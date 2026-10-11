import { fetchPostListItems, renderPostListCard } from './post-cards';
import { getRecentIds } from './recent-storage';

export function initHistoryPage(): void {
	const page = document.querySelector<HTMLElement>('[data-js-history-page]');
	if (!page) {
		return;
	}
	const template = page.querySelector<HTMLTemplateElement>('[data-js-history-template]');
	const thumbTemplate = page.querySelector<HTMLTemplateElement>('[data-js-history-thumb-template]');
	const loading = page.querySelector<HTMLElement>('[data-js-loading]');
	const list = page.querySelector<HTMLElement>('[data-js-history-list]');
	const empty = page.querySelector<HTMLElement>('[data-js-history-empty]');
	if (!template || !loading || !list || !empty) {
		return;
	}

	const render = async () => {
		const ids = getRecentIds();
		list.replaceChildren();
		if (ids.length === 0) {
			empty.hidden = false;
			return;
		}
		empty.hidden = true;
		loading.hidden = false;
		try {
			const items = await fetchPostListItems(ids);
			list.replaceChildren();
			if (items.length === 0) {
				empty.hidden = false;
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
			loading.hidden = true;
		}
	};

	void render();
}
