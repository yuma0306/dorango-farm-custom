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

function ballpython_setup_shindan_shortcode(): string {
	ob_start();
	get_template_part('include/ballpython-setup-shindan');
	return (string) ob_get_clean();
}

add_shortcode('ballpython_setup_shindan', 'ballpython_setup_shindan_shortcode');
