<?php
	$title = get_the_title();
	$thumb = get_field('thumb_field');
	$modifiedDate = get_the_modified_time('Y-m-d');
	$permalink = get_permalink();
?>
<div class="blogs-item">
	<a class="blogs-item__link" href="<?php echo esc_url($permalink); ?>">
		<?php if(!empty($thumb)): ?>
			<picture class="blogs-item__thumb">
				<img class="blogs-item__img" src="<?php echo esc_url($thumb['url']); ?>" alt="<?php echo esc_html($thumb['url']); ?>"  width="<?php echo esc_html($thumb['width']); ?>" height="<?php echo esc_html($thumb['height']); ?>">
			</picture>
		<?php endif; ?>
		<div class="blogs-item__block">
			<time class="blogs-item__date" datetime="<?php echo esc_html($modifiedDate); ?>"><?php echo esc_html($modifiedDate); ?></time>
			<p class="blogs-item__text"><?php echo esc_html($title); ?></p>
		</div>
	</a>
</div>
