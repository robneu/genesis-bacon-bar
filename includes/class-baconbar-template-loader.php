<?php
/**
 * Display output functions.
 *
 * @package           Rich_Recipes
 * @author            Robet Neu
 * @license           GPL-2.0+
 * @link              http://wpbacon.com
 * @copyright         2014 Robert Neu
 *
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Template loader.
 *
 * @package Cue
 * @since 1.0.0
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
