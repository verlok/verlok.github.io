---
layout: post
title: Making of The Treasure of Front-end Island – Chapter 3 – The rising smoke
date: 2013-01-12 22:43:47.000000000 +01:00
categories:
- works
tags:
- css only
- css3
- css3 animations
- from the front
- front-end island
- making of
- no-js
- psd to html
status: publish
type: post
published: true
---
Ahoy, front-end pirates! Welcome to the Chapter 3 of the [Making of The Secret of Front-end Island]({% post_url 2012-12-09-making-of-the-treasure-of-front-end-island %}) saga: **the Rising Smoke**.

![Front-end Island Rising Smoke](/assets/Front-end-Island-Rising-Smoke-709x237.png)

In the layout the smoke was composed by 5 gray circles at different opacity. Oh joy! I could avoid using images using markup and border-radius, and animate every smoke ball using CSS 3 only. Challenging, then funny. :)

## Structure of the page

As explained in the [previous post]({% post_url 2012-12-09-making-of-the-treasure-of-front-end-island-chapter-1-the-splashing-title %} "Making of The Treasure of Front-end Island – Chapter 1 – The splashing title"), I divided the site into many `section`s:

*   **event**
*   speakers
*   description
*   city
*   venue
*   cart
*   and so on…

The DOM path of the smoke parent element is the following:

`#event > #horizon > #smoke`

## The smoke markup

By the layout, 5 balls of smoke are visible at the same time. To make a beautiful animation, I decided to double them. Here's the markup for the 10 balls of smoke.

{% highlight html %}
<div id="smoke">
	<span class="s0"></span>
	<span class="s1"></span>
	<span class="s2"></span>
	<span class="s3"></span>
	<span class="s4"></span>
	<span class="s5"></span>
	<span class="s6"></span>
	<span class="s7"></span>
	<span class="s8"></span>
	<span class="s9"></span>
</div>
{% endhighlight %}

## The CSS 3 only animation

The smoke animation can perfectly be developed in CSS 3 only.

I used Modernizr to test whether the browser supports CSS 3 animations or not. Modernizr adds the `cssanimations` class if the browser supports animations, or the `no-cssanimations` if it doesn't.

The `disableAnimations` class is toggled when the user presses the "disable animations" button on the page (maybe to save battery life).

So here's the code:

{% highlight css %}
/* Smoke container */
#smoke {
	position: absolute;
	z-index: 3;
	width: 1px; height: 160px;
	left: 50%; bottom: 116px;
}

/* No animations or animations disabled? Display a static smoke image */
.disableAnimations #smoke,
.no-cssanimations #smoke {
	width: 86px;
	margin-left: -25px;
	bottom: 146px;
	background: url('../img/smokeNoAni.png') no-repeat center bottom;
}

/* smoke balls */
.cssanimations #smoke span {
	display: block;
	position: absolute;
	bottom: -35px; left: 50%; margin-left:-20px;
	height: 0px; width: 0px;
	border: 35px solid #4b4b4b;
	border-radius: 35px;
	left: -14px; opacity: 0;
	transform: scale(0.2);
}
{% endhighlight %}

Until now, the smoke container is positioned and all the smoke balls are positioned to its bottom and scaled to 20%.

And here's where the magic happens. I created two different animations, `smokeL` for the smoke balls which moved up and left, and `smokeR` for the smoke balls which moved up and right.

{% highlight css %}
@keyframes smokeL {
	0%   { transform:scale(0.2) translate(0, 0) }
	10%  { opacity: 1; transform: scale(0.2) translate(0, -5px) }
	100% { opacity: 0; transform: scale(1) translate(-20px, -130px) }
}

@keyframes smokeR {
	0%   { transform:scale(0.2) translate(0, 0) }
	10%  { opacity: 1; transform: scale(0.2) translate(0, -5px) }
	100% { opacity: 0; transform: scale(1) translate(20px, -130px) }
}
{% endhighlight %}

Then I applied this two animations alternately to each smoke ball, with a total duration of 10 seconds, and a delay of 1 second more each.

Here's how:

{% highlight css %}
#smoke .s0 { animation: smokeL 10s 0s infinite }
#smoke .s1 { animation: smokeR 10s 1s infinite }
#smoke .s2 { animation: smokeL 10s 2s infinite }
#smoke .s3 { animation: smokeR 10s 3s infinite }
#smoke .s4 { animation: smokeL 10s 4s infinite }
#smoke .s5 { animation: smokeR 10s 5s infinite }
#smoke .s6 { animation: smokeL 10s 6s infinite }
#smoke .s7 { animation: smokeR 10s 7s infinite }
#smoke .s8 { animation: smokeL 10s 8s infinite }
#smoke .s9 { animation: smokeR 10s 9s infinite }
{% endhighlight %}

And that's it! The smoke animation works perfectly on modern browsers!

Here's the result:

<iframe src="/examples/css3-only-smoke-animation.html" width="100%" height="250"></iframe>

If you liked this explanation, please share this post!

## More to come!

Come back in the next few days to see the rest of the [Making of The Treasure of Front-end Island]({% post_url 2012-12-09-making-of-the-treasure-of-front-end-island %}) saga!