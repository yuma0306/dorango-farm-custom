<?php
// add_filter( 'wp_img_tag_add_width_and_height_attr', '__return_false' );
// 画像に付与されるsrcset削除
add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
// 画像に付与されるwidthとheight削除
add_filter( 'the_content', 'removeImageAttr');
// 埋め込み用記事の画像のwidthとheight削除（できない）
// add_filter( 'wp_get_attachment_image_attributes', 'removeImageAttr');
function removeImageAttr($html) {
	$html = preg_replace( '/(width|height)="\d*"\s/', '', $html );
	$html = preg_replace('/class=[\'"]([^\'"]+)[\'"]/i', '', $html);
	return $html;
}

?>
