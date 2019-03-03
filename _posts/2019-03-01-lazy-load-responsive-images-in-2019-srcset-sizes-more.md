---
layout: post
title: Lazy load responsive images in 2019
date: 2019-03-01 08:15:00 +01:00
categories:
- development, libraries
tags: [srcset, responsive images, lazy load]
---

In the latest years, both at my job and as maintainer of a [LazyLoad script](https://github.com/verlok/lazyload), I've specialized in **lazy loading** of **responsive images**. Today I'm going to show you what HTML, CSS and JavaScript code you need to write _in 2019_ in order to serve responsive images _and_ load them lazily. In the second part of the post, I'm also showing how to make the browser **natively pick the WebP image** when it supports it.

## Responsive lazy what?

**Responsive images** are the images that adapt to the user's screen _while_ keeping our websites fast by downloading just the right image source for the right **viewport witdh** (from small devices to large desktop computers), also considering the user's **screen density** (retina display, hiDpi, etc.). 

**Lazy loading images** is a technique to make your website faster by **avoiding to load below the fold images**, then loading them **as they enter the viewport**. Beyond performance, this also allows you to save bandwith and money, e.g. if you're paying a CDN service for your images.

## Got it! Now show me some code!

&rarr; [Take a look at the results](http://verlok.github.io/lazyload/demos/image_srcset_lazy_sizes.html) &larr; that you will achieve. Open your browser's **developer tools** and switch to the **network panel**. You will see that the first images are loaded immediately (or _eagerly_) at page landing, while the rest of the images are loaded as you **scroll down** the document.

### The HTML markup

Here's the markup of an immediately loaded responsive image.

```html
<!-- Immediately loaded, responsive image -->
<img
    alt="Image 01"
    src="https://via.placeholder.com/220x280?text=Img+01"
    srcset="https://via.placeholder.com/220x280?text=Img+01 220w,
        https://via.placeholder.com/440x560?text=Img+01 440w"
    sizes="220px"
/>
```

To make sure that your users will see your images **as soon as possible**, I recommend to **immediately load the topmost images** of your webpage, only the ones that will be placed _above the fold_ in most common viewports, considering smartphones, tablets and computers. 

Always remember that lazy loading is a Javascript-based task, so before any lazy image **can start downloading**, your Javascript code needs to be **downloaded, parsed and executed**, your lazy images must be **found in the DOM**, **their position evaluated**, and this operations will take a while.

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

If you want your lazy images to have a low-quality preview image while they load, you can put a small, low-quality image in the `src` tag like the following.

```html
<!-- Lazy loaded responsive image
     with low-quality preview -->
<img
    alt="Image 03"
    class="lazy"
    src="https://via.placeholder.com/11x14?text=Img+03"
    data-src="https://via.placeholder.com/220x280?text=Img+03"
    data-srcset="https://via.placeholder.com/220x280?text=Img+03 220w, https://via.placeholder.com/440x560?text=Img+03 440w"
    data-sizes="220px"
/>
```

We're using the `img` HTML tag and not the `picture` tag, since the latter is not necessary in this case. I'll dig into the `picture` tag use cases [down below](#picture-tag-use-cases).

#### But hey, what about Internet Explorer?

It's true, Internet Explorer does not support responsive images, but given that only its latest version stuck around and it's slowly disappearing from our radars (in the websites we manage, its share is around 4%), I'd suggest NOT to use a responsive images polyfill for it, and just rely on the image specified in the `src` (or `data-src`) attribute instead.

### Script inclusion

To load the lazy images as they enter the viewport, you need a lazy load script such as [vanilla-lazyload](http://verlok.github.io/lazyload/) which is a lightweight-as-air (1.9 kb gzipped), configurable, SEO-friendly script that I've been developing and improving since 2014. It's also based on the `IntersectionObserver` browser API so it's blazing fast and grants jank-free scrolling also on slower devices.

Here is the simplest way to include the script in your page.

```html
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@11.0.2/dist/lazyload.min.js"></script>
```

### LazyLoad initialization

You need LazyLoad to manage and load all the images with the `.lazy` class in the page. You can initialize `LazyLoad` like this:


```js
var lazyLoad = new LazyLoad({
    elements_selector: ".lazy",
    // More options here
});
```

**NOTE:** You have other choices for script inclusion in your web pages, like using an `async` script with auto-init, or using RequireJS, or with WebPack or Rollup.js. It's your choice. [Learn more](https://github.com/verlok/lazyload/#include-lazyload-in-your-project). 

### Some CSS Tricks

There are also some features that you can achieve using CSS only. You need to:

* **Make not-yet-loaded lazy images to occupy some space**. If you don't do so, those images will have height `0` and they'll collapse one next to another. As a result, all of them will enter the viewport all at the same time, nullifying our efforts to load them as they enter the viewport.
* Avoid empty images to appear as broken images
* Resolve a Firefox anomaly that displays the broken image icon while images are loading

You can do all that using this CSS rules:

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
Fixes the Firefox anomaly while images are loading
*/
@-moz-document url-prefix() {
    img:-moz-loading {
        visibility: hidden;
    }
}
```

### Picture tag use cases

Until now, I wrote about the `img` tag with the `srcset` and `sizes` attributes, which is the solution to the vast majority of the responsive images you might need and use on a website or web application. Now, in which cases should you use the `picture` tag?

#### Different width/height ratio

Use case: you need to show images with different **width/height ratio** depending on a media query. e.g. you want to show _portrait_ images on mobile, vertical devices, _landscape_ on wider viewports, like tablets and computers.

&rarr; [Take a look at the results](http://verlok.github.io/lazyload/demos/picture_media.html) &larr; 

Here's the code you're gonna need in this case. In order to have immediately loaded images, just use the plain `src` and `srcset` attributes, with no `data-` prefix.

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

#### Automatically switch to WebP

Use case: you want the browser to **automatically pick the WebP format** depending on its support for that format.

&rarr; [Take a look at the results](http://verlok.github.io/lazyload/demos/picture_type_webp.html) &larr; 

Here's the code! Again, in order to obtain immediately loaded images, just use the plain `src`, `srcset` and `sizes` attributes, with no `data-` prefix.

```html
<picture>
    <source
        type="image/webp"
        data-srcset="https://via.placeholder.com/1024x576?text=WebP+Image 1x, https://via.placeholder.com/2048x1152?text=WebP+Image 2x"
        data-sizes="220px"
    />
    <img
        data-src="https://via.placeholder.com/256.jpg?text=1024x576+Jpg+Image"
        data-srcset="https://via.placeholder.com/1024x576?text=Jpg+Image 1x, https://via.placeholder.com/2048x1152?text=Jpg+Image 2x"
        data-sizes="220px"
        alt="An image"
        class="lazy"
    />
    </picture>
```

## _One more thing_

The vanilla [LazyLoad script](https://github.com/verlok/lazyload) leverages the `IntersectionObserver` API so, in browser not supporting it like Internet Explorer and older versions of Safari, it will load all images as soon as it executes, which leads more or less to the same result as if no LazyLoad was ever used on the page.

If you want to load your content lazily in the 100% of the browsers out there (I wouldn't, but it's up to you), you need to include the [IntersectionObserver Polyfill](https://github.com/w3c/IntersectionObserver/tree/master/polyfill) script before LazyLoad. 

You can either you put the script in the page just before the LazyLoad one, as it follows...

```html
<script src="https://cdn.jsdelivr.net/npm/intersection-observer@0.5.1/intersection-observer.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@11.0.2/dist/lazyload.min.js"></script>
```

...or you can load it the polyfill as a dependency of LazyLoad using _RequireJS_ or another AMD module loader. [More info here](https://github.com/verlok/lazyload/blob/master/README.md#include-via-requirejs-without-intersectionobserver-polyfill).

## Conclusions

Here is a summary:

1. Don't load all the images lazily, just the ones _below the fold_
2. Use the `img` tag to do simple responsive images
3. Use the `picture` tag to conditinally serve the WebP version of your images, or to change your images ratio
4. Use [vanilla-lazyload](https://github.com/verlok/lazyload/) to load your lazy images.
5. Optionally use the IntersectionObserver polyfill if you want to load lazily on 100% of the browsers.

If something is unclear or could be improved, let me know in the comments. Or [tweet me](https://twitter.com/verlok/).

If you did find this useful, feel free to share it! 

### Useful resources

- [Responsive images in practice](http://alistapart.com/article/responsive-images-in-practice) @ A List Apart
- [Responsive images](https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images) @ Mozilla Developer Network
- [Responsive images in CSS](https://css-tricks.com/responsive-images-css/) @ CSS Tricks
- [Responsive images community group](https://responsiveimages.org) website
