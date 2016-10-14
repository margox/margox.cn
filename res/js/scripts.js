-function($) {

  // Build Audio Player
  var playerObjs = [];

  $('.post-audio-obj').each(function() {

    var player_id = $(this).attr('data-id');
    var player_obj = new Audio();
    var player_src= $(this).attr('data-audio');
    var player_wrap = $('#post-audio-' + player_id);
    var player_btn = player_wrap.find('.btn-play-pause');
    var player_played = player_wrap.find('.played-time');
    var player_total = player_wrap.find('.total-time');
    var player_bar = player_wrap.find('.progress-bar');
    var player_bar_width = player_bar.width();
    var player_status = 'stop';
    var player_timmer;

    $(window).on('resize', function() {
      player_bar_width = player_bar.width();
    });

    player_obj.addEventListener('playing', function() {
      player_status = 'playing';
      player_btn.addClass('playing');
      player_total.text(sec2min(player_obj.duration));
      playingFunc();
    });

    player_obj.addEventListener('pause', function() {
      player_btn.removeClass('playing');
      player_status = 'paused';
      clearTimeout(player_timmer);
    });

    player_obj.addEventListener('ended', function() {
      player_btn.removeClass('playing');
      player_status = 'ended';
      clearTimeout(player_timmer);
    });

    player_obj.addEventListener('abort', function() {
      player_btn.removeClass('playing');
      player_status = 'abort';
      clearTimeout(player_timmer);
    });

    player_bar.on('click', function(e) {

      var offset_x = Math.ceil(e.pageX - $(this).offset().left);
      var new_time = offset_x / player_bar_width * player_obj.duration;

      if (!isNaN(new_time)) {
        playerObjs.forEach(function(player) {
            player.pause();
        });
        player_obj.currentTime = new_time;
        player_obj.play();
      }

    });

    function playingFunc() {

      if (player_status === 'playing') {
        player_played.text(sec2min(player_obj.currentTime));
        player_bar.css({
            borderLeftWidth: player_obj.currentTime/player_obj.duration * player_bar_width
        });
        player_timmer = setTimeout(playingFunc, 1000);
      } else {
        clearTimeout(player_timmer);
      }

    }

    player_btn.on('click', function() {

      if (player_status === 'stop') {

        player_obj.src = player_src;
        playerObjs.forEach(function(player) {
          player.pause();
        });
        player_obj.play();
        playerObjs.push(player_obj);

      } else if(player_status === 'playing') {
        player_obj.pause();
      } else {

        playerObjs.forEach(function(player) {
          player.pause();
        });
        player_obj.play();

      }

    });

  });

  function sec2min(second) {

    var min = Math.floor(second / 60);
    var sec = Math.floor(second % 60);

    sec < 10 && (sec = "0" + sec);
    min < 10 && (min = "0" + min);

    return min + ":" + sec;

  }

}(jQuery);