const { src, dest, watch, series } = require("gulp");
const browsersync = require("browser-sync").create(),
  sass = require("gulp-sass")(require("sass")),
  rename = require("gulp-rename"),
  autoprefixer = require("autoprefixer"),
  minifycss = require("gulp-minify-css"),
  sourcemaps = require("gulp-sourcemaps"),
  cssnano = require("cssnano"),
  postcss = require("gulp-postcss");

// Default Gulp Task
exports.default = series(scssTask, browsersyncServe, watchTask);

// Sass Task
function scssTask() {
  return src("static/scss/style.scss")
    .pipe(sourcemaps.init())
    .pipe(sass({ style: "expanded" }))
    .pipe(postcss([autoprefixer({ grid: "autoplace" }), cssnano()]))
    .pipe(sourcemaps.write("./"))
    .pipe(dest("./"));
}

function browsersyncServe(cb) {
  browsersync.init({
    proxy: {
      target: "http://milo-media-starter-theme.local",
    },
  });
  cb();
}

function browsersyncReload(cb) {
  browsersync.reload();
  cb();
}

// Watch Task
function watchTask() {
  watch(["*.php", "/templates/*.twig"], browsersyncReload);
  watch(
    ["static/**/*.scss", "/static/*.scss"],
    series(scssTask, browsersyncReload)
  );
}
