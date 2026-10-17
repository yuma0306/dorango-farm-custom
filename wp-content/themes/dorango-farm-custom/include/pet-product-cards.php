<?php
$all_products = get_posts([
	'post_type' => 'pet_product',
	'post_status' => 'publish',
	'posts_per_page' => -1,
	'orderby' => ['menu_order' => 'ASC', 'ID' => 'ASC'],
]);
$groups = group_pet_products_by_category($all_products);
if ($groups === []) {
	return;
}
?>
<section>
	<h2 class="heading-lv2-02">おすすめ飼育用品から探す</h2>
	<div class="grid-panel u-mt3-pc u-mt3-sp">
		<?php foreach ($groups as $slug => $group) : ?>
			<button
				type="button"
				class="product-card"
				data-js-product-modal-open="<?php echo esc_attr($slug); ?>"
			>
				<?php if ($group['icon'] !== '') : ?>
					<img
						class="product-card__icon"
						src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/' . $group['icon']); ?>"
						alt=""
						width="48"
						height="48"
					>
				<?php endif; ?>
				<span class="product-card__label"><?php echo esc_html($group['label']); ?></span>
			</button>
		<?php endforeach; ?>
	</div>
	<a class="button u-mt3-pc u-mt3-sp" href="<?php echo esc_url(home_url('/pet-products/')); ?>">セール情報・おすすめ飼育用品一覧</a>
</section>

<div class="product-modal" data-js-product-modal>
	<button
		type="button"
		class="product-modal__backdrop"
		data-js-product-modal-backdrop
		aria-label="モーダルを閉じる"
		style="display: none"
	></button>
	<div
		class="product-modal__panel"
		data-js-product-modal-panel
		role="dialog"
		aria-modal="true"
		style="display: none"
	>
		<button
			type="button"
			class="product-modal__close"
			data-js-product-modal-close
			aria-label="閉じる"
		>
			<span class="product-modal__close-bar" aria-hidden="true"></span>
			<span class="product-modal__close-bar" aria-hidden="true"></span>
		</button>
		<?php foreach ($groups as $slug => $group) : ?>
			<div
				class="product-modal__section stack"
				data-js-product-modal-section="<?php echo esc_attr($slug); ?>"
				style="display: none"
			>
				<h3 class="heading-lv3-01 u-pt0"><?php echo esc_html($group['label']); ?></h3>
				<div class="stack">
					<?php foreach ($group['posts'] as $product_post) : ?>
						<?php get_template_part('include/pet-product-item', null, ['product_post' => $product_post]); ?>
					<?php endforeach; ?>
				</div>
				<?php if ($group['post_ids'] !== []) : ?>
					<section class="stack">
						<h4 class="heading-lv4-01"><?php echo esc_html($group['label']); ?>の関連記事</h4>
						<div class="grid-block grid-block--col2">
							<?php foreach ($group['post_ids'] as $related_id) : ?>
								<?php get_template_part('include/blogs-item', null, ['post_id' => $related_id]); ?>
							<?php endforeach; ?>
						</div>
					</section>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
