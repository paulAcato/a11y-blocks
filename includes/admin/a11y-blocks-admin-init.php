<?php
/**
 * Admin init file.
 *
 * @return void
 */
function a11y_blocks_admin_init() {
	// Deactivate the plugin to prevent further issues.
	if ( version_compare( get_bloginfo( 'version' ), '6.0', '<' ) ) {
		deactivate_plugins( A11Y_BLOCKS_PLUGIN_BASENAME );
	}
}

add_action( 'admin_init', 'a11y_blocks_admin_init' );
