<?php

/**
 * @return void
 */
function a11y_blocks_admin_notices() {
	// Display an error message if the minimum version requirement is not met.
	if ( version_compare( get_bloginfo( 'version' ), '6.0', '<' ) ) {
		printf( '<div class="error"><p>%s</p></div>',
			esc_attr_x( 'The a11y-blocks plugin requires WordPress version 6.0 or higher.', 'Plugin activation warning', 'a11y-blocks' )
		);
	}
}

add_action( 'admin_notices', 'a11y_blocks_admin_notices' );
