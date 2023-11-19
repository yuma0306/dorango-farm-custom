<?php
// カスタムフィールドの値を読み込む
$custom = get_post_custom();
// キーワード
// if(!empty( $custom['keywords'][0])) {
// 	$keywords = $custom['keywords'][0];
// }
// 記事ページと固定ページならそのまま
// if(!empty( $custom['pageTtl'][0])) {
// 	$pageTtl = $custom['pageTtl'][0];
// }
// if(!empty( $custom['description'][0])) {
// 	$description = $custom['description'][0];
// }
if (is_page() || is_single()) {
	$pageTtl = get_the_title();
	$description = get_the_excerpt();
}
if(is_front_page() || is_home()) {
	$pageTtl = get_bloginfo('name');
	$description = get_bloginfo('description');
}
if(is_category()) {
	$pageTtl = single_cat_title('', false) . 'の記事';
	$description = single_cat_title('', false) . 'の記事一覧です。' . single_cat_title('', false) . 'についてお探しの方はこちらの記事をご参照ください。';
}
if(is_tag()) {
	$pageTtl = single_tag_title('', false);
	$description = single_tag_title('', false) . 'の記事一覧です。' . single_tag_title('', false) . 'についてお探しの方はこちらの記事をご参照ください。';
}
if(is_tax()) {
	$pageTtl = single_tag_title('', false);
	$description = single_tag_title('', false) . 'の記事一覧です。' . single_tag_title('', false) . 'についてお探しの方はこちらの記事をご参照ください。';
}
if(is_search()) {
	$pageTtl = '「' . get_search_query() . '」の検索結果';
	$description = '「' . get_search_query() . '」の検索結果一覧です。' . get_search_query() .'についてお探しの方はこちらの記事をご参照ください。';
}
if(is_404()) {
	$pageTtl = 'お探しのページが見つかりませんでした';
	$description = 'お探しのページが見つかりませんでした';
}
?>
<meta charset="UTF-8">
<?php get_template_part('assets/parts/gtm_head'); ?>
<!-- seo -->
<title><?php echo esc_html($pageTtl); ?></title>
<meta name="description" content="<?php echo esc_html($description); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<?php if(is_404()): // 404ページ ?>
<meta name="robots" content="noindex">
<meta http-equiv="refresh" content="10;URL=<?php echo esc_url(home_url('/')); ?>">
<?php endif; ?>
<?php if(is_search()): // 検索結果 ?>
<meta name="robots" content="noindex">
<?php endif; ?>
<!-- /seo -->
<!-- font -->
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap" media="print" onload="this.media='all'">
<!-- /font -->
<!-- css -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css">
<!-- /css-->
<!-- js -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js" defer></script>
<?php if (is_page() || is_single()): ?>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/post.js" defer></script>
<?php endif; ?>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/common.js" defer></script>
<!-- /js -->
<!-- ogp -->
<meta property="og:site_name" content="<?php echo esc_html(get_bloginfo('name')); ?>">
<?php if(is_front_page() || is_home()): ?>
<meta property="og:type" content="website">
<?php else: ?>
<meta property="og:type" content="article">
<?php endif; ?>
<meta property="og:title" content="<?php echo esc_html($pageTtl); ?>">
<meta property="og:description" content="<?php echo esc_html($description); ?>">
<meta property="og:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>">
<?php if(is_single()): ?>
<?php if(has_post_thumbnail()): ?>
<meta property="og:image" content="<?php the_post_thumbnail_url('full'); ?>">
<?php endif; ?>
<?php else: ?>
<meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/assets/favicon/apple-touch-icon.png">
<?php endif; ?>
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="@https://twitter.com/yuma03060306">
<!-- /ogp -->
<!-- favicon -->
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/favicon-16x16.png">
<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/site.webmanifest">
<link rel="mask-icon" href="<?php echo get_template_directory_uri(); ?>/assets/favicon/safari-pinned-tab.svg" color="#FFC65D">
<meta name="msapplication-TileColor" content="#FFC65D">
<meta name="theme-color" content="#FFC65D">
<!-- /favicon -->
<!-- schema -->
<script type="application/ld+json">
{
	"@context" : "http://schema.org",
	"@type" : "WebSite",
	"name" : "ヘビ牧場どらんごファーム"
}
</script>
<!-- /schema -->
<!-- wp-head -->
<?php wp_head(); ?>
<!-- /wp-head -->
