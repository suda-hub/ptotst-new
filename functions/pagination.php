<?php 
/**
 * pagination
 * ページネーション用
 */
function pagination($pages = '', $range = 2){
    $showitems = ($range * 1)+1;
    global $paged;
    global $maxPager;
    if(empty($paged)) $paged = 1;
    if($pages == ''){
        global $wp_query;
        $pages = $wp_query->max_num_pages;
        if(!$pages){
            $pages = 1;
        }
    }
    if(1 != $pages){
        $img_pass = get_template_directory_uri();
        echo "<div class=\"m-pagination\">";

        // 「1/2」という表示
        // echo "<div class=\"m-pagination__result\">". $paged."/". $pages."</div>";
        
        // 「前へ」を表示
        // if($paged > 1) echo "<div class=\"m-pagination__prev\"><a href='".get_pagenum_link($paged - 1)."'>前へ</a></div>";

        echo "<ol class=\"m-pagination__body\">\n";
        for ($i=1; $i <= $pages; $i++){
            if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
                echo ($paged == $i)? "<li class=\"current\">".$i."</li>":
                    "<li><a href='".get_pagenum_link($i)."'>".$i."</a></li>";
            }
        }

        // [...] 表示
        // if(($paged + 4 ) < $pages){
        //     echo "<li class=\"notNumbering\">...</li>";
        //     echo "<li><a href='".get_pagenum_link($pages)."'>".$pages."</a></li>";
        // }

        echo "</ol>\n";

        // 「次へ」を表示
        // if($paged < $pages) echo "<div class=\"m-pagination__next\"><a href='".get_pagenum_link($paged + 1)."'>次へ</a></div>";

        echo "</div>\n";
    }
}
?>