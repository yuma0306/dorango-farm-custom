<?php
	$text = get_sub_field('h2_field');
	// $count = $count + 1;
	// $tocs['anchor-lv2-'.$count] = $text;
?>
<?php if(!empty($text)): ?>
	<h2 class="heading-lv2-02"><?php echo esc_html($text); ?></h2>
<?php endif; ?>
