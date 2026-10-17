<?php
	$all_products = get_posts([
		'post_type' => 'pet_product',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => ['menu_order' => 'ASC', 'ID' => 'ASC'],
	]);
	$sale_posts = [];
	$recommended_posts = [];
	foreach ($all_products as $product_post) {
		if ((bool) get_field('is_on_sale', $product_post->ID)) {
			$sale_posts[] = $product_post;
		} else {
			$recommended_posts[] = $product_post;
		}
	}
?>

<section class="stack">
	<h2 class="heading-lv2-02">セール中の爬虫類飼育用品</h2>
	<?php if ($sale_posts === []) : ?>
		<p>現在確認できているセール対象商品はありません</p>
	<?php else : ?>
		<div class="stack">
			<?php foreach ($sale_posts as $product_post) : ?>
				<?php get_template_part('include/pet-product-item', null, ['product_post' => $product_post]); ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
<section class="stack">
	<h2 class="heading-lv2-02">おすすめ飼育用品</h2>
	<?php if ($recommended_posts === []) : ?>
		<p>現在登録されているおすすめ飼育用品はありません</p>
	<?php else : ?>
		<div class="stack">
			<?php foreach ($recommended_posts as $product_post) : ?>
				<?php get_template_part('include/pet-product-item', null, ['product_post' => $product_post]); ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
