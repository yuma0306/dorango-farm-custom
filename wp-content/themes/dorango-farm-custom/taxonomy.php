<?php
	$taxTerm = get_queried_object();
	$taxTitle = "「{$taxTerm->name}」に関する記事";
?>
<!DOCTYPE html>
<html lang="ja">
<?php get_template_part('include/head'); ?>
<body>
	<div class="wrapper">
		<?php get_template_part('include/header'); ?>
		<main class="main">
			<h1 class="heading-lv1-01">
				<span class="heading-lv1-01__text"><?php echo esc_html($taxTitle); ?></span>
			</h1>
			<div class="inner">
				<ul class="breadcrumb">
					<li class="breadcrumb__item">
						<a class="breadcrumb__link" href="/">ホーム</a>
					</li>
					<li class="breadcrumb__item">
						<a class="breadcrumb__link" href="/tag/">タグ一覧</a>
					</li>
					<li class="breadcrumb__item">
						<span class="breadcrumb__text"><?php echo esc_html($taxTitle); ?></span>
					</li>
				</ul>
				<p class="affi-note">当サイトはアフェリエイト広告を利用しています。</p>
				<div class="grid-block grid-block--col2">
					<?php if(have_posts()): ?>
						<?php while (have_posts()): the_post(); ?>
							<?php get_template_part('include/blogs-item'); ?>
						<?php endwhile; ?>
					<?php endif; ?>
				</div>
				<?php createPagenation(); ?>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
    <?php wp_footer(); ?>
</body>
</html>
