<div class="content-box" data-js-shindan>
	<h2 class="heading-lv2-02 u-pt0">ボールパイソン飼育セット診断</h2>
	<p class="u-mt2-pc u-mt2-sp"><span class="u-bold u-primary02">たった数秒</span>で、あなたにぴったりの<span class="u-bold u-primary02">飼育セット</span>がわかる！</p>
	<p class="u-mt1-pc u-mt1-sp">飼育・繁殖などの目的に合わせて、いくつかの質問に答えるだけで、ケージやヒーター、床材など、<span class="u-bold u-primary02">必要な飼育用品をまとめて</span>ご提案します。登録・メールアドレスの入力など不要です。</p>
	<form class="u-mt3-pc u-mt3-sp" data-js-shindan-quiz novalidate></form>
	<div class="u-mt3-pc u-mt3-sp" data-js-shindan-result hidden>
		<div class="box" data-js-shindan-outcomes>
			<?php foreach (DORANGO_SHINDAN_OUTCOME_IDS as $outcome_id) : ?>
				<div
					class="shindan__outcome"
					data-js-shindan-outcome="<?php echo esc_attr($outcome_id); ?>"
					hidden
				>
					<?php shindan_render_outcome($outcome_id); ?>
				</div>
			<?php endforeach; ?>
		</div>
		<a
			class="button u-mt3-pc u-mt3-sp"
			href="<?php echo esc_url(home_url('/ballpython-setup-shindan/')); ?>"
		>もう一度診断する</a>
	</div>
	<template data-js-shindan-question-template>
		<dl class="box stack stack--gap3" data-js-shindan-question>
			<dt class="shidan-title" data-js-shindan-question-text></dt>
			<dd class="flex flex--fit-center flex--align-center" data-js-shindan-question-options></dd>
		</dl>
	</template>
	<template data-js-shindan-option-template>
		<button type="button" class="button" data-js-shindan-option></button>
	</template>
</div>
