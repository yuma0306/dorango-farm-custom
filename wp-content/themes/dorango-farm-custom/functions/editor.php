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
 * 許可する Gutenberg ブロック
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
