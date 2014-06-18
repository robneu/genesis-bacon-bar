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
 * @since 1.0.0
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
 * @since 1.0.0
 */
function wpbacon_enqueue_scripts() {
	wp_enqueue_script( 'wpbacon-general', wpbacon_get_js_uri() . 'general.js', array( 'jquery' ), '1.0.0', true );
}

function baconbar_get_style_data() {
	$styles = array(
		'bg_color'           => baconbar_get_option( 'baconbar_bg_color' ),
		'text_color'         => baconbar_get_option( 'baconbar_text_color' ),
		'button_color'       => baconbar_get_option( 'baconbar_button_color' ),
		'button_hover_color' => baconbar_get_option( 'baconbar_button_hover_color' ),
		'button_text_color'  => baconbar_get_option( 'baconbar_button_text_color' ),
	);
	return $styles;
}

/** Load CSS in <head> */
add_action( 'wp_head', 'baconbar_meh_css' );
/**
 * Custom CSS.
 *
 * Output custom CSS to control the look of the icons.
 */
function baconbar_meh_css() {
	$styles = baconbar_get_style_data();

	if ( ! baconbar_has_data( $styles ) ) {
		return;
	}
	$css = '';
	ob_start();
	if ( $styles['bg_color'] ) {
		?>
		.bacon-bar {
			background: <?php echo $styles['bg_color'] ?>;
		}
		<?php
	}

	if ( $styles['text_color'] ) {
		?>
		.bacon-bar .bacon-text {
			color: <?php echo $styles['text_color'] ?>;
		}
		<?php
	}

	if ( $styles['button_color'] || $styles['button_text_color'] ) {
		?>
		.bacon-bar .bacon-button {
			background: <?php echo $styles['button_color'] ?>;
			color: <?php echo $styles['button_text_color'] ?>;
		}
		<?php
	}

	if ( $styles['button_color'] ) {
		?>
		.bacon-bar .bacon-button:hover {
			background: <?php echo $styles['button_hover_color'] ?>;
		}
		<?php
	}

	$css = ob_get_clean();

	//* Minify the CSS a bit.
	$css = str_replace( "\t", '', $css );
	$css = str_replace( array( "\n", "\r" ), ' ', $css );

	//* Echo the CSS.
	echo '<style type="text/css" media="screen">' . $css . '</style>';
}
