<?php
	$post = get_sub_field('post_field');
	$postID = $post[0];
	$thumb = get_field('thumb_field', $postID);
	$permalink = get_permalink($postID);
	$title = get_the_title($postID);
	$modifiedDate = get_the_modified_time('Y-m-d', $postID);
?>
<?php if(!empty($thumb) && !empty($permalink) && !empty($title)): ?>
	<div class="article-block">
		<div class="blogs-item blogs-item--article">
			<a class="blogs-item__link" href="<?php echo esc_url($permalink); ?>">
				<picture class="blogs-item__thumb">
					<img class="blogs-item__img" src="<?php echo esc_url($thumb['url']); ?>" alt="<?php echo esc_html($thumb['url']); ?>">
				</picture>
				<div class="blogs-item__block">
					<time class="blogs-item__date" datetime="<?php echo esc_html($modifiedDate); ?>"><?php echo esc_html($modifiedDate); ?></time>
					<p class="blogs-item__text"><?php echo esc_html($title); ?></p>
				</div>
			</a>
		</div>
	</div>
<?php endif; ?>
