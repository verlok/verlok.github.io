---
layout: post
title: How to optimise for CLS when loading more content asynchronously
date: 2020-08-31 19:00:00 +02:00
categories:
  - techniques
tags:
  [
    cumulative layout shift,
    pagination,
    infinite scroll,
    lazy loading
  ]
image: optimise-cls-load-more__1x.webp
---

Cumulative Layout Shift (CLS) is an important, user-centric metric for measuring visual stability because it helps quantify how often users experience unexpected layout shifts — a low CLS helps ensure that the page is delightful.

<div class="post-image-spacer" style="background-color: #FFF">
  <img 
    alt="vanilla-lazyload and lazysizes" 
    src="/assets/post-images/optimise-cls-load-more__1x.jpg" 
    srcset="/assets/post-images/optimise-cls-load-more__1x.webp 1x, /assets/post-images/optimise-cls-load-more__2x.webp 2x" 
    class="post-image"
    width="600"
    height="399">
</div>

What you might not know is:

- **CLS is measured continuously**. In fact, its value is also updated while your users scroll your page, if the scroll generates some layout movement
- **CLS measurement is paused for 500ms** whenever a user interaction like a click or a keyboard event occurs

Long story short, Cumulative Layout Shift measures every unexpected layout movement occurring while your users interact with the page, including while they scroll down.

> When loading more content in our pages, the most common source of CLS is the page footer becoming visible for a while, then being pushed below-the-fold again by new, dynamically added content.

So how to keep CLS from growing when we need to load new content dynamically, e.g. to load a whole new page of products? 

[Continue reading on Medium](https://medium.com/ynap-tech/how-to-optimize-for-cls-when-having-to-load-more-content-3f60f0cf561c)