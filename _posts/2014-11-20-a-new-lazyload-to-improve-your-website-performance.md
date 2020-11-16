---
layout: post
title: A new LazyLoad to improve your website performance
date: 2014-11-20 19:26:58.000000000 +01:00
categories:
- libraries
tags: [lazy load, performance, vanilla javascript]
status: publish
type: post
published: true
---
In the latest days I've been working on websites performance optimization and I realized that there is no way to take advantage of the **progressive JPEG** image format on websites if you're using [jQuery_lazyload](https://github.com/tuupola/jquery_lazyload "Mika Tuupola"). So after sending a pull request to its author, I decided to write my own lazy load, which turned out to be better, because:

* it's 6x faster
* it allows you to [lazy load responsive images]({% post_url 2015-04-20-lazy-load-responsive-images-srcset %})
* it doesn't depend on jQuery
* it best supports the progressive JPEG format

More information on [LazyLoad website](http://verlok.github.io/vanilla-lazyload/).
Check out the code on the [GitHub Repo](https://github.com/verlok/vanilla-lazyload).