<?php
	$recomPosts = [
		4848,
		4846,
		4836,
		4826,
		4851,
	];
	$kvArgs = [
		'post_type' => ['breed', 'zoo', 'shop', 'cook', 'trivia'],
		'post__in' => $recomPosts,
		'posts_per_page' => count($recomPosts),
		'post_status' => 'publish',
	];
	$breedArgs = [
		'post_type' => 'breed',
		'posts_per_page' => 3, // 表示する投稿数
		'orderby' => 'date',
		'order' => 'DESC',
	];
	$kvPosts = new WP_Query($kvArgs);
	$breedPosts = new WP_Query($breedArgs);
?>
<!DOCTYPE html>
<html lang="ja">
<?php get_template_part('include/head'); ?>
<body>
	<div class="wrapper">
		<?php get_template_part('include/header'); ?>
		<main>
			<?php if($kvPosts->have_posts()): ?>
				<div class="kv">
					<div class="splide kv-slider" id="js-kv-slider">
						<div class="splide__track kv-slider__track">
							<ul class="splide__list kv-slider__list">
								<?php while($kvPosts->have_posts()): $kvPosts->the_post(); ?>
									<?php get_template_part('include/kv-slide'); ?>
								<?php endwhile; ?>
							</ul>
						</div>
						<div class="splide__arrows kv-arrow">
							<button class="splide__arrow splide__arrow--prev kv-arrow__btn kv-arrow__btn--prev">prev</button>
							<button class="splide__arrow splide__arrow--next kv-arrow__btn kv-arrow__btn--next">next</button>
						</div>
					</div>
				</div>
			<?php wp_reset_postdata(); endif; ?>
			<div class="block-lg">
				<div class="inner">
					<!-- <form class="" action="https://www.ko2jiko.com" method="get">
						<input class="" type="search" id="s" name="s" placeholder="例）ボールパイソン">
						<<input type="hidden" name="post_type" value="breed">
						<button class="">
							<img width="11" height="11" class="" src="" alt="検索">
						</button>
					</form> -->
					<div class="blogs-wrap">
						<?php if($breedPosts->have_posts()): ?>
							<section class="blogs-block">
								<h2 class="heading-lv2-01"><span class="heading-lv2-01__deco">飼育・繁殖</span>の記事</h2>
								<ul class="blogs-list">
									<?php while($breedPosts->have_posts()): $breedPosts->the_post(); ?>
										<?php get_template_part('include/blogs-item'); ?>
									<?php endwhile; ?>
								</ul>
								<a class="" href="/breed/">飼育・繁殖の記事一覧</a>
							</section>
						<?php wp_reset_postdata(); endif; ?>
						<?php if($breedPosts->have_posts()): ?>
							<section class="blogs-block">
								<h2 class="heading-lv2-01"><span class="heading-lv2-01__deco">飼育・繁殖</span>の記事</h2>
								<ul class="blogs-list">
									<?php while($breedPosts->have_posts()): $breedPosts->the_post(); ?>
										<?php get_template_part('include/blogs-item'); ?>
									<?php endwhile; ?>
								</ul>
								<a class="" href="/breed/">飼育・繁殖の記事一覧</a>
							</section>
						<?php wp_reset_postdata(); endif; ?>
						<section>
							<h2 class="heading-lv2-01"><span class="heading-lv2-01__deco">動物園</span>の記事</h2>
							<a href="/zoo/">動物園の記事一覧</a>
						</section>
						<section>
							<h2>ショップ</h2>
							<a href="/shop/">ショップの記事一覧</a>
						</section>
						<section>
							<h2>昆虫食</h2>
							<a href="/cook/">昆虫食の記事一覧</a>
						</section>
						<section>
							<h2>動物雑学</h2>
							<a href="/trivia/">動物雑学の記事一覧</a>
						</section>
					</div>
				</div>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
    <?php wp_footer(); ?>
</body>
</html>
