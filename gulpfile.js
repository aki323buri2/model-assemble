var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();

var prefix = {
	browsers: [
		'last 2 versions', 
		'> 1%', 
	]
};

gulp.task('vendor', function ()
{
	gulp.src('bower_components/**/*.*', { base: 'bower_components' })
		.pipe(gulp.dest('public/vendor'))
	;
});
gulp.task('bs4', function ()
{
	gulp.src('src/bootstrap/bootstrap-custom.scss')
		.pipe(plugins.plumber())
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.sass({
			includePaths: ['bower_components/bootstrap/scss']
		}))
		.on('error', function ()
		{
			plugins.sass.logError();
		})
		.pipe(plugins.autoprefixer(prefix))
		.pipe(plugins.sourcemaps.write('.'))
		.pipe(gulp.dest('public/build/bootstrap/dist/css'))
		.on('end', function ()
		{
			console.log('bootstrap-custom.scss compilation finished!!');
		})
	;
});
gulp.task('watch', function ()
{
	gulp.watch('src/bootstrap/**/*.*', ['bs4']);
});