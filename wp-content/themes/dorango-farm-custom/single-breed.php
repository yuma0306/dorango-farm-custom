<!DOCTYPE html>
<html lang="ja">
<?php get_template_part('include/head'); ?>
<body>
	<div class="wrapper">
		<?php get_template_part('include/header'); ?>
		<?php getAcfContent(); ?>
		<?php get_template_part('include/footer'); ?>
	</div>
    <?php wp_footer(); ?>
</body>
</html>
