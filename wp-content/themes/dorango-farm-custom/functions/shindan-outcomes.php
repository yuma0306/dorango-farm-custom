<?php

function shindan_outcomes(): array {
	// 質問の順: 性別 → 繁殖 →（繁殖はいなら）エアコン →（無印ルート以外なら）レイアウト →（繁殖いいえなら）温湿度
	return [
		// A: 繁殖「はい」→ エアコン「はい」（性別はどちらでも。以降の質問なし）
		'A' => [
			'type' => '繁殖効率重視ブリーダータイプ',
			'intro' => sprintf(
				'繁殖を目的としていて、部屋をエアコンで温度管理できる方向けの飼育セットです。ケージは<a class="text-link" target="_blank" href="%s">無印良品の衣装ケースを改造</a>し、マルチパネルヒーターをセットできるようにして使います。',
				esc_url(home_url('/breed/ballpython-cage/'))
			),
			'article_ids' => [4926, 4931, 4936],
			'items' => [
				shindan_item('muji-costume-case'),
				shindan_item(
					'multi-panel-heater-16w',
					'無印の衣装ケースを改造し、マルチパネルヒーター16wをセットできるようにして使います。パネルヒーターに温度調節機能が付いている優れものです。'
				),
				shindan_item(
					'pet-sheet-medium',
					'無印良品のポリプロピレン衣装ケース（大）にピッタリです。白いペットシーツで見栄えも良く、排泄物の状態が確認しやすいです。'
				),
				shindan_item('water-dish-natural'),
			],
		],
		// B: オス → 繁殖「はい」→ エアコン「いいえ」→ レイアウト「掃除・管理のしやすさ」
		'B' => [
			'type' => '飼育も繁殖も楽しみたいメンテナンス重視タイプ',
			'intro' => 'オスのボールパイソンの飼育・繁殖をする方向けの飼育セット。メンテナンス性を重視したレイアウトと、繁殖に向けた細かい温度管理ができる飼育用品セットです。',
			'article_ids' => [4931, 4936, 4942],
			'items' => [
				shindan_item('pantheon-6030'),
				shindan_item('heating-top-m'),
				shindan_item('multi-panel-heater-16w'),
				shindan_item('pet-sheet-medium'),
				shindan_item('water-dish-tapper-s'),
				shindan_item('thermostat-advanced'),
				shindan_item('ad-5648a'),
			],
		],
		// C: オス → 繁殖「はい」→ エアコン「いいえ」→ レイアウト「自然な見た目を再現したい」
		'C' => [
			'type' => '飼育も繁殖も楽しみたい自然派レイアウトタイプ',
			'intro' => 'オスのボールパイソンの飼育・繁殖をする方向けの飼育セット。自然な見た目のレイアウトと、繁殖に向けた細かい温度管理を両立した飼育セットです。',
			'article_ids' => [4931, 4936, 4942],
			'items' => [
				shindan_item('pantheon-6030'),
				shindan_item('heating-top-m'),
				shindan_item('multi-panel-heater-16w'),
				shindan_item('husk-chip'),
				shindan_item('water-dish-natural'),
				shindan_item('thermostat-advanced'),
				shindan_item('ad-5648a'),
			],
		],
		// D: メス → 繁殖「はい」→ エアコン「いいえ」→ レイアウト「掃除・管理のしやすさ」
		'D' => [
			'type' => '飼育も繁殖も楽しみたいメンテナンス重視タイプ',
			'intro' => 'メスのボールパイソンの飼育・繁殖をする方向けの飼育セット。広めのケージに、掃除のしやすさと繁殖に向けた細かい温度管理ができる飼育用品セットです。',
			'article_ids' => [4931, 4936, 4942],
			'items' => [
				shindan_item('pantheon-9045'),
				shindan_item('heating-top-m-9045'),
				shindan_item('multi-panel-heater-32w'),
				shindan_item('pet-sheet-large'),
				shindan_item('water-dish-tapper-m'),
				shindan_item('thermostat-advanced'),
				shindan_item('ad-5648a'),
			],
		],
		// E: メス → 繁殖「はい」→ エアコン「いいえ」→ レイアウト「自然な見た目を再現したい」
		'E' => [
			'type' => '飼育も繁殖も楽しみたい自然派レイアウトタイプ',
			'intro' => 'メスのボールパイソンの飼育・繁殖をする方向けの飼育セット。広めのケージに、自然な見た目のレイアウトと、繁殖に向けた細かい温度管理を両立した飼育セットです。',
			'article_ids' => [4931, 4936, 4942],
			'items' => [
				shindan_item('pantheon-9045'),
				shindan_item('heating-top-m-9045'),
				shindan_item('multi-panel-heater-32w'),
				shindan_item('husk-chip'),
				shindan_item('water-dish-natural'),
				shindan_item('thermostat-advanced'),
				shindan_item('ad-5648a'),
			],
		],
		// F: オス → 繁殖「いいえ」→ レイアウト「掃除・管理のしやすさ」→ 温湿度「費用を抑えたい」
		'F' => [
			'type' => 'コスパ・メンテナンス重視タイプ',
			'intro' => 'オスのボールパイソンを飼育する方向けの飼育セット。メンテナンス性を重視したレイアウトと、費用を抑えたシンプルな温湿度管理ができる飼育用品セットです。',
			'article_ids' => [4942],
			'items' => [
				shindan_item('pantheon-6030'),
				shindan_item('heating-top-m'),
				shindan_item('multi-panel-heater-16w'),
				shindan_item('pet-sheet-medium'),
				shindan_item('water-dish-tapper-s'),
				shindan_item('thermostat-basic'),
				shindan_item('vivaria-twin-meter-neo'),
			],
		],
		// G: オス → 繁殖「いいえ」→ レイアウト「掃除・管理のしやすさ」→ 温湿度「最高・最低まで把握したい」
		'G' => [
			'type' => '温度管理徹底・メンテナンス重視タイプ',
			'intro' => 'オスのボールパイソンを飼育する方向けの飼育セット。メンテナンス性を重視したレイアウトと、細かい温度管理ができる飼育用品セットです。',
			'article_ids' => [4942],
			'items' => [
				shindan_item('pantheon-6030'),
				shindan_item('heating-top-m'),
				shindan_item('multi-panel-heater-16w'),
				shindan_item('pet-sheet-medium'),
				shindan_item('water-dish-tapper-s'),
				shindan_item('thermostat-advanced'),
				shindan_item('ad-5648a'),
			],
		],
		// H: オス → 繁殖「いいえ」→ レイアウト「自然な見た目を再現したい」→ 温湿度「費用を抑えたい」
		'H' => [
			'type' => 'コスパ重視の自然派レイアウトタイプ',
			'intro' => 'オスのボールパイソンを飼育する方向けの飼育セット。自然な見た目のレイアウトと、費用を抑えたシンプルな温湿度管理を両立した飼育セットです。',
			'article_ids' => [4942],
			'items' => [
				shindan_item('pantheon-6030'),
				shindan_item('heating-top-m'),
				shindan_item('multi-panel-heater-16w'),
				shindan_item('husk-chip'),
				shindan_item('water-dish-natural'),
				shindan_item('thermostat-basic'),
				shindan_item('vivaria-twin-meter-neo'),
			],
		],
		// I: オス → 繁殖「いいえ」→ レイアウト「自然な見た目を再現したい」→ 温湿度「最高・最低まで把握したい」
		'I' => [
			'type' => '温度管理徹底・自然派レイアウトタイプ',
			'intro' => 'オスのボールパイソンを飼育する方向けの飼育セット。自然な見た目のレイアウトと、細かい温度管理を両立した飼育セットです。',
			'article_ids' => [4942],
			'items' => [
				shindan_item('pantheon-6030'),
				shindan_item('heating-top-m'),
				shindan_item('multi-panel-heater-16w'),
				shindan_item('husk-chip'),
				shindan_item('water-dish-natural'),
				shindan_item('thermostat-advanced'),
				shindan_item('ad-5648a'),
			],
		],
		// J: メス → 繁殖「いいえ」→ レイアウト「掃除・管理のしやすさ」→ 温湿度「費用を抑えたい」
		'J' => [
			'type' => 'コスパ・メンテナンス重視タイプ',
			'intro' => 'メスのボールパイソンを飼育する方向けの飼育セット。広めのケージに、メンテナンス性を重視したレイアウトと、費用を抑えたシンプルな温湿度管理ができる飼育用品セットです。',
			'article_ids' => [4942],
			'items' => [
				shindan_item('pantheon-9045'),
				shindan_item('heating-top-m-9045'),
				shindan_item('multi-panel-heater-32w'),
				shindan_item('pet-sheet-large'),
				shindan_item('water-dish-tapper-m'),
				shindan_item('thermostat-basic'),
				shindan_item('vivaria-twin-meter-neo'),
			],
		],
		// K: メス → 繁殖「いいえ」→ レイアウト「掃除・管理のしやすさ」→ 温湿度「最高・最低まで把握したい」
		'K' => [
			'type' => '温度管理徹底・メンテナンス重視タイプ',
			'intro' => 'メスのボールパイソンを飼育する方向けの飼育セット。広めのケージに、メンテナンス性を重視したレイアウトと、細かい温度管理ができる飼育用品セットです。',
			'article_ids' => [4942],
			'items' => [
				shindan_item('pantheon-9045'),
				shindan_item('heating-top-m-9045'),
				shindan_item('multi-panel-heater-32w'),
				shindan_item('pet-sheet-large'),
				shindan_item('water-dish-tapper-m'),
				shindan_item('thermostat-advanced'),
				shindan_item('ad-5648a'),
			],
		],
		// L: メス → 繁殖「いいえ」→ レイアウト「自然な見た目を再現したい」→ 温湿度「費用を抑えたい」
		'L' => [
			'type' => 'コスパ重視の自然派レイアウトタイプ',
			'intro' => 'メスのボールパイソンを飼育する方向けの飼育セット。広めのケージに、自然な見た目のレイアウトと、費用を抑えたシンプルな温湿度管理を組み合わせた飼育セットです。',
			'article_ids' => [4942],
			'items' => [
				shindan_item('pantheon-9045'),
				shindan_item('heating-top-m-9045'),
				shindan_item('multi-panel-heater-32w'),
				shindan_item('husk-chip'),
				shindan_item('water-dish-natural'),
				shindan_item('thermostat-basic'),
				shindan_item('vivaria-twin-meter-neo'),
			],
		],
		// M: メス → 繁殖「いいえ」→ レイアウト「自然な見た目を再現したい」→ 温湿度「最高・最低まで把握したい」
		'M' => [
			'type' => '温度管理徹底・自然派レイアウトタイプ',
			'intro' => 'メスのボールパイソンを飼育する方向けの飼育セット。広めのケージに、自然な見た目のレイアウトと、細かい温度管理を両立した飼育セットです。',
			'article_ids' => [4942],
			'items' => [
				shindan_item('pantheon-9045'),
				shindan_item('heating-top-m-9045'),
				shindan_item('multi-panel-heater-32w'),
				shindan_item('husk-chip'),
				shindan_item('water-dish-natural'),
				shindan_item('thermostat-advanced'),
				shindan_item('ad-5648a'),
			],
		],
	];
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
		shindan_item('hypochlorous-acid-water'),
		shindan_item('pressure-sprayer'),
		shindan_item('feeding-tweezers'),
	];
}

