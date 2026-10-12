<?php
/**
 * Template Name: 飼育セット診断
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
				<?php get_template_part('include/aff-text'); ?>
				<?php get_template_part('include/set-diagnosis'); ?>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/js/common.js" defer></script>
	<script type="module" src="<?php echo esc_url(dorango_set_diagnosis_uri()); ?>"></script>
	<?php wp_footer(); ?>
</body>
</html>
