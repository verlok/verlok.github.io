---
layout: post
title: SVG + PNG fallback made super-easy with Grunt and SVGZR
date: 2014-07-18 07:20:57.000000000 +02:00
categories:
- libraries
- announcements
tags: [svg, grunt, techniques]
status: publish
type: post
published: true
---
It was recently released the **SVGZR** Grunt Plugin, which makes super-easy to implement SVG icons in your website, with automatic PNG fallback for older <abbr title="Internet Explorer">IE</abbr> versions.

![SVG Icons](/assets/post-images/svg-icons.jpg)

SVGZR will help you to:

*   take all the SVG images from an input folder
*   compress the SVG removing useless data from the SVG format
*   embed all the SVG images in a CSS file (using the base64 encoding), each one with a specific class name referring to the file name
*   create a PNG sprite image as a fallback for legacy browsers

You can find the Grunt Plugin and more information at this [SVGZR GitHub page](https://github.com/aditollo/grunt-svgzr), and you can install it as a [NPM module](https://www.npmjs.org/package/grunt-svgzr).