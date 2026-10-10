<?php
	$post_id = absint( ($args ?? [])['post_id'] ?? get_the_ID() );
	$is_hub = defined('BALL_PYTHON_HUB_ID') && $post_id === BALL_PYTHON_HUB_ID;
	$title = get_the_title($post_id);
	$thumb = get_article_thumb($post_id);
	$publishedDate = get_post_time('Y-m-d', false, $post_id);
	$modifiedDate = get_post_modified_time('Y-m-d', false, $post_id);
	$permalink = get_permalink($post_id);
?>
<div class="blogs-item">
	<a class="blogs-item__link" href="<?php echo esc_url($permalink); ?>">
		<?php if ($is_hub) : ?>
			<span class="blogs-item__badge">おすすめ</span>
		<?php endif; ?>
		<?php if(!empty($thumb)): ?>
			<picture class="blogs-item__thumb">
				<img class="blogs-item__img" src="<?php echo esc_url($thumb['url']); ?>" alt="<?php echo esc_html($thumb['url']); ?>"  width="<?php echo esc_html($thumb['width']); ?>" height="<?php echo esc_html($thumb['height']); ?>">
			</picture>
		<?php endif; ?>
		<div class="blogs-item__block">
			<div class="blogs-item__dates">
				<span class="blogs-item__date"><span class="blogs-item__icon blogs-item__icon--pencil" role="img" aria-label="投稿日"></span><time datetime="<?php echo esc_html($publishedDate); ?>"><?php echo esc_html($publishedDate); ?></time></span>
				<span class="blogs-item__date"><span class="blogs-item__icon blogs-item__icon--update" role="img" aria-label="更新日"></span><time datetime="<?php echo esc_html($modifiedDate); ?>"><?php echo esc_html($modifiedDate); ?></time></span>
			</div>
			<p class="blogs-item__text"><?php echo esc_html($title); ?></p>
		</div>
	</a>
</div>
