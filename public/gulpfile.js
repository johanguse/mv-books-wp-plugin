const gulp = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const concat = require("gulp-concat");
const uglify = require("gulp-uglify");
const postcss = require("gulp-postcss");
const autoprefixer = require("autoprefixer");
const cssnano = require("cssnano");
const rename = require("gulp-rename");
const sourcemaps = require("gulp-sourcemaps");
const wpPot = require("gulp-wp-pot");
const fillPotPo = import('gulp-fill-pot-po');
const browserSync = require("browser-sync").create();

const paths = {
  styles: {
    src: "src/scss/**/*.scss",
    dest: "css/",
  },
  scripts: {
    src: "src/js/**/*.js",
    dest: "js/",
  },
};

function styles() {
  return gulp
    .src(paths.styles.src)
    .pipe(sourcemaps.init())
    .pipe(sass().on("error", sass.logError))
    .pipe(postcss([autoprefixer(), cssnano()]))
    .pipe(
      rename({
        basename: "mvup-books-public",
        suffix: ".min",
      })
    )
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest(paths.styles.dest))
    .pipe(browserSync.stream());
}

function scripts() {
  return gulp
    .src(paths.scripts.src)
    .pipe(sourcemaps.init())
    .pipe(uglify())
    .pipe(concat("mvup-books-public.min.js"))
    .pipe(sourcemaps.write("."))
    .pipe(gulp.dest(paths.scripts.dest))
    .pipe(browserSync.stream());
}

function serve() {
  browserSync.init({
    server: "./",
  });

  watch();
}

function watch() {
  gulp.watch(paths.scripts.src, scripts);
  gulp.watch(paths.styles.src, styles);
  gulp.watch("./*.html").on("change", browserSync.reload);
}

async function makepot() {
  const { default: fillPotPoModule } = await fillPotPo;
  return gulp
    .src(["../**/*.php", "!../node_modules/**"])
    .pipe(
      wpPot({
        domain: "mvup-books",
        package: "MV Books",
      })
    )
    .pipe(gulp.dest("../languages/mvup-books.pot"))
    .pipe(
      fillPotPoModule({
        srcDir: "../languages/",
      })
    )
    .pipe(gulp.dest("../languages/"));
}

const build = gulp.parallel(styles, scripts);

exports.styles = styles;
exports.scripts = scripts;
exports.watch = watch;
exports.serve = serve;
exports.build = build;
exports.makepot = makepot;
exports.default = build;
