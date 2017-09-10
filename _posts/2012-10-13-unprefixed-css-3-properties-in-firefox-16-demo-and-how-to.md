---
layout: post
title: Unprefixed CSS 3 properties in Firefox 16, demo and how-to
date: 2012-10-13 14:07:30.000000000 +02:00
categories:
- development
tags:
- animations
- css 3
- demo
- firefox
- prefixes
- transitions
status: publish
type: post
published: true
---
I heard that Firefox 16 unprefixed CSS 3 transitions, animations and gradients, so I wanted to give it a try. In short, it's true: starting from October 9th, no more -webkit- prefix in transition, animation, @keyframes and linear-gradient.

![](/assets/post-images/unprefixed-ff-button1.jpg "unprefixed-ff-button")

So here's how to create a shaking button that transitions to another color when rolled over.

## Result first:

<iframe class="lazy" height='265' scrolling='no' title='Animated and transitioned gradient rounded button' data-src='https://codepen.io/verlok/embed/dWgePa/?height=265&amp;theme-id=0&amp;default-tab=css,result&amp;embed-version=2' frameborder='no' allowtransparency='true' allowfullscreen='true' style='width: 100%;'>See the Pen <a href='https://codepen.io/verlok/pen/dWgePa/'>Animated and transitioned gradient rounded button</a> by Andrea Verlicchi (<a href='https://codepen.io/verlok'>@verlok</a>) on <a href='https://codepen.io'>CodePen</a>.
</iframe>

## Create the markup and the basic CSS

This is a regular rounded corners button that changes color to red when mouse-overed.

```html
<div class="clearfix">
    <a id="me" href="http://www.andreaverlicchi.eu">Visit andreaverlicchi.eu</a>
</div>
```

```css
body {
    font-family: Helvetica, Arial, sans-serif;
}

#me {
    color: white;
    display: block;
    float: left;
    padding: 0.5em 1em;
    background-color: purple;
    text-decoration: none;
}

/* The hover state */

#me:hover {
    background-color: red;
}

/* CSS 3 already unprefixed in all browser */

#me {
    border-radius: 20px;
    text-shadow: 0 1px 1px black;
}
```

## The simplest thing: add the transition

```css
#me {
    /* For Firefox 16 and Internet Explorer 10 */
    transition: background-color 1s ease-in-out;
    /* For Chrome 22 and Safari 6 */
    -webkit-transition: background-color 1s ease-in-out;
    /* For Opera 12 */
    -o-transition: background-color 1s ease-in-out;
}
```

## Now the animation keyframes

```css
/* Fore Firefox 16 and Internet Explorer 10 */
@keyframes shake {
    100% {transform: translate(20px, 0px); }
}
/* For Chrome 22 and Safari 6 */
@-webkit-keyframes shake {
    100% {-webkit-transform: translate(20px, 0px); }
}
/* For Opera 12 */
@-o-keyframes shake {
    100% {-o-transform: translate(20px, 0px); }
}
```

## ...and the animation appliance

```css
/* For Firefox 16 and Internet Explorer 10 */
animation: shake 1s infinite alternate ease-in-out;
/* For Chrome 22 and Safari 6 */
-webkit-animation: shake 1s infinite alternate ease-in-out;
/* For Opera 12 */
-o-animation: shake 1s infinite alternate ease-in-out;
```

## Finally, the linear gradient

Note that the syntax of linear gradient has been changed according to standards

```css
/* For Firefox 16 and Internet Explorer 10 */
background-image: linear-gradient(to bottom, rgba(255,255,255,.5), rgba(127,127,127,0.1), rgba(0,0,0,0.5));
/* For Chrome 22 and Safari 6 */
background-image: -webkit-linear-gradient(top, rgba(255,255,255,.5), rgba(127,127,127,0.1), rgba(0,0,0,0.5));
/* For Opera 12 */
background-image: -o-linear-gradient(top, rgba(255,255,255,.5), rgba(127,127,127,0.1), rgba(0,0,0,0.5));
```

## The final, without comment, compact and readable version:

```css
@-webkit-keyframes shake {
    100% {-webkit-transform: translate(20px, 0px); }
}
@-o-keyframes shake {
    100% {     -o-transform: translate(20px, 0px); }
}
@keyframes shake {
    100% {        transform: translate(20px, 0px); }
}

#me {
    border-radius: 20px;
    text-shadow: 0 1px 1px black;

    /* Ani */
    -webkit-animation: shake 1s infinite alternate ease-in-out;
    -o-animation:      shake 1s infinite alternate ease-in-out;
    animation:         shake 1s infinite alternate ease-in-out;

    /* Trans */
    -webkit-transition: background-color 1s ease-in-out;
    -o-transition:      background-color 1s ease-in-out;
    transition:         background-color 1s ease-in-out;

    /* Gradient */
    background-image: -webkit-linear-gradient(top,       rgba(255,255,255,.5), rgba(127,127,127,0.1), rgba(0,0,0,0.5));
    background-image:      -o-linear-gradient(top,       rgba(255,255,255,.5), rgba(127,127,127,0.1), rgba(0,0,0,0.5));
    background-image:         linear-gradient(to bottom, rgba(255,255,255,.5), rgba(127,127,127,0.1), rgba(0,0,0,0.5));
    }
```

That's it!

If you have any questions, please tweet me [@verlok](https://twitter.com/verlok).