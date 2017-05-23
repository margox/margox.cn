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
$prev_post = get_previous_post();
$next_post = get_next_post();
if ($prev_post || $next_post) {
?>
  <div class="post-navs">
<?php
  if ($prev_post) {
    $img_id = get_post_thumbnail_id($prev_post->ID);
?>
    <a href="<?php echo get_permalink($prev_post);?>">
<?php
    if ($img_id) {
?>
      <img src="<?php echo wp_get_attachment_image_src($img_id, 'image-large')[0];?>" alt="<?php echo $prev_post->post_title;?>"/>
<?php
    }
?>
      <small class="tip">上一篇</small>
      <h3 class="title"><?php echo $prev_post->post_title;?></h3>
      <div class="mask"></div>
    </a>
<?php
  }
  if ($next_post) {
    $img_id = get_post_thumbnail_id($next_post->ID);
?>
    <a href="<?php echo get_permalink($next_post);?>">
<?php
    if ($img_id) {
?>
      <img src="<?php echo wp_get_attachment_image_src($img_id, 'image-large')[0];?>" alt="<?php echo $next_post->post_title;?>"/>
<?php
    }
?>
      <small class="tip">下一篇</small>
      <h3 class="title"><?php echo $next_post->post_title;?></h3>
      <div class="mask"></div>
    </a>
<?php
  }
?>
  </div>
<?php
}
get_footer();
?>