<?php

function shindan_outcomes(): array {
	// 質問の順: 性別 → 繁殖 →（繁殖はいなら）エアコン →（無印ルート以外なら）レイアウト →（繁殖いいえなら）温湿度
	static $outcomes = [
		// A: 繁殖「はい」→ エアコン「はい」（性別はどちらでも。以降の質問なし）
		'A' => [
			'type' => '繁殖効率重視ブリーダータイプ',
			'intro' => sprintf(
				'繁殖を目的としていて、部屋をエアコンで温度管理できる方向けの飼育セットです。ケージは<a class="text-link" target="_blank" href="%s">無印良品の衣装ケースを改造</a>し、マルチパネルヒーターをセットできるようにして使います。',
				esc_url(home_url('/breed/ballpython-cage/'))
			),
			'article_ids' => [4926, 4931, 4936],
			'items' => [
				[
					'label' => 'ケージ',
					'product_id' => 'muji_costume_case',
					'description' => '',
				],
				[
					'label' => 'パネルヒーター',
					'product_id' => 'multi_panel_heater_16w',
					'description' => '',
				],
				[
					'label' => '床材',
					'product_id' => 'pet_sheet_medium',
					'description' => '',
				],
				[
					'label' => '水入れ',
					'product_id' => 'water_dish_natural',
					'description' => '',
				],
			],
		],
		// B: オス → 繁殖「はい」→ エアコン「いいえ」→ レイアウト「掃除・管理のしやすさ」
		'B' => [
			'type' => '飼育も繁殖も楽しみたいメンテナンス重視タイプ',
			'intro' => 'オスのボールパイソンの飼育・繁殖をする方向けの飼育セット。メンテナンス性を重視したレイアウトと、繁殖に向けた細かい温度管理ができる飼育用品セットです。',
			'article_ids' => [4931, 4936, 4942],
			'items' => [
				[
					'label' => 'ケージ',
					'product_id' => 'pantheon_6030',
					'description' => '',
				],
				[
					'label' => '保温',
					'product_id' => 'heating_top_m',
					'description' => '',
				],
				[
					'label' => 'パネルヒーター',
					'product_id' => 'multi_panel_heater_16w',
					'description' => '',
				],
				[
					'label' => '床材',
					'product_id' => 'pet_sheet_medium',
					'description' => '',
				],
				[
					'label' => '水入れ',
					'product_id' => 'water_dish_tapper_medium',
					'description' => '',
				],
				[
					'label' => 'サーモスタット',
					'product_id' => 'thermostat_advanced',
					'description' => '',
				],
				[
					'label' => '温湿度計',
					'product_id' => 'ad_5648a',
					'description' => '',
				],
			],
		],
		// C: オス → 繁殖「はい」→ エアコン「いいえ」→ レイアウト「自然な見た目を再現したい」
		'C' => [
			'type' => '飼育も繁殖も楽しみたい自然派レイアウトタイプ',
			'intro' => 'オスのボールパイソンの飼育・繁殖をする方向けの飼育セット。自然な見た目のレイアウトと、繁殖に向けた細かい温度管理を両立した飼育セットです。',
			'article_ids' => [4931, 4936, 4942],
			'items' => [
				[
					'label' => 'ケージ',
					'product_id' => 'pantheon_6030',
					'description' => '',
				],
				[
					'label' => '保温',
					'product_id' => 'heating_top_m',
					'description' => '',
				],
				[
					'label' => 'パネルヒーター',
					'product_id' => 'multi_panel_heater_16w',
					'description' => '',
				],
				[
					'label' => '床材',
					'product_id' => 'husk_chip',
					'description' => '',
				],
				[
					'label' => '水入れ',
					'product_id' => 'water_dish_natural',
					'description' => '',
				],
				[
					'label' => 'サーモスタット',
					'product_id' => 'thermostat_advanced',
					'description' => '',
				],
				[
					'label' => '温湿度計',
					'product_id' => 'ad_5648a',
					'description' => '',
				],
			],
		],
		// D: メス → 繁殖「はい」→ エアコン「いいえ」→ レイアウト「掃除・管理のしやすさ」
		'D' => [
			'type' => '飼育も繁殖も楽しみたいメンテナンス重視タイプ',
			'intro' => 'メスのボールパイソンの飼育・繁殖をする方向けの飼育セット。広めのケージに、掃除のしやすさと繁殖に向けた細かい温度管理ができる飼育用品セットです。',
			'article_ids' => [4931, 4936, 4942],
			'items' => [
				[
					'label' => 'ケージ',
					'product_id' => 'pantheon_9045',
					'description' => '',
				],
				[
					'label' => '保温',
					'product_id' => 'heating_top_m',
					'description' => '',
				],
				[
					'label' => 'パネルヒーター',
					'product_id' => 'multi_panel_heater_32w',
					'description' => '',
				],
				[
					'label' => '床材',
					'product_id' => 'pet_sheet_large',
					'description' => '',
				],
				[
					'label' => '水入れ',
					'product_id' => 'water_dish_tapper_large',
					'description' => '',
				],
				[
					'label' => 'サーモスタット',
					'product_id' => 'thermostat_advanced',
					'description' => '',
				],
				[
					'label' => '温湿度計',
					'product_id' => 'ad_5648a',
					'description' => '',
				],
			],
		],
		// E: メス → 繁殖「はい」→ エアコン「いいえ」→ レイアウト「自然な見た目を再現したい」
		'E' => [
			'type' => '飼育も繁殖も楽しみたい自然派レイアウトタイプ',
			'intro' => 'メスのボールパイソンの飼育・繁殖をする方向けの飼育セット。広めのケージに、自然な見た目のレイアウトと、繁殖に向けた細かい温度管理を両立した飼育セットです。',
			'article_ids' => [4931, 4936, 4942],
			'items' => [
				[
					'label' => 'ケージ',
					'product_id' => 'pantheon_9045',
					'description' => '',
				],
				[
					'label' => '保温',
					'product_id' => 'heating_top_m',
					'description' => '',
				],
				[
					'label' => 'パネルヒーター',
					'product_id' => 'multi_panel_heater_32w',
					'description' => '',
				],
				[
					'label' => '床材',
					'product_id' => 'husk_chip',
					'description' => '',
				],
				[
					'label' => '水入れ',
					'product_id' => 'water_dish_natural',
					'description' => '',
				],
				[
					'label' => 'サーモスタット',
					'product_id' => 'thermostat_advanced',
					'description' => '',
				],
				[
					'label' => '温湿度計',
					'product_id' => 'ad_5648a',
					'description' => '',
				],
			],
		],
		// F: オス → 繁殖「いいえ」→ レイアウト「掃除・管理のしやすさ」→ 温湿度「費用を抑えたい」
		'F' => [
			'type' => 'コスパ・メンテナンス重視タイプ',
			'intro' => 'オスのボールパイソンを飼育する方向けの飼育セット。メンテナンス性を重視したレイアウトと、費用を抑えたシンプルな温湿度管理ができる飼育用品セットです。',
			'article_ids' => [4942],
			'items' => [
				[
					'label' => 'ケージ',
					'product_id' => 'pantheon_6030',
					'description' => '',
				],
				[
					'label' => '保温',
					'product_id' => 'heating_top_m',
					'description' => '',
				],
				[
					'label' => 'パネルヒーター',
					'product_id' => 'multi_panel_heater_16w',
					'description' => '',
				],
				[
					'label' => '床材',
					'product_id' => 'pet_sheet_medium',
					'description' => '',
				],
				[
					'label' => '水入れ',
					'product_id' => 'water_dish_tapper_medium',
					'description' => '',
				],
				[
					'label' => 'サーモスタット',
					'product_id' => 'thermostat_basic',
					'description' => '',
				],
				[
					'label' => '温湿度計',
					'product_id' => 'vivaria_twin_meter_neo',
					'description' => '',
				],
			],
		],
		// G: オス → 繁殖「いいえ」→ レイアウト「掃除・管理のしやすさ」→ 温湿度「最高・最低まで把握したい」
		'G' => [
			'type' => '温度管理徹底・メンテナンス重視タイプ',
			'intro' => 'オスのボールパイソンを飼育する方向けの飼育セット。メンテナンス性を重視したレイアウトと、細かい温度管理ができる飼育用品セットです。',
			'article_ids' => [4942],
			'items' => [
				[
					'label' => 'ケージ',
					'product_id' => 'pantheon_6030',
					'description' => '',
				],
				[
					'label' => '保温',
					'product_id' => 'heating_top_m',
					'description' => '',
				],
				[
					'label' => 'パネルヒーター',
					'product_id' => 'multi_panel_heater_16w',
					'description' => '',
				],
				[
					'label' => '床材',
					'product_id' => 'pet_sheet_medium',
					'description' => '',
				],
				[
					'label' => '水入れ',
					'product_id' => 'water_dish_tapper_medium',
					'description' => '',
				],
				[
					'label' => 'サーモスタット',
					'product_id' => 'thermostat_advanced',
					'description' => '',
				],
				[
					'label' => '温湿度計',
					'product_id' => 'ad_5648a',
					'description' => '',
				],
			],
		],
		// H: オス → 繁殖「いいえ」→ レイアウト「自然な見た目を再現したい」→ 温湿度「費用を抑えたい」
		'H' => [
			'type' => 'コスパ重視の自然派レイアウトタイプ',
			'intro' => 'オスのボールパイソンを飼育する方向けの飼育セット。自然な見た目のレイアウトと、費用を抑えたシンプルな温湿度管理を両立した飼育セットです。',
			'article_ids' => [4942],
			'items' => [
				[
					'label' => 'ケージ',
					'product_id' => 'pantheon_6030',
					'description' => '',
				],
				[
					'label' => '保温',
					'product_id' => 'heating_top_m',
					'description' => '',
				],
				[
					'label' => 'パネルヒーター',
					'product_id' => 'multi_panel_heater_16w',
					'description' => '',
				],
				[
					'label' => '床材',
					'product_id' => 'husk_chip',
					'description' => '',
				],
				[
					'label' => '水入れ',
					'product_id' => 'water_dish_natural',
					'description' => '',
				],
				[
					'label' => 'サーモスタット',
					'product_id' => 'thermostat_basic',
					'description' => '',
				],
				[
					'label' => '温湿度計',
					'product_id' => 'vivaria_twin_meter_neo',
					'description' => '',
				],
			],
		],
		// I: オス → 繁殖「いいえ」→ レイアウト「自然な見た目を再現したい」→ 温湿度「最高・最低まで把握したい」
		'I' => [
			'type' => '温度管理徹底・自然派レイアウトタイプ',
			'intro' => 'オスのボールパイソンを飼育する方向けの飼育セット。自然な見た目のレイアウトと、細かい温度管理を両立した飼育セットです。',
			'article_ids' => [4942],
			'items' => [
				[
					'label' => 'ケージ',
					'product_id' => 'pantheon_6030',
					'description' => '',
				],
				[
					'label' => '保温',
					'product_id' => 'heating_top_m',
					'description' => '',
				],
				[
					'label' => 'パネルヒーター',
					'product_id' => 'multi_panel_heater_16w',
					'description' => '',
				],
				[
					'label' => '床材',
					'product_id' => 'husk_chip',
					'description' => '',
				],
				[
					'label' => '水入れ',
					'product_id' => 'water_dish_natural',
					'description' => '',
				],
				[
					'label' => 'サーモスタット',
					'product_id' => 'thermostat_advanced',
					'description' => '',
				],
				[
					'label' => '温湿度計',
					'product_id' => 'ad_5648a',
					'description' => '',
				],
			],
		],
		// J: メス → 繁殖「いいえ」→ レイアウト「掃除・管理のしやすさ」→ 温湿度「費用を抑えたい」
		'J' => [
			'type' => 'コスパ・メンテナンス重視タイプ',
			'intro' => 'メスのボールパイソンを飼育する方向けの飼育セット。広めのケージに、メンテナンス性を重視したレイアウトと、費用を抑えたシンプルな温湿度管理ができる飼育用品セットです。',
			'article_ids' => [4942],
			'items' => [
				[
					'label' => 'ケージ',
					'product_id' => 'pantheon_9045',
					'description' => '',
				],
				[
					'label' => '保温',
					'product_id' => 'heating_top_m',
					'description' => '',
				],
				[
					'label' => 'パネルヒーター',
					'product_id' => 'multi_panel_heater_32w',
					'description' => '',
				],
				[
					'label' => '床材',
					'product_id' => 'pet_sheet_large',
					'description' => '',
				],
				[
					'label' => '水入れ',
					'product_id' => 'water_dish_tapper_large',
					'description' => '',
				],
				[
					'label' => 'サーモスタット',
					'product_id' => 'thermostat_basic',
					'description' => '',
				],
				[
					'label' => '温湿度計',
					'product_id' => 'vivaria_twin_meter_neo',
					'description' => '',
				],
			],
		],
		// K: メス → 繁殖「いいえ」→ レイアウト「掃除・管理のしやすさ」→ 温湿度「最高・最低まで把握したい」
		'K' => [
			'type' => '温度管理徹底・メンテナンス重視タイプ',
			'intro' => 'メスのボールパイソンを飼育する方向けの飼育セット。広めのケージに、メンテナンス性を重視したレイアウトと、細かい温度管理ができる飼育用品セットです。',
			'article_ids' => [4942],
			'items' => [
				[
					'label' => 'ケージ',
					'product_id' => 'pantheon_9045',
					'description' => '',
				],
				[
					'label' => '保温',
					'product_id' => 'heating_top_m',
					'description' => '',
				],
				[
					'label' => 'パネルヒーター',
					'product_id' => 'multi_panel_heater_32w',
					'description' => '',
				],
				[
					'label' => '床材',
					'product_id' => 'pet_sheet_large',
					'description' => '',
				],
				[
					'label' => '水入れ',
					'product_id' => 'water_dish_tapper_large',
					'description' => '',
				],
				[
					'label' => 'サーモスタット',
					'product_id' => 'thermostat_advanced',
					'description' => '',
				],
				[
					'label' => '温湿度計',
					'product_id' => 'ad_5648a',
					'description' => '',
				],
			],
		],
		// L: メス → 繁殖「いいえ」→ レイアウト「自然な見た目を再現したい」→ 温湿度「費用を抑えたい」
		'L' => [
			'type' => 'コスパ重視の自然派レイアウトタイプ',
			'intro' => 'メスのボールパイソンを飼育する方向けの飼育セット。広めのケージに、自然な見た目のレイアウトと、費用を抑えたシンプルな温湿度管理を組み合わせた飼育セットです。',
			'article_ids' => [4942],
			'items' => [
				[
					'label' => 'ケージ',
					'product_id' => 'pantheon_9045',
					'description' => '',
				],
				[
					'label' => '保温',
					'product_id' => 'heating_top_m',
					'description' => '',
				],
				[
					'label' => 'パネルヒーター',
					'product_id' => 'multi_panel_heater_32w',
					'description' => '',
				],
				[
					'label' => '床材',
					'product_id' => 'husk_chip',
					'description' => '',
				],
				[
					'label' => '水入れ',
					'product_id' => 'water_dish_natural',
					'description' => '',
				],
				[
					'label' => 'サーモスタット',
					'product_id' => 'thermostat_basic',
					'description' => '',
				],
				[
					'label' => '温湿度計',
					'product_id' => 'vivaria_twin_meter_neo',
					'description' => '',
				],
			],
		],
		// M: メス → 繁殖「いいえ」→ レイアウト「自然な見た目を再現したい」→ 温湿度「最高・最低まで把握したい」
		'M' => [
			'type' => '温度管理徹底・自然派レイアウトタイプ',
			'intro' => 'メスのボールパイソンを飼育する方向けの飼育セット。広めのケージに、自然な見た目のレイアウトと、細かい温度管理を両立した飼育セットです。',
			'article_ids' => [4942],
			'items' => [
				[
					'label' => 'ケージ',
					'product_id' => 'pantheon_9045',
					'description' => '',
				],
				[
					'label' => '保温',
					'product_id' => 'heating_top_m',
					'description' => '',
				],
				[
					'label' => 'パネルヒーター',
					'product_id' => 'multi_panel_heater_32w',
					'description' => '',
				],
				[
					'label' => '床材',
					'product_id' => 'husk_chip',
					'description' => '',
				],
				[
					'label' => '水入れ',
					'product_id' => 'water_dish_natural',
					'description' => '',
				],
				[
					'label' => 'サーモスタット',
					'product_id' => 'thermostat_advanced',
					'description' => '',
				],
				[
					'label' => '温湿度計',
					'product_id' => 'ad_5648a',
					'description' => '',
				],
			],
		],
	];
	return $outcomes;
}

function shindan_outcome(string $id): ?array {
	$id = strtoupper($id);
	$outcomes = shindan_outcomes();
	$raw = $outcomes[$id] ?? null;
	if ($raw === null) {
		return null;
	}

	$items = isset($raw['items']) && is_array($raw['items']) ? $raw['items'] : [];

	return [
		'type' => $raw['type'] ?? '',
		'intro' => isset($raw['intro']) ? (string) $raw['intro'] : '',
		'article_ids' => isset($raw['article_ids']) && is_array($raw['article_ids']) ? $raw['article_ids'] : [],
		'items' => [...$items, ...shindan_common_items()],
	];
}

function shindan_outcome_items(string $id): array {
	$outcome = shindan_outcome($id);
	return $outcome !== null ? $outcome['items'] : [];
}

function shindan_common_items(): array {
	return [
		[
			'label' => '次亜塩素酸水',
			'product_id' => 'hypochlorous_acid_water',
			'description' => '',
		],
		[
			'label' => '蓄圧式霧吹き',
			'product_id' => 'pressure_sprayer',
			'description' => '',
		],
		[
			'label' => '給餌用ピンセット',
			'product_id' => 'feeding_tweezers',
			'description' => '',
		],
	];
}
