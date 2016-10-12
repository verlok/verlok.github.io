---
layout: post
title: Responsive images? You don't need the picture tag
date: 2015-12-21 07:54:00 +01:00
categories:
- techniques
- experiments
tags: [responsive images, picture, tag, responsive design]
---

Say you have a responsive website layout where images are sized at 100% of the container, but **the container is not always as wide as the viewport**. Do we need to use the `picture` tag, or the `img` tag is enough? **The `img` tag can do it**, using its `sizes` and `srcset` attributes. Here's how.

## The images layout

The images in the layout are wide as follows:

| Viewport Width          | Images width     | Container width            |
|-------------------------|------------------|----------------------------|
| 0 to 767 px             | 1/2 of container | 100% with no padding       |
| From 768 px to 1023 px  | 1/3 of container | 100% with 30 px padding    |
| From 1024 px to 1279 px | 1/4 of container | 100% with 30 px padding    |
| From 1280 px up         | 1/4 of container | 1280 px with 30 px padding |

## Units we can use in the `sizes` attribute

When using the `img` tag, in the `sizes` attribute, you can specify how wide your images will display at different media queries, not only using the viewport width (`vw`) unit (as you could find googling around) but **using any length** and also **using CSS `calc()`** if you have to deal with paddings or container's `max-width`.

| Viewport Width          | Images width     | Container width            | Image width in CSS           |
|-------------------------|------------------|----------------------------|------------------------------|
| 0 to 767 px             | 1/2 of container | 100% with no padding       | `50vw`                       |
| From 768 px to 1023 px  | 1/3 of container | 100% with 30 px padding    | `calc(( 100vw - 60 px ) / 3)`|
| From 1024 px to 1279 px | 1/4 of container | 100% with 30 px padding    | `calc(( 100vw - 60 px ) / 4)`|
| From 1280 px up         | 1/4 of container | 1280 px with 30 px padding | `305 px`                     |

See [this pen](http://codepen.io/verlok/pen/JGXeyz?editors=110) which uses media queries and CSS to specify `img` widths, and [this pen](http://codepen.io/verlok/pen/adNQqX?editors=110) which specifies the `sizes` inside the `img` tag.

> Confused? If you need a more extensive explication, please read [srcset and sizes](https://ericportis.com/posts/2014/srcset-sizes/) by Eric Portis, in my opinion the best article about using `img` with `srcset` and `sizes`

## Calculating optimized image sizes based on spacing and device / orientation

We want our images to be optimized at most common resolutions, we need to:

1. Define which are the most common screen resolutions / densities
1. Decide which are the resolutions / densities that we want to optimize for
1. Calculate what the image sizes will be at these resolutions / densities
1. Scale our images to those image sizes
1. Markup the `img`s in our HTML
    2. List all the image sizes in the `srcset` attribute, using the `w` descriptor
    2. List all the image widths in the `sizes` attribute, as defined in the table above

To define the screen resolutions and decide which ones to optimize for, we can use any tool like Google Analytics to get some information about our users and the devices they mostly use.

After some [calculations](https://docs.google.com/spreadsheets/d/1BCeWGXOevUHlL8l9ti2i81C9BgSsHtybO9Z9WAYpfnQ/edit), the resulting image sizes were the following:

| Device & orientation    | Screen width | Img width (css px) | Img height (css px) | Screen density | Img width (px) | Img height (px)     |
|-------------------------|--------------|--------------------|---------------------|----------------|----------------|---------------------|
| iPhone 4/5/5s           | 320          | 160                | 186                 | 2              | **320**        | **372**             |
| iPhone 6                | 375          | 187                | 217                 | 2              | **374**        | **435**             |
| iPhone 5/5s landscape   | 568          | 284                | 330                 | 2              | **568**        | **660**             |
| iPhone 6 landscape      | 667          | 333                | 387                 | 2              | **666**        | **774**             |
| iPad / mini             | 768          | 236                | 274                 | 2              | **472**        | **549**             |
| iPad / mini landscape   | 1024         | 241                | 280                 | 2              | **482**        | **560**             |
| PC with 1280w up        | 1280         | 305                | 355                 | 1              | **305**        | **355**             |
| PC with 1280w and HiDPI | 1280         | 305                | 355                 | 2              | **610**        | **709**             |
| PC with more than 1280w | 1920         | 305                | 355                 | 1              | **305**        | **355**             |

## To the code!

The code of the POC that I created is on GitHub in [this repo](https://www.github.com/verlok/responsiveImagesTagsCompared), and the [live demo is here](http://verlok.github.io/responsiveImagesTagsCompared).

### picture markup

{% highlight html %}
<picture>
    <source media="(max-width: 320px)"
            srcset="http://placehold.it/320x372 2x">
    <source media="(max-width: 375px)"
            srcset="http://placehold.it/374x435 2x">
    <source media="(max-width: 568px)"
            srcset="http://placehold.it/568x660 2x">
    <source media="(max-width: 667px)"
            srcset="http://placehold.it/666x774 2x">
    <source media="(max-width: 768px)"
            srcset="http://placehold.it/472x549 2x">
    <source media="(max-width: 1024px)"
            srcset="http://placehold.it/241x280 1x, http://placehold.it/482x560 2x">
    <source media="(min-width: 1280px)"
            srcset="http://placehold.it/305x355 1x, http://placehold.it/610x709 2x">
    <img src="http://placehold.it/305x355" alt="A product image">
</picture>
{% endhighlight %}

### img markup

{% highlight html %}
<img src="http://placehold.it/305x355"
         srcset="http://placehold.it/241x280 241w,
             http://placehold.it/305x355 305w,
             http://placehold.it/320x372 320w,
             http://placehold.it/374x435 374w,
             http://placehold.it/472x549 472w,
             http://placehold.it/482x560 482w,
             http://placehold.it/568x660 578w,
             http://placehold.it/610x709 610w,
             http://placehold.it/666x774 666w"
         sizes="(min-width: 1280px) 305px,
            (min-width: 1024px) calc((100vw - 60px) / 4),
            (min-width: 768px) calc((100vw - 60px) / 3),
            50vw"
         alt="A product image">
{% endhighlight %}

## Conclusion

* `picture` markup turns out to be more verbose, and we're still not supporting single density displays under 768px.
* `img` markup is shorter and less repetitive, and lets the browser calculate what is the better image to use considering resolution AND pixel density.

**You don't need the `picture` tag.**

The reason is that using the `img` you'll have to write **much less code** to support **much more devices and screen densities**. Given the ability to use CSS' `calc()` function in the length expression of the `sizes` attribute, we can do even complex calculations to define the right image to use even in complex layouts.

Note that the `picture` and `img` tags are comparable only when all the images have the **same ratio over multiple media queries**. If the images ratio change to adapt images to devices ratios, the `picture` tag is the only way to go.

Cheers!