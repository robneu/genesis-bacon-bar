<?php
/**
 * Misc Functions.
 *
 * @package      WP Bacon Bar
 * @author       Robert Neu <http://wpbacon.com/>
 * @copyright    Copyright (c) 2014, FAT Media, LLC
 * @license      GPL2+
 *
 */

// Exit if accessed directly
defined( 'WPINC' ) or die;

add_action( 'get_header', 'baconbar_setup' );
function baconbar_setup() {
	add_filter( 'body_class', 'baconbar_body_class' );
	add_action( 'genesis_before', 'baconbar_do_bacon_bar' );
	//add_action( 'genesis_after', 'baconbar_do_bacon_bar' );
}


//* Add custom body class to the head
function baconbar_body_class( $classes ) {
	$classes[] = 'bacon-bar-active';
	return $classes;
}

/**
 * baconbar_social_sharing_buttons function.
 *
 * This function displays social sharing buttons based on the options selected by the user.
 *
 * @since 1.0.0
 *
 */
function baconbar_do_bacon_bar() {
	$field        = BACON_SETTINGS_FIELD;
	$button_url   = genesis_get_option( 'baconbar_button_url', $field );
	$button_text  =	genesis_get_option( 'baconbar_button_text', $field );
	$target_blank =	genesis_get_option( 'baconbar_target_blank', $field );
	$teaser_text  = genesis_get_option( 'baconbar_teaser_text', $field );
	$classes = '';
	$classes .= 'fixed-bar';

	echo '<div class="bacon-bar ' . $classes . '">';
		echo '<div class="wrap">';

			if ( $teaser_text ) {
				echo '<p class="bacon-text">' . esc_attr( $teaser_text ) . '</p>';
			}
			if ( $button_url && $button_text ) {
				echo '<a class="bacon-button" href="' . esc_url( $button_url ) . '">' . esc_attr( $button_text ) . '</a>';
			}
		echo '</div>';
	echo '</div>';
}
