<?php
/**
 * Load Theme JavaScript and CSS
 *
 * @package     Genesis Bacon Bar
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2013, FAT Media, LLC
 * @license     GPL-2.0+
 * @since       2.0.0
 */

// Exit if accessed directly
defined( 'WPINC' ) or die;

/**
 * Removes the default Genesis child theme CSS
 * and then registers and loads CSS files.
 *
 * @since 2.0.0
 */
add_action( 'wp_enqueue_scripts', 'baconbar_enqueue_styles' );
function baconbar_enqueue_styles() {
	// Get the theme info.
	$css_uri = BACON_BAR_URL . 'assets/css/';

	// Register the styles.
	wp_enqueue_style( 'bacon-bar', $css_uri . '/style.css', array(), BACON_BAR_VERSION );
}

//add_action( 'wp_enqueue_scripts', 'wpbacon_enqueue_scripts' );
/**
 * Registers and loads JavaScript files.
 *
 * @since 2.0.0
 */
function wpbacon_enqueue_scripts() {
	wp_enqueue_script( 'wpbacon-general', wpbacon_get_js_uri() . 'general.js', array( 'jquery' ), '1.0.0', true );
}

function baconbar_get_style_data() {
	$field = BACON_SETTINGS_FIELD;
	$styles = array(
		'bg_color'           => genesis_get_option( 'baconbar_bg_color', $field ),
		'text_color'         => genesis_get_option( 'baconbar_text_color', $field ),
		'button_color'       => genesis_get_option( 'baconbar_button_color', $field ),
		'button_hover_color' => genesis_get_option( 'baconbar_button_hover_color', $field ),
		'button_text_color'  => genesis_get_option( 'baconbar_button_text_color', $field ),
	);
	return $styles;
}

/** Load CSS in <head> */
//add_action( 'wp_head', 'baconbar_meh_css' );
/**
 * Custom CSS.
 *
 * Output custom CSS to control the look of the icons.
 */
function baconbar_meh_css() {

	$styles = baconbar_get_style_data();

	$font_size = round( (int) $instance['size'] / 2 );
	$icon_padding = round ( (int) $font_size / 2 );

	/** The CSS to output */
	$css = '
	.awesome-feature .ico-bg a {
		background: ' . $styles['background_color'] . ' !important;
		-moz-border-radius: ' . $styles['border_radius'] . 'px
		-webkit-border-radius: ' . $styles['border_radius'] . 'px;
		border-radius: ' . $styles['border_radius'] . 'px;
		color: ' . $styles['icon_color'] . ' !important;
		font-size: ' . $styles . 'px;
		padding: ' . $styles . 'px;
	}

	.awesome-feature .ico-bg i {
		color: rgba(6, 6, 6, 0.14);
		display: block;
		font-size: 80px;
		padding: 25% 0;
		cursor: pointer;
		position: relative;
		text-align: center;
	}

	.awesome-feature .ico-bg a:hover {
		background-color: ' . $instance['background_color_hover'] . ' !important;
		color: ' . $instance['icon_color_hover'] . ' !important;
	}';

	/** Minify a bit */
	$css = str_replace( "\t", '', $css );
	$css = str_replace( array( "\n", "\r" ), ' ', $css );

	/** Echo the CSS */
	echo '<style type="text/css" media="screen">' . $css . '</style>';

}
