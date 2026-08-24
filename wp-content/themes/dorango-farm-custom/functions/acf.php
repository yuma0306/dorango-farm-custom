<?php
/**
 * ACF フィールド（テーマ側で登録）
 */

function dorango_register_acf_fields() {
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	$locations = [];
	foreach (['breed', 'zoo', 'shop', 'food', 'trivia', 'page'] as $post_type) {
		$locations[] = [[
			'param' => 'post_type',
			'operator' => '==',
			'value' => $post_type,
		]];
	}

	acf_add_local_field_group([
		'key' => 'group_dorango_display',
		'title' => '表示方式',
		'fields' => [
			[
				'key' => 'field_use_gutenberg',
				'label' => '新しい編集方式（ブロック）で表示する',
				'name' => 'use_gutenberg_field',
				'type' => 'true_false',
				'instructions' => 'オンにすると Gutenberg の本文とアイキャッチ画像を表示します。オフのときは従来の Flexible Content とサムネイル欄を表示します。',
				'required' => 0,
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => 'ブロック',
				'ui_off_text' => '従来',
			],
		],
		'location' => $locations,
		'position' => 'side',
		'style' => 'default',
		'label_placement' => 'top',
		'menu_order' => 0,
	]);
}
add_action('acf/init', 'dorango_register_acf_fields');

function dorango_skip_required_thumb_for_gutenberg($valid, $value, $field, $input) {
	if ($valid === true) {
		return $valid;
	}
	$use_gutenberg = !empty($_POST['acf']['field_use_gutenberg']);
	if ($use_gutenberg) {
		return true;
	}
	return $valid;
}
add_filter('acf/validate_value/name=thumb_field', 'dorango_skip_required_thumb_for_gutenberg', 10, 4);
