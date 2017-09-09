/**
 * Lightbox
 * @author margox
 * @version 1.0.0
 * @license MIT
 */
-function(exports) {

  "use strict"

  var $ = document.querySelector.bind(document)
  var $all = document.querySelectorAll.bind(document)

  var lightboxObj = null
  var elements = {}
  var currentIndex = 0
  var currentLeft = 0
  var imagesLength = 0
  var screenDPR = window.devicePixelRatio

  var ua = navigator.userAgent
  var isWeixin = false
  var isMQQ = false
  var isUC = false

  if (/MicroMessenger/.test(ua) && (typeof wx !== 'undefined')) {
    isWeixin = true
  }

  var __slideTo = function(index) {

    elements.list.style.transform = 'translate3d(-' + index * 100 + '%,0,0)'
    elements.index.innerHTML = (index + 1) + '/' + imagesLength
    currentLeft = index * -100

    if (index === imagesLength - 1) {
      lightboxObj.classList.add('no-next')
    } else {
      lightboxObj.classList.remove('no-next')
    }

    if (index === 0) {
      lightboxObj.classList.add('no-prev')
    } else {
      lightboxObj.classList.remove('no-prev')
    }

  }

  var __initialize = function() {

    if (isWeixin || isMQQ || isUC) {
      return false
    }

    if (!$('#J-margox-lightbox')) {

      lightboxObj = document.createElement("div")
      lightboxObj.id = 'J-margox-lightbox'
      lightboxObj.className = 'margox-lightbox'
      lightboxObj.innerHTML = [
        '<div class="back-layer"></div>',
        '<div class="list-wrap"><ul class="list"></ul></div>',
        '<div class="meta">',
          '<span class="index blured-backdrop-dark">0/0</span>',
        '</div>',
        '<div class="controlls">',
          '<a href="javascript:void(0);" class="btn-close blured-backdrop-dark iconfont icon-close"></a>',
          '<a href="javascript:void(0);" class="btn-next blured-backdrop-dark iconfont icon-right"></a>',
          '<a href="javascript:void(0);" class="btn-prev blured-backdrop-dark iconfont icon-left"></a>',
        '</div>'
      ].join('')

      document.body.appendChild(lightboxObj)

    } else {
      lightboxObj = $('#J-margox-lightbox')
    }

    // 获取元素
    elements = {
      backLayer: lightboxObj.querySelector('.back-layer'),
      list: lightboxObj.querySelector('.list'),
      index: lightboxObj.querySelector('.index'),
      btnClose: lightboxObj.querySelector('.btn-close'),
      btnNext: lightboxObj.querySelector('.btn-next'),
      btnPrev: lightboxObj.querySelector('.btn-prev')
    }

    // 按钮事件处理
    elements.list.addEventListener('click', function() {
      lightboxObj.classList.remove('active')
    })

    elements.btnClose.addEventListener('click', function() {
      lightboxObj.classList.remove('active')
    })

    elements.btnNext.addEventListener('click', function() {

      if (currentIndex < imagesLength - 1) {
        currentIndex ++
        __slideTo(currentIndex)
      }

    })

    elements.btnPrev.addEventListener('click', function() {

      if (currentIndex > 0) {
        currentIndex --
        __slideTo(currentIndex)
      }

    })

    // 触屏事件处理
    var touchMoving = false
    var fullWidth = 0
    var startX = 0
    var lastX = 0

    lightboxObj.addEventListener('touchstart', function(e) {

      fullWidth = lightboxObj.getBoundingClientRect().width
      touchMoving = true
      elements.list.classList.add('touch-moving')
      startX = lastX = e.touches[0].clientX

    })

    lightboxObj.addEventListener('touchmove', function(e) {

      if (touchMoving) {

        var newX = e.touches[0].clientX
        var offsetX = newX - lastX

        if (
            (offsetX < 0 && currentIndex === imagesLength - 1) ||
            (offsetX > 0 && currentIndex === 0)
        ) {
            offsetX = offsetX * .25
        }

        // 位移转为百分比
        offsetX = offsetX / fullWidth * 100
        currentLeft += offsetX
        elements.list.style.transform = 'translate3d(' + currentLeft + '%,0,0)'
        lastX = newX

      }

    })

    lightboxObj.addEventListener('touchend', function(e) {

        var moveDistance = lastX - startX
        touchMoving = false

        if (moveDistance < -20 * screenDPR) {
            currentIndex = currentIndex >= imagesLength - 1 ? imagesLength - 1 : currentIndex + 1
        } else if (moveDistance > 20 * screenDPR) {
            currentIndex = currentIndex <= 0 ? 0 : currentIndex - 1
        }

        elements.list.classList.remove('touch-moving')

        __slideTo(currentIndex)

    })

  }

  __initialize()

  exports.lightBox = function(current, images) {

    var urls = images.map(function(image) {
      return image.src
    })

    if (isWeixin) {

      wx.previewImage({  
        'current': urls[current],  
        'urls': urls  
      })
      return

    }

    currentIndex = current
    imagesLength = images.length

    var imagesHTML = images.map(function(image, index) {
      return '<li data-index="' + index + '"><span>' + image.title + '</span><img class="fade-image" onload="javascript:this.classList.add(\'loaded\');" src="' + image.src + '" alt="' + image.title + '"/></li>'
    }).join('')

    elements.list.innerHTML = imagesHTML
    elements.list.style.transform = 'translate3d(-' + current * 100 + '%,0,0)'
    elements.index.innerHTML = (current + 1) + '/' + imagesLength
    currentLeft = current * -100

    if (current === imagesLength - 1) {
      lightboxObj.classList.add('no-next')
    } else {
      lightboxObj.classList.remove('no-next')
    }

    if (current === 0) {
      lightboxObj.classList.add('no-prev')
    } else {
      lightboxObj.classList.remove('no-prev')
    }

    lightboxObj.classList.add('active')

  }

}(window)