<!DOCTYPE html>
<html lang="ja">
<head>
<?php 
// Google analyticsのコードを読み込み
require_once(dirname(__FILE__)."/templates/analytics.php"); ?>
<meta charset="UTF-8"/>
<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title><?php set_meta_title(); ?></title>
<?php /* OGP */ ?>
<meta name="description" content="<?php set_meta_description(); ?>"/>
<meta name="keywords" content=""/>
<meta property="og:title" content="<?php set_meta_title(); ?>">
<meta property="og:site_name" content="<?php bloginfo('name'); ?>">
<?php if (is_front_page()) { ?>
<meta property="og:type" content="website">
<?php } else { ?>
<meta property="og:type" content="article">
<?php } ?>
<meta property="og:description" content="<?php set_meta_description(); ?>">
<meta property="og:url" content="<?php set_meta_ogurl(); ?>">
<meta property="og:image" content="<?php set_meta_image(); ?>" />
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="//////////twitterアカウント/////////////">
<meta name="twitter:title" content="<?php set_meta_title(); ?>">
<meta name="twitter:description" content="<?php set_meta_description(); ?>">
<meta name="twitter:image" content="<?php set_meta_image(); ?>">
<meta name="twitter:url" content="<?php set_meta_ogurl(); ?>">
<?php /* OGPここまで*/ ?>
<?php /* 外部ファイル読み込み*/ ?>
<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/_common/favicon.ico"/>
<link rel="apple-touch-icon-precomposed" href="<?php echo get_template_directory_uri(); ?>/assets/images/_common/touchicon.png" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.min.css">
<?php /* 外部ファイル読み込みここまで*/ ?>
<?php wp_head(); ?>
</head>
<body>
<!-- ヘッダー -->
<header role="banner" class="l-header">
	
</header>

<?php 
if( is_front_page() ){
	require_once(dirname(__FILE__)."/templates/mainvisual.php");
}else{
	require_once(dirname(__FILE__)."/templates/pagevisual.php");
}
?>