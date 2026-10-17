<?php
/**
 * Template Name: お気に入り飼育セット（ボールパイソン）
 * Slug: ballpython-setup
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
				<div class="stack" data-js-favorite-setup-detail="ballpython-setup">
					<?php if (!empty($thumb)) : ?>
						<picture class="article-thumb">
							<img class="article-thumb__img" src="<?php echo esc_url($thumb['url']); ?>" alt="<?php echo esc_html($thumb['alt']); ?>" width="<?php echo esc_html($thumb['width']); ?>" height="<?php echo esc_html($thumb['height']); ?>">
						</picture>
					<?php endif; ?>
					<?php get_template_part('include/aff-text'); ?>
					<div class="content-box">
						<div class="stack" data-js-favorite-setup-detail-content style="display: none">
							<h2 class="heading-lv2-02 u-pt0">ボールパイソン飼育セット診断</h2>
							<div class="box">
								<?php foreach (DORANGO_SHINDAN_OUTCOME_IDS as $outcome_id) : ?>
									<div
										class="shindan__outcome"
										data-js-favorite-setup-outcome="<?php echo esc_attr($outcome_id); ?>"
										style="display: none"
									>
										<?php shindan_render_outcome($outcome_id); ?>
									</div>
								<?php endforeach; ?>
							</div>
							<div class="flex flex--fit-center">
								<a
									class="button flex-child-1"
									href="<?php echo esc_url(home_url('/ballpython-setup-shindan/')); ?>"
								>もう一度診断する</a>
								<button
									type="button"
									class="button button--no-arrow flex-child-1"
									data-js-favorite-setup-remove
								>お気に入り飼育セットを解除</button>
							</div>
						</div>
						<div class="stack" data-js-favorite-setup-detail-empty style="display: none">
							<p class="u-tc">お気に入りに登録したボールパイソンの飼育セットはありません。</p>
							<a class="button" href="<?php echo esc_url(home_url('/ballpython-setup-shindan/')); ?>">ボールパイソン飼育セット診断をする</a>
						</div>
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
