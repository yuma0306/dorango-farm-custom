const HIDE_DELAY = 2500;

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
	toast.hidden = false;
	hideTimer = window.setTimeout(() => {
		toast.hidden = true;
	}, HIDE_DELAY);
}
