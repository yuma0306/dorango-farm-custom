<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
	<?php get_header(); ?>
</head>
<body id="archive">
	<?php get_template_part('assets/parts/header'); ?>
	<?php get_template_part('assets/parts/breadcrumb'); ?>
	<!-- l-wrapper -->
	<div class="l-wrapper">
		<?php get_template_part('assets/parts/post'); ?>
		<?php get_sidebar(); ?>
	</div>
	<!-- /l-wrapper -->
	<?php get_template_part('assets/parts/gnav_sp'); ?>
	<?php get_template_part('assets/parts/menu_sp'); ?>
	<?php get_template_part('assets/parts/footer'); ?>
	<?php get_footer(); ?>
</body>
