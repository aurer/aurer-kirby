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
				compress: true
				sourceMap: true
				sourceMapRootpath: '/'
			},
			less: {
				files: [{
					expand: true
					cwd: "<%= srcDir %>/less/"
					src: "*.less"
					dest: "<%= distDir %>/css/"
					ext: '.css'
				}]
			}
		}

		pleeease: {
			options: {
				autoprefixer: {'browsers': ['last 2 versions', 'ios 6', 'ie 8', 'ie 9']},
				minifier: true,
				mqpacker: true
				sourcemaps: true,
			},
			files: {
				'<%= distDir %>/css/screen.css': '<%= distDir %>/css/screen.css'
			}
		},

		uglify: {
			main: {
				files: {
					'<%= distDir %>/js/main.js': [
						'<%= srcDir %>/components/svg4everybody.legacy.min.js'
						'<%= srcDir %>/components/ajax/dist/ajax.min.js'
						'<%= srcDir %>/js/plugins.js'
						'<%= srcDir %>/js/main.js'
					]
				}
			}
			music: {
				files: {
					'<%= distDir %>/js/music.js': [
						'<%= srcDir %>/components/underscore/underscore-min.js'
						'<%= srcDir %>/components/jquery/dist/jquery.min.js'
						'<%= srcDir %>/components/backbone/backbone-min.js'
						'<%= srcDir %>/components/jquery-timeago/jquery.timeago.js'
						'<%= srcDir %>/js/music/app.js'
					]
				}
			}
			shiv: {
				files: {
					'<%= distDir %>/js/html5shiv.min.js': '<%= srcDir %>/components/html5shiv/dist/html5shiv.min.js'
				}
			}
		}

		imagemin: {
			dynamic: {
				options: {
					svgoPlugins: [{cleanupIDs: false}]
				}
				files: [{
					expand: true
					optimizationLevel: 4
					cwd: '<%= srcDir %>/images/'
					src: ['**/*']
					dest: '<%= distDir %>/images'
				}]
			}
		}

		filerev: {
			css: {
				src: '<%= distDir %>/css/*.css'
			}
			js: {
				src: '<%= distDir %>/js/*'
			}
		}

		watch: {
			less: {
				files: '<%= srcDir %>/less/**/*.less'
				tasks: ['less', 'pleeease']
			}
			jsMain: {
				files: '<%= srcDir %>/js/*.js'
				tasks: ['uglify:main', 'uglify:shiv']
			}
			jsMusic: {
				files: '<%= srcDir %>/js/music/*.js'
				tasks: ['uglify:music']
			}
			images: {
				files: '<%= srcDir %>/images/*'
				tasks: ['imagemin']
			}
		}

		browserSync: {
			bsFiles: {
				src : [
					'<%= distDir %>/css/*.css'
					'<%= distDir %>/js/*.js'
					'site/**/*.php'
					'content/**/*'
				]
			},
			options: {
				proxy: '<%= proxy %>'
				watchTask: true
				notify: false
			}
		}
	}

	grunt.loadNpmTasks 'grunt-filerev'
	grunt.loadNpmTasks 'grunt-browser-sync'
	grunt.loadNpmTasks 'grunt-contrib-clean'
	grunt.loadNpmTasks 'grunt-contrib-imagemin'
	grunt.loadNpmTasks 'grunt-contrib-less'
	grunt.loadNpmTasks 'grunt-contrib-uglify'
	grunt.loadNpmTasks 'grunt-contrib-watch'
	grunt.loadNpmTasks 'grunt-pleeease'

	# Create a manifest file from filerev summary
	grunt.registerTask('rev-manifest', 'Create a filerev manifest', =>
		grunt.file.write('public/assets/rev-manifest.json', JSON.stringify(grunt.filerev.summary));
	)

	grunt.registerTask('default', ['clean', 'less', 'pleeease', 'uglify', 'imagemin'])
	grunt.registerTask('dev', ['default', 'browserSync', 'watch'])
	grunt.registerTask('build', ['default', 'filerev', 'rev-manifest'])

