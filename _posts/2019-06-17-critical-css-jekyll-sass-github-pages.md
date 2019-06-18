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

<img alt="TODO" src="/assets/post-images/critical-css-jekyll-sass-github-pages__ph.png" data-src="/assets/post-images/critical-css-jekyll-sass-github-pages__1x.png" data-srcset="/assets/post-images/critical-css-jekyll-sass-github-pages__1x.png 1x, /assets/post-images/critical-css-jekyll-sass-github-pages__2x.png 2x" class="lazy post-image">

## includes/critical.scss

```scss
// Import partials for critical css contentl
@import "variables", "mixins", "base", "layout", "posts_above", 
  "pages", "utils";
```

NOTE: This goes under the `includes` folder!

## assets/main.scss

```scss
---
---

// Import partials for below-the-fold content
@import "variables", "mixins", "posts_below", "syntax-highlighting", 
  "footer", "code",	"pagination", "icons", "iframes", "tables";
```

NOTE: This goes under the `assets` folder. The triple dash at the beginning is required by Jekyll to recognize it and deploy it as content.


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
