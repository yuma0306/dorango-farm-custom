<header class="header">
	<div class="inner">
		<?php if (is_front_page()) : ?>
			<h1><a class="logo" href="/"><?php echo esc_html(get_bloginfo('name')); ?></a></h1>
		<?php else : ?>
			<a class="logo" href="/"><?php echo esc_html(get_bloginfo('name')); ?></a>
		<?php endif; ?>
	</div>
	<nav class="gnav">
		<ul class="gnav__list">
			<?php foreach (get_nav_links(GNAV_LINK_KEYS) as $link) : ?>
				<li class="gnav__item">
					<a class="gnav__link" href="<?php echo esc_url($link['href']); ?>"><?php echo esc_html($link['label']); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</nav>
</header>
