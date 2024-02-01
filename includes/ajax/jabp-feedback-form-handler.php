<?php

if ( ! function_exists( 'jabp_feedback_form_handler' ) ) {
	// Add this to your theme's functions.php file or in a custom plugin
	function jabp_feedback_form_handler() {

		$jabp_request = wp_unslash( $_REQUEST );

		if ( empty( $jabp_request['_ajax_nonce'] ) || empty( $jabp_request['post_id'] ) || ! is_scalar( $jabp_request['post_id'] ) ) {
			wp_send_json_error( _x( 'Something went wrong', 'Ajax', 'jabp' ) );
		}

		$jabp_validate = check_ajax_referer( 'jabp_feedback_form', $jabp_request['_ajax_nonce'] );

		if ( empty( $jabp_validate ) ) {
			wp_send_json_error( _x( 'Something went wrong', 'Ajax', 'jabp' ) );
		}

		$jabp_direction = $jabp_request['direction'] ?: 'positive';
		$jabp_post_id   = absint( $jabp_request['post_id'] );
		$jabp_meta_key  = 'jabp_feedback';

		if ( ! metadata_exists( 'post', $jabp_post_id, $jabp_meta_key ) ) {
			add_post_meta( $jabp_post_id, $jabp_meta_key, 'positive' === $jabp_direction ? 1 : - 1, true );
		} else {
			$jabp_meta_value = get_post_meta( $jabp_post_id, $jabp_meta_key, true );
			update_post_meta( $jabp_post_id, $jabp_meta_key, 'positive' === $jabp_direction ? $jabp_meta_value + 1 : $jabp_meta_value - 1 );
		}

		// Your AJAX logic here
		$response = [
			'heading'   => esc_attr_x( 'Thank you for your feedback', 'After submit heading', 'jabp' ),
			'message'   => esc_attr_x( 'Your feedback matters! Help us improve by sharing your thoughts and experiences. Thank you for your valuable input!', 'After submit message', 'jabp' ),
			'direction' => $jabp_direction,
		];

		wp_send_json_success( $response );
	}

	add_action( 'wp_ajax_feedback_form', 'jabp_feedback_form_handler' );
	add_action( 'wp_ajax_nopriv_feedback_form', 'jabp_feedback_form_handler' );

}
