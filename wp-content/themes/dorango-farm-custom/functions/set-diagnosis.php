<?php

function dorango_set_diagnosis_uri(): string {
	return get_template_directory_uri() . '/assets/js/set-diagnosis.js';
}

function dorango_register_set_diagnosis_shortcode(): void {
	add_shortcode('set_diagnosis', 'set_diagnosis_shortcode');
}

function dorango_queue_set_diagnosis_script(): void {
	static $queued = false;
	if ($queued) {
		return;
	}
	$queued = true;
	add_action('wp_footer', 'dorango_print_set_diagnosis_script', 20);
}

function dorango_print_set_diagnosis_script(): void {
	$src = esc_url(dorango_set_diagnosis_uri());
	echo '<script type="module" src="' . $src . '"></script>' . "\n";
}

function set_diagnosis_shortcode(): string {
	dorango_queue_set_diagnosis_script();
	ob_start();
	get_template_part('include/set-diagnosis');
	return (string) ob_get_clean();
}

function dorango_set_diagnosis_outcome_ids(): array {
	return ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M'];
}

function dorango_set_diagnosis_questions(): array {
	static $questions = null;
	if ($questions !== null) {
		return $questions;
	}
	$path = get_template_directory() . '/data/questions.json';
	if (!is_readable($path)) {
		return [];
	}
	$decoded = json_decode((string) file_get_contents($path), true);
	if (!is_array($decoded)) {
		return [];
	}
	$questions = $decoded;
	return $questions;
}
