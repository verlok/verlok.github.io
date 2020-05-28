---
layout: post
title: Lazy load responsive images in 2020
date: 2020-05-24 08:00:00 +01:00
categories:
  - libraries
tags: [srcset, responsive images, lazy load]
image: lazy-load-responsive-images-2020__2x.jpg
---

Do you want to boost performance on your website? You can do that by using **responsive images** and **lazy loading**! In this article you will find the **HTML, JavaScript and CSS code** to lazy load responsive images, to make browsers use **modern image formats** like **WebP** and **Jpeg2000**, and to enable **native lazy load** where supported.

<figure>
  <picture>
    <source
      type="image/jp2"
      data-srcset="
        /assets/post-images/lazy-load-responsive-images-2020__600w.jp2 600w,
        /assets/post-images/lazy-load-responsive-images-2020__698w.jp2 698w,
        /assets/post-images/lazy-load-responsive-images-2020__1047w.jp2 1047w,
        /assets/post-images/lazy-load-responsive-images-2020__1200w.jp2 1200w
      "
    />
    <source
      type="image/webp"
      data-srcset="
        /assets/post-images/lazy-load-responsive-images-2020__600w.webp 600w,
        /assets/post-images/lazy-load-responsive-images-2020__698w.webp 698w,
        /assets/post-images/lazy-load-responsive-images-2020__1047w.webp 1047w,
        /assets/post-images/lazy-load-responsive-images-2020__1200w.webp 1200w
      "
    />
    <img
      class="lazy post-image"
      alt="Lazy loading responsive images (2020)" 
      src="/assets/post-images/lazy-load-responsive-images-2020__50w.jpg" 
      data-src="/assets/post-images/lazy-load-responsive-images-2020__600w.jpg" 
      data-srcset="
        /assets/post-images/lazy-load-responsive-images-2020__600w.jpg 600w,
        /assets/post-images/lazy-load-responsive-images-2020__698w.jpg 698w,
        /assets/post-images/lazy-load-responsive-images-2020__1047w.jpg 1047w,
        /assets/post-images/lazy-load-responsive-images-2020__1200w.jpg 1200w
      "
      data-sizes="(min-width: 630px) 600px, calc(100vw - 26px)"
    >
  </picture>
  <figcaption>
    Photo by <a href="https://unsplash.com/@domenicoloia">Domenico Loia</a> on <a href="https://unsplash.com/s/photos/website">Unsplash</a>
  </figcaption>
</figure>

## Definitions

**Responsive images** are images that adapt to your design by **downloading a different image source** from a given **set of image sources**, which you provide, depending on **some conditions**, which you specify. You can specify basic conditions related to the browser's **viewport width** and **device pixel density** using a regular `img` tag, and you can use media queries by wrapping your images in a `picture` tag. More about [responsive images in the MDN](https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images).

**Lazy loading images** is a technique to make your website render faster by **deferring the loading of below-the-fold images** to when they **enter the viewport**. Beyond performance, this also allows you to save bandwidth and money, e.g. if you're paying a CDN service for your images.

## Above-the-fold first

Bear in mind that using a script to **lazy load images is a Javascript-based task** and it's **relevantly slower than the regular image loading** (_eager loading_ from now on) which starts as soon as the HTML document is being parsed.

☝️ For this reason, the best practice is to **eagerly load above-the-fold images**, and **lazy load only the below-the-fold images**.

A good way to understand how many images will appear _above-the-fold_ in your responsively designed page is... to count them! Open your page in a browser and **try it in the most common viewports** of smartphones, computers, and tablets.

## Now to some code!

Here's the HTML markup of an _eagerly loaded_ responsive image.

```html
<!-- Eagerly loaded responsive image -->
<!-- Only for above-the-fold images!!! -->
<img
  alt="Image 01"
  src="https://via.placeholder.com/220x280?text=Img+01"
  srcset="
    https://via.placeholder.com/220x280?text=Img+01 220w,
    https://via.placeholder.com/440x560?text=Img+01 440w
  "
  sizes="220px"
/>
```

And here's the markup you're going to need to _lazy load_ a responsive image.

```html
<!-- Lazy loaded responsive image -->
<!-- Only for below-the-fold images!!! -->
<img
  alt="Image 03"
  class="lazy"
  data-src="https://via.placeholder.com/220x280?text=Img+03"
  data-srcset="https://via.placeholder.com/220x280?text=Img+03 220w, 
    https://via.placeholder.com/440x560?text=Img+03 440w"
  data-sizes="220px"
/>
```

Want a low-resolution preview while your lazy images load? You can do that by using a small, low-quality image in the `src` tag, like the following.

```html
<!-- Lazy loaded responsive image + low-res preview -->
<!-- Only for below-the-fold images!!! -->
<img
  alt="Image 03"
  class="lazy"
  src="https://via.placeholder.com/11x14?text=Img+03"
  data-src="https://via.placeholder.com/220x280?text=Img+03"
  data-srcset="https://via.placeholder.com/220x280?text=Img+03 220w, 
    https://via.placeholder.com/440x560?text=Img+03 440w"
  data-sizes="220px"
/>
```

