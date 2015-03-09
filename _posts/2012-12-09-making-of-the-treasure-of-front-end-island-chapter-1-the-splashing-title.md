---
layout: post
title: Making of The Treasure of Front-end Island - Chapter 1 - The splashing title
date: 2012-12-09 22:30:41.000000000 +01:00
categories:
- works
tags:
- css 3
- css3 animations
- from the front
- front-end island
- psd to html
status: publish
type: post
published: true
---
Ahoy, front-end pirates!

Welcome to the Chapter 1 of the [Making of The Secret of Front-end Island](http://www.andreaverlicchi.eu/making-of-the-secret-of-front-end-island-chapter-1-splashing-title/) saga: **the Splashing Title**.

![](/assets/logo_tofel.jpg "Splash image: the Treasure of Frontend Island")

Let's start saying that in the Photoshop layout I got from the designer ([Diego Sessa](http://www.linkedin.com/in/diegosessa "Diego")) I had the finished 1280 pixel wide layout, and I had the discretion of choosing animations, responsive behavior, and so on.

For the splash image I decided to make a "splash" effect using CSS 3 only. So the image had to start small, become bigger than it had to become, bounce back a little, and finally become of the final size. It also had to be shown of the final size in browsers that don't support CSS 3 transitions.

Here are the steps of what I did:

## Exporting the image

I duplicated the layer containing the splash image "The Treasure of Frontend Island" in a new image, trimmed the empty pixels, and saved it as transparent png (8 bit in this case, not 24, to have a lighter file).

## Structure of the page

I divided the site into many `sections`:

*   **event**
*   speakers
*   description
*   city
*   venue
*   cart
*   and so on...

The **event** section contains the _From the Front_ logo, the _The Treasure of Frontend Island_ splash image, the event day, time and location, and the graphic of the island with the trees, the smoke, the sea, etc.

Then, I divided again the **event** section in 4 `div`:

*   ftfPresents
*   **treasure**
*   eventInfo
*   horizon

Inside the **treasure** `div` I placed:

*   the clouds markup
*   **the splash image **
*   the event summary
*   the event type

## The image

The splash image is now inside #event > #treasure > img.

{% highlight css %}
#treasure img {
	z-index: 5;
	position: relative;
	width: 100%;
	max-width: 668px;
	height: auto;
}
{% endhighlight %}

This places the image at z-index 5 (in front of some clouds, on the back of some others), makes it wide the full page up to 668px (the image original width), and makes the height automatically scale based on the image original ratio.

## The splash animation

To define a CSS animation, you have to use the @keyframes directive and give the animation a name and some keyframes statuses. For more info about this, see my post [CSS 3 Transitions and Animation](http://www.andreaverlicchi.eu/css-3-transitions-and-animation-graceful-degradation-with-jquery/ "CSS 3 Transitions and Animation + graceful degradation with jQuery").

{% highlight css %}
@keyframes splash {
	0%   { transform : scale(0.1)}
	50%  { transform : scale(1.1); animation-timing-function: ease-in }
	75%  { transform : scale(0.9); animation-timing-function: ease-in-out }
	100% { transform : scale(  1); animation-timing-function: ease-in-out }
}
{% endhighlight %}

## Image starting size + animation application

I wanted the starting size of the image to be:

*   10% of the full image size if the browser supports CSS animations
*   full size if the browser doesn't support CSS animations

To test browser features, I always use the powerful [Modernizr](http://modernizr.com "Modernizr web site"), which as result it adds classes to the &lt;html&gt; element with the result of the tested features.

As a result, the html element can have `.cssanimations` or `.no-cssanimations` depending on the browser support to CSS animations.

So I used the following piece of CSS to apply the animation.

{% highlight css %}
#treasure img {
	/* Initial frame status */
	transform: scale(0.1);
}

.cssanimations #treasure img {
	/* Animation */
	animation: splash 1s 0.2s forwards;
}

.no-cssanimations #treasure img {
	/* Final frame status */
	transform: scale(1);
}
{% endhighlight %}

Like that:

*   by CSS definition, the splash image is initially resized ad 10% of its size
*   when the Javascript code of Modernizr is executed (and the classes added to the html element):
    *   if CSS 3 animations are supported, the "splash" animation is applied
    *   if not, the image is scaled to its original size

## Final result

See the final result on [2012.fromthefront.it](http://2012.fromthefront.it "From the Front 2012 conference site")

If you liked this explanation, please share this post!

## More to come!

Come back in the next few days to see the rest of the [Making of The Treasure of Front-end Island](http://www.andreaverlicchi.eu/making-of-the-treasure-of-front-end-island/) saga!