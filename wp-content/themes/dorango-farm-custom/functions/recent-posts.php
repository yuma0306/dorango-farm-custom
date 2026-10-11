<?php

const RECENT_HISTORY_LIMIT = 10;
const RECENT_SINGLE_SECTION_LIMIT = 4;

function dorango_recent_limits_script(): void {
	$data = [
		'history' => RECENT_HISTORY_LIMIT,
		'single' => RECENT_SINGLE_SECTION_LIMIT,
	];
	echo '<script>window.dorangoRecentLimits=' . wp_json_encode($data) . ';</script>' . "\n";
}
