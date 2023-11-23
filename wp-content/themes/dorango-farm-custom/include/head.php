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
	<link rel="icon" href="">
	<link rel="apple-touch-icon" href="">
	<!-- ogp -->
	<meta property="og:title" content="<?php echo $metaTitle; ?>">
	<meta property="og:description" content="<?php echo $metaDesc; ?>">
	<meta property="og:url" content="<?php getOgUrl(); ?>">
	<meta property="og:image" content="<?php getOgImage(); ?>">
	<meta property="og:site_name" content="<?php echo bloginfo('name'); ?>">
	<meta property="og:type" content="website">
	<meta property="og:locale" content="ja_JP">
	<meta property="fb:app_id" content="">
	<meta name="twitter:site" content="">
	<meta name="twitter:card" content="summary">
	<!-- /ogp -->
	<!-- style -->
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/style.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide-core.min.css">
	<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/front-page.css">
	<!-- /style -->
	<!-- schema -->
	<script type="application/ld+json">
		<?php createBreadcrumbsSchema(); ?>
	</script>
	<!-- /schema -->
<?php wp_head(); ?>
