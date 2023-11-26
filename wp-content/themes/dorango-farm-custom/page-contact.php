<?php
/**
 * Template Name: お問い合わせ
 */

?>
<!DOCTYPE html>
<html lang="ja">
<?php get_template_part('include/head'); ?>
<body>
	<div class="wrapper">
		<?php get_template_part('include/header'); ?>
		<main class="main">
			<h1 class="heading-lv1-01">
				<span class="heading-lv1-01__text">お問い合わせ</span>
			</h1>
			<div class="inner inner--small">
				<?php displayBreadcrumnbs(); ?>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
    <?php wp_footer(); ?>
</body>
</html>
