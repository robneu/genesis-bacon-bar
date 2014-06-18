<?php
/**
 * Misc Functions.
 *
 * @package      Genesis Bacon Bar
 * @author       Robert Neu <http://wpbacon.com/>
 * @copyright    Copyright (c) 2014, FAT Media, LLC
 * @license      GPL-2.0+
 *
 */

// Exit if accessed directly
defined( 'WPINC' ) or die;

/**
 * Helper function to load the appropriate template.
 *
 * This allows developers to override the default plugin templates by placing
 * a copy of them in their parent or child theme. Use the directory
 * 'genesis-bacon-bar' to store your custom templates and they will be used
 * instead of the ones included in this plugin.
 *
 * @param  $slug the slug of the base template
 * @param  $name the name of the template part
 * @param  $load an option that determines if the template should be loaded
 * @return $template_loader the template
 * @uses   Bacon_Bar_Template_Loader
 * @since  1.0.1
 */
function baconbar_get_template_part( $slug, $name = null, $load = true ) {
    $template_loader = new Bacon_Bar_Template_Loader;
    $template_loader->get_template_part( $slug, $name, $load );
}

/**
 * Check whether we are currently viewing the site via the WordPress Customizer.
 *
 * @since 1.0.4
 *
 * @global $wp_customize Customizer.
 *
 * @return boolean Return true if viewing page via Customizer, false otherwise.
 */
function baconbar_is_customizer() {
	global $wp_customize;
	return is_a( $wp_customize, 'WP_Customize_Manager' ) && $wp_customize->is_preview();
}

/**
 * Helper function to make getting the bacon bar options less verbose.
 *
 * @param  $option the option value to check.
 * @return $output the returned option value.
 * @uses   genesis_get_option()
 * @uses   baconbar_is_customizer()
 * @since  1.0.1
 */
function baconbar_get_option( $option ) {
	$use_cache = true;
	if ( baconbar_is_customizer() ) {
		$use_cache = false;
	}
	$output = genesis_get_option( $option, 'bacon-settings', $use_cache );
	return $output;
}

/**
 * Helper function to grab the bacon bar settings as an array.
 *
 * @return $settings the returned option values in an array.
 * @uses   baconbar_get_option()
 * @since  1.0.1
 */
function baconbar_get_data() {
	$settings = array(
		'teaser_text'  => baconbar_get_option( 'baconbar_teaser_text' ),
		'button_text'  => baconbar_get_option( 'baconbar_button_text' ),
		'button_url'   => baconbar_get_option( 'baconbar_button_url' ),
		'target_blank' => baconbar_get_option( 'baconbar_target_blank' ),
		'position'     => baconbar_get_option( 'baconbar_position' ),
		'is_sticky'    => baconbar_get_option( 'baconbar_sticky' ),
		'size'         => baconbar_get_option( 'baconbar_size' ),
		'has_border'   => baconbar_get_option( 'baconbar_has_border' ),
	);
	return $settings;
}

/**
 * Helper function to grab some placeholder text when no text has been entered.
 *
 * @return $settings the returned option values in an array.
 * @since  1.0.3
 */
function baconbar_get_dummy_data() {
	$settings = array(
		'teaser_text'  => __( 'Want More Traffic? Supercharge Your Site With a WordPress SEO Audit!', 'baconbar' ),
		'button_text'  => __( 'Audit WP', 'baconbar' ),
		'button_url'   => 'http://auditwp.com',
		'target_blank' => 1,
	);
	return $settings;
}

// Check an array to see if it has any data.
function baconbar_has_data( $array ) {
	if ( ! is_array( $array ) || empty( $array ) ) {
		return false;
	}
	if ( count( array_filter( $array ) ) !== 0 ) {
		return true;
	}
	return false;
}

/**
 * Helper function to determine if the user has added any values to be displayed.
 *
 * @return bool returns true if we have data, false if we don't.
 * @uses   baconbar_get_data()
 * @since  1.0.1
 */
function baconbar_has_content() {
	$settings = baconbar_get_data();
	if ( $settings['button_url'] || $settings['button_text'] || $settings['teaser_text'] ) {
		return true;
	}
	return false;
}

