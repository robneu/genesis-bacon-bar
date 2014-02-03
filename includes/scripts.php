<?php
/**
 * Load Theme JavaScript and CSS
 *
 * @package     WP Bacon Bar
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
	$css_uri = BACON_BAR_URL . 'assets/styles/';

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

/** Load CSS in <head> */
//add_action( 'wp_head', 'baconbar_meh_css' );
/**
 * Custom CSS.
 *
 * Output custom CSS to control the look of the icons.
 */
function baconbar_meh_css() {

	global $afpw_options;

	$font_size = round( (int) $instance['size'] / 2 );
	$icon_padding = round ( (int) $font_size / 2 );

	/** The CSS to output */
	$css = '
	.awesome-feature .ico-bg a {
		background: ' . $instance['background_color'] . ' !important;
		-moz-border-radius: ' . $instance['border_radius'] . 'px
		-webkit-border-radius: ' . $instance['border_radius'] . 'px;
		border-radius: ' . $instance['border_radius'] . 'px;
		color: ' . $instance['icon_color'] . ' !important;
		font-size: ' . $font_size . 'px;
		padding: ' . $icon_padding . 'px;
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
