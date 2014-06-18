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

/**
 * Register a metabox and default settings for the Genesis Bacon Bar.
 *
 * @package Genesis\Admin
 */
class Bacon_Bar_Settings extends Genesis_Admin_Boxes {

	/**
	 * Create an archive settings admin menu item and settings page for relevant custom post types.
	 *
	 * @since 1.0.5
	 */
	public function __construct() {

		$settings_field = 'bacon-settings';
		$page_id = 'genesis-bacon-bar';
		$menu_ops = array(
			'submenu' => array(
				'parent_slug' => 'genesis',
				'page_title'  => __( 'Genesis Bacon Bar', 'baconbar' ),
				'menu_title'  => __( 'Bacon Bar Settings', 'baconbar' )
			)
		);
		$page_ops = array(); //* use defaults

		$default_settings = apply_filters(
			'baconbar_settings_defaults',
			array(
				'baconbar_teaser_text'  => __( 'Want More Traffic? Supercharge Your Site With a WordPress SEO Audit!', 'baconbar' ),
				'baconbar_button_text'  => __( 'Audit WP', 'baconbar' ),
				'baconbar_button_url'   => 'http://auditwp.com',
				'baconbar_target_blank' => 1,
				'baconbar_position'     => 'above',
				'baconbar_is_sticky'    => 0,
				'baconbar_size'         => 'large',
				'baconbar_has_border'   => 1,
			)
		);

		$this->create( $page_id, $menu_ops, $page_ops, $settings_field, $default_settings );

		add_action( 'genesis_settings_sanitizer_init', array( $this, 'sanitizer_filters' ) );
	}

	/**
	 * Register each of the settings with a sanitization filter type.
	 *
	 * @since 1.0.5
	 *
	 * @uses genesis_add_option_filter() Assign filter to array of settings.
	 *
	 * @see \Genesis_Settings_Sanitizer::add_filter()
	 */
	public function sanitizer_filters() {

		genesis_add_option_filter(
			'no_html',
			$this->settings_field,
			array(
				'baconbar_button_text',
				'baconbar_position',
				'baconbar_size',
			)
		);
		genesis_add_option_filter(
			'safe_html',
			$this->settings_field,
			array(
				'baconbar_teaser_text',
			)
		);
		genesis_add_option_filter(
			'one_zero',
			$this->settings_field,
			array(
				'baconbar_target_blank',
				'baconbar_is_sticky',
				'baconbar_has_border',
			)
		);
		genesis_add_option_filter(
			'url',
			$this->settings_field,
			array(
				'baconbar_button_url',
			)
		);
	}
	/**
	 * Register Metabox for the Genesis Bacon Bar.
	 *
	 * @param string $_genesis_theme_settings_pagehook
	 * @uses  add_meta_box()
	 * @since 1.0.2
	 */
	function metaboxes() {
		add_meta_box( 'baconbar-settings', 'Customize', array( $this, 'settings_box' ), $this->pagehook, 'main', 'high' );
	}

	/**
	 * Create Metabox which links to and explains the WordPress customizer.
	 *
	 * @uses  wp_customize_url()
	 * @since 1.0.2
	 */
	function settings_box() {
		$customizer_link = wp_customize_url( get_stylesheet() );
		echo '<p>';
			_e( 'The Genesis Bacon Bar is controlled by the WordPress Customizer. ', 'baconbar' );
			_e( 'You can edit the content, display options, and look and feel in real-time.', 'baconbar' );
		echo '</p>';
		echo '<p>';
			echo '<a class="button" href="' . $customizer_link . '">' . __( 'Customize Now', 'baconbar' ) . '</a>';
		echo '</p>';
	}
}
