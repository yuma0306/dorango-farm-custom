<div class="hamburger" data-js-hamburger>
	<div class="hamburger__open">
		<button
			type="button"
			class="hamburger-btn hamburger-btn--open"
			data-js-hamburger-btn
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
						<?php echo esc_html($link['label']); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</nav>
</div>
