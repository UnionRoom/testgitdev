var gulp = require('gulp');

var browserSync = require('browser-sync').create();
var reload = browserSync.reload;

var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var cssnano = require('gulp-cssnano');
var sourcemaps = require('gulp-sourcemaps');

var order = require('gulp-order');
var concat = require('gulp-concat');
var minify = require('gulp-minify');

var newer = require('gulp-newer');
var imagemin = require('gulp-imagemin');

gulp.task('styles', function () {
    return gulp.src('./assets/scss/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(cssnano())
        .pipe(sourcemaps.write(''))
        .pipe(gulp.dest('./css/'));
});

gulp.task('images', function () {
    return gulp.src('assets/img/**/*')
        .pipe(newer('./img/'))
        .pipe(imagemin({optimizationLevel: 5}))
        .pipe(gulp.dest('./img/'));
});

gulp.task('js', function () {
    return gulp.src('assets/js/*.js')
        .pipe(order([
            'global.js'
        ]))
        .pipe(concat('global.js'))
        .pipe(minify({
            ext:{
                src:'-debug.js',
                min:'.js'
            }
        }))
        .pipe(gulp.dest('./js/'));
});

gulp.task('watch', ['styles', 'images', 'js'], function () {
    gulp.watch('assets/scss/*.scss', ['styles']);
    gulp.watch('assets/img/**/*', ['images']);
    gulp.watch('assets/js/*.js', ['js']);
});

gulp.task('default', ['watch', 'styles', 'images', 'js']);