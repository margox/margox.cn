<?php
if (post_password_required()) {
    return;
}
?>
<div class="post-comments" id="comments">
    
<?php
$comment_count = $post->comment_count;
if ($comment_count == 0) {
?>
    <div class="no-comments"><span>该文章暂无评论，赶快抢占沙发！</span></div>
<?php
} else {
  echo '<h3 class="comments-caption">共' . $comment_count . '条评论</h3>';
}
?>
<?php

if (have_comments()) {

    echo '<ol class="comment-list" id="post-comments-list">';
    wp_list_comments(array('avatar_size' => 120));
    echo '</ol>';

    if (get_comment_pages_count() > 1 && get_option('page_comments')) {
        echo '<div class="comment-pager">'; 
        paginate_comments_links(array('prev_text' => '<i class="iconfont icon-left"></i>', 'next_text' => '<i class="iconfont icon-right"></i>'));
        echo '</div>';
    }

}

if (!comments_open()) {
?>
    <div class="comment-off">抱歉，该文章已关闭评论。</div>
<?php
} else {
?>
    <div class="post-comment-form">
<?php
    wp_enqueue_script('comment-reply');
    comment_form();
?>
    </div>
<?php
}
?>
</div>