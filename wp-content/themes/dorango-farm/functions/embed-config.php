<?php
// 埋め込み用ダイアログ削除
remove_action( 'embed_footer', 'print_embed_sharing_dialog' );
// 埋め込み用デフォルトcss削除
remove_action( 'embed_head', 'print_embed_styles' );
// オリジナルのcss読み込み
function loadEmbedCss() {
	wp_enqueue_style( 'wp-oembed-embed', '/wp-content/themes/dorango-farm/assets/css/wp-embed.css' );
}
add_action( 'embed_head', 'loadEmbedCss' );
?>
