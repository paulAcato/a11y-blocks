<?php

/**
 * @return void
 */
function jabp_blocks_admin_notices() {
	// Display an error message if the minimum version requirement is not met.
	if ( version_compare( get_bloginfo( 'version' ), '6.0', '<' ) ) {
		printf( '<div class="error"><p>%s</p></div>',
			esc_attr_x( 'The Just Another Blocks Plugin requires WordPress version 6.0 or higher.', 'Plugin activation warning', 'jabp' )
		);
	}
}

add_action( 'admin_notices', 'jabp_blocks_admin_notices' );
