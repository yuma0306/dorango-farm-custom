<!-- l-post -->
<section class="l-post">
	<div class="l-post__inner">
		<?php if(is_front_page() && $_SERVER["REQUEST_URI"] === '/'): ?>
		<!-- トップページのみオススメ記事を表示 -->
			<?php
				$args = [
					'post_type' => 'post',
					'post__in' => [1321,1667,3100,],
					'post_status' => ['publish'],
					'order'=> 'asc',
					'orderby'=> 'post_date'
				];
				$query = new WP_Query($args);
			?>
			<div class="c-headline">
				<div class="c-headline__icon">
					<span class="dashicons dashicons-buddicons-replies c-headline__insect"></span>
				</div>
				<h2 class="c-headline__txt">おすすめ記事</h2>
			</div>
			<ul class="l-post__list l-post__list--suggest">
			<?php if($query->have_posts()): ?>
			<?php while($query->have_posts()): $query->the_post(); ?>
				<li class="l-post__item">
					<a class="l-post__desc" href="<?php esc_attr(the_permalink()); ?>">
						<?php if(has_post_thumbnail()): ?>
						<div class="l-post__thumb">
							<?php the_post_thumbnail('full'); ?>
						</div>
						<?php endif; ?>
						<div class="l-post__block">
							<h3 class="l-post__ttl"><?php esc_html(the_title()); ?></h3>
							<p class="l-post__date"><?php echo esc_html((get_the_date())); ?></p>
						</div>
					</a>
					<?php if(has_tag() || has_category()): ?>
					<div class="l-post__foot">
						<ul class="l-post__tags">
							<?php if(has_category()): ?>
								<?php foreach($categories = get_the_category() as $category): ?>
								<li class="l-post__tag">
									<a class="c-tag c-tag--orange" href="<?php echo esc_attr(get_tag_link($category->term_id)); ?>">
										<?php echo esc_html($category->name); ?>
									</a>
								</li>
								<?php endforeach; ?>
							<?php endif; ?>
							<?php if(has_tag()): ?>
							<?php foreach($tags = get_the_tags() as $tag): ?>
							<li class="l-post__tag">
								<a class="c-tag" href="<?php echo esc_attr(get_tag_link($tag->term_id)); ?>">
									<?php echo esc_html($tag->name); ?>
								</a>
							</li>
							<?php endforeach; ?>
							<?php endif; ?>
						</ul>
					</div>
					<?php endif; ?>
				</li>
			<?php endwhile; ?>
			<?php endif; ?>
			</ul>
		<!-- /トップページのみオススメ記事を表示 -->
		<?php endif; ?>
		<div class="c-headline">
			<div class="c-headline__icon">
				<span class="dashicons dashicons-buddicons-replies c-headline__insect"></span>
			</div>
			<?php if(is_category()): ?>
				<h1 class="c-headline__txt">
					<?php echo esc_html('「' . single_cat_title('', false) . '」の記事一覧'); ?>
				</h1>
			<?php elseif(is_tag()): ?>
				<h1 class="c-headline__txt">
					<?php echo esc_html('「#' . single_tag_title('', false) . '」の記事一覧'); ?>
				</h1>
			<?php elseif(is_tax()): ?>
				<h1 class="c-headline__txt">
					<?php echo esc_html('「#' . single_tag_title('', false) . '」の記事一覧'); ?>
				</h1>
			<?php elseif(is_search()): ?>
				<h1 class="c-headline__txt">
					<?php echo esc_html('「'.get_search_query().'」の検索結果'); ?>
				</h1>
			<?php else: ?>
				<h2 class="c-headline__txt">記事一覧</h2>
			<?php endif; ?>
		</div>
		<ul class="l-post__list">
			<?php if(have_posts()): ?>
			<?php while(have_posts()): the_post(); ?>
			<li class="l-post__item">
				<a class="l-post__desc" href="<?php esc_attr(the_permalink()); ?>">
					<?php if(has_post_thumbnail()): ?>
					<div class="l-post__thumb">
						<?php the_post_thumbnail('full'); ?>
					</div>
					<?php endif; ?>
					<div class="l-post__block">
						<h3 class="l-post__ttl"><?php esc_html(the_title()); ?></h3>
						<p class="l-post__date"><?php echo esc_html((get_the_date())); ?></p>
					</div>
				</a>
				<?php if(has_tag() || has_category()): ?>
				<div class="l-post__foot">
					<ul class="l-post__tags">
						<?php if(has_category()): ?>
						<?php foreach($categories = get_the_category() as $category): ?>
						<li class="l-post__tag">
							<a class="c-tag c-tag--orange" href="<?php echo esc_attr(get_tag_link($category->term_id)); ?>">
								<?php echo esc_html($category->name); ?>
							</a>
						</li>
						<?php endforeach; ?>
						<?php endif; ?>
						<?php if(has_tag()): ?>
						<?php foreach($tags = get_the_tags() as $tag): ?>
						<li class="l-post__tag">
							<a class="c-tag" href="<?php echo esc_attr(get_tag_link($tag->term_id)); ?>">
								<?php echo esc_html($tag->name); ?>
							</a>
						</li>
						<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				</div>
				<?php endif; ?>
			</li>
			<?php endwhile; ?>
			<?php else: ?>
				<li class="l-post__err">投稿が見つかりませんでした。</li>
			<?php endif; ?>
		</ul>
		<?php
			$args = array(
				'mid_size' => 1,
				'prev_text' => '前へ',
				'next_text' => '次へ',
				'screen_reader_text' => ' ',
			);
			the_posts_pagination($args);
		?>
	</div>
</section>
<!-- /l-post -->
