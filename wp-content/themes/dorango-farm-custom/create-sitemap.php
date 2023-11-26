<?php
ini_set('display_errors', "On");
require_once $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php';

function getPostPage() {
	$pages = [];
	// 対象外URL
	$excludes = [];
	// クエリー
	$args = [
		'post_type' => [
			'breed',
			'zoo',
			'shop',
			'food',
			'trivia',
			'page',
		],
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'orderby' => 'modified',
	];
	$query = new WP_Query($args);
	while($query->have_posts()) {
		$query->the_post();
		// URL
		$permalink = urldecode(get_permalink());
		// 編集日
		$lastmod = get_the_modified_date('Y-m-d');
		// noindexかどうか
		$noindexFlag = get_post_meta(get_the_ID(), 'noindex', true);
		// canonicalを上書きしてるか
		$canonicalFlag = get_post_meta(get_the_ID(), 'canonical', true);
		if($noindexFlag || !empty($canonicalFlag) || in_array($permalink, $excludes, true)) continue;
		$pages[] = "<url><loc>{$permalink}</loc><lastmod>{$lastmod}</lastmod></url>\n";
	}
	return $pages;
}

function getStaticPage() {
	$staticPages = [];
	// フロントページ
	$homeUrl = home_url();
	$frontFile = get_template_directory() . '/front-page.php';
	$frontPageLastmod = date('Y-m-d', filemtime($frontFile));
	$staticPages[] = "<url><loc>{$homeUrl}</loc><lastmod>{$frontPageLastmod}</lastmod></url>\n";
	// アーカイブページ
	$archives = [
		'breed',
		'zoo',
		'shop',
		'food',
		'trivia',
	];
	$archiveFile = get_template_directory() . '/archive.php';
	$archivePageLastmod = date('Y-m-d', filemtime($archiveFile));
	foreach ($archives as $archive) {
		$staticPages[] = "<url><loc>{$homeUrl}/{$archive}/</loc><lastmod>{$archivePageLastmod}</lastmod></url>\n";
	}
	// タクソノミーページ
	$taxonomies = [
		'goods',
		'method',
		'species',
		'morph',
		'diseases',
		'cross',
	];
	$taxonomyFile = get_template_directory() . '/taxonomy.php';
	$taxonomyPageLastmod = date('Y-m-d', filemtime($taxonomyFile));
	foreach ($taxonomies as $taxonomy) {
		$terms = get_terms([
			'taxonomy' => $taxonomy,
			'hide_empty' => true,
		]);
		if(!empty($terms)) {
			foreach ($terms as $term) {
				$termLink = get_term_link($term);
				$staticPages[] = "<url><loc>{$termLink}</loc><lastmod>{$taxonomyPageLastmod}</lastmod></url>\n";
			}
		}
	}
	return $staticPages;
}

function createTags() {
	$start = [
		'<?xml version="1.0" encoding="UTF-8"?>' . "\n",
		'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n",
	];
	$end = ['</urlset>'];
	$staticPages = getStaticPage();
	$postPages = getPostPage();
	return implode(array_merge($start, $staticPages, $postPages, $end));
}

function writeSitemap($tags) {
	$xmlFile = $_SERVER['DOCUMENT_ROOT'] . '/sitemap.xml';
	if(file_exists($xmlFile)) {
		$writeFile = fopen($xmlFile,'w');
		fwrite($writeFile, $tags);
		fclose($writeFile);
	} else {
		echo '書き込み失敗';
	}
}

$tags = createTags();
writeSitemap($tags);

?>
