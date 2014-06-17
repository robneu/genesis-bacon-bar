<?php
/**
 * Misc Functions.
 *
 * @package      Genesis Bacon Bar
 * @author       Robert Neu <http://wpbacon.com/>
 * @copyright    Copyright (c) 2014, FAT Media, LLC
 * @license      GPL2+
 *
 */

// Exit if accessed directly
defined( 'WPINC' ) or die;

// Check an array to see if it has any data.
function baconbar_array_has_data( $array ) {
	if ( ! is_array( $array ) || empty( $array ) ) {
		return false;
	}

	if ( count( array_filter( $array ) ) !== 0 ) {
		return true;
	}
	return false;
}

// This function can live wherever is suitable in your plugin
function baconbar_get_template_part( $slug, $name = null, $load = true ) {
    $template_loader = new Bacon_Bar_Template_Loader;
    $template_loader->get_template_part( $slug, $name, $load );
}

function baconbar_get_data() {
	$field = BACON_SETTINGS_FIELD;
	$settings = array(
		'button_url'   => genesis_get_option( 'baconbar_button_url', $field ),
		'button_text'  => genesis_get_option( 'baconbar_button_text', $field ),
		'target_blank' => genesis_get_option( 'baconbar_target_blank', $field ),
		'teaser_text'  => genesis_get_option( 'baconbar_teaser_text', $field ),
		'position'     => genesis_get_option( 'baconbar_position', $field ),
		'is_sticky'    => genesis_get_option( 'baconbar_sticky', $field ),
	);
	return $settings;
}

function baconbar_has_data() {
	$settings = baconbar_get_data();
	if ( $settings['button_url'] || $settings['button_text'] || $settings['teaser_text'] ) {
		return true;
	}
	return false;
}

add_action( 'genesis_meta', 'baconbar_setup' );
function baconbar_setup() {
	if ( ! baconbar_has_data() ) {
		return;
	}
	$settings = baconbar_get_data();
	add_filter( 'body_class', 'baconbar_body_class' );
	if ( 'above' === $settings['position'] ) {
		add_action( 'genesis_before', 'baconbar_do_header_bar' );
	}
	if ( 'below' === $settings['position'] ) {
		add_action( 'genesis_after', 'baconbar_do_footer_bar' );
	}
}


//* Add custom body class to the head
function baconbar_body_class( $classes ) {
	$settings = baconbar_get_data();
	$classes[] = 'bacon-bar-active';
	if ( $settings['is_sticky'] && 'above' === $settings['position'] ) {
		$classes[] = 'sticky-top';
	}
	if ( $settings['is_sticky'] && 'below' === $settings['position'] ) {
		$classes[] = 'sticky-bottom';
	}
	return $classes;
}

function baconbar_get_bar_class( $position ) {
	$settings = baconbar_get_data();
	$classes  = 'header-bar';
	if ( $settings['is_sticky'] ) {
		$classes .= ' fixed-bar';
	}
	if ( 'footer' !== $position ) {
		return $classes;
	}
	$classes  = 'footer-bar';
	if ( $settings['is_sticky'] ) {
		$classes .= ' fixed-footer';
	}
	return $classes;
}

add_action( 'baconbar_header_content', 'baconbar_do_content' );
add_action( 'baconbar_footer_content', 'baconbar_do_content' );
function baconbar_do_content() {
	$settings = baconbar_get_data();
	$target_blank = ! empty( $settings['target_blank'] ) ? 'target="_blank"' : '';

	if ( $settings['teaser_text'] ) {
		echo '<p class="bacon-text">' . esc_attr( $settings['teaser_text'] ) . '</p>';
	}
	if ( $settings['button_url'] && $settings['button_text'] ) {
		echo '<a class="bacon-button" ' . $target_blank . ' href="' . esc_url( $settings['button_url'] ) . '">' . esc_attr( $settings['button_text'] ) . '</a>';
	}
}

/**
 * Display a template for the Bacon Bar.
 *
 * @since  4.0.0
 */
function baconbar_do_header_bar() {
	baconbar_get_template_part( 'bacon-bar' );
}

/**
 * Display a template for the Bacon Bar.
 *
 * @since  4.0.0
 */
function baconbar_do_footer_bar() {
	baconbar_get_template_part( 'bacon-bar', 'footer' );
}
