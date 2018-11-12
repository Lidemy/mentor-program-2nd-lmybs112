var gulp = require('gulp')
var sass = require('gulp-sass')
var autoprefixer = require('gulp-autoprefixer')
var cssmin = require('gulp-clean-css')
var babel = require('gulp-babel')
var uglify = require('gulp-uglify-es').default
var rename = require('gulp-rename')
var clean = require('gulp-clean')

// scss編譯加前綴、壓縮
gulp.task('scss', function () {
  gulp.src('src/css/*.scss')
    .pipe(sass())
    .pipe(autoprefixer({
      browsers: ['last 5 version']
    }))
    .pipe(gulp.dest('dist/css'))
    .pipe(cssmin({
      compatibility: 'ie8'
    }))
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('dist/css'))
})
// es6 編譯、壓縮
gulp.task('js', function () {
  gulp.src('src/js/*.js')
    .pipe(babel({
      presets: ['@babel/env']
    }))
    .pipe(uglify())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('dist/js'))
})

// 清空文件夾
gulp.task('clean', function () {
  return gulp.src('dist',
    {
      read: false
    })
    .pipe(clean())
})
