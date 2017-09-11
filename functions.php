<?php

// 常量
define('__THEME__', get_template_directory_uri() . '/');
define('__RES__', __THEME__ . 'res/');
define('__ROOT__', get_template_directory() . '/');
define('__INC__', 'inc');

// 设定内容宽度
if (!isset($content_width)) {
  $content_width = 980;
}

// 主题设置
function theme_setup() {

  add_theme_support('automatic-feed-links');

  // 设定支持的文章类型
  add_theme_support('post-formats', array('image', 'audio', 'gallery'));

  // 开启导航栏支持
  add_theme_support('nav-menus');
  register_nav_menus(array(
    'header-menu' => '导航栏菜单'
  ));

  // 开启标题标签支持
  add_theme_support('title-tag');

  // 开启缩略图支持并设定尺寸
  add_theme_support('post-thumbnails');
  set_post_thumbnail_size(980, '', true);
  add_image_size('image-large-2x', 1960, '', true);
  add_image_size('image-large', 980, '', true);
  add_image_size('image-middle', 480, '', true);

  // 移除前台顶栏
  add_filter('show_admin_bar', '__return_false');
  remove_action('init', '_wp_admin_bar_init');

  // 移除默认相册样式
  add_filter('use_default_gallery_style', '__return_false');

}
add_action('after_setup_theme', 'theme_setup');

// 编辑器工具栏
function margox_editor_buttons($buttons) {

  $buttons[] = 'fontselect';
  $buttons[] = 'fontsizeselect';
  $buttons[] = 'backcolor';
  $buttons[] = 'hr';
  $buttons[] = 'sub';
  $buttons[] = 'sup';
  $buttons[] = 'cut';
  $buttons[] = 'copy';
  $buttons[] = 'paste';
  $buttons[] = 'cleanup';
  $buttons[] = 'newdocument';
  $buttons[] = 'pagebreak';
  return $buttons;

}
add_filter("mce_buttons_3", "margox_editor_buttons");

// 网站标题
function new_wp_title($title) {

  if ($title) {
    return $title . get_bloginfo('name');
  } else {
    return get_bloginfo('name');
  }

}
add_filter('wp_title', 'new_wp_title');

// 摘要长度
function margox_excerpt_length($length) {
  return 100;
}
// 摘要后缀
function margox_excerpt_more($more) {
  return "...";
}
add_filter('excerpt_length', 'margox_excerpt_length');
add_filter('excerpt_more', 'margox_excerpt_more');

// 移除谷歌字体
function remove_open_sans_from_wp_core() {
  wp_deregister_style('open-sans');
  wp_register_style('open-sans', false);
  wp_enqueue_style('open-sans', '');
}
add_action('init', 'remove_open_sans_from_wp_core');

// 加载静态资源
function enqueue_assets() {

  // 加载JS
  if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
    wp_enqueue_script('margox-weixin', __RES__ . 'js/libs/weixin-sdk.js', false, '1.2.0', true);
  }
  wp_enqueue_script('margox-highlight', __RES__ . 'js/libs/highlight/highlight.pack.js', false, '1.0.0', true);
  // wp_enqueue_script('margox-fastclick', __RES__ . 'js/libs/fastclick.js', false, '1.0.1', true);
  wp_enqueue_script('margox-lightbox', __RES__ . 'js/libs/lightbox.js', false, '1.0.1', true);
  wp_enqueue_script('margox-scripts', __RES__ . 'js/scripts.js', false, '1.0.24', true);

  // 加载CSS
  wp_enqueue_style('margox-styles', __RES__ . 'css/styles.css', false, '1.0.25');
  wp_enqueue_style('margox-highlight-github', __RES__ . 'js/libs/highlight/styles/github.css', false, '1.0.0');

}
add_action('wp_enqueue_scripts', 'enqueue_assets');

// 获取浏览器语言
function get_browser_lang() {

  $browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'],0,5);
  $browser_lang = strtolower($browser_lang);

  return $browser_lang;

}

// 获取资静态源路径
function get_res_url($path) {
  return __RES__ . $path;
}

