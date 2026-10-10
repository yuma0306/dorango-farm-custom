<?php
$data = ball_python_hub_data();
if ($data === null) {
	return;
}
?>
<section>
	<h2 class="heading-lv2-02">ボールパイソンについて詳しく</h2>
	<?php if ($data['hub_visible']) : ?>
		<div class="grid-block grid-block--col2">
			<?php get_template_part('include/blogs-item', null, ['post_id' => $data['hub_id']]); ?>
		</div>
	<?php endif; ?>
	<?php foreach ($data['visible'] as $section) : ?>
		<h3 class="heading-lv3-01"><?php echo esc_html($section['title']); ?></h3>
		<div class="grid-block grid-block--col2">
			<?php foreach ($section['post_ids'] as $post_id) : ?>
				<?php get_template_part('include/blogs-item', null, ['post_id' => $post_id]); ?>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
</section>
