<?php
	$text = get_sub_field('h3_field');
	// $count = $count + 1;
	// $tocs['anchor-lv3-'.$count] = $text;
?>
<?php if(!empty($text)): ?>
	<h3 class="heading-lv3-01"><?php echo esc_html($text); ?></h3>
<?php endif; ?>
