import { cloneTemplateContent } from './clone-template';

export type PostListItem = {
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

function isPostListThumb(value: unknown): value is PostListItem['thumb'] & object {
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

function isPostListItem(value: unknown): value is PostListItem {
	if (!isRecord(value)) {
		return false;
	}
	const thumb = value.thumb;
	return (
		typeof value.id === 'number' &&
		typeof value.title === 'string' &&
		typeof value.url === 'string' &&
		(thumb === null || isPostListThumb(thumb)) &&
		typeof value.published === 'string' &&
		typeof value.modified === 'string'
	);
}

export function parsePostListItems(data: unknown): PostListItem[] {
	if (!Array.isArray(data)) {
		return [];
	}
	return data.filter(isPostListItem);
}

export function renderPostListCard(
	template: HTMLTemplateElement,
	thumbTemplate: HTMLTemplateElement | null,
	item: PostListItem,
): DocumentFragment {
	const fragment = cloneTemplateContent(template);
	const link = fragment.querySelector('[data-js-blogs-item-link]');
	if (link instanceof HTMLAnchorElement) {
		link.href = item.url;
	}
	const block = fragment.querySelector('[data-js-blogs-item-block]');
	if (item.thumb) {
		let img = fragment.querySelector('[data-js-blogs-item-img]');
		if (!(img instanceof HTMLImageElement) && thumbTemplate !== null) {
			fragment.querySelector('[data-js-blogs-item-thumb]')?.remove();
			const thumbFragment = cloneTemplateContent(thumbTemplate);
			const picture = thumbFragment.querySelector('[data-js-blogs-item-thumb]');
			if (picture instanceof HTMLElement && block instanceof HTMLElement) {
				block.before(picture);
				img = fragment.querySelector('[data-js-blogs-item-img]');
			}
		}
		if (img instanceof HTMLImageElement) {
			img.src = item.thumb.url;
			img.alt = item.thumb.alt;
			img.width = item.thumb.width;
			img.height = item.thumb.height;
		}
	} else {
		fragment.querySelector('[data-js-blogs-item-thumb]')?.remove();
	}
	const published = fragment.querySelector('[data-js-blogs-item-published]');
	if (published instanceof HTMLTimeElement) {
		published.dateTime = item.published;
		published.textContent = item.published;
	}
	const modified = fragment.querySelector('[data-js-blogs-item-modified]');
	if (modified instanceof HTMLTimeElement) {
		modified.dateTime = item.modified;
		modified.textContent = item.modified;
	}
	const title = fragment.querySelector('[data-js-blogs-item-title]');
	if (title instanceof HTMLElement) {
		title.textContent = item.title;
	}
	return fragment;
}

export async function fetchPostListItems(ids: number[]): Promise<PostListItem[]> {
	if (ids.length === 0) {
		return [];
	}
	const controller = new AbortController();
	const timeoutId = window.setTimeout(() => {
		controller.abort();
	}, 10000);
	try {
		const res = await fetch(`/wp-json/dorango/v1/posts?ids=${ids.join(',')}`, {
			signal: controller.signal,
		});
		if (!res.ok) {
			throw new Error(`HTTP ${res.status}`);
		}
		return parsePostListItems(await res.json());
	} finally {
		window.clearTimeout(timeoutId);
	}
}
