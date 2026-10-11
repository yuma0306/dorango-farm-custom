<?php
$post_id = absint(($args ?? [])['post_id'] ?? 0);
$has_toc = !empty(($args ?? [])['has_toc']);
if ($post_id <= 0) {
	return;
}
$history_href = NAV_LINKS['history']['href'];
?>
<nav
	class="single-fixed-footer"
	data-js-single-fixed-footer
	aria-label="記事メニュー"
	style="--single-fixed-footer-cols: <?php echo $has_toc ? 4 : 3; ?>"
>
	<div class="single-fixed-footer__inner">
		<button
			type="button"
			class="single-fixed-footer__item"
			data-js-favorite-btn
			data-post-id="<?php echo esc_attr((string) $post_id); ?>"
			aria-pressed="false"
			aria-label="お気に入りに追加"
		>
			<span class="single-fixed-footer__icon single-fixed-footer__icon--favorite" aria-hidden="true"></span>
			<span class="single-fixed-footer__label">お気に入り</span>
		</button>
		<?php if ($has_toc) : ?>
			<button type="button" class="single-fixed-footer__item" data-js-single-fixed-footer-toc>
				<span class="single-fixed-footer__icon single-fixed-footer__icon--toc" aria-hidden="true"></span>
				<span class="single-fixed-footer__label">目次</span>
			</button>
		<?php endif; ?>
		<button type="button" class="single-fixed-footer__item" data-js-single-fixed-footer-search>
			<span class="single-fixed-footer__icon single-fixed-footer__icon--search" aria-hidden="true"></span>
			<span class="single-fixed-footer__label">検索</span>
		</button>
		<a class="single-fixed-footer__item" href="<?php echo esc_url($history_href); ?>">
			<span class="single-fixed-footer__icon single-fixed-footer__icon--history" aria-hidden="true"></span>
			<span class="single-fixed-footer__label">履歴</span>
		</a>
	</div>
</nav>
