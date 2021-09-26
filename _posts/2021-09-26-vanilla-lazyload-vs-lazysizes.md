---
layout: post
title: vanilla-lazyload vs lazysizes
date: 2021-09-26 11:00:00 +02:00
categories:
  - libraries
tags:
  [
    libraries,
    lazyloading,
    images,
    iframes,
    videos
  ]
---

It's not the first time I get asked the question: <q>what is the difference between vanilla-lazyload and lazy sizes?</q> It's now time to answer the question once and for all.

<!-- 🤫 Quick answer: find all the differences [in this table](https://github.com/verlok/vanilla-lazyload/blob/master/README.md#vanilla-lazyload-vs-lazysizes) -->

## What are vanilla-lazyload and lazy sizes?

[vanilla-lazyload](https://github.com/verlok/vanilla-lazyload/) and [lazysizes](https://github.com/afarkas/lazysizes/) are two popular Javascript libraries to [lazy-load](https://web.dev/lazy-loading/) images and other DOM elements lazily, meaning <strong>load them only when they enter the visible portion of the web page</strong>, or a little bit earlier than they do.

Both of them are great solutions to improve the <strong>rendering time</strong> of your website, by delaying all non-crucial content to when users <strong>scroll down the page</strong>, ultimately getting better [Core Web Vitals](https://web.dev/cwv) values as a result, and especially an improved [Largest Contentful Paint](https://web.dev/lcp).

So what are the <strong>differences between vanilla-lazyload and lazysizes</strong>?

Both of them are very populare libraries used in production on thousand websites, so I've written this very detailed comparison.

## vanilla-lazyload and lazysizes compared

Find the main features of vanilla-lazyload compared with lazysizes in the table below.

| It                                                                                       | vanilla-lazyload | lazysizes       |
| ---------------------------------------------------------------------------------------- | ---------------- | --------------- |
| Is lightweight (source: [bundlephobia](https://bundlephobia.com/))                       | ✔ (2.8 kB)       | ✔ (3.4 kB)      |
| Is extendable                                                                            | ✔ (via API)      | ✔ (via plugins) |
| Is SEO friendly                                                                          | ✔                | ✔               |
| Optimizes performance by cancelling downloads of images that already exited the viewport | ✔                |                 |
| Retries loading after network connection went off and on again                           | ✔                |                 |
| Supports conditional usage of native lazyloading                                         | ✔                |                 |
| Works with your DOM, your own classes and data-attributes                                | ✔                |                 |
| Can lazyload responsive images                                                           | ✔                | ✔               |
| ...and automatically calculate the value of the `sizes` attribute                        |                  | ✔               |
| Can lazyload iframes                                                                     | ✔                | ✔               |
| Can lazyload videos                                                                      | ✔                |                 |
| Can lazyload background images                                                           | ✔                |                 |
| Can lazily execute code, when given elements enter the viewport                          | ✔                |                 |
| Can restore DOM to its original state                                                    | ✔                |                 |

## Table rows explanained

### Is extendable

Both vanilla-lazyload and lazysizes are extendable, see [vanilla-lazyload API](https://www.github.com/verlok/vanilla-lazyload#-api) and [lazysizes plugins](https://github.com/aFarkas/lazysizes/tree/gh-pages/plugins). 

### Is SEO friendly

Both scripts **don't hide images/assets from search engines**. No matter what markup pattern you use. Search engines don't scroll/interact with your website. These scripts detect whether or not the user agent is capable to scroll and if not, they reveal all images instantly.

### Optimizes performance by cancelling downloads of images that already exited the viewport

If your mobile users are on slow connections and scrolls down fast, vanilla-lazyload cancels the download of images that are still loading but already exited the viewport. If for some reason you don't want this to happen, you can turn this feature off bu setting the option `cancel_on_exit` to `false` (default is `true`).

### Retries loading after network connection went off and on

If your mobile users are on flaky connections and go offline and back online, vanilla-lazyload retries downloading the images that errored.

### Supports conditional usage of native lazyloading

If your users are on a browser supporting native lazyloading and you want to use it, with vanilla-lazyload you can conditinally activate it by setting the `use_native` option to `true`. Find here [more information](https://github.com/verlok/vanilla-lazyload#mixed-native-and-js-based-lazy-loading) and the [conditional native lazyload demo](https://www.andreaverlicchi.eu/vanilla-lazyload/demos/native_lazyload_conditional.html).

### Works with your DOM, your own classes and data-attributes

Both scripts work by default with the `data-src` attribute and the `lazy` class in your DOM, but on vanilla-lazyload you can change it, e.g. to `data-origin`, if you want to migrate from other lazy loading scripts to vanilla-lazyload without changing your HTML markup.

### Can lazyload responsive images

Both vanilla-lazyload and lazysizes can lazyload responsive images by all kinds, the simple `img` tag and the `picture` tag with multiple `source` tags.

For more information, check out [lazy load responsive images in 2020](https://www.andreaverlicchi.eu/lazy-load-responsive-images-in-2020-srcset-sizes-picture-webp/) by yours truly.

### ...and automatically calculate the value of the `sizes` attribute

The lazysizes script has a function that can spare you the "fatigue" of writing the value of the `sizes` attribute in your HTML markup. By placing a `data-sizes="auto"` in your images markup, it can derive its value via Javascript from your CSS.

This is a missing feature vanilla-lazyload for a reason. To make browsers display your website's content as fast as possible, you will have to <strong>mix lazy loading and eager loading</strong> (eager being the opposite of lazy). The best practice here is to eagerly load images above-the-fold and lazy loading the ones below-the-fold. In the eagerly loaded images you will have to put a sensible value of the `sizes` attribute. This means that you will have to calculate that value anyway and, once you did that, what is the use of calculating its value using JavaScript? You can use the value you calculated both for your eager images and your lazy ones.

### Can lazyload iframes

Both vanilla-lazyload and lazisizes can lazyload the `iframe` tag.

### Can lazyload videos

Only vanilla-lazyload can lazyload the `video` tag, even with multiple `source`s. 

See [lazy video](https://github.com/verlok/vanilla-lazyload#lazy-video) in vanilla-lazyload documentation for more.

### Can lazyload background images

Only vanilla-lazyload can lazyload background images, even multiple background images. It also has a way to supporting HiDPI displays such as Retina displays and Super Retina display. 

See [lazy background images](https://github.com/verlok/vanilla-lazyload#lazy-background-image) in vanilla-lazyload documentation for more.

### Can lazily execute code, when given elements enter the viewport

Only on vanilla-lazyload you can execute code when given elements enter the visible portion of the page. 

Check out the [lazy functions](https://www.github.com/verlok/vanilla-lazyload#lazy-functions) section in vanilla-lazyload documentation for more.

### Can restore DOM to its original state

Sometimes you need to clean up your DOM before unloading it and soft-navigating to another page, e.g. when using TurboLinks. 

vanilla-lazyload allows you to restore all DOM it manipulated to its original state by calling the `restoreAll()` method. 

## Conclusion

vanilla-lazyload has more features you can use to lazyload images, background images, videos and iframes, it automatically retries loading images after a network down, supports conditional native lazy loading, can execute code lazily, and restore your DOM to its original state.  
On the other hand, lazysizes is extendable and it has the ability to automatically calculate your images `sizes` attribute if you don't want to.

- [vanilla-lazyload github page](https://github.com/verlok/vanilla-lazyload)
- [lazysizes github page](https://github.com/afarkas/lazysizes/)

I hope you found this article useful!