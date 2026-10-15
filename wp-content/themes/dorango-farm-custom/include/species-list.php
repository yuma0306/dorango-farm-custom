<?php
$species_items = [
	[
		'href' => '/tag/species/ball-python/',
		'img' => 'img-ballpython-front.webp',
		'en' => 'BALL PYTHON',
		'ja' => 'ボールパイソン',
	],
	[
		'href' => '/tag/species/corn-snake/',
		'img' => 'img-cornsnake-front.webp',
		'en' => 'CORN SNAKE',
		'ja' => 'コーンスネーク',
	],
	[
		'href' => '/tag/species/spilota/',
		'img' => 'img-carpetpython-front.webp',
		'en' => 'CARPET PYTHON',
		'ja' => 'カーペットパイソン',
	],
	[
		'href' => '/tag/species/cranwell-horned-frog/',
		'img' => 'img-tunogaeru-front.webp',
		'en' => 'HORNED FROG',
		'ja' => 'ツノガエル',
	],
	[
		'href' => '/tag/species/rat/',
		'img' => 'img-rat-front.webp',
		'en' => 'RAT',
		'ja' => 'ラット',
	],
];
?>
<section>
	<h2 class="heading-lv2-02">種類から探す</h2>
	<div class="grid-block grid-block--col3 grid-block--col2-sp u-mt3-pc u-mt3-sp">
		<?php foreach ($species_items as $item) : ?>
			<a class="panel-link" href="<?php echo esc_url(home_url($item['href'])); ?>">
				<img
					class="panel-link__img"
					src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/' . $item['img']); ?>"
					alt="<?php echo esc_attr($item['ja']); ?>"
				>
				<span class="panel-link__body">
					<span class="panel-link__en"><?php echo esc_html($item['en']); ?></span>
					<span class="panel-link__ja"><?php echo esc_html($item['ja']); ?></span>
				</span>
			</a>
		<?php endforeach; ?>
	</div>
</section>
