<?php
/**
 * 記事本文抜粋表示
 * 使用方法：the_excerpt();
 */
function new_excerpt_mblength($length) {
    // 100文字制限
    return 100;
    // モバイルの際に出しわけ
    // return ( wp_is_mobile() ) ? 35 : 140;
}
add_filter('excerpt_mblength', 'new_excerpt_mblength');
// 抜粋後の文末につける文字
function new_excerpt_more($more) {
     return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');

?>