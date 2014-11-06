module.exports = function(grunt) {
  	
	/*
		Setup actions
	*/
  	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		concat: {
			options: {
				separator: ';'
			},
			dist: {
				src: ['assets/src/js/plugins.js', 'assets/src/js/main.js'],
				dest: 'assets/dist/js/build.js'
			},
			shiv: {
				src: 'assets/src/js/vendor/html5shiv.min.js',
				dest: 'assets/dist/js/html5shiv.min.js'
			},
			music: {
				src: ['assets/src/js/vendor/underscore.js', 'assets/src/js/vendor/quest.js', 'assets/src/js/music.js'],
				dest: 'assets/dist/js/music.js'
			}
		},

		sass: {
			dist: {
				options: {
					style: 'expanded'
				},
				files: {
					'assets/dist/css/screen.css': 'assets/src/styles/screen.scss'
				}
			},
			ie: {
				files: {
					'assets/dist/css/ie8.css': 'assets/src/styles/ie8.scss'
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
				tasks: 'concat'
			},
			styles: {
				files: 'assets/src/styles/**/*',
				tasks: ['sass', 'autoprefixer']
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
		        proxy: 'aurer-kirby:8080',
		        watchTask: true
		    }
		}
	});


  	/*
		Load NPM Tasks
  	*/
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-browser-sync');
	grunt.loadNpmTasks('grunt-svg2png');

	/*
		Setup the tasks
	*/
	grunt.registerTask('default', ['sass', 'concat', 'browserSync', 'watch']);
};