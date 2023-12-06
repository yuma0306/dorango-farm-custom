<?php
/**
 * Template Name: タグ一覧
 */

$taxonomies = ['goods', 'method', 'species', 'morph', 'diseases', 'cross'];

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
				<span class="heading-lv1-01__text">タグ一覧</span>
			</h1>
			<div class="inner inner--small">
				<?php displayBreadcrumnbs(); ?>
				<?php foreach($taxonomies as $taxonomy): ?>
					<?php
						$terms = get_terms([
							'taxonomy' => $taxonomy,
							'hide_empty' => true,
						]);
					?>
					<?php if(!empty($terms)): ?>
						<div class="tag-list">
							<h2 class="heading-lv2-02"><?php echo esc_html(get_taxonomy($taxonomy)->label); ?></h2>
							<div class="tag-list__block tag-list__block--wrap">
								<?php foreach ($terms as $term): ?>
									<?php $termLink = get_term_link($term); ?>
									<a class="tag" href="<?php echo esc_url($termLink); ?>">
										<?php echo esc_html($term->name); ?>
									</a>
								<?php endforeach; ?>
							</div>
						</div>
					<?php endif; ?>
				<?php endforeach; ?>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
    <?php wp_footer(); ?>
</body>
</html>
