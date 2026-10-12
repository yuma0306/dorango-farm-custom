<?php

function gtm_event(string $key) {
	static $events = [
		'floating_favorite' => 'floating-favorite',
		'floating_toc' => 'floating-toc',
		'floating_search' => 'floating-search',
		'floating_history' => 'floating-history',
		'hamburger_open' => 'hamburger-open',
		'hamburger_close' => 'hamburger-close',
		'article_toc' => 'article-toc',
		'btn_top' => 'btn-top',
		'search_submit' => 'search-submit',
		'ball_python_shindan_retry' => 'ball_python_shindan_retry',
	];
	return $events[$key] ?? '';
}
