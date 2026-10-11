import { showToast } from './toast';

const STORAGE_KEY = 'dorango_favorites';
const MAX_IDS = 30;

type FavoriteItem = {
	id: number;
	title: string;
	url: string;
	thumb: { url: string; width: number; height: number; alt: string } | null;
	published: string;
	modified: string;
};

function isRecord(value: unknown): value is Record<string, unknown> {
	return typeof value === 'object' && value !== null;
}

function isFavoriteThumb(value: unknown): value is FavoriteItem['thumb'] & object {
	if (!isRecord(value)) {
		return false;
	}
	return (
		typeof value.url === 'string' &&
		typeof value.width === 'number' &&
		typeof value.height === 'number' &&
		typeof value.alt === 'string'
	);
}

function isFavoriteItem(value: unknown): value is FavoriteItem {
	if (!isRecord(value)) {
		return false;
	}
	const thumb = value.thumb;
	return (
		typeof value.id === 'number' &&
		typeof value.title === 'string' &&
		typeof value.url === 'string' &&
		(thumb === null || isFavoriteThumb(thumb)) &&
		typeof value.published === 'string' &&
		typeof value.modified === 'string'
	);
}

function parseFavoriteItems(data: unknown): FavoriteItem[] {
	if (!Array.isArray(data)) {
		return [];
	}
	return data.filter(isFavoriteItem);
}

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
	btn.setAttribute('aria-label', active ? 'お気に入りを解除しました' : 'お気に入りに追加');
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
			paintFavoriteButton(btn, active);
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

function renderFavoriteCard(
	template: HTMLTemplateElement,
	thumbTemplate: HTMLTemplateElement | null,
	item: FavoriteItem,
): DocumentFragment {
	const fragment = template.content.cloneNode(true) as DocumentFragment;
	const link = fragment.querySelector('[data-js-favorite-link]');
	if (link instanceof HTMLAnchorElement) {
		link.href = item.url;
	}
	const block = fragment.querySelector('[data-js-favorite-block]');
	if (item.thumb) {
		let img = fragment.querySelector('[data-js-favorite-img]');
		if (!(img instanceof HTMLImageElement) && thumbTemplate !== null) {
			fragment.querySelector('[data-js-favorite-thumb]')?.remove();
			const thumbFragment = thumbTemplate.content.cloneNode(true) as DocumentFragment;
			const picture = thumbFragment.querySelector('[data-js-favorite-thumb]');
			if (picture instanceof HTMLElement && block instanceof HTMLElement) {
				block.before(picture);
				img = fragment.querySelector('[data-js-favorite-img]');
			}
		}
		if (img instanceof HTMLImageElement) {
			img.src = item.thumb.url;
			img.alt = item.thumb.alt;
			img.width = item.thumb.width;
			img.height = item.thumb.height;
		}
	} else {
		fragment.querySelector('[data-js-favorite-thumb]')?.remove();
	}
	const published = fragment.querySelector('[data-js-favorite-published]');
	if (published instanceof HTMLTimeElement) {
		published.dateTime = item.published;
		published.textContent = item.published;
	}
	const modified = fragment.querySelector('[data-js-favorite-modified]');
	if (modified instanceof HTMLTimeElement) {
		modified.dateTime = item.modified;
		modified.textContent = item.modified;
	}
	const title = fragment.querySelector('[data-js-favorite-title]');
	if (title instanceof HTMLElement) {
		title.textContent = item.title;
	}
	return fragment;
}

export function initFavoritePage(): void {
	const page = document.querySelector<HTMLElement>('[data-js-favorite-page]');
	if (!page) {
		return;
	}
	const template = page.querySelector<HTMLTemplateElement>('[data-js-favorite-template]');
	const thumbTemplate = page.querySelector<HTMLTemplateElement>('[data-js-favorite-thumb-template]');
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
			empty.hidden = false;
			return;
		}
		empty.hidden = true;
		loading.hidden = false;
		const controller = new AbortController();
		const timeoutId = window.setTimeout(() => {
			controller.abort();
		}, 10000);
		try {
			const res = await fetch(`/wp-json/dorango/v1/favorites?ids=${ids.join(',')}`, { signal: controller.signal });
			if (!res.ok) {
				throw new Error(`HTTP ${res.status}`);
			}
			const items = parseFavoriteItems(await res.json());
			list.replaceChildren();
			if (items.length === 0) {
				empty.hidden = false;
				return;
			}
			items.forEach((item) => {
				list.append(renderFavoriteCard(template, thumbTemplate, item));
			});
		} catch {
			list.replaceChildren();
			const error = document.createElement('p');
			error.textContent = '一覧の取得に失敗しました。時間をおいて再度お試しください。';
			list.append(error);
		} finally {
			window.clearTimeout(timeoutId);
			loading.hidden = true;
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
