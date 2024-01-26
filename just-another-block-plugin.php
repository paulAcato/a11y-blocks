<?php
/**
 * This file is read by WordPress to generate the plugin information in the plugin admin area. This file also includes
 * all the dependencies used by the plugin and starts the plugin.
 *
 * @since             1.0.0
 * @package           Just_Another_Block_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Just Another Block Plugin
 * Description:       Enhances the block editor by adding usefully accessible blocks to the block editor.
 * Version:           1.0.0
 * Author:            Paul van Impelen <paulvanimpelen@google.com>
 * Author URI:        https://themeforest.net/search/paulvanimpelen
 * Text Domain:       jabp
 * Domain Path:       /languages
 */


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

defined( 'YABP_VERSION' ) or define( 'YABP_VERSION', '1.0.0' );
defined( 'YABP_BASENAME' ) or define( 'YABP_BASENAME', plugin_basename( __FILE__ ) );
defined( 'YABP_DIR' ) or define( 'YABP_DIR', plugin_dir_path( __FILE__ ) );
defined( 'YABP_URI' ) or define( 'YABP_URI', plugin_dir_url( __FILE__ ) );
defined( 'YABP_WP_REQUIRED_VERSION' ) or define( 'YABP_WP_REQUIRED_VERSION', '6.2' );
defined( 'YABP_WP_VALID_VERSION' ) or define( 'YABP_WP_VALID_VERSION', version_compare( get_bloginfo( 'version' ), YABP_WP_REQUIRED_VERSION, '>=' ) );

/**
 * Load all files from a given path.
 *
 * @param {string} $path The path from the root of the plugin to include.
 *
 * @return void
 */
function load( $path ) {

	$files = glob( YABP_DIR . $path . DIRECTORY_SEPARATOR . '*.php' );

	foreach ( $files as $file ) {
		require_once $file;
	}

	$directories = glob( YABP_DIR . $path, GLOB_ONLYDIR );

	if ( ! empty( $directories ) ) {
		foreach ( $directories as $directory ) {

			$scanned_directories = array_diff( scandir( $directory ), array( '..', '.' ) );

			if ( empty( $scanned_directories ) ) {
				continue;
			}

			foreach ( $scanned_directories as $scanned_directory ) {

				if ( is_file( YABP_DIR . $path . DIRECTORY_SEPARATOR . $scanned_directory ) ) {
					// File in directory;
					require_once YABP_DIR . $path . DIRECTORY_SEPARATOR . $scanned_directory;

					continue;
				}

				load( $path . DIRECTORY_SEPARATOR . $scanned_directory );
			}
		}
	}
}

load( 'includes' );
