---
layout: post
title: Data-driven images optimisation for the most common screen resolutions
date: 2021-10-26 19:00:00 +02:00
categories:
  - techniques
tags:
  [
    screen resolution,
    pixel density,
    image optimisation,
    analytics
  ]
image: ---__1x.jpg
---

When you start using a SAAS Image Manager like Cloudinary, Akamai Image Manager or similar, you might be tempted to create a considerable amount of resized images to get the perfect fit for every possible screen resolution. But in order to get best performance results, if you consider the most common screen resolutions and device pixel densities, it turns out that you probably need only 3 or 4 resized images.

## A switch of approach

As a web performance geek and front-end architect at YNAP, I've been pair-programming with dozens of developers for a few years now, to optimise images in fashion and luxury e-commerce websites. The mission was always the same: optimise images performance using the less resized images possible, without sacrificing quality.

Throughout the years I've been iteratively perfecting a technique which involved both measurements in the browser's developer tools and calculations on a spreadsheet, to find the perfect balance between performance and quality, limiting the number of resized images to 10-ish.

After repeating the same job many times for many different layouts created by our creative department, the idea of automatically calculating the widths of the resized image started to grow in me, so I started developing a calculator app which, given some layout parameters, calculates the optimial resized images dimensions.

The process of developing the calculator made me go for an even more scientific approach: I needed to know which were the most common viewport widths of the devices used to brwose our website. In addition to that, I needed to know which were the device pixel ratio related to the viewport widths.

So we've started to track device pixel ratio (`window.devicePixelRatio`) on Google Analytics and after some time we were able to extract the data, something like the following:

| Width | Device pixel ratio | Number of sessions | %   |
| ----- | ------------------ | ------------------ | --- |
| 320   | 2                  | 10                 | 1%  |
| 360   | 3                  | 100                | 10% |
| ...   | ...                | ...                | ... |
| 414   | 3                  | 200                | 2%  |



--

You’d better reuse the same image resizes across the pages, across devices, across your users, so the lesser you have the better

How do you find the optimal resizes then? Get the most used screen sizes + screen pixel densities, optimise for those first, let the browser resize the images in all other cases

Example HTML before
Example HTML later

Improvement in LCP
