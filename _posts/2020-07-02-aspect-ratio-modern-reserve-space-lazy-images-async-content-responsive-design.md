---
layout: post
title: "aspect-ratio: A modern way to reserve space for images and async content in responsive design"
date: 2020-07-02 01:00:00 +02:00
categories:
  - techniques
tags: [aspect-ratio, responsive design, responsive-images, cumulative layout shift]
image: aspect-ratio__2x.png
---

To avoid **layout shifting** and optimize for the [Cumulative Layout Shift](https://web.dev/cls/) [web vital](https://web.dev/vitals/) in you web pages, you need to reserve space for any **content that might be rendered later in time**. This is the case for images, videos and any asynchonously loaded content (e.g with AJAX calls). Here's a new way to do it.

<figure>
  <div class="post-image-spacer" style="background-color: #eee">
    <img alt="Boxes of different aspect ratios and the text: &quot;A modern way to reserve space for lazy images and async content in responsive design&quot;" src="/assets/post-images/aspect-ratio__2x.png" srcset="/assets/post-images/aspect-ratio__1x.png 1x, /assets/post-images/aspect-ratio__2x.png 2x" class="post-image">
  </div>
</figure>

## The good old way

The traditional way to reserve space for images is to use the vertical padding trick.

```html
<div class="image-wrapper">
  <img
    alt="An image"
    src="image.jpg"
  />
</div>
```

```css
.image-wrapper {
  width: 100%;
  height: 0;
  padding-bottom: 150%;
  /* 👆 image height / width * 100% */
  position: relative;
}
.image {
  width: 100%;
  height: auto;
  position: absolute;
}
```

## The modern way - mapped

The modern and simpler way is to define a width / height aspect ratio implicitly by [defining the width and height attributes on images and videos](https://twitter.com/addyosmani/status/1276779799198007301). This is called "mapped aspect-ratio".

```html
<img
  alt="An image"
  src="image.jpg"
  width="200"
  height="300"
/>

<video
  alt="A video"
  src="video.mp4"
  width="1600"
  height="900"
>
  ...
</video>
```

```css
/* Modern browser stylesheets will add a default
  aspect ratio based on the element's existing 
  width and height attributes */
  img, video {
    aspect-ratio: attr(width) / attr(height);
  }
```

Firefox and Chromium browsers (Chrome, MS Egde, Opera) have already shipped this feature. Mapped aspect-ratio is not supported by Safari yet, but it will be [supported in Safari 14](https://twitter.com/jensimmons/status/1275171897244823553) later in 2020. 

I've created a [3 images with native lazy-loading](https://codepen.io/verlok/pen/ExPwzGO) pen. Note how the paragraph is rendered _below the images_ even before the images start loading.

### JS lazy-loaded images without placeholder are not supported

Unfortunately, this is not working for images lazy-loaded using Javascript. I've created a [3 images with JavaScript lazy-loading](https://codepen.io/verlok/pen/bGEYyZe). Note that the `width` and `height` attributes have no effect. This is probably because the `src`/`srcset` attributes are both missing.

### JS lazy-loaded images with placeholder works!

Using a placeholder image in the `src` attribute makes the mapped `aspect-ratio` work. I've created a [3 images with JavaScript lazy-loading and an SVG placeholder image](https://codepen.io/verlok/pen/zYNmoxz). You can see that the `width` and `height` work to reserve space even before the placeholder image is loaded. To check this out, you can use your browser's developer tool to disable cache and simulate a very slow connection like "slod 3G".

## The modern way - explicit

In the near future, you will also be able to explicitly set the aspect ratio in your CSS code using [the aspect-ratio CSS rule](https://developer.mozilla.org/en-US/docs/Web/CSS/aspect-ratio).

```html
<div
  class="async"
>
  Content is loading...
</div>
```

```css
.async {
  aspect-ratio: 16/9;
}
```

This is experimental and it has currently (July 2nd, 2020) only [shipped to Chrome Canary](  https://twitter.com/una/status/1260980901934137345). We still don't know if this will be supported in Safari 14, which announced support [only for mapped values](https://twitter.com/jensimmons/status/1275171897244823553).


## Conclusion

Will we be able to ditch the vertical padding trick in favor of mapped or explicitly set `aspect-ratio` CSS rule? 

It depends on what Safari 14 will ship and on how quickly Internet Explorer 11 will disappear from the market share. 

I'm not that optimistic but... Fingers crossed, developers! 🤞
