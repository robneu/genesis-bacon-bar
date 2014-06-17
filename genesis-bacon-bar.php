<?php
/*
Plugin Name: Genesis Bacon Bar
Description: Creates a fixed-position call-to-action bar on any Genesis site.
Version: 1.0.1
License: GPL version 2 or any later version
Plugin URI: http://wpbacon.com/plugins/genesis-bacon-bar/
Author: WP Bacon
Author URI: http://wpbacon.com/
Text Domain: baconbar

==========================================================================

Copyright 2013-2014 FAT Media, LLC

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// Exit if accessed directly
defined( 'WPINC' ) or die;

// Grab this directory
$_dir = dirname( __FILE__ ) . '/';

// Include our core plugin files.
include( $_dir . 'includes/install.php' );
include( $_dir . 'includes/plugin.php' );

// Clean up
unset( $_dir );

// Handy function for grabbing the plugin instance
function genesis_bacon_bar() {
	return new Genesis_Bacon_Bar;
}

// Initialize the plugin
genesis_bacon_bar();
