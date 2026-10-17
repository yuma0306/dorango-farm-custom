<?php
	$product_post = ($args ?? [])['product_post'] ?? null;
	if (!$product_post instanceof WP_Post) {
		return;
	}
	$product_id = $product_post->ID;
	$title = get_the_title($product_id);
	$content = apply_filters('the_content', get_post_field('post_content', $product_id));
	$is_on_sale = (bool) get_field('is_on_sale', $product_id);
	$original_price = get_field('original_price', $product_id);
	$sale_price = get_field('sale_price', $product_id);
	$discount_percent = get_field('discount_percent', $product_id);
	$sale_ends_at = (string) get_field('sale_ends_at', $product_id);
	$moshimo_html = (string) get_field('moshimo_html', $product_id);
?>
<section class="stack">
	<h4 class="heading-lv4-01"><?php echo esc_html($title); ?></h4>
	<?php if (trim(wp_strip_all_tags($content)) !== '') : ?>
		<div class="wysiwyg-v2">
			<?php echo $content; ?>
		</div>
	<?php endif; ?>
	<?php if ($is_on_sale && !empty($sale_price)) : ?>
		<p class="flex flex--gap1 u-bold u-primary02">
			<?php if (!empty($discount_percent)) : ?>
				<span>-<?php echo esc_html((string) (int) $discount_percent); ?>% OFF</span>
			<?php endif; ?>
			<span>Amazonセール価格：¥<?php echo esc_html(number_format((int) $sale_price)); ?></span>
		</p>
		<?php if (!empty($original_price)) : ?>
			<p class="u-bold">通常価格：<s>¥<?php echo esc_html(number_format((int) $original_price)); ?></s></p>
		<?php endif; ?>
		<?php if ($sale_ends_at !== '') : ?>
			<p>セール終了予定：<?php echo esc_html($sale_ends_at); ?></p>
		<?php endif; ?>
	<?php endif; ?>
	<?php if ($moshimo_html !== '') : ?>
		<div>
			<?php echo $moshimo_html; ?>
		</div>
	<?php endif; ?>
</section>
