<?php
	$title = get_the_title();
	$thumb = get_field('thumb_field');
	$modifiedDate = get_the_modified_time('Y-m-d');
	$permalink = get_permalink();
?>
<li class="splide__slide kv-slide">
	<a class="kv-slide__link" href="<?php echo esc_url($permalink); ?>">
		<?php if(!empty($thumb)): ?>
			<picture class="kv-slide__thumb">
				<img class="kv-slide__img" src="<?php echo esc_url($thumb['url']); ?>" alt="<?php echo esc_html($thumb['alt']); ?>" width="<?php echo esc_html($thumb['width']); ?>" height="<?php echo esc_html($thumb['height']); ?>">
			</picture>
		<?php endif; ?>
		<div class="kv-slide__block">
			<time class="kv-slide__date" datetime="<?php echo esc_html($modifiedDate); ?>"><?php echo esc_html($modifiedDate); ?></time>
			<p class="kv-slide__text"><?php echo esc_html($title); ?></p>
		</div>
	</a>
</li>
