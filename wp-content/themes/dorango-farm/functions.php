<?php
//アイキャッチ画像を設定可能に
add_theme_support('post-thumbnails');

// デフォルトjqueryを削除
function delete_jquery() {
	if (!is_admin()) {
		wp_deregister_script('jquery');
	}
}
add_action('init', 'delete_jquery');

//author情報からユーザー名の特定防止
function disableAuthorArchiveQuery() {
if( preg_match('/author=([0-9]*)/i', $_SERVER['QUERY_STRING']) ){
	wp_redirect( home_url() );
	exit;
	}
}
add_action('init', 'disableAuthorArchiveQuery');

//WordPress REST API によるユーザー情報特定防止
function filterRestEndpoints( $endpoints ) {
	if ( isset( $endpoints['/wp/v2/users'] ) ) {
	unset( $endpoints['/wp/v2/users'] );
	}
	if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
	unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $endpoints;
	}
add_filter( 'rest_endpoints', 'filterRestEndpoints', 10, 1 );

// Load Dashicons
function load_dashicons() {
	wp_enqueue_style('dashicons');
	}
add_action('wp_enqueue_scripts', 'load_dashicons');


/*
* サイトマップxml作成
* リライトルールの書き替え
*/
function my_rewrite_rules_array($rules) {
// sitemap.xml へのアクセス時にURLをリライト
$new_rules["^sitemap\.xml$"] = "index.php?feed=sitemap";
return $new_rules + $rules;
}
add_action('rewrite_rules_array', 'my_rewrite_rules_array', 10, 1);
/* do_feed_sitemap
* サイトマップ用のfeedテンプレートのロード
*/
function my_do_feed_sitemap() {
load_template(get_template_directory() . '/make-sitemap.php');
}
add_action('do_feed_sitemap', 'my_do_feed_sitemap');

/**
 * FILTER HOOK : redirect_canonical
 * sitemap.xml へのアクセス時に末尾にスラッシュをつけない
 */
function removeSitemapTrailingslash( $redirect_url, $requested_url ) {
	if ( 'sitemap' == get_query_var( 'feed' ) ) {
		return $requested_url;
	}
	return $redirect_url;
}
add_filter( 'redirect_canonical', 'removeSitemapTrailingslash', 1, 2 );

// pagination
function custom_the_posts_pagination( $template ) {
	$template = '
	<nav class="p-pagination %1$s" role="navigation">
		<div class="p-pagination__inner">%3$s</div>
	</nav>';
	return $template;
}
add_filter( 'navigation_markup_template', 'custom_the_posts_pagination' );

// 埋め込み用デフォルト機能のカスタマイズ
locate_template('functions/embed-config.php', true);

locate_template('functions/editor-config.php', true);
?>
