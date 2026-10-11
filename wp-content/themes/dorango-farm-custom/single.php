<?php
	$heading = get_the_title();
	$thumb = get_article_thumb();
	$currentUri = get_current_uri();
	$currentPath = getCurrentPath($currentUri);
	$publishedDate = get_the_date('Y-m-d');
	$modifiedDate = get_the_modified_time('Y-m-d');
	$postPrefix = [
		"breed" => "飼育繁殖の",
		"zoo" => "アニマルスポットの",
		"shop" => "ショップの",
		"food" => "昆虫食の",
		"trivia" => "動物雑学の",
	];
	$postType = isset($postPrefix[$currentPath]) ? $postPrefix[$currentPath] : '';
	ob_start();
	createToc();
	$tocHtml = ob_get_clean();
?>
<!DOCTYPE html>
<html lang="ja">
<?php get_template_part('include/head'); ?>
<body class="has-floating-bar">
	<?php get_template_part('include/gtm-body'); ?>
	<div class="wrapper">
		<?php get_template_part('include/header'); ?>
		<?php get_template_part('include/hamburger'); ?>
		<main class="main">
			<h1 class="heading-lv1-01">
				<span class="heading-lv1-01__text"><?php echo esc_html($heading); ?></span>
			</h1>
			<div class="inner">
				<ul class="breadcrumb">
					<li class="breadcrumb__item">
						<a class="breadcrumb__link" href="/">ホーム</a>
					</li>
					<li class="breadcrumb__item">
						<a class="breadcrumb__link" href="/<?php echo $currentPath; ?>/"><?php echo $postType; ?>記事一覧</a>
					</li>
					<li class="breadcrumb__item">
						<span class="breadcrumb__text"><?php echo esc_html($heading); ?></span>
					</li>
				</ul>
				<?php if(!empty($thumb)): ?>
				<picture class="article-thumb">
					<img class="article-thumb__img" src="<?php echo esc_url($thumb['url']); ?>" alt="<?php echo esc_html($thumb['alt']); ?>" width="<?php echo esc_html($thumb['width']); ?>" height="<?php echo esc_html($thumb['height']); ?>">
				</picture>
				<?php endif; ?>
				<div class="article-date">
					<span class="article-date__item"><span class="article-date__icon article-date__icon--pencil" role="img" aria-label="投稿日"></span><time class="article-date__text" datetime="<?php echo esc_html($publishedDate); ?>"><?php echo esc_html($publishedDate); ?></time></span>
					<span class="article-date__item"><span class="article-date__icon article-date__icon--update" role="img" aria-label="更新日"></span><time class="article-date__text" datetime="<?php echo esc_html($modifiedDate); ?>"><?php echo esc_html($modifiedDate); ?></time></span>
				</div>
				<?php if (str_contains($tocHtml, 'toc__link')) : ?>
					<details class="toc">
						<summary class="toc__summary">目次</summary>
						<div class="toc__content">
							<?php echo $tocHtml; ?>
						</div>
					</details>
				<?php endif; ?>
				<?php get_template_part('include/aff-text'); ?>
				<section class="article-content-v2 wysiwyg-v2">
					<?php the_content(); ?>
				</section>
				<?php if (is_ball_python_post()) : ?>
					<?php get_template_part('include/ball-python-hub', null, ['exclude_id' => get_the_ID()]); ?>
				<?php endif; ?>
				<?php get_template_part('include/recent-posts', null, ['post_id' => get_the_ID()]); ?>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<?php get_template_part('include/toc-float', null, ['toc_html' => $tocHtml]); ?>
	<?php get_template_part('include/search-float', null, ['post_type' => $currentPath]); ?>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
	<?php wp_footer(); ?>
	<?php get_template_part('include/floating-bar', null, [
		'post_id' => get_the_ID(),
		'has_toc' => str_contains($tocHtml, 'toc__link'),
	]); ?>
</body>
</html>
