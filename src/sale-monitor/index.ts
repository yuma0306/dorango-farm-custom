import { existsSync, readFileSync } from 'node:fs';
import { mkdir, writeFile } from 'node:fs/promises';
import { dirname, resolve } from 'node:path';
import { chromium, type Page } from 'playwright';

const DEFAULT_ASIN = 'B08KQTJ8CN';

interface WpPetProduct {
	id: number;
	title?: { rendered?: string };
	acf?: {
		asin?: string;
		is_on_sale?: boolean;
		original_price?: number | string | null;
		sale_price?: number | string | null;
		discount_percent?: number | string | null;
		first_sale_detected_at?: string | null;
		sale_ends_at?: string | null;
		last_checked_at?: string | null;
	};
}

interface ScrapedProduct {
	asin: string;
	name: string | null;
	seller: string | null;
	is_on_sale: boolean | null;
	original_price: number | null;
	sale_price: number | null;
	discount_percent: number | null;
	deal_badge: string | null;
	delivery_location: string | null;
	checked_at: string;
	page_title: string;
	wp_post_id?: number;
	wp_updated?: boolean;
}

/**
 * ローカル実行時に .env があれば読み込む
 */
function loadDotEnv(): void {
	const envPath = resolve(process.cwd(), '.env');
	if (!existsSync(envPath)) return;

	const content = readFileSync(envPath, 'utf-8');
	for (const line of content.split(/\r?\n/)) {
		const trimmed = line.trim();
		if (!trimmed || trimmed.startsWith('#')) continue;
		const eqIndex = trimmed.indexOf('=');
		if (eqIndex === -1) continue;
		const key = trimmed.slice(0, eqIndex).trim();
		const val = trimmed
			.slice(eqIndex + 1)
			.trim()
			.replace(/^['"]|['"]$/g, '');
		if (!process.env[key]) {
			process.env[key] = val;
		}
	}
}

function getWpConfig(): { baseUrl: string; authHeader: string } | null {
	const rawUrl = (process.env.WP_URL || process.env.WP_SITE_URL || '').trim();
	const username = (process.env.WP_USERNAME || '').trim();
	const appPassword = (
		process.env.WP_APPLICATION_PASSWORD ||
		process.env.WP_APP_PASSWORD ||
		''
	).trim();

	if (!rawUrl || !username || !appPassword) {
		return null;
	}

	const baseUrl = rawUrl.replace(/\/+$/, '');
	const token = Buffer.from(`${username}:${appPassword}`).toString('base64');
	return {
		baseUrl,
		authHeader: `Basic ${token}`,
	};
}

function isRecord(value: unknown): value is Record<string, unknown> {
	return typeof value === 'object' && value !== null;
}

function parseWpProducts(data: unknown): WpPetProduct[] {
	if (!Array.isArray(data)) return [];
	const items: WpPetProduct[] = [];

	for (const raw of data) {
		if (!isRecord(raw) || typeof raw.id !== 'number') continue;
		const acfRaw = isRecord(raw.acf) ? raw.acf : undefined;
		items.push({
			id: raw.id,
			acf: acfRaw
				? {
						asin: typeof acfRaw.asin === 'string' ? acfRaw.asin : undefined,
						is_on_sale: Boolean(acfRaw.is_on_sale),
						first_sale_detected_at:
							typeof acfRaw.first_sale_detected_at === 'string'
								? acfRaw.first_sale_detected_at
								: null,
					}
				: undefined,
		});
	}

	return items;
}

async function fetchWpProducts(wp: {
	baseUrl: string;
	authHeader: string;
}): Promise<WpPetProduct[]> {
	const endpoint = `${wp.baseUrl}/wp-json/wp/v2/pet_product?per_page=100&status=publish`;
	const res = await fetch(endpoint, {
		headers: {
			Authorization: wp.authHeader,
			Accept: 'application/json',
		},
	});

	if (!res.ok) {
		const body = await res.text();
		throw new Error(`WP REST API GET error (${res.status}): ${body}`);
	}

	const json: unknown = await res.json();
	return parseWpProducts(json);
}

async function updateWpProductAcf(
	wp: { baseUrl: string; authHeader: string },
	product: WpPetProduct,
	scraped: ScrapedProduct,
): Promise<boolean> {
	// Amazonから商品名・価格がどちらも取れなかった場合は誤上書きを防ぐためスキップ
	if (scraped.name === null || scraped.is_on_sale === null) {
		return false;
	}

	const prevFirstDetected = product.acf?.first_sale_detected_at?.trim() || '';
	const firstSaleDetectedAt = scraped.is_on_sale
		? prevFirstDetected !== ''
			? prevFirstDetected
			: scraped.checked_at
		: '';

	const acfPayload = {
		is_on_sale: scraped.is_on_sale,
		original_price: scraped.original_price ?? '',
		sale_price: scraped.is_on_sale ? (scraped.sale_price ?? '') : '',
		discount_percent: scraped.is_on_sale ? (scraped.discount_percent ?? '') : '',
		first_sale_detected_at: firstSaleDetectedAt,
		sale_ends_at: '',
		last_checked_at: scraped.checked_at,
	};

	const endpoint = `${wp.baseUrl}/wp-json/wp/v2/pet_product/${product.id}`;
	const res = await fetch(endpoint, {
		method: 'POST',
		headers: {
			Authorization: wp.authHeader,
			'Content-Type': 'application/json',
			Accept: 'application/json',
		},
		body: JSON.stringify({ acf: acfPayload }),
	});

	if (!res.ok) {
		const body = await res.text();
		throw new Error(`WP REST API POST error for ID ${product.id} (${res.status}): ${body}`);
	}

	return true;
}

async function getText(page: Page, selector: string): Promise<string | null> {
	const locator = page.locator(selector).first();
	if ((await locator.count()) === 0) return null;
	const raw = await locator.textContent();
	const trimmed = raw?.replace(/\s+/g, ' ').trim() ?? '';
	return trimmed.length > 0 ? trimmed : null;
}

function parsePrice(text: string | null): number | null {
	if (!text) return null;
	const match = text.replace(/[,，]/g, '').match(/(\d+)/);
	return match ? Number.parseInt(match[1], 10) : null;
}

/**
 * 海外IP（GitHub Actionsや海外滞在時）からアクセスした際、
 * Amazonの配送先を日本（100-0001）に切り替えて日本国内向けの価格UIを表示させる
 */
async function ensureJapanDeliveryLocation(page: Page, productUrl: string): Promise<string | null> {
	const glowText = await getText(page, '#glow-ingress-block');
	if (
		glowText &&
		(glowText.includes('100-') || glowText.includes('153-') || /〒|\d{3}-\d{4}/.test(glowText))
	) {
		if (!page.url().includes('/dp/')) {
			await page.goto(productUrl, { waitUntil: 'domcontentloaded', timeout: 30_000 });
		}
		return glowText;
	}

	const trigger = page.locator('#nav-global-location-popover-link').first();
	if ((await trigger.count()) === 0) {
		return glowText;
	}

	try {
		await trigger.click({ timeout: 5000 });
		const zipInput = page.locator('#GLUXZipUpdateInput_0, #GLUXZipUpdateInput').first();
		await zipInput.waitFor({ state: 'visible', timeout: 5000 });

		const zipInput2 = page.locator('#GLUXZipUpdateInput_1');
		if ((await zipInput2.count()) > 0 && (await zipInput2.isVisible())) {
			await zipInput.fill('100');
			await zipInput2.fill('0001');
		} else {
			await zipInput.fill('100-0001');
		}

		await page.locator('#GLUXZipUpdate input[type="submit"], #GLUXZipUpdate').first().click();
		await page.waitForTimeout(1500);
		await page.goto(productUrl, { waitUntil: 'domcontentloaded', timeout: 30_000 });
	} catch {
		if (!page.url().includes('/dp/')) {
			await page.goto(productUrl, { waitUntil: 'domcontentloaded', timeout: 30_000 });
		}
	}

	return await getText(page, '#glow-ingress-block');
}

async function scrapeAmazonByAsin(page: Page, asin: string): Promise<ScrapedProduct> {
	const url = `https://www.amazon.co.jp/dp/${encodeURIComponent(asin)}?th=1&psc=1&language=ja_JP&currency=JPY`;

	await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 30_000 });

	// 「ショッピングを続ける」が出た場合はクリックして商品ページへ進む
	const continueBtn = page
		.locator(
			'button:has-text("ショッピングを続ける"), input[value*="ショッピングを続ける"], a:has-text("ショッピングを続ける")',
		)
		.first();
	if ((await continueBtn.count()) > 0) {
		await Promise.all([
			page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => null),
			continueBtn.click(),
		]);
	}

	// 海外IPからのアクセス時に配送先を日本に設定して商品ページを開き直す
	const deliveryLocation = await ensureJapanDeliveryLocation(page, url);

	const name = await getText(page, '#productTitle');

	// 現在の販売価格（セール時はセール価格）
	const priceText = await getText(
		page,
		[
			'#corePriceDisplay_desktop_feature_div .priceToPay',
			'#corePrice_feature_div .a-price',
			'#apex_desktop .priceToPay',
		].join(', '),
	);

	// 過去価格・参考価格（打ち消し線の元値 ￥4,291 など）
	const basisPriceText = await getText(
		page,
		[
			'#corePriceDisplay_desktop_feature_div .basisPrice .a-text-price',
			'#corePriceDisplay_desktop_feature_div [data-a-strike="true"]',
			'#corePriceDisplay_desktop_feature_div .basisPrice',
		].join(', '),
	);

	const discountText = await getText(
		page,
		'#corePriceDisplay_desktop_feature_div .savingsPercentage',
	);

	// セールバッジ
	const dealBadge = await getText(
		page,
		'#dealBadgeSupportingText span, .dealBadgeTextColor, [data-testid="deal-badge"], #dealBadge_feature_div',
	);

	// 販売元・出荷元
	const seller = await getText(
		page,
		'#sellerProfileTriggerId, #merchantInfoFeature_feature_div .offer-display-feature-text-message',
	);

	const currentPrice = parsePrice(priceText);
	const basisPrice = parsePrice(basisPriceText);
	const discountPercent = parsePrice(discountText);
	const isOnSale = dealBadge !== null;

	return {
		asin,
		name,
		seller,
		is_on_sale: name && currentPrice !== null ? isOnSale : null,
		original_price: isOnSale ? basisPrice : currentPrice,
		sale_price: isOnSale ? currentPrice : null,
		discount_percent: isOnSale ? discountPercent : null,
		deal_badge: dealBadge,
		delivery_location: deliveryLocation,
		checked_at: new Date().toISOString(),
		page_title: await page.title(),
	};
}

