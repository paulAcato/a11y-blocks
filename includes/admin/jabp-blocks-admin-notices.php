<?php

/**
 * @return void
 */
function jabp_blocks_admin_notices() {
	// Display an error message if the minimum version requirement is not met.
	if ( ! YABP_WP_VALID_VERSION ) {
		printf( '<div class="error"><p>%s</p></div>',
			sprintf( esc_attr_x( 'The Just Another Blocks Plugin requires WordPress version %s or higher.', 'Plugin activation warning', 'jabp' ), YABP_WP_REQUIRED_VERSION )
		);
	}
}

add_action( 'admin_notices', 'jabp_blocks_admin_notices' );
