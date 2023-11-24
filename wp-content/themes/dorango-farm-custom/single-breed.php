<?php
	$heading = get_the_title();
	$thumb = get_field('thumb_field');
	$currentUri = getCurrentUri();
	$currentPath = getCurrentPath($currentUri);
	$modifiedDate = get_the_modified_time('Y-m-d');
	$articleID = get_the_ID();
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
						<a class="breadcrumb__link" href="/<?php echo $currentPath; ?>/">飼育繁殖</a>
					</li>
					<li class="breadcrumb__item">
						<span class="breadcrumb__text"><?php echo esc_html($heading); ?></span>
					</li>
				</ul>
				<picture class="article-thumb">
					<img class="article-thumb__img" src="<?php echo esc_url($thumb['url']); ?>" alt="<?php echo esc_html($thumb['alt']); ?>">
				</picture>
				<div class="article-date">
					<img class="article-date__img" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-pen.svg" alt="">
					<time class="article-date__text" datetime="<?php echo esc_html($modifiedDate); ?>"><?php echo esc_html($modifiedDate); ?></time>
				</div>
				<details class="toc">
					<summary class="toc__summary">目次</summary>
					<div class="toc__content" id="js-toc"></div>
				</details>
				<p class="affi-note">当サイトはアフェリエイト広告を利用しています。</p>
				<section class="article-content" id="js-article">
					<?php getAcfArticle(); ?>
				</section>
				<?php if(!empty($breedTagList)): ?>
					<h2 class="heading-lv2-02">関連タグ</h2>
					<div class="">
						<?php foreach($breedTagList as $key => $breedTagItem): if(!empty($breedTagItem)): ?>
							<dl>
								<dt>
									<?php echo esc_html($breedTagTerms[$key]); ?>
								</dt>
								<dd>
									<ul class="tag">
										<?php foreach($breedTagItem as $breedTag): if(!empty($breedTag)):?>
											<?php $tagLink = get_term_link($breedTag); ?>
											<?php if(!is_wp_error($tagLink)): ?>
												<li class="tag__item">
													<a class="tag__link" href="<?php echo esc_url($tagLink); ?>">
														<?php echo esc_html($breedTag->name); ?>
													</a>
												</li>
											<?php endif; ?>
										<?php endif; endforeach; ?>
									</ul>
								</dd>
							</dl>
						<?php endif; endforeach; ?>
					</div>
				<?php endif; ?>
				<h2 class="heading-lv2-02">「飼育繁殖」のカテゴリー・キーワード検索</h2>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
    <?php wp_footer(); ?>
</body>
</html>
