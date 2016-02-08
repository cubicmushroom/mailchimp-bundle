var gulp    = require('gulp'),
    notify  = require('gulp-notify'),
    phpspecTasks = require('gulp-cm-phpspec-tasks');

var phpspecGlob = 'spec/**/*Spec.php';
var srcGlob = 'src/**/*.php';

phpspecTasks.addTasks(gulp, 'CubicMushroom\\Symfony\\MailchimpBundle\\', {bin: 'vendor/bin/phpspec'});

gulp.task('watch', function () {
    gulp.watch([phpspecGlob, srcGlob], ['phpspec']);
});