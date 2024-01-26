<?php
/**
 * Render callback for the `jabp/sr-heading` block.
 *
 * @global $attributes array The attributes of the block.
 * @global $content string The content of the block.
 */

if ( empty( $content ) ) {
	return;
}

echo wp_kses_post( $content );