// 获取文章相册数据
function margox_get_post_gallery($postid = null) {

  !is_numeric($postid) && $postid = get_the_ID();
  $gallery = get_post_meta($postid, 'margox_meta_gallery', true);

  if (!$gallery) {
    return false;
  }

  $images = $gallery['images'];

  if (is_array($images['urls']) && count($images['urls']) > 0) {

    $html = '<ul class="post-gallery clearfix" id="post-gallery-' . $postid . '">';
    $n = 0;

    foreach ($images['urls'] as $urls) {

      $image_a = explode("|", $urls);
      $image_id = $image_a[2];
      $image_title = get_the_title($image_id);

      $image_url = wp_get_attachment_image_src($image_id, 'image-large');
      $image_url = $image_url[0];
      empty($image_url) && $image_url = $image_a[1];

      $image_thumbnail_url =  wp_get_attachment_image_src($image_id, 'image-middle');
      $image_thumbnail_url = $image_thumbnail_url[0];
      empty($image_thumbnail_url) && $image_thumbnail_url = $image_a[0];

      if (!empty($image_url)) {
        $html .= '
        <li>
          <a href="' . $image_url . '" data-title="' . $image_title . '" target="_blank" data-lightbox="margox-post-gallery-' . $postid . '">
            <img onload="javascript:this.classList.add(\'loaded\');" class="fade-image" alt="' . $image_title . '" src="' . str_replace(array('http:', 'https:'), '', $image_thumbnail_url) . '">
          </a>
        </li>
        ';
      }

    }

    $html .= '
    </ul>
    ';

    return $html;
  }

  return false;

}

function margox_shortcode_audio($atts) {
  
  $post = get_post();
  static $index = 0;
  $index ++;

  extract(shortcode_atts(array(
    'mp3' => null,
    'artist' => null,
    'name' => null,
    'poster' => null,
    'album' => null
  ), $atts));

  $html = '<div class="post-audio margox-audio-player" id="post-audio-' . $index . '"><div class="post-audio-obj" data-id="' . $index . '" data-audio="' . $mp3 . '"></div>';

  if ($poster) {
    $html .= '<div class="cover" style="background-image: url(' . $poster . ');">';
  } else {
    $html .= '<div class="cover">';
  }

  $html .= '<a href="javascript:void(0);" class="btn-play-pause" data-id="' . $index . '">
      <i class="iconfont icon-play"></i>
      <i class="iconfont icon-pause"></i>
      </a>
    </div>
    <h5 class="caption">' . ($name ? $name : '未知名称') . '</h5>
    <h6 class="sub-caption">' . ($artist ? $artist : '未知歌手') . '/ ' . ($album ? $album : '位置专辑') .'</h6>
    <div class="progress">
      <span class="played-time">00:00</span>
      <span class="total-time">00:00</span>
      <span class="progress-bar"></span>
    </div>
    </div>
  </div>';

  return force_balance_tags($html);

}

add_shortcode('audio', 'margox_shortcode_audio');

function margox_shortcode_gallery($atts) {
  
  $post = get_post();
  static $index = 0;
  $index ++;
  
  extract(shortcode_atts(array(
    'ids' => null,
    'orderby' => null,
    'link' => null,
    'columns' => 4 
  ), $atts));

  $ids = explode(',', $ids);

  if ($orderby == 'rand') {
    shuffle($ids);
  }

  $html = '<div class="post-gallery-wrap"><ul id="post-gallery-' . $index . '" class="post-gallery post-gallery-' . $columns . '-columns clearfix">';
  
  foreach ($ids as $id) {

    if (is_numeric($id)) {

      $attachment = get_post($id);
      $full_src = wp_get_attachment_image_src($id, 'image-large');
      $full_src = $full_src[0];
      $thumb_url = wp_get_attachment_image_src($id, 'image-middle');
      $thumb_url = $thumb_url[0];

      if (empty($thumb_url)) {
        $thumb_url = wp_get_attachment_image_src($id, 'thumbnail');
        $thumb_url = $thumb_url[0];
      }

      if ($link == 'none') {
        $href = $full_src . '" data-lightbox="gallery-shortcode-' . $post->ID;
      } elseif ($link == 'file') {
        $href = $full_src . '"';
      } else {
        $href = get_attachment_link($id) . '"';
      }

      $caption = $attachment->post_excerpt;
      $html .= '
      <li>
        <a href="' . $href . '" data-title="' . $caption . '">
          <img onload="javascript:this.classList.add(\'loaded\');" class="fade-image" src="' . str_replace(array('http:', 'https:'), '', $thumb_url) . '" alt="' . $caption . '">
        </a>
      </li>';

      }

    }
  
  return force_balance_tags($html . '</ul></div>');

}

add_shortcode('gallery', 'margox_shortcode_gallery');

// 获取文章音频字段
function margox_get_post_audio($postid = null) {

  !is_numeric($postid) && $postid = get_the_ID();
  $audio = get_post_meta($postid, 'margox_meta_audio', true);
  return $audio;

}

