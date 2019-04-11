---
layout: post
title: Native lazy loading with vanillalazyload

date: 2019-04-11 19:00:00 +01:00
categories:
- libraries
- techniques
tags: [native, vanilla, lazyload, image, iframe]
---

On April 6th 2019, Addy Osmany wrote about [native image lazy-loading ](https://addyosmani.com/blog/lazy-loading/). Two days later Yvain, a front-end developer from Paris, [asked me](https://github.com/verlok/lazyload/issues/331) if my [vanilla-lazyload](https://github.com/verlok/lazyload/) could be a **loading attribute polyfill**, inspiring me to develop and release version 12 of the script, which features a new `use_native` option to enable native lazy-loading where supported.

