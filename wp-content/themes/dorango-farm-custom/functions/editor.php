<?php

/**
 * エディター画面のカスタマイズ
 * https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#disabling-the-default-block-patterns
 */
function init_editor() {
    remove_theme_support('core-block-patterns');
    remove_post_type_support('page', 'comments');
    remove_post_type_support('page', 'author');
    $postId = $_GET['post'] ?? $_POST['post_ID'] ?? null;
    if(!isset($postId)) return;
    $templateFile = get_post_meta($postId, '_wp_page_template', true);
    $templates = [
		'page-thanks.php',
        'page-tag.php',
		'page-lp.php',
    ];
    if(in_array($templateFile, $templates)) {
        remove_post_type_support('page', 'editor');
    }
}
add_action('init', 'init_editor');

/**
 * グーテンベルクの制御
 * https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#hiding-blocks-from-the-inserter
 */
function custom_block_types($allowed_blocks, $editor_context) {
    return [
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/list-item',
        'core/image',
        'core/quote',
        'core/embed',
        'core/html',
        'core/shortcode',
    ];
}
add_filter('allowed_block_types_all', 'custom_block_types', 10, 2);

/**
 * リッチエディターへの機能追加
 * https://celtislab.net/archives/20200319/wordpress-richtext-toolbar-button/
 * https://ja.wordpress.org/team/handbook/block-editor/reference-guides/richtext/
 * https://ja.wordpress.org/team/handbook/block-editor/how-to-guides/format-api/
 * ▼devツールのconsoleから実行
 * wp.data.select( 'core/rich-text' ).getFormatTypes();
 */
// function customRichtext() {
//     if(is_admin()){
//         wp_enqueue_style(
//             'gutenberg-richtext-style',
//             get_template_directory_uri() . '/gutenberg/gutenberg.css',
//         );
//         wp_enqueue_script(
//             'gutenberg-richtext-js',
//             get_template_directory_uri() . '/gutenberg/gutenberg.js',
//             array('lodash', 'wp-rich-text', 'wp-element', 'wp-components', 'wp-blocks', 'wp-block-editor', 'wp-keycodes'),
//             null,
//             true,
//         );
//     }
// }
// add_action('enqueue_block_editor_assets', 'customRichtext');
// add_action('admin_enqueue_scripts', 'customRichtext');

/**
 * 【ACF】wysiwygエディターの追加
 * https://www.advancedcustomfields.com/resources/customize-the-wysiwyg-toolbars/
 */
function add_original_wysiwyg_editor($toolbars) {
    $toolbars['original_toolbars'] = [];
    $toolbars['original_toolbars'][1] = [
		// 太字
		'bold',
		// 番号なしリスト
		'bullist',
		// 番号付きリスト
		'numlist',
		// 引用
		'blockquote',
		// 左寄せ
		'alignleft',
		// 中央揃え
		'aligncenter',
		// 右寄せ
		'alignright',
		// リンクの挿入と編集
		'link',
		// リンクの削除
		'unlink',
		// テキスト色
		'forecolor',
		// オリジナル
		'marker',
		'removeMarker',
		// フォントサイズ
		'fontsizeselect',
	];
	// $toolbars['original_toolbars'][2] = [ ];
    return $toolbars;
}
add_filter('acf/fields/wysiwyg/toolbars', 'add_original_wysiwyg_editor');

/**
 * 【TinyMCE】フォントサイズカスタマイズ
 */
function custom_tiny_mce_font_sizes($init) {
    $init['fontsize_formats'] = '13px 15px 17px 20px 22px';
    return $init;
}
add_filter('tiny_mce_before_init', 'custom_tiny_mce_font_sizes');

/**
 * 【TinyMCE】カレーパレットカスタマイズ
 * https://www.advancedcustomfields.com/resources/customize-the-wysiwyg-toolbars/
 */
function custom_tiny_mce_colors($init) {
	$default_colors = '
		"333333", "TextBlack",
		"FFFFFF", "white"
	';
	$custom_colors = '
		"E1AA3C", "Primary01",
		"FA8501", "Primary02"
	';
	$init['textcolor_map'] = '[' . $default_colors . ',' . $custom_colors . ']';
	// 行数設定
	// $init['textcolor_rows'] = 6;
	return $init;
}
add_filter('tiny_mce_before_init', 'custom_tiny_mce_colors');

/**
 * クラシックブロックで script を残す（もしもかんたんリンク用）
 */
function dorango_tinymce_allow_script($init) {
	$existing = $init['extended_valid_elements'] ?? '';
	$allow = 'script[type|src|id|charset|async|defer],div[id|class|style]';
	$init['extended_valid_elements'] = $existing !== '' ? $existing . ',' . $allow : $allow;
	return $init;
}
add_filter('tiny_mce_before_init', 'dorango_tinymce_allow_script');

/**
 * Gutenberg が script を外したもしもコードを復元する
 */
function dorango_restore_moshimo_scripts($content) {
	if (!is_string($content) || $content === '') {
		return $content;
	}
	return preg_replace_callback(
		'/<!--\s*START MoshimoAffiliateEasyLink\s*-->(.*?)<!--\s*MoshimoAffiliateEasyLink END\s*-->/s',
		function ($matches) {
			$inner = $matches[1];
			if (stripos($inner, '<script') !== false) {
				return $matches[0];
			}
			$div = '';
			if (preg_match('/(<div\b.*?<\/div>)/is', $inner, $div_match)) {
				$div = $div_match[1];
				$inner = str_replace($div_match[1], '', $inner);
			}
			$js = trim($inner);
			if ($js === '') {
				return $matches[0];
			}
			return '<!-- START MoshimoAffiliateEasyLink --><script type="text/javascript">' . $js . '</script>' . $div . '<!-- MoshimoAffiliateEasyLink END -->';
		},
		$content
	);
}
add_filter('the_content', 'dorango_restore_moshimo_scripts', 8);

/**
 * カスタムTinyMCEボタン用のスクリプトを読み込む
 */
function enqueue_tinymce_marker_script() {
    wp_enqueue_script('tinymce-marker', get_stylesheet_directory_uri() . '/assets/js/tinymce-button.js', array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'enqueue_tinymce_marker_script');

/**
 * カスタムTinyMCEボタンを追加する
 */
function add_tinymce_marker_button($buttons) {
    array_push($buttons, 'marker');
    return $buttons;
}
add_filter('mce_buttons', 'add_tinymce_marker_button');

/**
 * カスタムTinyMCEボタンのプラグインを追加する
 */
function add_tinymce_marker_plugin($plugins) {
    $plugins['marker'] = get_stylesheet_directory_uri() . '/assets/js/tinymce-button.js';
    return $plugins;
}
add_filter('mce_external_plugins', 'add_tinymce_marker_plugin');
