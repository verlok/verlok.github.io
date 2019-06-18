---
layout: post
title: Critical CSS with Jekyll and SASS

date: 2019-06-17 23:00:00 +01:00
categories:
- techniques
tags: [critical css, jekyll, sass]
image: critical-css-jekyll-sass__2x.png
---

This site is run by **Jekyll on GitHub pages** and its CSS is built using SASS. Today I decided to boost performance even more inlining the render-blocking _critical_ CSS, but even searching the internet I struggled to find an easy way to do it. This post is for you, in case you want to do the same.

<img alt="Blurry but colored code :)" src="/assets/post-images/critical-css-jekyll-sass__ph.png" data-src="/assets/post-images/critical-css-jekyll-sass__1x.png" data-srcset="/assets/post-images/critical-css-jekyll-sass__1x.png 1x, /assets/post-images/critical-css-jekyll-sass__2x.png 2x" class="lazy post-image">

## The critical style

In the critical SASS file, use the SASS `@import` directive to include all the partials that have an impact on the layout of your page, plus your _variables_ and _mixins_ that might be required from the imported partials.

For instance, I import the `base` partial, containing the basic rules of the website like reset and typography, the `layout` partial that styles the header and layout of the page, the `posts_above` partial which styles the _above-the-fold_ part of the posts list and the post detail, and `utils` which contains some helper classes (e.g. `visuallyHidden`).

The `posts_above` partial was once a single file called `posts`, but I decided to split it in two separate files for further optimization. The other partial, names `posts_below`, contains information to style the post footer (the author section, the share button) so it's _not_ included here.

Create a `critical.scss` file inside the `includes` folder.

`includes/critical.scss`

```scss
// Import partials for critical css content
@import "variables", "mixins", "base", "layout", "posts_above", "pages", "utils";
```

IMPORTANT: Place this file in the `includes` folder! You'll need to include it in your HTML later.

## Stick it in your `head`

In the ``head`` HTML partial, inline the critical CSS inside a `style` tag. You can do that using the following Jekyll code, which is based on the Liquid template engine used in Jekyll.

``head.html``:

```liquid
{% raw %}
{% capture critical %}
  {% include minima_critical.scss %}
{% endcapture %}

{{ critical | scssify }} 
{% endraw %}
```

Also, it's a good idea to preload the `main` CSS file that you will use later in time:

```html
<link rel="preload" href="{{ '/assets/main.css' | relative_url }}" as="style">
```


## The rest of your stylesheet

If your website is simple enough, you can import the rest of your partials inside a single SCSS file, which you will load asynchronously using JavaScript.

I for instance imported there all the syntax highlighting style, the footer, the pagination style, the icons style, and also the iframes and tables styles, which are likely to appear _below-the-fold_ most of the times.

`assets/main.scss`

```scss
---
---

// Import partials for below-the-fold content
@import "variables", "mixins", "posts_below", "syntax-highlighting", "footer", "code", "pagination", "icons", "iframes", "tables";
```

**IMPORTANT**: The two lines with a triple dash at the beginning of the file are required by Jekyll to recognize and deploy the file as content.


## Load the rest of CSS using Javascript

`default.html`

Just before the closing `body` tag, load non critical CSS using JS:

```html
<!-- Non critical CSS -->
<script async>
  var href = "{{ '/assets/main.css' | relative_url }}";
  var link = document.createElement("link");
  link.setAttribute("rel", "stylesheet");
  link.setAttribute("href", href);
  document.documentElement.appendChild(link);
</script>
```

That's it! Easy and blazing fast.
