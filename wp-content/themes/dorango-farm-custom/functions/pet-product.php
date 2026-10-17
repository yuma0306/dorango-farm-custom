<?php
/**
 * 飼育用品（pet_product）のカテゴリ定義（表示順・関連記事ID）
 */
function pet_product_categories(): array {
	return [
		'cage' => [
			'title' => 'ケージ',
			'post_ids' => [4994],
		],
		'thermostat' => [
			'title' => 'サーモスタット',
			'post_ids' => [4920],
		],
		'top_heater' => [
			'title' => '上部ヒーター',
			'post_ids' => [4893, 4920],
		],
		'panel_heater' => [
			'title' => 'パネルヒーター',
			'post_ids' => [4990],
		],
		'substrate' => [
			'title' => '床材',
			'post_ids' => [5517],
		],
		'maintenance' => [
			'title' => 'メンテナンス・掃除用品',
			'post_ids' => [5475],
		],
		'thermometer' => [
			'title' => '温湿度計',
			'post_ids' => [4999],
		],
		'water_dish' => [
			'title' => '水入れ',
			'post_ids' => [],
		],
		'feeding' => [
			'title' => '給餌',
			'post_ids' => [4911, 4907],
		],
	];
}

/**
 * ACF select 用の [slug => title] 連想配列を返す
 */
function pet_product_category_choices(): array {
	$choices = [];
	foreach (pet_product_categories() as $slug => $config) {
		$choices[$slug] = (string) ($config['title'] ?? '');
	}
	return $choices;
}

/**
 * 飼育用品の投稿配列を定義順カテゴリにグルーピングする（カテゴリ未設定は除外）
 *
 * @param WP_Post[] $posts
 * @return array<string, array{label: string, posts: WP_Post[], post_ids: int[]}>
 */
function group_pet_products_by_category(array $posts): array {
	$category_map = pet_product_categories();
	$choices = pet_product_category_choices();
	$categories = [];

	foreach ($category_map as $slug => $config) {
		$post_ids = [];
		foreach ($config['post_ids'] ?? [] as $post_id) {
			$post_id = absint($post_id);
			if ($post_id && get_post_status($post_id) === 'publish') {
				$post_ids[] = $post_id;
			}
		}

		$categories[$slug] = [
			'label' => (string) ($config['title'] ?? ''),
			'posts' => [],
			'post_ids' => $post_ids,
		];
	}

	foreach ($posts as $post) {
		$raw_cat = trim((string) get_field('category', $post->ID));
		if ($raw_cat !== '' && isset($categories[$raw_cat])) {
			$categories[$raw_cat]['posts'][] = $post;
			continue;
		}
		// ラベル名で保存されている場合にも対応
		$matched_slug = array_search($raw_cat, $choices, true);
		if ($matched_slug !== false && isset($categories[$matched_slug])) {
			$categories[$matched_slug]['posts'][] = $post;
		}
	}

	// 商品が0件のカテゴリを除外
	return array_filter(
		$categories,
		static fn(array $group): bool => $group['posts'] !== []
	);
}

/**
 * 飼育用品（pet_product）のACFフィールド定義
 */
function register_pet_product_acf_fields() {
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	acf_add_local_field_group([
		'key' => 'group_pet_product_details',
		'title' => '飼育用品情報・セール監視設定',
		'fields' => [
			[
				'key' => 'field_pet_product_category',
				'label' => 'カテゴリ',
				'name' => 'category',
				'type' => 'select',
				'instructions' => '一覧ページでの表示グループを選択してください（未選択の場合は一覧に表示されません）。',
				'required' => 0,
				'choices' => pet_product_category_choices(),
				'default_value' => '',
				'allow_null' => 1,
				'multiple' => 0,
				'ui' => 0,
				'return_format' => 'value',
			],
			[
				'key' => 'field_pet_product_asin',
				'label' => 'ASIN',
				'name' => 'asin',
				'type' => 'text',
				'instructions' => 'Amazonの10桁のASINコード（例: B08KQTJ8CN）を入力してください。',
				'required' => 0,
				'placeholder' => 'B08KQTJ8CN',
			],
			[
				'key' => 'field_pet_product_moshimo_html',
				'label' => 'もしもアフィリエイトHTML',
				'name' => 'moshimo_html',
				'type' => 'textarea',
				'instructions' => 'もしもアフィリエイトのかんたんリンク等のHTMLコードをそのまま貼り付けてください。',
				'required' => 0,
				'rows' => 6,
				'new_lines' => '',
			],
			[
				'key' => 'field_pet_product_is_on_sale',
				'label' => 'セール中か',
				'name' => 'is_on_sale',
				'type' => 'true_false',
				'instructions' => 'セール監視バッチにより自動更新されます（手動で切り替えることも可能です）。',
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => 'セール中',
				'ui_off_text' => '通常',
			],
			[
				'key' => 'field_pet_product_original_price',
				'label' => '値引き前価格',
				'name' => 'original_price',
				'type' => 'number',
				'instructions' => '自動更新（円）',
				'prepend' => '¥',
				'min' => 0,
				'step' => 1,
			],
			[
				'key' => 'field_pet_product_sale_price',
				'label' => 'セール価格',
				'name' => 'sale_price',
				'type' => 'number',
				'instructions' => '自動更新（円）',
				'prepend' => '¥',
				'min' => 0,
				'step' => 1,
			],
			[
				'key' => 'field_pet_product_discount_percent',
				'label' => '割引率',
				'name' => 'discount_percent',
				'type' => 'number',
				'instructions' => '自動更新（%）',
				'append' => '%',
				'min' => 0,
				'max' => 100,
				'step' => 1,
			],
			[
				'key' => 'field_pet_product_first_sale_detected_at',
				'label' => '初回セール検知日時',
				'name' => 'first_sale_detected_at',
				'type' => 'text',
				'instructions' => '自動更新（ISO8601 / 日時文字列）',
			],
			[
				'key' => 'field_pet_product_sale_ends_at',
				'label' => 'セール終了日時',
				'name' => 'sale_ends_at',
				'type' => 'text',
				'instructions' => '取得できる場合のみ自動更新',
			],
			[
				'key' => 'field_pet_product_last_checked_at',
				'label' => '最終確認日時',
				'name' => 'last_checked_at',
				'type' => 'text',
				'instructions' => '自動更新（最終チェック日時）',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'pet_product',
				],
			],
		],
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'active' => true,
		'show_in_rest' => 1,
	]);
}
add_action('acf/init', 'register_pet_product_acf_fields');
