<?php
/**
 * Get the ID from the mix-manifest file.
 *
 * @since      1.0.0
 * @package    Werken_Voor_Denhaag_Theme
 * @subpackage Werken_Voor_Denhaag_Theme/Helpers
 */

if ( ! function_exists( 'a11y_blocks_mix' ) ) {

	/**
	 * Just a little helper to get filenames from the mix-manifest file.
	 *
	 * @param {string} $path to file.
	 *
	 * @return string
	 */
	function a11y_blocks_mix( $path ): string {
		$manifest = A11Y_BLOCKS_PLUGIN_DIR . '/build/mix-manifest.json';
		if ( ! file_exists( $manifest ) ) {
			return A11Y_BLOCKS_PLUGIN_URI . $path;
		}

		$manifest = json_decode(
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			file_get_contents( $manifest )
		);

		if ( str_contains( $path, A11Y_BLOCKS_PLUGIN_DIR . 'build' ) ) {
			$path = str_replace( A11Y_BLOCKS_PLUGIN_DIR . 'build', '', $path );
		}

		$manifest = get_object_vars( $manifest );

		if ( ! array_search( $path, $manifest, true ) ) {
			if ( ! empty( $manifest[ $path ] ) ) {
				return untrailingslashit( A11Y_BLOCKS_PLUGIN_URI . 'build' ) . $manifest[ $path ];
			}

			return untrailingslashit( A11Y_BLOCKS_PLUGIN_URI . 'build' ) . $path;
		}

		return untrailingslashit( A11Y_BLOCKS_PLUGIN_URI . 'build' ) . $manifest[ $path ];
	}
}
