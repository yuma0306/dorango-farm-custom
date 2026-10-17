<?php

const NAV_LINKS = [
	'home' => [
		'href' => '/',
		'label' => 'ホーム',
		'icon' => 'home',
	],
	'ballPython' => [
		'href' => '/tag/species/ball-python/',
		'label' => 'ボールパイソンの記事',
	],
	'ballPythonSetupShindan' => [
		'href' => '/ballpython-setup-shindan/',
		'label' => 'ボールパイソン飼育セット診断',
	],
	'petProducts' => [
		'href' => '/pet-products/',
		'label' => 'セール情報・おすすめ飼育用品',
		'icon' => 'sale',
	],
	'breed' => [
		'href' => '/breed/',
		'label' => '飼育・繁殖',
		'en' => 'BREED',
		'img' => 'img-breeding-front.webp',
	],
	'zoo' => [
		'href' => '/zoo/',
		'label' => 'アニマルスポット',
		'en' => 'ZOO',
		'img' => 'img-zoo-front.webp',
	],
	'shop' => [
		'href' => '/shop/',
		'label' => 'ショップ',
		'en' => 'SHOP',
		'img' => 'img-shop-front.webp',
	],
	'food' => [
		'href' => '/food/',
		'label' => '昆虫食',
		'en' => 'FOOD',
		'img' => 'img-insect-front.webp',
	],
	'trivia' => [
		'href' => '/trivia/',
		'label' => '動物雑学',
		'en' => 'TRIVIA',
		'img' => 'img-trivia-front.webp',
	],
	'favorite' => [
		'href' => '/favorite/',
		'label' => 'お気に入り記事',
		'icon' => 'heart',
	],
	'history' => [
		'href' => '/history/',
		'label' => '最近チェックした記事',
		'icon' => 'history',
	],
	'tags' => [
		'href' => '/tag/',
		'label' => 'タグ一覧',
	],
	'privacy' => [
		'href' => '/privacy/',
		'label' => 'プライバシーポリシー',
	],
	'contact' => [
		'href' => '/contact/',
		'label' => 'お問い合わせ',
	],
];

const HAMBURGER_LINK_KEYS = [
	'home',
	'favorite',
	'history',
	'petProducts',
	'ballPython',
	'ballPythonSetupShindan',
	'breed',
	'zoo',
	'shop',
	'food',
	'trivia',
];

const FOOTER_LINK_KEYS = [
	'petProducts',
	'ballPython',
	'ballPythonSetupShindan',
	'breed',
	'zoo',
	'shop',
	'food',
	'trivia',
	'favorite',
	'history',
	'tags',
	'privacy',
	'contact',
];

const CATEGORY_LINK_KEYS = [
	'breed',
	'zoo',
	'shop',
	'food',
	'trivia',
];

function get_nav_links(array $keys): array {
	$links = [];
	foreach ($keys as $key) {
		if (!isset(NAV_LINKS[$key])) {
			continue;
		}
		$links[] = NAV_LINKS[$key];
	}
	return $links;
}
