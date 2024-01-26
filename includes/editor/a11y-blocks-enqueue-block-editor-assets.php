<?php

/**
 * Register the block editor scripts and styles by the generated block asset file.
 * @return void
 */
function jabp_blocks_enqueue_block_editor_assets() {
	// Register shared block styles for the blocks.
	$jabp_blocks_styles = glob( YABP_BLOCKS_PLUGIN_DIR . 'build/blocks' . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . 'editor.css' );

	if ( ! empty( $jabp_blocks_styles ) ) {
		foreach ( $jabp_blocks_styles as $jabp_blocks_style ) {
			if ( ! jabp_blocks_has_resource( $jabp_blocks_style ) ) {
				// Continue if the file is empty.
				continue;
			}

			// Name of the block by the URL.
			$jabp_blocks_block_name = preg_replace( '/.*\/build\/blocks\/(.*)\/editor.css/', '$1', $jabp_blocks_style );

			wp_register_style(
				"a11y-blocks-$jabp_blocks_block_name-block-editor",
				jabp_blocks_mix( $jabp_blocks_style ),
				[],
				YABP_BLOCKS_VERSION
			);
		}
	}
}

add_action( 'enqueue_block_assets', 'jabp_blocks_enqueue_block_editor_assets' );
