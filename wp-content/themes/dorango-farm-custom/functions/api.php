<?php

add_action('rest_api_init', function () {
	register_rest_route('dorango/v1', '/favorites', [
		'methods' => 'GET',
		'callback' => 'dorango_favorites_data',
		'permission_callback' => '__return_true',
		'args' => [
			'ids' => [
				'type' => 'string',
				'sanitize_callback' => 'sanitize_text_field',
			],
		],
	]);
});