function shindan_item(string $product_id, ?string $custom_description = null): array {
	static $catalog = [
		'muji-costume-case' => [
			'label' => 'ケージ',
			'description' => '無印良品のポリプロピレン衣装ケース（大）です。積み上げ可能で、積み上げた隙間にマルチパネルヒーターをセットできるように改造して使えます。',
		],
		'pantheon-6030' => [
			'label' => 'ケージ',
			'description' => 'オスのボールパイソン飼育におすすめのケージ。脱走できるような隙間がなく、天板と扉の締め忘れに注意すれば、ベビー個体でも問題無し。スライド式の扉で、給餌時の飛び出しを防ぎやすい設計。ヒーティングトップMを載せられ、底面の足を利用してマルチパネルヒーターも設置可能。',
		],
		'pantheon-9045' => [
			'label' => 'ケージ',
			'description' => 'メスのボールパイソン飼育におすすめのケージ。脱走できるような隙間がなく、天板と扉の締め忘れに注意すれば、ベビー個体でも問題無し。スライド式の扉で、給餌時の飛び出しを防ぎやすい設計。ヒーティングトップMを載せられ、底面の足を利用してマルチパネルヒーターも設置可能。',
		],
		'heating-top-m' => [
			'label' => '保温',
			'description' => 'パンテオンの天板に置くだけで設置可能なケージの全体温度を保温するためのミニエアコン。サーモスタットと接続して温度を自動調整しながら使用します。',
		],
		'heating-top-m-9045' => [
			'label' => '保温',
			'product_id' => 'heating-top-m',
			'description' => 'パンテオンの天板に置くだけで設置可能なケージの全体温度を保温するためのミニエアコン。サーモスタットと接続して温度を自動調整しながら使用します。保温が足りない場合はサーモスタットとヒーティングトップMをもう1つずつ用意して、両天板に設置可能。',
		],
		'multi-panel-heater-16w' => [
			'label' => 'パネルヒーター',
			'description' => 'パンテオン6030に合う16wサイズ。パネルヒーターに温度調節機能が付いている優れもの。',
		],
		'multi-panel-heater-32w' => [
			'label' => 'パネルヒーター',
			'description' => 'パンテオン9045に合う32wサイズ。パネルヒーターに温度調節機能が付いている優れもの。',
		],
		'pet-sheet-medium' => [
			'label' => '床材',
			'description' => 'パンテオン6030にぴったりのワイドサイズ。白いペットシーツで見栄えも良く、排泄物の状態が確認しやすい。',
		],
		'pet-sheet-large' => [
			'label' => '床材',
			'description' => 'パンテオン9045にぴったりのスーパーワイドサイズ。白いペットシーツで見栄えも良く、排泄物の状態が確認しやすい。',
		],
		'husk-chip' => [
			'label' => '床材',
			'description' => '大きめに砕かれたヤシガラ（ハスクチップ）。保湿性が高く、粒も大きいので誤飲のリスクが少ない。1〜2ヶ月に1回交換が必要。',
		],
		'water-dish-natural' => [
			'label' => '水入れ',
			'description' => 'ケージのコーナーに設置できる自然な見た目の水入れです。',
		],
		'water-dish-tapper-s' => [
			'label' => '水入れ',
			'description' => 'パンテオン6030に最適な全身浸かれるタイプの大きめタッパー。',
		],
		'water-dish-tapper-m' => [
			'label' => '水入れ',
			'description' => 'パンテオン9045に最適な全身浸かれるタイプの大きめタッパー。',
		],
		'thermostat-basic' => [
			'label' => 'サーモスタット',
			'description' => 'ケージ内の温度の上がりすぎを防ぐためのサーモスタット。ヒーティングトップに接続して、設定した温度になるようにON・OFFを自動で切り替えるお値打ちのおすすめ商品。夜間に設定温度を下げる場合や照明のONとOFFには別途切り替えが必要。',
		],
		'thermostat-advanced' => [
			'label' => 'サーモスタット',
			'description' => 'ケージ内の温度の上がりすぎを防ぐためのサーモスタット。ヒーティングトップに接続して、設定した温度になるようにON・OFFを自動で切り替えます。夜間と日中で温度を切り替えることも可能。タイマー機能もあり、照明の自動ON・OFFも可能。',
		],
		'ad-5648a' => [
			'label' => '温湿度計',
			'description' => '1日の最高最低温度・湿度を継続する機能があり、夜間の温度の下がりすぎ、日中の温度の上がりすぎにいち早く気付ける。センサーでケージ内の温湿度を測定し、同時に本体を設置している部屋の温度も測れます。',
		],
		'vivaria-twin-meter-neo' => [
			'label' => '温湿度計',
			'description' => 'ケージ内に吸盤で貼り付けられ、温度と湿度を同時に測ることができるお値打ち温度計。1日の最高最低温度・湿度を測る機能は無いので夜間の温度の下がりすぎなどはチェックが必要。',
		],
		'hypochlorous-acid-water' => [
			'label' => '次亜塩素酸水',
			'description' => '掃除に使用する次亜塩素酸水です。消毒もできて、使用後水に戻るので生体にも安全に使える優れものです！',
		],
		'pressure-sprayer' => [
			'label' => '蓄圧式霧吹き',
			'description' => '手が疲れない蓄圧式の霧吹きです。簡単に霧吹きできます。100均とは違うのだよ。100均とは。',
		],
		'feeding-tweezers' => [
			'label' => '給餌用ピンセット',
			'description' => '竹で出来ており、生体に安全に給餌ができます。ピンセットはこれ一強です！',
		],
	];
	$item = $catalog[$product_id] ?? ['label' => '', 'description' => ''];
	return [
		'label' => $item['label'],
		'product_id' => $item['product_id'] ?? $product_id,
		'description' => $custom_description ?? $item['description'],
	];
}
