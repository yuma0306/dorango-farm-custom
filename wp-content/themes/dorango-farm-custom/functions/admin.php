<?php
/**
 * ログインURLの変更
 */

// Git管理外 loginファイル定義
$envFile =  $_SERVER['DOCUMENT_ROOT'] . '/env.php';

if (file_exists($envFile)) {
	include $envFile;
	if (defined('LOGIN_FILE')) {
		define('LOGIN_PAGE', LOGIN_FILE);
		// 指定以外のログインURLはTOPページへリダイレクト
		if (!function_exists('login_redirect')) {
			function login_redirect() {
				if (!defined('LOGIN_CHANGE') || sha1('keyword') != LOGIN_CHANGE ) {
					wp_safe_redirect(home_url());
					exit;
				}
			}
		}
		add_action( 'login_init', 'login_redirect' );

		// ログイン済みかログインURLの場合はwp-login.phpを置き換える
		if (!function_exists('login_change')) {
			function login_change( $url, $path, $orig_scheme, $blog_id ) {
			if ($path == 'wp-login.php' && (is_user_logged_in() || strpos($_SERVER['REQUEST_URI'], LOGIN_PAGE ) !== false ))
				$url = str_replace( 'wp-login.php', LOGIN_PAGE, $url);
				return $url;
			}
		}
		add_filter('site_url', 'login_change', 10, 4);

		// ログアウト時のリダイレクト先の設定
		if (!function_exists('logout_redirect')) {
			function logout_redirect($location, $status) {
				if (strpos($_SERVER['REQUEST_URI'], LOGIN_PAGE) !== false) {
					$location = str_replace('wp-login.php', LOGIN_PAGE, $location);
				}
				return $location;
			}
		}
		add_filter('wp_redirect', 'logout_redirect', 10, 2);
	}
}

?>
