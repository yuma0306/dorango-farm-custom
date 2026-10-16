<?php
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
				'key' => 'field_pet_product_related_posts',
				'label' => '関連記事',
				'name' => 'related_posts',
				'type' => 'relationship',
				'instructions' => 'この商品に関連する飼育記事・解説記事を選択してください。',
				'required' => 0,
				'post_type' => [
					'post',
					'breed',
					'zoo',
					'shop',
					'food',
					'trivia',
				],
				'filters' => [
					'search',
					'post_type',
					'taxonomy',
				],
				'return_format' => 'id',
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

