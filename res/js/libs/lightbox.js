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

  if (!$('#J-margox-lightbox')) {

    lightboxObj = document.createElement("div")
    lightboxObj = 'J-margox-lightbox'
    lightboxObj.className = 'margox-lightbox-host'
    lightboxObj.innerHTML = [
      '<div class="back-layer"></div>',
      '<div class="list-wrap"><ul class="list"></ul></div>',
      '<div class="meta">',
        '<h5 class="caption"></h5>',
        '<span class="index"></span>',
      '</div>',
      '<div class="controlls">',
        '<a href="javascript:void(0);" class="btn-next"></a>',
        '<a href="javascript:vodi(0);" class="btn-prev"></a>',
      '</div>'
    ].join('')

    document.body.appendChild(lightboxObj)

  } else {
    lightboxObj = $('#J-margox-lightbox')
  }

  var elements = {
    backLayer: lightboxObj.querySelector('.back-layer'),
    list: lightboxObj.querySelector('.list'),
    caption: lightboxObj.querySelector('.caption'),
    index: lightboxObj.querySelector('.index'),
    btnNext: lightboxObj.querySelector('.btn-next'),
    btnPrev: lightboxObj.querySelector('.btn-prev'),
  }

  var currentIndex = 0

  exports.lightBox = function(current, images) {

    var imagesHTML = images.map(function(image, index) {
      return '<li data-index="' + index + '"><span>' + image.title + '</span><img src="' + image.src + '" alt="' + image.title + '"/></li>'
    }).join('')

    elements.list.innerHTML = imagesHTML

  }

}(window)