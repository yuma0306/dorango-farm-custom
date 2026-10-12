import { hideElement, showElement } from './element-display';
import { fetchPostListItems, renderPostListCard } from './post-cards';
import { showToast } from './toast';

const STORAGE_KEY = 'dorango_favorites';
const MAX_IDS = 30;

export function getFavoriteIds(): number[] {
	try {
		const raw = localStorage.getItem(STORAGE_KEY);
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
		return Array.from(new Set(ids)).slice(0, MAX_IDS);
	} catch {
		return [];
	}
}

function saveFavoriteIds(ids: number[]): void {
	try {
		localStorage.setItem(STORAGE_KEY, JSON.stringify(ids));
	} catch {
		return;
	}
}

function notifyFavoriteChange(): void {
	document.dispatchEvent(new CustomEvent('dorango:favorite-change'));
}

export function toggleFavorite(id: number): boolean {
	const ids = getFavoriteIds();
	const index = ids.indexOf(id);
	if (index === -1) {
		ids.unshift(id);
	} else {
		ids.splice(index, 1);
	}
	saveFavoriteIds(ids.slice(0, MAX_IDS));
	notifyFavoriteChange();
	return index === -1;
}

function paintFavoriteButton(btn: HTMLButtonElement, active: boolean): void {
	if (active) {
		btn.setAttribute('data-js-favorite-active', '');
	} else {
		btn.removeAttribute('data-js-favorite-active');
	}
	btn.setAttribute('aria-pressed', active ? 'true' : 'false');
	btn.setAttribute('aria-label', active ? 'お気に入りから外す' : 'お気に入りに追加');
}

function syncFavoriteButtons(id: number, active: boolean): void {
	document
		.querySelectorAll<HTMLButtonElement>(`[data-js-favorite-btn][data-post-id="${id}"]`)
		.forEach((btn) => {
			paintFavoriteButton(btn, active);
		});
}

export function initFavoriteButtons(scope: ParentNode = document): void {
	const buttons = scope.querySelectorAll<HTMLButtonElement>('[data-js-favorite-btn]');
	buttons.forEach((btn) => {
		const id = Number(btn.dataset.postId);
		if (!Number.isInteger(id) || id <= 0) {
			return;
		}
		paintFavoriteButton(btn, getFavoriteIds().includes(id));
		btn.addEventListener('click', (e) => {
			e.preventDefault();
			const active = toggleFavorite(id);
			syncFavoriteButtons(id, active);
			if (active) {
				showToast(
					'メニューの「<a href="/favorite/">お気に入り記事</a>」からお気に入りした作品が確認できます。',
					{ html: true },
				);
			} else {
				showToast('お気に入りを外しました');
			}
		});
	});
}

export function initFavoritePage(): void {
	const page = document.querySelector<HTMLElement>('[data-js-favorite-page]');
	if (!page) {
		return;
	}
	const template = page.querySelector<HTMLTemplateElement>('[data-js-favorite-template]');
	const thumbTemplate = page.querySelector<HTMLTemplateElement>(
		'[data-js-favorite-thumb-template]',
	);
	const loading = page.querySelector<HTMLElement>('[data-js-loading]');
	const list = page.querySelector<HTMLElement>('[data-js-favorite-list]');
	const empty = page.querySelector<HTMLElement>('[data-js-favorite-empty]');
	if (!template || !loading || !list || !empty) {
		return;
	}
	const render = async () => {
		const ids = getFavoriteIds();
		list.replaceChildren();
		if (ids.length === 0) {
			showElement(empty);
			return;
		}
		hideElement(empty);
		showElement(loading);
		try {
			const items = await fetchPostListItems(ids);
			list.replaceChildren();
			if (items.length === 0) {
				showElement(empty);
				return;
			}
			items.forEach((item) => {
				list.append(renderPostListCard(template, thumbTemplate, item));
			});
		} catch {
			list.replaceChildren();
			const error = document.createElement('p');
			error.textContent = '一覧の取得に失敗しました。時間をおいて再度お試しください。';
			list.append(error);
		} finally {
			hideElement(loading);
		}
	};
	void render();
	document.addEventListener('dorango:favorite-change', () => {
		void render();
	});
}

export function initFavorites(): void {
	initFavoriteButtons();
	initFavoritePage();
}
