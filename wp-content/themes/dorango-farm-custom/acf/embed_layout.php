<?php
	$embed = get_sub_field('embedfield');
?>
<?php if(!empty($embed)): ?>
	<div class="article-block">
		<?php echo $embed; ?>
	</div>
<?php endif; ?>

