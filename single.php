<?php get_header();?>
  <div class="container blog-body">
    <div class="single-post">
<?php
if (have_posts()) {

  while (have_posts()) {

    the_post();
    get_template_part('inc/contents/content', get_post_format());

  }

  wp_reset_query();

}
?>
    </div>
<?php
if ( comments_open() ) {
?>
    <div id="post-comments" class="post-comments">
      <?php comments_template();?>
    </div>
<?php
}
?>
  </div>
<?php
$prev_post = get_previous_post_link('%link', '<i class="iconfont icon-xiangzuo1"></i> %title');
$next_post = get_next_post_link('%link', '%title <i class="iconfont icon-xiangyou1"></i>');
if ($prev_post || $next_post) {
?>
  <div class="post-navs">
    <div class="container clearfix">
      <div class="pull-left"><?php echo $prev_post;?></div>
      <div class="pull-right"><?php echo $next_post;?></div>
    </div>
  </div>
<?php
}
get_footer();
?>