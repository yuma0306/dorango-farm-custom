<?php

add_action('rest_api_init', function () {
	$post_ids_args = [
		'args' => [
			'ids' => [
				'type' => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			],
		],
		'methods' => 'GET',
		'callback' => 'dorango_favorites_data',
		'permission_callback' => '__return_true',
	];
	register_rest_route('dorango/v1', '/posts', $post_ids_args);
	register_rest_route('dorango/v1', '/favorites', $post_ids_args);
});
