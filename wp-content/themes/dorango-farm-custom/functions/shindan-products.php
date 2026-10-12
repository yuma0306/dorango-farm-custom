<?php

function shindan_product(string $id): ?string {
	static $affiliates = [
		'pantheon_9045' => 'pantheon-9045',
		'pantheon_6030' => 'pantheon-6030',
		'muji_costume_case' => 'muji-costume-case',
		'heating_top_m' => 'heating-top-m',
		'multi_panel_heater_16w' => 'multi-panel-heater-16w',
		'multi_panel_heater_32w' => 'multi-panel-heater-32w',
		'pet_sheet' => 'pet-sheet',
		'thermostat_basic' => 'thermostat-basic',
		'thermostat_advanced' => 'thermostat-advanced',
		'vivaria_twin_meter_neo' => 'vivaria-twin-meter-neo',
		'ad_5648a' => 'ad-5648a',
		'husk_chip' => 'husk-chip',
		'water_dish_natural' => 'water-dish-natural',
		'water_dish_simple' => 'water-dish-simple',
	];

	return $affiliates[$id] ?? null;
}

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
		'lead' => shindan_outcome_lead_context($outcome, $outcome_id),
		'items' => $outcome['items'],
	]);
}
