/*---------- Declare gulp variables ----------*/

	var gulp        = require('gulp'),
		livereload  = require('gulp-livereload'),
		clean       = require('gulp-clean'),
		rev         = require('gulp-rev'),
		uglify      = require('gulp-uglify'),
		minifycss   = require('gulp-minify-css'),
		sass        = require('gulp-sass'),
		notify      = require("gulp-notify"),
		concat      = require("gulp-concat"),
		prefix      = require("gulp-autoprefixer"),
		plumber      = require("gulp-plumber"),
		imagemin    = require('gulp-imagemin');


/*---------- Declare paths ----------*/

	var paths = {
		src : {
			css: 			'./assets/src/styles/screen.scss',
			js:             ['./assets/src/js/plugins.js', './assets/src/js/main.js'],
			gfx: 			'./assets/src/gfx/*',
		},
		dist : {
			css:            './assets/dist/css',
			js:             './assets/dist/js',
			gfx: 			'./assets/dist/gfx',
		},
		watch : {
			styles: 		'./assets/src/styles/*',
			css: 			'./assets/dist/css/*.css',
			js:             './assets/src/js/*',
			jsDist:         './assets/dist/js/*',
			gfx: 			'./assets/src/gfx/*',
			files: 			['./site/templates/*', './site/snippets/*', './content/**'],
		}
	};


/*---------- Tasks ----------*/

	// Styles
	gulp.task('styles', function(){
		return gulp.src(paths.src.css)
			.pipe(sass({
				errLogToConsole: true,
				onError: function(err){
					console.log('sass error:', err);
					gulp.src(paths.cssIn).pipe(notify({
						title: 'Sass error',
						message: err
					}));
				}
			}))
			.pipe(prefix('last 2 versions'))
			.pipe(minifycss())
			.pipe(gulp.dest(paths.dist.css))
	});

	// Scripts
	gulp.task('scripts', function(){		
		return gulp.src(paths.src.js)
			.pipe(plumber())
			.pipe(concat('build.js'))
			.pipe(uglify())
			.pipe(gulp.dest(paths.dist.js));
	});

	// Revision
	gulp.task('rev_css', function() {
		gulp.src(paths.dist.css + '/*.css', {read: false})
		    .pipe(clean());

		gulp.src(paths.src.css)
			.pipe(sass({
				errLogToConsole: true,
				onError: function(err){
					console.log('sass error:', err);
					gulp.src(paths.cssIn).pipe(notify({
						title: 'Sass error',
						message: err
					}));
				}
			}))
			.pipe(prefix('last 2 versions'))
			.pipe(minifycss())
			.pipe(rev())
			.pipe(gulp.dest(paths.dist.css))
			.pipe(rev.manifest())
			.pipe(gulp.dest(paths.dist.css))
	});
	

	// Images
	 gulp.task('gfx', function(){
		return gulp.src(paths.src.gfx)
			.pipe(imagemin({
				optimizationLevel: 5,
				progressive: true,
				interlaced: true
			}))
			.pipe(gulp.dest(paths.dist.gfx));
	});

	// Clean Build Folder
	gulp.task('clean', function() {
		gulp.src([paths.dist.css, paths.dist.js, paths.dist.gfx], {read: false}).pipe(clean());
		gulp.start('styles', 'scripts', 'gfx');
	});

	// Watch Files For Changes & Livereload
	gulp.task('watch', function() {
		var server = livereload();
		
		// Recompile styles
		gulp.watch(paths.watch.styles, ['styles']);
		
		// Compile scripts
		gulp.watch(paths.watch.js, ['scripts']);
		
		// Process images
		gulp.watch(paths.watch.gfx, ['gfx']);

		// Live reload
		gulp.watch([paths.watch.css, paths.watch.jsDist, paths.watch.files]).on('change', function(file) {
			server.changed(file.path);
		});
	});


/*---------- Environements Tasks ----------*/

	// Default Task
	gulp.task('default',['gfx','watch']);
	
	// Build Task
	gulp.task('build', ['clean', 'rev_css', 'gfx']);