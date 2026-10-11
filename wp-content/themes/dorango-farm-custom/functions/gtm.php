<?php
function gtm_event(string $key) {
	static $events = [
		'floating_favorite' => 'floating-favorite',
		'floating_toc' => 'floating-toc',
		'floating_search' => 'floating-search',
		'floating_history' => 'floating-history',
	];
	return $events[$key] ?? '';
}
