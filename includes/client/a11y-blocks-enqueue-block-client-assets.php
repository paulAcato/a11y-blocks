<?php

/**
 * Register the block styles and scripts by the generated block asset file.
 * @return void
 */
function jabp_blocks_enqueue_block_client_assets() {
	// Register shared block styles for the blocks.
	$jabp_blocks_styles = glob( YABP_BLOCKS_PLUGIN_DIR . 'build/blocks' . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . 'client.css' );
	$jabp_blocks_scripts = glob( YABP_BLOCKS_PLUGIN_DIR . 'build/blocks' . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . 'client.js' );

	if ( ! empty( $jabp_blocks_styles ) ) {
		foreach ( $jabp_blocks_styles as $jabp_blocks_style ) {
			if ( ! jabp_blocks_has_resource( $jabp_blocks_style ) ) {
				// Continue if the file is empty.
				continue;
			}

			// Name of the block by the URL.
			$jabp_blocks_block_name = preg_replace( '/.*\/build\/blocks\/(.*)\/client.css/', '$1', $jabp_blocks_style );

			wp_register_style(
				"a11y-blocks-$jabp_blocks_block_name-block",
				jabp_blocks_mix( $jabp_blocks_style ),
				[],
				YABP_BLOCKS_VERSION
			);
		}
	}

	if ( ! empty( $jabp_blocks_scripts ) ) {
		foreach ( $jabp_blocks_scripts as $jabp_blocks_script ) {
			if ( ! jabp_blocks_has_resource( $jabp_blocks_script ) ) {
				// Continue if the file is empty.
				continue;
			}

			// Name of the block by the URL.
			$jabp_blocks_block_name = preg_replace( '/.*\/build\/blocks\/(.*)\/client.js/', '$1', $jabp_blocks_script );

			wp_register_script(
				"a11y-blocks-$jabp_blocks_block_name-block",
				jabp_blocks_mix( $jabp_blocks_script ),
				[],
				YABP_BLOCKS_VERSION,
			);
		}
	}
}

add_action( 'enqueue_block_assets', 'jabp_blocks_enqueue_block_client_assets' );
