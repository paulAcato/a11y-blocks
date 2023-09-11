<?php

function enqueue_registering_blocks() {

	$script_asset_path = A11Y_BLOCKS_PLUGIN_DIR . 'build/index.asset.php';
	if ( a11y_blocks_has_resource( $script_asset_path ) ) {
		$script_asset = require $script_asset_path;
	} else {
		$script_asset = [
			'dependencies' => [ 'wp-blocks' ],
			'version'      => A11Y_BLOCKS_VERSION,
		];
	}

	wp_enqueue_script( 'a11y-blocks-register-blocks', A11Y_BLOCKS_PLUGIN_URI . 'build/index.js', $script_asset['dependencies'], $script_asset['version'], true );
}

add_action( 'enqueue_block_editor_assets', 'enqueue_registering_blocks' );
