<?php get_header();?>
  <div class="container blog-body">
    <div class="post-list">
<?php
if (have_posts()) {
  while (have_posts()) {
    the_post();
    get_template_part('inc/contents/excerpt', get_post_format());

  }
  wp_reset_query();
}
?>
    </div>
    <div class="post-pagers">
<?php
global $wp_query;
$big = 999999999;
echo paginate_links(array(
  'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
  'format' => '?paged=%#%',
  'current' => max(1, get_query_var('paged')),
  'total' => $wp_query->max_num_pages,
  'prev_next' => true,
  'prev_text' => '<i class="iconfont icon-left"></i><b>上一页</b>',
  'next_text' => '<i class="iconfont icon-right"></i><b>下一页</b>'
));
?>
    </div>
  </div>
<?php get_footer();?>