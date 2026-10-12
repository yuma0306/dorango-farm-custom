<?php
	$ballPythonArchiveUrl = '/tag/species/ball-python/';
	$ballPythonTerm = get_term_by('slug', 'ball-python', 'species');
	if ($ballPythonTerm && !is_wp_error($ballPythonTerm)) {
		$termLink = get_term_link($ballPythonTerm);
		if (!is_wp_error($termLink)) {
			$ballPythonArchiveUrl = $termLink;
		}
	}
?>
<!DOCTYPE html>
<html lang="ja">
<?php get_template_part('include/head'); ?>
<body>
	<?php get_template_part('include/gtm-body'); ?>
	<div class="wrapper" data-js-page-wrapper>
		<?php get_template_part('include/header'); ?>
		<?php get_template_part('include/hamburger'); ?>
		<main class="main u-pt5-pc u-pt5-sp">
			<div class="inner">
				<form class="search-form js-search-form u-m0a" action="<?php echo home_url(); ?>" method="get">
					<input class="search-form__input js-search-input" type="text" name="s" value="" placeholder="キーワード例：ボールパイソン">
					<button type="button" class="search-form__btn js-search-btn" data-gtm-event="<?php echo esc_attr(gtm_event('search_submit')); ?>">
						<span class="search-form__icon" role="img" aria-label="検索"></span>
					</button>
				</form>
				<div class="validate-err js-search-err">
					<div class="validate-err__elm js-search-child">キーワードを入力してください</div>
				</div>
				<p class="u-pt2-pc u-pt2-sp">ヘビ牧場どらんごファームでは、実際に飼育・繁殖した経験をもとに、<span class="u-primary02 u-bold">ボールパイソン</span>を中心に<span class="u-primary02 u-bold">爬虫類の飼育・繁殖、飼育用品、動物園、野生観察</span>について発信するメディアです。</p>
				<?php get_template_part('include/ball-python-hub'); ?>
				<a class="button u-mt3-pc u-mt3-sp" href="<?php echo esc_url($ballPythonArchiveUrl); ?>">ボールパイソンの記事</a>
			</div>
		</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
	<?php wp_footer(); ?>
</body>
</html>
