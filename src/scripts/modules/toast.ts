import { hideElement, showElement } from './element-display';

const HIDE_DELAY = 3000;

let hideTimer = 0;

type ShowToastOptions = {
	html?: boolean;
};

export function showToast(message: string, options?: ShowToastOptions): void {
	const toast = document.querySelector<HTMLElement>('[data-js-toast]');
	const text = toast?.querySelector<HTMLElement>('[data-js-toast-text]');
	if (!toast || !text) {
		return;
	}
	window.clearTimeout(hideTimer);
	if (options?.html) {
		text.innerHTML = message;
	} else {
		text.textContent = message;
	}
	showElement(toast);
	toast.style.animation = 'none';
	void toast.offsetWidth;
	toast.style.animation = '';
	hideTimer = window.setTimeout(() => {
		hideElement(toast);
	}, HIDE_DELAY);
}
