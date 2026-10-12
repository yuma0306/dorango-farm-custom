<?php
$questions = dorango_set_diagnosis_questions();
$outcome_ids = dorango_set_diagnosis_outcome_ids();
?>
<div class="set-diagnosis-wrap">
	<div class="set-diagnosis" data-js-set-diagnosis>
		<p class="set-diagnosis__lead">いくつかの質問に答えると、あなたに合った飼育セットの組み合わせを提案します。</p>
		<div class="set-diagnosis__quiz" data-js-set-diagnosis-quiz>
			<form class="set-diagnosis__form" data-js-set-diagnosis-form novalidate>
				<div class="set-diagnosis__step" data-js-set-diagnosis-step>
					<?php
					get_template_part(
						'include/set-diagnosis-question',
						null,
						[
							'question_id' => 'sex',
							'questions' => $questions,
						],
					);
					?>
				</div>
			</form>
		</div>
		<div class="set-diagnosis__result" data-js-set-diagnosis-result hidden>
			<h2 class="set-diagnosis__result-title heading-lv3-01">あなたへのおすすめ</h2>
			<p class="set-diagnosis__error" data-js-set-diagnosis-error hidden>
				結果を表示できませんでした。もう一度お試しください。
			</p>
			<div class="set-diagnosis__outcomes" data-js-set-diagnosis-outcomes>
				<?php foreach ($outcome_ids as $outcome_id) : ?>
					<div
						class="set-diagnosis__outcome"
						data-js-set-diagnosis-outcome="<?php echo esc_attr($outcome_id); ?>"
						hidden
					>
						<?php get_template_part('include/set-diagnosis-outcome', strtolower($outcome_id)); ?>
					</div>
				<?php endforeach; ?>
			</div>
			<button type="button" class="set-diagnosis__retry btn-link01" data-js-set-diagnosis-retry>
				もう一度診断する
			</button>
		</div>
		<template data-js-set-diagnosis-question-template>
			<fieldset class="set-diagnosis__field" data-js-set-diagnosis-question>
				<legend class="set-diagnosis__field-legend" data-js-set-diagnosis-question-text></legend>
				<div class="set-diagnosis__field-options" data-js-set-diagnosis-question-options></div>
			</fieldset>
		</template>
		<template data-js-set-diagnosis-option-template>
			<button
				type="button"
				class="set-diagnosis__option btn-link01"
				data-js-set-diagnosis-option
			></button>
		</template>
	</div>
</div>
