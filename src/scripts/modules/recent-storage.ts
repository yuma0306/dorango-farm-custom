export const RECENT_STORAGE_KEY = 'dorango_recent_posts';

type RecentLimits = {
	history: number;
	single: number;
};

declare global {
	interface Window {
		dorangoRecentLimits?: RecentLimits;
	}
}

const FALLBACK_LIMITS: RecentLimits = {
	history: 10,
	single: 4,
};

function recentLimits(): RecentLimits {
	const fromWindow = window.dorangoRecentLimits;
	if (
		fromWindow &&
		Number.isInteger(fromWindow.history) &&
		fromWindow.history > 0 &&
		Number.isInteger(fromWindow.single) &&
		fromWindow.single > 0
	) {
		return fromWindow;
	}
	return FALLBACK_LIMITS;
}

export function getRecentHistoryLimit(): number {
	return recentLimits().history;
}

export function getRecentSingleSectionLimit(): number {
	return recentLimits().single;
}

export function getRecentIds(limit?: number): number[] {
	const max = limit ?? getRecentHistoryLimit();
	try {
		const raw = localStorage.getItem(RECENT_STORAGE_KEY);
		if (!raw) {
			return [];
		}
		const parsed: unknown = JSON.parse(raw);
		if (!Array.isArray(parsed)) {
			return [];
		}
		const ids = parsed
			.map((value) => Number(value))
			.filter((value) => Number.isInteger(value) && value > 0);
		return Array.from(new Set(ids)).slice(0, max);
	} catch {
		return [];
	}
}

export function recordRecentPost(id: number): void {
	if (!Number.isInteger(id) || id <= 0) {
		return;
	}
	const historyLimit = getRecentHistoryLimit();
	const ids = getRecentIds(historyLimit).filter((storedId) => storedId !== id);
	ids.unshift(id);
	try {
		localStorage.setItem(RECENT_STORAGE_KEY, JSON.stringify(ids.slice(0, historyLimit)));
	} catch {
		return;
	}
}
