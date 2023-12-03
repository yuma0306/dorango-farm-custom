<?php
	$text = get_sub_field('h2_field');
	$count = $count + 1;
?>
<?php if(!empty($text)): ?>
	<h2 class="heading-lv2-02" id="<?php echo "anchor-{$count}"; ?>"><?php echo esc_html($text); ?></h2>
<?php endif; ?>
