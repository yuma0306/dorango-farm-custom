export function initTocFloat(): void {
	const root = document.querySelector<HTMLElement>('[data-js-toc-float]');
	const btn = root?.querySelector<HTMLButtonElement>('[data-js-toc-float-btn]');
	const panel = root?.querySelector<HTMLElement>('[data-js-toc-float-panel]');
	const backdrop = root?.querySelector<HTMLButtonElement>('[data-js-toc-float-backdrop]');
	if (!root || !btn || !panel || !backdrop) {
		return;
	}
	const setOpen = (open: boolean) => {
		btn.setAttribute('aria-expanded', open ? 'true' : 'false');
		panel.hidden = !open;
		backdrop.hidden = !open;
		document.body.style.overflow = open ? 'hidden' : '';
	};
	btn.addEventListener('click', () => {
		setOpen(Boolean(panel.hidden));
	});
	backdrop.addEventListener('click', () => {
		setOpen(false);
	});
	panel.addEventListener('click', (event) => {
		const target = event.target;
		if (!(target instanceof Element)) {
			return;
		}
		if (!target.closest('a[href^="#"]')) {
			return;
		}
		setOpen(false);
	});
	document.querySelector('[data-js-single-fixed-footer-toc]')?.addEventListener('click', () => {
		setOpen(true);
	});
}
