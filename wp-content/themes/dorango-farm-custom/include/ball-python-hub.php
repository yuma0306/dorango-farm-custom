<?php
if (!is_ball_python_post()) {
	return;
}

$sections = ball_python_hub_sections();
$current_id = (int) get_the_ID();
$post_ids = [];
foreach ($sections as $section) {
	foreach ($section['post_ids'] ?? [] as $post_id) {
		$post_id = absint($post_id);
		if ($post_id && $post_id !== $current_id) {
			$post_ids[] = $post_id;
		}
	}
}
$posts_by_id = ball_python_hub_posts_by_id($post_ids);

$visible = [];
foreach ($sections as $section) {
	$title = (string) ($section['title'] ?? '');
	if ($title === '') {
		continue;
	}
	$ids = [];
	foreach ($section['post_ids'] ?? [] as $post_id) {
		$post_id = absint($post_id);
		if ($post_id && isset($posts_by_id[$post_id])) {
			$ids[] = $post_id;
		}
	}
	if ($ids === []) {
		continue;
	}
	$visible[] = [
		'title' => $title,
		'post_ids' => $ids,
	];
}
if ($visible === []) {
	return;
}
?>
<section>
	<h2 class="heading-lv2-02">ボールパイソンについてもっと詳しく</h2>
	<?php foreach ($visible as $section) : ?>
		<h3 class="heading-lv3-01"><?php echo esc_html($section['title']); ?></h3>
		<div class="grid-block grid-block--col2">
			<?php foreach ($section['post_ids'] as $post_id) : ?>
				<?php get_template_part('include/blogs-item', null, ['post_id' => $post_id]); ?>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
</section>
