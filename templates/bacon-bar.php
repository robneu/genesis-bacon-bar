<?php
/**
 * Bacon bar header template.
 *
 * @package     Genesis Bacon Bar
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2013, FAT Media, LLC
 * @license     GPL-2.0+
 * @since       2.0.0
 */

// Get the Bacon bar's class settings.
$classes = baconbar_get_bar_class( 'header' );
// Display the bacon bar.
echo '<div class="bacon-bar ' . $classes . '">';
	echo '<div class="wrap">';
		do_action( 'baconbar_header_content' );
	echo '</div>';
echo '</div>';
