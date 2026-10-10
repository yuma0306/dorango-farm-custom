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
<body>
	<?php get_template_part('include/gtm-body'); ?>
	<div class="wrapper">
		<?php get_template_part('include/header'); ?>
		<main class="main">
			<h1 class="heading-lv1-01">
				<span class="heading-lv1-01__text"><?php echo esc_html($heading); ?></span>
			</h1>
			<div class="inner inner--small">
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
				<details class="toc">
					<summary class="toc__summary">目次</summary>
					<div class="toc__content">
					<?php echo $tocHtml; ?>
					</div>
				</details>
				<?php get_template_part('include/aff-text'); ?>
				<section class="article-content-v2 wysiwyg-v2">
					<?php the_content(); ?>
				</section>
				<?php get_template_part('include/ball-python-hub'); ?>
				<h2 class="heading-lv2-02">もっと記事を探す</h2>
				<form class="search-form js-search-form" action="<?php echo home_url(); ?>" method="get">
					<input class="search-form__input js-search-input" type="text" name="s" value="<?php the_search_query(); ?>" placeholder="キーワード">
					<input type="hidden" name="post_type[]" value="<?php echo $currentPath; ?>">
					<button type="button" class="search-form__btn js-search-btn">
						<img class="search-form__icon" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-search.svg" alt="検索" width="32" height="32">
					</button>
				</form>
				<div class="validate-err js-search-err">
					<div class="validate-err__elm js-search-child">キーワードを入力してください</div>
				</div>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<?php get_template_part('include/toc-float', null, ['toc_html' => $tocHtml]); ?>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
	<?php wp_footer(); ?>
</body>
</html>
