<?php
	$img = get_sub_field('img_field');
	$caption = get_sub_field('img_caption_field');
?>
<?php if(!empty($img) || !empty($caption)): ?>
	<div class="article-block">
		<div class="article-img">
			<?php if(!empty($img)): ?>
				<picture class="article-img__picture">
					<img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_html($img['alt']); ?>" width="<?php echo esc_html($img['width']); ?>" height="<?php echo esc_html($img['height']); ?>">
				</picture>
			<?php endif; ?>
			<?php if(!empty($caption)): ?>
				<p class="article-img__caption">
					<?php echo esc_html($caption); ?>
				</p>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>

