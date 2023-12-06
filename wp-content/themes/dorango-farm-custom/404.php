<!DOCTYPE html>
<html lang="ja">
<?php get_template_part('include/head'); ?>
<body>
	<?php get_template_part('include/gtm-body'); ?>
	<div class="wrapper">
		<?php get_template_part('include/header'); ?>
		<main class="main">
			<h1 class="heading-lv1-01">
				<span class="heading-lv1-01__text">ページが見つかりません</span>
			</h1>
			<div class="inner inner--small">
				<ul class="breadcrumb">
					<li class="breadcrumb__item">
						<a class="breadcrumb__link" href="/">ホーム</a>
					</li>
					<li class="breadcrumb__item">
						<span class="breadcrumb__text">ページが見つかりません</span>
					</li>
				</ul>
				<p class="affi-note">当サイトはアフェリエイト広告を利用しています。</p>
				<div class="grid-block">
					<p>ページが見つかりません。</p>
					<p>リンクから別のページに遷移、または記事を検索してください。</p>
				</div>
				<form class="search-form js-search-form" action="<?php echo home_url(); ?>" method="get">
					<input class="search-form__input js-search-input" type="text" name="s" value="<?php the_search_query(); ?>" placeholder="例：ボールパイソン">
					<input type="hidden" name="post_type[]" value="breed">
					<input type="hidden" name="post_type[]" value="zoo">
					<input type="hidden" name="post_type[]" value="shop">
					<input type="hidden" name="post_type[]" value="food">
					<input type="hidden" name="post_type[]" value="trivia">
					<input type="hidden" name="post_type[]" value="page">
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
