/**
 * DOM読み込み後
 */
document.addEventListener('DOMContentLoaded', function() {
	/**
	 * 共通変数
	 */
	// アクティブなクラス
	const activeFlag = 'is-active';
	// フローティング
	const header = 'js-header';

	/**
	 * スムーズスクロール
	 */
	const scrollSmooth = () => {
		const adjust = 0;
		document.querySelectorAll('a[href^="#"]').forEach(anchor => {
			anchor.addEventListener('click', function (e) {
				const headerHeight = document.getElementById(header).clientHeight;
				e.preventDefault();
				const href = this.getAttribute('href');
				const target = href === '#' || href === '' ? document.documentElement : document.querySelector(href);
				const pos = target.offsetTop - (headerHeight + adjust);
				window.scrollTo({
					top: pos,
					behavior: 'smooth'
				});
			});
		});
	};

	/**
	 * 固定コンテンツ
	 */
	const fixedContent = () => {
		const pos = 100;
		window.addEventListener('scroll', function() {
			if (window.scrollY > pos) {
				document.getElementById(header).classList.add(activeFlag);
			} else {
				document.getElementById(header).classList.remove(activeFlag);
			}
		});
	};

	/**
	 * 検索フォームバリデーション
	 */
	const validateSearchBtn = () => {
		const serchForm = 'js-search-form';
		const searchBtn = 'js-search-btn';
		const searchInput = 'js-search-input';
		const validateErr = 'js-search-err';
		const validateErrChild = 'js-search-child';
		const searchFormElm = document.querySelector(`.${serchForm}`);
		const searchBtnElm = document.querySelector(`.${searchBtn}`);
		const searchInputElm = document.querySelector(`.${searchInput}`);
		const validateErrElm = document.querySelector(`.${validateErr}`);
		const validateErrChildElm = document.querySelector(`.${validateErrChild}`);
		// なければ処理終わり
		if (!searchBtnElm || !searchInputElm || !searchFormElm || !validateErrElm || !validateErrChildElm) {
			return;
		}
		// 送信ボタンクリック
		searchBtnElm.addEventListener('click', function (e) {
			e.preventDefault();
			validateAndSubmitForm();
		});
		// Enter押された時
		searchInputElm.addEventListener('keydown', function (e) {
			if (e.key === 'Enter') {
				e.preventDefault();
				validateAndSubmitForm();
			}
		});
		// バリデーションチェック
		function validateAndSubmitForm() {
			const inputValue = searchInputElm.value;
			if (inputValue.trim() !== '') {
				searchFormElm.submit();
			} else {
				validateErrChildElm.style.display = 'block';
				validateErrElm.style.visibility = 'visible';
				validateErrElm.style.opacity = '1';
			}
		}
		// 再度フォーカスされたら
		searchInputElm.addEventListener('focus', function () {
			validateErrChildElm.style.display = 'none';
			validateErrElm.style.visibility = 'hidden';
			validateErrElm.style.opacity = '0';
		});
	}

	const animateScrollY = () => {
		const animateElements = document.querySelectorAll('.js-animate-y');
		// アニメーション要素がなければ終わり
		if (animateElements.length === 0) {
			return;
		}
		const delayTime = 0.2;
		window.addEventListener('scroll', function() {
		const scrollPos = window.scrollY;
		const windowHeight = window.innerHeight;
		animateElements.forEach((animateElement, index) => {
			const elementPos = animateElement.offsetTop;
			const adjust = 50;
				if (scrollPos > elementPos - windowHeight + adjust) {
					animateElement.style.opacity = 1;
					animateElement.style.visibility = 'visible';
					animateElement.style.transform = 'translateY(0)';
					animateElement.style.transitionDelay = `${index * delayTime}s`;
				}
			});
		});
	}

	/**
	 * 関数実行
	 */
	animateScrollY();
	// createToc();
	scrollSmooth();
	fixedContent();
	validateSearchBtn();
});
