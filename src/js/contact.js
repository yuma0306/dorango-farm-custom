
document.addEventListener('DOMContentLoaded', function() {
	/**
	 * ContactForm7 DOMイベント
	 * https://contactform7.com/ja/dom-events/
	 */

	/**
	 * サンクスページへリダイレクト
	 * contact-form7を利用
	 */
	const redirectThanks = () => {
		const thanksPath = '/contact/thanks/';
		document.addEventListener('wpcf7mailsent', function() {
			location = thanksPath;
		}, false);
	}

	/**
	 * フォームバリデーション
	 */
	const scrollValidate = () => {
		// 要素
		const header = 'js-header';
		const errorElm = 'wpcf7-not-valid';
		const contactGroup = 'js-contact-group';
		const wpcf7 = 'wpcf7';
		const wpcf7Elm = document.querySelector(`.${wpcf7}`);
		// 位置調整
		const adjust = 0;
		// バリデーションエラーの処理
		wpcf7Elm.addEventListener('wpcf7invalid', function() {
			const speed = 300;
			const headerHeight = document.querySelector(`#${header}`).clientHeight;
			setTimeout(function() {
				const firstErrorElm = document.querySelector(`.${errorElm}:first-child`).closest(`.${contactGroup}`);
				let scrollPos = firstErrorElm.getBoundingClientRect().top + window.scrollY - (headerHeight + adjust);
				window.scrollTo({ top: scrollPos, behavior: 'smooth' });
			}, speed);
		}, false);
	}
	/**
	 * 関数実行
	 */
	scrollValidate();
	redirectThanks();
})
