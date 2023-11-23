<?php
	$heading = get_the_title();
	$thumb = get_field('thumb_field');
	$currentUri = getCurrentUri();
	$currentPath = getCurrentPath($currentUri);
	$modifiedDate = get_the_modified_time('Y-m-d');
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
				<div class="article-head">
					<ul class="tag">
						<li class="tag__item">
							<a class="tag__link" href="">タグ</a>
						</li>
						<li class="tag__item">
							<a class="tag__link" href="">タグ</a>
						</li>
					</ul>
					<div class="article-date">
						<img class="article-date__img" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-pen.svg" alt="">
						<time class="article-date__text" datetime="<?php echo esc_html($modifiedDate); ?>"><?php echo esc_html($modifiedDate); ?></time>
					</div>
				</div>
				<section class="article-content">
					<?php getAcfArticle(); ?>
				</section>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
    <?php wp_footer(); ?>
</body>
</html>
