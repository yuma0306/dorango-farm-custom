<?php

/**
 * 記事ID指定のリンクカード
 * 例: [dorango_article id="4847"]
 */
function dorango_article_card_shortcode($atts) {
	$atts = shortcode_atts(
		['id' => 0],
		$atts,
		'dorango_article'
	);
	$post_id = absint($atts['id']);
	if (!$post_id) {
		return '';
	}
	ob_start();
	get_template_part('include/article-card', null, ['post_id' => $post_id]);
	return (string) ob_get_clean();
}
add_shortcode('dorango_article', 'dorango_article_card_shortcode');
