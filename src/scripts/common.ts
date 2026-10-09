/**
 * DOM読み込み後
 */
document.addEventListener('DOMContentLoaded', () => {
	const validateSearchBtn = () => {
		const searchFormElm = document.querySelector<HTMLFormElement>('.js-search-form');
		const searchBtnElm = document.querySelector<HTMLButtonElement>('.js-search-btn');
		const searchInputElm = document.querySelector<HTMLInputElement>('.js-search-input');
		const validateErrElm = document.querySelector<HTMLElement>('.js-search-err');
		const validateErrChildElm = document.querySelector<HTMLElement>('.js-search-child');
		if (!searchBtnElm || !searchInputElm || !searchFormElm || !validateErrElm || !validateErrChildElm) {
			return;
		}
		const validateAndSubmitForm = () => {
			if (searchInputElm.value.trim() !== '') {
				searchFormElm.submit();
				return;
			}
			validateErrChildElm.style.display = 'block';
			validateErrElm.style.visibility = 'visible';
			validateErrElm.style.opacity = '1';
		};
		searchBtnElm.addEventListener('click', (e) => {
			e.preventDefault();
			validateAndSubmitForm();
		});
		searchInputElm.addEventListener('keydown', (e) => {
			if (e.key === 'Enter') {
				e.preventDefault();
				validateAndSubmitForm();
			}
		});
		searchInputElm.addEventListener('focus', () => {
			validateErrChildElm.style.display = 'none';
			validateErrElm.style.visibility = 'hidden';
			validateErrElm.style.opacity = '0';
		});
	};

	const tocFloat = () => {
		const root = document.querySelector<HTMLElement>('.js-toc-float');
		const btn = root?.querySelector<HTMLButtonElement>('.js-toc-float-btn');
		const panel = root?.querySelector<HTMLElement>('.js-toc-float-panel');
		const backdrop = root?.querySelector<HTMLButtonElement>('.js-toc-float-backdrop');
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
	};

	validateSearchBtn();
	tocFloat();
});
