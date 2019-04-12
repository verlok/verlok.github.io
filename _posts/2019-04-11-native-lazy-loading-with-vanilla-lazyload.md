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

In case you didn't read Addy's post, it will soon be possible to _natively_ lazy load images through the `loading="lazy"` attribute on images and iframes.

```html
<img loading="lazy" src="...">
<iframe loading="lazy" src="...">
```

Browsers will fetch the first 2kb of the images in order to get some initial information (e.g. size), then fetch the rest when they are about to enter the viewport.

The problem is that if you directly assign the `src` (and/or `srcset`) to the images, the browser which still don't support native lazy loading would download them all immediately, and this is something you might want to avoid in order to save bandwidth and speed up your website or web application.

For this reason, I added the `use_native` option in version 12 of _vanilla-lazyload_ which enable native lazy-loading where supported.

More info on native lazy loading can be found on Addy Osmani's post [native image lazy-loading](https://addyosmani.com/blog/lazy-loading/).

You lazily load responsive images using both the `img` tag and the `picture` tag. See also: [lazy loading responsive images in 2019]({% post_url 2019-03-01-lazy-load-responsive-images-in-2019-srcset-sizes-more %}).

## The browser you need

As of 10th April 2019, native lazy-loading is in dev preview and available only in Chrome 75, which means Chrome Canary, and under a flag. So in order to test it, you need to:

1. [Download Chrome Canary](https://www.google.com/chrome/canary/) and install it
2. In Chrome Canary, go to the URL *chrome://flags* and enable the following flags:
   - _Enable lazy image loading_
   - _Enable lazy iframe loading_
3. Restart Chrome Canary 

## Demo

Now that you have the Chrome Canary browser with the native lazy loading enabled, you get started visiting the following demo pages.

&rarr; [Native LazyLoad Demo](https://www.andreaverlicchi.eu/lazyload/demos/native_lazyload_conditional.html) /or/ [Read the code](https://github.com/verlok/lazyload/blob/master/demos/native_lazyload_conditional.html)

If you did everything correctly, that's what will happen:

- On Chrome Canary, LazyLoad will trigger the **native lazyload**
- On older versions of Chrome or other browsers, the **js-based lazyloading** will occur

## Now you do it!

In order to achieve this on your website, you need to follow the following steps.

In-viewport / above-the-fold images are regular <img> tags. A `data-src` would defeat the preload scanner so we want to avoid it for everything likely to be in the viewport. In addition, I'd the `loading="eager"` attribute to make sure they load as soon as possible.

```html
<img 
    src="https://via.placeholder.com/440x560?text=Img+01" 
    loading="eager"
    alt="Img 01" 
/>
```

You should still use `data-src`, `data-srcset` and `data-sizes` on images to avoid an eager load in unsupported browsers.

```html
<img
    data-src="https://via.placeholder.com/440x560?text=Img+03"
    class="lazy"
    alt="Img 03"
/>
```

Then use LazyLoad v. 12 beta. Via jsdelivr CDN:

```html
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0-beta.0/dist/lazyload.min.js"></script>
```

Or install it using npm:

```
npm install vanilla-lazyload@12.0.0-beta.0
```

Then in your Javascript code, instantiate a LazyLoad with the `use_native` option set to `true`.

```js
new LazyLoad({
    elements_selector: `.lazy`,
    use_native: true // <-- See?
})
```

The `use_native` option makes sure that:

- where native lazy loading is supported, LazyLoad adds the `loading="lazy"` attribute to the images, then just swaps the `data-*` attributes for the proper ones. Now the browser will manage the lazy loading itself.
- where native lazy loading is NOT supported, the lazy loading continues to be managed by Javascript

## Conclusion

You can already have both native lazy-loading and js-based lazyload today using vanilla-lazyload 12, just set the `use_native` option to true.

If you have questions, don't hesitate to contact me. On Twitter, I'm [@verlok](https://twitter.com/verlok).