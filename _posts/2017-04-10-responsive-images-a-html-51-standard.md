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

It's official. Responsive images are now a [W3C recommendation](https://www.w3.org/TR/html51/) since November 2016, featuring the brand new `picture` tag and new attributes for the `img` tag: `srcset` and `sizes`.

Back in 2010, Ethan Marcotte started talking of [responsive web design](https://alistapart.com/article/responsive-web-design), an approach to web design aimed at allowing webpages to be viewed in response to the size of the browser viewport.

That was revolutionary, but suddenly we developers had a new problem to face: in a responsive website, how big should the website's image files be?

The initial approach was to use a large image for all viewport sizes, so that images looked great on large screens and they had to be scaled down on smaller devices, but this soon turned out to be a bad practice: slower (and prepaid) connections on mobile devices and less performing CPUs were slowing down the website and making user experience worse.

So developers started using javascript to pick the right image size based on the viewport, and that's when scripts like [picturefill](https://github.com/scottjehl/picturefill) came about.

But the thing is that Javascript must be downloaded, parsed and executed before the browser could even start downloading the images. We needed something native to go back to defining the images in the HTML and make the browser start download them as soon as possible.

That's when the [Responsive Images Community Group](http://ricg.io/), a group of independent designers and developers, started proposing new tags and attributes to the W3C. 

"Responsive images" is the name given to the technique of *defining more than one source* per each image, and make the browser *download the best one*, depending on a number of factors, which are:

* browser viewport, or website layout
* device pixel density
* supported image formats

[WORK IN PROGRESS]