import { mkdir, writeFile } from 'node:fs/promises';
import { dirname, resolve } from 'node:path';
import { chromium, type Page } from 'playwright';

const DEFAULT_ASIN = 'B08KQTJ8CN';

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
async function ensureJapanDeliveryLocation(page: Page): Promise<string | null> {
	const glowText = await getText(page, '#glow-ingress-block');
	if (
		glowText &&
		(glowText.includes('100-') || glowText.includes('153-') || /〒|\d{3}-\d{4}/.test(glowText))
	) {
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
		await page.reload({ waitUntil: 'domcontentloaded', timeout: 30_000 });
	} catch {
		// ポップオーバー操作に失敗した場合はそのまま続行
	}

	return await getText(page, '#glow-ingress-block');
}

async function run(): Promise<void> {
	const asin = process.env.ASIN?.trim() || DEFAULT_ASIN;
	const url = `https://www.amazon.co.jp/dp/${encodeURIComponent(asin)}?th=1&psc=1`;
	const outputPath = resolve(process.cwd(), 'tmp/sale-monitor/result.json');
	const isHeaded = process.argv.includes('--ui') || process.env.HEADLESS === 'false';

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
		const page = await context.newPage();

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

		// 海外IPからのアクセス時に配送先を日本に設定してリロード
		const deliveryLocation = await ensureJapanDeliveryLocation(page);

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

		// セールバッジ（余計なstyleタグやタイマー文字列が入らないようラベル要素を優先取得）
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

		const result = {
			asin,
			name,
			seller,
			is_on_sale: name ? isOnSale : null,
			original_price: isOnSale ? basisPrice : currentPrice,
			sale_price: isOnSale ? currentPrice : null,
			discount_percent: isOnSale ? discountPercent : null,
			deal_badge: dealBadge,
			delivery_location: deliveryLocation,
			checked_at: new Date().toISOString(),
			page_title: await page.title(),
		};

		await mkdir(dirname(outputPath), { recursive: true });
		await writeFile(outputPath, `${JSON.stringify(result, null, 2)}\n`, 'utf-8');
		console.log(JSON.stringify(result, null, 2));
	} finally {
		await browser.close();
	}
}

run();
