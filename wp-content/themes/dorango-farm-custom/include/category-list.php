<section>
	<h2 class="heading-lv2-02">カテゴリーから探す</h2>
	<div class="grid-panel u-mt3-pc u-mt3-sp">
		<?php foreach (get_nav_links(CATEGORY_LINK_KEYS) as $item) : ?>
			<a class="panel-link" href="<?php echo esc_url(home_url($item['href'])); ?>">
				<img
					class="panel-link__img"
					src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/' . $item['img']); ?>"
					alt="<?php echo esc_attr($item['label']); ?>"
				>
				<span class="panel-link__body">
					<span class="panel-link__en"><?php echo esc_html($item['en']); ?></span>
					<span class="panel-link__ja"><?php echo esc_html($item['label']); ?></span>
				</span>
			</a>
		<?php endforeach; ?>
	</div>
</section>
