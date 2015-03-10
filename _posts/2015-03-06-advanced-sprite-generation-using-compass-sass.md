---
layout: post
title: Advanced sprite generation using Compass (SASS)
date: 2015-03-06 08:17:21 +01:00
categories:
- development
tags: [spriting, sprite generation, compass, mixins]
---
Spriting is a way to improve performance in your website by putting many images (or icons) in a single larger image, in order to make a single HTTP request instead of many. You could manually create the sprite map (the single larger image) using your favorite image editor and cutting it in CSS, or you can create sprite maps using Compass.

## Creating sprites with Compass

### The simple way

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

### The "considering pixel density + spacing between sprites + size generating + offset managing" way

Skipping all the others way you can do sprites generation with Compass, I found out that if you have to do the following:

*   Generate dimensions of the box equals to the sprite ones
*   Use an offset inside the box
*   Spacing sprites inside the sprite map
*   Manage 1x, 2x, 3x density displays
*   Optimize sprite generation time

The only way to do spriting with Compass is to create your own mixins which use Compass base mixins under the hood.

### _mixins.scss

I created the following mixins, that I usually put in a separate _mixins.scss partial.

{% highlight scss %}
// N-ple density sprite
@mixin useNxSprite($sprite, $spriteMap, $spriteUrl, /* OPTIONAL PARAMETERS -> */ $multiplier: 1, $renderSize: false, $offsetX: 0, $offsetY: 0) {
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

// Single and double density sprite
@mixin use1x2xSprite($sprite, $sprite1xMap, $sprite2xMap, $sprite1xUrl, $sprite2xUrl, /* OPTIONAL PARAMETERS -> */ $renderSize: false, $offsetX: 0, $offsetY: 0) {
  @include useNxSprite($sprite, $sprite1xMap, $sprite1xUrl, 1, $renderSize, $offsetX, $offsetY);
  @media (-webkit-min-device-pixel-ratio: 1.5), (min-resolution: 144dpi) {
    @include useNxSprite($sprite, $sprite2xMap, $sprite2xUrl, 2, $renderSize, $offsetX, $offsetY);
  }
}
{% endhighlight %}

### _variables.scss

This is the file where you define all the variables for your site, that you're going to use across all your scss files.

In your _variables.scss file you should define the spacing between sprites in sprite map images.

{% highlight scss %}
// Generic spacing (at 1x) for sprites
$spacing-sprites-generic: 10px;
{% endhighlight %}

### _flagSprites.scss

This is the file where you define the variables and the mixins for your sprites.

I suggest to use a _sprites.scss partial different from you _variables.scss, and to @import _sprites.scss only in scss files that requires sprites. This speeds up build time a lot, by avoiding frequent images check on the file system.

{% highlight scss %}
// FlagSprites MAPS and URLS
$flagSprites1xMap: sprite-map("flagSprites1x/*.png", $spacing: $spacing-sprites-generic);
$flagSprites2xMap: sprite-map("flagSprites2x/*.png", $spacing: $spacing-sprites-generic * 2);
$flagSprites1xUrl: sprite-url($flagSprites1xMap);
$flagSprites2xUrl: sprite-url($flagSprites2xMap);

// FlagSprites mixin
@mixin flagSprites($spriteName, $renderSize: false, $offsetX: 0, $offsetY: 0) {
    @include use1x2xSprite($spriteName, $flagSprites1xMap, $flagSprites2xMap, $flagSprites1xUrl, $flagSprites2xUrl, $renderSize, $offsetX, $offsetY);
}
{% endhighlight %}

### final_file.scss

In your final scss file you can use the sprite doing the following:

#### Simple usage

If you don't need space around your sprite and you don't want Compass to generate box dimensions for you, you can simply do the following.

{% highlight scss %}
@import "compass/utilities/sprites";
@import "_variables";
@import "_flagSprites";

// Simple usage
.exampleSimple {
    @include flagSprites(Italy);
}
{% endhighlight %}

That will produce the following:

{% highlight css %}
.exampleSimple {
  background: transparent url('../img/flagSprites1x-s479625030c.png') no-repeat 0 -882px;
}
@media (-webkit-min-device-pixel-ratio: 1.5), (min-resolution: 144dpi) {
  .exampleSimple {
    background: transparent url('../img/flagSprites2x-s9a855cf705.png') no-repeat 0 -882px;
    background-size: 32px 2048px;
  }
}
{% endhighlight %}

#### With box size generation

If you want Compass to generate box dimensions for you, you should do the following.

{% highlight scss %}
@import "compass/utilities/sprites";
@import "_variables";
@import "_flagSprites";

.exampleWithDimensions {
    @include flagSprites(Italy, true);
}
{% endhighlight %}

That will produce the following:

{% highlight css %}
.exampleWithDimensions {
  background: transparent url('../img/flagSprites1x-s479625030c.png') no-repeat 0 -882px;
  height: 32px;
  width: 32px;
}
@media (-webkit-min-device-pixel-ratio: 1.5), (min-resolution: 144dpi) {
  .exampleWithDimensions {
    background: transparent url('../img/flagSprites2x-s9a855cf705.png') no-repeat 0 -882px;
    background-size: 32px 2048px;
    height: 32px;
    width: 32px;
  }
}
{% endhighlight %}

#### With box size generation

If you don't want Compass to generate box dimensions for you, but you want to use an offset inside the box, you should do the following.

{% highlight scss %}
@import "compass/utilities/sprites";
@import "_variables";
@import "_flagSprites";

.exampleWithPadding {
    @include flagSprites(Italy, false, 10, 10);
    width: 52px; height: 52px;
}
{% endhighlight %}

That will produce the following:

{% highlight css %}
.exampleWithPadding {
  background: transparent url('../img/flagSprites1x-s479625030c.png') no-repeat 10px -872px;
  width: 52px;
  height: 52px;
}
@media (-webkit-min-device-pixel-ratio: 1.5), (min-resolution: 144dpi) {
  .exampleWithPadding {
    background: transparent url('../img/flagSprites2x-s9a855cf705.png') no-repeat 10px -872px;
    background-size: 32px 2048px;
  }
}
{% endhighlight %}