add_action( 'genesis_meta', 'baconbar_setup' );
/**
 * Hook into Genesis and add the bacon bar based on user settings.
 *
 * @uses  baconbar_has_data()
 * @uses  baconbar_get_data()
 * @since  1.0.1
 */
function baconbar_setup() {
	$settings = baconbar_get_data();
	// Add the custom body classes for the bacon bar.
	add_filter( 'body_class', 'baconbar_body_class' );
	// Add the bacon bar above the site if it's been enabled.
	if ( 'above' === $settings['position'] ) {
		add_action( 'genesis_before', 'baconbar_do_header_bar' );
	}
	// Add the bacon bar below the site if it's been enabled.
	if ( 'below' === $settings['position'] ) {
		add_action( 'genesis_after', 'baconbar_do_footer_bar' );
	}
}

/**
 * Add custom body classes to the head based on user settings.
 *
 * @param  $classes arary the current body classes.
 * @return $classes array the modified body classes.
 * @uses   baconbar_get_data()
 * @since  1.0.1
 */
function baconbar_body_class( $classes ) {
	$settings = baconbar_get_data();
	if ( $settings['size'] ) {
		$classes[] .= 'bacon-bar-' . esc_attr( $settings['size'] );
	}
	if ( $settings['is_sticky'] && 'above' === $settings['position'] ) {
		$classes[] = 'sticky-top';
	}
	if ( $settings['is_sticky'] && 'below' === $settings['position'] ) {
		$classes[] = 'sticky-bottom';
	}
	return $classes;
}

/**
 * Get the bacon bar classes based on user settings.
 *
 * @param  $position the position where the bacon bar is to be displayed.
 * @return $classes string a list of classes to be used by the bacon bar.
 * @uses   baconbar_get_data()
 * @since  1.0.1
 */
function baconbar_get_bar_class( $position ) {
	$settings = baconbar_get_data();
	$classes  = 'header-bar';
	// Add the sticky class for a fixed-position bar.
	if ( $settings['is_sticky'] ) {
		$classes .= ' fixed-bar';
	}
	if ( $settings['has_border'] ) {
		$classes .= ' has-border';
	}
	if ( $settings['size'] ) {
		$classes .= ' ' . esc_attr( $settings['size'] );
	}
	// End here if we're not displaying a footer bar.
	if ( 'footer' !== $position ) {
		return $classes;
	}
	$classes  = 'footer-bar';
	// Add the sticky class for a fixed-position bar.
	if ( $settings['is_sticky'] ) {
		$classes .= ' fixed-footer';
	}
	if ( $settings['has_border'] ) {
		$classes .= ' has-border';
	}
	if ( $settings['size'] ) {
		$classes .= ' ' . esc_attr( $settings['size'] );
	}
	return $classes;
}

add_action( 'baconbar_header_content', 'baconbar_do_content' );
add_action( 'baconbar_footer_content', 'baconbar_do_content' );
/**
 * Display the bacon bar content based on user input.
 *
 * @uses   baconbar_get_data()
 * @since  1.0.1
 */
function baconbar_do_content() {
	$settings = baconbar_get_data();
	// Do nothing if the user hasn't entered any information to display.
	if ( ! baconbar_has_content() ) {
		$settings = baconbar_get_dummy_data();
	}
	$target_blank = ! empty( $settings['target_blank'] ) ? 'target="_blank"' : '';

	if ( $settings['teaser_text'] ) {
		echo '<p class="bacon-text">' . esc_attr( $settings['teaser_text'] ) . '</p>';
	}
	if ( $settings['button_url'] && $settings['button_text'] ) {
		echo '<a class="bacon-button" ' . $target_blank . ' href="' . esc_url( $settings['button_url'] ) . '">' . esc_attr( $settings['button_text'] ) . '</a>';
	}
}

/**
 * Display a template for the header Bacon Bar.
 *
 * @uses   baconbar_get_template_part
 * @since  1.0.1
 */
function baconbar_do_header_bar() {
	baconbar_get_template_part( 'bacon-bar' );
}

/**
 * Display a template for the footer Bacon Bar.
 *
 * @uses   baconbar_get_template_part
 * @since  1.0.1
 */
function baconbar_do_footer_bar() {
	baconbar_get_template_part( 'bacon-bar', 'footer' );
}
