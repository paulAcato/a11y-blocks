<?php

if ( ! function_exists( 'jabp_load_textdomain' ) ) {

	function jabp_load_textdomain() {
		load_plugin_textdomain( 'jabp', false, YABP_DIR . 'languages' . DIRECTORY_SEPARATOR );
	}

	add_action( 'plugins_loaded', 'jabp_load_textdomain' );

}
