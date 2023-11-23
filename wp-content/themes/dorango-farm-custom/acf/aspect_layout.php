<?php
	$aspect = get_sub_field('aspect_field');
?>
<?php if(!empty($aspect)): ?>
	<div class="article-block">
		<div class="aspect">
			<?php echo $aspect; ?>
		</div>
	</div>
<?php endif; ?>

