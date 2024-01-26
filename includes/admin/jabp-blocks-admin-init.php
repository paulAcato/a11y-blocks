<?php
/**
 * Admin init file.
 *
 * @return void
 */
function jabp_blocks_admin_init() {
	// Deactivate the plugin to prevent further issues.
	if ( ! YABP_WP_VALID_VERSION ) {
		deactivate_plugins( YABP_BASENAME );
	}
}

add_action( 'admin_init', 'jabp_blocks_admin_init' );
