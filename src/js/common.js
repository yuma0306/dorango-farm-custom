/**
 * 非同期実行
 */
const addImageAttr = () => {
	const createPromiseObj = function(src){
		return new Promise(function(resolve){
			const image = new Image();
			image.src = src;
			image.onload = function(){
				resolve(image);
			}
		});
	}
	const images = document.getElementsByTagName('img');
	for (const image of images) {
		const src = image.getAttribute('src');
		createPromiseObj(src)
		.then(function(res){
			if(!image.hasAttribute('width')){
				image.setAttribute('width', res.width);
			}
			if(!image.hasAttribute('height')){
				image.setAttribute('height', res.height);
			}
		});
	}
}

addImageAttr();


/**
 * DOM読み込み後
 */
$(function() {
	/**
	 * 共通変数
	 */
	// break point
	const media = 767;
	// active class
	const activeFlag = 'is-active';
	// ハンバーガー
	const burgerBtn = 'js-burger-btn';
	const burgerMenu = 'js-burger-menu';
	const burgerCloseBtn = 'js-close-btn';
	// SPのみアコーディオン
	const spAccParent = 'js-acc-sp';
	const spAccContent = 'js-acc-sp-body';
	const spAccTriger = 'js-acc-sp-triger';
	// floating
	const header = 'js-header';
	const flow = 'js-flow';

	/**
	 * リサイズ処理
	 */
	const resizeWindow = () => {
		let vw = $(window).width();
		$(window).on('resize', () => {
			if (vw === $(window).width()) {
				// 横幅に変化ないなら終了
				return;
			}
			vw = $(window).width();
			// 処理
		});
	}

	/**
	 * スムーズスクロール
	 */
	const scrollSmooth = () => {
		let adjust = 0;
		const speed = 400;
		const animation = 'swing';
		$('a[href^="#"]').click(function () {
			const href = $(this).attr('href');
			const target = $(href == '#' || href == '' ? 'html' : href);
			const pos = target.offset().top - adjust;
			$('html, body').animate({ scrollTop: pos }, speed, animation);
			return false;
		});
	}

	/**
	 * fixコンテンツ
	 */
	const fixedContent = () => {
		const pos = 100;
		$(window).on('scroll', function() {
			if ($(this).scrollTop() > pos) {
				$(`#${header}`).addClass(activeFlag);
			} else {
				$(`#${header}`).removeClass(activeFlag);
			}
		});
	}

	const createSlider = () => {
		const main = new Splide('#js-kv-slider', {
			type: 'loop',
			drag: true,
			perPage: 3,
			perMove: 1,
			gap: '2%',
			padding: "4%",
			classes: {
				pagination: 'splide__pagination kv-pagination',
				page      : 'splide__pagination__page kv-pagination__item',
			},
			breakpoints: {
				767: {
					perPage: 1,
					padding: "8%",
				},
			},
		});
		main.mount();
	}

	/**
	 * 関数実行
	 */
	addImageAttr();
	scrollSmooth();
	createSlider();
	fixedContent();
	// resizeWindow();
	// createAccSp();
	// createBurger();
});
