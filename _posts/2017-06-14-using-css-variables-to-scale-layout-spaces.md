---
layout: post
title: Using CSS variables as a spacing unit
date: 2017-06-14 08:30:00:00 +01:00
categories:
- techniques
tags: [css variables, css custom properties, layout]
---

Here I show you how you can CSS variables, popular name of _CSS custom properties_, to **scale your layout spaces** across different media queries.

> The advantage: shorter, lighter, easier-to-maintain CSS files.

To demonstrate this, I created [CSS vars based layout spacing](https://codepen.io/verlok/pen/owzLPm?editors=1100) on Codepen. Find it embedded at the end of this post.


## What are CSS variables

CSS variables one of the next big things in CSS. They're not [widely supported](http://caniuse.com/#feat=css-variables) (spoiler: Internet Explorer is missing) for current browsers market share, but it's time we start playing with them, don't you think? They might be useful when developing our next wonderful project!

The advantage of CSS variables is that we can assign a value to a name, and refer to the value using a name. 

## How to define a CSS variable

CSS variables can be defined at any point, and they are inherited to all the children of the DOM element they're applied to.

```css
html {
  --base-spacing: 15px;
}
```

Here we defined a CSS var named `--base-spacing` and we assigned it a value of `15px`. The variable is defined in the `html` element so it will be available in our whole document.

(Yeah, CSS vars must start with a double hyphen (`--`), which is ugly, but bare with me)


## Difference with SASS variables

In case you're thinking: "So what? I'm already using SASS and my `_variables.scss` has plenty of variables!" - Well, it's not quite the same.

SASS variables are pre-processed so they are transformed to a fixed, static CSS value. When the CSS is loaded, **the variable is lost** and only its value remains, spread out in all of its usages.

> A SASS variable cannot be changed after the CSS is loaded. CSS variables can be changed using media queries, javascript, or the developer tools of your favourite browser.


## How to use a CSS variable

We want the `--base-spacing` variable to be a spacing unit to be used in paddings and margins across our page. So what do we do?

```css
.box {
  padding: var(--base-spacing);
  margin: var(--base-spacing);
}

h1 {
  margin-bottom: var(--base-spacing);
}
```

That's great! Now we're using our CSS variable as a spacing unit, like we would do with a SASS variable, but... we can now change it!


## Changing CSS variables values

This is where the magic happens. CSS variables values can be re-assigned like you would do with any other CSS property, using:

- media queries
- javascript
- the developer tools of your favourite browser

The first thing you can do to understand the power of CSS variables is **open the developer tools**, locate the variable in your CSS file, and **change its value**. [Try it here](https://codepen.io/verlok/pen/owzLPm?editors=1100).

In our case, we want to enlarge spaces on wider screens, so we just do the following:

```css
@media (min-width: 500px) {
  html {
    --base-spacing: 30px;
  }
}
```

That's it. This simple variable reassignment will make all of our paddings and margins scale since we used a variable to define theis values.

## DEMO

This is what I'm talking about.

<p data-height="265" data-theme-id="dark" data-slug-hash="owzLPm" data-default-tab="css,result" data-user="verlok" data-embed-version="2" data-pen-title="CSS vars based layout spacing" class="codepen">See the Pen <a href="https://codepen.io/verlok/pen/owzLPm/">CSS vars based layout spacing</a> by Andrea Verlicchi (<a href="https://codepen.io/verlok">@verlok</a>) on <a href="https://codepen.io">CodePen</a>.</p>
<script async src="https://production-assets.codepen.io/assets/embed/ei.js"></script>


## Endless possibilities

Now that you master CSS variables, you can go far beyond and let your users decide the spacing of your layout, the main color, or anything else.

You just need some input fields and a few lines of javascript, like [@wesbos](https://www.twitter.com/wesbos) is demonstrating here.

<p data-height="265" data-theme-id="dark" data-slug-hash="adQjoY" data-default-tab="css,result" data-user="wesbos" data-embed-version="2" data-pen-title="Update CSS Variables with JS" class="codepen">See the Pen <a href="https://codepen.io/wesbos/pen/adQjoY/">Update CSS Variables with JS</a> by Wes Bos (<a href="https://codepen.io/wesbos">@wesbos</a>) on <a href="https://codepen.io">CodePen</a>.</p>
<script async src="https://production-assets.codepen.io/assets/embed/ei.js"></script>