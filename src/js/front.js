/**
 * スライダー作成
 */
const createSlider = () => {
	const main = new Splide('#js-kv-slider', {
		type: 'loop',
		drag: true,
		perPage: 3,
		perMove: 1,
		gap: '2%',
		padding: '4%',
		autoplay: true,
		speed: 1000,
		interval: 3000,
		classes: {
			pagination: 'splide__pagination kv-pagination',
			page: 'splide__pagination__page kv-pagination__item',
		},
		breakpoints: {
			1024: {
				perPage: 2,
				padding: '6%',
			},
			639: {
				perPage: 1,
				padding: '8%',
			},
		},
	});
	main.mount();
};

createSlider();
