---
layout: post
title: An elegant technique to lazyload images in Swiper, and lazily create Swiper instances
date: 2021-10-27 04:00:00 +02:00
categories:
  - techniques
tags:
  [
    lazyloading,
    images,
    swiper
  ]
---

Say you have multiple carousels in a page, each one containing multiple images, and you want to download only the images that are inside the visible portion of the page, and maybe save some CPU time by lazily create the carousel instances. I think I’ve found a valuable and elegant technique to do so.

The following technique is about lazy loading images inside an instance of [Swiper JS](https://swiperjs.com/), and also lazily creating the Swiper instances below-the-fold, using Swiper with [vanilla-lazyload](https://github.com/verlok/vanilla-lazyload).

The HTML code of the first carousel sets a couple of images as eagerly loaded so browsers will prioritize their downloading, and it leaves all the rest to lazy loading.

```html
<div class="swiper swiper--eager">
  <div class="swiper-wrapper">
    <!-- Eagerly loaded images -->
    <div class="swiper-slide">
      <img
        alt="Stivaletti"
        src="https://via.placeholder.com/220x280?text=S01E01"
        srcset="https://via.placeholder.com/440x560?text=S01E01 2x"
        width="220"
        height="280"
      />
    </div>
    <div class="swiper-slide">
      <img
        alt="Stivaletti"
        src="https://via.placeholder.com/220x280?text=S01E02"
        srcset="https://via.placeholder.com/440x560?text=S01E02 2x"
        width="220"
        height="280"
      />
    </div>
    <!-- Lazy loaded images -->
    <div class="swiper-slide">
      <img
        alt="Stivaletti"
        class="lazy"
        data-src="https://via.placeholder.com/220x280?text=S01E03"
        data-srcset="https://via.placeholder.com/440x560?text=S01E03 2x"
        width="220"
        height="280"
      />
    </div>
    <div class="swiper-slide">
      <img
        alt="Stivaletti"
        class="lazy"
        data-src="https://via.placeholder.com/220x280?text=S01E04"
        data-srcset="https://via.placeholder.com/440x560?text=S01E04 2x"
        width="220"
        height="280"
      />
    </div>
    <div class="swiper-slide">
      <img
        alt="Stivaletti"
        class="lazy"
        data-src="https://via.placeholder.com/220x280?text=S01E05"
        data-srcset="https://via.placeholder.com/440x560?text=S01E05 2x"
        width="220"
        height="280"
      />
    </div>
  </div>
  <div class="swiper-button-prev"></div>
  <div class="swiper-button-next"></div>
</div>
```

From the second carousel on, all the images are to be lazily loaded.

```html
<div class="swiper swiper--lazy" id="swiperLazy1">
  <div class="swiper-wrapper">
    <!-- All lazy loaded images -->
    <div class="swiper-slide">
      <img
        alt="Stivaletti"
        class="lazy"
        data-src="https://via.placeholder.com/220x280?text=S02E01"
        data-srcset="https://via.placeholder.com/440x560?text=S02E01 2x"
        width="220"
        height="280"
      />
    </div>
    <div class="swiper-slide">
      <img
        alt="Stivaletti"
        class="lazy"
        data-src="https://via.placeholder.com/220x280?text=S02E02"
        data-srcset="https://via.placeholder.com/440x560?text=S02E02 2x"
        width="220"
        height="280"
      />
    </div>
    <div class="swiper-slide">
      <img
        alt="Stivaletti"
        class="lazy"
        data-src="https://via.placeholder.com/220x280?text=S02E03"
        data-srcset="https://via.placeholder.com/440x560?text=S02E03 2x"
        width="220"
        height="280"
      />
    </div>
    <div class="swiper-slide">
      <img
        alt="Stivaletti"
        class="lazy"
        data-src="https://via.placeholder.com/220x280?text=S02E04"
        data-srcset="https://via.placeholder.com/440x560?text=S02E04 2x"
        width="220"
        height="280"
      />
    </div>
    <div class="swiper-slide">
      <img
        alt="Stivaletti"
        class="lazy"
        data-src="https://via.placeholder.com/220x280?text=S02E05"
        data-srcset="https://via.placeholder.com/440x560?text=S02E05 2x"
        width="220"
        height="280"
      />
    </div>
  </div>
  <div class="swiper-button-prev"></div>
  <div class="swiper-button-next"></div>
</div>
```

Here goes the JavaScript code that makes the magic. 

```js
const swiperOptions = {
  loop: true,
  slidesPerView: "auto",
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev"
  },
  on: {
    // LazyLoad swiper images after swiper initialization
    afterInit: (swiper) => {
      new LazyLoad({
        container: swiper.el,
        cancel_on_exit: false
      });
    }
  }
};

// Initialize the first swiper right away
const eagerSwiper = new Swiper(".swiper--eager", swiperOptions);

// Initialize all other swipers as they enter the viewport
new LazyLoad({
  elements_selector: ".swiper--lazy",
  unobserve_entered: true,
  callback_enter: function (swiperElement) {
    new Swiper("#" + swiperElement.id, swiperOptions);
  }
});
```

I tested it by emulating a "slow 3G" connection, and I like the waterfall of network calls and the optimal value of the Largest Contentful Paint.

[Try it live here](https://www.andreaverlicchi.eu/vanilla-lazyload/demos/swiper.html).
