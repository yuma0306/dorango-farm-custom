import { setSearchFloatOpen } from './search-float';

export function initFloatingBar(): void {
	const bar = document.querySelector('[data-js-floating-bar]');
	if (!bar) {
		return;
	}
	const searchBtn = bar.querySelector('[data-js-floating-bar-search]');
	searchBtn?.addEventListener('click', () => {
		setSearchFloatOpen(true);
	});
}
