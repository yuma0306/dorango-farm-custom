<?php

/**
 * デバック用関数
 */
function d() {
    echo '<pre style="position: relative; z-index: 10000; background:#fff; color:#4f5b93; border:2px solid #7a86b8; margin:5px; padding:5px; font-size:14px; line-height:1.8;">';
    // 関数に渡された引数を一つずつvar_dumpする
    foreach(func_get_args() as $item) {
        var_dump($item);
    }
    echo '</pre>';
}

/**
 * パタメータを除いたルートパスを取得
 */
function getCurrentUri() {
    $uri = $_SERVER['REQUEST_URI'];
    if(strstr($uri, '?')) {
        $uri = strtok($uri, '?');
    }
    return $uri;
}

/**
 * 使用されているテンプレートを取得
 */
function getCurrentTemplate() {
    $template = get_page_template();
    $template = pathinfo($template, PATHINFO_FILENAME);
    return $template;
}

/**
 * 現在のディレクトリ（第一階層を取得）
 */
function getCurrentPath($uri) {
    $path = explode('/', trim($uri, '/'));
    return $path[0];
}

/**
 * 末尾のディレクトリを取得
 */
function getEndPath() {
    $uri = rtrim($_SERVER['REQUEST_URI'], '/');
    $uri = substr($uri, strrpos($uri, '/') + 1);
    if(strstr($uri, '?')) {
        $uri = strtok($uri, '?');
    }
    return $uri;
}

/**
 * 固定ページテンプレートのパンクズ表示
 */
function displayBreadcrumnbs() {
    if(get_post_type() === 'page') {
        global $post;
        $ancestorList = array_reverse(get_post_ancestors($post));
        echo '<ul class-"breadcrumb">' . "\n";
            echo '<li class-"breadcrumb__item"><a class-"breadcrumb__link" href="/">トップ</a></li>' . "\n";
            if($ancestorList) {
                foreach($ancestorList as $ancestorItem) {
                    if('publish' !== get_post_status($ancestorItem)) continue;
                    $ancestorLink = get_page_link($ancestorItem);
                    $ancestorTitle = get_post($ancestorItem)->post_title;
                    echo '<li class-"breadcrumb__item"><a class-"breadcrumb__link" href="'.$ancestorLink.'">'.$ancestorTitle.'</a></li>'."\n";
                }
            }
            echo '<li class-"breadcrumb__item"><span class-"breadcrumb__text">'.get_the_title().'</span></li>'."\n";
        echo '</ul>'."\n";
    }
}

/**
 * 固定ページテンプレートのパンクズ表示
 */
