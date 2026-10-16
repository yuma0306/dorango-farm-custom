<?php
	$product_post = ($args ?? [])['product_post'] ?? null;
	if (!$product_post instanceof WP_Post) {
		return;
	}
	$product_id = $product_post->ID;
	$title = get_the_title($product_id);
	$content = apply_filters('the_content', get_post_field('post_content', $product_id));
	$thumb_url = get_the_post_thumbnail_url($product_id, 'large');
	$is_on_sale = (bool) get_field('is_on_sale', $product_id);
	$original_price = get_field('original_price', $product_id);
	$sale_price = get_field('sale_price', $product_id);
	$discount_percent = get_field('discount_percent', $product_id);
	$sale_ends_at = (string) get_field('sale_ends_at', $product_id);
	$moshimo_html = (string) get_field('moshimo_html', $product_id);
	$related_posts = get_field('related_posts', $product_id);
	$related_ids = is_array($related_posts) ? array_filter(array_map('absint', $related_posts)) : [];
?>
<section class="stack stack--gap1">
	<h3 class="heading-lv3-01"><?php echo esc_html($title); ?></h3>
	<?php if ($is_on_sale && !empty($sale_price)) : ?>
		<p class="u-bold">
			<?php if (!empty($discount_percent)) : ?>
				<span class="u-primary02">-<?php echo esc_html((string) (int) $discount_percent); ?>% OFF </span>
			<?php endif; ?>
			<span>セール価格：¥<?php echo esc_html(number_format((int) $sale_price)); ?></span>
			<?php if (!empty($original_price)) : ?>
				<span>（参考価格：<s>¥<?php echo esc_html(number_format((int) $original_price)); ?></s>）</span>
			<?php endif; ?>
		</p>
		<?php if ($sale_ends_at !== '') : ?>
			<p>セール終了予定：<?php echo esc_html($sale_ends_at); ?></p>
		<?php endif; ?>
	<?php elseif (!empty($original_price)) : ?>
		<p>参考価格：¥<?php echo esc_html(number_format((int) $original_price)); ?></p>
	<?php endif; ?>
	<?php if ($thumb_url && $moshimo_html === '') : ?>
		<figure class="article-img">
			<img src="<?php echo esc_url($thumb_url); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
		</figure>
	<?php endif; ?>
	<?php if (trim(wp_strip_all_tags($content)) !== '') : ?>
		<div class="wysiwyg-v2">
			<?php echo $content; ?>
		</div>
	<?php endif; ?>
	<?php if ($moshimo_html !== '') : ?>
		<div>
			<?php echo $moshimo_html; ?>
		</div>
	<?php endif; ?>
	<?php if ($related_ids !== []) : ?>
		<div class="stack stack--gap1">
			<p class="u-bold">関連する解説記事</p>
			<div class="grid-block grid-block--col2">
				<?php foreach ($related_ids as $related_id) : ?>
					<?php echo do_shortcode('[article id="' . absint($related_id) . '"]'); ?>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>
</section>
