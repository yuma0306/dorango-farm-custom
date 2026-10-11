import { initSearchValidation } from './modules/search-validation';
import { initTocFloat } from './modules/toc-float';
import { initFavorites } from './modules/favorite';
import { initHistoryPage } from './modules/history';
import { initRecentPosts } from './modules/recent-posts';

document.addEventListener('DOMContentLoaded', () => {
	initSearchValidation();
	initTocFloat();
	initFavorites();
	initRecentPosts();
	initHistoryPage();
});
