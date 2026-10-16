import type { Page } from 'playwright';
import type { DomCheckResult, SaleMonitorResult } from './types.ts';

export const DEFAULT_ASIN = 'B08KQTJ8CN'; // ヒーティングトップ M

const SALE_BADGE_SELECTORS = [
	'#dealBadge_feature_div',
	'#dealBadgeSupportingText',
	'.dealBadge',
	'.dealBadgeTextColor',
	'[data-testid="deal-badge"]',
	'#apex_desktop .a-badge-label',
	'#corePriceDisplay_desktop_feature_div .a-badge-label',
];

const SALE_KEYWORD_REGEX =
	/(タイムセール|特選タイムセール|期間限定セール|スマイルSALE|プライムデー|プライム感謝祭|ブラックフライデー|新生活SALE|ビッグセール|セール価格|Limited time deal)/i;

export function buildAmazonProductUrl(asin: string): string {
	return `https://www.amazon.co.jp/dp/${encodeURIComponent(asin.trim())}`;
}

export function formatJstIsoTimestamp(date: Date = new Date()): string {
	const jstOffsetMs = 9 * 60 * 60 * 1000;
	const jstDate = new Date(date.getTime() + jstOffsetMs);
	const iso = jstDate.toISOString().replace(/\.\d{3}Z$/, '');
	return `${iso}+09:00`;
}

/**
 * 公開テストページ（example.com）でPlaywright + ChromiumのDOM取得を検証する
 */
export async function verifyPublicTestPageDom(
	page: Page,
	url = 'https://example.com',
): Promise<DomCheckResult> {
	await page.goto(url, { waitUntil: 'domcontentloaded', timeout: 30_000 });
	const title = await page.title();
	const heading = await extractText(page, 'h1');
	return {
		url,
		title,
		heading,
		ok: title.length > 0 && heading !== null,
	};
}

/**
 * 現在のPageに読み込まれているAmazon商品DOMから商品情報・セール情報を解析する
 */
export async function parseAmazonProductDom(
	page: Page,
	asin: string,
	checkedAt: string = formatJstIsoTimestamp(),
	httpStatus: number | null = 200,
): Promise<SaleMonitorResult> {
	if (httpStatus !== null && (httpStatus === 403 || httpStatus === 429 || httpStatus === 503)) {
		return createErrorResult(
			asin,
			checkedAt,
			'access_denied',
			`HTTP ${httpStatus} によりアクセスが制限されました`,
		);
	}

	const isBlocked = await detectAccessRestriction(page);
	if (isBlocked) {
		return createErrorResult(
			asin,
			checkedAt,
			'access_denied',
			'CAPTCHAまたはボット対策ページが表示されました',
		);
	}

	const name = await extractText(page, '#productTitle, #title');
	if (!name) {
		return createErrorResult(
			asin,
			checkedAt,
			'unknown',
			'商品名（#productTitle）を取得できませんでした',
		);
	}

	const currentPriceText = await extractFirstText(page, [
		'#corePriceDisplay_desktop_feature_div .priceToPay .a-offscreen',
		'#corePriceDisplay_desktop_feature_div .apexPriceToPay .a-offscreen',
		'#corePriceDisplay_desktop_feature_div .priceToPay',
		'#corePrice_feature_div .a-price .a-offscreen',
		'#priceblock_dealprice',
		'#priceblock_ourprice',
	]);
	const currentPrice = parseYenPrice(currentPriceText);

	const basisPriceText = await extractFirstText(page, [
		'#corePriceDisplay_desktop_feature_div .basisPrice .a-offscreen',
		'#corePriceDisplay_desktop_feature_div .a-text-price[data-a-strike="true"] .a-offscreen',
		'#corePriceDisplay_desktop_feature_div .basisPrice .a-text-price',
	]);
	const basisPrice = parseYenPrice(basisPriceText);

	const discountText = await extractFirstText(page, [
		'#corePriceDisplay_desktop_feature_div .savingsPercentage',
		'#corePriceDisplay_desktop_feature_div .reinventPriceSavingsPercentageMargin',
	]);
	const explicitDiscountPercent = parseDiscountPercent(discountText);

	const badgeText = await extractSaleBadgeText(page);
	const saleEndsAt = await extractSaleEndsAt(page);

	if (currentPrice === null) {
		return {
			asin,
			name,
			is_on_sale: null,
			original_price: basisPrice,
			sale_price: null,
			discount_percent: null,
			sale_ends_at: null,
			checked_at: checkedAt,
			status: 'unknown',
			sale_state: 'unknown',
			reason: '現在価格がDOM上に存在しないためセール判定不能（在庫切れ・出品者のみ等の可能性）',
		};
	}

	// セール判定：参考価格との差額だけではセール中と判定せず、明示的なセールバッジ根拠がある場合のみ true
	const hasSaleBadge = badgeText !== null && SALE_KEYWORD_REGEX.test(badgeText);

	if (hasSaleBadge) {
		const originalPrice = basisPrice !== null && basisPrice > currentPrice ? basisPrice : null;
		const calculatedDiscount =
			originalPrice !== null
				? Math.round(((originalPrice - currentPrice) / originalPrice) * 100)
				: null;

		return {
			asin,
			name,
			is_on_sale: true,
			original_price: originalPrice,
			sale_price: currentPrice,
			discount_percent: explicitDiscountPercent ?? calculatedDiscount,
			sale_ends_at: saleEndsAt,
			checked_at: checkedAt,
			status: 'success',
			sale_state: 'on_sale',
			reason: `セールバッジを確認 (${badgeText})`,
		};
	}

	const notOnSaleReason =
		basisPrice !== null && basisPrice > currentPrice
			? '参考価格・過去価格からの差額表示はあるが、セールバッジ等の明示的なセール根拠がないためセール対象外'
			: 'セールバッジなし（通常販売）';

	return {
		asin,
		name,
		is_on_sale: false,
		original_price: currentPrice,
		sale_price: null,
		discount_percent: null,
		sale_ends_at: null,
		checked_at: checkedAt,
		status: 'success',
		sale_state: 'not_on_sale',
		reason: notOnSaleReason,
	};
}

