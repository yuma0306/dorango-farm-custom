import { hideElement, showElement } from './element-display';
import { showToast } from './toast';

const STORAGE_KEY = 'dorango_favorite_setups';

type FavoriteSetups = Record<string, string>;

export function getFavoriteSetups(): FavoriteSetups {
	try {
		const raw = localStorage.getItem(STORAGE_KEY);
		if (!raw) {
			return {};
		}
		const parsed: unknown = JSON.parse(raw);
		if (!parsed || typeof parsed !== 'object' || Array.isArray(parsed)) {
			return {};
		}
		const result: FavoriteSetups = {};
		for (const [key, value] of Object.entries(parsed)) {
			if (typeof value === 'string' && value !== '') {
				result[key] = value;
			}
		}
		return result;
	} catch {
		return {};
	}
}

export function getFavoriteSetup(setupKey: string): string | null {
	const setups = getFavoriteSetups();
	return setups[setupKey] ?? null;
}

function saveFavoriteSetups(setups: FavoriteSetups): void {
	try {
		localStorage.setItem(STORAGE_KEY, JSON.stringify(setups));
	} catch {
		return;
	}
}

export function toggleFavoriteSetup(setupKey: string, outcomeId: string): boolean {
	const setups = getFavoriteSetups();
	const isSame = setups[setupKey] === outcomeId;
	if (isSame) {
		delete setups[setupKey];
		saveFavoriteSetups(setups);
		return false;
	}
	setups[setupKey] = outcomeId;
	saveFavoriteSetups(setups);
	return true;
}

export function removeFavoriteSetup(setupKey: string): void {
	const setups = getFavoriteSetups();
	delete setups[setupKey];
	saveFavoriteSetups(setups);
}

export function syncShindanFavoriteButton(btn: HTMLButtonElement | null, outcomeId: string): void {
	if (!btn) {
		return;
	}
	const setupKey = btn.dataset.setupKey || 'ballpython-setup';
	btn.dataset.outcomeId = outcomeId;
	const active = getFavoriteSetup(setupKey) === outcomeId;
	paintShindanFavoriteButton(btn, active);
}

function paintShindanFavoriteButton(btn: HTMLButtonElement, active: boolean): void {
	btn.setAttribute('aria-pressed', active ? 'true' : 'false');
	btn.textContent = active ? 'お気に入り飼育セットを解除' : 'お気に入り飼育セットに登録';
}

function initShindanFavoriteTrigger(): void {
	const buttons = document.querySelectorAll<HTMLButtonElement>('[data-js-shindan-favorite-btn]');
	for (const btn of buttons) {
		btn.addEventListener('click', () => {
			const setupKey = btn.dataset.setupKey || 'ballpython-setup';
			const outcomeId = btn.dataset.outcomeId;
			if (!outcomeId) {
				return;
			}
			const active = toggleFavoriteSetup(setupKey, outcomeId);
			paintShindanFavoriteButton(btn, active);
			if (active) {
				showToast(
					'「<a href="/favorite-setup/ballpython-setup/">お気に入り飼育セット</a>」に登録しました。',
					{ html: true },
				);
			} else {
				showToast('お気に入り飼育セットを解除しました');
			}
		});
	}
}

function initFavoriteSetupIndexPage(): void {
	const root = document.querySelector<HTMLElement>('[data-js-favorite-setup-index]');
	if (!root) {
		return;
	}
	const list = root.querySelector<HTMLElement>('[data-js-favorite-setup-index-list]');
	const empty = root.querySelector<HTMLElement>('[data-js-favorite-setup-index-empty]');
	const items = root.querySelectorAll<HTMLElement>('[data-js-favorite-setup-index-item]');
	if (!list || !empty) {
		return;
	}
	const setups = getFavoriteSetups();
	let visibleCount = 0;
	for (const item of items) {
		const key = item.dataset.jsFavoriteSetupIndexItem;
		if (key && setups[key]) {
			showElement(item);
			visibleCount++;
		} else {
			hideElement(item);
		}
	}
	if (visibleCount > 0) {
		showElement(list);
		hideElement(empty);
	} else {
		hideElement(list);
		showElement(empty);
	}
}

function initFavoriteSetupDetailPage(): void {
	const root = document.querySelector<HTMLElement>('[data-js-favorite-setup-detail]');
	if (!root) {
		return;
	}
	const setupKey = root.dataset.jsFavoriteSetupDetail || 'ballpython-setup';
	const content = root.querySelector<HTMLElement>('[data-js-favorite-setup-detail-content]');
	const empty = root.querySelector<HTMLElement>('[data-js-favorite-setup-detail-empty]');
	const outcomes = root.querySelectorAll<HTMLElement>('[data-js-favorite-setup-outcome]');
	const removeBtn = root.querySelector<HTMLButtonElement>('[data-js-favorite-setup-remove]');
	if (!content || !empty) {
		return;
	}

	const render = (): void => {
		const savedOutcomeId = getFavoriteSetup(setupKey);
		let matched = false;
		for (const panel of outcomes) {
			if (savedOutcomeId && panel.dataset.jsFavoriteSetupOutcome === savedOutcomeId) {
				showElement(panel);
				matched = true;
			} else {
				hideElement(panel);
			}
		}
		if (matched) {
			showElement(content);
			hideElement(empty);
		} else {
			hideElement(content);
			showElement(empty);
		}
	};

	render();

	removeBtn?.addEventListener('click', () => {
		removeFavoriteSetup(setupKey);
		showToast('お気に入り飼育セットを解除しました');
		render();
	});
}

export function initFavoriteSetups(): void {
	initShindanFavoriteTrigger();
	initFavoriteSetupIndexPage();
	initFavoriteSetupDetailPage();
}
