<?php
/**
 * This file is read by WordPress to generate the plugin information in the plugin admin area. This file also includes
 * all the dependencies used by the plugin and starts the plugin.
 *
 * @since             1.0.0
 * @package           A11y_Blocks
 *
 * @wordpress-plugin
 * Plugin Name:       A11y Blocks
 * Description:       Description: Enhances accessibility by adding accessible blocks to the block editor.
 * Version:           1.0.0
 * Author:            Paul van Impelen <paul@acato.nl>
 * Author URI:        https://www.acato.nl
 * Text Domain:       a11y-blocks
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'A11Y_BLOCKS_VERSION' ) ) {
	define( 'A11Y_BLOCKS_VERSION', '1.0.0' );
}

if ( ! defined( 'A11Y_BLOCKS_PLUGIN_BASENAME' ) ) {
	define( 'A11Y_BLOCKS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'A11Y_BLOCKS_PLUGIN_DIR' ) ) {
	define( 'A11Y_BLOCKS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'A11Y_BLOCKS_PLUGIN_URI' ) ) {
	define( 'A11Y_BLOCKS_PLUGIN_URI', plugin_dir_url( __FILE__ ) );
}

/**
 * Load all files from a given path.
 *
 * @param {string} $path The path from the root of the plugin to include.
 *
 * @return void
 */
function load( $path ) {

	$files = glob( A11Y_BLOCKS_PLUGIN_DIR . $path . DIRECTORY_SEPARATOR . '*.php' );

	foreach ( $files as $file ) {
		require_once $file;
	}

	$directories = glob( A11Y_BLOCKS_PLUGIN_DIR . $path, GLOB_ONLYDIR );

	if ( ! empty( $directories ) ) {
		foreach ( $directories as $directory ) {

			$scanned_directories = array_diff( scandir( $directory ), array( '..', '.' ) );

			if ( empty( $scanned_directories ) ) {
				continue;
			}

			foreach ( $scanned_directories as $scanned_directory ) {

				if ( is_file( A11Y_BLOCKS_PLUGIN_DIR . $path . DIRECTORY_SEPARATOR . $scanned_directory ) ) {
					// File in directory;
					require_once A11Y_BLOCKS_PLUGIN_DIR . $path . DIRECTORY_SEPARATOR . $scanned_directory;

					continue;
				}

				load( $path . DIRECTORY_SEPARATOR . $scanned_directory );
			}
		}
	}
}

load( 'includes' );
