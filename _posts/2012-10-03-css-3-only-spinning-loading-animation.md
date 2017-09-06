---
layout: post
title: CSS 3 only spinning "loading" animation
date: 2012-10-03 23:25:03.000000000 +02:00
categories:
- tips-and-tricks
tags:
- animations
- css only
- css3
- ie10
- loading
- preloader
- spinner
status: publish
type: post
published: true
---
We used GIF images to create animations for years, but they aren't pretty to be used over gradients or pictures (no alpha channel, no anti-aliasing) of which modern web sites are full. There are many workarounds to animate PNG images instead, but...

![](/assets/post-images/preloader_preview1.png "preloader_preview")

I want to show you a solution I found to create a "loading" animation from scratch, using only CSS 3, without images.

## Results first

<p data-height="265" data-theme-id="0" data-slug-hash="bWmvON" data-default-tab="css,result" data-user="verlok" data-embed-version="2" data-pen-title="CSS 3 only spinning circle quarter - loading animation" class="codepen">See the Pen <a href="https://codepen.io/verlok/pen/bWmvON/">CSS 3 only spinning circle quarter - loading animation</a> by Andrea Verlicchi (<a href="https://codepen.io/verlok">@verlok</a>) on <a href="https://codepen.io">CodePen</a>.</p>
<script async src="https://production-assets.codepen.io/assets/embed/ei.js"></script>

## What happens here

The core of this is to draw a quarter of circle and animate it. 
Read on to know the bottom-up steps to do it.

## 1. Create a circle

```html
<!-- Inner masked circle -->
<div class="maskedCircle"></div>
```

```css
/* Spinning circle (inner circle) */
.loading .maskedCircle {
	width: 20px;
	height: 20px;
	border-radius: 12px;
	border: 3px solid white;
}
```

## 2. Mask one quarter of the circle

```html
<!-- Mask of the quarter of circle -->
<div class="mask">
    <!-- Inner masked circle -->
    <div class="maskedCircle"></div>
</div>
```

```css
/* Spinning circle mask */
.loading .mask {
	width: 12px;
	height: 12px;
	overflow: hidden;
}
```

## 3. Make both spin around

```html
<!-- We make this div spin -->
<div class="spinner">
	<!-- Mask of the quarter of circle -->
	<div class="mask">
		<!-- Inner masked circle -->
		<div class="maskedCircle"></div>
	</div>
</div>
```

```css
/* Animation keyframes */
@keyframes spin {
	from { transform: rotate(0deg); }
	to { transform: rotate(360deg); }
}

/* Spinner */
.loading .spinner {
	position: absolute;
	left: 1px;
	top: 1px;
	width: 26px;
	height: 26px;
	animation: spin 1s infinite linear;
}
```

## 4. Wrap everything in a "loading" container, that will be centered inside its parent

```html
<!-- Loading animation container -->
<div class="loading">
	<!-- We make this div spin -->
	<div class="spinner">
		<!-- Mask of the quarter of circle -->
		<div class="mask">
			<!-- Inner masked circle -->
			<div class="maskedCircle"></div>
		</div>
	</div>
</div>
```

```css
/* Loading animation container */
.loading {
	position: absolute;
	top: 50%;
	left: 50%;
	width: 28px;
	height: 28px;
	margin: -14px 0 0 -14px;
}
```

## Resulting HTML and CSS code:

```html
<!-- Loading animation container -->
<div class="loading">
	<!-- We make this div spin -->
	<div class="spinner">
		<!-- Mask of the quarter of circle -->
		<div class="mask">
			<!-- Inner masked circle -->
			<div class="maskedCircle"></div>
		</div>
	</div>
</div>
```

```css
/* Animation keyframes - you need to add prefixes */
@keyframes spin {
	from { transform: rotate(0deg); }
	to { transform: rotate(360deg); }
}

/* Loading animation container */
.loading {
	position: absolute;
	top: 50%;
	left: 50%;
	width: 28px;
	height: 28px;
	margin: -14px 0 0 -14px;
}

/* Spinning circle (inner circle) */
.loading .maskedCircle {
	width: 20px;
	height: 20px;
	border-radius: 12px;
	border: 3px solid white;
}

/* Spinning circle mask */
.loading .mask {
	width: 12px;
	height: 12px;
	overflow: hidden;
}

/* Spinner */
.loading .spinner {
	position: absolute;
	left: 1px;
	top: 1px;
	width: 26px;
	height: 26px;
	animation: spin 1s infinite linear;
}
```

Isn't that cool? 

It works perfectly on all desktop browsers like:

* Internet Explorer 10+
* Edge
* Chrome
* Firefox
* Safari
* Opera

and also for all major mobile browsers:

* Safari Mobile
* Chrome Mobile
* Firefox Mobile
* Opera Mobile
* Internet Explorer Mobile (Windows Phone 8 only)

At the moment, Windows Phone 7's Internet Explorer won't animate the figure.

## The fallbacks?

Need a fallback to see the animation in older browsers? If you read so far, you probably do.

Although the fallback is not the purpose of this article, let's say that the best solution would be preparing **a sprite with all the frames** of the animation at a constant distance one from each other, use the sprite as background of a DOM element, and **animate the background with Javascript**.