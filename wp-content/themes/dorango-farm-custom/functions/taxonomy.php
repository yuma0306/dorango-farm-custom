<?php
function add_custom_taxonomy() {
	register_taxonomy('goods', 'breed', [
		'label' => '飼育用品',
		'hierarchical' => false,
		'public' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'tag/goods'
		],
		'show_admin_column' => true,
	]);
	register_taxonomy('method', 'breed', [
		'label' => '飼育法',
		'hierarchical' => false,
		'public' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'tag/method'
		],
		'show_admin_column' => true,
	]);
	register_taxonomy('species', 'breed', [
		'label' => '種',
		'hierarchical' => false,
		'public' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'tag/species'
		],
		'show_admin_column' => true,
	]);
	register_taxonomy('morph', 'breed', [
		'label' => 'モルフ',
		'hierarchical' => false,
		'public' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'tag/morph'
		],
		'show_admin_column' => true,
	]);
	register_taxonomy('diseases', 'breed', [
		'label' => '病気',
		'hierarchical' => false,
		'public' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'tag/diseases'
		],
		'show_admin_column' => true,
	]);
	register_taxonomy('cross', 'breed', [
		'label' => '繁殖',
		'hierarchical' => false,
		'public' => true,
		'rewrite' => [
			'with_front' => false,
			'slug' => 'tag/cross'
		],
		'show_admin_column' => true,
	]);
}

add_action('init', 'add_custom_taxonomy');
