var gulp        = require('gulp');
var browserSync = require('browser-sync').create();
var sass        = require('gulp-sass');

// Static Server + watching scss/html files
gulp.task('serve', function() {

  browserSync.init({
      proxy: "http://localhost/wordpress/"
  });

var styleWatcher = gulp.watch('src/scss/*.scss');
styleWatcher.on('all', function() {
  return gulp.src("src/scss/*.scss")
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest("src/css"))
    .pipe(browserSync.stream());
});

var contentWatcher = gulp.watch('*.php');
contentWatcher.on('all', browserSync.reload);
//  gulp.watch("src/scss/*.scss", ['sass']);
//  gulp.watch("src/*.html").on('change', browserSync.reload);
});

// Compile sass into CSS & auto-inject into browsers
gulp.task('sass', function() {
  return gulp.src("src/scss/*.scss")
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest("src/css"))
    .pipe(browserSync.stream());
});

gulp.task('default', gulp.series('sass', 'serve'));
