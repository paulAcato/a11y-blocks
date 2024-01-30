<?php
/**
 * Render callback for the `jabp/feedback-form` block.
 *
 * @global $attributes array The attributes of the block.
 * @global $content    string The content of the block.
 */

$jabp_style = $attributes['style'] ?: 1;
switch ( $jabp_style ) {
	case 1:
		$icons = [
			'<svg aria-hidden="true" role="presentation" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M695.559-166.154H300v-430.154l246.462-243.385 15.846 15.231q5.346 5.962 8.827 13.926t3.481 14.591v5.637l-40.308 194h278q23.731 0 42.635 18.904 18.903 18.904 18.903 42.635v48.128q0 5.365-.859 11.716-.859 6.352-2.987 11.387L761.96-208.986q-7.792 18.648-27.145 30.74-19.353 12.092-39.256 12.092Zm-358.636-36.923h359.692q8.462 0 17.308-4.615 8.846-4.616 13.462-15.385l109.538-256.808v-54.884q0-10.77-6.923-17.693-6.923-6.923-17.692-6.923H488.923l45.577-217.23-197.577 195.653v377.885Zm0-377.885v377.885-377.885ZM300-596.308v36.923H163.692v356.308H300v36.923H126.769v-430.154H300Z"/></svg>',
			'<svg aria-hidden="true" role="presentation" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M265.056-759.693h395.559v430.155L414.154-86.154l-15.847-15.231q-5.346-5.961-8.827-13.925-3.48-7.964-3.48-14.591v-5.638l40.307-193.999H148.308q-23.731 0-42.635-18.904-18.904-18.904-18.904-42.635v-48.128q0-5.365.859-11.717.859-6.351 2.987-11.386l108.041-254.553q7.791-18.648 27.144-30.74 19.354-12.092 39.256-12.092Zm358.636 36.924H264q-8.462 0-17.308 4.615t-13.461 15.384L123.692-446.475v55.398q0 10.769 6.923 17.692t17.693 6.923h323.384L426.5-149.231l197.192-196.038v-377.5Zm0 377.5V-722.769v377.5Zm36.923 15.731v-36.924h136.308v-356.307H660.615v-36.924h173.231v430.155H660.615Z"/></svg>',
		];
		break;

	case 2:
		$icons = [
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48" aria-hidden="true" focusable="false"><path d="M16.7 7.1l-6.3 8.5-3.3-2.5-.9 1.2 4.5 3.4L17.9 8z"></path></svg>',
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="36" height="36" aria-hidden="true" focusable="false"><path d="M12 13.06l3.712 3.713 1.061-1.06L13.061 12l3.712-3.712-1.06-1.06L12 10.938 8.288 7.227l-1.061 1.06L10.939 12l-3.712 3.712 1.06 1.061L12 13.061z"></path></svg>',
		];
		break;

	case 3:
		$icons = [
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false"><path d="M11 12.5V17.5H12.5V12.5H17.5V11H12.5V6H11V11H6V12.5H11Z"></path></svg>',
			'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="48" height="48" aria-hidden="true" focusable="false"><path d="M5 11.25h14v1.5H5z"></path></svg>',
		];
		break;
	default:
		$icons = [ '', '' ];
}


$jabp_attributes = [
	'class' => [ 'jabp-feedback-form', 'jabp-feedback-form--style-' . $jabp_style ],
];

$jabp_button_attributes = [
	'class' => [
		'jabp-feedback-form__btn',
		'jabp-feedback-form__btn--' . $attributes['buttonStyle'] ?: 'default',
	],
];

?>
<section <?php echo jabp_to_dom_attributes( $jabp_attributes ); ?>>
	<?php

	printf( '<button %1$s>%2$s<span>%4$s</span></button>
					<button %1$s>%3$s<span>%5$s</span></button>
					',
		jabp_to_dom_attributes( $jabp_button_attributes ),
		$icons[0],
		$icons[1],
		esc_attr__( 'Yes', 'jabp' ),
		esc_attr__( 'No', 'jabp' )
	);
	?>
</section>

