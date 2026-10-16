import { mkdir, writeFile } from 'node:fs/promises';
import { dirname, resolve } from 'node:path';
import { chromium, type Page } from 'playwright';

const TARGET_URL =
	'https://www.amazon.co.jp/%E3%83%92%E3%83%BC%E3%83%86%E3%82%A3%E3%83%B3%E3%82%B0%E3%83%88%E3%83%83%E3%83%97-%E7%88%AC%E8%99%AB%E9%A1%9E%E3%83%BB%E4%B8%A1%E7%94%9F%E9%A1%9E%E9%A3%BC%E8%82%B2-%E3%82%B1%E3%83%BC%E3%82%B8%E4%B8%8A%E9%83%A8%E8%A8%AD%E7%BD%AE%E5%9E%8B%E3%83%92%E3%83%BC%E3%82%BF%E3%83%BC-%E7%BD%AE%E3%81%8F%E3%81%A0%E3%81%91%E7%B0%A1%E5%8D%98%E8%A8%AD%E7%BD%AE-W25-6%C3%97D16%C3%97H2-8cm/dp/B0DZCV9TYG';

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

async function run(): Promise<void> {
	const outputPath = resolve(process.cwd(), 'tmp/sale-monitor/result.json');
	const browser = await chromium.launch({ headless: true });

	try {
		const page = await browser.newPage({
			locale: 'ja-JP',
			timezoneId: 'Asia/Tokyo',
			userAgent:
				'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
		});

		await page.goto(TARGET_URL, { waitUntil: 'domcontentloaded', timeout: 30_000 });

		// 「ショッピングを続ける」が出た場合だけクリックして商品ページへ進む
		const continueBtn = page
			.locator('button:has-text("ショッピングを続ける"), input[value*="ショッピングを続ける"]')
			.first();
		if ((await continueBtn.count()) > 0) {
			await Promise.all([
				page.waitForNavigation({ waitUntil: 'domcontentloaded' }).catch(() => null),
				continueBtn.click(),
			]);
		}

		const name = await getText(page, '#productTitle');
		const priceText = await getText(
			page,
			'#corePriceDisplay_desktop_feature_div .priceToPay .a-offscreen, #corePrice_feature_div .a-price .a-offscreen',
		);
		const basisPriceText = await getText(
			page,
			'#corePriceDisplay_desktop_feature_div .basisPrice .a-offscreen',
		);
		const discountText = await getText(
			page,
			'#corePriceDisplay_desktop_feature_div .savingsPercentage',
		);
		const dealBadge = await getText(
			page,
			'#dealBadge_feature_div, #dealBadgeSupportingText, .dealBadge',
		);

		const currentPrice = parsePrice(priceText);
		const basisPrice = parsePrice(basisPriceText);
		const discountPercent = parsePrice(discountText);
		const isOnSale = dealBadge !== null;

		const result = {
			asin: 'B0DZCV9TYG',
			name,
			is_on_sale: name ? isOnSale : null,
			original_price: isOnSale ? basisPrice : currentPrice,
			sale_price: isOnSale ? currentPrice : null,
			discount_percent: isOnSale ? discountPercent : null,
			deal_badge: dealBadge,
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
