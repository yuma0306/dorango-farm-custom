<?php
	$text = get_sub_field('h3_field');
	$count = $count + 1;
?>
<?php if(!empty($text)): ?>
	<h3 class="heading-lv3-01" id="<?php echo "anchor-{$count}"; ?>"><?php echo esc_html($text); ?></h3>
<?php endif; ?>
