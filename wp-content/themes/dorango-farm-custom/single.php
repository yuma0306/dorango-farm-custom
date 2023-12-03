<?php
	$heading = get_the_title();
	$thumb = get_field('thumb_field');
	$currentUri = getCurrentUri();
	$currentPath = getCurrentPath($currentUri);
	$modifiedDate = get_the_modified_time('Y-m-d');
	$postPrefix = [
		"breed" => "飼育繁殖の",
		"zoo" => "動物園の",
		"shop" => "ショップの",
		"food" => "昆虫食の",
		"trivia" => "動物雑学の",
	];
	$postType = isset($postPrefix[$currentPath]) ? $postPrefix[$currentPath] : '';
	// breedのみタグ表示
	if($currentPath === 'breed') {
		$articleID = get_the_ID();
		$taxonomies = ['goods', 'method', 'species', 'morph', 'diseases', 'cross'];
		$breedTaxonomyList = [
			'goods' => '飼育用品',
			'method' => '飼育法',
			'species' => '種',
			'morph' => 'モルフ',
			'diseases' => '病気',
			'cross' => '繁殖',
		];
		$breedTagList = [];
		$breedTagTerms = [];
		foreach ($breedTaxonomyList as $breedTaxonomyKey => $breedTaxonomyItem) {
			$breedTagList[] = get_the_terms($articleID, $breedTaxonomyKey);
			$breedTagTerms[] = $breedTaxonomyItem;
		}
	}
?>
<!DOCTYPE html>
<html lang="ja">
<?php get_template_part('include/head'); ?>
<body>
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
				<picture class="article-thumb">
					<img class="article-thumb__img" src="<?php echo esc_url($thumb['url']); ?>" alt="<?php echo esc_html($thumb['alt']); ?>" width="<?php echo esc_html($thumb['width']); ?>" height="<?php echo esc_html($thumb['height']); ?>">
				</picture>
				<div class="article-date">
					<img class="article-date__img" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-pen.svg" alt="">
					<time class="article-date__text" datetime="<?php echo esc_html($modifiedDate); ?>"><?php echo esc_html($modifiedDate); ?></time>
				</div>
				<details class="toc">
					<summary class="toc__summary">目次</summary>
					<div class="toc__content">
					<?php createToc(); ?>
					</div>
				</details>
				<p class="affi-note">当サイトはアフェリエイト広告を利用しています。</p>
				<section class="article-content" id="js-article">
					<?php getAcfArticle(); ?>
				</section>
				<h2 class="heading-lv2-02">もっと記事を探す</h2>
				<?php if(!empty($breedTagList)): ?>
					<h3 class="heading-lv3-01">この記事の関連タグ</h3>
					<div class="grid-block">
						<?php foreach($breedTagList as $key => $breedTagItem): if(!empty($breedTagItem)): ?>
							<dl class="tag-list">
								<dt class="tag-list__term">
									<?php echo esc_html($breedTagTerms[$key]); ?>
								</dt>
								<dd class="tag-list__desc">
									<div class="tag-list__block">
										<?php foreach($breedTagItem as $breedTag): if(!empty($breedTag)):?>
											<?php $tagLink = get_term_link($breedTag); ?>
											<?php if(!is_wp_error($tagLink)): ?>
												<a class="tag" href="<?php echo esc_url($tagLink); ?>">
													<?php echo esc_html($breedTag->name); ?>
												</a>
											<?php endif; ?>
										<?php endif; endforeach; ?>
									</div>
								</dd>
							</dl>
						<?php endif; endforeach; ?>
					</div>
					<a href="/tag/" class="btn-link01 u-ml0-pc">タグ一覧</a>
				<?php endif; ?>
				<h3 class="heading-lv3-01"><?php echo $postType; ?>記事を検索</h3>
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
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
    <?php wp_footer(); ?>
</body>
</html>
