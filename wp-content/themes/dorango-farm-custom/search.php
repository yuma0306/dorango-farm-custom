<?php if(have_posts()): ?>
	<h2>「<?php the_search_query(); ?>」の検索結果</h2>
	<?php while(have_posts()): the_post(); ?>
		<ul>
			<li>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</li>
		</ul>
	<?php endwhile; ?>
<!-- 検索ワードがヒットしないとき  -->
<?php else: ?>
	<p>検索結果はありませんでした。</p>
	<p>再度サイト内検索、または下部リンクより目的のページをお探しください。</p>
<?php endif; ?>
