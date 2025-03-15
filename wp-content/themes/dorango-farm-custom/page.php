<?php
	$heading = get_the_title();
?>
<!DOCTYPE html>
<html lang="ja">
<?php get_template_part('include/head'); ?>
<body>
	<?php get_template_part('include/gtm-body'); ?>
	<div class="wrapper">
		<?php get_template_part('include/header'); ?>
		<main class="main">
			<h1 class="heading-lv1-01">
				<span class="heading-lv1-01__text"><?php echo esc_html($heading); ?></span>
			</h1>
			<div class="inner inner--small">
				<?php displayBreadcrumnbs(); ?>
				<details class="toc">
					<summary class="toc__summary">目次</summary>
					<div class="toc__content">
						<?php createToc(); ?>
					</div>
				</details>
				<?php get_template_part('include/aff-text'); ?>
				<section class="article-content">
					<?php getAcfArticle(); ?>
				</section>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
    <?php wp_footer(); ?>
</body>
</html>
