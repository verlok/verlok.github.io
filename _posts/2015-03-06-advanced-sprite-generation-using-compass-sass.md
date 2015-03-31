---
layout: post
title: Advanced sprite generation using Compass (SASS)
date: 2015-03-06 08:17:21 +01:00
categories:
- development
tags: [spriting, sprite generation, compass, mixins]
---
Spriting is a way to improve performance in your website by putting many images (or icons) in a single larger image, in order to make a single HTTP request instead of many. Here's how you can do sprites using Compass.

## The simple way

The simpler way to create a sprite with Compass requires you to import a folder of images in your project, then generate a class for each sprite. You can do that by using the following code:

{% highlight sass %}
// Required Compass tool import
@import "compass/utilities/sprites";
// Importing all the png images under the flags folder
@import "flags/*.png";
// Generate a CSS class for each sprite
@include all-flags-sprites
{% endhighlight %}

Example of CSS output:

{% highlight css %}
.flags-it,
.flags-de,
.flags-fr { 
  background: url('/images/flags-s34fe0604ab.png') no-repeat; }

.flags-it { background-position: 0 0; }
.flags-de { background-position: 0 -32px; }
.flags-fr { background-position: 0 -64px; }
{% endhighlight %}

This can be enough for your needs... but you want more, don't you?

## The advanced way

Skipping all the others way you can do sprites generation with Compass, I found out that if you have to do the following:

*   Generate dimensions of the box equals to the sprite ones
*   Use an offset inside the box
*   Spacing sprites inside the sprite map
*   Manage 1x, 2x, 3x density displays
*   Optimize sprite generation time

The only way to do spriting with Compass is to create your own mixins which use Compass base mixins under the hood.

### Images and folders structure

To have the images in single density, double density and maybe triple density, we need to provide the images in 1x, 2x and maybe 3x size.

So, supposing you will create a sprite map containing **flags**, you can have the following folders under our images folder:

* flagsSprite1x - _flags images @ single density_
    * france.png
    * germany.png
    * italy.png
    * ...
* flagsSprite2x - _flags images @ double density_
    * france.png
    * germany.png
    * italy.png
    * ...
* flagsSprite3x - _...triple density_
    * ...

And if we're were going to create also an **icons** sprite map, we'd have to create the folders:

* iconsSprite1x 
    * ...
* iconsSprite2x
    * ...
* iconsSprite3x
    * ...

Now let's take a look at the SASS partials you should create.

### SASS partials

To guarantee the maximum flexibility and the smallest build time, I suggest you to use the following:

* _variables.scss - all your variables
* _mixins.scss - all your mixins
* one partial file for set of images
    * _flagsSprite.scss - flags
    * _iconsSprite.scss - icons
    * ...

Let's see what to put in our partials, one by one.

### _mixins.scss

Here's some mixins you might want to include in your mixins file. You can find the explanation of what they do right in the code comments.

{% highlight scss %}
/* 
Makes possible to use a n-ple density sprite
Automatically adapts background-size and offset when $multiplier is greater than 1
Allows you to use automatic size generation, which is automatically adapted when $multiplier is greater than 1

Required parameters:
- $sprite - the sprite name
- $spriteMap - the spriteMap variable
- $spriteUrl - the sprite map url of the sprite

Optional parameters:
- $multiplier (1) - the sprite density (1 for single density, 2 for retina, 3, etc.)
- $renderSize (false) - tells the mixin to render width and height of the box containing the sprite
- $offsetX (0) - the horizontal offset (px) for the image in the box
- $offsetY (0) - the vertical offset (px) for the image in the box
*/
@mixin useNxSprite($sprite, $spriteMap, $spriteUrl, $multiplier: 1, $renderSize: false, $offsetX: 0, $offsetY: 0) {
  $spritePosition: sprite-position($spriteMap, $sprite, $offsetX * $multiplier, $offsetY * $multiplier);
  background: transparent $spriteUrl no-repeat nth($spritePosition, 1) / $multiplier nth($spritePosition, 2) / $multiplier;
  @if ($multiplier > 1) {
    background-size: (image-width(sprite-path($spriteMap)) / $multiplier) (image-height(sprite-path($spriteMap)) / $multiplier);
  }
  @if ($renderSize) {
    height: image-height(sprite-file($spriteMap, $sprite)) / $multiplier;
    width: image-width(sprite-file($spriteMap, $sprite)) / $multiplier;
  }
}

