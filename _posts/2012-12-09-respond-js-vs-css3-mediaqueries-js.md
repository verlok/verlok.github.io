---
layout: post
title: Respond.js vs css3-mediaqueries.js
date: 2012-12-09 18:55:05.000000000 +01:00
categories:
- development
tags:
- css3-mediaqueries.js
- graceful degradation
- javascript
- respond.js
- responsive
status: publish
type: post
published: true
---
Googling **respond.js vs css3-mediaqueries.js** I've found [Techniques For Gracefully Degrading Media Queries](http://coding.smashingmagazine.com/2011/08/10/techniques-for-gracefully-degrading-media-queries/), a Smashing Magazine post about [Lewis Nyman](http://lewisnyman.co.uk) which talks about how to apply the **graceful degradation** of media queries on browsers that don't support them (IE 8, IE 7, IE 6).

![](/assets/post-images/responsive.jpg "responsive")

The options are:

*   Use a **separate style sheet** to load conditionally on old Internet Explorer versions, or separate style rules to apply based on the body class
*   Use a **javascript fallback** (using **respond.js** or **css3-mediaqueries.js**)

In case of javascript fallback, the best may be **respond.js**, in the following case:

*   Desktop support is a primary high concern;
*   You are querying only the width and height of the browser;
*   You don’t want to query the width by ems;
*   You have no problem with non-JavaScript users seeing an unoptimized page

In my opinion, this is a very frequent case!

CSS3-mediaqueries.js is indicated only if you have **particular conditions** to query (other than width and height), but it weights 15 freaking kilobytes!

So you should use respond.js and switch to css3-mediaqueries.js only if the first doesn't fit your needs.

That's it!