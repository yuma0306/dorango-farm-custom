<?php
/*
Template Name: タグ一覧ページ
*/
?>
<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
	<?php get_header(); ?>
</head>
<body id="page-tag">
	<?php get_template_part('assets/parts/header'); ?>
	<?php get_template_part('assets/parts/breadcrumb'); ?>
	<!-- l-wrapper -->
	<div class="l-wrapper">
		<!-- p-tag -->
		<section class="p-tag">
			<div class="p-tag__inner">
				<div class="c-headline">
					<div class="c-headline__icon">
						<span class="dashicons dashicons-buddicons-replies c-headline__insect"></span>
					</div>
					<h1 class="c-headline__txt">タグ一覧</h1>
				</div>
				<p class="p-tag__txt">タグを選択して、記事を絞り込むことができます。</p>
				<ul class="p-tag__list">
				<?php foreach ($tags = get_tags() as $tag): ?>
					<li class="p-tag__item">
						<a class="c-tag c-tag--navy" href="<?php echo esc_attr(get_tag_link($tag->term_id)); ?>"><?php echo esc_html($tag->name); ?></a>
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
		</section>
		<!-- /p-tag -->
		<?php get_sidebar(); ?>
	</div>
	<!-- /l-wrapper -->
	<?php get_template_part('assets/parts/gnav_sp'); ?>
	<?php get_template_part('assets/parts/menu_sp'); ?>
	<?php get_template_part('assets/parts/footer'); ?>
	<?php get_footer(); ?>
</body>
