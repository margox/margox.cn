      <article id="post-<?php the_ID();?>" <?php post_class('post');?>>
        <div class="post-inner">
          <header class="post-header">
            <h3 class="title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
          </header>
          <div class="post-featured-content">
            <?php echo margox_get_post_gallery($post->ID);?>
          </div>
          <div class="post-excerpt"><?php the_excerpt();?></div>
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