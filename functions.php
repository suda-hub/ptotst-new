<?php

/* 
ファンクション
必要のないものはコメントアウトする。

*/
require_once('functions/init.php');
require_once('functions/custom_ogp.php');
require_once('functions/custom_thumbnail.php');
require_once('functions/post_content_expert.php');
require_once('functions/pagination.php');
require_once('functions/breadcrumbs.php');


/**
 * pre_get_posts
 * メインクエリを一時的に使ってループ
 * カテゴリなどの自動取得にはこちらの関数が便利 : get_queried_object()
 */
add_action( 'pre_get_posts', 'my_pre_get_posts' );
function my_pre_get_posts( $query ) {
    if ( is_admin() || ! $query -> is_main_query() ) return;
    
    // is_~の条件分岐タグを使ってページごとの設定をする
    // if ( $query -> is_home() ) {
    //     $paged = get_query_var('paged');
    //     $query -> set( 'posts_per_page', '' );
    //     $query -> set( 'paged', $paged );
    // }
}


/**
 * shotrcode_name
 * ショートコード用の関数
 * returnで返す内容を書くことで、画面に表示する内容が変わる
 */
// function shotrcode_name($attr) {
// 	return 'ショートコード';
// }
// add_shortcode('short', 'shotrcode_name');


/*-------------------*
  SEO関連の設定、OGP等
 *-------------------*/
/**
 * set meta title
 * 記事詳細ページでは記事のタイトルを出力し、それ以外のページでは「ページタイトル | サイト名」を出す
 */
function set_meta_title() {
    if ( is_single() ) {
      $title = wp_title( '|', true, 'right' ) . " | " . bloginfo('name');
    } else {
      $title = bloginfo('name');
    }
    echo $title;
}

/**
 * set meta description
 * ディスクリプションの情報を取得、表示
 */
function set_meta_description() {
    global $post;

    // 管理画面の設定 > 一般設定 で設定されている、サイトのキャッチフレーズを取得
    $description = get_bloginfo('description');

    // 記事詳細ページでは記事の抜粋文言を設定
    if ( is_single() ) {
        // 記事冒頭を120文字抜粋
        $description = strip_tags($post->post_content);
        $description = str_replace("\n", "", $description);
        $description = str_replace("\r", "", $description);
        $description = mb_substr($description, 0, 120) . "...";
    }
    echo $description;
}


/**
 * set meta url
 * url情報を取得
 */
function set_meta_ogurl() {
    if ( is_front_page() ) {
        echo bloginfo('url');
    } else {
        echo bloginfo('url') . $_SERVER["REQUEST_URI"];
    }
}

/**
 * set meta image
 * og画像を設定、記事詳細と固定ページの時はアイキャッチが設定されていればそちらを優先する
 */
function set_meta_image() {
	$meta_image = get_stylesheet_directory_uri()."/assets/images/_common/ogp.png";
	if (is_single()||is_page()) {
		if (has_post_thumbnail()) {
    		$image_id = get_post_thumbnail_id();
    		$image = wp_get_attachment_image_src( $image_id, 'full');
    		$meta_image = $image[0];
   		}
	}
	echo $meta_image;
}


