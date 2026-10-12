<?php
	$post_id = absint( ($args ?? [])['post_id'] ?? get_the_ID() );
	$is_recommended = ball_python_hub_is_recommended($post_id);
	$title = get_the_title($post_id);
	$thumb = get_article_thumb($post_id);
	$publishedDate = get_post_time('Y-m-d', false, $post_id);
	$modifiedDate = get_post_modified_time('Y-m-d', false, $post_id);
	$permalink = get_permalink($post_id);
?>
<div class="blogs-item">
	<a class="blogs-item__link" data-js-blogs-item-link href="<?php echo esc_url($permalink); ?>">
		<?php if ($is_recommended) : ?>
			<span class="blogs-item__badge">おすすめ</span>
		<?php endif; ?>
		<?php if(!empty($thumb)): ?>
			<picture class="blogs-item__thumb" data-js-blogs-item-thumb>
				<img class="blogs-item__img" data-js-blogs-item-img src="<?php echo esc_url($thumb['url']); ?>" alt="<?php echo esc_html($thumb['url']); ?>"  width="<?php echo esc_html($thumb['width']); ?>" height="<?php echo esc_html($thumb['height']); ?>">
			</picture>
		<?php endif; ?>
		<div class="blogs-item__block" data-js-blogs-item-block>
			<div class="blogs-item__dates">
				<span class="blogs-item__date"><span class="blogs-item__icon blogs-item__icon--pencil" role="img" aria-label="投稿日"></span><time data-js-blogs-item-published datetime="<?php echo esc_html($publishedDate); ?>"><?php echo esc_html($publishedDate); ?></time></span>
				<span class="blogs-item__date"><span class="blogs-item__icon blogs-item__icon--update" role="img" aria-label="更新日"></span><time data-js-blogs-item-modified datetime="<?php echo esc_html($modifiedDate); ?>"><?php echo esc_html($modifiedDate); ?></time></span>
			</div>
			<p class="blogs-item__text" data-js-blogs-item-title><?php echo esc_html($title); ?></p>
		</div>
	</a>
</div>
