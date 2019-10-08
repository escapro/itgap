const gulp = require('gulp');
const rename = require('gulp-rename');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const browserSync = require('browser-sync');
const javascriptObfuscator = require('gulp-javascript-obfuscator');

const autoprefixBrowsers = ['> 1%', 'last 2 versions', 'firefox >= 4', 'safari 7', 'safari 8', 'IE 8', 'IE 9', 'IE 10', 'IE 11', 'iOS 7'];

function compileSass(done) {
    gulp.src('./resources/scss/**/*.scss')
        .pipe(sass({
            errorLogToConsole: true,
            outputStyle: 'compressed'
        }))
        .on('error', console.error.bind(console))
        .pipe( autoprefixer({
            overrideBrowserslist: ['last 99 versions'],
            cascade: false
        }) )
        .pipe( rename({suffix: '.min'}) )
        .pipe( gulp.dest('./public/media/css/') )
        .pipe( browserSync.stream() );

    done();
}

function watchFiles() {
    gulp.watch("./resources/scss/**/*", compileSass);
    gulp.watch("./resources/js/**/*.js", abfuscateJs);
    gulp.watch("./application/**/*.php", browserRealod);
    gulp.watch("./application/**/*.html", browserRealod);
}

function browserRealod(done) {
    browserSync.reload();
    done();
}

function liveReload(done) {
    browserSync.init({
       proxy: "itgap/",
       port: 3000 
    });
}

function abfuscateJs(done) {
    gulp.src('./resources/js/**/*.js')
    .pipe(javascriptObfuscator())
    .pipe( rename({suffix: '.min'}) )
    .pipe(gulp.dest('./public/media/js/'));

    browserSync.reload();
    done();
}

gulp.task('default', gulp.parallel(liveReload, watchFiles));