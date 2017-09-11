<div class="post-author-bio c">
  <a class="post-author-avatar" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
    <?php echo get_avatar(get_the_author_meta('user_email'), 150);?>
  </a>
  <h3 class="post-author-title">
    <a class="post-author-link" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author">
      <?php echo get_the_author(); ?>
    </a>
  </h3>
  <div class="post-author-description">
    <p><?php the_author_meta('description'); ?></p>	
    <div class="post-author-socials">
      <?php
      $author_social_metas = array(
        'url' => '<i class="fa fa-link"></i>',
        'twitter' => '<i class="fa fa-twitter"></i>',
        'facebook' => '<i class="fa fa-facebook"></i>',
        'googleplus' => '<i class="fa fa-google-plus"></i>',
        'pinterest' => '<i class="fa fa-pinterest"></i>',
        'instagram' => '<i class="fa fa-instagram"></i>',
        'tumblr' => '<i class="fa fa-tumblr"></i>',
        'linkedin' => '<i class="fa fa-linkedin"></i>',
        'dribbble' => '<i class="fa fa-dribbble"></i>',
    );
      $output = '';
      foreach ($author_social_metas as $meta => $class) {
        $url = get_the_author_meta($meta);
        if ($url) {
          $output .= '<a href="' . $url . '" target="_blank">' . $class . '</a>';
        }
      }
      echo $output;
      ?>
    </div>
  </div>
</div>
