---
layout: post
title: Do we still need lazy loading libraries and `data-src` in 2022?
date: 2022-11-13 23:30:00 +01:00
categories:
  - techniques
  - lazy loading
  - performance
tags:
  [
    lazy loading,
    hybrid lazy loading,
    native lazy loading,
    pros and cons,
  ]
image: do-we-still-need-lazyload-2022__1x.webp
---

Back in the days, as browser support for [native lazy loading](https://web.dev/browser-level-image-lazy-loading/) was not widespread as today, the best practice was to markup our images with data attributes like `data-src` and use a JavaScript library like my [vanilla-lazyload](https://github.com/verlok/vanilla-lazyload) to start loading them as they entered the visible portion of the page. Is it still a best practice today?

<div class="post-image-spacer" style="background-color: #08a683; padding-bottom: 50%">
  <img 
    alt="Do we still need lazy loading libraries and data-src in 2022?" 
    src="/assets/post-images/do-we-still-need-lazyload-2022__1x.webp" 
    srcset="/assets/post-images/do-we-still-need-lazyload-2022__1x.webp 1x, /assets/post-images/do-we-still-need-lazyload-2022__2x.webp 2x"
    class="post-image"
    loading="eager"
    width="600"
    height="300">
</div>

## What is lazy loading?

**Lazy loading images** is a technique to **defer the loading of _below-the-fold_ images** to when they **entered the viewport**, or are close to do it, viewport meaning the visible portion of the page. It allows you to save bandwidth and money (if you're paying a CDN service for your images), reduce the carbon footprint of your website, and last but not least to reduce the rendering time of your page, improving web performance, and particularly the [Largest Contentful Paint](https://web.dev/lcp/).

## JavaScript-driven image lazy loading

In order to lazy load images, it’s a very common practice to mark them up by replacing the proper `src` attribute with a similar data attribute, `data-src`, then to rely on a JavaScript solution to a) detect when the images are getting close to the visible portion of the website (typically because the user scrolled down), b) to copy the `data` attributes into the proper ones, triggering the deferred loading of their content.

```html
<img
  data-src="turtle.jpg"
  alt="Lazy turtle"
  class="lazy"
/>
```

## Native lazy loading

With native lazy loading, or [browser level lazy loading](https://web.dev/browser-level-image-lazy-loading/), to lazy load images, you just need to add the `loading="lazy"` attribute on the `<img>` tag.

```html
<img
  src="turtle.jpg"
  alt="Lazy turtle"
  loading="lazy"
/>
```

That enables native lazy loading on [browsers that support it](https://caniuse.com/loading-lazy-attr), meaning pretty much every browser except our old _"friend"_ Internet Explorer.

## Do we still need JavaScript-driven lazy loading?

The short answer is: no, unless you want greater control over how lazy loading is handled.

So, what are the cases for using JavaScript-driven lazy loading, instead of just using `loading='lazy'`?

### 1. You care for users on slow or faulty connections (hint: you should)

What happens if you have some pages with many images, and some users on slow connections who scroll down faster than their connection would take to download the images?

Native lazy loading would make browsers download your lazy images in this order: from the first that appeared on the page to the last ones.

With Javascript-driven libraries like [vanilla-lazyload](https://github.com/verlok/vanilla-lazyload), which cancels the download of images that exit the visible portion of the page while still downloading, your users bandwidth will be always focused on downloading the images that are in the visible portion of the page.

Moreover, if images download get interrupted by a network error, e.g. if users connection goes off for a while, vanilla-lazyload will retry download those images when the network becomes available again.

All of this results in a much better user experience. You can try these features on any of the [vanilla-lazyload demos](https://www.andreaverlicchi.eu/vanilla-lazyload/#-demos), like the [basic case demo](https://www.andreaverlicchi.eu/vanilla-lazyload/demos/image_basic.html), and throttling or disabling your connection speed in the developer tools of your browser.

### 2. You need advanced callbacks or CSS classes on your images

Native lazy loading defer the loading of images and you can still watch over events like `loaded`, but you don't have the ability to watch for other events on you images, like start loading, error, exited viewport, etc.

JavaScript-driven lazy loading will trigger callbacks and apply CSS classes on different cases: when images start loading, when images enter or exit the viewport, when they all finished loading, and even when their loading fails because of a network error.

Those callbacks and CSS classes might be very helpful to create visual effects on your page.

Find more about callbacks and classes in [vanilla-lazyload API](https://www.andreaverlicchi.eu/vanilla-lazyload/#-api) / [options](https://www.andreaverlicchi.eu/vanilla-lazyload/#options).

### 3. You want to optimize web performance, and specifically the Largest Contentful Paint of your page

With native lazy loading you don't have control on what images get downloaded from the browser.

There might be some images that barely appear in the visible portion of the page, or they are below-the-fold but not far off, that browsers will download even if they are not the main image of the page, meaning the one that triggers the largest paint on your page.

With JavaScript-driven lazy load you have plenty of options to control if you want to pre-download images that are off-viewport, and how much far off.

If you want to really optimise the [Largest Contentful Paint](https://web.dev/lcp/) on the image causing the LCP, you might be interested in experimenting with JavaScript-driven lazy loading to have more control over it.

Check out [vanilla-lazyload API](https://www.andreaverlicchi.eu/vanilla-lazyload/#-api) / [options](https://www.andreaverlicchi.eu/vanilla-lazyload/#options) to know more.

## Lazy loading everything else

In this article I focused only on _content_ images. To lazy load _background_ images, videos, animated SVGs, and even iframes on some browsers, you still need a JavaScript lazy loading library. Find more about it on the [vanilla-lazyload documentation](https://www.andreaverlicchi.eu/vanilla-lazyload/).
