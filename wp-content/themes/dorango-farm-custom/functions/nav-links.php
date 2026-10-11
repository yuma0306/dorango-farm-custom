<?php

const NAV_LINKS = [
	'ballPython' => [
		'href' => '/tag/species/ball-python/',
		'label' => 'ボールパイソンの記事',
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
		'label' => 'お気に入り',
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

const GNAV_LINK_KEYS = [
	'ballPython',
	'breed',
	'zoo',
	'shop',
	'food',
	'trivia',
	'favorite',
];

const FOOTER_LINK_KEYS = [
	'ballPython',
	'breed',
	'zoo',
	'shop',
	'food',
	'trivia',
	'favorite',
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
