<?php

/**
 * Register the block editor scripts and styles by the generated block asset file.
 *
 * @return void
 */
function jabp_register_blocks() {

	$script_asset_path = YABP_DIR . 'build/index.asset.php';
	if ( jabp_has_resource( $script_asset_path ) ) {
		$script_asset = require $script_asset_path;
	} else {
		$script_asset = [
			'dependencies' => [ 'wp-blocks' ],
			'version'      => YABP_VERSION,
		];
	}

	wp_enqueue_script( 'jabp-register-blocks', YABP_URI . 'build/index.js', $script_asset['dependencies'], $script_asset['version'], true );
	wp_set_script_translations( 'jabp-register-blocks', 'jabp', YABP_DIR . 'languages' );
}

add_action( 'enqueue_block_editor_assets', 'jabp_register_blocks' );
