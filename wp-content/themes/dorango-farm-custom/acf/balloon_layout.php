<?php
	$balloonList = get_sub_field('balloon_field');
?>
<?php if(!empty($balloonList)): ?>
	<div class="article-block">
		<?php foreach($balloonList as $balloonItem): ?>
			<?php $balloonFlag = $balloonItem['balloon_bool_field'];?>
			<div class="balloon<?php $balloonFlag && print ' balloon--reverse'; ?>">
				<picture class="balloon__picture">
					<img class="balloon__img" src="<?php echo get_template_directory_uri(); ?>/assets/img/img-<?php $balloonFlag ? print 'lizard' : print 'frog'; ?>.webp" alt="">
				</picture>
				<div class="balloon__text wysiwyg">
					<?php echo $balloonItem['balloon_wysiwyg_field']; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php endif; ?>

