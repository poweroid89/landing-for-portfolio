import { src, dest, watch, series, parallel } from 'gulp';
import * as dartSass from 'sass';
import gulpSass from 'gulp-sass';
const sass = gulpSass(dartSass);
import autoprefixer from 'gulp-autoprefixer';
import cleanCSS from 'gulp-clean-css';
import uglify from 'gulp-uglify';
import concat from 'gulp-concat';
import sourcemaps from 'gulp-sourcemaps';
import browserSyncLib from 'browser-sync';
const browserSync = browserSyncLib.create();
import { deleteAsync } from 'del';

// THEME & SRC PATHS
const THEME_PATH = './theme';
const SRC_PATH = './src';

// 1. CLEAN
export async function clean() {
    return deleteAsync([`${THEME_PATH}/assets/css/`, `${THEME_PATH}/assets/js/`], { force: true });
}

// 2. MAIN BUNDLE CSS (Global styles)
export function stylesMain() {
    return src(`${SRC_PATH}/scss/main.scss`)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(cleanCSS())
        .pipe(sourcemaps.write('.'))
        .pipe(dest(`${THEME_PATH}/assets/css/`))
        .pipe(browserSync.stream());
}

// 3. BLOCK STYLES (One CSS per block)
export function stylesBlocks() {
    return src(`${THEME_PATH}/blocks/**/*.scss`)
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(cleanCSS())
        .pipe(sourcemaps.write('.'))
        .pipe(dest(`${THEME_PATH}/assets/css/`))
        .pipe(browserSync.stream());
}

// 4. SCRIPTS
export function scripts() {
    // Main script
    src(`${SRC_PATH}/js/main.js`)
        .pipe(sourcemaps.init())
        .pipe(concat('main.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('.'))
        .pipe(dest(`${THEME_PATH}/assets/js/`));

    // Block scripts
    return src(`${THEME_PATH}/blocks/**/*.js`)
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(sourcemaps.write('.'))
        .pipe(dest(`${THEME_PATH}/assets/js/`))
        .pipe(browserSync.stream());
}

// 5. SERVE
export function serve(done) {
    browserSync.init({
        proxy: "localhost:8082",
        notify: false,
    });
    done();
}

// 6. WATCH
export function watchFiles() {
    watch(`${SRC_PATH}/scss/**/*.scss`, stylesMain);
    watch(`${THEME_PATH}/blocks/**/*.scss`, stylesBlocks);
    watch([`${SRC_PATH}/js/**/*.js`, `${THEME_PATH}/blocks/**/*.js`], scripts);
    watch(`${THEME_PATH}/**/*.php`).on('change', browserSync.reload);
}

// TASKS
export const build = series(clean, parallel(stylesMain, stylesBlocks, scripts));
export default series(clean, parallel(stylesMain, stylesBlocks, scripts), serve, watchFiles);
