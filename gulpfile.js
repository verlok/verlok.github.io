var gulp = require('gulp');
var postcss = require('gulp-postcss');
var uncss = require('postcss-uncss');

gulp.task('css', function () {
    var plugins = [
        uncss({
            html: ['_site/**/index.html']
        }),
    ];
    return gulp.src('./_site/assets/main.css')
        .pipe(postcss(plugins))
        .pipe(gulp.dest('./dest'));
});