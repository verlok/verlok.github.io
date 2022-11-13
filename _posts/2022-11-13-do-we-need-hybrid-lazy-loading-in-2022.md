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
---

Back in the days, as browser support for [native lazy loading](https://web.dev/browser-level-image-lazy-loading/) was not widespread as today, the best practice was to markup our images with data attributes like `data-src` and use a JavaScript library like my [vanilla-lazyload](https://github.com/verlok/vanilla-lazyload) to start loading them as they entered the visible portion of the page. Is it still a best practice today?

The short answer is: no, unless you need callbacks or you really care about web performance and user experience.

If we limit our focus to lazy loading content images (not background images or videos, for which you still need a JavaScript lazy loading library), you can be cool by marking up your lazy images like the following.

```html
<img
  src="sloth.webp"
  alt="Lazy sloth"
  loading="lazy"
/>
```

That will enable native lazy loading on [browsers that support it](https://caniuse.com/loading-lazy-attr), meaning pretty much every browser except our old _friend_ Internet Explorer.

So what are the cases for keeping using JavaScript lazy loading, instead of just using `loading='lazy'`?

```html
<img
  data-src="sloth.webp"
  alt="Lazy sloth"
  class="lazy"
/>

<script>
  new LazyLoad();
</script>
```

## You care for users on slow/faulty connections

On slow connections, [vanilla-lazyload](https://github.com/verlok/vanilla-lazyload) cancels the download of images that already exited the visible portion of the page, so your users bandwidth can be really focused on the images that are currently in the visible portion of the page.

This would result in a much better experience, especially if your page contains many images, and your users scrolled down faster than their connection would take to download the images.

In addition, [vanilla-lazyload](https://github.com/verlok/vanilla-lazyload) will retry loading images when their download was interrupted by a network error, e.g. if users connection goes off and on ofter some time.


## You need callbacks or managing loading status of the image

Lazy loading with JavaScript libraries like [vanilla-lazyload](https://github.com/verlok/vanilla-lazyload) triggers callbacks when images enter or exit the viewport, when they are being loaded or finished loading, when their loading failes because of a network error, etc.

You might be interested in using those callbacks to generate visual effects on your page, or just retry loading images when it failed the first time.


## You really want to hide images to the browser before they enter the viewport

There might be cases where you want your images to be hidden to the browser until JavaScript kicks in, e.g. you want to really optimise the [Largest Contentful Paint](https://web.dev/lcp/) by focusing all your users bandwidth on the hero image (which you will have eagerly loaded).
