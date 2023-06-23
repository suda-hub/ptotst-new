<!--
 *
 * WPテーマに必要なタグ
 *
 *
 -->
<!-- タイトルタグ -->
<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
<!-- head閉じタグの直前に置く -->
<?php wp_head(); ?>

<!-- body閉じタグの直前に置く -->
<?php wp_footer(); ?>


<!--
 *
 * パス、リンク
 *
 *
 -->
<!-- ファイルのパス -->
<?php echo get_template_directory_uri(); ?>/
<!-- リンクのパス -->
<?php echo home_url();?>/
<!-- 投稿タイプの一覧ページへのリンク -->
<?php echo get_post_type_archive_link( '投稿タイプのスラッグ' ); ?>
<!-- PHPファイル読み込み -->
<?php require_once(dirname(__FILE__)."/templates/hoge.php"); ?>
<?php get_template_part( 'templates/modules/content', 'cvarea' );?>
<!-- ループ内で記事リンクを取得 -->
<?php the_permalink(); ?>

<!--
 *
 * 既存の関数を実行
 *
 *
 -->
<!-- パンくずリスト表示 -->
<?php breadcrumb();?>
<!-- ページネーションがあれば呼び出し -->
<?php if(function_exists('pagination')){ pagination(); }?>


<!--
 *
 * 記事取得表示ループ
 *
 *
 -->
<?php
$paged = get_query_var('paged');
$args = new WP_Query(
    // 取得する記事の条件
    array(
        'post_type' => 'ポスト名',  // デフォルトなら'post'
        'posts_per_page' => '表示したい件数',
        'paged' => $paged, // 今何ページ目か
        'category_name' => 'slug',

        // カスタムタクソノミー指定
        'tax_query' => array(
            array(
                'taxonomy' => '~~~', // タクソノミーを指定
                'field' => '~~~', // 直下のtermsの種類を指定、name、slug、term_idの中から選択する
                'terms' => '~~~', // fieldの指定に沿って記述する
            )
        ),

        // カスタムフィールド指定
        'meta_key' => 'フィールドのスラッグ',
        'meta_value' => true,
        'meta_compare' => 'LIKE',

        // 記事詳細ページで現在表示中の記事を除外する
        'post__not_in'=> array(get_the_ID())

        // 検索結果表示、変数名は検索フォームで設定したname属性
        's' => $s
    )
);
// ループ
if ( $args->have_posts() ) :
while ( $args->have_posts() ) : $args->the_post();
// ターム情報を取得、0から始まる連想配列で取得される
$term_object = get_the_terms($post->ID,'unique_taxonomy_slug');
// タームの一覧ページのリンク取得
$term_archive_link = home_url().'/'.$term_object[0]->taxonomy.'/'.$term_object[0]->slug.'/';
//現在の投稿タイプスラッグを取得
$current_post_type = get_post_type();
// 投稿のタイトルを取得
$current_title = get_the_title($post->ID);
// カテゴリ取得、複数カテゴリが設定されている場合はforeachで回す
$cat = get_the_category();
$cat_slug = $cat[0]->slug;
$cat_name = $cat[0]->name;

// タグ取得、基本的にはforeachで回す
$set_tags = get_the_tags();
var_dump($set_tags);
?>

    <?php 
    // 記事の更新時から7日間は「NEW」アイコンを出す
    $days = 7;
    $today = date_i18n('U');
    $entry = get_the_time('U');
    $kiji = date('U',($today - $entry)) / 86400 ;
    ;?>
    <?php if( $days > $kiji ) :?>
    <span class="newIcon"></span>
    <?php endif;?>

    
    <!-- 投稿のリンク -->
    <?php the_permalink(); ?>
    <!-- 
    サムネイル取得
    サムネイルの有無の判定、ダミー画像の表示対応。/functions/custom_thumbnail.php内でダミー画像のパスの指定必要あり
     -->
    <?php idot_the_post_thumbnail()?>

    <!-- 投稿のタイトル -->
    <?php the_title(); ?>
    <!-- 投稿の日付 -->
    <?php the_time('Y/m/d'); ?>
    <!-- 本文表示 -->
    <?php the_content(); ?>
    <!-- 本文抜粋表示 -->
    <?php the_excerpt(); ?>

