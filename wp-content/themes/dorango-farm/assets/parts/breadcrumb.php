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
<div class="p-breadcrumb">
	<div class="p-breadcrumb__inner">
		<ol class="p-breadcrumb__list">
			<li class="p-breadcrumb__item">
				<a href="<?php echo esc_url(home_url()); ?>" class="p-breadcrumb__link">
					<span>ホーム</span>
				</a>
			</li>
			<?php if(is_tag()): ?>
			<li class="p-breadcrumb__item">
				<a class="p-breadcrumb__link" href="<?php echo esc_url(home_url('/tag/')); ?>">
					<span>タグ一覧</span>
				</a>
			</li>
			<li class="p-breadcrumb__item">
				<span><?php echo esc_html($pageTtl); ?></span>
			</li>
			<?php else: ?>
			<li class="p-breadcrumb__item">
				<span><?php echo esc_html($pageTtl); ?></span>
			</li>
			<?php endif; ?>
		</ol>
	</div>
</div>
