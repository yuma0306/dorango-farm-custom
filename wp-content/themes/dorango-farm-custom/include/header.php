<header class="header">
	<div class="inner header__inner">
		<?php if (is_front_page()) : ?>
			<h1><a class="logo" href="/"><?php echo esc_html(get_bloginfo('name')); ?></a></h1>
		<?php else : ?>
			<a class="logo" href="/"><?php echo esc_html(get_bloginfo('name')); ?></a>
		<?php endif; ?>
	</div>
</header>
