/**
 * 検索フォームのバリデーションと送信
 */
export function initSearchValidation(): void {
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
}
