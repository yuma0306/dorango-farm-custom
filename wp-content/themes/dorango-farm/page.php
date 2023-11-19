<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
	<?php get_header(); ?>
</head>
<body id="single">
	<?php get_template_part('assets/parts/header'); ?>
	<?php get_template_part('assets/parts/breadcrumb'); ?>
	<!-- l-wrapper -->
	<div class="l-wrapper">
			<!-- l-article -->
			<section class="l-article">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php if(has_post_thumbnail()): ?>
						<div class="l-article__thumb">
							<img loading="lazy" src="<?php the_post_thumbnail_url('full'); ?>">
						</div>
					<?php endif; ?>
					<div class="l-article__inner">
						<h1 class="c-headline1"><?php the_title(); ?></h1>
						<!-- 目次 -->
						<details class="p-acc">
							<summary class="p-acc__ttl">目次</summary>
							<ol class="p-acc__indexes" id="js-indexes"></ol>
						</details>
						<!-- /目次 -->
						<div class="l-article__content" id="js-article-content">
							<?php echo the_content(); ?>
						</div>
					</div>
				<?php endwhile; endif; ?>
			</section>
			<!-- /l-article -->
		<?php get_sidebar(); ?>
	</div>
	<!-- /l-wrapper -->
	<?php get_template_part('assets/parts/gnav_sp'); ?>
	<?php get_template_part('assets/parts/menu_sp'); ?>
	<?php get_template_part('assets/parts/footer'); ?>
	<?php get_footer(); ?>
</body>
