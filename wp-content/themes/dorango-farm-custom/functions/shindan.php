<?php

const DORANGO_SHINDAN_OUTCOME_IDS = [
	'A',
	'B',
	'C',
	'D',
	'E',
	'F',
	'G',
	'H',
	'I',
	'J',
	'K',
	'L',
	'M',
];

function shindan_shortcode(): string {
	ob_start();
	get_template_part('include/shindan');
	return (string) ob_get_clean();
}

add_shortcode('shindan', 'shindan_shortcode');