/**
 * Amazon.co.jpの商品URLへアクセスして商品情報を取得する
 */
export async function fetchAmazonProduct(page: Page, asin: string): Promise<SaleMonitorResult> {
	const checkedAt = formatJstIsoTimestamp();
	const url = buildAmazonProductUrl(asin);

	try {
		const response = await page.goto(url, {
			waitUntil: 'domcontentloaded',
			timeout: 30_000,
		});
		const status = response ? response.status() : null;
		return await parseAmazonProductDom(page, asin, checkedAt, status);
	} catch (error) {
		const message = error instanceof Error ? error.message : String(error);
		return createErrorResult(asin, checkedAt, 'fetch_error', message);
	}
}

async function detectAccessRestriction(page: Page): Promise<boolean> {
	const captchaSelector =
		'form[action*="/errors/validateCaptcha"], #captchacharacters, input[name="amzn-r"]';
	const captchaCount = await page.locator(captchaSelector).count();
	if (captchaCount > 0) {
		return true;
	}
	const title = await page.title();
	if (/Amazon CAPTCHA|Bot Check|ロボットでないことを確認/i.test(title)) {
		return true;
	}
	const bodyText = (await extractText(page, 'body')) ?? '';
	if (
		bodyText.includes('ロボットでないことを確認') ||
		bodyText.includes('Enter the characters you see below')
	) {
		return true;
	}
	return false;
}

async function extractSaleBadgeText(page: Page): Promise<string | null> {
	for (const selector of SALE_BADGE_SELECTORS) {
		const text = await extractText(page, selector);
		if (text && SALE_KEYWORD_REGEX.test(text)) {
			return text;
		}
	}
	return null;
}

