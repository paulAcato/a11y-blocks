<?php
/**
 * Admin init file.
 *
 * @return void
 */
function jabp_blocks_admin_init() {
	// Deactivate the plugin to prevent further issues.
	if ( version_compare( get_bloginfo( 'version' ), '6.0', '<' ) ) {
		deactivate_plugins( YABP_BLOCKS_PLUGIN_BASENAME );
	}
}

add_action( 'admin_init', 'jabp_blocks_admin_init' );
