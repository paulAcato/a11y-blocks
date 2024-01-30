<?php
/**
 * Defines theme helper functions.
 *
 * @since      1.0.0
 * @package    Just_Another_Block_Plugin
 * @author     Paul van Impelen <paulvanimpelen@gmail.com>
 */

if ( ! function_exists( 'jabp_to_dom_attributes' ) ) {
	/**
	 * Implements jabp_to_dom_attributes($attributes).
	 *
	 * @param array $attributes A named array of DOM attributes.
	 *
	 * @return string A string of all DOM attributes (without leading- or appending spaces).
	 */
	function jabp_to_dom_attributes( $attributes ) {
		$attr_str = '';
		foreach ( $attributes as $attr_key => $attr_value ) {
			if ( is_array( $attr_value ) ) {
				$attr_value = implode( ' ', array_unique( array_filter( $attr_value ) ) );
			}
			$attr_str .= " {$attr_key}=\"" . esc_attr( $attr_value ) . '"';
		}

		return trim( $attr_str );
	}
}
