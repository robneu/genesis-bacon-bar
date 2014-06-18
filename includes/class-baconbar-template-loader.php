<?php
/**
 * Template Loader Class.
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
 * Template loader.
 *
 * @package Genesis Bacon Bar
 * @since   1.0.0
 */
class Bacon_Bar_Template_Loader extends Gamajo_Template_Loader {
	/**
	 * Prefix for filter names.
	 *
	 * @var string
	 */
	protected $filter_prefix = 'baconbar';

	/**
	 * Directory name where custom templates for this plugin should be found in the theme.
	 *
	 * @var string
	 */
	protected $theme_template_directory = 'genesis-bacon-bar';

	/**
	 * Reference to the root directory path of this plugin.
	 *
	 * @var string
	 */
	protected $plugin_directory = BACON_BAR_DIR;
}
