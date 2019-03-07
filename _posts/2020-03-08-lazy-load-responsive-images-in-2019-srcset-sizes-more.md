---
layout: post
title: Tables that look like lists and lists that look like tables in responsive design

date: 2019-03-11 08:15:00 +01:00
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

Here's the markup of the table you've got.

```html
<table>
  <thead>
    <tr>
      <th scope="col">Photo</th>
      <th scope="col">Description</th>
      <th scope="col">Price</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><img src="https://via.placeholder.com/70x100&text=Product"></td>
      <td>Description</td>
      <td>EUR 12.345</td>
    </tr>
    <tr>
      <td><img src="https://via.placeholder.com/70x100&text=Product"></td>
      <td>Description</td>
      <td>EUR 12.345</td>
    </tr>
  </tbody>
</table>
```

The solution in this case would be to `display: flex` the rows, then order them vertically using `flex-direction: column`.

```css
tr {
  display: flex;
  flex-direction: column;
}

@media (min-width: 400px) {
  tr {
    flex-direction: row;
  }
}

td {
  padding: 10px;
}

thead {
  display: none;
}
```

And boom.

<iframe height="350" style="width: 100%;" scrolling="no" title="Table markup, list layout (on small viewports)" data-src="//codepen.io/verlok/embed/GeWXGy/?height=350&theme-id=light&default-tab=html,result" frameborder="no" allowtransparency="true" allowfullscreen="true">
  See the Pen <a href='https://codepen.io/verlok/pen/GeWXGy/'>Table markup, list layout (on small viewports)</a> by Andrea Verlicchi
  (<a href='https://codepen.io/verlok'>@verlok</a>) on <a href='https://codepen.io'>CodePen</a>.
</iframe>

## Table or table not?

But is `<table>` the right tag to use here? Isn't just a list of order an unorder list? So why don't we use a `ul` instead?

```html
<ul>
  <li>
    <div class="photo"><img src="https://via.placeholder.com/70x100&text=Product"></div>
    <div class="description">Description</div>
    <div class="price">EUR 12.345</div>
  </li>
  <li>
    <div class="photo"><img src="https://via.placeholder.com/70x100&text=Product"></div>
    <div class="description">Description</div>
    <div class="price">EUR 12.345</div>
  </li>
  <li>
    <div class="photo"><img src="https://via.placeholder.com/70x100&text=Product"></div>
    <div class="description">Description</div>
    <div class="price">EUR 12.345</div>
  </li>
  <li>
    <div class="photo"><img src="https://via.placeholder.com/70x100&text=Product"></div>
    <div class="description">Description</div>
    <div class="price">EUR 12.345</div>
  </li>
</ul>
```

And in the CSS, make the `div`s inside the list items to be aligned horizontally, when there's enough space to do this.

```css
@media (min-width: 400px) {
  li {
    display: flex;
  }
}

div {
  padding: 10px;
}
```

And here's the result:

<iframe height="350" style="width: 100%;" scrolling="no" title="List markup, table layout (on large viewports)" data-src="//codepen.io/verlok/embed/pYeOwq/?height=350&theme-id=light&default-tab=html,result" frameborder="no" allowtransparency="true" allowfullscreen="true">
  See the Pen <a href='https://codepen.io/verlok/pen/pYeOwq/'>List markup, table layout (on large viewports)</a> by Andrea Verlicchi
  (<a href='https://codepen.io/verlok'>@verlok</a>) on <a href='https://codepen.io'>CodePen</a>.
</iframe>

## Accessibility considerations

Table is very accessible but it does make sense to have a table when the data in the cells have 2 headings, one at the top and one at the left.

If it's only a title per each column you have, you probably used the table only to align the columns, but the data is not to be considered a table.

So make sure you choose properly!