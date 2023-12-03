<?php
	$metaTitle = getMetaTitle();
	$metaDesc = getMetaDesc();
?>
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
	<meta charset="UTF-8">
	<?php isNoindex(); ?>
	<title><?php echo $metaTitle; ?></title>
	<meta name="description" content="<?php echo $metaDesc; ?>">
	<link rel="canonical" href="<?php getCanonical(); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<meta name="format-detection" content="telephone=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- ogp -->
	<meta property="og:title" content="<?php echo $metaTitle; ?>">
	<meta property="og:description" content="<?php echo $metaDesc; ?>">
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
	<?php loadCssFile(); ?>
	<!-- /style -->
	<!-- schema -->
	<script type="application/ld+json">
		<?php createBreadcrumbsSchema(); ?>
	</script>
	<!-- /schema -->
	<?php wp_head(); ?>
</head>
