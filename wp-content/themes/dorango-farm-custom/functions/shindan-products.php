<?php

function shindan_outcome_articles_anchor_id(string $outcome_id): string {
	return 'anchor-' . $outcome_id;
}

function shindan_outcome_lead_context(array $outcome, string $outcome_id): ?array {
	$intro = isset($outcome['intro']) ? trim((string) $outcome['intro']) : '';
	$article_ids = [];

	foreach ($outcome['article_ids'] ?? [] as $post_id) {
		$post_id = absint($post_id);
		if ($post_id === 0) {
			continue;
		}
		$article_ids[] = $post_id;
	}

	if ($article_ids !== [] && $outcome_id !== '') {
		$intro = rtrim($intro) . sprintf(
			'各飼育用品の使い方は<a class="text-link" href="#%s">これらの記事</a>で解説しています。',
			esc_attr(shindan_outcome_articles_anchor_id($outcome_id))
		);
	}

	if ($intro === '' && $article_ids === []) {
		return null;
	}

	return [
		'intro' => $intro,
		'article_ids' => $article_ids,
	];
}

function shindan_share_text(string $outcome_id): string {
	$share_page_url = add_query_arg('result', strtoupper($outcome_id), home_url('/ballpython-setup-shindan/'));
	$outcome = shindan_outcome($outcome_id);
	$type = $outcome['type'] ?? '';
	$lines = [
		sprintf('診断結果は【%s】でした', $type),
		'',
		'目的にあった飼育用品一覧がわかる🐍',
		'',
		'#ボールパイソン飼育セット診断',
		'',
		$share_page_url,
	];
	return implode("\n", $lines);
}

function shindan_share_url(string $outcome_id): string {
	return 'https://twitter.com/intent/tweet?' . http_build_query([
		'text' => shindan_share_text($outcome_id),
	], '', '&', PHP_QUERY_RFC3986);
}

function shindan_line_share_url(string $outcome_id): string {
	return 'https://line.me/R/share?' . http_build_query([
		'text' => shindan_share_text($outcome_id),
	], '', '&', PHP_QUERY_RFC3986);
}

function shindan_render_outcome(string $outcome_id): void {
	$outcome = shindan_outcome($outcome_id);
	if ($outcome === null) {
		return;
	}

	get_template_part('include/shindan-result', null, [
		'outcome_id' => $outcome_id,
		'type' => $outcome['type'],
		'lead' => shindan_outcome_lead_context($outcome, $outcome_id),
		'items' => $outcome['items'],
		'total_price' => $outcome['total_price'],
		'share_url' => shindan_share_url($outcome_id),
	]);
}
