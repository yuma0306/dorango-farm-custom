<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
	<?php get_header(); ?>
</head>
<body id="notfound">
	<?php get_template_part('assets/parts/header'); ?>
	<?php get_template_part('assets/parts/breadcrumb'); ?>
	<!-- l-wrapper -->
	<div class="l-wrapper">
		<section class="p-notfound">
			<div class="p-notfound__inner">
				<div class="c-headline">
					<div class="c-headline__icon">
						<span class="dashicons dashicons-buddicons-replies c-headline__insect"></span>
					</div>
					<h1 class="c-headline__txt">お探しのページが見つかりませんでした。</h1>
				</div>
			</div>
		</section>
		<?php get_sidebar(); ?>
	</div>
	<!-- /l-wrapper -->
	<?php get_template_part('assets/parts/gnav_sp'); ?>
	<?php get_template_part('assets/parts/menu_sp'); ?>
	<?php get_template_part('assets/parts/footer'); ?>
	<?php get_footer(); ?>
</body>
