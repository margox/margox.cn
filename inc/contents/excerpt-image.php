      <article id="post-<?php the_ID();?>" <?php post_class('post');?>>
        <div class="post-inner">
<?php
if (has_post_thumbnail()) {
  $img_id = get_post_thumbnail_id($post->ID);
  $img_src = wp_get_attachment_image_src($img_id, 'image-large');
?>
          <div class="post-featured-content">
            <a href="<?php the_permalink();?>" class="featured-image">
              <img onload="javascript:this.classList.add('loaded');" class="fade-image" width="<?php echo $img_src[1];?>" height="<?php echo $img_src[2];?>" src="<?php echo $img_src[0];?>" alt="<?php the_title();?>"/>
            </a>
          </div>
<?php
}
?>
          <footer class="post-footer">
            <div class="metas">
              <div class="date pull-left">
                <a class="author-link" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author">
                  <?php echo get_the_author(); ?>
                </a>发表于<?php echo format_date(get_the_time("Y-m-d H:i:s"));?>
              </div>
              <div class="categories pull-left"><?php the_category(',', 'single');?></div>
              <div class="comments pull-left"><?php comments_popup_link('暂无评论', '1条评论', '%条评论'); ?></div>
            </div>
          </footer>
        </div>
      </article>