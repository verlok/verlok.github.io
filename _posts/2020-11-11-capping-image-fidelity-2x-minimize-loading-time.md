---
layout: post
title: Capping image fidelity to 2x to minimize loading time on high-end mobile phones
date: 2020-11-11 23:00:00 +02:00
categories:
    - techniques
tags:
    [
        performance,
        responsive-images,
        image fidelity capping,
    ]
image: capping-image-fidelity__2x.jpg
---

With the rise of very high density "super retina" displays in newest high-end devices such as the whole iPhone 12 and the whole Google Pixel lineups, capping image fidelity to 2x leads to a big improvement in terms of download speed, and no perceivable quality loss for your users. Here's a new best practice on how to do that.

<figure>
  <div class="post-image-spacer" style="background-color: #eee">
    <picture>
        <source type="image/webp" srcset="/assets/post-images/capping-image-fidelity__1x.webp 1x, /assets/post-images/capping-image-fidelity__2x.webp 2x">
        <img alt="Capping image fidelity at 2x" src="/assets/post-images/capping-image-fidelity__2x.jpg" srcset="/assets/post-images/capping-image-fidelity__1x.jpg 1x, /assets/post-images/capping-image-fidelity__2x.jpg 2x" class="post-image">
    </picture>
  </div>
  <figcaption>Photo by <a href="https://unsplash.com/@reinhartjulian?utm_source=unsplash&amp;utm_medium=referral&amp;utm_content=creditCopyText">Reinhart Julian</a> on <a href="https://unsplash.com/?utm_source=unsplash&amp;utm_medium=referral&amp;utm_content=creditCopyText">Unsplash</a></figcaption>
</figure>

## Images x screen densities

In June 2010, Apple introduces the first Retina display on the iPhone 4. "Retina" is just a fancy name to describe a HiDPI display, that has 2x the pixels horizontally and 2x vertically.

HiDPI <abbr title="also known as">aka</abbr> Retina displays are wonderful when having to render vectors, like fonts and SVG images, but when it comes to images, if we don't provide a specific image for HiDPI displays, our regular image gets strecthed to cover all the additinal pixels, which doesn't look good.

So the first thing we started doing was to list a normal image to regular 1x displays and a bigger, better defined image specifically for Retina displays, using the `srcset` attribute and the `x` descriptor. Like this:

```html
<img
    src="batman_1x.jpg"
    srcset="
        batman_1x.jpg 1x,
        batman_2x.jpg 2x
    "
    alt="Batman, Super-man and Wonder Woman"
    width="1280"
    height="720"
/>
```

Remember that `x` descriptor in the `srcset` attribute, we will use this later. `1x` meaning "this is the image for regular screens", `2x` meaning "this is the image for HiDPI <abbr title="also known as">aka</abbr> Retina display". Depending on the device's screen, browsers are to pick the corresponding source and don't stretch it.

## Responsive images

