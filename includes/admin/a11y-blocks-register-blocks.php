<?php

function jabp_blocks_register_blocks() {
	if ( ! function_exists( 'register_block_type' ) ) {
		// Block editor is not available.
		return;
	}

	$jabp_blocks_blocks_meta = jabp_blocks_get_blocks_meta();

	if ( empty( $jabp_blocks_blocks_meta ) ) {
		return;
	}

	foreach ( array_map( 'dirname', $jabp_blocks_blocks_meta ) as $jabp_blocks_block_meta ) {
		register_block_type_from_metadata( $jabp_blocks_block_meta );
	}
}

add_action( 'init', 'jabp_blocks_register_blocks' );
