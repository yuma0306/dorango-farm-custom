import { initFavorites } from './modules/favorite';
import { initFavoriteSetups } from './modules/favorite-setup';
import { initFloatingBar } from './modules/floating-bar';
import { initHamburger } from './modules/hamburger';
import { initHistoryPage } from './modules/history';
import { initProductModal } from './modules/product-modal';
import { initRecentPosts } from './modules/recent-posts';
import { initSearchFloat } from './modules/search-float';
import { initSearchValidation } from './modules/search-validation';
import { initShindan } from './modules/shindan';
import { initTocFloat } from './modules/toc-float';

document.addEventListener('DOMContentLoaded', () => {
	initSearchValidation();
	initSearchFloat();
	initTocFloat();
	initFavorites();
	initFavoriteSetups();
	initRecentPosts();
	initHistoryPage();
	initFloatingBar();
	initHamburger();
	initShindan();
	initProductModal();
});
