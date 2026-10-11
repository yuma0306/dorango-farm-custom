<?php
$post_type = (string) (($args ?? [])['post_type'] ?? '');
if ($post_type === '') {
	return;
}
?>
<div class="search-float" data-js-search-float>
	<button class="search-float__backdrop" data-js-search-float-backdrop type="button" aria-label="検索を閉じる" hidden></button>
	<div
		class="search-float__panel"
		data-js-search-float-panel
		role="dialog"
		aria-modal="true"
		aria-labelledby="search-float-title"
		hidden
	>
		<div class="search-float__inner">
			<h2 class="heading-lv2-02 u-pt0" id="search-float-title">もっと記事を探す</h2>
			<form class="search-form js-search-form" action="<?php echo esc_url(home_url('/')); ?>" method="get">
				<input class="search-form__input js-search-input" type="text" name="s" value="<?php echo esc_attr(get_search_query()); ?>" placeholder="キーワード">
				<button type="button" class="search-form__btn js-search-btn" data-gtm-event="<?php echo esc_attr(gtm_event('search_submit')); ?>">
					<span class="search-form__icon" role="img" aria-label="検索"></span>
				</button>
			</form>
			<div class="validate-err js-search-err">
				<div class="validate-err__elm js-search-child">キーワードを入力してください</div>
			</div>
		</div>
	</div>
</div>
