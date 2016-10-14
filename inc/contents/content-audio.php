      <article id="post-<?php the_ID();?>" <?php post_class('post');?>>
        <header class="post-header">
          <h3 class="title"><a href="<?php the_permalink();?>" target="_blank"><?php the_title();?></a></h3>
        </header>
        <div class="post-featured-content">
<?php
$post_audio = margox_get_post_audio($post->ID);
$post_audio = explode('|', $post_audio);
?>
          <div class="post-audio" id="post-audio-<?php echo $post->ID;?>">
            <div class="post-audio-obj" data-id="<?php echo $post->ID;?>" data-audio="<?php echo $post_audio[0];?>"></div>
<?php
if (has_post_thumbnail()) {
  $cover_img_id = get_post_thumbnail_id($post->ID);
  $cover_img_src = wp_get_attachment_image_src($cover_img_id, 'thumbnail');
?>
            <div class="cover" style="background-image: url(<?php echo $cover_img_src[0];?>);">
<?php
} else {
?>
            <div class="cover">
<?php
}
?>
              <a href="javascript:void(0);" class="btn-play-pause" data-id="<?php echo $post->ID;?>">
                <i class="iconfont icon-play"></i>
                <i class="iconfont icon-pause"></i>
              </a>
            </div>
            <h5 class="caption"><?php echo $post_audio[1] ? $post_audio[1] : '未知名称';?></h5>
            <h6 class="sub-caption"><?php echo $post_audio[2] ? $post_audio[2] : '未知歌手';?> / <?php echo $post_audio[3] ? $post_audio[3] : '未知专辑';?></h6>
            <div class="progress">
              <span class="played-time">00:00</span>
              <span class="total-time">00:00</span>
              <span class="progress-bar"></span>
            </div>
          </div>
        </div>
<?php
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