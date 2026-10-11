<?php
	/**
	 * Template Name: お気に入り
	 */
	$heading = get_the_title();
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
						<span class="breadcrumb__text"><?php echo esc_html($heading); ?></span>
					</li>
				</ul>
				<div data-js-favorite-page>
					<div class="stack">
						<p>作品カードのハートを押すと、この端末のブラウザに保存されます。</p>
						<p>シークレットモード（プライベートブラウズ）では、ブラウザを閉じるとお気に入りが消えてしまいます。通常のブラウザでのご利用をおすすめします。</p>
						<?php get_template_part('include/loading'); ?>
						<div class="grid-block grid-block--col2" data-js-favorite-list></div>
						<p data-js-favorite-empty hidden>お気に入りに登録した記事はありません。</p>
					</div>
					<template data-js-favorite-template>
						<?php get_template_part('include/blogs-item', null, ['post_id' => 0]); ?>
					</template>
					<template data-js-favorite-thumb-template>
						<picture class="blogs-item__thumb" data-js-favorite-thumb>
							<img class="blogs-item__img" data-js-favorite-img alt="" width="0" height="0">
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
