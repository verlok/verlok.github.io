---
layout: post
title: Create a JavaScript library using ES2015, modules, Gulp, Rollup and Jest
date: 2017-09-11 08:00:00:00 +01:00
categories:
- best practices
tags: [es2015, modules, javaScript, gulp, rollup]
---

Let's discover how and why to write a JavaScript library using [ES2015](https://babeljs.io/learn-es2015/) transpiled with [Babel](https://babeljs.io/), featuring [ES modules](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Statements/import) packed up using [Rollup](https://rollupjs.org/), running everything with [Gulp](gulp.js) and using [Jest](https://facebook.github.io/jest/) to test your code.

The experience I'm showing in this post is the one I had while developing my [vanilla-lazyload](https://github.com/verlok/lazyload).


## Gulp

Gulp is a task runner similar to Grunt for automating painful or time-consuming tasks in your development workflow, so you can stop messing around and build something.

I chose to migrate from Grunt (another task runner) to Gulp because the latter is blazing fast, being it based on Node [streams](https://medium.freecodecamp.org/node-js-streams-everything-you-need-to-know-c9141306be93) instead of the file system.

In order to use Gulp, you need to install Gulp locally to your project, and you need a local file named `gulpfile.js`. 

You can create an empty `gulpfile.js` for now, I'll show you later what to put in it.

To install gulp locally, just do:

```bash
npm install --save-dev gulp 
```

A good option to use Gulp is to install its command line executable with:

```bash
npm install -g gulp-cli
```

So you can just execute it by running the Gulp command

```bash
gulp
```

For more information, I would suggest to read [Gulp for beginners](https://css-tricks.com/gulp-for-beginners/) on CSS tricks.


## Step 1. Linting first

Being JavaScript a dynamic and loosely-typed language, is especially prone to developer errors. Linting tools like [ESLint](https://eslint.org/) allow developers to discover problems with their JavaScript code without executing it.

So the first thing I want my `gulp` command to do is check the code using ESLint.

To install ESLint for Gulp, just run:

```bash
npm install --save-dev gulp-eslint 
```

Then in your `gulpfile.js` add:

```js
var gulp = require("gulp");
var eslint = require("gulp-eslint");

gulp.task("default", function () {
    process.env.NODE_ENV = "release";
    return gulp.src("./src/**/*.js")
        // ----------- linting --------------
        .pipe(eslint())
        .pipe(eslint.format())
        .pipe(eslint.failAfterError()) // --> fails if errors
        // --> pipe more stuff here 
});
```

NOTE: Setting the `process.env.NODE_ENV` variable is necessary to match the task we're running in the Babel configuration. I'll explain this later.


## Step 2. Rolling up modules

Rollup is a module bundler for JavaScript which compiles small pieces of code into something larger, such as a library. It uses the new standardized format for code modules included in the ES2015 revision of JavaScript, instead of older CommonJS and AMD. ES6 modules let you freely and seamlessly combine the most useful individual functions from your favorite libraries.

To simplify, Rollup reads your main JavaScript file and generates a bigger file with all the modules included, automatically. And it even removes what you don't use, feature also known as _tree shaking_.

Install rollup with:

```bash
npm install --save-dev gulp-rollup gulp-rename 
```

Then in your gulpfile, just add a pipe command:

```js
        // ----------- rolling up --------------
        .pipe(rollup({
            format: "umd",
            moduleName: "LazyLoad",
            entry: "./src/lazyload.js"
        }))
```

This means that Rollup has to produce a `umd` type of module, the produced module name will be `LazyLoad`, and the entry point to start looking for dependencies is `./src/lazyload.js`.

Since I want to distribute a version of the script which is not transpiled in ES5, I save it to `lazyload.es2015.js` piping the `rename` command and the `dest` one.

```js
        .pipe(rename("lazyload.es2015.js"))
        .pipe(gulp.dest(destFolder)) // --> writing rolledup
```

`destFolder` is a JavaScript variable and it's just set to  `./dist` inside your `gulpfile.js`.



Until now, your `gulpfile.js` will now look like this:

```js
var gulp = require("gulp");
var eslint = require("gulp-eslint");
var rollup = require("gulp-rollup");
var destFolder = "./dist";

gulp.task("default", function () {
    process.env.NODE_ENV = "release";
    return gulp.src("./src/**/*.js")
        // ----------- linting --------------
        .pipe(eslint())
        .pipe(eslint.format())
        .pipe(eslint.failAfterError()) // --> fails if errors
        // ----------- rolling up --------------
        .pipe(rollup({
            format: "umd",
            moduleName: "LazyLoad",
            entry: "./src/lazyload.js"
        }))
        .pipe(rename("lazyload.es2015.js"))
        .pipe(gulp.dest(destFolder)) // --> writing rolledup
});
```

NOTE: [Webpack](https://webpack.github.io/) is a similar bundling script which might be preferrable to bundle complex applications, but I noticed that the final code generated by Webpack would be much heavier, so I prefer Rollup to do this kind of job.


## Step 3. Tranpilation using Babel

Until now, we have bundled all our modules in a single file which will work in modern browsers only. Of course we also want to produce a file which is readable by _not so modern_ browsers.

To install babel and its ES2015 preset, plus a plugin to transform `Object.assign()` to ES5, do:

```bash
npm install --save-dev babel-core gulp-babel babel-preset-es2015 babel-plugin-transform-object-assign
```

Then, to babelize our previously rolled-up JavaScript and save it to `lazyload.js`, let's require `gulp-babel`

```js
var babel = require("gulp-babel");
```

Then, add the following pipe to our `gruntfile.js`:

```js
        // ----------- babelizing --------------
        .pipe(babel())
        .pipe(rename("lazyload.js"))
        .pipe(gulp.dest(destFolder)) // --> writing babelized es5 js
```

## Step 4. Minification with Uglify

.
.
.
.
.

** TODO: Create a separate post about testing private functions from modules using Jest and ES2015 modules **

