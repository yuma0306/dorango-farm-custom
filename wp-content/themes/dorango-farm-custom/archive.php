<?php
	$currentUri = getCurrentUri();
	$currentPath = getCurrentPath($currentUri);
	$title = '記事一覧';
	$titlePrefix = [
		"breed" => "飼育繁殖の",
		"zoo" => "動物園の",
		"shop" => "ショップの",
		"food" => "昆虫食の",
		"trivia" => "動物雑学の",
	];
	$resultTitle = isset($titlePrefix[$currentPath]) ? $titlePrefix[$currentPath] . $title : $title;
?>
<!DOCTYPE html>
<html lang="ja">
<?php get_template_part('include/head'); ?>
<body>
	<div class="wrapper">
		<?php get_template_part('include/header'); ?>
		<main class="main">
			<h1 class="heading-lv1-01">
				<span class="heading-lv1-01__text"><?php echo $resultTitle; ?></span>
			</h1>
			<div class="inner">
				<ul class="breadcrumb">
					<li class="breadcrumb__item">
						<a class="breadcrumb__link" href="/">ホーム</a>
					</li>
					<li class="breadcrumb__item">
						<span class="breadcrumb__text"><?php echo $resultTitle; ?></span>
					</li>
				</ul>
				<p class="affi-note">当サイトはアフェリエイト広告を利用しています。</p>
				<div class="grid-block grid-block--col2">
					<?php
						$args = [
							'post_type' => $currentPath,
							'posts_per_page' => get_option('post_per_page'),
							'orderby' => 'modified',
							'order' => 'DESC',
							'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
						];
						$query = new WP_Query($args);
					?>
					<?php if($query->have_posts()): ?>
						<?php while ($query->have_posts()): $query->the_post(); ?>
							<?php get_template_part('include/blogs-item'); ?>
						<?php endwhile; ?>
					<?php endif; ?>
				</div>
				<?php createWpPagination($query); ?>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
    <?php wp_footer(); ?>
</body>
</html>
