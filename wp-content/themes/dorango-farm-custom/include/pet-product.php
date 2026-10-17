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
	$sale_groups = group_pet_products_by_category($sale_posts);
	$recommended_groups = group_pet_products_by_category($recommended_posts);
?>

<section class="stack">
	<h2 class="heading-lv2-02">セール中の爬虫類飼育用品</h2>
	<?php if ($sale_groups === []) : ?>
		<p>現在確認できているセール対象商品はありません</p>
	<?php else : ?>
		<div class="stack">
			<?php foreach ($sale_groups as $group) : ?>
				<section class="stack">
					<h3 class="heading-lv3-01"><?php echo esc_html($group['label']); ?></h3>
					<div class="stack">
						<?php foreach ($group['posts'] as $product_post) : ?>
							<?php get_template_part('include/pet-product-item', null, ['product_post' => $product_post]); ?>
						<?php endforeach; ?>
					</div>
					<?php if ($group['post_ids'] !== []) : ?>
						<section class="stack stack--gap1">
							<h4 class="heading-lv4-01"><?php echo esc_html($group['label']); ?>の関連記事</h4>
							<div class="grid-block grid-block--col2">
								<?php foreach ($group['post_ids'] as $related_id) : ?>
									<?php get_template_part('include/blogs-item', null, ['post_id' => $related_id]); ?>
								<?php endforeach; ?>
							</div>
						</section>
					<?php endif; ?>
				</section>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>

<section class="stack">
	<h2 class="heading-lv2-02">おすすめ飼育用品</h2>
	<?php if ($recommended_groups === []) : ?>
		<p>現在登録されているおすすめ飼育用品はありません</p>
	<?php else : ?>
		<div class="stack">
			<?php foreach ($recommended_groups as $group) : ?>
				<section class="stack">
					<h3 class="heading-lv3-01"><?php echo esc_html($group['label']); ?></h3>
					<div class="stack">
						<?php foreach ($group['posts'] as $product_post) : ?>
							<?php get_template_part('include/pet-product-item', null, ['product_post' => $product_post]); ?>
						<?php endforeach; ?>
					</div>
					<?php if ($group['post_ids'] !== []) : ?>
						<section class="stack stack--gap1">
							<h4 class="heading-lv4-01"><?php echo esc_html($group['label']); ?>の関連記事</h4>
							<div class="grid-block grid-block--col2">
								<?php foreach ($group['post_ids'] as $related_id) : ?>
									<?php get_template_part('include/blogs-item', null, ['post_id' => $related_id]); ?>
								<?php endforeach; ?>
							</div>
						</section>
					<?php endif; ?>
				</section>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>
