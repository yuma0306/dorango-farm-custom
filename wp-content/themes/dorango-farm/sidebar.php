<!-- l-side -->
<aside class="l-side u-pc" id="js-burger-target">
	<div class="l-side__inner">
		<!-- カテゴリー -->
		<?php $categories = get_categories(); if(!empty($categories)): ?>
		<div class="l-side__block">
			<div class="c-headline">
				<div class="c-headline__icon">
					<span class="dashicons dashicons-buddicons-replies c-headline__insect c-headline__insect--orange"></span>
				</div>
				<h2 class="c-headline__txt">カテゴリーから探す</h2>
			</div>
			<ul class="l-side__list">
				<?php foreach($categories as $category): ?>
					<li class="l-side__item">
						<a class="l-side__link" href="<?php echo esc_attr(get_category_link($category->term_id)); ?>"><?php echo esc_html($category->name); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>
		<!-- /カテゴリー -->

		<?php $tags = get_tags(); if(!empty($tags)): ?>
		<div class="l-side__block">
			<div class="c-headline">
				<div class="c-headline__icon">
					<span class="dashicons dashicons-buddicons-replies c-headline__insect c-headline__insect--orange"></span>
				</div>
				<h2 class="c-headline__txt">タグから探す</h2>
			</div>
			<ul class="l-side__list">
				<li class="l-side__item"><a class="l-side__link" href="/tag/ボールパイソン/">#ボールパイソン</a></li>
				<li class="l-side__item"><a class="l-side__link" href="/tag/飼育環境/">#飼育環境</a></li>
				<li class="l-side__item"><a class="l-side__link" href="/tag/飼育用品/">#飼育用品</a></li>
				<li class="l-side__item"><a class="l-side__link" href="/tag/病気/">#病気</a></li>
				<li class="l-side__item"><a class="l-side__link" href="/tag/餌/">#餌</a></li>
				<li class="l-side__item"><a class="l-side__link" href="/tag/保温器具/">#保温器具</a></li>
				<!-- <?php //foreach ($tags as $tag): ?>
					<li class="l-side__item">
						<a class="l-side__link" href="<?php //echo esc_attr(get_tag_link($tag->term_id)); ?>">#<?php //echo esc_html($tag->name); ?></a>
					</li>
				<?php //endforeach; ?> -->
			</ul>
			<div class="l-side__btn">
				<a class="c-btn" href="<?php echo esc_url(home_url('/tag/')); ?>">タグ一覧</a>
			</div>
		</div>
		<?php endif; ?>
	</div>
</aside>
<!-- /l-side -->
