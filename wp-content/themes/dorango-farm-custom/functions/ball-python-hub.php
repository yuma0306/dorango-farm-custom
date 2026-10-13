<?php

function is_ball_python_post(): bool {
	return is_singular('breed') && has_term('ball-python', 'species');
}

const BALL_PYTHON_HUB_RECOMMENDED_POST_IDS = [
	4942,
];

function ball_python_hub_is_recommended(int $post_id): bool {
	return in_array($post_id, BALL_PYTHON_HUB_RECOMMENDED_POST_IDS, true);
}

function ball_python_hub_sections(): array {
	return [
		['title' => 'お迎え', 'post_ids' => [5503, 5012]],
		['title' => 'ケージ', 'post_ids' => [4994, 4926]],
		['title' => '温度・湿度', 'post_ids' => [4999]],
		['title' => '床材', 'post_ids' => [5517]],
		['title' => 'メンテナンス・掃除', 'post_ids' => [5475]],
		['title' => '餌', 'post_ids' => [4911, 4907]],
		['title' => '拒食', 'post_ids' => [4949]],
		['title' => '繁殖', 'post_ids' => [4931, 4936]],
		['title' => '病気・健康管理', 'post_ids' => [4923]],
	];
}

function ball_python_hub_data(int $exclude_id): ?array {
	$sections = ball_python_hub_sections();
	$recommended_post_ids = [];
	foreach (BALL_PYTHON_HUB_RECOMMENDED_POST_IDS as $post_id) {
		$post_id = absint($post_id);
		if ($post_id && $post_id !== $exclude_id) {
			$recommended_post_ids[] = $post_id;
		}
	}
	$post_ids = $recommended_post_ids;
	foreach ($sections as $section) {
		foreach ($section['post_ids'] ?? [] as $post_id) {
			$post_id = absint($post_id);
			if ($post_id && $post_id !== $exclude_id) {
				$post_ids[] = $post_id;
			}
		}
	}
	$posts_by_id = ball_python_hub_posts_by_id($post_ids);
	$recommended_visible = [];
	foreach ($recommended_post_ids as $post_id) {
		if (isset($posts_by_id[$post_id])) {
			$recommended_visible[] = $post_id;
		}
	}
	$visible = [];
	foreach ($sections as $section) {
		$title = (string) ($section['title'] ?? '');
		if ($title === '') {
			continue;
		}
		$ids = [];
		foreach ($section['post_ids'] ?? [] as $post_id) {
			$post_id = absint($post_id);
			if ($post_id && isset($posts_by_id[$post_id])) {
				$ids[] = $post_id;
			}
		}
		if ($ids === []) {
			continue;
		}
		$visible[] = [
			'title' => $title,
			'post_ids' => $ids,
		];
	}
	if ($visible === [] && $recommended_visible === []) {
		return null;
	}
	return [
		'recommended_post_ids' => $recommended_visible,
		'visible' => $visible,
	];
}

function ball_python_hub_posts_by_id(array $post_ids): array {
	$post_ids = array_values(array_unique(array_filter(array_map('absint', $post_ids))));
	if ($post_ids === []) {
		return [];
	}
	$posts = get_posts([
		'post__in' => $post_ids,
		'post_type' => ['breed', 'page'],
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
