<?php
/**
 * Genesis Bacon Bar admin Funcitons.
 *
 * @package      Genesis Bacon Bar
 * @author       Robert Neu <http://wpbacon.com/>
 * @copyright    Copyright (c) 2014, FAT Media, LLC
 * @license      GPL-2.0+
 *
 */

add_action( 'after_setup_theme', 'baconbar_add_admin_menus' );
/**
 * Add Genesis top-level item in admin menu.
 *
 * Calls the `genesis_admin_menu hook` at the end - all submenu items should be attached to that hook to ensure
 * correct ordering.
 *
 * @since 1.0.5
 * @return null Returns null if Genesis menu is disabled, or disabled for current user
 */
function baconbar_add_admin_menus() {
	$_baconbar_settings = new Bacon_Bar_Settings;
	return $_baconbar_settings;
}

add_filter( 'plugin_action_links_' .  plugin_basename( BACON_BAR_FILE ), 'baconbar_add_settings_link' );
/**
 * Add a link to the WordPress customizer to the plugin action links.
 *
 * @param  array $links default plugin action links
 * @return array $links modified plugin action links
 * @uses   wp_customize_url()
 * @since  1.0.2
 */
function baconbar_add_settings_link( $links ) {
	$customizer_link = wp_customize_url( get_stylesheet() );
    $settings_link = '<a href="' . $customizer_link . '">' . __( 'Customize', 'baconbar' ) . '</a>';
  	array_push( $links, $settings_link );
  	return $links;
}
