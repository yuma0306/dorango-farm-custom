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
        echo '<ul class="breadcrumb">' . "\n";
            echo '<li class="breadcrumb__item"><a class="breadcrumb__link" href="/">トップ</a></li>' . "\n";
            if($ancestorList) {
                foreach($ancestorList as $ancestorItem) {
                    if('publish' !== get_post_status($ancestorItem)) continue;
                    $ancestorLink = get_page_link($ancestorItem);
                    $ancestorTitle = get_post($ancestorItem)->post_title;
                    echo '<li class="breadcrumb__item"><a class="breadcrumb__link" href="'.$ancestorLink.'">'.$ancestorTitle.'</a></li>'."\n";
                }
            }
            echo '<li class="breadcrumb__item"><span class="breadcrumb__text">'.get_the_title().'</span></li>'."\n";
        echo '</ul>'."\n";
    }
}

/**
 * パンクズスキーマの表示
 */
function createBreadcrumbsSchema() {
	// ページ情報
	$currentUri = getCurrentUri();
	$currentPath = getCurrentPath($currentUri);
	$articleTitle = '記事一覧';
	$prefix = [
		"breed" => "飼育繁殖の",
		"zoo" => "動物園の",
		"shop" => "ショップの",
		"food" => "昆虫食の",
		"trivia" => "動物雑学の",
	];
	// パンクズスキーマ
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
	if(is_404()) {
		$breadcrumbs[] = [
			'@type' => 'ListItem',
			'position' => count($breadcrumbs) + 1,
			'name' => 'ページが見つかりません',
			'item' => home_url() . $currentUri
		];
	}
	if(is_archive() && !is_tax()) {
		$archiveTitle = isset($prefix[$currentPath]) ? $prefix[$currentPath] . $articleTitle : $articleTitle;
        $breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => count($breadcrumbs) + 1,
            'name' => $archiveTitle,
            'item' => home_url() . $currentUri
        ];
    }
	if(is_single()) {
		$singleTitle = get_the_title();
		$archiveTitle = isset($prefix[$currentPath]) ? $prefix[$currentPath] . $articleTitle : $articleTitle;
		$breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => count($breadcrumbs) + 1,
            'name' => $archiveTitle,
            'item' => home_url() . "/{$currentPath}/"
        ];
		$breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => count($breadcrumbs) + 1,
            'name' => $singleTitle,
            'item' => home_url() . $currentUri
        ];
    }
	if(is_tax()) {
		$taxTerm = get_queried_object();
		$taxTitle = "「{$taxTerm->name}」に関する記事";
		$breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => count($breadcrumbs) + 1,
            'name' => 'タグ一覧',
            'item' => home_url() . "/tag/"
        ];
		$breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => count($breadcrumbs) + 1,
            'name' => $taxTitle,
            'item' => home_url() . $currentUri
        ];
	}
	if(is_search()){
		global $wp_query;
		$total = $wp_query->found_posts;
		$searchQuery = get_search_query();
		$breadcrumbs[] = [
            '@type' => 'ListItem',
            'position' => count($breadcrumbs) + 1,
            'name' => "「{$searchQuery}」の検索結果（{$total}件）",
            'item' => home_url() . $currentUri
        ];
	}
    echo json_encode([
        '@context' => 'http://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => $breadcrumbs
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
}

/**
 * メインループページネーション
 * https://developer.wordpress.org/reference/hooks/navigation_markup_template/
 * https://developer.wordpress.org/reference/functions/get_the_posts_pagination/
 */
function createPagenation(){
    $pager = get_the_posts_pagination([
        'class' => 'pagination',
        'mid_size' => 2,
        'prev_next' => true,
        'prev_text' => __(''),
        'next_text' => __(''),
    ]);
    $replaceClass = [
		'/<h2 class="screen-reader-text">投稿ナビゲーション<\/h2>/' => '',
        '/<nav class="navigation\s/' => '<nav class="',
        '/<div class="nav-links"/' => '<div class="pagination"',
        '/class="page-numbers\scurrent"/' => 'class="pagination__number pagination__number--current"',
        '/class="next\spage-numbers"/' => 'class="pagination__btn pagination__btn--next"',
        '/class="prev\spage-numbers"/' => 'class="pagination__btn pagination__btn--prev"',
        '/class="page-numbers"/' => 'class="pagination__number"',
        '/class="page-numbers dots"/' => 'class="page-numbers page-numbers--dots"',
    ];
    foreach($replaceClass as $pattern => $replacement) {
        $pager = preg_replace($pattern, $replacement, $pager);
    }
    echo $pager;
}

/**
 * WP_Queryページネーション
 * https://developer.wordpress.org/reference/functions/get_pagenum_link/
 */
function createWpPagination($query) {
	$big = 999999999;
	$pager = paginate_links([
		'base' => str_replace($big,'%#%', esc_url(get_pagenum_link($big))),
		'format' => '/%#%/',
		'current' => max(1, get_query_var('paged')),
		'total' => $query->max_num_pages,
		'mid_size' => 1,
		'prev_next' => true,
		'prev_text' => __(''),
        'next_text' => __(''),
	]);
	$replaceClass = [
        '/class="page-numbers\scurrent"/' => 'class="pagination__number pagination__number--current"',
        '/class="next\spage-numbers"/' => 'class="pagination__btn pagination__btn--next"',
        '/class="prev\spage-numbers"/' => 'class="pagination__btn pagination__btn--prev"',
        '/class="page-numbers"/' => 'class="pagination__number"',
        '/class="page-numbers dots"/' => 'class="page-numbers page-numbers--dots"',
    ];
	if(!empty($pager)) {
		foreach($replaceClass as $pattern => $replacement) {
			$pager = preg_replace($pattern, $replacement, $pager);
		}
		echo "<div class=\"pagination\">{$pager}</div>";
	}
}

/**
 * メタタイトル取得
 */
function getMetaTitle () {
	$blogTitle = esc_html(get_bloginfo('name'));
	$currentUri = getCurrentUri();
	$currentPath = getCurrentPath($currentUri);
	$articleTitle = "記事一覧 | {$blogTitle}";
	$prefix = [
		"breed" => "飼育繁殖の",
		"zoo" => "動物園の",
		"shop" => "ショップの",
		"food" => "昆虫食の",
		"trivia" => "動物雑学の",
	];
	if(is_front_page()) {
		return $blogTitle;
	}
	if(is_404()) {
		return "ページが見つかりません | {$blogTitle}";
	}
	if(is_search()) {
		global $wp_query;
		$total = $wp_query->found_posts;
		$searchQuery = esc_html(get_search_query());
		return "{$searchQuery}」の検索結果（{$total}件 | {$blogTitle}";
	}
	if(is_archive() && !is_tax()) {
		return isset($prefix[$currentPath]) ? $prefix[$currentPath] . $articleTitle : $articleTitle;
	}
	if(is_tax()) {
		$taxTerm = get_queried_object();
		return "「{$taxTerm->name}」に関する記事 | {$blogTitle}";
	}
	$metaTitle = esc_html(get_field('meta_title_field'));
	return "{$metaTitle} | {$blogTitle}";

}

/**
 * メタディスクリプション取得
 */
function getMetaDesc() {
	$blogDesc = esc_html(get_bloginfo('description'));
	$currentUri = getCurrentUri();
	$currentPath = getCurrentPath($currentUri);
	$articleDesc = "記事一覧 | {$blogDesc}";
	$prefix = [
		"breed" => "飼育繁殖の",
		"zoo" => "動物園の",
		"shop" => "ショップの",
		"food" => "昆虫食の",
		"trivia" => "動物雑学の",
	];
	if(is_front_page()) {
		return $blogDesc;
	}
	if(is_404()) {
		return "ページが見つかりません | {$blogDesc}";
	}
	if(is_search()) {
		global $wp_query;
		$total = $wp_query->found_posts;
		$searchQuery = esc_html(get_search_query());
		return "{$searchQuery}」の検索結果（{$total}件 | {$blogDesc}";
	}
	if(is_archive() && !is_tax()) {
		return isset($prefix[$currentPath]) ? $prefix[$currentPath] . $articleDesc : $articleDesc;
	}
	if(is_tax()) {
		$taxTerm = get_queried_object();
		return "「{$taxTerm->name}」に関する記事 | {$blogDesc}";
	}
	if(is_front_page()) {
		return esc_html($blogDesc);
	}
	$metaDesc = esc_html(get_field('meta_title_field'));
	return "{$metaDesc} | {$blogDesc}";
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
	$defaultImage = get_template_directory_uri() . '/assets/img/ogp.webp';
	$ogImage = get_field('og_image_field');
	if(empty($ogImage)) {
		echo esc_url($defaultImage);
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
	$count = 0;
	$tocs = [];
	if(have_rows($acfArticle)) {
		while(have_rows($acfArticle)) {
			the_row();
			$layout = get_row_layout();
			$path = get_template_directory();
			if(file_exists("{$path}/acf/{$layout}.php")) {
				include(get_template_directory() . "/acf/{$layout}.php");
			}
		}
	}
}

/**
 * 目次自動生成
 */
function createToc() {
	$acfArticle = 'flexible_field';
	$count = 1;
	$tocs = [];
	$startHeadingLv = 2;
	$endHeadingLv = 3;
	$pattern = "/^h([\"{$startHeadingLv}-{$endHeadingLv}\"])_layout$/";
	// 一番上の見出し階層
	$currentLv = $startHeadingLv;
	if(have_rows($acfArticle)) {
		while(have_rows($acfArticle)) {
			the_row();
			$layout = get_row_layout();
			if(preg_match($pattern, $layout, $matches)) {
				$headingLv = intval($matches[1]);
				$headingText = get_sub_field("h{$headingLv}_field");
				if($headingLv > $currentLv) {
					$tocs[] = "<li class=\"toc__item\"><ol class=\"toc__list toc__list--lower\">\n";
				} elseif ($headingLv < $currentLv) {
					$tocs[] = "</ol></li>\n";
				}
				$tocs[] = "<li class=\"toc__item toc__item--lv{$headingLv}\"><a href=\"#anchor-{$count}\" class=\"toc__link\">{$headingText}</a></li>";
				$currentLv = $headingLv;
				$count++;
			}
		}
	}
	while ($currentLv > $startHeadingLv) {
		$tocs[] = "</ol></li>\n";
		$currentLv--;
	}
	array_unshift($tocs, '<ol class="toc__list">');
	$tocs[] = '</ol>';
	foreach ($tocs as $toc) {
		echo $toc;
	}
}

function loadCssFile() {
	$currentUri = getCurrentUri();
    $baseUri = get_stylesheet_directory_uri();
    $cssFiles = [
        '/contact/' => '/assets/css/contact.css',
        '/' => [
            'https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide-core.min.css',
            $baseUri . '/assets/css/front-page.css',
        ],
    ];
	// 共通CSS
	echo "<link rel='stylesheet' href='{$baseUri}/assets/css/style.css'>";
    if(isset($cssFiles[$currentUri])) {
        if(is_array($cssFiles[$currentUri])) {
            foreach ($cssFiles[$currentUri] as $cssFile) {
                if (isset($cssFile)) {
                    echo "<link rel='stylesheet' href='{$cssFile}'>";
                }
            }
        } else {
            echo "<link rel='stylesheet' href='{$baseUri}{$cssFiles[$currentUri]}'>";
        }
    }
}

function get_article_file() {
	$currentUri = getCurrentUri();
	$filePath = substr($currentUri, 0, strlen($currentUri) -1);
	$articleFile = get_template_directory() . 'include' . $filePath . '.php';
	if(file_exists($articleFile)) {
		include $articleFile;
		return;
	}
	$indexArticleFile = get_template_directory() . 'include' . $currentUri . 'index.php';
	if(file_exists($indexArticleFile)) {
		include $indexArticleFile;
		return;
	}
}


