export type MonitorStatus = 'success' | 'unknown' | 'access_denied' | 'fetch_error';

export type SaleState =
	| 'on_sale' // セール中
	| 'not_on_sale' // セール対象外
	| 'unknown' // 判定不能
	| 'access_denied' // アクセス制限
	| 'fetch_error'; // 取得失敗

export interface SaleMonitorResult {
	asin: string;
	name: string | null;
	is_on_sale: boolean | null;
	original_price: number | null;
	sale_price: number | null;
	discount_percent: number | null;
	sale_ends_at: string | null;
	checked_at: string;
	status: MonitorStatus;
	sale_state?: SaleState;
	reason?: string;
}

export interface DomCheckResult {
	url: string;
	title: string;
	heading: string | null;
	ok: boolean;
}
