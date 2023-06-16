const gulp = require('gulp');
const sass = require('gulp-dart-sass');
const bs   = require('browser-sync');
const $ = require('gulp-load-plugins')();

const rootPaths = {
  "htmlRoot" : "./**/*.html",
  "sassRoot" : "./assets/sass/**/*.scss",
  "cssRoot" : "./assets/css/**/*.css",
  "cssDirectly" : ["./assets/css/*.css","!./assets/css/*.min.css"],
  "jsRoot" : "./assets/js/**/*.js",
  "jsDirectly" : ["./assets/js/*.js","!./assets/js/*.min.js"],
}

// browserSync
gulp.task( 'bs' , function(){
  return bs.init({
    server: {
        baseDir: "./"
      },
      filer: [rootPaths.htmlRoot,rootPaths.cssRoot]
  });
});

/* Sass 
 * ベンダープレフィクス自動付与、圧縮リネーム
 */
gulp.task( 'sass' , function(){
  return gulp.src( rootPaths.sassRoot )
    .pipe($.plumber())
    .pipe(sass())
    .pipe(gulp.dest('./assets/css/'))
    .pipe(bs.reload({
      stream: true,
      once  : true
    }));
});

/* css
 * 圧縮リネーム
 */
gulp.task('css-minify', function() {
  return gulp.src( rootPaths.cssDirectly )
    .pipe($.plumber())
    .pipe($.cleanCss())
    .pipe($.rename({suffix: '.min'}))
    .pipe(gulp.dest('./assets/css/')); // 圧縮後のファイルの保存場所、案件によって変わる場合はここを書き換える
});

/* js 
 * 圧縮リネーム
 */
gulp.task('js-minify', function() {
  return gulp.src( rootPaths.jsDirectly )
    .pipe($.babel({
      presets: ['@babel/preset-env']
    }))
    .pipe($.plumber())
    .pipe($.uglify())
    .pipe($.rename({suffix: '.min'}))
    .pipe(gulp.dest('./assets/js/')); // 圧縮後のファイルの保存場所、案件によって変わる場合はここを書き換える
});

// ブラウザリロード
gulp.task('bs-reload', function () {
    bs.reload();
});

// watchタスク
gulp.task( 'watch' , function(){
  gulp.watch( rootPaths.sassRoot , gulp.task('sass'));
  gulp.watch( rootPaths.htmlRoot , gulp.task('bs-reload'));
  gulp.watch( rootPaths.cssDirectly , gulp.task('css-minify'));
  gulp.watch( rootPaths.jsDirectly , gulp.task('js-minify'));
});

// defaultで実行
gulp.task('default', gulp.parallel('watch','sass','bs-reload','bs','css-minify','js-minify'));