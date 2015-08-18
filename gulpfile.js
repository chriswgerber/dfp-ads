/*
 npm install --save-dev gulp
 npm install gulp-ruby-sass gulp-sass gulp-watch gulp-jshint gulp-plumber gulp-autoprefixer gulp-include gulp-minify-css gulp-jshint gulp-concat gulp-uglify gulp-imagemin gulp-notify gulp-rename gulp-livereload gulp-cache del jshint-stylish --save-dev
 */

var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    concat = require('gulp-concat'),
    jshint = require('gulp-jshint'),
    stylish = require('jshint-stylish'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename');

// Lint Task
gulp.task('lint', function() {
  return gulp.src('./assets/js/dfp-ads.js')
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('jshint-stylish'));
});

// Uglify Registration Scripts
gulp.task('ads-scripts', function() {
  return gulp.src('./assets/js/google-ads.js')
    .pipe(rename('google-ads.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('./assets/js/'));
});

// Uglify DFP Scripts
gulp.task('dfp-scripts', function() {
  return gulp.src('./assets/js/dfp-ads.js')
    .pipe(rename('dfp-ads.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('./assets/js/'));
});

gulp.task('default', ['lint', 'ads-scripts', 'dfp-scripts'], function() {});
