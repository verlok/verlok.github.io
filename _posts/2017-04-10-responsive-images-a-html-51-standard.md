---
layout: post
title: Responsive images, an HTML 5.1 standard
date: 2017-04-10 12:30:00 +01:00
categories:
- techniques
- responsive images
- performance
tags: [responsive images, techniques, performance]
---

It's official. Responsive images are a [W3C recommendation](https://www.w3.org/TR/html51/) since November 2016, featuring the brand new `picture` tag and new attributes for the `img` tag: `srcset` and `sizes`.

## Why responsive images?

Back in 2010, Ethan Marcotte started talking of [responsive web design](https://alistapart.com/article/responsive-web-design), an approach to web design aimed at allowing webpages to be viewed in response to the size of the browser viewport.

That was revolutionary, but suddenly we developers had a new problem to face: in a responsive website, **how big should the website's image files be**?

The initial approach was to use one large image for all viewport sizes, so that images looked great on large screens even if they had to be scaled down on smaller devices, but soon this turned out to be a bad practice: *slower connections* on mobile devices and *less performing CPUs* were slowing down the website and making user experience worse.

Developers then started to use javascript to *pick the right image size* based on the viewport, that's when scripts like [picturefill](https://github.com/scottjehl/picturefill) came about.

But the thing is that javascript is slower then pure HTML: it must be downloaded, parsed and executed before the browser could even start downloading the images. The web needed something native to go back defining images in the HTML in order to allow browsers to start downloading them as soon as possible.

That's why a group of independent designers and developers who go by the name of [Responsive Images Community Group](http://ricg.io/), started proposing new tags and attributes.

## What are responsive images?

"Responsive images" is the name given to the technique of **defining more than one source per each image**, and make the browser **to download the best one**, depending on a number of factors, which are:

* browser viewport, or your website layout
* device pixel density

Users have different pixel densities depending on the monitor of their device. Standard devices have a pixel density of 1, meaning the monitor has 1 device pixel per CSS pixel, while newest HiDpi monitors - including "Retina" displays - have a higher density. For example, a pixel density of 2 means that the monitor has 2x2 device pixels per CSS pixel, and so forth.

HiDpi displays are great when rendering vectors, like fonts or SVG images. But when it comes to render images, browsers will just stretch the original image, making it blurry on devices that are supposed to deliver a better quality.

## Supporting hiDpi displays

The simplest of things you can do with the new `srcset` attribute is supporting different pixel densities. You just need to specify different sources for your image, describing each one with the `x` descriptor, which indicates the pixel density of the image source. Like that:

```html
<img src="shirt_300w.jpg"
  srcset="shirt_300w.jpg 1x,
          shirt_600w.jpg 2x"
  alt="A beautiful shirt"
  width="300" height="380">
```

In this example, we want to display an image of 300 x 380 *CSS* pixels. The standard density image is `shirt_300w.jpg` and it's described by the `1x` descriptor. The double density image is `shirt_300w.jpg`, and it needs to be 600 x 760 pixels.

**Note:** browsers that understand the new `srcset` attribute will ignore the `src` one, which is still required.

This is already a good result to deliver the best image quality to our users, but what if in our responsive layout the image size varies depending on the available space?

## Different image sizes

Let's suppose that our image must be wide:

- 300 pixels on small (< 600) viewports
- 600 pixels on medium (> 600) viewports
- 1200 pixels on large (> 1200) viewports

How do we make sure that our users always get the image size that best fits their viewport *and* pixel density?

We can define images of these sizes:

| Density / Viewport width | < 600     | >= 600      | >= 1200     |
|--------------------------|-----------|-------------|-------------|
| 1x                       | 300 x 380 | 600 x 760   | 1200 x 1520 |
| 2x                       | 600 x 760 | 1200 x 1520 | 2400 x 3040 |

As you can see, we're using 4 different image sizes. I advice to name the images with their width on the name, since it's much clearer to understand.

- 300 x 380 - shirt_300w.jpg
- 600 x 760 - shirt_600w.jpg
- 1200 x 1520 - shirt_1200w.jpg
- 2400 x 3040 - shirt_2400w.jpg

To markup this in our HTML, we must do:

```html
<img src="shirt_300w.jpg"
  srcset="shirt_300w.jpg 300w,
          shirt_600w.jpg 600w,
          shirt_1200w.jpg 1200w,
          shirt_2400w.jpg 2400w"
  alt="A beautiful shirt"
  sizes="(min-width: 1200px) 1200px,
    (min-width: 600px) 600px,
    300px">
```

TODO: CHECK THE ORDER IN `SIZES`




## Browser support

The `srcset` attribute was known to be supported across all browsers except IE 11, but a [bug](https://developer.microsoft.com/en-us/microsoft-edge/platform/issues/7778808/) in MS Edge 14 was recently discovered.

Fortunately, there's an official [polyfill](https://github.com/scottjehl/picturefill/) which makes everything work properly on every browser.