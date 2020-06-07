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

<img alt="Blurry, uncomprehensible and colored code" src="/assets/post-images/critical-css-jekyll-sass__1x.png" srcset="/assets/post-images/critical-css-jekyll-sass__1x.png 1x, /assets/post-images/critical-css-jekyll-sass__2x.png 2x" class="post-image">

## The critical style

In the critical SASS file, use the SASS `@import` directive to include all the partials that have an impact on the layout of your page. Also include your _variables_ and _mixins_ that might be required from the imported partials.

For instance, I'm importing: 

- the `base` partial, which contains the basic rules of the website like the CSS reset and the typography rules,
- the `layout` partial, which styles the header and layout of the page, 
- the `posts_above` partial, which styles the _above-the-fold_ part of the posts list and the post detail, 
- the `utils` partial, which contains some helper classes (e.g. `visuallyHidden`).

The `posts_above` partial initially was a single file called `posts`, but I decided to split it in two separate files to optimize even more. The other partial, named `posts_below`, contains information to style the post footer (the author section, the share button) so it's _not_ included here.

&rarr; Create a `critical.scss` file inside the `includes` folder.

File `includes/critical.scss`:

```scss
// Import partials for critical css content
@import "variables", "mixins", "base", "layout", "posts_above", "pages", "utils";
```

IMPORTANT: Place this file in the `includes` folder! You'll need to include it in your HTML later.

## Stick it in your `head`

Inline the critical CSS inside a `style` tag in the `<head>` section of your HTML. You can do that using the following Jekyll code, which is based on the Liquid template engine used in Jekyll.

&rarr; Open your `head.html` partial if you have any.

File ``includes/head.html``:

```liquid
{% raw %}{% capture critical %}
  {% include minima_critical.scss %}
{% endcapture %}

{{ critical | scssify }}{% endraw %}
```

## The rest of your stylesheet

If your website is simple enough, you can import the rest of your partials inside a single SCSS file, which you will load asynchronously using JavaScript.

I for instance imported there all the SASS partials which style the page sections that are likely to appear _below-the-fold_: 

- the syntax highlighting style,
- the footer style,
- the pagination style, 
- the SVG icons style, 
- the iframes and tables styles

&rarr; Put the rest of your SASS rules inside your regular CSS file.

File `assets/main.scss`:

```scss
---
---

// Import partials for below-the-fold content
@import "variables", "mixins", "posts_below", "syntax-highlighting", "footer", "code", "pagination", "icons", "iframes", "tables";
```

**IMPORTANT**: The two lines with a triple dash at the beginning of the file are required by Jekyll to recognize and deploy the file as content.

## Load the rest of your stylesheet

There are many ways to load the rest of your CSS using Javascript, but I've decided to use the [modern async technique](https://www.filamentgroup.com/lab/async-css.html) which makes a CSS file load with low priority, then apply it to the page when loaded.

File `head.html`:

```html
{% raw %}<link rel="stylesheet" href="{{ '/assets/main.css' | relative_url }}" media="nope!" onload="this.media='all'">{% endraw %}
```

This works!

## Conclusion

Inlining the critical part of your CSS makes your pages to display faster since CSS is in the browser's critical rendering path.

Give it a try! If you have any comments, let me know in the comments section below!
