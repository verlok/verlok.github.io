---
layout: post
title: Changing text color for contrast based on background lightness
date: 2017-06-02 08:00:00:00 +01:00
categories:
- techniques
tags: [background-color, color, lightness, contrast]
---

If you had to change the color of some fixed-positioned text based on the lightness of its scrolling background, how would you do that? CSS filters, blend modes? But what if you had to support all browsers, including Internet Explorer? Here are a couple of ways to do that using CSS `clip` and `clip-path`.

Here's the result using `clip` - wide browser support

<iframe class="lazy" height='200' scrolling='no' title='Text color change at background using clip' data-src='//codepen.io/verlok/embed/VWZeBL/?height=194&amp;theme-id=light&amp;default-tab=result&amp;embed-version=2' frameborder='no' allowtransparency='true' allowfullscreen='true' style='width: 100%;'>See the Pen <a href='https://codepen.io/verlok/pen/VWZeBL/'>Text color change at background using clip</a> by Andrea Verlicchi (<a href='https://codepen.io/verlok'>@verlok</a>) on <a href='https://codepen.io'>CodePen</a>.
</iframe>

And here's the result using `clip-path` - modern browsers only

<iframe class="lazy" height='200' scrolling='no' title='Text color change at background using clip-path' data-src='//codepen.io/verlok/embed/owvYjx/?height=265&amp;theme-id=light&amp;default-tab=result&amp;embed-version=2' frameborder='no' allowtransparency='true' allowfullscreen='true' style='width: 100%;'>See the Pen <a href='https://codepen.io/verlok/pen/owvYjx/'>Text color change at background using clip-path</a> by Andrea Verlicchi (<a href='https://codepen.io/verlok'>@verlok</a>) on <a href='https://codepen.io'>CodePen</a>.
</iframe>

What happens here that the content is:

- wrapped by a box with class `clipper` which clips its content
- copied inside every container :(
- positioned with `position: fixed`

Being the content in position fixed, the content sticks to our browser window, but is't clipped by the moving clipping elements.

This solutions has 2 problems, though:

- there's a bug in IE and Edge which makes the content's block children invisible. It works with inline elements, though, but it's a hack
- we need to copy the content inside every container

Can you think of a better solution? If you do, please add it to the comments!