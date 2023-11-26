<?php
	// おすすめ記事取得
	$recomPosts = [
		4848,
		4846,
		4836,
		4826,
		4851,
	];
	$kvArgs = [
		'post_type' => ['breed', 'zoo', 'shop', 'food', 'trivia'],
		'post__in' => $recomPosts,
		'posts_per_page' => count($recomPosts),
		'post_status' => 'publish',
	];
	$kvPosts = new WP_Query($kvArgs);

	// 各投稿タイプの記事取得
	function getPostsByType($postType) {
		$args = [
			'post_type'      => $postType,
			'posts_per_page' => 2,
			'orderby'        => 'date',
			'order'          => 'DESC',
		];
		return new WP_Query($args);
	}
	$breedPosts = getPostsByType('breed');
	$zooPosts = getPostsByType('zoo');
	$shopPosts = getPostsByType('shop');
	$foodPosts = getPostsByType('food');
	$triviaPosts = getPostsByType('trivia');
?>
<!DOCTYPE html>
<html lang="ja">
<?php get_template_part('include/head'); ?>
<body>
	<div class="wrapper">
		<?php get_template_part('include/header'); ?>
		<main class="main u-p0">
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
							<button class="splide__arrow splide__arrow--prev kv-arrow__btn kv-arrow__btn--prev"></button>
							<button class="splide__arrow splide__arrow--next kv-arrow__btn kv-arrow__btn--next"></button>
						</div>
						<ul class="splide__pagination kv-pagination"></ul>
					</div>
				</div>
			<?php wp_reset_postdata(); endif; ?>
			<div class="block-large">
				<div class="inner">
					<div class="search-form-block">
						<form class="search-form u-m0a js-search-form" action="<?php echo home_url(); ?>" method="get">
							<input class="search-form__input js-search-input" type="text" name="s" value="<?php the_search_query(); ?>" placeholder="例：ボールパイソン">
							<input type="hidden" name="post_type[]" value="breed">
							<input type="hidden" name="post_type[]" value="zoo">
							<input type="hidden" name="post_type[]" value="shop">
							<input type="hidden" name="post_type[]" value="food">
							<input type="hidden" name="post_type[]" value="trivia">
							<button type="button" class="search-form__btn js-search-btn">
								<img class="search-form__icon" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-search.svg" alt="">
							</button>
						</form>
						<div class="validate-err js-search-err">キーワードを入力してください</div>
					</div>
					<div class="blogs-wrap">
						<?php if($breedPosts->have_posts()): ?>
							<section class="blogs-block">
								<h2 class="heading-lv2-01 heading-lv2-01--breed"><span class="heading-lv2-01__deco">飼育・繁殖</span>の記事</h2>
								<ul class="blogs-list">
									<?php while($breedPosts->have_posts()): $breedPosts->the_post(); ?>
										<?php get_template_part('include/blogs-item'); ?>
									<?php endwhile; ?>
								</ul>
								<a class="btn-link01 btn-link01--end" href="/breed/">飼育・繁殖の記事一覧</a>
							</section>
						<?php wp_reset_postdata(); endif; ?>
						<?php if($zooPosts->have_posts()): ?>
							<section class="blogs-block">
								<h2 class="heading-lv2-01 heading-lv2-01--zoo"><span class="heading-lv2-01__deco">動物園</span>の記事</h2>
								<ul class="blogs-list">
									<?php while($zooPosts->have_posts()): $zooPosts->the_post(); ?>
										<?php get_template_part('include/blogs-item'); ?>
									<?php endwhile; ?>
								</ul>
								<a class="btn-link01 btn-link01--end" href="/breed/">動物園の記事一覧</a>
							</section>
						<?php wp_reset_postdata(); endif; ?>
						<?php if($shopPosts->have_posts()): ?>
							<section class="blogs-block">
								<h2 class="heading-lv2-01 heading-lv2-01--shop"><span class="heading-lv2-01__deco">ショップ</span>の記事</h2>
								<ul class="blogs-list">
									<?php while($shopPosts->have_posts()): $shopPosts->the_post(); ?>
										<?php get_template_part('include/blogs-item'); ?>
									<?php endwhile; ?>
								</ul>
								<a class="btn-link01 btn-link01--end" href="/shop/">ショップの記事一覧</a>
							</section>
						<?php wp_reset_postdata(); endif; ?>
						<?php if($foodPosts->have_posts()): ?>
							<section class="blogs-block">
								<h2 class="heading-lv2-01 heading-lv2-01--food"><span class="heading-lv2-01__deco">昆虫食</span>の記事</h2>
								<ul class="blogs-list">
									<?php while($foodPosts->have_posts()): $foodPosts->the_post(); ?>
										<?php get_template_part('include/blogs-item'); ?>
									<?php endwhile; ?>
								</ul>
								<a class="btn-link01 btn-link01--end" href="/food/">昆虫食の記事一覧</a>
							</section>
						<?php wp_reset_postdata(); endif; ?>
						<?php if($triviaPosts->have_posts()): ?>
							<section class="blogs-block">
								<h2 class="heading-lv2-01 heading-lv2-01--trivia"><span class="heading-lv2-01__deco">動物雑学</span>の記事</h2>
								<ul class="blogs-list">
									<?php while($triviaPosts->have_posts()): $triviaPosts->the_post(); ?>
										<?php get_template_part('include/blogs-item'); ?>
									<?php endwhile; ?>
								</ul>
								<a class="btn-link01 btn-link01--end" href="/trivia/">動物雑学の記事一覧</a>
							</section>
						<?php wp_reset_postdata(); endif; ?>
					</div>
				</div>
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/front.js" defer></script>
    <?php wp_footer(); ?>
</body>
</html>
