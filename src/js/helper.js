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

/**
 * セレクトタグのリダイレクト
 */
const redirectToPage = () => {
	const selectors = Array.from(document.getElementsByClassName('js-select-redirect'));
	selectors.forEach(selector => {
		selector.addEventListener('change', function() {
			const value = selector.value;
			value && (window.location.href = value);
		});
	});
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
	// 処理
	});
};
