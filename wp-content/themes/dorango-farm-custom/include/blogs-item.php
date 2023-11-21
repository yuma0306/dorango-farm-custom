<?php
	$title = get_the_title();
	$thumb = get_field('thumb');
	$modifiedDate = get_the_modified_time('Y-m-d');
	$permalink = get_permalink();
?>
<li class="blogs-item">
	<a class="blogs-item__link" href="<?php echo esc_url($permalink); ?>">
		<picture class="blogs-item__thumb">
			<img src="<?php echo esc_url($thumb); ?>" alt="">
		</picture>
		<div class="blogs-item__block">
			<time class="blogs-item__date" datetime="2021-06-13"><?php echo esc_html($modifiedDate); ?></time>
			<p class="blogs-item__text"><?php echo esc_html($title); ?></p>
		</div>
	</a>
</li>
