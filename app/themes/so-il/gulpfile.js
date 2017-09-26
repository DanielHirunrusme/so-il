var gulp = require('gulp');
var sass = require('gulp-sass');
var minify = require('gulp-minify-css');
var watch = require('gulp-watch');
var rename = require('gulp-rename');
var uglify = require('gulp-uglify');
var prefix = require('gulp-autoprefixer');
var imagemin = require('gulp-imagemin');
var concat = require('gulp-concat');
var coffee = require('gulp-coffee');


    
var paths = {
  jsvendor: 'src/js/vendor/*.js',
  js: 'src/js/*.coffee',
  sass: 'src/sass/**/*',
  image: 'src/img/**/*'
}

gulp.task('sass', function(){
  console.log(sass.info);
  gulp.src(paths.sass)
    .pipe(sass({ errLogToConsole: true }))
    .pipe(prefix("last 2 versions", "> 1%", "ie 8", "ie 7"))
    .pipe(minify())
    .pipe(concat('main.min.css'))
    .pipe(gulp.dest('assets/css'))
})

gulp.task('js', function(){
  gulp.src(paths.js)
    .pipe(coffee())
    .pipe(uglify())
    .pipe(concat('scripts.min.js'))
    .pipe(gulp.dest('assets/js'))
})

gulp.task('images', function() {
  gulp.src(paths.image)
    .pipe(imagemin({optimizationLevel: 5}))
    .pipe(gulp.dest('assets/img'));
});

gulp.task('vendor', function() {
  gulp.src(paths.jsvendor)
    .pipe(uglify())
    .pipe(rename({
      extname: ".min.js"
    }))
    .pipe(gulp.dest('assets/js/vendor'));
});

gulp.task('watch', function(){
  gulp.watch(paths.sass, ['sass'])
  gulp.watch(paths.js, ['js'])
  gulp.watch(paths.jsvendor, ['vendor'])
  gulp.watch(paths.image, ['images'])
})

gulp.task('default', ['sass', 'js', 'vendor', 'watch'])
