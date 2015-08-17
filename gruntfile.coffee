module.exports = (grunt) ->
	grunt.initConfig {
		# Main options
		srcDir: 'assets'
		distDir: 'public/assets'
		proxy: 'aurer.dev'

		# Load packages
		pkg: grunt.file.readJSON 'package.json'

		##############
		# Define tasks
		##############

		clean : {
			build: ['<%= distDir %>/*']
		}

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
				beautify: true
			}
			main: {
				files: {
					'<%= distDir %>/js/build.js': [
						'<%= srcDir %>/js/vendor/promise.js'
						'<%= srcDir %>/js/vendor/underscore.js'
						'<%= srcDir %>/js/music.js'
						'<%= srcDir %>/js/main.js'
					]
				}
			}
			shiv: {
				files: {
					'<%= distDir %>/js/html5shiv.min.js': '<%= srcDir %>/js/vendor/html5shiv.min.js'
				}
			}
		}

		imagemin: {
			dynamic: {
				files: [{
					expand: true
					optimizationLevel: 4
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
				src : [
					'<%= distDir %>/css/*.css',
					'<%= distDir %>/js/*.js',
					'../site/**/*.php'
				]
			},
			options: {
				proxy: '<%= proxy %>'
				watchTask: true
				notify: false
			}
		}

		filerev: {
			css: {
				src: ['<%= distDir %>/css/*.css']
			}
			js: {
				src: ['<%= distDir %>/js/build.js']
			}
		}

		assetsReplace: {
			options: {
				manifest: '<%= distDir %>/manifest.json'
			}
			files: {
				'<%= distDir %>': ['<%= distDir %>/**/*']
			}
		}
	}

	grunt.loadNpmTasks 'assetflow'
	grunt.loadNpmTasks 'grunt-autoprefixer'
	grunt.loadNpmTasks 'grunt-browser-sync'
	grunt.loadNpmTasks 'grunt-contrib-clean'
	grunt.loadNpmTasks 'grunt-contrib-imagemin'
	grunt.loadNpmTasks 'grunt-contrib-less'
	grunt.loadNpmTasks 'grunt-contrib-uglify'
	grunt.loadNpmTasks 'grunt-contrib-watch'
	grunt.loadNpmTasks 'grunt-filerev'

	grunt.registerTask('default', ['less', 'autoprefixer', 'uglify', 'imagemin'])
	grunt.registerTask('dev', ['clean', 'less', 'browserSync', 'watch'])
	grunt.registerTask('build', ['clean', 'less', 'autoprefixer', 'uglify', 'imagemin', 'assetsReplace'])