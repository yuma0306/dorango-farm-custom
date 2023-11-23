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
		classes: {
			pagination: 'splide__pagination kv-pagination',
			page: 'splide__pagination__page kv-pagination__item',
		},
		breakpoints: {
			767: {
				perPage: 1,
				padding: '8%',
			},
		},
	});
	main.mount();
};

createSlider();