function createBreadcrumbsSchema() {
    $breadcrumbs = [];
    $breadcrumbs[] = [
        '@type' => 'ListItem',
        'position' => 1,
        'name' => 'トップ',
        'item' => 'https://dorango-farm.com'
    ];
    if(is_page()) {
        $page = get_queried_object();
        $ancestors = get_ancestors($page->ID, 'page');
        $ancestors = array_reverse($ancestors);
        foreach($ancestors as $ancestorId) {
            $ancestorPage = get_post($ancestorId);
            $breadcrumbs[] = [
                '@type' => 'ListItem',
                'position' => count($breadcrumbs) + 1,
                'name' => $ancestorPage->post_title,
                'item' => get_permalink($ancestorPage)
            ];
        }
        // 現在の固定ページのリンクを追加
        $breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => count($breadcrumbs) + 1,
            'name' => $page->post_title,
            'item' => get_permalink($page)
        ];
    }
    echo json_encode([
        '@context' => 'http://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $breadcrumbs
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

/**
 * ページネーションカスタマイズ
 * https://developer.wordpress.org/reference/hooks/navigation_markup_template/
 * https://developer.wordpress.org/reference/functions/get_the_posts_pagination/
 */
function createPagenation(){
    $pager = [
        'class' => 'pagination',
        'mid_size' => 2,
        'prev_next' => true,
        'prev_text' => __('<span>戻る</span>'),
        'next_text' => __('<span>次へ</span>'),
    ];
    $replaceclasses = [
        '/<h2 class-"screen-reader-text">(.*)<\/h2>/' => '',
        '/<nav class-"navigation\s/' => '<nav class="',
        '/<div class-"nav-links"/' => '<div class="pagination__inner">',
        '<li>/' => '<li class="pagination__item">',
        '/class="page-numbers\scurrent"/' => 'class="pagination__number pagination__number--current"',
        '/class="next\spage-numbers"/' => 'class="pagination__btn pagination__btn--next"',
        '/class="prev\spage-numbers"/' => 'class="pagination__btn pagination__btn--prev"',
        '/class="page-numbers"/' => 'class="pagination__number"',
    ];
    foreach($replaceclasses as $pattern => $replacement) {
        $pager = preg_replace($pattern, $replacement, $pager);
    }
    echo $pager;
}

/**
 * メタタイトル取得
 */
function getMetaTitle () {
	$blogTitle = get_bloginfo('name');
	if(is_front_page()) {
		return esc_html($blogTitle);
	}
	$metaTitle = esc_html(get_field('meta_title_field') . '|'  . $blogTitle);
	return $metaTitle;
}

/**
 * メタディスクリプション取得
 */
function getMetaDesc() {
	$blogDesc = esc_html(get_bloginfo('description'));
	if(is_front_page()) {
		return esc_html($blogDesc);
	}
	$metaDesc = esc_html(get_field('meta_desc_field') . '|'  . $blogDesc);
	return $metaDesc;
}

/**
 * カノニカルタグを取得
 */
function getCanonical() {
	$currentUri = getCurrentUri();
	$canonical = get_field('canonical_field');
	if(empty($canonical)) {
		echo esc_url('https://dorango-farm.com' . $currentUri);
	} else {
		echo esc_url($canonical);
	}
}

/**
 * og:urlを取得
 */
function getOgUrl() {
	$currentUri = getCurrentUri();
	$ogUrl = get_field('og_url_field');
	if(empty($ogUrl)) {
		echo esc_url('https://dorango-farm.com' . $currentUri);
	} else {
		echo esc_url($ogUrl);
	}
}

/**
 * og:imageを取得
 */
function getOgImage() {
	$defaultImage = '/assets/ogp.webp';
	$ogImage = get_field('og_image_field');
	if(empty($ogImage)) {
		echo esc_url('https://dorango-farm.com' . $defaultImage);
	} else {
		echo $ogImage;
	}
}

/**
 * noindex・nofollow
 */
function isNoindex() {
	$isNoindex = get_field('noindex_field');
	$isNofollow = get_field('nofollow_field');
	if($isNoindex && $isNofollow) {
		echo '<meta name="robots" content="none">';
	} elseif($isNoindex && !$isNofollow) {
		echo '<meta name="robots" content="noindex">';
	} elseif(!$isNoindex && $isNofollow) {
		echo '<meta name="robots" content="nofollow">';
	}
}

/**
 * adf component取得
 */
function getAcfArticle() {
	$acfArticle = 'flexible_field';
	// $count = 0;
	// $tocs = [];
	if(have_rows($acfArticle)) {
		while(have_rows($acfArticle)) {
			the_row();
			$layout = get_row_layout();
			$path = get_template_directory();
			if(file_exists("{$path}/acf/{$layout}.php")) {
				// include(get_template_directory() . "/acf/{$layout}.php");
				get_template_part("acf/{$layout}");
			}
		}
	}
}

// function getAcfArticle() {
// 	$tocs = [];
// 	$tocsCount = 0;
// 	$acfArticle = 'flexible_field';
// 	if(have_rows($acfArticle) ) {
// 		while(have_rows($acfArticle)) {
// 			the_row();
// 			$layout = get_row_layout();
// 			$path = get_template_directory();
// 			if(file_exists("{$path}/acf/{$layout}.php")) {
// 				get_template_part("acf/{$layout}");
// 			}
// 		}
// 	}
// }

