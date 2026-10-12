<?php
/**
 * Template Name: ボールパイソン飼育セット診断
 * Slug: ballpython-setup-shindan
 */
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
					<?php get_template_part('include/aff-text'); ?>
					<?php get_template_part('include/ballpython-setup-shindan'); ?>
				</div>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/js/common.js" defer></script>
	<?php wp_footer(); ?>
</body>
</html>
