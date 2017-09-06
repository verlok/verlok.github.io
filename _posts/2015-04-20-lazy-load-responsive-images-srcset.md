---
layout: post
title: Lazy load of responsive images with srcset and LazyLoad
date: 2015-04-20 08:14:00 +01:00
categories:
- development, libraries
tags: [srcset, responsive images, lazy load]
---
It's now possible (yes, today!) to have **lazy loading** on **responsive images** to make our images to adapt to users screens _and_ keep our website fast. YAY! \o/ In this article, we'll see what markup we need to write and which Javascript libraries we're gonna need to do that.

## Responsive lazy what?

**Responsive images** is a technique to make the images in your website to adapt to the **viewport witdh** and **screen density** (1x, 2x - retina display, etc.). To understand how to do this, you can read [Responsive images in practise](http://alistapart.com/article/responsive-images-in-practice) and you can find more info at the [responsive images community group website](http://responsiveimages.org/).

**Lazy loading images** is a technique to make your website faster by **avoiding to load images** that the user might never see on his viewport, then **loading them as they enter the viewport**. Beyond performance, this also allows you to save bandwith (and money, if you're paying a CDN service for your images). 


## Implementation

[Take a look at the results](http://verlok.github.io/img_srcset_lazyload) we're going to achieve using this techniques together.

If you open your browser inspector in the network panel, you would see that the first images are loaded "normally" by the browser at page landing, but the rest of the images are loaded as you scroll down the document.

### The markup

Here's the markup you're gonna need to lazy load a responsive image.

```html
<!-- Image loaded normally by the browser -->
<img srcset="img/41494516WM_10r_n_f.jpg 668w,
        img/41494516WM_10_n_f.jpg 334w,
        img/41494516WM_9r_n_f.jpg 446w, 
        img/41494516WM_9_n_f.jpg 223w"
    sizes="(min-width: 361px) 50vw,
        (min-width: 481px) 33.333vw, 
        (min-width: 769px) 25vw, 
        (min-width: 1025px) 20vw, 
        100vw">
        
<!-- Image loaded lazily by javascript -->
<img data-srcset="img/41494516WM_10r_n_f.jpg 668w,
        img/41494516WM_10_n_f.jpg 334w,
        img/41494516WM_9r_n_f.jpg 446w, 
        img/41494516WM_9_n_f.jpg 223w"
    sizes="(min-width: 361px) 50vw,
        (min-width: 481px) 33.333vw, 
        (min-width: 769px) 25vw, 
        (min-width: 1025px) 20vw, 
        100vw">
```

Note that we're using the `img` HTML tag and **not** the `picture`. The latter is not necessary because we're not changing the image ratio in this case.


### Script inclusion

First of all, we need a library to load the lazy images as they enter the viewport. There are a couple of libraries to have your images loaded lazily, but to have lazy loading of _responsive_ images you're gonna need the one that I wrote: [LazyLoad](http://verlok.github.io/lazyload/) (read about all its advantages [here]({% post_url 2014-11-20-a-new-lazyload-to-improve-your-website-performance %})).

Furthermore, as not all browser are supporting responsive images, we need to include Filament Group's [picturefill](https://github.com/scottjehl/picturefill) library, a polyfill which allows us fill the gap and make responsive images work in all browsers. Note that this library won't be necessary when all browsers you need to support will support responsive images.

So we're going to include those 2 scripts:

```html
<script src="js/vendor/lazyload.min.js"></script>
<script src="js/vendor/picturefill.min.js"></script>
```


### Script initialization

What we need to do is create a new instance of `LazyLoad` to transform that `data-srcset` attribute into a proper `srcset` attribute. This would be enough for browsers that natively support _responsive images_ but, for the rest of them, we need to call `picturefill` soon after `LazyLoad` has modified the DOM. 

We can do all of that using this command:

```js
/*var myLazyLoad = */ new LazyLoad({
    data_src: "src",
    data_srcset: "srcset",
    show_while_loading: true, //best for progressive JPEG
    callback_set: function (img) {
        picturefill({
            elements: [img]
        });
    }
});
```

For further reference about what we did here, see [LazyLoad documentation](http://verlok.github.io/lazyload/).

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
