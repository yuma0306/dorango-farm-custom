<?php
$question_id = $args['question_id'] ?? '';
$questions = $args['questions'] ?? [];
if ($question_id === '' || !isset($questions[$question_id])) {
	return;
}
$def = $questions[$question_id];
?>
<fieldset class="set-diagnosis__field" data-js-set-diagnosis-question="<?php echo esc_attr($question_id); ?>">
	<legend class="set-diagnosis__field-legend"><?php echo esc_html($def['question']); ?></legend>
	<div class="set-diagnosis__field-options">
		<?php foreach ($def['options'] as $value => $label) : ?>
			<button
				type="button"
				class="set-diagnosis__option btn-link01"
				data-js-set-diagnosis-option
				data-set-diagnosis-option-value="<?php echo esc_attr($value); ?>"
			>
				<?php echo esc_html($label); ?>
			</button>
		<?php endforeach; ?>
	</div>
</fieldset>
