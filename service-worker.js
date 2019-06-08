importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js');

/*
 * PRECACHING
 */

// TURNED OFF BECAUSE THESE RESOURCES WOULD BE CACHE-FIRST ONLY!
/*workbox.precaching.precacheAndRoute([
  { url: '/', revision: '20190607' },
  { url: '/about/', revision: '20190607' },
  { url: '/contact/', revision: '20190607' }
]);*/

/*
 * ROUTING
 */

workbox.routing.registerRoute(
  /\.js$/,
  new workbox.strategies.StaleWhileRevalidate({
    cacheName: "js-cache",
  })
);
    
workbox.routing.registerRoute(
  /\.css$/,
  new workbox.strategies.StaleWhileRevalidate({
    cacheName: 'css-cache',
  })
);

workbox.routing.registerRoute(
  /\.(?:png|jpg|jpeg|svg)$/,
  new workbox.strategies.CacheFirst({
    cacheName: 'image-cache',
    plugins: [
      new workbox.expiration.Plugin({
        maxEntries: 20,
        maxAgeSeconds: 7 * 24 * 60 * 60,
      })
    ],
  })
);

workbox.routing.registerRoute(
  /\/[^\/]+\/$/,
  new workbox.strategies.NetworkFirst({
    cacheName: 'posts-cache',
    plugins: [
      new workbox.expiration.Plugin({
        maxEntries: 20
      })
    ],
  })
);
