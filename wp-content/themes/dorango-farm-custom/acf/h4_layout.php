<?php
	$text = get_sub_field('h4_field');
	// $count = $count + 1;
	// $tocs['anchor-lv4-'.$count] = $text;
?>
<?php if(!empty($text)): ?>
	<h4 class="heading-lv4-01"><?php echo esc_html($text); ?></h4>
<?php endif; ?>
