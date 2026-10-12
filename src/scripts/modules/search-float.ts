import { hideElement, isElementHidden, showElement } from './element-display';

let lastFocused: HTMLElement | null = null;

export function setSearchFloatOpen(open: boolean): void {
	const root = document.querySelector<HTMLElement>('[data-js-search-float]');
	const panel = root?.querySelector<HTMLElement>('[data-js-search-float-panel]');
	const backdrop = root?.querySelector<HTMLButtonElement>('[data-js-search-float-backdrop]');
	if (!root || !panel || !backdrop) {
		return;
	}
	if (open) {
		lastFocused = document.activeElement instanceof HTMLElement ? document.activeElement : null;
		showElement(backdrop);
		showElement(panel);
		document.body.style.overflow = 'hidden';
		const input = panel.querySelector<HTMLInputElement>('.js-search-input');
		input?.focus();
		return;
	}
	hideElement(backdrop);
	hideElement(panel);
	document.body.style.overflow = '';
	lastFocused?.focus();
	lastFocused = null;
}

export function initSearchFloat(): void {
	const root = document.querySelector<HTMLElement>('[data-js-search-float]');
	const panel = root?.querySelector<HTMLElement>('[data-js-search-float-panel]');
	const backdrop = root?.querySelector<HTMLButtonElement>('[data-js-search-float-backdrop]');
	if (!root || !panel || !backdrop) {
		return;
	}
	backdrop.addEventListener('click', () => {
		setSearchFloatOpen(false);
	});
	document.addEventListener('keydown', (event) => {
		if (event.key !== 'Escape' || isElementHidden(panel)) {
			return;
		}
		setSearchFloatOpen(false);
	});
}
