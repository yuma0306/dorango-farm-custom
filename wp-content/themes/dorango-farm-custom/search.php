<?php
	global $wp_query;
	$total = $wp_query->found_posts;
	$searchQuery = get_search_query();
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
				<span class="heading-lv1-01__text">「<?php echo $searchQuery; ?>」の検索結果（<?php echo $total; ?>件）</span>
			</h1>
			<div class="inner inner--small">
				<ul class="breadcrumb">
					<li class="breadcrumb__item">
						<a class="breadcrumb__link" href="/">ホーム</a>
					</li>
					<li class="breadcrumb__item">
						<span class="breadcrumb__text">「<?php echo $searchQuery; ?>」の検索結果（<?php echo $total; ?>件）</span>
					</li>
				</ul>
				<?php get_template_part('include/aff-text'); ?>
				<?php if(have_posts()): ?>
					<div class="grid-block grid-block--col2">
						<?php while (have_posts()): the_post(); ?>
							<?php get_template_part('include/blogs-item'); ?>
						<?php endwhile; ?>
					</div>
				<?php else: ?>
					<div class="grid-block">
						<p>検索結果はありませんでした。別のキーワードで検索してください。</p>
					</div>
					<form class="search-form js-search-form" action="<?php echo home_url(); ?>" method="get">
						<input class="search-form__input js-search-input" type="text" name="s" value="<?php the_search_query(); ?>" placeholder="例：ボールパイソン">
						<input type="hidden" name="post_type[]" value="breed">
						<button type="button" class="search-form__btn js-search-btn">
							<img class="search-form__icon" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-search.svg" alt="検索" width="32" height="32">
						</button>
					</form>
					<div class="validate-err js-search-err">
						<div class="validate-err__elm js-search-child">キーワードを入力してください</div>
					</div>
				<?php endif; ?>
				<?php createPagenation(); ?>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
    <?php wp_footer(); ?>
</body>
</html>
