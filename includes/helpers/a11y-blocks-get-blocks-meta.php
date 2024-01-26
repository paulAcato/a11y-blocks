<?php

function jabp_blocks_get_blocks_meta() {
	static $jabp_blocks_blocks_meta;
	if ( ! $jabp_blocks_blocks_meta ) {
		$jabp_blocks_blocks_meta = glob( YABP_BLOCKS_PLUGIN_DIR . 'blocks' . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . 'block.json' );
	}

	return $jabp_blocks_blocks_meta;
}
