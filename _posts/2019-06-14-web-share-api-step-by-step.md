---
layout: post
title: Web Share API, the step after PWA

date: 2019-06-14 9:00:00 +01:00
categories:
- techniques
- web share API
tags: [web share api]
image: native-web-sharing-api__2x.png
---

Today I experimented with the Web Share API and implemented it on this website, just to begin. Here's what I did and how you can implement it on your website.

<img alt="iOS system share tray" src="/assets/post-images/native-web-sharing-api__1x.png" srcset="/assets/post-images/native-web-sharing-api__1x.png 1x, /assets/post-images/native-web-sharing-api__2x.png 2x" class="post-image">

After I made a Progressive Web Application out of this website, I also removed the AddThis script which was used to add the share buttons ad the end of each posts, because it was slowing down the website. I then realized that, after adding the website to my home screen as a standalone app, users couldn't share posts anymore. 

## Web Share API to the rescue!

I've added the following script to my website's post pages:

```js
(function() {
  // Detects support for the web share feature
  var supportsShare = "share" in navigator;

  // No support? 
  // - Add a "noShare" class to the document
  // - Don't do anything else
  if (!supportsShare) {
    document.documentElement.classList.add("noShare");
    return;
  }

  // Supported? Get:
  // - the share button (DOM element)
  // - the canonicalUrl of the page
  // - the title of the page
  var shareButton = document.querySelector(".post-share");
  var canonicalUrl = document
    .querySelector("link[rel=canonical]")
    .getAttribute("href");
  var title = document.querySelector("title").innerText;

  // Add a listener to the share button
  shareButton.addEventListener("click", function(event) {
    // Call navigator share with the title and the canonical URL
    navigator
      .share({
        title: title,
        url: canonicalUrl
      })
      .then(() => {
        // You do whatever you want here
        console.log("Thanks for sharing!");
      })
      .catch(e => {
        // Manage errors here
        console.error(e, "Share failed")
      });
  });
})();
```

Then, to hide the share buttons using CSS when the `noShare` class is added to the document:

```css
.noShare .post-share {
  display: none;
}
```

That easy!

The [support for the Web Share API](https://caniuse.com/#feat=web-share) is still little, but at least is supported from Safari and Chrome for Android, so it'll help whoever installed your PWA in their mobile's home screen.