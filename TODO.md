A performance review showed that

## slideShareResize.js is always downloaded

...even if not used by the page.
It is hindering other network requests though.

- Download it only in the pages where there are slided
- Use a new lazyload instance to detect when slides are included and entered / are about to enter the page

## Quicklink check

- Is it still in use? If not, remove it.

## External domains

Lazyload and quicklink are downloaded from an external domain: jsdelivr.
- self host the scripts

## External fonts

Am I still using external fonts?

- If not, remove them.
- If yes, self host them.