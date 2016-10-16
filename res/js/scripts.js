-function() {

  var $ = document.querySelector.bind(document)
  var $all = document.querySelectorAll.bind(document)

  if (document.body.style.webkitBackdropFilter !== undefined) {
    document.body.classList.add('backdrop-filter-supported')
  }

  // 顶部进度条处理
  var progress = 0
  var progressTimmer = null
  var progressBar = $('#J-header-progress-bar')

  function progress_func() {

    if (progress < 95) {

      progressTimmer = setTimeout(function() {
        progress += 5
        progressBar.style.width = progress + '%'
        progress_func()
      }, Math.random() * 500 + 40)

    }

  }

  progress_func()

  window.addEventListener('load', function() {

    progress = 100
    progressBar.style.width = '100%'
    clearTimeout(progressTimmer)

    setTimeout(function() {
      progressBar.classList.add('completed')
    }, 100)

  })


  // 音频播放器处理
  var playerObjs = []
  var vudioOptions = {
    width: 512,
    height: 50,
    accuracy: 256,
    waveform: {
      maxHeight: 40,
      minHeight: 0,
      fadeSide: false,
      spacing: 1,
      horizontalAlign: 'center',
      verticalAlign: 'bottom',
      color: '#f39c12'
    }
  };

  [].forEach.call($all('.post-audio-obj'), function(item) {

    var vudio_obj = null
    var player_id = item.dataset.id
    var player_obj = new Audio()
    var player_src= item.dataset.audio
    var player_wrap = $('#post-audio-' + player_id)
    var player_waveform_canvas = player_wrap.querySelector('.vudio-waveform')
    var player_btn = player_wrap.querySelector('.btn-play-pause')
    var player_played = player_wrap.querySelector('.played-time')
    var player_total = player_wrap.querySelector('.total-time')
    var player_bar = player_wrap.querySelector('.progress-bar')
    var player_bar_width = player_bar.getBoundingClientRect().width
    var player_status = 'stop'
    var player_timmer

    var vudio_obj = window.chrome ? new Vudio(player_obj, player_waveform_canvas, vudioOptions) : {
      dance: function() {},
      play: function() {}
    }

    window.addEventListener('resize', function() {
      player_bar_width = player_bar.getBoundingClientRect().width
    })

    player_obj.addEventListener('playing', function() {
      player_status = 'playing'
      player_btn.classList.add('playing')
      player_total.innerText = sec2min(player_obj.duration)
      playingFunc()
      vudio_obj.dance()
    })

    player_obj.addEventListener('pause', function() {
      player_btn.classList.remove('playing')
      player_status = 'paused'
      clearTimeout(player_timmer)
    })

    player_obj.addEventListener('ended', function() {
      player_btn.classList.remove('playing')
      player_status = 'ended'
      clearTimeout(player_timmer)
    })

    player_obj.addEventListener('abort', function() {
      player_btn.classList.remove('playing')
      player_status = 'abort'
      clearTimeout(player_timmer)
    })

    player_bar.addEventListener('click', function(e) {

      var offset_x = Math.ceil(e.pageX - this.getBoundingClientRect().left)
      var new_time = offset_x / player_bar_width * player_obj.duration

      if (!isNaN(new_time)) {
        playerObjs.forEach(function(player) {
          player.pause()
        })
        player_obj.currentTime = new_time
        player_obj.play()
      }

    })

    function playingFunc() {

      if (player_status === 'playing') {

        player_played.innerText = sec2min(player_obj.currentTime)
        player_bar.style.borderLeftWidth = player_obj.currentTime / player_obj.duration * player_bar_width + 'px'
        player_timmer = setTimeout(playingFunc, 1000)

      } else {
        clearTimeout(player_timmer)
      }

    }

    player_btn.addEventListener('click', function() {

      if (player_status === 'stop') {

        player_obj.src = player_src
        playerObjs.forEach(function(player) {
          player.pause()
        })
        player_obj.play()
        playerObjs.push(player_obj)

      } else if(player_status === 'playing') {
        player_obj.pause()
      } else {

        playerObjs.forEach(function(player) {
          player.pause()
        })
        player_obj.play()

      }

    })

  })

  function sec2min(second) {

    var min = Math.floor(second / 60)
    var sec = Math.floor(second % 60)

    sec < 10 && (sec = "0" + sec)
    min < 10 && (min = "0" + min)

    return min + ":" + sec

  }

}()