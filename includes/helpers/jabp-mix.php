<?php
/**
 * Get the ID from the mix-manifest file.
 *
 * @since      1.0.0
 * @package    Werken_Voor_Denhaag_Theme
 * @subpackage Werken_Voor_Denhaag_Theme/Helpers
 */

if ( ! function_exists( 'jabp_mix' ) ) {

	/**
	 * Just a little helper to get filenames from the mix-manifest file.
	 *
	 * @param {string} $path to file.
	 *
	 * @return string
	 */
	function jabp_mix( $path ): string {
		$manifest = YABP_DIR . '/build/mix-manifest.json';
		if ( ! file_exists( $manifest ) ) {
			return YABP_URI . $path;
		}

		$manifest = json_decode(
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			file_get_contents( $manifest )
		);

		if ( str_contains( $path, YABP_DIR . 'build' ) ) {
			$path = str_replace( YABP_DIR . 'build', '', $path );
		}

		$manifest = get_object_vars( $manifest );

		if ( ! array_search( $path, $manifest, true ) ) {
			if ( ! empty( $manifest[ $path ] ) ) {
				return untrailingslashit( YABP_URI . 'build' ) . $manifest[ $path ];
			}

			return untrailingslashit( YABP_URI . 'build' ) . $path;
		}

		return untrailingslashit( YABP_URI . 'build' ) . $manifest[ $path ];
	}
}
