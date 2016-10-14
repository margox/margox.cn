jQuery(document).ready(function($){

  /*change meta box when post format has been changed*/

  var _margox_post_formats = $("#post-formats-select").find("input[name=post_format]");
  var _margox_post_format = $("#post-formats-select").find("input:checked")[0].id.replace("post-format-","");

  var _change_meta_box = function(id) {
  
    $("#margox_format_video").hide();
    $("#margox_format_audio").hide();
    $("#margox_format_link").hide();
    $("#margox_format_linktitle").hide();
    $("#margox_format_quote").hide();
    $("#margox_format_status").hide();
    $("#margox_format_gallery").hide();
    $("#margox_format_" + id).length && $("#margox_format_" + id).show();
    
    if(id == 'link'){
      $("#margox_format_linktitle").show()
    }
  
  }

  _change_meta_box(_margox_post_format);

  _margox_post_formats.change(function() {
    _margox_post_format = this.id.replace("post-format-", "");
    _change_meta_box(_margox_post_format);
  });

  $("#margox_add_audio").click(function() {
    var custom_uploader = wp.media({
      title: 'Select Audio',
      library: {
        type: 'audio'
      },
      button: {
        text: 'Select'
      },
      multiple: false
    }).on('select', function() {
      var attachment = custom_uploader.state().get('selection').first().toJSON();
      $("#margox_meta_audio").val(attachment.url);
    }).open();

  });

  $("#margox_add_video").click(function(){
    var custom_uploader = wp.media({
      title: 'Select Video',
      library: {
        type: 'video'
      },
      button: {
        text: 'Select'
      },
      multiple: false
    }).on('select', function() {
      var attachment = custom_uploader.state().get('selection').first().toJSON();
      $("#margox_meta_video").val(attachment.url);
    }).open();

  });

  $(".margox-meta-gallery").find(".margox-meta-gallery-add").click(function(){
    var gallerys = $(this).prev('.margox-meta-gallery-wrapper');
    var name = $(this).data('name');
    var custom_uploader = wp.media({
      title: 'Select Images',
      library: {
        type: 'image'
      },
      button: {
        text: 'Add Image'
      },
      multiple: true
    }).on('select', function() {

      var selection = custom_uploader.state().get('selection');
      selection.each(function(attachment) {

        var html = '<div class="margox-meta-gallery-item">';
        var margox_thumbnail = attachment.attributes.sizes.thumbnail;

        console.log(attachment.attributes)

        if (typeof(margox_thumbnail) == 'undefined') {
          margox_thumbnail = attachment.attributes;
        }

        html += '<img src="' + margox_thumbnail.url + '" width="100px" height="100px"/>';
        html += '<input type="hidden" class="margox_meta_gallery_fields" name="margox_meta_' + name + '[images][urls][]" value="' + margox_thumbnail.url + '|' + attachment.attributes.url + '|' + attachment.id + '" />';
        html += '</div>';

        $(html).on("click", function() {
          margox_gallery_delete(this);
        });

        $(html).appendTo(gallerys);

      });

    }).open();

  });

  $(".margox-meta-gallery").on("click", '.margox-meta-gallery-item img', function() {
    margox_gallery_delete($(this).parent());
  });

  $(".margox-meta-gallery-type").find('input').click(function() {
    if (this.value == 'grid') {
      $(this).parents('.margox-meta-gallery-type').next('.margox-meta-gallery').removeClass('margox-meta-gallery-slide').addClass('margox-meta-gallery-grid');
    } else {
      $(this).parents('.margox-meta-gallery-type').next('.margox-meta-gallery').removeClass('margox-meta-gallery-grid').addClass('margox-meta-gallery-slide');
    }
  });

  function margox_gallery_delete(obj) {
    $(obj).remove();
  }

  $('#margox-meta-thumbnail-preview').click(function() {

    var custom_uploader = wp.media({
      title: 'Select Thumbnail',
      library: {
        type: 'image'
      },
      button: {
        text: 'Select'
      },
      multiple: false
    }).on('select', function() {

      var attachment = custom_uploader.state().get('selection').first();
      var margox_thumbnail = attachment.attributes.sizes.thumbnail;

      if( typeof(margox_thumbnail) != 'undefined') {
        $('#margox_meta_thumbnail_id').val(attachment.id);
        $('#margox_meta_thumbnail_src').val(margox_thumbnail.url);
        $('#margox-meta-thumbnail-preview').attr('src', margox_thumbnail.url);
      } else {
        $('#margox_meta_thumbnail_id').val(attachment.id);
        $('#margox_meta_thumbnail_src').val(attachment.attributes.url);
        $('#margox-meta-thumbnail-preview').attr('src', attachment.attributes.url);
        console.log('Thumbnail of this image not found.');
      }

    }).open();

  });

  $('#margox-remove-thumbnail').click(function() {
    $('#margox_meta_thumbnail_id').val('');
    $('#margox_meta_thumbnail_src').val('');
    $('#margox-meta-thumbnail-preview').attr('src', '');
  });

});