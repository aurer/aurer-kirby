module.exports = function(grunt) {
  	
	/*
		Setup actions
	*/
  	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		uglify: {
			options: {
				beautify: true
			},
			dist: {
				files: {
					'assets/dist/js/build.js': ['assets/src/js/plugins.js', 'assets/src/js/vendor/quest.js', 'assets/src/js/main.js']
				}
			},
			shiv: {
				files: {
					'assets/dist/js/html5shiv.min.js': 'assets/src/js/vendor/html5shiv.min.js'
				}
			},
			music: {
				files: {
					'assets/dist/js/music.js': ['assets/src/js/vendor/underscore.js', 'assets/src/js/music.js']		
				}
			}
		},

		less: {
			options: {
				compress: true,
				sourceMap: true,
				sourceMapRootpath: '/'
			},
			dist: {
				files: {
					'assets/dist/css/screen.css': 'assets/src/styles/screen.less'
				},
				options: {
					sourceMapURL: '/assets/dist/css/screen.css.map'
				}
			},
			ie: {
				files: {
					'assets/dist/css/ie8.css': 'assets/src/styles/ie8.less'
				},
				options: {
					sourceMapURL: '/assets/dist/css/ie8.css.map'
				}
			}
		},

		autoprefixer: {
			options: {
				browsers: ['last 2 version', 'ie 8', 'ie 9']
			},
			files:{
				expand: true,
      			flatten: true,
				src: 'assets/dist/css/*.css',
				dest: 'assets/dist/css/'
			}
		},

		imagemin: {
			dynamic: {
				files: [{
					expand: true,
					optimizationLevel: 7,
					cwd: 'assets/src/gfx/',
					src: ['**/*'],
					dest: 'assets/dist/gfx'
				}]
			}
		},

		svg2png: {
	        all: {
	            files: [
	                { 
	                	src: 'assets/dist/gfx/*.svg'
	                },
	            ]
	        }
	    },

		watch: {
			scripts: {
				files: 'assets/src/js/**/*',
				tasks: ['uglify']
			},
			styles: {
				files: 'assets/src/styles/**/*',
				tasks: ['less', 'autoprefixer']
			},
			images: {
				files: 'assets/src/gfx/**/*',
				tasks: ['imagemin', 'svg2png']
			},
			grunt: {
				files: 'gruntfile.js'
			}
		},

		browserSync: {
		    bsFiles: {
		        src : ['assets/dist/css/*.css', 'content/**/*', 'site/templates/*.php']
		    },
		    options: {
		        proxy: 'v2.aurer.dev',
		        watchTask: true,
		        ghostMode: {
				    clicks: true,
				    location: false,
				    forms: true,
				    scroll: false
				}
		    }
		}
	});


  	/*
		Load NPM Tasks
  	*/
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-contrib-less');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-browser-sync');
	grunt.loadNpmTasks('grunt-svg2png');

	/*
		Setup the tasks
	*/
	grunt.registerTask('default', ['less', 'uglify', 'browserSync', 'watch']);
};