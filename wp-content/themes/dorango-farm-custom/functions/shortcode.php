<?php

/**
 * 記事ID指定のリンクカード（blogs-item）
 * 例: [article id="4847"]
 */
function article_card_shortcode($atts) {
	$atts = shortcode_atts(
		['id' => 0],
		$atts,
		'article'
	);
	$post_id = absint($atts['id']);
	if (!$post_id || get_post_status($post_id) !== 'publish') {
		return '';
	}
	ob_start();
	get_template_part('include/blogs-item', null, ['post_id' => $post_id]);
	return (string) ob_get_clean();
}
add_shortcode('article', 'article_card_shortcode');

/**
 * 飼育用品一覧ショートコード
 * [reptile_products type="sale"]
 * [reptile_products type="recommended"]
 */
function reptile_products_shortcode($atts) {
	$atts = shortcode_atts(
		[
			'type' => 'recommended',
		],
		$atts,
		'reptile_products'
	);

	$type = $atts['type'] === 'sale' ? 'sale' : 'recommended';

	$meta_query =
		$type === 'sale'
			? [
					[
						'key' => 'is_on_sale',
						'value' => '1',
						'compare' => '=',
					],
				]
			: [
					'relation' => 'OR',
					[
						'key' => 'is_on_sale',
						'value' => '1',
						'compare' => '!=',
					],
					[
						'key' => 'is_on_sale',
						'compare' => 'NOT EXISTS',
					],
				];

	$query = new WP_Query([
		'post_type' => 'pet_product',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'meta_query' => $meta_query,
		'orderby' => ['menu_order' => 'ASC', 'ID' => 'ASC'],
	]);

	ob_start();
	get_template_part('include/reptile-products', null, [
		'type' => $type,
		'posts' => $query->posts,
	]);
	wp_reset_postdata();

	return (string) ob_get_clean();
}
add_shortcode('reptile_products', 'reptile_products_shortcode');