async function extractSaleEndsAt(page: Page): Promise<string | null> {
	const isoAttr = await page
		.locator('[data-deal-expiry-iso]')
		.first()
		.getAttribute('data-deal-expiry-iso')
		.catch(() => null);
	if (isoAttr && isoAttr.trim().length > 0) {
		return isoAttr.trim();
	}

	const expiryText = await extractFirstText(page, [
		'#dealExpiryTimer',
		'[id^="dealExpiryTimer"]',
		'[data-testid="deal-expiry-timer"]',
	]);
	if (!expiryText) {
		return null;
	}

	// 明示的な年月日・時刻（例: 2026/10/20 23:59）が含まれる場合のみISO形式で抽出し、曖昧な残り時間は推測しない
	const match = expiryText.match(/(\d{4})[/-](\d{1,2})[/-](\d{1,2})\s+(\d{1,2}):(\d{2})/);
	if (!match) {
		return null;
	}
	const [, year, month, day, hour, minute] = match;
	return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}T${hour.padStart(2, '0')}:${minute}:00+09:00`;
}

async function extractFirstText(page: Page, selectors: string[]): Promise<string | null> {
	for (const selector of selectors) {
		const text = await extractText(page, selector);
		if (text) {
			return text;
		}
	}
	return null;
}

async function extractText(page: Page, selector: string): Promise<string | null> {
	const locator = page.locator(selector).first();
	const count = await locator.count();
	if (count === 0) {
		return null;
	}
	const raw = await locator.textContent();
	const trimmed = raw?.replace(/\s+/g, ' ').trim() ?? '';
	return trimmed.length > 0 ? trimmed : null;
}

export function parseYenPrice(text: string | null): number | null {
	if (!text) {
		return null;
	}
	const match = text.replace(/[,，]/g, '').match(/(?:￥|¥)?\s*(\d+)/);
	if (!match) {
		return null;
	}
	const value = Number.parseInt(match[1], 10);
	return Number.isFinite(value) && value > 0 ? value : null;
}

export function parseDiscountPercent(text: string | null): number | null {
	if (!text) {
		return null;
	}
	const match = text.match(/-?\s*(\d+)\s*%/);
	if (!match) {
		return null;
	}
	const value = Number.parseInt(match[1], 10);
	return Number.isFinite(value) && value > 0 ? value : null;
}

export function createErrorResult(
	asin: string,
	checkedAt: string,
	state: 'unknown' | 'access_denied' | 'fetch_error',
	reason: string,
): SaleMonitorResult {
	return {
		asin,
		name: null,
		is_on_sale: null,
		original_price: null,
		sale_price: null,
		discount_percent: null,
		sale_ends_at: null,
		checked_at: checkedAt,
		status: state,
		sale_state: state,
		reason,
	};
}

/**
 * 保存済みHTML・モックデータ検証用のサンプルDOM（Amazon規約に配慮したオフライン解析テスト用）
 */
export const MOCK_PRODUCT_HTML = {
	on_sale: `<!DOCTYPE html>
<html lang="ja">
<head><title>Amazon.co.jp: ヒーティングトップ M</title></head>
<body>
	<span id="productTitle">EXO TERRA (エキゾテラ) ヒーティングトップ M</span>
	<div id="dealBadge_feature_div">
		<span class="dealBadgeTextColor">タイムセール</span>
	</div>
	<div id="corePriceDisplay_desktop_feature_div">
		<span class="savingsPercentage">-15%</span>
		<span class="priceToPay"><span class="a-offscreen">￥3,647</span></span>
		<span class="basisPrice"><span class="a-offscreen">￥4,291</span></span>
	</div>
</body>
</html>`,
	reference_discount_only: `<!DOCTYPE html>
<html lang="ja">
<head><title>Amazon.co.jp: ヒーティングトップ M</title></head>
<body>
	<span id="productTitle">EXO TERRA (エキゾテラ) ヒーティングトップ M</span>
	<div id="corePriceDisplay_desktop_feature_div">
		<span class="savingsPercentage">-15%</span>
		<span class="priceToPay"><span class="a-offscreen">￥3,647</span></span>
		<span class="basisPrice">参考価格: <span class="a-offscreen">￥4,291</span></span>
	</div>
</body>
</html>`,
	access_denied: `<!DOCTYPE html>
<html lang="ja">
<head><title>Amazon CAPTCHA</title></head>
<body>
	<form action="/errors/validateCaptcha">
		<p>ロボットでないことを確認してください</p>
		<input id="captchacharacters" type="text" />
	</form>
</body>
</html>`,
} as const;
