<?php
	$meta_title = get_meta_title();
	$meta_desc = get_meta_desc();
?>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
	<meta charset="UTF-8">
	<?php get_template_part('include/gtm-head'); ?>
	<?php isNoindex(); ?>
	<title><?php echo $meta_title; ?></title>
	<meta name="description" content="<?php echo $meta_desc; ?>">
	<link rel="canonical" href="<?php getCanonical(); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- ogp -->
	<meta property="og:title" content="<?php echo $meta_title; ?>">
	<meta property="og:description" content="<?php echo $meta_desc; ?>">
	<meta property="og:url" content="<?php getOgUrl(); ?>">
	<meta property="og:image" content="<?php getOgImage(); ?>">
	<meta property="og:site_name" content="<?php echo bloginfo('name'); ?>">
	<meta property="og:type" content="website">
	<meta property="og:locale" content="ja_JP">
	<!-- /ogp -->
	<!-- favicon -->
	<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/favicon-16x16.png">
	<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/site.webmanifest">
	<link rel="mask-icon" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/safari-pinned-tab.svg" color="#E1AA3C">
	<meta name="msapplication-TileColor" content="#E1AA3C">
	<meta name="theme-color" content="#E1AA3C">
	<!-- /favicon -->
	<!-- style -->
	<?php
		$base_uri = get_stylesheet_directory();
		$ip = '';
		if (getenv('SERVER_ADDR') !== false) {
			$ip = $_SERVER['SERVER_ADDR'];
		}
		// ローカル環境
		if (false !== strpos($ip, '::1')) {
			load_css_file();
		// 本番環境
		} else {
			ob_start();
				require_once "{$base_uri}/assets/css/style.css";
				if(is_front_page()) {
					require_once "{$base_uri}/assets/css/front-page.css";
				}
				if(is_page('contact')) {
					require_once "{$base_uri}/assets/css/contact.css";
				}
				$style = ob_get_contents();
			ob_end_clean();
			echo "<style>{$style}</style>";
		}
	?>
	<!-- /style -->
	<!-- schema -->
	<script type="application/ld+json">
		<?php createBreadcrumbsSchema(); ?>
	</script>
	<!-- /schema -->
	<?php wp_head(); ?>
</head>
