import { initSearchFloat } from './modules/search-float';
import { initSearchValidation } from './modules/search-validation';
import { initTocFloat } from './modules/toc-float';
import { initFavorites } from './modules/favorite';
import { initHistoryPage } from './modules/history';
import { initRecentPosts } from './modules/recent-posts';
import { initFloatingBar } from './modules/floating-bar';
import { initHamburger } from './modules/hamburger';

document.addEventListener('DOMContentLoaded', () => {
	initSearchValidation();
	initSearchFloat();
	initTocFloat();
	initFavorites();
	initRecentPosts();
	initHistoryPage();
	initFloatingBar();
	initHamburger();
});
