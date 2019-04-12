---
layout: post
title: Native lazy loading and js-based fallback with vanilla-lazyload 12

date: 2019-04-11 19:00:00 +01:00
categories:
- libraries
- techniques
tags: [native, vanilla, lazyload, image, iframe]
---

On April 6th 2019, Addy Osmany wrote about [native image lazy-loading](https://addyosmani.com/blog/lazy-loading/). Two days later Yvain, a front-end developer from Paris, [asked me](https://github.com/verlok/lazyload/issues/331) if my [vanilla-lazyload](https://github.com/verlok/lazyload/) could be a **loading attribute polyfill**, inspiring me to develop and release version 12 of the script, which features a new `use_native` option to enable native lazy-loading where supported. You can already use it today.

## Wait... what?

In case you missed Addy Osmani's article, it will be possible to _natively_ lazy load images through the `loading="lazy"` attribute on images and iframes, and it's already possible on Chrome 75 (currently Canary).

```html
<img loading="lazy" src="...">
<iframe loading="lazy" src="...">
```

Browsers will initially fetch a tiny bit of the images (~2kb) in order to get some initial information (e.g. size), then fetch the rest when they are _about to enter the viewport_.

The problem is that if you directly assign the `src` (and/or `srcset`) to the images, browsers that still don't support native lazy loading would download them all immediately, and this is something you might want to avoid in order to save bandwidth and speed up your website or web application.

![](/assets/post-images/use_native.png "the `use_native` option")

For this reason, I added the `use_native` option in version 12 of _vanilla-lazyload_ which enables native lazy-loading where supported.

More info on native lazy loading can be found on Addy Osmani's post [native image lazy-loading](https://addyosmani.com/blog/lazy-loading/).

## The browser you need

As of 10th April 2019, native lazy-loading is in the early stages (dev preview) and it's available only in Chrome 75 (currently Canary), and under a flag. So in order to test it, you need to:

1. [Download Chrome Canary](https://www.google.com/chrome/canary/) and install it
2. In Chrome Canary, go to the URL *chrome://flags* and enable the following flags:
   - _Enable lazy image loading_
   - _Enable lazy iframe loading_
3. Restart Chrome Canary 

## Demo

Now that you have the Chrome Canary browser with the native lazy loading enabled, you can get started visiting the following demo page.

&rarr; [Open the demo](https://www.andreaverlicchi.eu/lazyload/demos/native_lazyload_conditional.html) _and/or_ [Check the code](https://github.com/verlok/lazyload/blob/master/demos/native_lazyload_conditional.html)

If you did everything correctly, that's what will happen:

- On Chrome 75 (Canary), LazyLoad will trigger the **native lazy-loading**
- On other browsers and older versions of Chrome, the **js-based lazy loading** will occur

## Try it on your website!

In order to try it yourself, you need to follow the following steps.

### Markup

In-viewport / above-the-fold images should be regular <img> tags. Using `data-src` would defeat the browser's preload scanner, so we want to avoid it for performance reasons. In addition, you can use the `loading="eager"` attribute to make sure they load as soon as possible.

```html
<img 
    src="eager-eagle.jpg" 
    loading="eager"
    alt="Eager Eagle" 
/>
```

For off-viewport / below-the-fold images you should still use `data-src`, `data-srcset` and `data-sizes` to avoid an eager loading in unsupported browsers.

```html
<img
    data-src="lazy-sloth.jpg"
    class="lazy"
    alt="Lazy Sloth"
/>
```

Note that you can lazily load responsive images using both the `img` tag and the `picture` tag. [Read more about lazy loading responsive images]({% post_url 2019-03-01-lazy-load-responsive-images-in-2019-srcset-sizes-more %}).

### Now to the Javascript code! 

You're gonna need vanilla-lazyload version 12 (currently in beta). 

You can include it via a CDN:

```html
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0-beta.0/dist/lazyload.min.js"></script>
```

Or install it using npm:

```
npm install vanilla-lazyload@12.0.0-beta.0
```

In your code, set the option `use_native` to `true` when instantiating LazyLoad:

```js
new LazyLoad({
    elements_selector: `.lazy`,
    use_native: true // This one
})
```

The `use_native` option makes sure that:

- where native lazy loading is supported, LazyLoad adds the `loading="lazy"` attribute to the images, then just swaps the `data-*` attributes for the proper ones. Now the browser will manage the lazy loading itself.
- where native lazy loading is NOT supported, the lazy loading continues to be managed by Javascript

## Conclusion

You can have **both native lazy-loading and js-based lazyload today** using vanilla-lazyload 12, just setting the `use_native` option to `true`.

If you have questions, don't hesitate to contact me. On Twitter, I'm [@verlok](https://twitter.com/verlok).