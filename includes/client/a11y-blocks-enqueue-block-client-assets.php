<?php

function a11y_blocks_enqueue_block_client_assets() {
	// Register shared block styles for the blocks.
	$a11y_blocks_blocks_meta = a11y_blocks_get_blocks_meta();

	if ( empty( $a11y_blocks_blocks_meta ) ) {
		return;
	}

	foreach ( $a11y_blocks_blocks_meta as $block ) {
		$block_meta = json_decode(
		//phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			file_get_contents( $block ),
			false
		);

		if ( empty( $block_meta ) || empty( $block_meta->style ) ) {
			continue;
		}

		if ( ! a11y_blocks_has_resource( A11Y_BLOCKS_PLUGIN_DIR . 'build/blocks/heading/client.css' ) ) {
			// Continue if the file is empty.
			continue;
		}

		wp_register_style(
			is_array( $block_meta->style ) ? $block_meta->style[0] : $block_meta->style,
			A11Y_BLOCKS_PLUGIN_URI . 'build/blocks/heading/client.css',
			[],
			$block_meta->version
		);
	}
}

add_action( 'enqueue_block_assets', 'a11y_blocks_enqueue_block_client_assets' );
