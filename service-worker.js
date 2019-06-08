importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js');

/*
 * PRECACHING
 */

workbox.precaching.precacheAndRoute([
  { url: '/about/', revision: '20190607' },
  { url: '/contact/', revision: '20190607' },
  { url: '/native-lazy-loading-with-vanilla-lazyload/', revision: '20190607' },
  { url: '/detect-intersection-observer-online-tool/', revision: '20190607' },
  { url: '/tables-look-like-lists-look-like-tables-accessible-responsive-design/', revision: '20190607' },
  { url: '/lazy-load-responsive-images-in-2019-srcset-sizes-more/', revision: '20190607' },
  { url: '/check-if-element-still-inside-viewport-after-given-time/', revision: '20190607' },
  { url: '/using-css-variables-to-scale-layout-spaces/', revision: '20190607' },
  { url: '/responsive-images-a-html-51-standard/', revision: '20190607' },
  { url: '/hybrid-lazy-loading-smashing-magazine-article/', revision: '20190607' },
]);


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
