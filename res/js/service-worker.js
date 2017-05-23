const assetsRoot = '/wp-content/themes/margox.cn/res'
const CACHE_VERSION = 'v4'
const requestToCache = [
  '/',
  '/category/codes',
  '/category/lifestyle',
  assetsRoot + '/js/scripts.js',
  assetsRoot + '/js/libs/lightbox.js',
  assetsRoot + '/js/libs/weixin-sdk.js',
  assetsRoot + '/js/libs/highlight/highlight.pack.js',
  assetsRoot + '/css/styles.css',
  assetsRoot + '/images/favicon.png',
  assetsRoot + '/images/loading.gif'
]

this.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(CACHE_VERSION).then(function(cache) {
      return cache.addAll(requestToCache)
    })
  )
})

this.addEventListener('fetch', function(event) {
  event.respondWith(
    caches.match(event.request).then(function(response) {
      // if request has been cached, return the cache as response
      if (response) {
        return response
      }
      // else fetch it from internet
      var forkedRequest = event.request.clone()
      return fetch(forkedRequest).then(function(response) {
        // check if we received a valid response
        if(!response || response.status !== 200 || response.type !== 'basic') {
          return response;
        }
        // cache the fetched response
        var forkedResponse = response.clone()
        caches.open(CACHE_VERSION).then(function(cache) {
          cache.put(event.request, forkedResponse)
        })
        return response
      })
    })
  )
})