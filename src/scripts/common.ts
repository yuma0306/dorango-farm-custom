import { initSearchValidation } from './modules/search-validation';
import { initTocFloat } from './modules/toc-float';
import { initFavorites } from './modules/favorite';

document.addEventListener('DOMContentLoaded', () => {
	initSearchValidation();
	initTocFloat();
	initFavorites();
});
