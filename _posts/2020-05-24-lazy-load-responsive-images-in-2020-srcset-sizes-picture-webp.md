---
layout: post
title: Lazy load responsive images in 2020
date: 2020-05-24 08:00:00 +01:00
categories:
  - libraries
tags: [srcset, responsive images, lazy load]
image: lazy-load-responsive-images-2020__1200w.jpg
---

Do you want to boost performance on your website? You can do that by using **responsive images** and **lazy loading**! In this article, you will find the **HTML, JavaScript, and CSS code** to lazy load responsive images, to make browsers use **modern image formats** like **WebP** and **Jpeg2000**, and to enable **native lazy load** where supported.

<figure>
  <div class="post-image-spacer" style="background-color: #d8d8e0">
    <picture>
      <source
        type="image/jp2"
        srcset="
          /assets/post-images/lazy-load-responsive-images-2020__600w.jp2 600w,
          /assets/post-images/lazy-load-responsive-images-2020__698w.jp2 698w,
          /assets/post-images/lazy-load-responsive-images-2020__1047w.jp2 1047w,
          /assets/post-images/lazy-load-responsive-images-2020__1200w.jp2 1200w
        "
      />
      <source
        type="image/webp"
        srcset="
          /assets/post-images/lazy-load-responsive-images-2020__600w.webp 600w,
          /assets/post-images/lazy-load-responsive-images-2020__698w.webp 698w,
          /assets/post-images/lazy-load-responsive-images-2020__1047w.webp 1047w,
          /assets/post-images/lazy-load-responsive-images-2020__1200w.webp 1200w
        "
      />
      <img
        class="post-image"
        alt="Lazy loading responsive images (2020)" 
        src="/assets/post-images/lazy-load-responsive-images-2020__600w.jpg" 
        srcset="
          /assets/post-images/lazy-load-responsive-images-2020__600w.jpg 600w,
          /assets/post-images/lazy-load-responsive-images-2020__698w.jpg 698w,
          /assets/post-images/lazy-load-responsive-images-2020__1047w.jpg 1047w,
          /assets/post-images/lazy-load-responsive-images-2020__1200w.jpg 1200w
        "
        sizes="(min-width: 630px) 600px, calc(100vw - 26px)"
      >
    </picture>
  </div>
  <figcaption>
    Photo by <a href="https://unsplash.com/@domenicoloia">Domenico Loia</a> on <a href="https://unsplash.com/s/photos/website">Unsplash</a>
  </figcaption>
</figure>

## Definitions

**Responsive images** are `img` tags that download the right image source depending on your design and the user's device. You can provide information about your design in the `sizes` attribute and a list of image sources in the `srcset` attribute. You can also use media queries by wrapping your `img` in a `picture` tag. More about [responsive images in the MDN](https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images).

**Lazy loading images** is a technique that makes your website render faster by **deferring the loading of below-the-fold images** to when they **enter the viewport**. Beyond performance, this also allows you to save bandwidth and money, e.g. if you're paying a CDN service for your images.

## Above-the-fold first

Bear in mind that using a script to **lazy load images is a Javascript-based task** and it's **relevantly slower than the regular image loading** (_eager loading_ from now on) which starts as soon as the HTML document is being parsed.

☝️ For this reason, the best practice is to **eagerly load above-the-fold images**, and **lazy load only the below-the-fold images**.

At this point, people usually ask:

💬 _My website is responsive, how do I know how many images will be_ above-the-fold _at page landing?_

The answer is: count them! Open the web page in a browser, resize the viewport to the most common dimensions (smartphones, computers, and tablets) maybe using the device emulation tool, and count them.

If you can see 4 images _above-the-fold_ in a smartphone viewport, plus only the tip of 4 more images on a desktop viewport, be conservative and eagerly load only 4.

## Now to some code!

Here's the HTML markup of an _eagerly loaded_ responsive image.

```html
<!-- Eagerly loaded,
     above-the-fold only -->
<img
  alt="Eager above"
  src="220x280.jpg"
  srcset="
    220x280.jpg 220w,
    440x560.jpg 440w
  "
  sizes="220px"
/>
```

And here's the markup to _lazy load_ a responsive image.

```html
<!-- Lazy loaded,
     below-the-fold only -->
<img
  alt="Lazy below"
  class="lazy"
  data-src="220x280.jpg"
  data-srcset="220x280.jpg 220w, 
    440x560.jpg 440w"
  data-sizes="220px"
/>
```

Want to show a low-resolution preview while your lazy images are loading? You can do that by using a small, low-quality image in the `src` tag, like the following.

```html
<!-- Lazy loaded,
     + low-res preview,
     below-the-fold only -->
<img
  alt="Lazy below with preview"
  class="lazy"
  src="11x14.jpg"
  data-src="220x280.jpg"
  data-srcset="220x280.jpg 220w, 
    440x560.jpg 440w"
  data-sizes="220px"
/>
```

