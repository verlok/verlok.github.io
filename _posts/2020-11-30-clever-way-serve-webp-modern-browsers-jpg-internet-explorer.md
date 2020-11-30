---
layout: post
title: A clever way to serve WebP images to modern browsers and JPG to IE
date: 2020-11-29 23:00:00 +02:00
categories:
    - techniques
tags: [performance, images]
image: clever-way-webp-modern-jpg-ie__2x.jpg
---

Before the day Safari started support WebP images, we were forced to use the `picture` tag to serve WebP images to browsers supporting it. Today all modern browsers support WebP, so there's probably a clever way to do that using a single tag: `img`.

<figure>
  <div class="post-image-spacer" style="background-color: #1e1e1e">
    <img alt="A clever way to serve WebP images to modern browsers only" src="/assets/post-images/clever-way-webp-modern-jpg-ie/clever-way-webp-modern-jpg-ie__2x.jpg" srcset="/assets/post-images/clever-way-webp-modern-jpg-ie/clever-way-webp-modern-jpg-ie__1x.webp 1x, /assets/post-images/clever-way-webp-modern-jpg-ie/clever-way-webp-modern-jpg-ie__2x.webp 2x" class="post-image">
  </div>
  <figcaption>A clever way to serve WebP images to modern browsers only</figcaption>
</figure>


## How we did it before

The old way to do that was using a `picture` tag containing the regular `img` tag with both `src` and `srcset` attributes for browsers not supporting WebP, and a sibling `source` tag - marked with the `type="image/webp"` - containing the `srcset` for browsers accepting the WebP image format.

Long story short, this:

```html
<picture>
    <source
        type="image/webp"
        srcset="
            {url-standard}.webp 1x,
            {url-retina}.webp   2x
        "
    />
    <img
        alt="Old way"
        src="{url-standard}.jpg"
        srcset="
            {url-standard}.jpg 1x,
            {url-retina}.jpg   2x
        "
    />
</picture>
```

## But Safari is more modern now

Now that all modern browsers support WebP, we can assume that all browsers that support the `srcset` attribute also support WebP. So we can get rid of the `picture` tag and use a single `img` tag.

Like this:

```html
<img
    alt="New, clever way"
    src="{url-standard}.jpg"
    srcset="
        {url-standard}.webp 1x,
        {url-retina}.webp   2x
    "
/>
```

Legacy browsers fallback to the `src` attribute, and they get the Jpg image. Simple as that.


## Compatibility

If you're supporting versions of iOS older than 14, you probably want to continue using the `picture` tag to to so. This depends on the audience you're targeting. Find more about your audience using Google Analytics data.


## Demo?

Here you go! The top image of this blog post has been loaded with the technique I'm explaining here. Check it out on your browser inspector!