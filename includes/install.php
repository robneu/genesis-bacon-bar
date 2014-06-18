<?php
/**
 * Install functions.
 *
 * @package      Genesis Bacon Bar
 * @author       Robert Neu <http://wpbacon.com/>
 * @copyright    Copyright (c) 2014, FAT Media, LLC
 * @license      GPL-2.0+
 *
 */

// Exit if accessed directly
defined( 'WPINC' ) or die;

// Grab the plugin file.
$_plugin_file = $_dir . 'genesis-bacon-bar.php';

/**
 * Install
 *
 * Runs on plugin install and checks to make sure Genesis is activated.
 *
 * @since 1.0
 * @return void
 */
function baconbar_install( $_plugin_file ) {

	$theme_info = wp_get_theme();

	$genesis_flavors = array(
		'genesis',
		'genesis-trunk',
	);

	if ( ! in_array( $theme_info->Template, $genesis_flavors ) ) {
		deactivate_plugins( $_plugin_file ); // Deactivate ourself
		wp_die('Sorry, you can\'t activate unless you have installed <a href="http://www.studiopress.com/themes/genesis">Genesis</a>');
	}
}
register_activation_hook( $_plugin_file, 'baconbar_install' );

// Clean up
unset( $_plugin_file );
