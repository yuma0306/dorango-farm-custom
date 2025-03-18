<?php
	// removeMoshimoLink(content: $embed);
	$embed = get_sub_field('embed_field');
?>
<?php if(!empty($embed)): ?>
	<div class="article-block">
		<?php echo $embed; ?>
	</div>
<?php endif; ?>

