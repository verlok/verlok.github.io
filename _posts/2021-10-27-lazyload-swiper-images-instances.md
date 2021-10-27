---
layout: post
title: A clever way to lazyload images in Swiper, and lazily create Swiper instances
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

I think I've found a valuable and elegant technique to lazyload images inside a Swiper instance and also lazily create multiple instances of Swiper in a page, using a combination of Swiper and vanilla-lazyload. 

Say you have multiple Swiper instances in a page, each Swiper instance containing multiple images, but you only want

- to download only the images inside the visible portion of the page, to save bandwidth and optimize the user experience 
- to lazily create Swiper instances, as they enter the page, to increment the DOM only as needed

The HTML code leaves a couple of images as eagerly loaded, to prioritise their downloads, and leaves the rest all lazy. 

```html
    <p>This is an eagerly loaded swiper</p>
    <div class="swiper swiper--eager">
      <div class="swiper-wrapper">
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

    <p>Following, more lazily loaded swipers</p>
    <div class="swiper swiper--lazy" id="swiperLazy1">
      <div class="swiper-wrapper">
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

And here's the JavaScript code to make it happen. 

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

I've tested it emulating a "slow 3G" connection and I like the waterfall and the Largest Contentful Paint a lot.  

[Try it live here](https://www.andreaverlicchi.eu/vanilla-lazyload/demos/swiper.html).

What do you think? Let me know in the comments. 
