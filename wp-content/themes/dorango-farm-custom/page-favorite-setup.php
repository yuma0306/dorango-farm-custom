<?php
/**
 * Template Name: お気に入り飼育セット一覧
 * Slug: favorite-setup
 */
$thumb = get_article_thumb();
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
				<span class="heading-lv1-01__text"><?php the_title(); ?></span>
			</h1>
			<div class="inner">
				<?php displayBreadcrumnbs(); ?>
				<div class="stack" data-js-favorite-setup-index>
					<?php if (!empty($thumb)) : ?>
						<picture class="article-thumb">
							<img class="article-thumb__img" src="<?php echo esc_url($thumb['url']); ?>" alt="<?php echo esc_html($thumb['alt']); ?>" width="<?php echo esc_html($thumb['width']); ?>" height="<?php echo esc_html($thumb['height']); ?>">
						</picture>
					<?php endif; ?>
					<?php get_template_part('include/aff-text'); ?>
					<p>お気に入り登録した飼育セット一覧が確認できます。</p>
					<p>シークレットモード（プライベートブラウズ）では、ブラウザを閉じるとお気に入りが消えてしまいます。通常のブラウザでのご利用をおすすめします。</p>
					<div class="grid-panel" data-js-favorite-setup-index-list style="display: none">
						<a
							class="panel-link"
							href="<?php echo esc_url(home_url('/favorite-setup/ballpython-setup/')); ?>"
							data-js-favorite-setup-index-item="ballpython-setup"
							style="display: none"
						>
							<img
								class="panel-link__img"
								src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/img-ballpython-panel.webp'); ?>"
								alt="ボールパイソンの飼育セット"
							>
							<span class="panel-link__body">
								<span class="panel-link__en">BALL PYTHON</span>
								<span class="panel-link__ja">ボールパイソン</span>
							</span>
						</a>
					</div>
					<div class="stack" data-js-favorite-setup-index-empty style="display: none">
						<p>お気に入りに登録した飼育セットはありません。</p>
						<a class="button" href="<?php echo esc_url(home_url('/ballpython-setup-shindan/')); ?>">ボールパイソン飼育セット診断へ</a>
					</div>
				</div>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/js/common.js" defer></script>
	<?php wp_footer(); ?>
</body>
</html>
