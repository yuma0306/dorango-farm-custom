export function initTocFloat(): void {
	const root = document.querySelector<HTMLElement>('[data-js-toc-float]');
	const btn = root?.querySelector<HTMLButtonElement>('[data-js-toc-float-btn]');
	const panel = root?.querySelector<HTMLElement>('[data-js-toc-float-panel]');
	const overlay = root?.querySelector<HTMLElement>('[data-js-toc-float-overlay]');
	if (!root || !btn || !panel || !overlay) {
		return;
	}
	const setOpen = (open: boolean) => {
		btn.setAttribute('aria-expanded', open ? 'true' : 'false');
		root.classList.toggle('js-open', open);
		overlay.setAttribute('aria-hidden', open ? 'false' : 'true');
		document.body.style.overflow = open ? 'hidden' : '';
	};
	btn.addEventListener('click', () => {
		setOpen(!root.classList.contains('js-open'));
	});
	overlay.addEventListener('click', () => {
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
	document.addEventListener('keydown', (event) => {
		if (event.key !== 'Escape' || !root.classList.contains('js-open')) {
			return;
		}
		setOpen(false);
	});
}
