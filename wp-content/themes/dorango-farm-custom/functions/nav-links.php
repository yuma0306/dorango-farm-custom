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
	'breed' => [
		'href' => '/breed/',
		'label' => '飼育繁殖',
	],
	'zoo' => [
		'href' => '/zoo/',
		'label' => 'アニマルスポット',
	],
	'shop' => [
		'href' => '/shop/',
		'label' => 'ショップ',
	],
	'food' => [
		'href' => '/food/',
		'label' => '昆虫食',
	],
	'trivia' => [
		'href' => '/trivia/',
		'label' => '動物雑学',
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
	'ballPython',
	'ballPythonSetupShindan',
	'breed',
	'zoo',
	'shop',
	'food',
	'trivia',
];

const FOOTER_LINK_KEYS = [
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
