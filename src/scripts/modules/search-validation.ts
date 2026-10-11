/**
 * 検索フォームのバリデーションと送信
 */
export function initSearchValidation(): void {
	const searchForms = document.querySelectorAll<HTMLFormElement>('.js-search-form');
	searchForms.forEach((searchFormElm) => {
		const searchBtnElm = searchFormElm.querySelector<HTMLButtonElement>('.js-search-btn');
		const searchInputElm = searchFormElm.querySelector<HTMLInputElement>('.js-search-input');
		const validateErrElm = searchFormElm.nextElementSibling;
		const validateErrChildElm = validateErrElm?.querySelector<HTMLElement>('.js-search-child');
		if (
			!searchBtnElm ||
			!searchInputElm ||
			!validateErrElm ||
			!(validateErrElm instanceof HTMLElement) ||
			!validateErrChildElm
		) {
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
	});
}
