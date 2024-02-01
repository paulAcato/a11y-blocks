<?php

/**
 * Register activation hook.
 * Disable plugin when the classic-editor plugin is active.
 *
 * @return void
 */

if ( ! function_exists( 'jabp_blocks_register_activation_hook' ) ) {
	function jabp_blocks_register_activation_hook() {
		// Check if the Classic Editor plugin is installed and active..
		if ( is_plugin_active( 'classic-editor/classic-editor.php' ) ) {
			// Classic Editor plugin is active, deactivate a11y-blocks.
			deactivate_plugins( YABP_BASENAME );
			// Display a notice to the user.
			wp_die( _x( 'The Just Another blocks plugin has been deactivated because the Classic Editor plugin is active.', 'Plugin activation warning', 'jabp' ) );
		}

		if ( ! YABP_WP_VALID_VERSION ) {
			// Classic Editor plugin is active, deactivate a11y-blocks.
			deactivate_plugins( YABP_BASENAME );
			// Display a notice to the user.
			/* translators: %s The required WP version. */
			wp_die( sprintf( _x( 'The Just Another Blocks Plugin requires WordPress version %s or higher.', 'Plugin activation warning', 'jabp' ), YABP_WP_REQUIRED_VERSION ) );
		}
	}

	register_activation_hook( YABP_BASENAME, 'jabp_blocks_register_activation_hook' );

}

if ( ! YABP_WP_VALID_VERSION ) {
	// Display an error message if the minimum version requirement is not met

	function jabp_plugin_deactivate() {
		deactivate_plugins( YABP_BASENAME );
	}

	add_action( 'admin_init', 'jabp_plugin_deactivate' );
} else {
	// Activation hook when the minimum version requirement is met
	function jabp_plugin_activation() {
		// Your activation code here
	}

	register_activation_hook( __FILE__, 'jabp_plugin_activation' );
}



