<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="format-detection" content="telephone=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="transparent">
<meta name="x5-page-mode" content="app">
<meta name="x5-fullscreen" content="true">
<meta charset="<?php bloginfo('charset');?>">
<link rel="manifest" href="/manifest.json">
<link rel="apple-touch-icon" href="<?php echo get_res_url('images/favicon.png');?>">
<link rel="shortcut icon" href="<?php echo get_res_url('images/favicon.png');?>">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<title><?php wp_title('|', true, 'right');?></title>
<?php
$blog_description = get_bloginfo('description');
if ($blog_description && (is_home() || is_front_page())) {
?>
<meta name="description" content="<?php echo $blog_description;?>">
<?php
}else{
?>
<meta name="description" content="<?php wp_title();?>">
<?php
}
?>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo('pingback_url');?>">
<?php wp_head();?>
</head>
<body <?php body_class();?>>
  <header class="blog-header">
    <h1 class="logo pull-left"><span>超能刚哥</span></h1>
    <input id="J-mobile-menu-trigger-input" class="mobile-menu-trigger-input" type="checkbox">
    <label for="J-mobile-menu-trigger-input" class="mobile-menu-trigger iconfont icon-menu"><span>菜单栏</span></label>
    <div class="menu pull-left">
<?php
$menuParameters = array(
  'menu' => 'primary-menu',
  'container' => false,
  // 'items_wrap' => '%3$s',
  'menu_class' => 'menu-ul',
  'depth' => 0,
  'echo' => false,
);
echo wp_nav_menu($menuParameters);
?>
    </div>
    <div id="J-header-searcher" class="searcher pull-right">
      <form action="<?php echo home_url();?>">
        <input type="text" name="s" id="J-hearder-search-input" placeholder="按回车搜索" class="hearder-search-input">
        <label class="btn-search iconfont icon-search" for="J-hearder-search-input"></label>
      </form>
    </div>
    <div id="J-header-progress-bar" class="progress-bar"></div>
  </header>