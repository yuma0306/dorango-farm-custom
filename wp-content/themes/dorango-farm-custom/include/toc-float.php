<?php
$args = $args ?? [];
$toc_html = (string) ($args['toc_html'] ?? '');
if (!str_contains($toc_html, 'toc__link')) {
	return;
}
?>
<div class="toc-float" data-js-toc-float>
	<div class="toc-float__overlay" data-js-toc-float-overlay aria-hidden="true"></div>
	<div class="toc-float__panel" data-js-toc-float-panel>
		<?php echo $toc_html; ?>
	</div>
	<button class="toc-float__btn" data-js-toc-float-btn type="button" aria-expanded="false" aria-label="目次">
		<img class="toc-float__icon" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-toc.svg" alt="" width="28" height="28">
	</button>
</div>
