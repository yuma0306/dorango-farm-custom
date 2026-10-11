import { setSearchFloatOpen } from './search-float';

export function initSingleFixedFooter(): void {
	const footer = document.querySelector('[data-js-single-fixed-footer]');
	if (!footer) {
		return;
	}
	const searchBtn = footer.querySelector('[data-js-single-fixed-footer-search]');
	searchBtn?.addEventListener('click', () => {
		setSearchFloatOpen(true);
	});
}
