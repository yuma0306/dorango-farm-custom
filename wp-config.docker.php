<?php
/**
 * Docker 用 wp-config 断片（参考）
 */

$is_docker = getenv('WORDPRESS_DB_HOST') !== false && getenv('WORDPRESS_DB_HOST') !== '';

if ($is_docker) {
	define('DB_NAME', getenv('WORDPRESS_DB_NAME') ?: 'wordpress');
	define('DB_USER', getenv('WORDPRESS_DB_USER') ?: 'wordpress');
	define('DB_PASSWORD', getenv('WORDPRESS_DB_PASSWORD') ?: 'wordpress');
	define('DB_HOST', getenv('WORDPRESS_DB_HOST') ?: 'db');

	if (
		isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
		$_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'
	) {
		$_SERVER['HTTPS'] = 'on';
	}

	if (!defined('WP_ENVIRONMENT_TYPE')) {
		define('WP_ENVIRONMENT_TYPE', getenv('WP_ENVIRONMENT_TYPE') ?: 'local');
	}
} else {
	define('DB_NAME', 'your_db_name');
	define('DB_USER', 'your_db_user');
	define('DB_PASSWORD', 'your_db_password');
	define('DB_HOST', 'localhost');
}

// $table_prefix = 'wp1_';
