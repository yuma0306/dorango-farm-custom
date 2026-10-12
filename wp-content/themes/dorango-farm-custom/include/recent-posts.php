<?php
$post_id = absint(($args ?? [])['post_id'] ?? 0);
if ($post_id <= 0) {
	return;
}
?>
<section class="stack" data-js-recent-posts data-post-id="<?php echo esc_attr((string) $post_id); ?>" hidden>
	<h2 class="heading-lv2-02">最近チェックした記事</h2>
	<?php get_template_part('include/loading'); ?>
	<div class="grid-block grid-block--col2" data-js-recent-posts-list></div>
	<template data-js-recent-posts-template>
		<?php get_template_part('include/blogs-item', null, ['post_id' => 0]); ?>
	</template>
	<template data-js-recent-posts-thumb-template>
		<picture class="blogs-item__thumb" data-js-blogs-item-thumb>
			<img class="blogs-item__img" data-js-blogs-item-img alt="" width="0" height="0">
		</picture>
	</template>
</section>
