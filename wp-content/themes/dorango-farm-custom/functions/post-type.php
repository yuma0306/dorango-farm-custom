<?php
function addCustomPostType() {
	register_post_type('breed', [
		'label' => '飼育・繁殖',
		'hierarchical' => false,
		'public' => true,
		'has_archive' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'breed'
		],
		'supports' => [
			'title',
			'revisions',
		],
		'menu_position' => 5,
	]);

	register_post_type('zoo', [
		'label' => '動物園',
		'hierarchical' => false,
		'public' => true,
		'has_archive' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'zoo'
		],
		'supports' => [
			'title',
			'revisions',
		],
		'menu_position' => 5,
	]);

	register_post_type('shop', [
		'label' => 'ショップ',
		'hierarchical' => false,
		'public' => true,
		'has_archive' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'shop'
		],
		'supports' => [
			'title',
			'revisions',
		],
		'menu_position' => 5,
	]);

	register_post_type('food', [
		'label' => '昆虫食',
		'hierarchical' => false,
		'public' => true,
		'has_archive' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'food'
		],
		'supports' => [
			'title',
			'revisions',
		],
		'menu_position' => 5,
	]);

	register_post_type('trivia', [
		'label' => '動物雑学',
		'hierarchical' => false,
		'public' => true,
		'has_archive' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'trivia'
		],
		'supports' => [
			'title',
			'revisions',
		],
		'menu_position' => 5,
	]);
}

add_action('init', 'addCustomPostType');
