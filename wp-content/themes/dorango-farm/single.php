<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
	<?php get_header(); ?>
</head>
<body id="single">
	<?php get_template_part('assets/parts/header'); ?>
	<?php get_template_part('assets/parts/breadcrumb'); ?>
	<!-- l-wrapper -->
	<div class="l-wrapper">
		<!-- l-article -->
		<section class="l-article">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php if(has_post_thumbnail()): ?>
				<div class="l-article__thumb">
					<img src="<?php the_post_thumbnail_url('full'); ?>">
				</div>
			<?php endif; ?>
			<div class="l-article__inner">
				<h1 class="c-headline1"><?php the_title(); ?></h1>
				<!-- 目次 -->
				<details class="p-acc">
					<summary class="p-acc__ttl">目次</summary>
					<ol class="p-acc__indexes" id="js-indexes"></ol>
				</details>
				<!-- /目次 -->
				<!-- 本文 -->
				<div class="l-article__content" id="js-article-content" data-affi="<?php echo $productInfo['affiUrl']; ?>">
					<?php echo the_content(); ?>
					<?php if(!empty($productInfo)): ?>
						<h2>作品情報</h2>
						<ul>
							<?php if(!empty($productInfo['ttl'])): ?>
							<li>作品名：<?php echo $productInfo['ttl'] ?></li>
							<?php endif; ?>
							<?php if(!empty($productInfo['volume'])): ?>
							<li>ボリューム：<?php echo $productInfo['volume'] ?>分</li>
							<?php endif; ?>
							<?php if(!empty($productInfo['makerName'])): ?>
							<li>メーカー：<?php echo $productInfo['makerName'] ?></li>
							<?php endif; ?>
						</ul>
					<?php endif; ?>
				</div>
				<!-- /本文 -->
				<!-- タグ -->
				<?php $tags = get_the_tags(); if(!empty($tags)): ?>
				<section class="p-relate">
					<div class="c-headline c-headline--border">
						<div class="c-headline__icon c-headline__icon--border">
							<span class="dashicons dashicons-buddicons-replies c-headline__insect"></span>
						</div>
						<h2 class="c-headline__txt c-headline__txt--border">関連タグ</h2>
					</div>
					<div class="p-relate__over">
						<ul class="p-relate__tags">
						<?php foreach ($tags = get_the_tags() as $tag): ?>
							<li class="p-tag__item">
								<a class="c-tag c-tag--navy" href="<?php echo esc_attr(get_tag_link($tag->term_id)); ?>"><?php echo esc_html($tag->name); ?></a>
							</li>
						<?php endforeach; ?>
						</ul>
					</div>
				</section>
				<?php endif; ?>
				<!-- /タグ -->
			</div>
		<?php endwhile; endif; ?>
		</section>
		<!-- /l-article -->

		<?php get_sidebar(); ?>
	</div>
	<?php get_template_part('assets/parts/gnav_sp'); ?>
	<?php get_template_part('assets/parts/menu_sp'); ?>
	<?php get_template_part('assets/parts/footer'); ?>
	<?php get_footer(); ?>
</body>
