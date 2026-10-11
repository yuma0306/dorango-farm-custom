function setHamburgerOpen(open: boolean): void {
	const root = document.querySelector<HTMLElement>('[data-js-hamburger]');
	const overlay = document.querySelector<HTMLElement>('[data-js-hamburger-overlay]');
	const btns = document.querySelectorAll<HTMLButtonElement>('[data-js-hamburger-btn]');
	if (!root) {
		return;
	}
	root.classList.toggle('js-open', open);
	document.body.style.overflow = open ? 'hidden' : '';
	overlay?.setAttribute('aria-hidden', open ? 'false' : 'true');
	btns.forEach((btn) => {
		btn.setAttribute('aria-expanded', open ? 'true' : 'false');
		btn.setAttribute('aria-label', open ? 'メニューを閉じる' : 'メニューを開く');
	});
}

export function initHamburger(): void {
	const root = document.querySelector<HTMLElement>('[data-js-hamburger]');
	const btns = document.querySelectorAll<HTMLButtonElement>('[data-js-hamburger-btn]');
	const overlay = document.querySelector<HTMLElement>('[data-js-hamburger-overlay]');
	const panel = document.querySelector<HTMLElement>('[data-js-hamburger-panel]');
	if (!root || !overlay || !panel) {
		return;
	}
	btns.forEach((btn) => {
		btn.addEventListener('click', () => {
			setHamburgerOpen(!root.classList.contains('js-open'));
		});
	});
	overlay.addEventListener('click', () => {
		setHamburgerOpen(false);
	});
	panel.addEventListener('click', (event) => {
		const target = event.target;
		if (target instanceof Element && target.closest('a')) {
			setHamburgerOpen(false);
		}
	});
	document.addEventListener('keydown', (event) => {
		if (event.key !== 'Escape' || !root.classList.contains('js-open')) {
			return;
		}
		setHamburgerOpen(false);
	});
}
