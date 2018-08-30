---
layout: post
title: Check if an element is still inside viewport after a given time
date: 2018-08-27 08:30:00:00 +01:00
categories:
- techniques
tags: [javascript, IntersectionObserver, timeout, lazy loading]
---

What would you do if somebody asked you to load a DOM element only if it **stays inside the viewport for a given time**? You would use [vanilla-lazyload](https://github.com/verlok/lazyload), wouldn't you? 😉 This is exactly what the GitHub community asked for as new feature in LazyLoad, to **avoid loading elements which users skipped** by **scrolling fast beyond them**. In this post, I'd like to share the solution with you.

There are a couple of ways of doing this. The first one is check the element's posistion over time, the second one leverages `IntersectionObserver`.

## The (slow) way without IntersectionObserver

This way is much slower that using `IntersectionObserver` because it implies:

- watching browser’s `scroll` and `resize` events to call a (throttled) callback
- in the callback, loop through every watched element and call a `isInsideViewport` function to check if they are inside the viewport 
- the `isInsideViewport` function then checks a [bunch of things](https://github.com/verlok/lazyload/blob/support/8.x/src/lazyload.viewport.js) like the element's `getBoundingClientRect`, the window's `innerHeight`, `pageYOffset`, etc. and returns a boolean

All of these only to know when elements enter the viewport.

To know whether or not a given element stayed inside the viewport for a given time, you should do something like:

- when the element enters the viewport, `setTimeout` a function. Let's call it `isStillInsideViewport`.
- in the `isStillInsideViewport` function, check if the element is still inside the viewport calling `isInsideViewport` on that element, then:
  - if it is, load it and remove it from the watched elements
  - if it's NOT, don't load it and keep watching it

Quite straightforward as a thought, but not that fast executing.

## The way with IntersectionObserver

This way is much faster because it only implies the following.

- you set an `IntersectionObserver` and use it to observe all your watched elements
- it calls a `onIntersection` function each time an element intersects with the viewport
- you can do the loading logic inside the `onIntersection` function

No need to watch browser’s `scroll` nor `resize` events.

### First idea

My first thought was to do it without `IntersectionObserver`, meaning I'd have to check the "is inside viewport" state after a timeout.

Turns out there is not an elegant way to check if an element is inside the viewport with `IntersectionObserver`. All you get are callbacks when an element intersects with the viewport.

### Discovering thresholds

But wait, what is that `IntersectionObserver`'s `thresholds` option in the [doc](https://developer.mozilla.org/en-US/docs/Web/API/Intersection_Observer_API)? 😲

Says MDN:

> Either a single number or an array of numbers which indicate at what percentage of the target's visibility the observer's callback should be executed. If you only want to detect when visibility passes the 50% mark, you can use a value of 0.5. If you want the callback run every time visibility passes another 25%, you would specify the array [0, 0.25, 0.5, 0.75, 1]. The default is 0 (meaning as soon as even one pixel is visible, the callback will be run). A value of 1.0 means that the threshold isn't considered passed until every pixel is visible.

After I fiddled around with the option and tried the result in a specific [delay load demo](https://github.com/verlok/lazyload/blob/master/demos/delay_test.html), I found out that passing `0` to the `thresholds` option (which is the default value), the `onIntersection` function is called also when the element _leaves_ the viewport.

### Ultimate solution

Now that I knew when an element **leaves the viewport**, it's **much easier to solve the main problem**.

The solution, ultimately, is to:

- when an element enters the viewport, `setTimeout` a function to load the element
- store each timeout ID in a `data-` attribute of the related element
- let the element load when the timeout occurs
- if the element leaves the viewport before the timeout is executed, cancel the timeout with `clearTimeout`

That's linear and easy! 😊

---

## Show me the code!

You can find the full code in vanilla-lazyload's [`lazyload.js`](https://github.com/verlok/lazyload/blob/master/src/lazyload.js) file + related imports. If you don't feel like jumping from one file to another, you could also open the bundled file [`lazyload.es2015.js`](https://github.com/verlok/lazyload/blob/master/dist/lazyload.es2015.js) from the `dist` folder. 

A **simplified version** of the code is provided below for your convenience.

### Setting IntersectionObserver

```js
const gObserver = new IntersectionObserver(onIntersection, {
  rootMargin: "0px",
  threshold: 0
});
```

The `rootMargin` option set to `0px` here means: "observe the actual viewport size". You could pass any CSS length in order to expand the observed area. E.g. passing `300px` would expand it by that length on top, right, bottom, and left.

### onIntersection function

This function is called each time an intersection occurs and the parameter is the set of entries that intersected with the viewport.

Assuming `watchedElements` are the elements being watched by the script (see below), after each intersection they should be purged from the elements we already dealt with (loaded).

The `purgeElements` function is out of the scope of this post, but it returns a subset of the watchedElements.

```js
const onIntersection = entries => {
  entries.forEach(manageIntersection);
  watchedElements = purgeElements(watchedElements);
};
```

### manageIntersection function

This function is called on each entry that intersected with the viewport. Both on enter and exit.

On enter, it starts the delayed loading of the element. On exit, it cancels it.

```js
const manageIntersection = entry => {
  var element = entry.target;
  if (isIntersecting(entry)) {
    delayLoad(element, delayTime);
  } else {
    cancelDelayLoad(element);
  }
};
```

### isIntersecting utility function

This is a utility function to understand whether or not an entry is intersecting with the viewport.

Note that:

- `entry.isIntersecting` needs fallback because it is `null` on some versions of Microsoft Edge
- `entry.intersectionRatio` is not enough alone because it could be `0` on some intersecting elements 

```js
const isIntersecting = (entry) =>
  entry.isIntersecting || entry.intersectionRatio > 0;
```

### delayLoad function

This is the function that delays the load of the element by `delayTime`.

`getTimeoutData` and `setTimeoutData` are utility functions to get and set the timeout ID from a data-attribute on the element.

```js
const delayLoad = (element, delayTime) => {
  var timeoutId = getTimeoutData(element);
  if (timeoutId) {
    return; // timeout was already set, do nothing
  }
  timeoutId = setTimeout(function() {
    loadAndUnobserve(element);
    cancelDelayLoad(element);
  }, delayTime);
  setTimeoutData(element, timeoutId);
};
```

### cancelDelayLoad function

This function's duty is to cancel the element timeout, if it's set.

```js
const cancelDelayLoad = element => {
  var timeoutId = getTimeoutData(element);
  if (!timeoutId) {
    return; // do nothing if timeout doesn't exist
  }
  clearTimeout(timeoutId);
  deleteTimeoutData(element);
};
```

### loadAndUnobserve function

This immediately loads the element, and takes it away from the `IntersectionObserver`'s observed elements.

```js
const loadAndUnobserve = (element) => {
  // Here's what you actually do something with the element
  revealElement(element); 
  gObserver.unobserve(element);
};
```

### At my signal, unleash hell!

We did everything good until now, but we didn't start anything yet! We need a set of `watchedElements` to observe with our `IntersectionObserver`, or nothing will happen.

```js
var watchedElements = document.querySelectorAll("img");
watchedElements.forEach(element => gObserver.observe(element));
```

### All together now

You can find a working version of the code above on CodeSandbox for you to play around with it!

[![Check if an element is still inside viewport after a given time](https://codesandbox.io/static/img/play-codesandbox.svg)](https://codesandbox.io/s/mzokk46vlx)

## Final words

See how easy is it to check if an element is still inside the viewport after some time using `IntersectionObserver`?

For more information about how to create LazyLoad using `IntersectionObserver`, see [Intersection Observer and Lazy Load of elements]({{ site.baseurl }}{% post_url 2017-09-04-using-intersection-observers-to-create-vanilla-lazyload %}).

Is there something you would have done differently, or do you agree with what I did here? Please let me know in the comments!

If you want to show some love to LazyLoad, [star it on GitHub](https://github.com/verlok/lazyload)! ⭐
