<?php

function a11y_blocks_register_blocks() {
	if ( ! function_exists( 'register_block_type' ) ) {
		// Block editor is not available.
		return;
	}

	$a11y_blocks_blocks_meta = a11y_blocks_get_blocks_meta();

	if ( empty( $a11y_blocks_blocks_meta ) ) {
		return;
	}

	foreach ( array_map( 'dirname', $a11y_blocks_blocks_meta ) as $a11y_blocks_block_meta ) {
		register_block_type_from_metadata( $a11y_blocks_block_meta );
	}
}

add_action( 'init', 'a11y_blocks_register_blocks' );
