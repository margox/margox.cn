      <article id="post-<?php the_ID();?>" <?php post_class('post');?>>
        <header class="post-header">
          <h3 class="title"><a href="<?php the_permalink();?>" target="_blank"><?php the_title();?></a></h3>
        </header>
<?php
if (has_post_thumbnail()) {
  $img_id = get_post_thumbnail_id($post->ID);
  $img_src = wp_get_attachment_image_src($img_id, 'image-large');
?>
        <div class="post-featured-content">
          <a href="<?php the_permalink();?>" class="featured-image">
            <img src="<?php echo $img_src[0];?>" alt="<?php the_title();?>"/>
          </a>
        </div>
<?php
}
if (!is_singular()) {
?>
        <div class="post-excerpt"><?php the_excerpt();?></div>
<?php
} else {
?>
        <div class="post-content markdown-body"><?php the_content();?></div>
<?php
}
?>
        <footer class="post-footer">
          <div class="metas">
            <div class="date pull-left"><?php the_time(get_option('date_format'));?>&emsp;/&emsp;</div>
            <div class="categories pull-left"><?php the_category(',', 'single');?></div>
            <div class="share pull-right"><a href=""><i class="iconfont icon-share"></i></a></div>
          </div>
        </footer>
      </article>