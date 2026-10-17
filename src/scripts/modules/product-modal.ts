import { hideElement, isElementHidden, showElement } from './element-display';

export function initProductModal(): void {
	const root = document.querySelector<HTMLElement>('[data-js-product-modal]');
	const panel = root?.querySelector<HTMLElement>('[data-js-product-modal-panel]');
	const backdrop = root?.querySelector<HTMLButtonElement>('[data-js-product-modal-backdrop]');
	const closeBtn = root?.querySelector<HTMLButtonElement>('[data-js-product-modal-close]');
	const sections = root?.querySelectorAll<HTMLElement>('[data-js-product-modal-section]');
	const triggers = document.querySelectorAll<HTMLButtonElement>('[data-js-product-modal-open]');

	if (!root || !panel || !backdrop || !sections || triggers.length === 0) {
		return;
	}

	let lastFocused: HTMLElement | null = null;

	const closeModal = (): void => {
		hideElement(backdrop);
		hideElement(panel);
		for (const sec of sections) {
			hideElement(sec);
		}
		document.body.style.overflow = '';
		lastFocused?.focus();
		lastFocused = null;
	};

	const openModal = (slug: string, trigger: HTMLElement): void => {
		let matched = false;
		sections.forEach((sec) => {
			if (sec.dataset.jsProductModalSection === slug) {
				showElement(sec);
				matched = true;
			} else {
				hideElement(sec);
			}
		});
		if (!matched) {
			return;
		}
		lastFocused = trigger;
		showElement(backdrop);
		showElement(panel);
		panel.scrollTop = 0;
		document.body.style.overflow = 'hidden';
		closeBtn?.focus();
	};

	triggers.forEach((btn) => {
		btn.addEventListener('click', () => {
			const slug = btn.dataset.jsProductModalOpen;
			if (slug) {
				openModal(slug, btn);
			}
		});
	});

	backdrop.addEventListener('click', closeModal);
	closeBtn?.addEventListener('click', closeModal);

	document.addEventListener('keydown', (event) => {
		if (event.key === 'Escape' && !isElementHidden(panel)) {
			closeModal();
		}
	});
}
