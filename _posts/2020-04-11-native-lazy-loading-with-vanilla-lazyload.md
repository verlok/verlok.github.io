---
layout: post
title: Native lazy loading with vanillalazyload

date: 2019-04-11 19:00:00 +01:00
categories:
- libraries
- techniques
tags: [native, vanilla, lazyload, image, iframe]
---

On April 6th 2019, Addy Osmany wrote about [native image lazy-loading ](https://addyosmani.com/blog/lazy-loading/). Two days later Yvain, a front-end developer from Paris, [asked me](https://github.com/verlok/lazyload/issues/331) if my [vanilla-lazyload](https://github.com/verlok/lazyload/) could be a **loading attribute polyfill**, inspiring me to develop and release version 12 of the script, which features a new `use_native` option to enable native lazy-loading where supported. Here's how to try it out today.

## The browser you need

Native lazy loading is in dev preview and available only in Chrome Canary under a flag. So in order to test it, you need to:

1. [Download Chrome Canary](https://www.google.com/chrome/canary/) and install it
2. In Chrome Canary, go to the URL *chrome://flags* and enable the following flags:
   - Enable lazy image loading
   - Enable lazy iframe loading
3. Restart Chrome Canary 

## Demo

Now that you have the Chrome Canary browser with the native lazy loading enabled, you get started visiting the following demo pages.

&rarr; [Native LazyLoad Demo](https://www.andreaverlicchi.eu/lazyload/demos/native_lazyload_conditional.html) /or/ [Read the code](https://github.com/verlok/lazyload/blob/master/demos/native_lazyload_conditional.html)

If you did everything correctly, that's what will happen:

- On Chrome Canary, LazyLoad will trigger the **native lazyload**
- On older versions of Chrome or other browsers, the **js-based lazyloading** will occur

## Now you do it!

In order to achieve this on your website, you need to follow the following steps.

In-viewport / above-the-fold images are regular <img> tags. A `data-src` would defeat the preload scanner so we want to avoid it for everything likely to be in the viewport. In addition, I added the `loading="eager"` attribute.

You can still use `data-src`, `data-srcset` and `data-sizes` on images to avoid an eager load in unsupported browsers.

Then use LazyLoad v. 12 beta:

Via script:

```html
<script src="https://cdn.jsdelivr.net/npm/vanilla-lazyload@12.0.0-beta.0/dist/lazyload.min.js"></script>
```

Or via npm:

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

You can have both native lazy-loading and js-based lazyload today using vanilla-lazyload 12, just set the `use_native` option to true.

That's it!
If you have questions, please tweet me @verlok.