// 生产二维码
function margox_generate_qrcode($data) {

  return '//api.qrserver.com/v1/create-qr-code/?color=222222&bgcolor=FFFFFF&qzone=1&margin=0&size=400x400&ecc=L&data=' . $data;

}

// 扩展字段处理
$margox_metaboxes = array(
   'link' => array(
    array(
      'name' => 'link',
      'title' => '链接地址',
      'placeholder' => '链接地址',
      'type' => 'text',
      'html' => false
    )
  ),
  'linktitle' => array(
    array(
      'name' => 'linktitle',
      'title' => '链接标题',
      'placeholder' => '链接标题',
      'type' => 'text',
      'html' => false
    )
  ),
  'audio' => array(
    array(
      'name' => 'audio',
      'title' => '音频文件地址',
      'placeholder' => '粘贴音频文件地址，或者从媒体库选取',
      'type' => 'audio',
      'html' => true
    )
  ),
  'video' => array(
    array(
      'name' => 'video',
      'title' => '视频文件地址',
      'placeholder' => '粘贴视频文件地址，或者从媒体库选取',
      'type' => 'video',
      'html' => true
    )
  ),
  'quote' => array(
    array(
      'name' => 'quote',
      'title' => '引用文字',
      'placeholder' => '填写引用文字',
      'type' => 'text',
      'html' => false
    )
  ),
  'status' => array(
    array(
      'name' => 'status',
      'title' => '嵌入的社交状态代码或者任意HTML代码',
      'placeholder' => '请将代码粘贴于此',
      'type' => 'textarea',
      'html' => true
    )
  ),
  'gallery' => array(
    array(
      'name' => 'gallery',
      'title' => '相册图片',
      'placeholder' => '',
      'type' => 'mulitmedia',
      'html' => true
    )
  )
);


// Add MetaBoxes
function margox_add_metaboxes() {

  global $margox_metaboxes;
  $screens = array('post');

  foreach ($margox_metaboxes as $key => $fields) {
    foreach ($screens as $screen) {
      foreach ($fields as $field) {
        add_meta_box('margox_format_' . $field['name'], $field['title'], 'margox_create_metaboxes', $screen, 'advanced', 'default', array($key));
      }
    }
  }

  if (in_array(margox_current_screen(), array('post'))) {
    wp_enqueue_script('margox-post-format-js', __RES__ . 'js/admin/post-format.js');
    wp_enqueue_style('margox-post-format-css', __RES__ . 'css/admin/post-format.css');
  }

}

function margox_current_screen() {

  $screen = get_current_screen();
  return $screen->id;

}

function margox_thumbnail_metabox($post, $args) {

  $margox_thumbnail = get_post_meta($post->ID, 'margox_meta_thumbnail', true);
  $margox_thumbnail_id = isset($margox_thumbnail['id']) ? $margox_thumbnail['id'] : 0;
  $margox_thumbnail_src = isset($margox_thumbnail['src']) ? $margox_thumbnail['src'] : '';
?>
<div id="margox-meta-thumbnail">
  <input type="hidden" id="margox_meta_thumbnail_id" name="margox_meta_thumbnail[id]" value="<?php echo $margox_thumbnail_id;?>">
  <input type="hidden" id="margox_meta_thumbnail_src" name="margox_meta_thumbnail[src]" value="<?php echo $margox_thumbnail_src;?>">
  <div class="margox-meta-thumbnail-preview-wrapper">
    <img src="<?php echo $margox_thumbnail_src;?>" id="margox-meta-thumbnail-preview" width="150" height="150">
    <a href="javascript:void(0);" id="margox-remove-thumbnail">x</a>
  </div>
</div>
<?php
}

