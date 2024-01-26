<?php

/**
 * Checks if file exists and if the file is populated, so we don't enqueue empty files.
 *
 * @param {string} $path ABSPATH to file.
 *
 * @return bool|mixed
 */
function jabp_has_resource( $path ) {
	static $resources = null;

	if ( isset( $resources[ $path ] ) ) {
		return $resources[ $path ];
	}

	// Check if resource exists and has content.
	$resources[ $path ] = file_exists( $path ) && 0 < filesize( $path );

	return $resources[ $path ];
}
