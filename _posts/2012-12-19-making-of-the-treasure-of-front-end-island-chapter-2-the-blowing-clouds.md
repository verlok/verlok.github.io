---
layout: post
title: Making of The Treasure of Front-end Island – Chapter 2 – The blowing clouds
date: 2012-12-19 03:20:52.000000000 +01:00
categories:
- works
tags:
- css 3
- css3 animations
- from the front
- front-end island
- making of
- psd to html
status: publish
type: post
published: true
---
Ahoy, front-end pirates! Welcome to the Chapter 2 of the [Making of The Secret of Front-end Island]({% post_url 2012-12-09-making-of-the-treasure-of-front-end-island %}) saga: **the Blowing Clouds**.

![](/assets/post-images/blowing_clouds1.jpg "The clouds sprite")

As I described [before]({% post_url 2012-12-09-making-of-the-treasure-of-front-end-island-chapter-1-the-splashing-title %} "Making of The Treasure of Front-end Island – Chapter 1 – The splashing title"), in the Photoshop layout I got from the designer ([Diego Sessa](http://www.linkedin.com/in/diegosessa "Diego")) I had the finished 1280 pixel wide layout, and I had the discretion of choosing animations, responsive behavior, and so on.

For the blowing clouds I decided to make a "blow left and right" effect using CSS 3 only. I also wanted the clouds to move at different speeds.

Here are the steps of what I did:

## The clouds sprite

I created a new empty, transparent image and copied the 4 clouds in it. After trimming the empty pixels, I saved it as transparent png (8 bit also in this case, instead of 24 bit, to save lots of kilobytes).

## Structure of the page

As explained in the [previous post]({% post_url 2012-12-09-making-of-the-treasure-of-front-end-island-chapter-1-the-splashing-title %} "Making of The Treasure of Front-end Island – Chapter 1 – The splashing title"), I divided the site into many `section`s:

*   **event**
*   speakers
*   description
*   city
*   venue
*   cart
*   and so on…

The **event** section contains the _From the Front_ logo, the _The Treasure of Frontend Island_ splash image, the event day, time and location, and the graphic of the island with the trees, the smoke, the sea, etc.

Then, I divided again the **event** section in 4 `div`:

*   ftfPresents
*   **treasure**
*   eventInfo
*   horizon

Inside the **treasure** `div` I placed:

*   **the clouds markup**
*   the splash image
*   the event summary
*   the event type

## The clouds markup

Here's the markup for the 4 clouds. I like to use semantic IDs and very short class names, when needed, to keep the html light.

{% highlight html %}
<div id="clouds">
    <span class="c1"></span>
    <span class="c2"></span>
    <span class="c3"></span>
    <span class="c4"></span>
</div>
{% endhighlight %}

## The clouds stylesheet portion

And here's the CSS that makes the sprite to split into pieces. As you see I use the span tag to apply the background image and the absolute position, and the classes c1, c2, c3 and c4 to offset it, size it and give it a z-index value.

Each cloud has a different z-index because some clouds are behind [the splashing title]({% post_url 2012-12-09-making-of-the-treasure-of-front-end-island-chapter-1-the-splashing-title %} "Making of The Treasure of Front-end Island – Chapter 1 – The splashing title"), some others are in front of it.

{% highlight css %}
/* Clouds */
#clouds span {
	background: url('../img/clouds.png') no-repeat top left;
	position: absolute;
}

#clouds .c1 {
	width: 206px; height: 89px;
	left: -75px; top: -38px;
	z-index: 3;
}

#clouds .c2 {
	background-position: -260px 0px;
	width: 270px; height: 102px;
	left: 590px; top: 206px;
	z-index: 8;
}

#clouds .c3 {
	background-position: 0px -99px;
	width: 255px; height: 81px;
	left: -95px; top: 278px;
	z-index: 3;
}

#clouds .c4 {
	background-position: -272px -114px;
	width: 129px; height: 56px;
	left: 504px; top: 463px;
	z-index: 12;
}
{% endhighlight %}

## The blowing animation

Let the wind blow! Here's how the animation is done. As you see, it's quite simple.

There are two types of clouds: A and B. The A type translates horizontally by only 50px, the B type translates by 100px. This makes the user to perceive some deepness of the sky.

So I wrote two keyframes definitions: cloudA and cloudB.

{% highlight css %}
/* Clouds animation keyframes */
@keyframes cloudA {
	0%   { transform: translate(0px) }
	100% { transform: translate(50px) }
}

@keyframes cloudB {
	0%   { transform: translate(0px) }
	100% { transform: translate(100px) }
}
{% endhighlight %}

To make the clouds move all together, I applied the keyframes to the elements giving it the same duration: 15 seconds. The animation goes back and forth infinite times using the easing function "ease-in-out", which makes the animation both start slow and end slow.

{% highlight css %}
/* Clouds animation appliance */
#clouds .c1,
#clouds .c4 {
	animation: cloudA 15s 0s infinite alternate ease-in-out;
}

#clouds .c2,
#clouds .c3 {
	animation: cloudB 15s 0s infinite alternate ease-in-out;
}
{% endhighlight %}

## Final result

See the final result on [2012.fromthefront.it](http://2012.fromthefront.it "From the Front 2012 conference site")

If you liked this explanation, please share this post!

## More to come!

Come back in the next few days to see the rest of the [Making of The Treasure of Front-end Island]({% post_url 2012-12-09-making-of-the-treasure-of-front-end-island %}) saga!