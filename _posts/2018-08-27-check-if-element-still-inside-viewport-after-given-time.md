---
layout: post
title: Check if an element is still inside viewport after a given time
date: 2018-08-27 08:30:00:00 +01:00
categories:
- techniques
tags: [javascript, IntersectionObserver, timeout, lazy loading]
---

They asked me a new feature on LazyLoad to avoid loading elements which users skipped scrolling fast over them

The way without IntersectionObserver 

- (watch browser’s scroll and resize events, then loop though every element and check if they are inside viewport calling a function)
- the function to check is inside viewport checks the element boundaries and offsets (details...)
- set a timeout when the element entered the viewport, 
- check if it was inside the viewport after the given time. 
- if it was load it and remove it from the watched elements, 
- if it wasn’t keep watching it

The way with IntersectionObserver 

- (Best performance because you don’t watch over scroll and resize)
- (you just set an observer and pass them a list of elements, it calls a function each time an intersection occurs)
- (It let you set some options like the margin of the elements, the second element or the viewport, and the thresholds in which to call the callback)
- First thought was to do like without intersection observer, meaning to check the inside viewport state after a timeout using IntersectionObserver
- Turns out there is no elegant way to check if an element is inside the viewport with intersection observer
- BUT there is a way to know when an element exits the viewport!

What is the solution then:

- Set a timeout when it enters the viewport 
- Let the element load when the timeout occurs
- Cancel the timeout when you’re notified the element exited the viewport 

That linear and easy. 
The code for this is provided below.
