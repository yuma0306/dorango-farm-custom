<?php
$args = $args ?? [];
$toc_html = (string) ($args['toc_html'] ?? '');
if (!str_contains($toc_html, 'toc__link')) {
	return;
}
?>
<div class="toc-float js-toc-float">
	<button class="toc-float__backdrop js-toc-float-backdrop" type="button" aria-label="目次を閉じる" hidden></button>
	<div class="toc-float__panel js-toc-float-panel" hidden>
		<?php echo $toc_html; ?>
	</div>
	<button class="toc-float__btn js-toc-float-btn" type="button" aria-expanded="false" aria-label="目次">
		<img class="toc-float__icon" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-toc.svg" alt="" width="28" height="28">
	</button>
</div>
