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

// 目次生成
const createToc = () => {
	// 初期設定
	const tocInsertSelector = '#js-toc';
	const headingSelector = '#js-article h1, #js-article h2, #js-article h3, #js-article h4, #js-article h5, #js-article h6';
	const tocListClassName = 'toc__list';
	const tocItemClassName = 'toc__item';
	const linkClassName = 'toc__link';
	const idPrefix = 'anchor-';
	const tocInsertElement = document.querySelector(tocInsertSelector);
	const headingElements = document.querySelectorAll(headingSelector);
	const tocLayers = [];
	let idCounter = 1;
	const generateUniqueId = () => `${idPrefix}${idCounter++}`;
	let previousRank = -1;
	// 目次生成
	try {
		// リンク生成
		const createTocLinkElement = (headingElement) => {
			const listItem = document.createElement('li');
			const anchor = document.createElement('a');
			headingElement.id = headingElement.id || generateUniqueId();
			anchor.href = `#${headingElement.id}`;
			anchor.innerText = headingElement.innerText;
			anchor.className = linkClassName;
			listItem.appendChild(anchor);
			return listItem;
		};
		// 目次の親レイヤーを探す
		const findParentLayer = (layers, rank, diff) => {
			do {
				rank += diff;
				if (layers[rank]) return layers[rank];
			} while (0 < rank && rank < 7);
			return false;
		};
		// 目次を追加
		const appendTocToElement = (element, toc) => {
			element.appendChild(toc.cloneNode(true));
		};
		headingElements.forEach((element) => {
			let headingRank = Number(element.tagName.substring(1));
			let parentLayer = findParentLayer(tocLayers, headingRank, -1);
			// 前のランクが現在のランクよりも大きい場合、tocLayersの長さを調整
			if (previousRank > headingRank) {
				tocLayers.length = headingRank + 1;
			}
			// tocLayersにまだ現在のランクのレイヤーが存在しない場合、新しいol要素を作成し追加
			if(!tocLayers[headingRank]) {
				tocLayers[headingRank] = document.createElement('ol');
				tocLayers[headingRank].className = tocListClassName;
				if (parentLayer.lastChild) {
					parentLayer.lastChild.appendChild(tocLayers[headingRank]);
				}
			}
			// 見出し要素に対応する目次のリンク要素を生成し、tocLayersに追加
			const tocItem = createTocLinkElement(element);
			tocItem.className = tocItemClassName;
			tocLayers[headingRank].appendChild(tocItem);
			// previousRankを更新
			previousRank = headingRank;
		});
		// 目次が存在する場合実行
		if (tocLayers.length) {
			appendTocToElement(tocInsertElement, findParentLayer(tocLayers, 0, 1));
		}
	} catch (error) {
		// console.error(error);
	}
}
