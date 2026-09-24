<?php
	// 各投稿タイプの記事取得
	function getPostsByType($postType) {
		$args = [
			'post_type' => $postType,
			'posts_per_page' => 2,
			'orderby' => 'modified',
			'order' => 'DESC',
			'post_status' => 'publish',
		];
		return new WP_Query($args);
	}
	$breedPosts = getPostsByType('breed');
	$zooPosts = getPostsByType('zoo');
	$shopPosts = getPostsByType('shop');
	$foodPosts = getPostsByType('food');
	$triviaPosts = getPostsByType('trivia');
	$ballPythonArgs = [
		'post_type' => 'breed',
		'posts_per_page' => 4,
		'orderby' => 'modified',
		'order' => 'DESC',
		'post_status' => 'publish',
		'tax_query' => [
			[
				'taxonomy' => 'species',
				'field' => 'slug',
				'terms' => 'ball-python',
			],
		],
	];
	$ballPythonPosts = new WP_Query($ballPythonArgs);
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
	<div class="wrapper">
		<?php get_template_part('include/header'); ?>
		<main class="main">
			<div class="block-large">
				<div class="inner">
					<?php if ($ballPythonPosts->have_posts()) : ?>
						<section class="blogs-block js-animate-y">
							<h2 class="heading-lv2-02 u-mt0">ボールパイソンの記事</h2>
							<div class="grid-block grid-block--col2">
								<?php while ($ballPythonPosts->have_posts()) : $ballPythonPosts->the_post(); ?>
									<?php get_template_part('include/blogs-item'); ?>
								<?php endwhile; ?>
							</div>
							<a class="btn-link01 btn-link01--end" href="<?php echo esc_url($ballPythonArchiveUrl); ?>">ボールパイソンの記事一覧</a>
						</section>
					<?php wp_reset_postdata(); endif; ?>
					<div class="blogs-wrap">
						<?php if($breedPosts->have_posts()): ?>
							<section class="blogs-block js-animate-y">
								<h2 class="heading-lv2-01 heading-lv2-01--breed"><span class="heading-lv2-01__deco">飼育・繁殖</span>の記事</h2>
								<div class="grid-block">
									<?php while($breedPosts->have_posts()): $breedPosts->the_post(); ?>
										<?php get_template_part('include/blogs-item'); ?>
									<?php endwhile; ?>
								</div>
								<a class="btn-link01 btn-link01--end" href="/breed/">飼育・繁殖の記事一覧</a>
							</section>
						<?php wp_reset_postdata(); endif; ?>
						<?php if($zooPosts->have_posts()): ?>
							<section class="blogs-block js-animate-y">
								<h2 class="heading-lv2-01 heading-lv2-01--zoo"><span class="heading-lv2-01__deco">アニマルスポット</span>の記事</h2>
								<div class="grid-block">
									<?php while($zooPosts->have_posts()): $zooPosts->the_post(); ?>
										<?php get_template_part('include/blogs-item'); ?>
									<?php endwhile; ?>
								</div>
								<a class="btn-link01 btn-link01--end" href="/zoo/">アニマルスポットの記事一覧</a>
							</section>
						<?php wp_reset_postdata(); endif; ?>
						<?php if($shopPosts->have_posts()): ?>
							<section class="blogs-block js-animate-y">
								<h2 class="heading-lv2-01 heading-lv2-01--shop"><span class="heading-lv2-01__deco">ショップ</span>の記事</h2>
								<div class="grid-block">
									<?php while($shopPosts->have_posts()): $shopPosts->the_post(); ?>
										<?php get_template_part('include/blogs-item'); ?>
									<?php endwhile; ?>
								</div>
								<a class="btn-link01 btn-link01--end" href="/shop/">ショップの記事一覧</a>
							</section>
						<?php wp_reset_postdata(); endif; ?>
						<?php if($foodPosts->have_posts()): ?>
							<section class="blogs-block js-animate-y">
								<h2 class="heading-lv2-01 heading-lv2-01--food"><span class="heading-lv2-01__deco">昆虫食</span>の記事</h2>
								<div class="grid-block">
									<?php while($foodPosts->have_posts()): $foodPosts->the_post(); ?>
										<?php get_template_part('include/blogs-item'); ?>
									<?php endwhile; ?>
								</div>
								<a class="btn-link01 btn-link01--end" href="/food/">昆虫食の記事一覧</a>
							</section>
						<?php wp_reset_postdata(); endif; ?>
						<?php if($triviaPosts->have_posts()): ?>
							<section class="blogs-block js-animate-y">
								<h2 class="heading-lv2-01 heading-lv2-01--trivia"><span class="heading-lv2-01__deco">動物雑学</span>の記事</h2>
								<div class="grid-block">
									<?php while($triviaPosts->have_posts()): $triviaPosts->the_post(); ?>
										<?php get_template_part('include/blogs-item'); ?>
									<?php endwhile; ?>
								</div>
								<a class="btn-link01 btn-link01--end" href="/trivia/">動物雑学の記事一覧</a>
							</section>
						<?php wp_reset_postdata(); endif; ?>
					</div>
				</div>
			</div>
			<div class="inner">
				<div class="search-form-block">
					<form class="search-form u-m0a js-search-form" action="<?php echo home_url(); ?>" method="get">
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
			</div>
		</main>
		<?php get_template_part('include/footer'); ?>
	</div>
	<script src="<?php echo get_template_directory_uri() ?>/assets/js/common.js" defer></script>
    <?php wp_footer(); ?>
</body>
</html>
