/**
 * DOM読み込み後
 */
document.addEventListener('DOMContentLoaded', function() {
	/**
	 * 共通変数
	 */
	const media = '639';
	// アクティブなクラス
	const activeFlag = 'is-active';
	// フローティング
	const header = 'js-header';
	// wysiwyg Editor
	const wysiwyg = 'js-wysiwyg';
	const wysiwygStyle = '[style*="font-size"]';
	const designWidth = 390;
	/**
	 * SPロード時
	 */
	const loadSpWindow = (vw = null) => {
		let width = vw;
		if(!vw) {
			width = window.innerWidth;
		}
		if(media >= width) {
			convertVwStyle();
		}
	}
	/**
	 * リサイズ処理
	 */
	const resizeWindow = () => {
		let vw = window.innerWidth;
		window.addEventListener('resize', () => {
			if (vw === window.innerWidth) {
				// 横幅に変化がない場合は終了
				return;
			}
			vw = window.innerWidth;
			resizeWysiwygFontSize(vw);
		});
	};
	/**
	 * 【ACF】wysiwygエディターで出力されたインラインのfont-sizeを変換
	 */
	const resizeWysiwygFontSize = vw => {
		// PC
		if(vw > media) {
			convertPxStyle();
		// SP
		} else if(media >= vw) {
			convertVwStyle();
		}
	}
	/**
	 * pxからvwに単位変換
	 */
	const convertPxStyle = () => {
		const elements = document.querySelectorAll(`.${wysiwyg} ${wysiwygStyle}`);
		elements.forEach(function(element) {
			let currentStyle = element.getAttribute('style');
			let matches = currentStyle.match(/([\d.]+)vw/);
			if (matches) {
				let val = parseFloat(matches[1]);
				let size = convertVwToPx(val);
				element.style.fontSize = size;
			}
		});
	}
	/**
	 * vwからpxに単位変換
	 */
	const convertVwStyle = () => {
		const elements = document.querySelectorAll(`.${wysiwyg} ${wysiwygStyle}`);
		elements.forEach(function(element) {
			let currentStyle = element.getAttribute('style');
			let matches = currentStyle.match(/([\d.]+)px/);
			if (matches) {
				let val = parseFloat(matches[1]);
				let size = convertPxToVw(val);
				element.style.fontSize = size;
			}
		});
	}
	/**
	 * pxからvwに単位変換
	 */
	const convertPxToVw = pxVal => {
		let px = parseFloat(pxVal, 10);
		let vw = (px / designWidth) * 100;
		return `${vw}vw`;
	}
	/**
	 * vwからpxに単位変換
	 */
	const convertVwToPx = vwVal => {
		let vw = parseFloat(vwVal, 10);
		let px = (vw * designWidth) / 100;
		return `${px}px`;
	}
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
	/**
	 * フェードアニメーション
	 */
	const animateScrollY = () => {
		const animateElms = document.querySelectorAll('.js-animate-y');
		// アニメーション要素がなければ終わり
		if (animateElms.length === 0) {
			return;
		}
		const delayTime = 0.2;
		window.addEventListener('scroll', function() {
		const scrollPos = window.scrollY;
		const windowHeight = window.innerHeight;
		animateElms.forEach((animateElm, index) => {
			const elementPos = animateElm.offsetTop;
			const adjust = 50;
				if (scrollPos > elementPos - windowHeight + adjust) {
					animateElm.style.opacity = 1;
					animateElm.style.visibility = 'visible';
					animateElm.style.transform = 'translateY(0)';
					animateElm.style.transitionDelay = `${index * delayTime}s`;
				}
			});
		});
	}
	/**
	 * 関数実行
	 */
	animateScrollY();
	scrollSmooth();
	fixedContent();
	validateSearchBtn();
	loadSpWindow();
	resizeWindow();
});
