module.exports = (grunt) ->
	grunt.initConfig {
		# Main options
		srcDir: '.'
		distDir: '../public/assets'
		proxy: 'aurer.dev'

		# Load packages
		pkg: grunt.file.readJSON 'package.json'

		##############
		# Define tasks
		##############
		less: {
			options: {
				compress: true,
				sourceMap: true,
				sourceMapRootpath: '/'
			}
			dist: {
				files: {
					'<%= distDir %>/css/screen.css': '<%= srcDir %>/less/screen.less'
				}
			}
		}

		autoprefixer: {
			options: {
				browsers: ['last 2 version', 'ie 8', 'ie 9']
			}
			files: {
				expand: true
				flatten: true
				src: '<%= distDir %>/css/*.css'
				dest: '<%= distDir %>/css/'
			}
		}

		uglify: {
			options: {
				beautify: false
			}
			main: {
				files: {
					'<%= distDir %>/js/build.js': ['<%= srcDir %>/js/plugins.js', '<%= srcDir %>/js/vendor/quest.js', '<%= srcDir %>/js/main.js']
				}
			}
			shiv: {
				files: {
					'<%= distDir %>/js/html5shiv.min.js': '<%= srcDir %>/js/vendor/html5shiv.min.js'
				}
			}
			music: {
				files: {
					'<%= distDir %>/js/music.js': ['<%= srcDir %>/js/vendor/underscore.js', '<%= srcDir %>/js/music.js']
				}
			}
		}

		imagemin: {
			dynamic: {
				files: [{
					expand: true
					optimizationLevel: 7
					cwd: '<%= srcDir %>/images/'
					src: ['**/*']
					dest: '<%= distDir %>/images'
				}]
			}
		}

		watch: {
			less: {
				files: '<%= srcDir %>/less/**/*.less'
				tasks: ['less', 'autoprefixer']
			}
			js: {
				files: '<%= srcDir %>/js/*.js'
				tasks: ['uglify']
			}
			grunt: {
				files: 'gruntfile.coffee'
			}
		}

		browserSync: {
			bsFiles: {
					src : ['<%= distDir %>/css/*.css', '<%= distDir %>/js/*.js']
			},
			options: {
				proxy: '<%= proxy %>'
				watchTask: true
				notify: false
				ghostMode: {
					clicks: true,
					location: false,
					forms: true,
					scroll: false
				}
			}
		}
	}

	grunt.loadNpmTasks 'grunt-autoprefixer'
	grunt.loadNpmTasks 'grunt-browser-sync'
	grunt.loadNpmTasks 'grunt-contrib-less'
	grunt.loadNpmTasks 'grunt-contrib-uglify'
	grunt.loadNpmTasks 'grunt-contrib-imagemin'
	grunt.loadNpmTasks 'grunt-contrib-watch'

	grunt.registerTask('default', ['less', 'autoprefixer', 'uglify', 'imagemin'])
	grunt.registerTask('dev', ['less', 'browserSync', 'watch'])
