---
layout: post
title: Critical CSS with Jekyll and SASS on GitHub pages

date: 2019-06-17 23:00:00 +01:00
categories:
- techniques
tags: [critical css, jekyll, sass]
image: critical-css-jekyll-sass-github-pages__2x.png
---

This site is run by Jekyll on GitHub pages and its CSS is build using SASS. Today I decided to boost performance even more inlining the render-blocking "critical" CSS, but I struggled to find an easy way to do it. Here's how I did it.

<img alt="Blurry but colored code :)" src="/assets/post-images/critical-css-jekyll-sass-github-pages__ph.png" data-src="/assets/post-images/critical-css-jekyll-sass-github-pages__1x.png" data-srcset="/assets/post-images/critical-css-jekyll-sass-github-pages__1x.png 1x, /assets/post-images/critical-css-jekyll-sass-github-pages__2x.png 2x" class="lazy post-image">

## The critical style

In the critical SASS file, use the SASS `@import` directive to include all the partials that have impact on the layout of your page, plus your _variables_ and _mixins_ that might be required from the imported partials.

For instance, I import `base` (the base of the website, including reset and other typography rules), `layout` that styles the header and layout of the page, `posts_above` which styles the above-the-fold part of the posts list and post detail, and `utils` with their helper classes (e.g. `visuallyHidden`).

The `posts_above` file was once a single file called `posts`, but I decided to split it in two separate files for further optimization. The `posts_below` contains information to style the post footer, the author section, the share button, etc.

Create a `critical.scss` file inside the `includes` folder.

`includes/critical.scss`

```scss
// Import partials for critical css content
@import "variables", "mixins", "base", "layout", "posts_above", "pages", "utils";
```

IMPORTANT: Place this file in the `includes` folder! You'll need to include it in your HTML later.

## The rest of your stylesheet

...

`assets/main.scss`

```scss
---
---

// Import partials for below-the-fold content
@import "variables", "mixins", "posts_below", "syntax-highlighting", "footer", "code", "pagination", "icons", "iframes", "tables";
```

NOTE: This goes under the `assets` folder. 

IMPORTANT: The two lines with a triple dash at the beginning of the file are required by Jekyll to recognize and deploy the file as content.

## head.html

Inline the critical CSS inside a `style` tag:

```liquid
 <style>
{% raw %}
{% capture critical %}
  {% include minima_critical.scss %}
{% endcapture %}

{{ critical | scssify }} 
{% endraw %}
</style>
```

Also, it's a good idea to preload the main CSS you will use later:

```html
<link rel="preload" href="{{ '/assets/main.css' | relative_url }}" as="style">
```

## default.html

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
