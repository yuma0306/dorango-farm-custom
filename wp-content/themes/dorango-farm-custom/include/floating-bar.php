<?php
$post_id = absint(($args ?? [])['post_id'] ?? 0);
$has_toc = !empty(($args ?? [])['has_toc']);
if ($post_id <= 0) {
	return;
}
$history_href = NAV_LINKS['history']['href'];
?>
<nav
	class="floating-bar"
	data-js-floating-bar
	aria-label="記事メニュー"
	style="--floating-bar-cols: <?php echo $has_toc ? 4 : 3; ?>"
>
	<div class="floating-bar__inner">
		<button
			type="button"
			class="floating-bar__item"
			data-js-favorite-btn
			data-post-id="<?php echo esc_attr((string) $post_id); ?>"
			data-gtm-event="<?php echo esc_attr(gtm_event('floating_favorite')); ?>"
			aria-pressed="false"
			aria-label="お気に入りに追加"
		>
			<span class="floating-bar__icon floating-bar__icon--favorite" aria-hidden="true"></span>
			<span class="floating-bar__label">お気に入り</span>
		</button>
		<?php if ($has_toc) : ?>
			<button
				type="button"
				class="floating-bar__item"
				data-js-floating-bar-toc
				data-gtm-event="<?php echo esc_attr(gtm_event('floating_toc')); ?>"
			>
				<span class="floating-bar__icon floating-bar__icon--toc" aria-hidden="true"></span>
				<span class="floating-bar__label">目次</span>
			</button>
		<?php endif; ?>
		<button
			type="button"
			class="floating-bar__item"
			data-js-floating-bar-search
			data-gtm-event="<?php echo esc_attr(gtm_event('floating_search')); ?>"
		>
			<span class="floating-bar__icon floating-bar__icon--search" aria-hidden="true"></span>
			<span class="floating-bar__label">検索</span>
		</button>
		<a
			class="floating-bar__item"
			href="<?php echo esc_url($history_href); ?>"
			data-gtm-event="<?php echo esc_attr(gtm_event('floating_history')); ?>"
		>
			<span class="floating-bar__icon floating-bar__icon--history" aria-hidden="true"></span>
			<span class="floating-bar__label">履歴</span>
		</a>
	</div>
</nav>