<?php endwhile; endif; wp_reset_postdata();?>

<!-- アドバンスドカスタムフィールドの出力 
参考記事
http://kotori-blog.com/wordpress/acf_output/
-->
<?php 
// 複数あれば配列に入れる
$cus_fields = array(
    'field名01' => get_field('field名01'),
    'field名02' => get_field('field名02'),
);

// 出力
echo $cus_fields['field名01'];

?>

<!--
 *
 * タクソノミー・ターム関連
 *
 *
 -->
<?php
// archive.php, page.phpで取得する際に便利
// 戻り値　配列
// タクソノミー スラッグより、タームの一覧情報を取得する
$term_all = get_terms('タクソノミーのスラッグ');

// archive.php, taxnomy.phpとかで便利
// クエリされているタクソノミーとタームを元に、現在のターム情報を取得
$now_terms = get_term_by('slug',get_query_var('term'),get_query_var('taxonomy'));

// ループ中で、ターム情報を取得するとき
// 戻り値　配列
get_the_terms( $post->ID, 'タクソノミースラッグ');

// ターム一覧へのリンクを取得する
echo get_term_link('ターム名','タクソノミー名')

?>


<!--
 * 検索に関するもの
 * 
 * 
 * 検索結果の情報取得   
 -->
<?php 
var_dump($s); // 検索フォームに入力した情報が入っている
$_GET['post_type'] // 検索した際のURLが次のようになり、post_type=hogehoge、hogehogeを取得できる
?>
<!--
 * サイト内検索フォーム
 * クラス名をつけて装飾する
 *
 -->
<form action="<?php echo home_url( '/' ); ?>" role="search" method="get">
<?php 
// 検索した文言を、結果表示画面で入力欄に表示したい時
$value_text = get_search_query() ? get_search_query() : $_GET['s'];
if( empty( $value_text ) ){
    $value_text = $_GET['text'];
}
?>
    <!-- 検索文言 入力箇所 -->
    <input type="text" placeholder="Search free words" name="s" value="<?php echo $value_text;?>">
    <!-- もしも、入力以外に検索範囲を絞り込みたい時は、hiddenフィールドに入れる -->
    <input type="hidden" name="post_type" value="<?php echo $post_name;?>">
    <!-- 送信ボタン -->
    <input type="submit" value=" ">
</form>


<!--
 * カテゴリの一覧表示
 * 
 *
 -->
<?php 
$term_all = get_terms('category');
$now_terms = get_category( $cat );
// カレント表示にこちらのフラグを使う
$flg = false;
if( is_home() ){
    $flg = true;
}
?>
<!-- 記事一覧ページへのリンクを表示する -->
<li class="<?php if( $flg ){echo '-active';}?>"><a href="<?php echo home_url();?>/blog/">全て</a></li>
<!-- カテゴリ一覧出力 -->
<?php foreach( $term_all as $term ):
$flg = false;
if( is_category() && $term->slug == $now_terms->slug ){
    $flg = true;
}
?>
<li class="<?php if( $flg ){echo '-active';}?>"><a href="<?php echo get_term_link($term->slug,'category');?>"><?php echo $term->name;?></a></li>
<?php endforeach;?>

<!--
 * SNSシェアボタンに使う現在のページのURLとタイトル
 * 
 *
 -->
<?php 
$shareTitle = rawurlencode(get_the_title());
$shareURL = rawurlencode(get_permalink());
?>
<!-- facebook -->
<div class="fb-like" data-href="<?php echo $shareURL?>" data-width="" data-layout="button" data-action="like" data-size="small" data-share="true"></div>
<!-- twitter -->
<a href="//twitter.com/share?text=<?php echo $shareTitle ?>&url=<?php echo $shareURL;?>" class="twitter-share-button" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>