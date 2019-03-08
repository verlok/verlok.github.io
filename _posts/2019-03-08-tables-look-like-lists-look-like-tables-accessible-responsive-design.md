---
layout: post
title: Responsive and accessible table design

date: 2019-03-08 07:12:00 +01:00
categories:
- development, responsive design, accessibility, techniques
tags: [accessibility, responsive design, tables, list]
---

How to make a potentially wide table fit on small devices, without losing readability and accessibility? Here are simple solutions to make tables look like lists, lists look like tables, in responsive and accessible design.

So let’s say you have an HTML `<table>` containing some orders, each one having:

1. a picture
2. a description 
3. a price

And you need to make it:

- **look like a list** on small viewports, typically smartphones
- **look like a table** on larger viewports, like tablets and computers
- **accessible** (see [accessibility](https://www.w3.org/standards/webdesign/accessibility)), e.g. to blind users

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

The solution in this case would be to `display: flex` the rows, then set their cells direction to vertical using `flex-direction: column`.

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
```

And boom. Here's the example on codepen.

<iframe class="lazy" height="350" style="width: 100%;" scrolling="no" title="Table markup, list layout (on small viewports)" data-src="//codepen.io/verlok/embed/GeWXGy/?height=350&theme-id=light&default-tab=html,result" frameborder="no" allowtransparency="true" allowfullscreen="true">
  See the Pen <a href='https://codepen.io/verlok/pen/GeWXGy/'>Table markup, list layout (on small viewports)</a> by Andrea Verlicchi
  (<a href='https://codepen.io/verlok'>@verlok</a>) on <a href='https://codepen.io'>CodePen</a>.
</iframe>

## But is this really a table?

Is `table` the right tag to use here? Is there a chance that we might have used the `table` tag only for layout simplicity? I mean, isn't it just a **list** of orders? So why don't use a `ul` instead?

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
</ul>
```

In this case, in the CSS, we just need to make the `div`s inside the list items to be aligned horizontally, when there's enough space to do this.

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

Here's the result:

<iframe class="lazy" height="350" style="width: 100%;" scrolling="no" title="List markup, table layout (on large viewports)" data-src="//codepen.io/verlok/embed/pYeOwq/?height=350&theme-id=light&default-tab=html,result" frameborder="no" allowtransparency="true" allowfullscreen="true">
  See the Pen <a href='https://codepen.io/verlok/pen/pYeOwq/'>List markup, table layout (on large viewports)</a> by Andrea Verlicchi
  (<a href='https://codepen.io/verlok'>@verlok</a>) on <a href='https://codepen.io'>CodePen</a>.
</iframe>

## Accessibility considerations

The `table`s can be very accessible if you [code them properly](https://webaim.org/techniques/tables/data), but I think it only makes sense to use `table`s when the data in each data cell have at least 2 headings: one at the beginning of its column and one at beginning of its row.

If it's only a title per each column you have, and you have a few columns, it's probably better to consider it a list and markup it like a list, using `ul` or `ol` as you prefer. Make sure you choose properly!

Last but not least, if you have a non-table markup (`ul`, `div`, `span`) that you are displaying as a table, and you want to make it accessible too, make sure you use [ARIA roles](https://www.w3.org/TR/wai-aria-practices/examples/table/table.html) to define your `rowgroup`s, your `columnheader`s and `rowheader`s, your `cell`s, etc.

## Conclusion

You can use flexbox to easily make a table look like a list, or a list look like a table. Keep accessibility in mind! When coding tables use table headers for rows and columns. When coding pseudo-tables use ARIA roles to define which is what.