/*
Utility mixin to use single and double density sprite, with double density media query included

Required parameters:
- $sprite - the sprite name
- $sprite1xMap - the spriteMap variable for the 1x sprites
- $sprite2xMap - the spriteMap variable for the 2x sprites
- $sprite1xUrl - the sprite map url of the 1x sprites
- $sprite2xUrl - the sprite map url of the 2x sprites

Optional parameters:
- $renderSize (false) - tells the mixin to render width and height of the box containing the sprite
- $offsetX (0) - the horizontal offset (px) for the image in the box
- $offsetY (0) - the vertical offset (px) for the image in the box
*/
@mixin use1x2xSprite($sprite, $sprite1xMap, $sprite2xMap, $sprite1xUrl, $sprite2xUrl, $renderSize: false, $offsetX: 0, $offsetY: 0) {
  @include useNxSprite($sprite, $sprite1xMap, $sprite1xUrl, 1, $renderSize, $offsetX, $offsetY);
  @media (-webkit-min-device-pixel-ratio: 1.5), (min-resolution: 144dpi) {
    @include useNxSprite($sprite, $sprite2xMap, $sprite2xUrl, 2, $renderSize, $offsetX, $offsetY);
  }
}
{% endhighlight %}

### _variables.scss

This is the file where you define all the variables for your site, that you're going to use across all your scss files.

Here you should define the spacing between sprites in sprite map images.

{% highlight scss %}
// Generic spacing (at 1x) for sprites
$spacing-sprites-generic: 10px;
{% endhighlight %}

### _flagsSprite.scss

This is the file where you define the variables and the mixins for your flag sprites.

I suggest to `@import` your `_flagsSprite.scss` only in files that requires flag sprites. This **speeds up build time** a lot, by avoiding frequent images check on the file system.

{% highlight scss %}
// flagsSprite MAPS and URLS
$flagsSprite1xMap: sprite-map("flagsSprite1x/*.png", $spacing: $spacing-sprites-generic);
$flagsSprite2xMap: sprite-map("flagsSprite2x/*.png", $spacing: $spacing-sprites-generic * 2);
$flagsSprite1xUrl: sprite-url($flagsSprite1xMap);
$flagsSprite2xUrl: sprite-url($flagsSprite2xMap);

// flagsSprite mixin
@mixin flagsSprite($spriteName, $renderSize: false, $offsetX: 0, $offsetY: 0) {
    @include use1x2xSprite($spriteName, $flagsSprite1xMap, $flagsSprite2xMap, $flagsSprite1xUrl, $flagsSprite2xUrl, $renderSize, $offsetX, $offsetY);
}
{% endhighlight %}

### style.scss - standard usage

If you don't need space around your sprite and you don't want Compass to generate box dimensions for you, you can simply do the following.

{% highlight scss %}
@import "compass/utilities/sprites";
@import "_variables";
@import "_flagsSprite";

// Simple usage
.exampleSimple {
    @include flagsSprite(italy);
}
{% endhighlight %}

That will produce the following:

{% highlight css %}
.exampleSimple {
  background: transparent url('../img/flagsSprite1x-s479625030c.png') no-repeat 0 -882px;
}
@media (-webkit-min-device-pixel-ratio: 1.5), (min-resolution: 144dpi) {
  .exampleSimple {
    background: transparent url('../img/flagsSprite2x-s9a855cf705.png') no-repeat 0 -882px;
    background-size: 32px 2048px;
  }
}
{% endhighlight %}

### style.scss - with box size generation

If you want Compass to generate box dimensions for you, you should do the following.

{% highlight scss %}
@import "compass/utilities/sprites";
@import "_variables";
@import "_flagsSprite";

.exampleWithDimensions {
    @include flagsSprite(italy, true);
}
{% endhighlight %}

That will produce the following:

{% highlight css %}
.exampleWithDimensions {
  background: transparent url('../img/flagsSprite1x-s479625030c.png') no-repeat 0 -882px;
  height: 32px;
  width: 32px;
}
@media (-webkit-min-device-pixel-ratio: 1.5), (min-resolution: 144dpi) {
  .exampleWithDimensions {
    background: transparent url('../img/flagsSprite2x-s9a855cf705.png') no-repeat 0 -882px;
    background-size: 32px 2048px;
    height: 32px;
    width: 32px;
  }
}
{% endhighlight %}

### style.scss - with offset management

If you don't want Compass to generate box dimensions for you, but you want to use an offset inside the box, you should do the following.

{% highlight scss %}
@import "compass/utilities/sprites";
@import "_variables";
@import "_flagsSprite";

.exampleWithPadding {
    @include flagsSprite(italy, false, 10, 10);
    width: 52px; height: 52px;
}
{% endhighlight %}

That will produce the following:

{% highlight css %}
.exampleWithPadding {
  background: transparent url('../img/flagsSprite1x-s479625030c.png') no-repeat 10px -872px;
  width: 52px;
  height: 52px;
}
@media (-webkit-min-device-pixel-ratio: 1.5), (min-resolution: 144dpi) {
  .exampleWithPadding {
    background: transparent url('../img/flagsSprite2x-s9a855cf705.png') no-repeat 10px -872px;
    background-size: 32px 2048px;
  }
}
{% endhighlight %}

## That's it

Automatic sprite generation using Compass considering all the factors can be quite complex, but if you follow this guide it will be easy and also easier to maintain.

You you found any issues with this post, please [tweet me](https://twitter.com/verlok) and I'll fix it.