[Responsive images](https://developer.mozilla.org/en-US/docs/Learn/HTML/Multimedia_and_embedding/Responsive_images) are an HTML spec that allows you to serve the proper image size to your users, depending on the space your image occupies on the user's screen, and taking the device pixel ratio into account.

The simplest way to do that is to list all the image sizes we have in a `srcset` attribute, using the `w` descriptor, and tell the browser how big is our image using the `sizes` attribute. Browsers will do the math and they will download the most appropriate image.

If you're confused, I recommend you to [read this in-depth explanation](https://ericportis.com/posts/2014/srcset-sizes/).

```html
<img
    src="batman_1280w.jpg"
    srcset="
        batman_1280w.jpg 1280w,
        batman_1024w.jpg 1024w,
        batman_768w.jpg   768w
    "
    alt="Batman, Super-man and Wonder Woman"
    sizes="100vw"
/>
```

Or complicate things more with media queries in the `sizes` attribute.

```html
<img
    src="batman_1280w.jpg"
    srcset="
        batman_1440w.jpg 1440w,
        batman_1280w.jpg 1280w,
        batman_1024w.jpg 1024w,
        batman_768w.jpg   768w
    "
    alt="Batman, Super-man and Wonder Woman"
    sizes="(min-width: 640px) 50vw, 100vw"
/>
```

## Devices with 3x displays

As I'm writing, there are a bunch of high-end devices, both from Apple and Google, mounting a 3x HiDPI displays, or Super Retina XDR display as Apple calls them.

<figure>
  <div class="post-image-spacer" style="background-color: #fff; padding-bottom: 81.5%">
    <picture>
        <source type="image/webp" srcset="/assets/post-images/devices-with-super-hidpi-display__1x.webp 1x, /assets/post-images/devices-with-super-hidpi-display__2x.webp 2x">
        <img alt="Capping image fidelity at 2x" src="/assets/post-images/devices-with-super-hidpi-display__2x.jpg" srcset="/assets/post-images/devices-with-super-hidpi-display__1x.jpg 1x, /assets/post-images/devices-with-super-hidpi-display__2x.jpg 2x" class="post-image">
    </picture>
  </div>
  <figcaption>Apple and Google devices with 3x HiDPI displays (excluding "Max" versions)</figcaption>
</figure>

## Capping image fidelity

Standing to the analysis on a [Twitter mobile app change](https://blog.twitter.com/engineering/en_us/topics/infrastructure/2019/capping-image-fidelity-on-ultra-high-resolution-devices.html), capping image fidelity to 2x leads to a big improvement in terms of download speed, and no perceivable quality loss for your users.

> Images in timelines on ultra-high resolution devices now load roughly 33% faster while using 1/3rd less data, and with no visible quality change.

The problem with doing responsive images using the `img` tag as we saw above is that there's no way to stop browsers from downloading the 3x image, because to determine which image to download from the `srcset` they do the following calculation:

```
width of the image on screen *
device pixel density =
===
width of the image to download
```

So for example, if an image is to be displayed at a width of `300px` on an iPhone 12, Safari would to:

```
300 *
3
===
900
```

Leading to the download of a 900 pixels wide image.
What we want is to cap the fidelity to 2x so that it downloads the an image 600 pixels wide.

The only way to do that on the web is to use the `picture` tag like the following:

```html
<picture>
    <!-- Landscape tablet / computers -->
    <source
        media="(min-width: ####px)"
        srcset="
            batman_###w.jpg 1x,
            batman_###w.jpg 2x
        "
    />
    <!-- Portrait tablet / landscape smartphone -->
    <source
        media="(min-width: ###px)"
        srcset="batman_###w.jpg 2x"
    />
    <!-- Larger smartphone(s) -->
    <source
        media="(min-width: ###px)"
        srcset="batman_###w.jpg 2x"
    />
    <!-- Smallest smartphone -->
    <img
        src="batman_###w.jpg"
        srcset="batman_###w.jpg 2x"
        alt="Batman Super-man and Wonder"
    />
</picture>
```

Note: I replaced the real numbers with a `###` placeholder, because numbers are not relevant to this explanation.

Notice that:

- on the smartphones media queries we describe only the `2x` image, because all smartphones mount a retina display nowadays
- on the landscape tablet / computers media query we should describe both the `1x` and `2x` images.

## [Optional] Reduce complexity on tablets / computers

If your layout requires you to do more than 1 media query for tablets / computers, you can then conside rusing the `srcset` attribute with the `w` descriptor and the `sizes` attribute, which leads to this:

```html
<picture>
    <!-- Landscape tablet / computers -->
    <source
        media="(min-width: ###px) "
        sizes="(min-width: ###px) 33vw, 50vw"
        srcset="
            batman_####w.jpg ####w,
            batman_####w.jpg ####w,
            batman_###w.jpg   ###w
        "
    />
    <!-- Portrait tablet / landscape smartphone -->
    <source
        media="(min-width: ###px)"
        srcset="batman_###w.jpg 2x"
    />
    <!-- Larger smartphone(s) -->
    <source
        media="(min-width: ###px)"
        srcset="batman_###w.jpg 2x"
    />
    <!-- Smallest smartphone -->
    <img
        src="batman_###w.jpg"
        srcset="batman_###w.jpg 2x"
        alt="Batman Super-man and Wonder"
    />
</picture>
```

In this way, from the landscape tablet / computers media query and above, you won't need to add other `source` tags, because we don't need to cap image quality on computers. So the upmost `source` tag does the trick.

## Conclusion

Capping image quality on super HiDPI devices a relatively new best practice in web design with responsive images, but with the growing number of smartphones spoiling super HiDPI displays, the overall download speed of your website will improve, and so will improve the [LCP](https://web.dev/lcp/) [Web Vital](https://web.dev/vitals/) of your pages. 

Your users will notice the difference.