[Open the 👀 demo](http://verlok.github.io/vanilla-lazyload/demos/image_srcset_lazy_sizes.html), then your browser's **developer tools**, and switch to the **Network panel**. You will see that the first 2 images are loaded _eagerly_ just after page landing, while the rest of the images are loaded _lazily_ **as you scroll down** the page.

We're using the `img` HTML tag and not the `picture` tag, given that the latter is not necessary in this case. I'll dig into the `picture` tag use cases later in this article. ⏩ [Skip to `picture` tag use cases](#picture-tag-use-cases)

### Script inclusion

To load the lazy images as they enter the viewport, you need a lazy load script such as [vanilla-lazyload](https://github.com/verlok/vanilla-lazyload) which is a lightweight (2.5 kb gzipped), blazing-fast, configurable, SEO-friendly script that I've been maintaining and improving since 2014.

Here is the simplest way to include it in your page.

```html
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@16.1.0/dist/lazyload.min.js"></script>
```

Other ways to include LazyLoad in your web pages, like using an `async` script with auto-init, using RequireJS, using WebPack or Rollup, are [documented here](https://github.com/verlok/vanilla-lazyload/#include-lazyload-in-your-project).

### LazyLoad initialization

You need LazyLoad to manage and load all the images with a `lazy` class included in the page. You can initialize `LazyLoad` like this:

```js
var lazyLoad = new LazyLoad({
  elements_selector: ".lazy"
  cancel_on_exit: true
  //☝️ recommended options
});
```

### Minimize layout reflow

When using lazy loading, the images that haven't started loading collapse to `0`-height, only to grow when they'll have started loading. Layout reflowing would make your website janky, so it's a best practice to stabilize your layout by occupying some space before the images start loading.

The universal solution to do that is to use the vertical padding trick, while in the future you'll be able to use the `aspect-ratio` CSS directive to do the trick (as I'm writing it's [landed](https://twitter.com/Una/status/1260980901934137345) in Chrome Canary only).

```css
.image-wrapper {
  width: 100%;
  height: 0;
  padding-bottom: 150%;
  /* ☝️ image height / width * 100% */
  position: relative;
}
.image {
  position: absolute;
  /* ...other positioning rules */
}
```

### Hide "broken" images

To avoid lazy images to appear as broken, even for a short amount of time, use CSS hide the images that still don't have neither an `src` nor a `srcset` attribute set.

```css
img:not([src]):not([srcset]) {
  visibility: hidden;
}
```

### No polyfills required

You might be tempted to add one or more polyfills to support Internet Explorer (_yes, I named it and it's 2020_). Don't do that, **you don't need any**. Let me tell you why:

- _Responsive images:_ Internet Explorer does not support responsive images, but you don't need to use a polyfill because <abbr title="Internet Explorer">IE</abbr> gracefully degrades using **the image in the `src` attribute**. So you can place in the `src` attribute an image that would appear nice on a regular desktop display, and you're cool.

- _IntersectionObserver:_ Internet Explorer does not support the `IntersectionObserver` API, which is used by vanilla-lazyload, but you don't need to provide a polyfill because vanilla-lazyload detects the support for that API and, in case it doesn't, it loads all images immediately, which leads to the same result as if no LazyLoad was ever used on the page.

That's cool, Internet Explorer is not being used by more than 5% of the users today, and Microsoft is silently replacing it with [Edge](https://www.microsoft.com/edge) via Windows Update.

Anyway if for some reason you want it to work in the same exact way on Internet Explorer, you can use the IntersectionObserver polyfill by including it before vanilla-lazyload.

```html
<!-- Don't do this if you're not sure! Read above -->
<script src="https://cdn.jsdelivr.net/npm/intersection-observer@0.10.0/intersection-observer.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@16.1.0/dist/lazyload.min.js"></script>
```

### Putting it all together

For your convenience here's all the HTML, JS, and CSS code together.

```html
<!-- Eagerly loaded responsive image -->
<!-- Only for above-the-fold images!!! -->
<img
  alt="Image 01"
  src="https://via.placeholder.com/220x280?text=Img+01"
  srcset="
    https://via.placeholder.com/220x280?text=Img+01 220w,
    https://via.placeholder.com/440x560?text=Img+01 440w
  "
  sizes="220px"
/>

<!-- Lazy loaded responsive image -->
<!-- Only for below-the-fold images!!! -->
<img
  alt="Image 03"
  class="lazy"
  data-src="https://via.placeholder.com/220x280?text=Img+03"
  data-srcset="https://via.placeholder.com/220x280?text=Img+03 220w, 
    https://via.placeholder.com/440x560?text=Img+03 440w"
  data-sizes="220px"
/>
```

```js
var lazyLoad = new LazyLoad({
  elements_selector: ".lazy"
  cancel_on_exit: true
  //☝️ recommended options
});
```

```css
/*
Images container to occupy space 
when the images aren't loaded yet
*/
.image-wrapper {
  width: 100%;
  height: 0;
  padding-bottom: 150%;
  /* ☝️ image height / width * 100% */
  position: relative;
}
.image {
  position: absolute;
  /* ...other positioning rules */
}

/*
Hide "broken" images before 
they start loading
*/
img:not([src]):not([srcset]) {
  visibility: hidden;
}
```

And that's it for the simple `img` tag.

## Picture tag use cases

Until now, I wrote about the `img` tag with the `srcset` and `sizes` attributes, which is the solution to the vast majority of the responsive images you might need and use on a website or web application. Now, in which cases should you use the `picture` tag?

### Different width/height ratio

Use case: you need to show images with different **width/height ratio** depending on a media query. e.g. you want to show _portrait_ images on mobile, vertical devices, _landscape_ on wider viewports, like tablets and computers.

Here's the code you're gonna need in this case. In order to have eagerly loaded images, just use the plain `src` and `srcset` attributes, without `data-` prefix.

```html
<picture>
  <source
    media="(min-width: 1024px)"
    data-srcset="https://via.placeholder.com/1024x576?text=Horizontal+Image 1x,
      https://via.placeholder.com/2048x1152?text=Horizontal+Image 2x"
  />
  <source
    media="(max-width: 1023px)"
    data-srcset="https://via.placeholder.com/640x960?text=Vertical+Image 1x,
      https://via.placeholder.com/1280x1920?text=Vertical+Image 2x"
  />
  <img
    class="lazy"
    alt="Stivaletti"
    data-src="https://via.placeholder.com/1024x576?text=Horizontal+Image"
  />
</picture>
```

[Open the 👀 demo](http://verlok.github.io/vanilla-lazyload/demos/picture_media.html), then your browser's **developer tools** and switch to the **network panel**. You will see that it downloads only the image source corresponding to the first media query that matches.

### Load modern formats like WebP and Jpeg2000

Use case: you want browsers to choose the source to **load a modern format like WebP and Jpeg2000** depending on its support for that format.

You need the `source` tag and the `type` attribute containing the MIME type of the images in the `data-`/`srcset` attribute.

```html
<picture>
  <source
    type="image/jp2"
    data-srcset="https://via.placeholder.com/1024x576?text=Jpeg2000+Image 1x, 
      https://via.placeholder.com/2048x1152?text=Jpeg2000+Image 2x"
  />
  <source
    type="image/webp"
    data-srcset="https://via.placeholder.com/1024x576?text=WebP+Image 1x, 
      https://via.placeholder.com/2048x1152?text=WebP+Image 2x"
  />
  <img
    data-src="https://via.placeholder.com/256.jpg?text=1024x576+Jpg+Image"
    data-srcset="https://via.placeholder.com/1024x576?text=Jpg+Image 1x, 
      https://via.placeholder.com/2048x1152?text=Jpg+Image 2x"
    data-sizes="220px"
    alt="An image"
    class="lazy"
  />
</picture>
```

[Open the 👀 demo](http://verlok.github.io/vanilla-lazyload/demos/picture_type_webp.html), then your browser's **developer tools** and switch to the **network panel**. You will see that it downloads only the image source corresponding to the first type that your browser supports.

## Native lazyload

You might have heard or read of [native lazy-loading](https://web.dev/native-lazy-loading/) coming to the web. Cool, isn't it? As of May 2020, it's supported in Chrome, Firefox, Edge, Opera, and _behind a flag_ in Safari.

So browser support isn't ready yet, but in case you want to try it in your browser, you could do [hybrid lazy-loading](https://www.smashingmagazine.com/2019/05/hybrid-lazy-loading-progressive-migration-native/) setting the `use_native` option of vanilla-lazyload to `true`.

```js
new LazyLoad({
  elements_selector: ".lazy",
  use_native: true
});
```

### You might miss these

If you go for native lazy-loading or hybrid lazyloading, you might miss some **features that JS-driven lazy-loading grants**.

- automatic classes application on events (`loading`, `loaded`, etc.)
- automatic retry loading when network failed
- download cancelation when an image exits the viewport while still loading
- callbacks on events (enter, exit, etc.)

So think about it!

---

## Conclusions

Here is a summary:

1. Use [vanilla-lazyload](https://github.com/verlok/vanilla-lazyload/) to load your lazy images.
1. Don't load all the images lazily, just the ones _below the fold_
1. Use the `img` for simple responsive images
1. Use the `picture` tag to
    - conditionally serve your images in modern formats like WebP or Jpeg2000
    - change your images width/height ratio at specific media queries
1. Don't use any polyfill if not strictly required

If something is unclear or could be improved, let me know in the comments or [tweet me](https://twitter.com/verlok/).
If you found this article useful, feel free to [buy me a coffee](https://ko-fi.com/verlok) ☕

Happy lazy loading!

### Useful resources

- [Responsive images in practice](http://alistapart.com/article/responsive-images-in-practice) @ A List Apart
- [Responsive images](https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images) @ Mozilla Developer Network
- [Responsive images in CSS](https://css-tricks.com/responsive-images-css/) @ CSS Tricks
- [Responsive images community group](https://responsiveimages.org) website
