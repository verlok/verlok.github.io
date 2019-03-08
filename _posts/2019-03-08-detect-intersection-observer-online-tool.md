---
layout: post
title: Detect IntersectionObserver with an online tool

date: 2019-03-08 22:15:00 +01:00
categories:
- tools
tags: [IntersectionObserver, detect]
---

Today I updated my iPhone to iOS 12.2 beta 4 which features the new version of Safari (also 12.2) with support to the IntersectionObserver API. I wanted to see it clearly so I've created a web page that detects and reveals to you if it's supported.

&rarr; [Open the tool](http://www.andreaverlicchi.eu/IntersectionObserverDetect/).

What you'll see there:

- If you are browsing the page using Firefox, Microsoft Edge, Chrome, Opera or other chromium based browsers, you will get a **YES**;
- If you're browsing with Internet Explorer you'll get a **NO**, (and you deserve it);
- If you browse using Safari, you need to have iOS 12.2 (now in beta) or Mac OS with Safari 12.1 (now in Technology Preview) in order to get a **YES**. On older versions, you'll get a **NO**, but it won't be for long.

To know what you can do with IntersectionObserver, [read this post]({% post_url 2017-09-04-using-intersection-observers-to-create-vanilla-lazyload %}).