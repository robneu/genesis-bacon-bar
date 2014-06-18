<?php
/**
 * Genesis Bacon Bar Settings
 *
 * @package      Genesis Bacon Bar
 * @author       Robert Neu <http://wpbacon.com/>
 * @copyright    Copyright (c) 2014, FAT Media, LLC
 * @license      GPL-2.0+
 *
 */

// Exit if accessed directly
defined( 'WPINC' ) or die;

function plugin_add_settings_link( $links ) {
	$customizer_link = wp_customize_url( get_stylesheet() );
    $settings_link = '<a href="' . $customizer_link . '">' . __( 'Customize', 'baconbar' ) . '</a>';
  	array_push( $links, $settings_link );
  	return $links;
}
add_filter( 'plugin_action_links_' .  plugin_basename( BACON_BAR_FILE ), 'plugin_add_settings_link' );

add_action( 'genesis_theme_settings_metaboxes', 'baconbar_register_settings_box' );
/**
 * Register Metabox for the Genesis Bacon Bar.
 *
 * @param string $_genesis_theme_settings_pagehook
 * @since 1.0.2
 */
function baconbar_register_settings_box( $_genesis_theme_settings_pagehook ) {
	add_meta_box(
		'baconbar-settings',
		'Genesis Bacon Bar',
		'baconbar_settings_box',
		$_genesis_theme_settings_pagehook,
		'main',
		'high'
	);
}

/**
 * Create Metabox which links to and explains the WordPress customizer.
 *
 * @since 1.0.2
 */
function baconbar_settings_box() {
	$customizer_link = wp_customize_url( get_stylesheet() );
	echo '<p>';
		_e( 'The Genesis Bacon Bar is controlled by the WordPress Customizer. ', 'baconbar' );
		_e( 'You can edit the content, display options, and look and feel in real-time.', 'baconbar' );
	echo '</p>';
	echo '<p>';
		echo '<a class="button" href="' . $customizer_link . '">' . __( 'Customize Now', 'baconbar' ) . '</a>';
	echo '</p>';
}