[Open the 👀 demo](http://verlok.github.io/vanilla-lazyload/demos/image_srcset_lazy_sizes.html), then your browser's **developer tools**, then switch to the **Network panel**. You will see that the first 2 images are _eagerly_ loaded just after page landing, while the rest of the images are _lazily_ loaded **as you scroll down** the page.

We're using the `img` HTML tag and not the `picture` tag, given that the latter is not necessary in this case. I'll dig into the `picture` tag use cases later in this article. ⏩ [Skip to `picture` tag use cases](#picture-tag-use-cases)

### Script inclusion

To load the lazy images as they enter the viewport, you need a lazy load script such as [vanilla-lazyload](https://github.com/verlok/vanilla-lazyload) which is a lightweight (2.5 kb gzipped), blazing-fast, configurable, SEO-friendly script that I created and I've been constantly improving since 2014.

Here is the simplest way to include it in your page.

```html
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.5.0/dist/lazyload.min.js"></script>
```

Have a look at the documentation for [more ways to include LazyLoad](https://github.com/verlok/vanilla-lazyload/#-getting-started---script) in your web pages, like using an `async` script with auto-init, using RequireJS, using WebPack or Rollup.

### LazyLoad initialization

Including the vanilla-lazyload script gives you a `LazyLoad` JS class you can use to load the images identified by the `lazy` CSS class. You must create a `LazyLoad` instance like this:

```js
var lazyLoad = new LazyLoad({
  // Your custom settings go here
});
```

### Minimize layout reflow

When using lazy loading, the images that haven't started loading collapse to `0`-height, only to grow when they'll have started loading. Layout reflowing would make your website janky, so it's a best practice to **stabilize your layout** by occupying the exact amount of space your images will take when loaded, before they start loading.

The universal solution to do that is to use the vertical padding trick, while in the future you'll be able to use the `aspect-ratio` CSS directive to do it (as I'm writing it's [landed](https://twitter.com/Una/status/1260980901934137345) in Chrome Canary only).

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
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
}
```

Here's also a useful SASS mixin to do that (source: [CSS tricks](https://css-tricks.com/snippets/sass/maintain-aspect-ratio-mixin/)).

```scss
@mixin aspect-ratio($width, $height) {
  position: relative;
  &:before {
    display: block;
    content: "";
    width: 100%;
    padding-top: ($height / $width) * 100%;
  }
  > .content {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
  }
}
```

More info in [Sizing Fluid Image Containers with a Little CSS Padding Hack](http://andyshora.com/css-image-container-padding-hack.html) by Andy Shora.

### Avoid "broken" images

To avoid lazy images to appear as broken, even for a short amount of time, use CSS. Hide the images that still don't have neither an `src` nor a `srcset` attribute set.

```css
img:not([src]):not([srcset]) {
  visibility: hidden;
}
```

### No polyfills required

You might be tempted to add one or more polyfills to support Internet Explorer (_yes, I named it and it's 2020_). Don't do that, **you don't need any**. Let me tell you why:

- _Responsive images:_ Internet Explorer does not support responsive images, but you don't need to use a polyfill because <abbr title="Internet Explorer">IE</abbr> gracefully degrades using **the image specified in the `src` attribute**. So choose an image that would appear nice on a regular desktop display, place in the `src` attribute, and you're cool.

- _IntersectionObserver:_ Internet Explorer does not support the `IntersectionObserver` API, which is used by vanilla-lazyload, but you don't need to provide a polyfill because vanilla-lazyload will detect the support for that API and, if missing, it will loads all images immediately. This leads to the same result as if no LazyLoad was ever used on the page, but it doesn't throw any errors.

That's cool, Internet Explorer is not being used by more than 5% of the users today, and Microsoft is silently replacing it with [Edge](https://www.microsoft.com/edge) via Windows Update.

Anyway if for some reason you want it to work in the same exact way on Internet Explorer, you can use the IntersectionObserver polyfill by including it before vanilla-lazyload.

```html
<!-- Don't do this if you're not sure! Read above -->
<script src="https://cdn.jsdelivr.net/npm/intersection-observer@0.10.0/intersection-observer.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@17.5.0/dist/lazyload.min.js"></script>
```

### Putting it all together

For your convenience here's all the HTML, JS, and CSS code together.

```html
<!-- Eagerly loaded,
     above-the-fold only -->
<img
  alt="Eager above"
  src="220x280.jpg"
  srcset="
    220x280.jpg 220w,
    440x560.jpg 440w
  "
  sizes="220px"
/>

<!-- Lazy loaded,
     below-the-fold only -->
<img
  alt="Lazy below"
  class="lazy"
  data-src="220x280.jpg"
  data-srcset="220x280.jpg 220w, 
    440x560.jpg 440w"
  data-sizes="220px"
/>
```

```js
var lazyLoad = new LazyLoad({
  elements_selector: ".lazy"
  cancel_on_exit: true
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

Until now, I wrote about the `img` tag with the `srcset` and `sizes` attributes, which is the solution to the vast majority of the responsive images you might need to use on a website or web application. Now, in which cases should you use the `picture` tag?

### Different width/height ratio

Use case: you need to show images with different **width/height ratio** depending on a media query. e.g. you want to show _portrait images_ on mobile, vertical devices, _landscape images_ on wider viewports, like tablets and computers.

Here's the code you're gonna need in this case. In order to have eagerly loaded images, just use the plain `src` and `srcset` attributes, without `data-` prefix.

```html
<picture>
  <source
    media="(min-width: 1024px)"
    data-srcset="1024x576.jpg 1x,
      2048x1152.jpg 2x"
  />
  <source
    media="(max-width: 1023px)"
    data-srcset="640x960.jpg 1x,
      1280x1920.jpg 2x"
  />
  <img
    class="lazy"
    alt="Portrait or landscape"
    data-src="1024x576.jpg"
  />
</picture>
```

[Open the 👀 demo](http://verlok.github.io/vanilla-lazyload/demos/picture_media.html), then your browser's **developer tools**, then switch to the **Network panel**. You will see that it downloads only the image source corresponding to the first matching media query.

### Load modern formats like WebP and Jpeg2000

Use case: you want browsers to choose the source to **load a modern format like WebP and Jpeg2000** depending on its support for that format.

You need the `source` tag and the `type` attribute containing the MIME type of the images in the `data-`/`srcset` attribute.

```html
<picture>
  <source
    type="image/jp2"
    data-srcset="1024x576.jp2 1x, 
      2048x1152.jp2 2x"
  />
  <source
    type="image/webp"
    data-srcset="1024x576.webp 1x, 
      2048x1152.webp 2x"
  />
  <img
    data-src="1024x576.jpg"
    data-srcset="1024x576.jpg 1x, 
      2048x1152.jpg 2x"
    data-sizes="1024px"
    alt="Jp2, WebP or Jpg"
    class="lazy"
  />
</picture>
```

[Open the 👀 demo](http://verlok.github.io/vanilla-lazyload/demos/picture_type_webp.html), then your browser's **developer tools**, then switch to the **Network panel**. You will see that it downloads only the image source corresponding to the first type that your browser supports.

💬 _Isn't that markup too long for one image?_

Yes, it is. And if you have money to invest in image optimization, there other ways to do that. Most of the cloud-based image servers in the market now automatically serve different image formats at the same URL. This means that you can request `1024x576.jpg` and you get a WebP or a Jpeg2000 accordingly. [Cloudinary](https://cloudinary.com/) and [Akamai Image &amp; Video Manager](https://www.akamai.com/it/it/products/performance/image-and-video-manager.jsp) do that, amongst others.

### Image fidelity capping to 2x

With the rise of very high density "super retina" displays in newest high-end devices such as the whole iPhone 12 and the whole Google Pixel lineups, capping image fidelity to 2x leads to a big improvement in terms of download speed, and no perceivable quality loss for your users. 

👉 [Here's a new best practice on how to do that.]({% post_url 2020-11-11-capping-image-fidelity-2x-minimize-loading-time %})


## Native lazyload

You might have heard or read of [native lazy-loading](https://web.dev/native-lazy-loading/) coming to the web. Cool, isn't it? As of May 2020, it's supported in Chrome, Firefox, Edge, Opera, and _behind a flag_ in Safari.

So 100% browsers support isn't quite there, but in case you want to enable it on supported browsers, you could go for [hybrid lazy-loading](https://www.smashingmagazine.com/2019/05/hybrid-lazy-loading-progressive-migration-native/) by setting the `use_native` option of vanilla-lazyload to `true`.

```js
new LazyLoad({
  use_native: true
});
```

### You might miss these features

If you go for native lazy-loading or hybrid lazyloading, you might miss some **features that JS-driven lazy-loading grants**.

- **automatic classes application** on events (`loading`, `loaded`, etc.)
- **automatic retry loading images** when the network failed and you're back online
- **download cancelation** when images exit the viewport while still loading, to **prioritize the loading of new ones**
- **callbacks on events triggered** (viewport enter/exit, loading started/finished, etc.)

Think about it carefully before switching to native lazy-loading. If you don't mind missing the above features, you're good to go.

---

## Conclusions

Here is a summary:

1. Use [vanilla-lazyload](https://github.com/verlok/vanilla-lazyload/) to load your lazy images.
1. Don't load all the images lazily, just the ones _below the fold_
1. Use the `img` for simple responsive images
1. Use the `picture` tag to
   - change your images width/height ratio at specific media queries
   - conditionally serve your images in modern formats like WebP or Jpeg2000
1. Don't use any polyfill if not strictly required

Happy lazy loading!

### About this article

If something is unclear or you think it could be improved, let me know in the comments or [tweet me](https://twitter.com/verlok/).

☕ If you've found this useful, you might want to express your gratitude by [buying me a coffee](https://ko-fi.com/verlok). ☕

### Useful resources

- [Responsive images in practice](http://alistapart.com/article/responsive-images-in-practice) @ A List Apart
- [Responsive images](https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images) @ Mozilla Developer Network
- [Responsive images in CSS](https://css-tricks.com/responsive-images-css/) @ CSS Tricks
- [Responsive images community group](https://responsiveimages.org) website
