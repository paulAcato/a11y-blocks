<?php

/**
 * Register the block styles and scripts by the generated block asset file.
 * @return void
 */
function a11y_blocks_enqueue_block_client_assets() {
	// Register shared block styles for the blocks.
	$a11y_blocks_styles = glob( A11Y_BLOCKS_PLUGIN_DIR . 'build/blocks' . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . 'client.css' );
	$a11y_blocks_scripts = glob( A11Y_BLOCKS_PLUGIN_DIR . 'build/blocks' . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . 'client.js' );

	if ( ! empty( $a11y_blocks_styles ) ) {
		foreach ( $a11y_blocks_styles as $a11y_blocks_style ) {
			if ( ! a11y_blocks_has_resource( $a11y_blocks_style ) ) {
				// Continue if the file is empty.
				continue;
			}

			// Name of the block by the URL.
			$a11y_blocks_block_name = preg_replace( '/.*\/build\/blocks\/(.*)\/client.css/', '$1', $a11y_blocks_style );

			wp_register_style(
				"a11y-blocks-$a11y_blocks_block_name-block",
				a11y_blocks_mix( $a11y_blocks_style ),
				[],
				A11Y_BLOCKS_VERSION
			);
		}
	}

	if ( ! empty( $a11y_blocks_scripts ) ) {
		foreach ( $a11y_blocks_scripts as $a11y_blocks_script ) {
			if ( ! a11y_blocks_has_resource( $a11y_blocks_script ) ) {
				// Continue if the file is empty.
				continue;
			}

			// Name of the block by the URL.
			$a11y_blocks_block_name = preg_replace( '/.*\/build\/blocks\/(.*)\/client.js/', '$1', $a11y_blocks_script );

			wp_register_script(
				"a11y-blocks-$a11y_blocks_block_name-block",
				a11y_blocks_mix( $a11y_blocks_script ),
				[],
				A11Y_BLOCKS_VERSION,
			);
		}
	}
}

add_action( 'enqueue_block_assets', 'a11y_blocks_enqueue_block_client_assets' );
