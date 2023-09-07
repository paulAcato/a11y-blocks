<?php
/**
 * Filters the allowed block types for all editor types.
 *
 * @link       https://www.acato.nl
 * @since      1.0.0
 */

/**
 * Filters the allowed block types for all editor types.
 *
 * @param bool|string[]           $allowed_block_types  Array of block type slugs, or boolean to enable/disable all. Default true (all registered block types supported).
 * @param WP_Block_Editor_Context $block_editor_context The current block editor context.
 *
 * @return array|mixed
 */
function a11y_blocks_allowed_block_types_all( $allowed_block_types, $block_editor_context ) {

	$a11y_blocks_blocks_meta = a11y_blocks_get_blocks_meta();

	if ( empty( $a11y_blocks_blocks_meta ) ) {
		return $allowed_block_types;
	}

	$allowed_blocks = [];
	foreach ( $a11y_blocks_blocks_meta as $block ) {
		$block_meta = json_decode(
		//phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
			file_get_contents( $block ),
			false
		);

		if ( empty( $block_meta ) ) {
			continue;
		}

		$allowed_blocks[] = $block_meta->name;
	}

	if ( is_array( $allowed_block_types ) ) {
		$allowed_blocks = array_merge( $allowed_blocks, $allowed_block_types );
	}

	return ! empty( $allowed_blocks ) ? array_unique( $allowed_blocks ) : $allowed_block_types;
}

add_filter( 'allowed_block_types_all', 'a11y_blocks_allowed_block_types_all', 10, 2 );
