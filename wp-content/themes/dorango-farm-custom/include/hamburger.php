<div class="hamburger" data-js-hamburger>
	<div class="hamburger__open">
		<button
			type="button"
			class="hamburger-btn hamburger-btn--open"
			data-js-hamburger-btn
			data-gtm-event="<?php echo esc_attr(gtm_event('hamburger_open')); ?>"
			aria-expanded="false"
			aria-controls="hamburger-panel"
			aria-label="メニューを開く"
		>
			<span class="hamburger-btn__bar" aria-hidden="true"></span>
			<span class="hamburger-btn__bar" aria-hidden="true"></span>
			<span class="hamburger-btn__bar" aria-hidden="true"></span>
		</button>
	</div>
	<div
		class="hamburger__overlay"
		data-js-hamburger-overlay
		data-gtm-event="<?php echo esc_attr(gtm_event('hamburger_close')); ?>"
		aria-hidden="true"
	></div>
	<nav
		id="hamburger-panel"
		class="hamburger__panel"
		data-js-hamburger-panel
		aria-label="サイトメニュー"
	>
		<button
			type="button"
			class="hamburger-btn hamburger-btn--close"
			data-js-hamburger-btn
			data-gtm-event="<?php echo esc_attr(gtm_event('hamburger_close')); ?>"
			aria-expanded="false"
			aria-controls="hamburger-panel"
			aria-label="メニューを閉じる"
		>
			<span class="hamburger-btn__bar" aria-hidden="true"></span>
			<span class="hamburger-btn__bar" aria-hidden="true"></span>
			<span class="hamburger-btn__bar" aria-hidden="true"></span>
		</button>
		<div class="hamburger__head">
		</div>
		<ul class="hamburger__list">
			<?php foreach (get_nav_links(HAMBURGER_LINK_KEYS) as $link) : ?>
				<li class="hamburger__item">
					<a class="hamburger__link" href="<?php echo esc_url($link['href']); ?>">
						<?php if (!empty($link['icon'])) : ?>
							<span
								class="hamburger__link-icon hamburger__link-icon--<?php echo esc_attr($link['icon']); ?>"
								aria-hidden="true"
							></span>
						<?php endif; ?>
						<?php echo esc_html($link['label']); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<form class="search-form js-search-form u-mt3-pc u-mt3-sp" action="<?php echo esc_url(home_url('/')); ?>" method="get">
			<input
				class="search-form__input js-search-input"
				type="search"
				name="s"
				value="<?php echo esc_attr(get_search_query()); ?>"
				placeholder="キーワード"
				autocomplete="off"
			>
			<button
				type="button"
				class="search-form__btn js-search-btn"
				data-gtm-event="<?php echo esc_attr(gtm_event('search_submit')); ?>"
			>
				<span class="search-form__icon" role="img" aria-label="検索"></span>
			</button>
		</form>
		<div class="validate-err js-search-err">
			<div class="validate-err__elm js-search-child">キーワードを入力してください</div>
		</div>
	</nav>
</div>
