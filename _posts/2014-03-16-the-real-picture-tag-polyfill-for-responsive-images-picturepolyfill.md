---
layout: post
title: 'The real picture tag polyfill for responsive images: picturePolyfill'
date: 2014-03-16 02:30:33.000000000 +01:00
categories:
- development
tags: []
status: publish
type: post
published: true
---
Today I released version 2 of picturePolyfill, the real `picture` element polyfill.

![Responsive Images](/assets/post-images/responsive_images.jpg)

The great news about version 2 of [PicturePolyfill](https://github.com/verlok/picturePolyfill "picturePolyfill repo") is that it supports the real `picture` tag, and it gives you the ability to create responsive images TODAY.

To have responsive images, include the picturePolyfill.min.js script in your page and mark up your images as you see below.

## The markup

### To support HD (Retina) displays

{% highlight html %}
<picture data-alt="A beautiful responsive image" data-default-src="img/1440x1440.gif">
    <source srcset="img/480x480.gif,   img/480x480x2.gif 2x"/>
    <source srcset="img/768x768.gif,   img/768x768x2.gif 2x"   media="(min-width: 481px)"/>
    <source srcset="img/1440x1440.gif, img/1440x1440x2.gif 2x" media="(min-width: 1025px)"/>
    <source srcset="img/1920x1920.gif, img/1920x1920x2.gif 2x" media="(min-width: 1441px)"/>
    <noscript>
        <img src="img/768x768.gif" alt="A beautiful responsive image"/>
    </noscript>
</picture>
{% endhighlight %}

### To support only standard resolution displays

{% highlight html %}
<picture data-alt="A beautiful responsive image" data-default-src="img/1440x1440.gif">
    <source srcset="img/480x480.gif"/>
    <source srcset="img/768x768.gif"   media="(min-width: 481px)"/>
    <source srcset="img/1440x1440.gif" media="(min-width: 1025px)"/>
    <source srcset="img/1920x1920.gif" media="(min-width: 1441px)"/>
    <noscript>
        <img src="img/768x768.gif" alt="A beautiful responsive image"/>
    </noscript>
</picture>
{% endhighlight %}

### If you have an image server for automated scaling

{% highlight html %}
<picture data-alt="A beautiful responsive image" data-default-src="http://demo.api.pixtulate.com/demo/large-2.jpg?w=1440">
    <source srcset="http://demo.api.pixtulate.com/demo/large-2.jpg?w=480"/>
    <source srcset="http://demo.api.pixtulate.com/demo/large-2.jpg?w=512" media="(min-width: 481px)"/>
    <source srcset="http://demo.api.pixtulate.com/demo/large-2.jpg?w=720" media="(min-width: 1025px)"/>
    <source srcset="http://demo.api.pixtulate.com/demo/large-2.jpg?w=960" media="(min-width: 1441px)"/>
    <noscript>
        <img src="http://demo.api.pixtulate.com/demo/large-2.jpg?w=1440" alt="A beautiful responsive image"/>
    </noscript>
</picture>
{% endhighlight %}

## Demo

Here's the [picturePolyfill demo](http://verlok.github.io/picturePolyfill/ "picturePolyfill demo - responsive images with support to HD (retina) display") on GitHub.io

## More info

I encourage you to look at the clean, self-explaining [javascript code of picturePolyfill](https://github.com/verlok/picturePolyfill/blob/master/picturePolyfill.js).

To know more about the script and about the script, read the [picturePolyfill project page](https://github.com/verlok/picturePolyfill "picturePolyfill") on GitHub.

Please drop a comment to tell me what you think about the script.