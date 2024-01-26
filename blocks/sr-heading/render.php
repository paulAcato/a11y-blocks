<?php

if ( empty( $content ) ) {
	return;
}

echo wp_kses_post( $content );
