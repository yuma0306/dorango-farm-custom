import { fetchPostListItems, renderPostListCard } from './post-cards';
import {
	getRecentIds,
	getRecentHistoryLimit,
	getRecentSingleSectionLimit,
	recordRecentPost,
} from './recent-storage';

export function initRecentPosts(): void {
	const section = document.querySelector<HTMLElement>('[data-js-recent-posts]');
	if (!section) {
		return;
	}
	const currentId = Number(section.dataset.postId);
	if (!Number.isInteger(currentId) || currentId <= 0) {
		return;
	}
	recordRecentPost(currentId);

	const template = section.querySelector<HTMLTemplateElement>('[data-js-recent-posts-template]');
	const thumbTemplate = section.querySelector<HTMLTemplateElement>('[data-js-recent-posts-thumb-template]');
	const loading = section.querySelector<HTMLElement>('[data-js-loading]');
	const list = section.querySelector<HTMLElement>('[data-js-recent-posts-list]');
	if (!template || !loading || !list) {
		return;
	}

	const ids = getRecentIds(getRecentHistoryLimit())
		.filter((id) => id !== currentId)
		.slice(0, getRecentSingleSectionLimit());
	if (ids.length === 0) {
		return;
	}

	const render = async () => {
		loading.hidden = false;
		list.replaceChildren();
		try {
			const items = await fetchPostListItems(ids);
			list.replaceChildren();
			if (items.length === 0) {
				return;
			}
			items.forEach((item) => {
				list.append(renderPostListCard(template, thumbTemplate, item));
			});
			section.hidden = false;
		} catch {
			list.replaceChildren();
		} finally {
			loading.hidden = true;
		}
	};

	void render();
}
