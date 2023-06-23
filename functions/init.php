<?php 
/*
 基本的なデフォルトの設定ファイル
*/

 
/**
 * アイキャッチ画像有効化
 * 
 */
add_theme_support('post-thumbnails');

/**
 * サムネイルサイズ追加
 * $name = 画像サイズの名前, $width = 横幅, $height = 縦幅, $crop = 切り抜き有無( bool値 )
 */
// add_image_size($name, $width, $height, $crop);



/**
 * 固定ページで現在のページ数が無視されるのを回避
 * ページネーションがバグを起こさないようにするため
 */
add_action( 'parse_query', 'my_parse_query' );
function my_parse_query( $query ) {
  if ( ! isset( $query->query_vars['paged'] ) && isset( $query->query_vars['page'] ) )
    $query->query_vars['paged'] = $query->query_vars['page'];
}

?>