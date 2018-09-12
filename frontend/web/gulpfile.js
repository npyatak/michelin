'use strict';

var gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    less = require('gulp-less'),
    cssmin = require('gulp-cssmin'),
    rigger = require('gulp-rigger'),
    imagemin = require('gulp-imagemin'),
    browserify = require('gulp-browserify');

var path = {
    build: {
        css: 'css',
        js: 'js'
    },
    src: {
        css: 'less/style.less',
        js: 'js_src/app.js'
    },
    watch: {
        css: 'less/*',
        js: 'js_src/*'
    }
};

gulp.task('style', function () {
    return gulp.src(path.src.css)
        .pipe(less())
        .pipe(cssmin())
        .pipe(gulp.dest(path.build.css));
});

gulp.task('script', function () {
    return gulp.src(path.src.js)
        .pipe(rigger())
        .pipe(browserify())
        .pipe(gulp.dest(path.build.js));
});

gulp.task('watch:all', function () {
    gulp.watch(path.watch.css, ['style']);
    gulp.watch(path.watch.js, ['script']);
});

gulp.task('watch:style', function () {
    gulp.watch(path.watch.css, ['style']);
});

gulp.task('watch:script', function () {
    gulp.watch(path.watch.js, ['script']);
});

gulp.task('default', ['watch:all', 'style', 'script']);
