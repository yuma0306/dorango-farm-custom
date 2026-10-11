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
		backdrop.hidden = false;
		panel.hidden = false;
		document.body.style.overflow = 'hidden';
		const input = panel.querySelector<HTMLInputElement>('.js-search-input');
		input?.focus();
		return;
	}
	backdrop.hidden = true;
	panel.hidden = true;
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
		if (event.key !== 'Escape' || panel.hidden) {
			return;
		}
		setSearchFloatOpen(false);
	});
}
