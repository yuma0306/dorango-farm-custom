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
	]);
}