function margox_create_metaboxes($post, $args) {

  global $margox_metaboxes;
  $margox_metabox = $margox_metaboxes[$args['args'][0]];

  foreach ($margox_metabox as $margox_meta) {
    $meta_value = get_post_meta($post->ID, 'margox_meta_' . $margox_meta['name'], true);
    if (!$margox_meta['html']) {
      $meta_value = esc_attr($meta_value);
    }
    switch ($margox_meta['type']) {
      case 'text':
        echo '<input type="text" placeholder="' . $margox_meta['placeholder'] . '" class="margox-text margox-long-text margox_meta_' . $args['args'][ 0 ] . '" name="margox_meta_' . $margox_meta['name'] . '" value="' . $meta_value . '" />';
        break;
      case 'textarea':
        echo '<textarea placeholder="' . $margox_meta['placeholder'] . '" class="margox-textarea margox_meta_' . $args['args'][0] . '" name="margox_meta_' . $margox_meta['name'] . '">' . $meta_value . '</textarea>';
        break;
      case 'audio':
        echo '<textarea placeholder="' . $margox_meta['placeholder'] . '" class="margox-textarea margox_meta_' . $args['args'][0] . '" id="margox_meta_audio" name="margox_meta_' . $margox_meta['name'] . '">' . $meta_value . '</textarea><a class="button" id="margox_add_audio">' . '从媒体库选取' . '</a>';
        break;
      case 'video':
        echo '<textarea placeholder="' . $margox_meta['placeholder'] . '" class="margox-textarea margox_meta_' . $args['args'][0] . '" id="margox_meta_video" name="margox_meta_' . $margox_meta['name'] . '">' . $meta_value . '</textarea><a class="button" id="margox_add_video">' . '从媒体库选取' . '</a>';
        break;
      case 'mulitmedia':
        $checked['slide'] = $checked['grid'] = '';
        $type = isset($meta_value['type']) ? $meta_value['type'] : "slide";
        $type = empty($type) ? 'slide' : $type;
        $checked[ $type ] = 'checked';
        echo '<div class="margox-meta-gallery-type">';
        echo '<label><input type="radio" name="margox_meta_' . $margox_meta['name'] . '[type]" ' . $checked['slide'] . ' value="slide">' . '轮播' . '</label>&nbsp;&nbsp;&nbsp;';
        echo '<label><input type="radio" name="margox_meta_' . $margox_meta['name'] . '[type]" ' . $checked['grid'] . ' value="grid">' . '阵列' . '</label>';
        echo '</div>';
        echo '<div class="margox-meta-gallery margox-meta-gallery-' . $type . '">';
        echo '<div class="margox-meta-gallery-wrapper">';
        $images = isset($meta_value['images']) ? $meta_value['images'] : null;
        if (is_array($images)) {
          $n = 0;
          foreach ($images['urls'] as $value) {
            $thumbnail = explode("|", $value);
            echo '<div class="margox-meta-gallery-item">';
            echo '<img src="' . $thumbnail[ 0 ] . '" width="100px" height="100px" title="' . 'Click to remove' . '"/>';
            echo '<input type="hidden" class="margox-meta-gallery-fields" name="margox_meta_' . $margox_meta['name'] . '[images][urls][]" value="' . $value . '" />';
            echo '</div>';
            $n++;
          }
        }
        echo '</div><a href="javascript:void(0);" class="margox-meta-gallery-add" data-name="' . $margox_meta['name'] . '">+</a><div class="clearfix"></div></div>';
        break;
    }
  }
}

function margox_save_metas($post_id) {

  global $margox_metaboxes;

  if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
    if (!current_user_can('edit_page', $post_id)) {
      return;
    }
  } else {
    if (!current_user_can('edit_post', $post_id)) {
      return;
    }
  }

  foreach ($margox_metaboxes as $fields) {

    foreach ($fields as $field) {

      if (isset($_POST['margox_meta_' . $field['name'] ])) {
        $new_meta_data = $field['html'] ? $_POST['margox_meta_' . $field['name'] ] : sanitize_text_field($_POST['margox_meta_' . $field['name'] ]);
        update_post_meta($post_id, 'margox_meta_' . $field['name'], $new_meta_data);
      }

    }

  }

  isset($_POST['margox_meta_thumbnail']) && update_post_meta($post_id, 'margox_meta_thumbnail', $_POST['margox_meta_thumbnail']);

}

add_action('add_meta_boxes', 'margox_add_metaboxes');
add_action('save_post', 'margox_save_metas');

// 日期格式化
function format_date($timeInt, $format = 'Y-m-d') {

  $timeInt = strtotime($timeInt);
  if ($timeInt === 0) {
    return '';
  }
  $d = time() - $timeInt + 28800;
  if ($d < 0) {
    return '';
  } else {
    if ($d < 60) {
      return $d . '秒前';
    } else {
      if ($d < 3600) {
        return floor($d / 60) . '分钟前';
      } else {
        if ($d < 86400) {
          return floor($d / 3600) . '小时前';
        } else {
          if ($d < 2592000) {//3天内
            return floor($d / 86400) . '天前';
          } else { 
            return date($format , $timeInt);
          }
        }
      }
    }
  }

}

?>