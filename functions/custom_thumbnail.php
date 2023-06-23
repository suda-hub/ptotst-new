<?php 

/*
アイキャッチ設定や記事内の画像有無によって、画像を出し分ける関数
サイズの指定などの基本的な使い方は、the_post_thumbnail()と同じ
仕様方法
ループ内
<?php idot_the_post_thumbnail(); ?>

ループ外
<?php idot_the_post_thumbnail( 記事ID, 'サイズ指定' ); ?>
*/

if ( ! function_exists( 'idot_get_post_thumbnail' ) ) {
  function idot_get_post_thumbnail( $post_id = null, $size = 'post-thumbnail' ) {
    if ( has_post_thumbnail( $post_id ) ) {
      $thumbnail_id = get_post_thumbnail_id( $post_id );
      $thumbnail_url = wp_get_attachment_image_url( $thumbnail_id, $size );
      $thumbnail_alt = get_post_meta( $thumbnail_id, '_wp_attachment_image_alt', true );
      $thumbnail_title = get_the_title( $thumbnail_id );

      if ( empty( $thumbnail_alt ) ) {
        $thumbnail_alt = $thumbnail_title ? $thumbnail_title : get_the_title( $post_id );
      }
    } else {
      preg_match( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_the_content( $post_id ), $matches );
      $thumbnail_url = ! empty( $matches[1] ) ? $matches[1] : get_theme_file_uri( '/assets/images/_common/no-thumbnail.jpg' );
      $thumbnail_alt = get_the_title( $post_id );
    }

    return sprintf(
      '<img src="%s" alt="%s">',
      esc_url( $thumbnail_url ),
      esc_attr( $thumbnail_alt )
    );
  }
}

if ( ! function_exists( 'idot_the_post_thumbnail' ) ) {
  function idot_the_post_thumbnail( $post_id = null, $size = 'post-thumbnail' ) {
    echo idot_get_post_thumbnail( $post_id, $size );
  }
}

?>