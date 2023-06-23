<?php 
/**
 * breadcrumb
 * ぱんくずリスト
 * 「slug、一覧( 通常の投稿一覧ページの名前とslug )」と、$defaultsのhome,newsの文言はサイトに応じて変更する
 */
function breadcrumb( $args = array() ){
    global $post;
    $str ='';
    $defaults = array(
        'id' => "breadcrumb",
        'class' => "clearfix",
        'home' => "HOME",
        'news' => "BLOG一覧",
        'search' => "で検索した結果",
        'tag' => "タグ",
        'author' => "投稿者",
        'notfound' => "404 Not found",
    );

    $args = wp_parse_args( $args, $defaults );
    extract( $args, EXTR_SKIP );
        if( is_home() ) {
            echo  '<div class="c-breadcrumb"><ol><li><a href="'.home_url().'">'. $home .'</a></li><li>'. $news .'</li></ol></div>';
        }
        if( !is_home() && !is_admin() ){
            $str.= '<div class="c-breadcrumb"><ol>';
            $str.= '<li><a href="'. get_option('home') .'">HOME</a></li>';
            $my_taxonomy = get_query_var( 'taxonomy' );
            $cpt = get_query_var( 'post_type' );

        if( $my_taxonomy && is_tax( $my_taxonomy ) ) {
            $my_tax = get_queried_object();
            $post_types = get_taxonomy( $my_taxonomy )->object_type;
            $cpt = $post_types[0];
            $now_post_type = get_post_type();
            $str.='<li><a href="' . get_post_type_archive_link( $now_post_type ). '">'. get_post_type_object( $cpt )->label .'</a></li>';
            if( $my_tax -> parent != 0 ) {
              $ancestors = array_reverse( get_ancestors( $my_tax -> term_id, $my_tax->taxonomy ) );

              foreach( $ancestors as $ancestor ){
                  $str.='<li><a href="'. get_term_link( $ancestor, $my_tax->taxonomy ) .'">'. get_term( $ancestor, $my_tax->taxonomy )->name .'</a></li>';
            }
        }
            $str.='<li>'. $my_tax -> name . '</li>';
        }

        elseif( is_category() ) {
            $cat = get_queried_object();
            if( $cat -> parent != 0 ){
                $ancestors = array_reverse( get_ancestors( $cat -> cat_ID, 'category' ));
                foreach( $ancestors as $ancestor ){
                    $str.='<li><a href="'. get_category_link( $ancestor ) .'">'. get_cat_name( $ancestor ) .'</a></li>';
                }
            }
            $str.='<li><a href="'. home_url() .'/slug/">'. $news .'</a></li><li>'. $cat -> name . '</li>';
        }

        elseif( is_post_type_archive() ) {
            $cpt = get_query_var( 'post_type' );
            $str.='<li>'. get_post_type_object( $cpt )->label . '</span></li>';
        }

        elseif( $cpt && is_singular( $cpt ) ){
            $taxes = get_object_taxonomies( $cpt );
            if( !empty($taxes) ){
                $mytax = $taxes[0];
                 $now_post_type = get_post_type();
                $str.='<li><a href="' . get_post_type_archive_link( $now_post_type ). '">'. get_post_type_object( $cpt )->label .'</a></li>';
                $taxes = get_the_terms( $post->ID, $mytax );
                $tax = get_youngest_tax( $taxes, $mytax );

                if( $tax -> parent != 0 ){
                    $ancestors = array_reverse( get_ancestors( $tax -> term_id, $mytax ) );
                    foreach( $ancestors as $ancestor ){
                        $str.='<li><a href="'. get_term_link( $ancestor, $mytax ).'">'. get_term( $ancestor, $mytax )->name . '</a></li>';
                    }
                }
                $str.='<li><a href="'. get_term_link( $tax, $mytax ).'">'. $tax -> name . '</a></li>';
                $str.= '<li>'. $post -> post_title .'</li>';
            }else{
                $str.= '<li>'. $post -> post_title .'</li>';
            }
        }
        elseif( is_single() ){
            $categories = get_the_category( $post->ID );
            $cat = get_youngest_cat( $categories );
            if( $cat -> parent != 0 ){
                $ancestors = array_reverse( get_ancestors( $cat -> cat_ID, 'category' ) );
                foreach( $ancestors as $ancestor ){
                    $str.='<li><a href="'. get_category_link( $ancestor ).'">'. get_cat_name( $ancestor ). '</a></li>';
                }
            }

            $str.='<li><a href="'.home_url().'/slug/">一覧</a></li>';
            $str.='<li><a href="'. get_category_link( $cat -> term_id ). '">'. $cat-> cat_name . '</a></li>';
            $str.='<li>'.mb_strimwidth(get_the_title($post->ID), 0 , 80, '…', 'UTF-8').'</li>';
        }

        elseif( is_page() ){
            if( $post -> post_parent != 0 ){
                $ancestors = array_reverse( get_post_ancestors( $post->ID ) );
                foreach( $ancestors as $ancestor ){
                    $str.='<li><a href="'. get_permalink( $ancestor ).'">'. get_the_title( $ancestor ) .'</a></li>';
                }
            }
            $str.= '<li>'. $post -> post_title .'</li>';
        }

        elseif( is_date() ){
            if( get_query_var( 'day' ) != 0){
                $str.='<li><a href="'. get_year_link(get_query_var('year')). '">' . get_query_var( 'year' ). '年</a></li>';
                $str.='<li><a href="'. get_month_link(get_query_var( 'year' ), get_query_var( 'monthnum' ) ). '">'. get_query_var( 'monthnum' ) .'月</a></li>';
                $str.='<li>'. get_query_var('day'). '日</span></li>';
        }

        elseif( get_query_var('monthnum' ) != 0){
            $str.='<li><a href="'. get_year_link( get_query_var('year') ) .'">'. get_query_var( 'year' ) .'年</a></li>';
            $str.='<li>'. get_query_var( 'monthnum' ). '月</span></li>';
        }

        else {
            $str.='<li>'. get_query_var( 'year' ) .'年</span></li>';
        }
        }

        elseif( is_search() ) {
            $str.='<li>「'. get_search_query() .'」'. $search .'</span></li>';
        }

        elseif( is_author() ){
            $str .='<li>'. $author .' : '. get_the_author_meta('display_name', get_query_var( 'author' )).'</span></li>';
        }

        elseif( is_tag() ){
            $nowInfo = get_queried_object();
            $nowInfo_name = $nowInfo->name;
            $str.='<li>'. $nowInfo_name .'</span></li>';
        }

        elseif( is_attachment() ){
            $str.= '<li>'. $post -> post_title .'</li>';
        }

        elseif( is_404() ){
            $str.='<li>'.$notfound.'</li>';
        }

        else{
            $str.='<li>'. wp_title( true ) .'</li>';
        }

            $str.='</ol></div>';
        }
    echo $str;
}
function get_youngest_cat( $categories ){
    global $post;
    if(count( $categories ) == 1 ){
        $youngest = $categories[0];
    }
    else{
        $count = 0;
        foreach( $categories as $category ){
            $children = get_term_children( $category -> term_id, 'category' );
            if($children){
                if ( $count < count( $children ) ){
                    $count = count( $children );
                    $lot_children = $children;
                    foreach( $lot_children as $child ){
                        if( in_category( $child, $post -> ID ) ){
                            $youngest = get_category( $child );
                        }
                    }
                }
            }
            else{
                $youngest = $category;
            }
        }
    }
    return $youngest;
}
function get_youngest_tax( $taxes, $mytaxonomy ){
    global $post;
    if( count( $taxes ) == 1 ){
        $youngest = $taxes[ key( $taxes )];
    }
    else{
        $count = 0;
        foreach( $taxes as $tax ){
            $children = get_term_children( $tax -> term_id, $mytaxonomy );
            if($children){
                if ( $count < count($children) ){
                    $count = count($children);
                    $lot_children = $children;
                    foreach($lot_children as $child){
                        if( is_object_in_term( $post -> ID, $mytaxonomy ) ){
                            $youngest = get_term($child, $mytaxonomy);
                        }
                    }
                }
            }
            else{
                $youngest = $tax;
            }
        }
    }
    return $youngest;
}
?>