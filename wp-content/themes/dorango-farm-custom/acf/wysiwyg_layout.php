<?php
	$wysiwyg = get_sub_field('wysiwyg_field');
?>
<?php if(!empty($wysiwyg)): ?>
	<div class="article-block">
		<div class="wysiwyg js-wysiwyg">
			<?php echo $wysiwyg; ?>
		</div>
	</div>
<?php endif; ?>

