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
		const adjust = 10;
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

	const validateSearchBtn = () => {
		const serchForm = '.js-search-form';
		const searchBtn = '.js-search-btn';
		const searchInput = '.js-search-input';
		const validateErr = '.js-search-err';
		const searchBtnElm = document.querySelector(searchBtn);
		const searchInputElm = document.querySelector(searchInput);
		const searchFormElm = document.querySelector(serchForm);
		const validateErrElm = document.querySelector(validateErr);
		if (!searchBtnElm || !searchInputElm || !searchFormElm || !validateErrElm) {
			return;
		}
		searchBtnElm.addEventListener('click', function (e) {
			e.preventDefault();
			validateAndSubmitForm();
		});
		searchInputElm.addEventListener('keydown', function (e) {
			if (e.key === 'Enter') {
				e.preventDefault();
				validateAndSubmitForm();
			}
		});
		function validateAndSubmitForm() {
			const inputValue = searchInputElm.value;
			if (inputValue.trim() !== '') {
				searchFormElm.submit();
			} else {
				validateErrElm.style.visibility = 'visible';
				validateErrElm.style.opacity = '1';
			}
		}
		searchInputElm.addEventListener('focus', function () {
			validateErrElm.style.visibility = 'hidden';
			validateErrElm.style.opacity = '0';
		});
	}

	/**
	 * 関数実行
	 */
	createToc();
	scrollSmooth();
	fixedContent();
	validateSearchBtn();
});
