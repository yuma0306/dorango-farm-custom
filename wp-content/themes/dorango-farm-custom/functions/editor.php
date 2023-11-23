<?php

/**
 * エディター画面のカスタマイズ
 * https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#disabling-the-default-block-patterns
 */
function initEditor() {
    remove_theme_support('core-block-patterns');
    remove_post_type_support('page', 'comments');
    remove_post_type_support('page', 'author');
    $postId = $_GET['post'] ?? $_POST['post_ID'] ?? null;
    if(!isset($postId)) return;
    $templateFile = get_post_meta($postId, '_wp_page_template', true);
    $templates = [
        'page-tag.php',
		'default',
		'',
    ];
    if(in_array($templateFile, $templates)) {
        remove_post_type_support('page', 'editor');
    }
}
add_action('init', 'initEditor');

/**
 * グーテンベルクの制御
 * https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/#hiding-blocks-from-the-inserter
 */
function customBlockTypes($allowed_blocks, $post) {
    // Allow block type
    return [
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/list-item',
        'core/table',
        'core/images',
        'core/columns',
        'core/shortcode',
        'core/html',
    ];
}
add_filter('allowed_block_types_all', 'customBlockTypes', 10, 10);

/**
 * リッチエディターへの機能追加
 * https://celtislab.net/archives/20200319/wordpress-richtext-toolbar-button/
 * https://ja.wordpress.org/team/handbook/block-editor/reference-guides/richtext/
 * https://ja.wordpress.org/team/handbook/block-editor/how-to-guides/format-api/
 * ▼devツールのconsoleから実行
 * wp.data.select( 'core/rich-text' ).getFormatTypes();
 */
function customRichtext() {
    if(is_admin()){
        wp_enqueue_style(
            'gutenberg-richtext-style',
            get_stylesheet_directory_uri() . '/gutenberg/gutenberg.css',
        );
        wp_enqueue_script(
            'gutenberg-richtext-js',
            get_stylesheet_directory_uri() . '/gutenberg/gutenberg.js',
            array('lodash', 'wp-rich-text', 'wp-element', 'wp-components', 'wp-blocks', 'wp-block-editor', 'wp-keycodes'),
            null,
            true,
        );
    }
}

add_action('enqueue_block_editor_assets', 'customRichtext');
add_action('wp_enqueue_scripts', 'customRichtext');
