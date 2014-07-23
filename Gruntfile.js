module.exports = function(grunt) {
  var merge = require('merge-recursive');
  var env = process.env.APP_ENV || 'dev';
  var fs = require('fs');

  // Define the gruntConfig.
  var gruntConfig = {
    pkg: grunt.file.readJSON('package.json'),

    // App configurations
    meta: {
      env: env,
      tmp: 'tmp/grunt',
      chauffeur: {
		// When running grunt from outside vagrant (default),
		// allow http connections from localhost:8000
		// and proxy to the vagrant port forward for apache.
      	bind: {
      		host: '127.0.0.1',
      		port: 9000  // 8000 would conflict with vagrants port forward for this service.
      	},
      	proxy: {
			host: '127.0.0.1',
			port: 8080
      	}
      },
      src: {
        base: 'webroot/js',
        app: '<%= meta.src.base %>/app',
        vendor: '<%= meta.src.base %>/vendor',
        tests: '<%= meta.src.base %>/test',
        templates: '<%= meta.src.base %>/template',
        config: '<%= meta.src.base %>/config',
        css: 'webroot/css'
      },
      build: {
        base: 'webroot/assets',
        app: '<%= meta.build.base %>/app.js',
        vendor: '<%= meta.build.base %>/lib.js',
        tests: '<%= meta.build.base %>/tests.js',
        templates: '<%= meta.build.base %>/templates.js',
        css: '<%= meta.build.base %>/app.css'
      }
    },

	// Environment-specific overrides. Will be merged on top of meta:{} based on the value of the APP_ENV environment variable. (Default: none)
	overrides: {
	  vagrant: {
        chauffeur: {
	      // When running grunt from INSIDE vagrant (SLOW!),
          // allow http connections from anywhere
          // (via the vagrant port forward for host:9000 -> vm:8000).
          // and proxy to the local VM-internal apache instance.
          bind: {
            host: '0.0.0.0',
          },
          proxy: {
            port: 8000  // Inside the VM, use 8000 so vagrant forwards to us properly.
          }
        }
      }
	},

    // Run time environment modifications
    config: {
      dev: {
        options: {
          variables: {
            'meta.env': 'dev',
            'fabricate.app.sourceMap': false,  // Would be nice if this worked when `true`.
            'fabricate.lib.sourceMap': false   // this too.
          }
        }
      },
      prod: {
        options: {
          variables: {
            'meta.env': 'prod',
            'fabricate.app.sourceMap': false,
            'fabricate.lib.sourceMap': false
          }
        }
      }
    },


    // Build tasks
    fabricate: {
      app: {
        src: '<%= meta.src.app %>/app.js',
        dest: '<%= meta.build.app %>',
        include: [
          '<%= meta.src.app %>',
          '<%= meta.src.config %>/<%= meta.env %>',
          '<%= meta.src.config %>/common'
        ],
        tmpDir: '<%= meta.tmp %>/fabricate'
      },
      lib: {
        src: '<%= meta.src.app %>/lib.js',
        dest: '<%= meta.build.vendor %>',
        include: [
          '<%= meta.src.vendor %>/<%= meta.env %>',
          '<%= meta.src.vendor %>/common',
          '<%= meta.src.config %>/<%= meta.env %>',
          '<%= meta.src.config %>/common'
        ],
        tmpDir: '<%= meta.tmp %>/fabricate'
      },
      tests: {
        src: '<%= meta.src.tests %>/runner.js',
        dest: '<%= meta.build.tests %>',
        include: ['<%= meta.src.tests %>'],
        tmpDir: '<%= meta.tmp %>/fabricate'
      }
    },

    emberTemplates: {
      compile: {
        options: {
          templateName: function(sourceFile) {
            return sourceFile.replace(/webroot\/js\/template\//, '');
          }
        },
        files: {
          '<%= meta.build.templates %>': '<%= meta.src.templates %>/**/*.{handlebars,hbs}'
        }
      }
    },

    less: {
      options: {
        paths: ['<%= meta.src.css %>'],
      },
      build: {
        src: '<%= meta.src.css %>/app.less',
        dest: '<%= meta.build.css %>'
      }
    },


    // Delivery
    chauffeur: {
      dev: {
      	host: '<%= meta.chauffeur.bind.host %>', // previously '0.0.0.0'
        port: '<%= meta.chauffeur.bind.port %>',  // previously 8000
        // routes: 'routes.js',
        staticFiles: [
          '<%= meta.tmp %>/fabricate',
          'webroot'
        ],
        lockfile: 'tmp/chauffeur.lock',
        testable: {
          route: 'test.html',
          files: [
            '<%= meta.build.css %>',
            '<%= meta.src.vendor %>/common/ember_testing_ui.js',
            '<%= meta.src.vendor %>/common/ember_testing_ui.css',
            '<%= meta.build.vendor %>',
            '<%= meta.build.templates %>',
            '<%= meta.build.app %>',
          ],
          tests: [
            '<%= meta.build.tests %>',
          ],
          transformPath: function(pathName) {
            if (new RegExp('^webroot').test(pathName)) {
              pathName = pathName.replace('webroot/', '');
            }
            if (new RegExp('^test').test(pathName)) {
              pathName = pathName.replace('test/', '');
            }
            return pathName;
          }
        },
        proxy: [
          {
          	host: '<%= meta.chauffeur.proxy.host %>',  // previously '127.0.0.1'
          	port: '<%= meta.chauffeur.proxy.port %>'  // previously 80
          }
        ]
      }
    },


    // Optimizations
    uglify: {
      app: {
        src:  '<%= meta.build.app %>',
        dest: '<%= meta.build.app %>'
      },
      templates: {
        src:  '<%= meta.build.templates %>',
        dest: '<%= meta.build.templates %>'
      }
    },

    cssmin: {
      app: {
        src: '<%= meta.build.css %>',
        dest: '<%= meta.build.css %>'
      }
    },


    // Utility
    clean: {
      build: '<%= meta.build.base %>/*',
      fabricate: '<%= meta.tmp %>/fabricate'
    },

    jshint: {
      options: {
        curly: true,
        eqeqeq: true,
        eqnull: true,
        browser: true,
        globals: {
          jQuery: true,
          $: true,
          Ember: true,
          Em: true,
          App: true
        },
        '-W018': true, // Ignore "Confusing use of '!'"
      },
      dev: {
        src: '<%= meta.src.app %>/**/*.js'
      },
      build: {
        src: '<%= meta.build.app %>'
      }
    },

    encase: {
      build: {
        src: '<%= meta.build.app %>',
        dest: '<%= meta.build.app %>',
        separator: '',
        params: { window: 'window', jQuery: '$', Ember: 'Ember', Em: 'Em' },
        exports: [],
        // useStrict: true, // Add 'use strict' to top of function. Should experiment
      }
    },

    watch: {
      app: {
        files: ['<%= meta.src.app %>/**/*.js', '!<%= meta.src.app %>/lib.js'],
        tasks: ['config:dev', 'fabricate:app']
      },
      lib: {
        files: ['<%= meta.src.vendor %>/**/*.js', '<%= meta.src.app %>/lib.js'],
        tasks: ['config:dev', 'fabricate:lib']
      },
      templates: {
        files: ['<%= meta.src.templates %>/**/*.{handlebars,hbs}'],
        tasks: ['config:dev', 'emberTemplates']
      },
      styles: {
        files: ['<%= meta.src.css %>/**/*.{css,less}'],
        tasks: ['config:dev', 'build:css'],
        options: {
          livereload: false
        },
      },
      php: {
        files: [
          '!Lib/Cake/**/*.php',
          '!Vendor/**/*.php',
          '**/*.php'
        ],
        tasks: 'null'
      },
      tests: {
        files: ['<%= meta.src.tests %>/**/*.js'],
        tasks: ['config:dev', 'fabricate:tests'],
      },
      runner: {
        files: ['<%= meta.build.base %>/*.js'],
        tasks: ['karma:autotest:run']
      }
    },

    focus: {
      dev: {
        exclude: ['runner'] // Use all watch tasks except the runner
      },
      test: {} // Use all watch tasks
    },

    karma: {
      options: {
        configFile: 'Config/karma.conf.js',
        reporters: 'dots',
        autoWatch: false
      },
      autotest: {
        background: true,
        singleRun: false,
        browsers: ['PhantomJS']
      },
      test: {
        singleRun: true,
        browsers: ['PhantomJS']
      },
      integration: {
        singleRun: true,
        browsers: ['Chrome', 'Safari', 'Firefox']
      }
    }
  };

  // Merge env-specific values on top of the default meta configs.
  if (gruntConfig.overrides[env] !== undefined) {
    gruntConfig.meta = merge.recursive(gruntConfig.meta, gruntConfig.overrides[env]);
  }

  // Pass it to grunt.initConfig()
  grunt.initConfig(gruntConfig);

  grunt.event.on('watch', function(action, filepath) {
    if (/\.php$/.test(filepath)) {
      var CakeTestRunner = require('./Console/node/cake_test_runner'),
      file = new CakeTestRunner(filepath);
      if (fs.existsSync('.vagrant')) {
        file.vagrantHost = true;
      }
      file.exists(function() { file.run(); });
    }
  });

  // Local configurations and runtime modifications
  grunt.loadNpmTasks('grunt-config');
  // Build tasks
  grunt.loadNpmTasks('grunt-ember-templates');
  grunt.loadNpmTasks('grunt-fabricate');
  grunt.loadNpmTasks('grunt-contrib-less');
  // Delivery servers
  grunt.loadNpmTasks('grunt-chauffeur');
  // Optimizations
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  // Utility
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-encase');
  grunt.loadNpmTasks('grunt-focus');
  grunt.loadNpmTasks('grunt-karma');

  grunt.registerTask('null', function() {});

  // Usable tasks from command line
  grunt.registerTask('lock', ['chauffeur:dev:lock']);
  grunt.registerTask('unlock', ['chauffeur:dev:unlock']);

  grunt.registerTask('build:setup', ['clean']);
  grunt.registerTask('build:css', ['less:build']);
  grunt.registerTask('build:templates', ['emberTemplates']);

  grunt.registerTask('prod:js', ['fabricate:app', 'fabricate:lib']);
  grunt.registerTask('dev:js', ['prod:js', 'fabricate:tests']);

  grunt.registerTask('prod:app', ['build:css', 'prod:js', 'build:templates']);
  grunt.registerTask('dev:app', ['build:css', 'dev:js', 'build:templates']);

  grunt.registerTask('optimize', ['cssmin', 'uglify']);


  grunt.registerTask('dev',  ['config:dev', 'build:setup', 'dev:app']);
  grunt.registerTask('prod', ['config:prod', 'build:setup', 'prod:app']);

  grunt.registerTask('run', ['dev', 'chauffeur:dev', 'focus:dev']);
//   grunt.registerTask('autotest', ['dev', 'chauffeur:dev', 'karma:autotest', 'focus:test']);
  grunt.registerTask('test', ['dev', 'karma:test']);
  grunt.registerTask('integration', ['dev', 'karma:integration']);

  grunt.registerTask('build', ['clean', 'jshint:dev', 'prod', 'optimize', 'encase:build']);
  grunt.registerTask('staging', ['clean', 'jshint:dev', 'dev']);

  grunt.registerTask('default', ['run']);
};
