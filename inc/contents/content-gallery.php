      <article id="post-<?php the_ID();?>" <?php post_class('post');?>>
        <div class="post-inner">
          <header class="post-header">
            <h3 class="title"><?php the_title();?></h3>
            <div class="metas">
              <div class="date pull-left">
                <a class="author-link" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author">
                  <?php echo get_the_author(); ?>
                </a>发表于<?php echo format_date(get_the_time("Y-m-d H:i:s"));?>
              </div>
              <div class="categories pull-left"><?php the_category(',', 'single');?></div>
              <div class="comments pull-left"><?php comments_popup_link('暂无评论', '1条评论', '%条评论'); ?></div>
              <div class="share pull-right"><a href="javascript:void(0);" class="btn-show-qrcode"><i class="iconfont icon-qrcode"></i></a><div class="post-qrcode"><img src="<?php echo margox_generate_qrcode(urlencode(get_permalink()));?>"></div></div>
            </div>
          </header>
          <div class="post-featured-content">
            <?php echo margox_get_post_gallery($post->ID);?>
          </div>
          <div class="post-content markdown-body"><?php the_content();?></div>
        </div>
      </article>