import { mkdir, readFile, writeFile } from 'node:fs/promises';
import { dirname, resolve } from 'node:path';
import { chromium } from 'playwright';
import {
	createErrorResult,
	DEFAULT_ASIN,
	fetchAmazonProduct,
	formatJstIsoTimestamp,
	MOCK_PRODUCT_HTML,
	parseAmazonProductDom,
	verifyPublicTestPageDom,
} from './amazon.ts';
import type { SaleMonitorResult } from './types.ts';

interface CliOptions {
	asin: string;
	mode: 'live' | 'mock-sale' | 'mock-regular' | 'mock-blocked' | 'html';
	htmlPath: string | null;
	outputPath: string;
	skipTestPage: boolean;
}

function parseMode(val: string | undefined): CliOptions['mode'] {
	if (
		val === 'live' ||
		val === 'mock-sale' ||
		val === 'mock-regular' ||
		val === 'mock-blocked' ||
		val === 'html'
	) {
		return val;
	}
	return 'live';
}

function parseCliOptions(argv: string[]): CliOptions {
	let asin = process.env.ASIN?.trim() || DEFAULT_ASIN;
	let mode: CliOptions['mode'] = parseMode(process.env.SALE_MONITOR_MODE?.trim());
	let htmlPath: string | null = process.env.SALE_MONITOR_HTML_PATH?.trim() || null;
	let outputPath =
		process.env.SALE_MONITOR_OUTPUT?.trim() ||
		resolve(process.cwd(), 'tmp/sale-monitor/result.json');
	let skipTestPage = false;

	for (let i = 0; i < argv.length; i++) {
		const arg = argv[i];
		if (arg === '--asin' && argv[i + 1]) {
			asin = argv[++i].trim();
		} else if (arg.startsWith('--asin=')) {
			asin = arg.slice('--asin='.length).trim();
		} else if (arg === '--mode' && argv[i + 1]) {
			const val = argv[++i].trim();
			if (
				val === 'live' ||
				val === 'mock-sale' ||
				val === 'mock-regular' ||
				val === 'mock-blocked' ||
				val === 'html'
			) {
				mode = val;
			}
		} else if (arg.startsWith('--mode=')) {
			const val = arg.slice('--mode='.length).trim();
			if (
				val === 'live' ||
				val === 'mock-sale' ||
				val === 'mock-regular' ||
				val === 'mock-blocked' ||
				val === 'html'
			) {
				mode = val;
			}
		} else if (arg === '--html' && argv[i + 1]) {
			htmlPath = argv[++i].trim();
			mode = 'html';
		} else if (arg === '--output' && argv[i + 1]) {
			outputPath = resolve(process.cwd(), argv[++i].trim());
		} else if (arg === '--skip-test-page') {
			skipTestPage = true;
		} else if (!arg.startsWith('--') && /^[A-Z0-9]{10}$/i.test(arg)) {
			asin = arg.toUpperCase();
		}
	}

	return { asin, mode, htmlPath, outputPath, skipTestPage };
}

async function saveResultJson(outputPath: string, result: SaleMonitorResult): Promise<void> {
	await mkdir(dirname(outputPath), { recursive: true });
	await writeFile(outputPath, `${JSON.stringify(result, null, 2)}\n`, 'utf-8');
}

async function run(): Promise<void> {
	const options = parseCliOptions(process.argv.slice(2));
	const checkedAt = formatJstIsoTimestamp();
	let result: SaleMonitorResult;

	const browser = await chromium.launch({ headless: true });
	try {
		const context = await browser.newContext({
			locale: 'ja-JP',
			timezoneId: 'Asia/Tokyo',
			userAgent:
				'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36',
		});
		const page = await context.newPage();

		if (!options.skipTestPage) {
			const domCheck = await verifyPublicTestPageDom(page);
			console.log('[1/2] Test page DOM check:', JSON.stringify(domCheck));
			if (!domCheck.ok) {
				throw new Error(`Test page DOM check failed for ${domCheck.url}`);
			}
		}

		if (options.mode === 'mock-sale') {
			await page.setContent(MOCK_PRODUCT_HTML.on_sale, { waitUntil: 'domcontentloaded' });
			result = await parseAmazonProductDom(page, options.asin, checkedAt, 200);
		} else if (options.mode === 'mock-regular') {
			await page.setContent(MOCK_PRODUCT_HTML.reference_discount_only, {
				waitUntil: 'domcontentloaded',
			});
			result = await parseAmazonProductDom(page, options.asin, checkedAt, 200);
		} else if (options.mode === 'mock-blocked') {
			await page.setContent(MOCK_PRODUCT_HTML.access_denied, {
				waitUntil: 'domcontentloaded',
			});
			result = await parseAmazonProductDom(page, options.asin, checkedAt, 200);
		} else if (options.mode === 'html' && options.htmlPath) {
			const html = await readFile(resolve(process.cwd(), options.htmlPath), 'utf-8');
			await page.setContent(html, { waitUntil: 'domcontentloaded' });
			result = await parseAmazonProductDom(page, options.asin, checkedAt, 200);
		} else {
			result = await fetchAmazonProduct(page, options.asin);
		}
	} catch (error) {
		const message = error instanceof Error ? error.message : String(error);
		result = createErrorResult(options.asin, checkedAt, 'fetch_error', message);
	} finally {
		await browser.close();
	}

	await saveResultJson(options.outputPath, result);
	console.log('[2/2] Sale Monitor Result:');
	console.log(JSON.stringify(result, null, 2));
	console.log(`Saved JSON to: ${options.outputPath}`);
}

run().catch((error) => {
	console.error('Fatal error in sale-monitor:', error);
	process.exitCode = 1;
});