async function run(): Promise<void> {
	loadDotEnv();

	const wpConfig = getWpConfig();
	const outputPath = resolve(process.cwd(), 'tmp/sale-monitor/result.json');
	const isHeaded = process.argv.includes('--ui') || process.env.HEADLESS === 'false';

	// WordPress連携がある場合は pet_product 一覧からASINを取得、ない場合は単発ASINで実行
	let wpProducts: WpPetProduct[] = [];
	if (wpConfig && !process.env.ASIN) {
		wpProducts = (await fetchWpProducts(wpConfig)).filter(
			(item) => typeof item.acf?.asin === 'string' && item.acf.asin.trim() !== '',
		);
	}

	const browser = await chromium.launch({
		headless: !isHeaded,
		slowMo: isHeaded ? 200 : 0,
	});

	try {
		const context = await browser.newContext({
			locale: 'ja-JP',
			timezoneId: 'Asia/Tokyo',
			extraHTTPHeaders: {
				'Accept-Language': 'ja-JP,ja;q=0.9',
			},
			userAgent:
				'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
		});
		await context.addCookies([
			{
				name: 'i18n-prefs',
				value: 'JPY',
				domain: '.amazon.co.jp',
				path: '/',
			},
			{
				name: 'lc-acbjp',
				value: 'ja_JP',
				domain: '.amazon.co.jp',
				path: '/',
			},
		]);
		const page = await context.newPage();

		const results: ScrapedProduct[] = [];

		if (wpConfig && wpProducts.length > 0) {
			for (let i = 0; i < wpProducts.length; i++) {
				const wpProduct = wpProducts[i];
				const asin = wpProduct.acf?.asin?.trim() || '';
				if (!asin) continue;

				if (i > 0) {
					await page.waitForTimeout(2500);
				}

				const scraped = await scrapeAmazonByAsin(page, asin);
				const updated = await updateWpProductAcf(wpConfig, wpProduct, scraped);
				results.push({
					...scraped,
					wp_post_id: wpProduct.id,
					wp_updated: updated,
				});
			}
		} else {
			const asin = process.env.ASIN?.trim() || DEFAULT_ASIN;
			const scraped = await scrapeAmazonByAsin(page, asin);
			results.push(scraped);
		}

		const outputData = results.length === 1 ? results[0] : results;
		await mkdir(dirname(outputPath), { recursive: true });
		await writeFile(outputPath, `${JSON.stringify(outputData, null, 2)}\n`, 'utf-8');
		console.log(JSON.stringify(outputData, null, 2));
	} finally {
		await browser.close();
	}
}

run();
