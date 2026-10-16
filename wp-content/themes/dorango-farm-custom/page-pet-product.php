<?php
	/**
	 * Template Name: おすすめ飼育用品・セール一覧
	 * Slug: pet-product
	 */
	$thumb = get_article_thumb();
?>
<!DOCTYPE html>
<html lang="ja">
<?php get_template_part('include/head'); ?>
<body>
	<?php get_template_part('include/gtm-body'); ?>
	<div class="wrapper" data-js-page-wrapper>
		<?php get_template_part('include/header'); ?>
		<?php get_template_part('include/hamburger'); ?>
		<main class="main">
			<h1 class="heading-lv1-01">
				<span class="heading-lv1-01__text"><?php the_title(); ?></span>
			</h1>
			<div class="inner">
				<?php displayBreadcrumnbs(); ?>
				<div class="stack">
					<?php if (!empty($thumb)) : ?>
						<picture class="article-thumb">
							<img class="article-thumb__img" src="<?php echo esc_url($thumb['url']); ?>" alt="<?php echo esc_html($thumb['alt']); ?>" width="<?php echo esc_html($thumb['width']); ?>" height="<?php echo esc_html($thumb['height']); ?>">
						</picture>
					<?php endif; ?>
					<?php get_template_part('include/aff-text'); ?>
					<?php if (trim(wp_strip_all_tags(get_the_content())) !== '') : ?>
						<section class="article-content-v2 wysiwyg-v2">
							<?php the_content(); ?>
						</section>
					<?php endif; ?>
					<?php get_template_part('include/pet-product'); ?>
				</div>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/js/common.js" defer></script>
	<?php wp_footer(); ?>
</body>
</html>
