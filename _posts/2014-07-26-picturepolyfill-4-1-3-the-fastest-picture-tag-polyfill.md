---
layout: post
title: PicturePolyfill 4 - the fastest picture tag polyfill
date: 2014-07-26 14:59:20.000000000 +02:00
categories:
- libraries
tags: [picture, polyfill, responsive images, responsive web design, vanilla javascript]
status: publish
type: post
published: true
---
**PicturePolyfill 4** is out! Implementing responsive images in your site has never been so simple and fast.

![Responsive image](/assets/Copia-di-Schermata-2014-07-26-alle-15.46.48-709x215.jpg)

## Most important features

*   the `source` parsing algorithm behavior: it now exits at the first matching media query instead of at the last one, as the native implementation does
*   one `img` tag is now mandatory, as defined in the [picture tag specification](http://www.w3.org/html/wg/drafts/html/master/embedded-content.html#the-picture-element)
*   the `srcset` attribute inside the `img` tag is now better managed, in browsers that support it
*   the script is now lighter than before, because the functions to create the `img` tag were removed
*   the script is now even faster because it now parses only the matching `srcset` attribute, and not all of them as before
*   the internal cache system is still in place and working fine but  you can avoid using it (just in case you need to) passing a parameter

## Installation - Manually

*   Download picturePolyfill from [GitHub](https://github.com/verlok/picturePolyfill "PicturePolyfill page on GitHub")
*   Include the minified file in your project script directory

## Installation - Using bower

You can install the latest version of picturePolyfill using bower. Just enter the following command in the Terminal, and it's done.

```
bower install picturePolyfill
```