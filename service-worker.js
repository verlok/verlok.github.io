importScripts('https://storage.googleapis.com/workbox-cdn/releases/4.3.1/workbox-sw.js');

workbox.routing.registerRoute(
  /\.js$/,
  new workbox.strategies.NetworkFirst({
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
  new workbox.strategies.StaleWhileRevalidate({
    cacheName: 'posts-cache',
    plugins: [
      new workbox.expiration.Plugin({
        maxEntries: 12
      })
    ],
  })
);

