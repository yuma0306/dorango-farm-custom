<?php

function dorango_favorites_data(WP_REST_Request $request): array {
	$ids = array_slice(array_values(array_unique(array_filter(array_map('absint', explode(',', (string) $request->get_param('ids')))))), 0, 100);
	if ($ids === []) {
		return [];
	}
	$posts = get_posts([
		'post__in' => $ids,
		'post_type' => ['breed', 'zoo', 'shop', 'food', 'trivia'],
		'post_status' => 'publish',
		'numberposts' => count($ids),
		'orderby' => 'post__in',
		'ignore_sticky_posts' => true,
	]);
	$data = [];
	foreach ($posts as $post) {
		$thumb = get_article_thumb($post->ID);
		$data[] = [
			'id' => (int) $post->ID,
			'title' => get_the_title($post->ID),
			'url' => get_permalink($post->ID),
			'thumb' => $thumb ? [
				'url' => $thumb['url'],
				'width' => (int) $thumb['width'],
				'height' => (int) $thumb['height'],
				'alt' => $thumb['alt'],
			] : null,
			'published' => get_post_time('Y-m-d', false, $post->ID),
			'modified' => get_post_modified_time('Y-m-d', false, $post->ID),
		];
	}
	return $data;
}
