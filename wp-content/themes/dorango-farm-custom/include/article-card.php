<?php
/**
 * @var array $args
 */
$post_id = isset($args['post_id']) ? absint($args['post_id']) : 0;
if (!$post_id) {
	return;
}
$post = get_post($post_id);
if (!$post || $post->post_status !== 'publish') {
	return;
}
$title = get_the_title($post_id);
$thumb = get_article_thumb($post_id);
?>
<a class="article-card" href="<?php echo esc_url(get_permalink($post_id)); ?>">
	<?php if (!empty($thumb)) : ?>
		<img
			class="article-card__img"
			src="<?php echo esc_url($thumb['url']); ?>"
			alt="<?php echo esc_attr($thumb['alt'] ?: $title); ?>"
			width="<?php echo esc_attr($thumb['width']); ?>"
			height="<?php echo esc_attr($thumb['height']); ?>"
		>
	<?php endif; ?>
	<span class="article-card__title"><?php echo esc_html($title); ?></span>
</a>
