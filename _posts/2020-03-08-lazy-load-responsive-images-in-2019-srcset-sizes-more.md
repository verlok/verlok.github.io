---
layout: post
title: Tables that look like lists and lists that look like tables in responsive design

date: 2019-03-08 08:15:00 +01:00
categories:
- development, responsive design, accessibility, techniques
tags: [accessibility, responsive design, tables, list]
---

How to make a potentially wide table fit on small devices, keeping accessibility in mind? Here is the solution and some considerations.

So let’s say you have an HTML `<table>` containing some orders, each one having:

1. a picture
2. a description 
3. a price

And you need to:

- make it look like a list on small viewports, typically smartphones
- make it look like a table on larger viewports, like tablets and computers
- make it accessible, e.g. to blind users

## Table markup

```html
<table>
    <thead>
        <tr>
            <th></th>
            <th></th>
            <th></th>
        </tr>
    </thead>
</table>
```