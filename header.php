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
  <header class="blog-header">
    <div class="container">
      <h1 class="logo"><span>I am Margox</span></h1>
      <ul class="menu pull-left">
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
      <div class="searcher pull-right">
        <form action="<?php echo home_url();?>">
          <input type="text" name="s" id="J-hearder-search-input" placeholder="按回车搜索" class="hearder-search-input">
          <label class="btn-search" for="J-hearder-search-input"><i class="iconfont icon-search"></i></label>
        </form>
      </div>
    </div>
    <div id="J-header-progress-bar" class="progress-bar"></div>
  </header>