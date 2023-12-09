
document.addEventListener('DOMContentLoaded', function() {
	/**
	 * サンクスページへリダイレクト
	 * contact-form7を利用
	 */
	const redirectThanks = () => {
		document.addEventListener( 'wpcf7mailsent', function( event ) {
			location = '/';
		}, false );
	}
	/**
	 * フォームバリデーション
	 */
	const scrollValidate = () => {
		// ContactForm7のフォーム
		const wpcf7El = document.querySelector('.wpcf7');
		// バリデーションエラーの処理
		wpcf7El.addEventListener('wpcf7invalid', function() {
		  const speed = 500; // スクロール速度
			setTimeout(function () {
				const firstErrorElm = document.querySelector('.wpcf7-not-valid:first-child');
				const scrollPos = firstErrorElm.offsetTop;
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
