<?php

function is_ball_python_post(): bool {
	return is_singular('breed') && has_term('ball-python', 'species');
}

function ball_python_hub_sections(): array {
	return [
		['title' => 'ケージについて', 'post_ids' => [4926, 4994]],
		['title' => '温度・湿度について', 'post_ids' => [4999]],
		['title' => '餌について', 'post_ids' => [4911, 4907]],
		['title' => '拒食について', 'post_ids' => [4949]],
		['title' => '繁殖について', 'post_ids' => [4931, 4936]],
		['title' => '病気・健康管理について', 'post_ids' => [4923]],
	];
}

function ball_python_hub_posts_by_id(array $post_ids): array {
	$post_ids = array_values(array_unique(array_filter(array_map('absint', $post_ids))));
	if ($post_ids === []) {
		return [];
	}
	$posts = get_posts([
		'post__in' => $post_ids,
		'post_type' => 'breed',
		'post_status' => 'publish',
		'numberposts' => count($post_ids),
		'orderby' => 'post__in',
		'ignore_sticky_posts' => true,
	]);
	if ($posts === []) {
		return [];
	}
	_prime_post_caches(wp_list_pluck($posts, 'ID'), false, true);
	$map = [];
	foreach ($posts as $post) {
		$map[(int) $post->ID] = $post;
	}
	return $map;
}
