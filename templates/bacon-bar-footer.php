<?php
/**
 * Bacon bar footer template.
 *
 * @package     Genesis Bacon Bar
 * @subpackage  Genesis
 * @copyright   Copyright (c) 2013, FAT Media, LLC
 * @license     GPL-2.0+
 * @since       1.0.1
 */

// Get the Bacon bar's class settings.
$class = baconbar_get_bar_class( 'footer' );
// Display the bacon bar.
echo '<div class="bacon-bar ' . $class . '">';
	echo '<div class="wrap">';
		do_action( 'baconbar_footer_content' );
	echo '</div>';
echo '</div>';
