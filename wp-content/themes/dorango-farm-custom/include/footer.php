<footer class="footer block-large">
	<div class="inner footer__inner">
		<a class="logo logo--footer" href="/"><?php echo esc_html(get_bloginfo('name')); ?></a>
		<ul class="footer__list">
			<?php foreach (get_nav_links(FOOTER_LINK_KEYS) as $link) : ?>
				<li class="footer__item">
					<a href="<?php echo esc_url($link['href']); ?>" class="footer__link"><?php echo esc_html($link['label']); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<ul class="footer__sns">
			<li class="footer__sns-item">
				<a href="https://x.com/dorango_farm" target="_blank" rel="noopener noreferrer" class="footer__sns-link" aria-label="X">
					<span class="footer__sns-icon footer__sns-icon--x" aria-hidden="true"></span>
				</a>
			</li>
			<li class="footer__sns-item">
				<a href="https://www.youtube.com/@holy0306-n" target="_blank" rel="noopener noreferrer" class="footer__sns-link" aria-label="YouTube">
					<span class="footer__sns-icon footer__sns-icon--youtube" aria-hidden="true"></span>
				</a>
			</li>
		</ul>
		<p class="footer__copy">&copy;<?php echo esc_html(get_bloginfo('name')); ?></p>
		<a href="#" class="btn-top" data-gtm-event="<?php echo esc_attr(gtm_event('btn_top')); ?>">
			<img class="btn-top__manbou" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon-manbou.svg" alt="" width="125" height="150">
		</a>
		<?php get_template_part('include/toast'); ?>
	</div>
</footer>
