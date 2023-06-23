<?php
// ヘッダーを取得
get_header();

// コンテンツを取得
if(have_posts()): while(have_posts()): the_post();
	the_content();
endwhile; endif; wp_reset_postdata();

// ページネーションを取得
if(function_exists('pagination')){ pagination(); }

// フッターを取得
get_footer(); 
?>