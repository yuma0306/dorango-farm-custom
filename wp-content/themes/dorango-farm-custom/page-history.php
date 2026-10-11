<?php
	/**
	 * Template Name: 最近チェックした記事
	 */
	$heading = get_the_title();
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
				<span class="heading-lv1-01__text"><?php echo esc_html($heading); ?></span>
			</h1>
			<div class="inner">
				<ul class="breadcrumb">
					<li class="breadcrumb__item">
						<a class="breadcrumb__link" href="/">ホーム</a>
					</li>
					<li class="breadcrumb__item">
						<span class="breadcrumb__text"><?php echo esc_html($heading); ?></span>
					</li>
				</ul>
				<div data-js-history-page>
					<div class="stack">
						<p>記事ページを開くと、この端末のブラウザに最近チェックした記事として保存されます（最大<?php echo RECENT_HISTORY_LIMIT; ?>件）。</p>
						<p>シークレットモード（プライベートブラウズ）では、ブラウザを閉じると履歴が消えてしまいます。通常のブラウザでのご利用をおすすめします。</p>
						<?php get_template_part('include/loading'); ?>
						<div class="grid-block grid-block--col2" data-js-history-list></div>
						<p data-js-history-empty hidden>最近チェックした記事はありません。</p>
					</div>
					<template data-js-history-template>
						<?php get_template_part('include/blogs-item', null, ['post_id' => 0]); ?>
					</template>
					<template data-js-history-thumb-template>
						<picture class="blogs-item__thumb" data-js-blogs-item-thumb>
							<img class="blogs-item__img" data-js-blogs-item-img alt="" width="0" height="0">
						</picture>
					</template>
				</div>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
	<?php wp_footer(); ?>
</body>
</html>
