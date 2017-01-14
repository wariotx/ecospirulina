/* jshint node:true */
module.exports = function( grunt ) {
	'use strict';

	grunt.initConfig({

		// JavaScript linting with JSHint.
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'assets/js/*.js',
				'!assets/js/*.min.js',
				'assets/js/admin/welcome-screen/*.js',
				'!assets/js/admin/welcome-screen/*.min.js',
				'assets/js/customizer/*.js',
				'!assets/js/customizer/*.min.js',
				'assets/js/woocommerce/*.js',
				'!assets/js/woocommerce/*.min.js'
			]
		},

		// Minify .js files.
		uglify: {
			options: {
				preserveComments: 'some'
			},
			main: {
				files: [{
					expand: true,
					cwd: 'assets/js/',
					src: [
						'*.js',
						'!*.min.js'
					],
					dest: 'assets/js/',
					ext: '.min.js'
				}]
			},
			admin: {
				files: [{
					expand: true,
					cwd: 'assets/js/admin/welcome-screen/',
					src: [
						'*.js',
						'!*.min.js'
					],
					dest: 'assets/js/admin/welcome-screen/',
					ext: '.min.js'
				}]
			},
			woocommerce: {
				files: [{
					expand: true,
					cwd: 'assets/js/woocommerce/',
					src: [
						'*.js',
						'!*.min.js'
					],
					dest: 'assets/js/woocommerce/',
					ext: '.min.js'
				}]
			}
		},

		// Compile all .scss files.
		sass: {
			dist: {
				options: {
					require: 'susy',
					sourcemap: 'none',
					includePaths: require( 'node-bourbon' ).includePaths
				},
				files: [
				    {src: 'style.scss', expand: true, ext: '.css'},
					{src: 'assets/sass/woocommerce/woocommerce.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/admin/welcome-screen/welcome.scss', expand: true, ext: '.css'},
                    {src: 'assets/sass/admin/welcome-screen/welcome.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/woocommerce/extensions/bookings.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/woocommerce/extensions/brands.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/woocommerce/extensions/wishlists.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/woocommerce/extensions/ajax-layered-nav.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/woocommerce/extensions/variation-swatches.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/woocommerce/extensions/composite-products.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/woocommerce/extensions/photography.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/woocommerce/extensions/product-reviews-pro.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/woocommerce/extensions/smart-coupons.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/woocommerce/extensions/deposits.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/woocommerce/extensions/bundles.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/woocommerce/extensions/ship-multiple-addresses.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/woocommerce/extensions/advanced-product-labels.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/woocommerce/extensions/mix-and-match.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/woocommerce/extensions/quick-view.scss', expand: true, ext:'.css'},
                    {src: 'assets/sass/jetpack/jetpack.scss', expand: true, ext:'.css'}
				]
			}
		},

		// Minify all .css files.
		cssmin: {
			options: {
				keepSpecialComments: 1
			},
			main: {
				files: {
					'style.min.css': 'style.css',
				}
			},
			admin: {
				expand: true,
				cwd: 'assets/sass/admin/welcome-screen/',
				src: ['*.css'],
				dest: 'assets/sass/admin/welcome-screen/',
				ext: '.min.css'
			},
			jetpack: {
				expand: true,
				cwd: 'assets/sass/jetpack/',
				src: ['*.css'],
				dest: 'assets/sass/jetpack/',
				ext: '.min.css'
			},
			woocommerce: {
				expand: true,
				cwd: 'assets/sass/woocommerce/',
				src: ['*.css'],
				dest: 'assets/sass/woocommerce/',
				ext: '.min.css'
			}
		},

		// Watch changes for assets.
		watch: {
			css: {
				files: [
					'style.scss',
					'assets/sass/admin/welcome-screen/*.scss',
					'assets/sass/woocommerce/*.scss',
					'assets/sass/jetpack/*.scss',
					'assets/sass/base/*.scss',
					'assets/sass/components/*.scss',
					'assets/sass/utils/*.scss',
					'assets/sass/vendors/*.scss'
				],
				tasks: [
					'sass',
					'css'
				]
			},
			js: {
				files: [
					// main js
					'assets/js/*js',
					'!assets/js/*.min.js',

					// admin js
					'assets/js/admin/welcome-screen/*js',
					'!assets/js/admin/welcome-screen/*.min.js',

					// customizer js
					'assets/js/customizer/*js',
					'!assets/js/customizer/*.min.js',

					// WooCommerce js
					'assets/js/woocommerce/*js',
					'!assets/js/woocommerce/*.min.js'
				],
				tasks: ['jshint', 'uglify']
			}
		},

		// Generate POT files.
		makepot: {
			options: {
				type: 'wp-theme',
				domainPath: 'languages',
				potHeaders: {
					'report-msgid-bugs-to': 'https://github.com/woothemes/storefront/issues',
					'language-team': 'LANGUAGE <EMAIL@ADDRESS>'
				}
			},
			frontend: {
				options: {
					potFilename: 'storefront.pot',
					exclude: [
						'storefront/.*' // Exclude deploy directory
					]
				}
			}
		},

		// Check textdomain errors.
		checktextdomain: {
			options:{
				text_domain: 'storefront',
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			},
			files: {
				src:  [
					'**/*.php', // Include all files
					'!node_modules/**' // Exclude node_modules/
				],
				expand: true
			}
		},

		// Creates deploy-able theme
		copy: {
			deploy: {
				src: [
					'**',
					'!.*',
					'!*.md',
					'!.*/**',
					'.htaccess',
					'!Gruntfile.js',
					'!package.json',
					'!node_modules/**',
					'!.DS_Store',
					'!npm-debug.log'
				],
				dest: 'storefront-deploy',
				expand: true,
				dot: true
			},
            copyAssets: {
                src: [
                	'style.scss',
                    'assets/sass/**',
                    'assets/fonts/**',
                    '!*.php',
                    '!*.js',
                    '!*.css',
                    '!.*',
                    '!*.md',
                    '!.*/**',
                    '.htaccess',
                    '!Gruntfile.js',
                    '!package.json',
                    '!node_modules/**',
                    '!.DS_Store',
                    '!npm-debug.log'
                ],
                dest: '',
                cwd: '../storefront/',
                expand: true,
                dot: true
            }
		},

		// RTLCSS
		rtlcss: {
			options: {
				config: {
					swapLeftRightInUrl: false,
					swapLtrRtlInUrl: false,
					autoRename: false,
					preserveDirectives: true
				},
				properties : [
					{
						name: 'swap-fontawesome-left-right-angles',
						expr: /content/im,
						action: function( prop, value ) {
							if ( value === '"\\f105"' ) { // fontawesome-angle-left
								value = '"\\f104"';
							}
							if ( value === '"\\f178"' ) { // fontawesome-long-arrow-right
								value = '"\\f177"';
							}
							return { prop: prop, value: value };
						}
					}
				]
			},
			main: {
				expand: true,
				ext: '-rtl.css',
				src: [
					'style.css',
					'assets/sass/woocommerce/extensions/bookings.css',
					'assets/sass/woocommerce/extensions/brands.css',
					'assets/sass/woocommerce/extensions/wishlists.css',
					'assets/sass/woocommerce/extensions/ajax-layered-nav.css',
					'assets/sass/woocommerce/extensions/variation-swatches.css',
					'assets/sass/woocommerce/extensions/composite-products.css',
					'assets/sass/woocommerce/extensions/photography.css',
					'assets/sass/woocommerce/extensions/product-reviews-pro.css',
					'assets/sass/woocommerce/extensions/smart-coupons.css',
					'assets/sass/woocommerce/extensions/deposits.css',
					'assets/sass/woocommerce/extensions/bundles.css',
					'assets/sass/woocommerce/extensions/ship-multiple-addresses.css',
					'assets/sass/woocommerce/extensions/advanced-product-labels.css',
					'assets/sass/woocommerce/extensions/mix-and-match.css',
					'assets/sass/woocommerce/extensions/quick-view.css',
					'assets/sass/woocommerce/woocommerce.css',
					'assets/sass/admin/welcome-screen/welcome.css',
					'assets/sass/jetpack/jetpack.css'
				]
			}
		}
	});

	// Load NPM tasks to be used here
	grunt.loadNpmTasks( 'grunt-contrib-jshint' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-cssmin' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-wp-i18n' );
	grunt.loadNpmTasks( 'grunt-checktextdomain' );
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-rtlcss' );

	// Register tasks
	grunt.registerTask( 'default', [
		'css',
		'jshint',
		'uglify'
	]);

	grunt.registerTask( 'css', [
		'sass',
		'cssmin',
		'rtlcss'
	]);

	grunt.registerTask( 'dev', [
		'default',
		'makepot'
	]);

	grunt.registerTask( 'deploy', [
		'copy:deploy'
	]);

    grunt.registerTask( 'init', [
        'copy:copyAssets'
    ]);
};
