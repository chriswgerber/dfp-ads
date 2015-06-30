/*
 npm install --save-dev gulp
 npm install gulp-ruby-sass gulp-sass gulp-watch gulp-jshint gulp-plumber gulp-autoprefixer gulp-include gulp-minify-css gulp-jshint gulp-concat gulp-uglify gulp-imagemin gulp-notify gulp-rename gulp-livereload gulp-cache del jshint-stylish --save-dev
 */

var gulp = require( 'gulp' ),
    plumber = require( 'gulp-plumber' ),
    watch = require( 'gulp-watch' ),
    livereload = require( 'gulp-livereload' ),
    minifycss = require( 'gulp-minify-css' ),
    concat = require('gulp-concat'),
    jshint = require( 'gulp-jshint' ),
    notify = require( 'gulp-notify' ),
    include = require( 'gulp-include' ),
    autoprefixer = require('gulp-autoprefixer'),
    imagemin = require('gulp-imagemin'),
    stylish = require( 'jshint-stylish' ),
    uglify = require( 'gulp-uglify' ),
    rename = require( 'gulp-rename' ),
    sass = require( 'gulp-sass' );

var onError = function( err ) {
    console.log( 'An error occurred:', err.message );
    this.emit( 'end' );
};

// Lint Task
gulp.task('lint', function() {
    return gulp.src('./assets/js/*.js')
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

gulp.task( 'default', [ 'lint', 'ads-scripts', 'dfp-scripts' ], function() {} );