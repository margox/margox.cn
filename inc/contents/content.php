      <article id="post-<?php the_ID();?>" <?php post_class('post');?>>
        <header class="post-header">
<?php
$is_singular = is_singular();
if ($is_singular) {
?>
          <h3 class="title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
<?php
} else {
?>
          <h3 class="title"><?php the_title();?></h3>
<?php
}
?>
        </header>
<?php
if (has_post_thumbnail()) {
  $img_id = get_post_thumbnail_id($post->ID);
  $img_src = wp_get_attachment_image_src($img_id, 'image-large');
?>
        <div class="post-featured-content">
<?php
  if ($is_singular) {
?>
          <a href="<?php echo $img_src[0];?>" data-title="<?php the_title();?>" data-lightbox="lightbox-<?php echo $post->ID?>" class="featured-image">
<?php
  } else {
?>
          <a href="<?php the_permalink();?>" class="featured-image">
<?php
  }
?>
            <img onload="javascript:this.classList.add('loaded');" class="fade-image" width="<?php echo $img_src[1];?>" height="<?php echo $img_src[2];?>" src="<?php echo $img_src[0];?>" alt="<?php the_title();?>"/>
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
            <div class="date pull-left"><?php echo format_date(get_the_time("Y-m-d H:i:s"));?></div>
            <div class="categories pull-left"><?php the_category(',', 'single');?></div>
            <div class="share pull-right"><a href="javascript:void(0);" class="btn-show-qrcode"><i class="iconfont icon-qrcode"></i></a><div class="post-qrcode"><img src="<?php echo margox_generate_qrcode(urlencode(get_permalink()));?>"></div></div>
          </div>
        </footer>
      </article>