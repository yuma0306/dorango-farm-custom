<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
	<?php get_header(); ?>
</head>
<body id="front-page">
	<?php get_template_part('assets/parts/header'); ?>
	<!-- p-flow -->
	<section class="p-flow">
		<div class="p-flow__flow">
			<h1 class="p-flow__ttl">ヘビ牧場どらんごファームではボールパイソンを中心にヘビ飼育・繁殖方法や動物園情報・動物雑学をわかりやすく紹介します。</h1>
		</div>
	</section>
	<!-- /p-flow -->
	<!-- l-wrapper -->
	<div class="l-wrapper">
		<?php get_template_part('assets/parts/post'); ?>
		<?php get_sidebar(); ?>
	</div>
	<!-- /l-wrapper -->
	<?php get_template_part('assets/parts/gnav_sp'); ?>
	<?php get_template_part('assets/parts/footer'); ?>
	<?php get_footer(); ?>
</body>
</html>
