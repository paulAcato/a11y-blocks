<?php

/**
 * Register the block styles and scripts by the generated block asset file.
 * @return void
 */
function jabp_enqueue_block_client_assets() {

	// Register shared block styles for the blocks.
	$jabp_block_path = YABP_DIR . 'build' . DIRECTORY_SEPARATOR . 'blocks' . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR;

	$jabp_blocks_styles = glob( $jabp_block_path . 'client.css' );
	$jabp_blocks_scripts = glob( $jabp_block_path . 'client.js' );

	if ( ! empty( $jabp_blocks_styles ) ) {
		foreach ( $jabp_blocks_styles as $jabp_blocks_style ) {
			if ( ! jabp_has_resource( $jabp_blocks_style ) ) {
				// Continue if the file is empty.
				continue;
			}

			// Name of the block by the URL.
			$jabp_block_name = preg_replace( '/.*\/build\/blocks\/(.*)\/client.css/', '$1', $jabp_blocks_style );

			wp_register_style(
				"jabp-$jabp_block_name",
				jabp_mix( $jabp_blocks_style ),
				[],
				YABP_VERSION
			);
		}
	}

	if ( ! empty( $jabp_blocks_scripts ) ) {
		foreach ( $jabp_blocks_scripts as $jabp_blocks_script ) {
			if ( ! jabp_has_resource( $jabp_blocks_script ) ) {
				// Continue if the file is empty.
				continue;
			}

			// Name of the block by the URL.
			$jabp_block_name = preg_replace( '/.*\/build\/blocks\/(.*)\/client.js/', '$1', $jabp_blocks_script );

			wp_register_script(
				"jabp-$jabp_block_name",
				jabp_mix( $jabp_blocks_script ),
				[],
				YABP_VERSION,
			);
		}
	}
}

add_action( 'enqueue_block_assets', 'jabp_enqueue_block_client_assets' );
