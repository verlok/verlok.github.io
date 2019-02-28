---
layout: post
title: Lazy load responsive images in 2019. Srcset, sizes and more!
date: 2019-03-01 08:15:00 +01:00
categories:
- development, libraries
tags: [srcset, responsive images, lazy load]
---

In the latest years, both at my job and as maintainer of a [LazyLoad script](https://github.com/verlok/lazyload), I've specialized in **lazy loading** of **responsive images**. In this article, I'm going to show you what HTML, CSS and Javascript code you need to write in 2019 in order to lazy load responsive images.

## Responsive lazy what?

**Responsive images** are the images that adapt to the user's screen _while_ keeping our websites fast by downloading just the right image source for the right **viewport witdh** (from small devices to large desktop computers), also considering the user's **screen density** (retina display, hiDpi, etc.). 

**Lazy loading images** is a technique to make your website faster by **avoiding to load images** that your users might never see on their viewport, then **loading them as they enter the viewport**. Beyond performance, this also allows you to save bandwith (and money, if you're paying a CDN service for your images).

## Just show me the code!

&rarr; [Take a look at the results](http://verlok.github.io/lazyload/demos/image_srcset_lazy_sizes.html) &larr; you will achieve. Open your browser's **developer tools** and switch to the **network panel**. You will see that the first images are loaded immediately (or _eagerly_) by the browser at page landing, while the rest of the images are loaded as you **scroll down** the document.

### The markup

Here's the markup of an immediately loaded responsive image.

```html
<!-- Immediately loaded responsive image -->
<img
    alt="Image 01"
    src="https://via.placeholder.com/220x280?text=Img+01"
    srcset="https://via.placeholder.com/220x280?text=Img+01 220w,
        https://via.placeholder.com/440x560?text=Img+01 440w"
    sizes="220px"
/>
```

([Learn more about `srcset` and `sizes`](http://alistapart.com/article/responsive-images-in-practice))

To make sure that your users will see your images **as soon as possible**, I recommend to **load immediately the topmost images** of your webpage, only the ones that will be placed _above the fold_ in most common viewports, considering smartphones, tablets and computers. 

Always remember that lazy loading is a Javascript-based task, so before any lazy image **can start downloading**, your Javascript code needs to be **downloaded, parsed and executed**, your lazy images must be **found in the DOM**, and **their position evaluated**, and this operations will take a while.

And here's the markup you're going to need in order to _lazy load_ a responsive image.

```html
<!-- Lazy loaded responsive image -->
<img
    alt="Image 03"
    class="lazy"
    data-src="https://via.placeholder.com/220x280?text=Img+03"
    data-srcset="https://via.placeholder.com/220x280?text=Img+03 220w, https://via.placeholder.com/440x560?text=Img+03 440w"
    data-sizes="220px"
/>
```

Note that we're using the `img` HTML tag and not the `picture` tag, since the latter is not necessary in this case. I'll dig into the `picture` tag use cases later.

### Script inclusion

We need a library to load the `.lazy` images as they enter the viewport, and there are a quite a few around. Since November 2014 I've been writing [vanilla-lazyload](http://verlok.github.io/lazyload/) which is lightweight as air (4 kb minified, less than 2 kb gzipped), configurable , SEO-friendly, and it also leverages the `IntersectionObserver` browser API so it's blazing fast and jank-free. 

Internet Explorer doesn't support responsive images, but given that only the last version of Internet Explorer (11) stuck around and it has almost disappeared from our radars, I'd suggest NOT to use a responsive images polyfill for it, and just rely on the image specified in the `src` attribute instead.

So you just need to include the vanilla-lazyload script.

```html
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@11.0.2/dist/lazyload.min.js"></script>
```

### Script initialization

Once the script is initialized and executed, you can initialize `LazyLoad` by doing this:


```js
var lazyLoad = new LazyLoad({
    elements_selector: ".lazy",
    // More options here?
});
```

**NOTE:** You have other choices for script inclusion in your web pages, like using an `async` script, using RequireJS, or again with WebPack or Rollup.js -> [read more](https://github.com/verlok/lazyload/#include-lazyload-in-your-project). It's your choice.


----- ORIGINAL POST - RESUME FROM HERE ------

TODO:

- [ ] Dig into `picture` use cases
- [ ] Explain how to load `IO` polyfill as a dependency


### The stylesheet

There are also some features that can be achieved only using our CSS. We need to:

* Make empty images to occupy some space. If we don't do so, all the empty images will be collapsed one to another and they will enter the viewport all at the same time, nullifying our efforts to load them lazily.
* Avoid empty images to appear as broken images
* (if we used the `show_while_loading` option, as we did) Resolve a Firefox anomaly that displays the broken image icon while images are loading

We can do all that using this CSS rules:

```css
/*
Makes images container to occupy some space 
when the images aren't loaded yet.
This value depends on your layout.
*/
.imageList li {
    min-height: 300px;
}
/*
Avoid empty images to appear as broken
*/
img:not([src]):not([srcset]) {
    visibility: hidden;
}
/* 
Fixes Firefox anomaly during images load time 
*/
@-moz-document url-prefix() {
    img:-moz-loading {
        visibility: hidden;
    }
}
```

## That's it!

It was very easy, wasn't it? If you didn't yet, [take a look at the demo](http://verlok.github.io/img_srcset_lazyload) of what we achieved here.
