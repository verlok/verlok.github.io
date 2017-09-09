var gulp = require('gulp');
var purify = require('gulp-purifycss');

gulp.task('css', function() {
  return gulp.src('./_site/main.css')
    .pipe(purify(['./_site/**/*.js', './_site/**/*.html']))
    .pipe(gulp.dest('./dist/'));
});