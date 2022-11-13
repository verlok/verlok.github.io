---
layout: post
title: Do we still need hybrid lazy loading in 2022?
date: 2022-11-14 08:00:00 +01:00
categories:
  - techniques
  - lazy loading
  - performance
tags:
  [
    lazy loading,
    hybrid lazy loading,
    native lazy loading,
    pros and cons
  ]
---

Back in 2019, as browsers were just starting to support native lazy loading, I [defined hybrid lazy loading](https://www.smashingmagazine.com/2019/05/hybrid-lazy-loading-progressive-migration-native/) a technique to progressively switch from JavaScript lazy loading to native lazy loading, by using `data-src` and using JavaScript and my vanilla-lazyload library to enable native lazy loading in browsers which supported it. Does it still make sense in 2022? 

Now it’s 2022 and, unless you need callbacks or you want to really optimise web performance, for content images you can use `src` and `loading=lazy`, without `data-src`. That is not hybrid lazy loading, that is native lazy loading, and it will work in every browser that support it. You don’t need JavaScript, so no `const lazyContent = new LazyLoad({use_native: true});`. 

For background images you still need the `data-bg` attribute and the `const lazyBackground = new LazyLoad(…);` as browser don’t support it. 

To answer the questions in the title of this issue:

> Does hybrid lazy load still have to use data-src? 

Yes, but you don’t need hybrid lazy loading, at least in the way I mean it. 

> what makes it better than adding the loading='lazy' attribute manually?

Nothing, if you want to enable native lazy loading with `use_native`. If you don’t. Using JS driven lazy load has the following advantages:
- it really hides images to the browser until JavaScript kicks in, which might improve web performance, in terms of largest contentful paint
- on slow connections and pages with lots of images, if users scroll down fast, it optimises to focus on the images on screen, candeline the download of the ones gone off screen
- it triggers callbacks, if you need them to control stuff related to images entering/exiting the viewport or loading/loaded/triggered an error. 
