<!DOCTYPE html>
<html <?php language_attributes();?>>
<head>
<meta charset="<?php bloginfo( 'charset' );?>">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
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
  <header class="blog-header blured-backdrop-light">
    <div class="container">
      <h1 class="logo"><span>I am Margox</span></h1>
      <input id="J-mobile-menu-trigger-input" class="mobile-menu-trigger-input" type="checkbox">
      <label for="J-mobile-menu-trigger-input" class="mobile-menu-trigger iconfont icon-menu"></label>
      <ul class="menu blured-backdrop-light pull-left">
<?php
$menuParameters = array(
  'theme_location' => 'primary-menu',
  'container' => false,
  'items_wrap' => '%3$s',
  'depth' => 0,
  'echo' => false,
);
echo wp_nav_menu($menuParameters);
?>
      </ul>
      <div id="J-header-searcher" class="searcher pull-right">
        <form action="<?php echo home_url();?>">
          <input type="text" name="s" id="J-hearder-search-input" placeholder="按回车搜索" class="hearder-search-input">
          <label class="btn-search iconfont icon-search" for="J-hearder-search-input"></label>
        </form>
      </div>
    </div>
    <div id="J-header-progress-bar" class="progress-bar"></div>
  </header>