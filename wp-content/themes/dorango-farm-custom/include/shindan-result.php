<?php
$view = is_array($args ?? null) ? $args : [];
$outcome_id = isset($view['outcome_id']) ? (string) $view['outcome_id'] : '';
$type = $view['type'] ?? '';
$lead = isset($view['lead']) && is_array($view['lead']) ? $view['lead'] : [];
$items = isset($view['items']) && is_array($view['items']) ? $view['items'] : [];
$intro = isset($lead['intro']) ? (string) $lead['intro'] : '';
$article_ids = isset($lead['article_ids']) && is_array($lead['article_ids']) ? $lead['article_ids'] : [];
?>

<section>
	<?php if ($items !== []) : ?>
		<dl class="stack">
			<dt class="u-tc stack stack--gap1">
				<p class="heading-lv3-02 u-bold">診断結果</p>
				<?php if ($type !== '') : ?>
					<p class="heading-lv3-02 u-primary02 u-bold"><?php echo esc_html($type); ?></p>
				<?php endif; ?>
			</dt>
			<dd class="stack">
				<?php if ($intro !== '') : ?>
					<p><?php echo wp_kses_post(nl2br($intro)); ?></p>
				<?php endif; ?>
				<h3 class="heading-lv3-01">あなたにおすすめの飼育用品</h3>
				<?php foreach ($items as $item) : ?>
					<?php
						$item = is_array($item) ? $item : [];
						$label = $item['label'] ?? '';
						$description = $item['description'] ?? '';
						$product_id = $item['product_id'] ?? '';
						$affiliate_slug = shindan_product($product_id);
						if ($affiliate_slug === null) {
							continue;
						}
					?>
					<dl class="stack">
						<dt class="heading-lv4-01"><?php echo esc_html($label); ?></dt>
						<dd class="stack stack--gap1">
							<?php if ($description !== '') : ?>
								<p><?php echo esc_html($description); ?></p>
							<?php endif; ?>
							<?php get_template_part('include/shindan-affiliate/' . $affiliate_slug); ?>
						</dd>
					</dl>
				<?php endforeach; ?>
				<?php if ($article_ids !== []) : ?>
					<h3
						class="heading-lv3-01"
						<?php if ($outcome_id !== '') : ?>
							id="<?php echo esc_attr(shindan_outcome_articles_anchor_id($outcome_id)); ?>"
						<?php endif; ?>
					>あなたにおすすめの記事</h3>
					<div class="grid-block grid-block--col2">
						<?php foreach ($article_ids as $post_id) : ?>
							<?php echo do_shortcode('[article id="' . absint($post_id) . '"]'); ?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</dd>
		</dl>
	<?php endif; ?>
</section>
