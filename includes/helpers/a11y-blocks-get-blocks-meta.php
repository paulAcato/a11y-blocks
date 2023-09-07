<?php

function a11y_blocks_get_blocks_meta() {
	static $a11y_blocks_blocks_meta;
	if ( ! $a11y_blocks_blocks_meta ) {
		$a11y_blocks_blocks_meta = glob( A11Y_BLOCKS_PLUGIN_DIR . 'blocks' . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . 'block.json' );
	}

	return $a11y_blocks_blocks_meta;
}
