/**
 * DOM読み込み後
 */
document.addEventListener('DOMContentLoaded', () => {
	const redirectThanks = () => {
		const thanksPath = '/contact/thanks/';
		document.addEventListener('wpcf7mailsent', () => {
			window.location.href = thanksPath;
		}, false);
	};

	const scrollValidate = () => {
		const wpcf7Elm = document.querySelector<HTMLElement>('.wpcf7');
		if (!wpcf7Elm) {
			return;
		}
		wpcf7Elm.addEventListener('wpcf7invalid', () => {
			const speed = 300;
			window.setTimeout(() => {
				const firstError = document.querySelector<HTMLElement>('.wpcf7-not-valid');
				const firstErrorElm = firstError?.closest<HTMLElement>('.js-contact-group');
				if (!firstErrorElm) {
					return;
				}
				const scrollPos = firstErrorElm.getBoundingClientRect().top + window.scrollY;
				window.scrollTo({ top: scrollPos, behavior: 'smooth' });
			}, speed);
		}, false);
	};

	scrollValidate();
	redirectThanks();
});
