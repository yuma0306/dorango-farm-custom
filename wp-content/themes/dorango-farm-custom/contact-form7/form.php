<div class="contact-form grid-block">
	<!-- name -->
	<div class="contact-group js-contact-group">
		<label class="contact-label" for="name">
			<span class="contact-label__tag">必須</span>
			<span class="contact-label__text">お名前</span>
		</label>
		<div class="contact-block">
			[text* your-name autocomplete:name class:contact-block__input id:name]
		</div>
	</div>
	<!-- /name -->
	<!-- email -->
	<div class="contact-group js-contact-group">
		<label class="contact-label" for="email">
			<span class="contact-label__tag">必須</span>
			<span class="contact-label__text">メールアドレス</span>
		</label>
		<div class="contact-block">
			[email* your-email autocomplete:email class:contact-block__input id:email]
		</div>
	</div>
	<!-- /email -->
	<!-- inquiry -->
	<div class="contact-group js-contact-group">
		<label class="contact-label" for="inquiry">
			<span class="contact-label__tag">必須</span>
			<span class="contact-label__text">お問い合わせ内容</span>
		</label>
		<div class="contact-block">
			[textarea* your-message class:contact-block__textarea id:inquiry]
		</div>
	</div>
	<!-- /inquiry -->
</div>

[submit class:btn-link01 "送信"]
