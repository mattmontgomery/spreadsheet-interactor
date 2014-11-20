var gulp = require('gulp'),
    shell = require('gulp-shell'),
    path = {};

gulp.task('server', shell.task([
        'php -S localhost:8088'
    ],{
        cwd: './public'
    }
));

gulp.task('default', ['server']);
