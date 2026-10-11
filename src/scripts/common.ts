import { initSearchValidation } from './modules/search-validation';
import { initTocFloat } from './modules/toc-float';

document.addEventListener('DOMContentLoaded', () => {
	initSearchValidation();
	initTocFloat();
});
