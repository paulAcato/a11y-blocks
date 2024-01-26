<?php

/**
 * Register activation hook.
 * Disable plugin when the classic-editor plugin is active.
 *
 * @return void
 */
function jabp_blocks_register_activation_hook() {
	// Check if the Classic Editor plugin is installed and active..
	if ( is_plugin_active( 'classic-editor/classic-editor.php' ) ) {
		// Classic Editor plugin is active, deactivate a11y-blocks.
		deactivate_plugins( YABP_BLOCKS_PLUGIN_BASENAME );
		// Display a notice to the user.
		wp_die( _x( 'The a11y-blocks plugin has been deactivated because the Classic Editor plugin is active.', 'Plugin activation warning', 'jabp' ) );
	}

	if ( version_compare( get_bloginfo( 'version' ), '6.0', '<' ) ) {
		// Classic Editor plugin is active, deactivate a11y-blocks.
		deactivate_plugins( YABP_BLOCKS_PLUGIN_BASENAME );
		// Display a notice to the user.
		wp_die( _x( 'The a11y-blocks plugin requires WordPress version 6.0 or higher.', 'Plugin activation warning', 'jabp' ) );
	}
}

register_activation_hook( YABP_BLOCKS_PLUGIN_BASENAME, 'jabp_blocks_register_activation_hook' );

// Check if WordPress version is at least 6.0
if ( version_compare( get_bloginfo( 'version' ), '6.0', '<' ) ) {
	// Display an error message if the minimum version requirement is not met


	// Deactivate the plugin to prevent further issues
	function my_plugin_deactivate() {
		deactivate_plugins( YABP_BLOCKS_PLUGIN_BASENAME );
	}

	add_action( 'admin_init', 'my_plugin_deactivate' );
} else {
	// Activation hook when the minimum version requirement is met
	function my_plugin_activation() {
		// Your activation code here
	}

	register_activation_hook( __FILE__, 'my_plugin_activation' );
}



