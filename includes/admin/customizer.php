<?php
/**
 * Genesis Bacon Bar Customizer Options.
 *
 * @package      Genesis Bacon Bar
 * @author       Robert Neu <http://wpbacon.com/>
 * @copyright    Copyright (c) 2014, FAT Media, LLC
 * @license      GPL-2.0+
 *
 */

// Exit if accessed directly
defined( 'WPINC' ) or die;

if ( ! class_exists( 'Genesis_Customizer_Base' ) ) :
/**
 *
 */
abstract class Genesis_Customizer_Base {

	/**
	 * Define defaults, call the `register` method, add css to head.
	 */
	public function __construct() {

		//** Register new customizer elements
		if ( method_exists( $this, 'register' ) ) {
			add_action( 'customize_register', array( $this, 'register'), 15 );
		} else {
			_doing_it_wrong( 'Genesis_Customizer_Base', __( 'When extending Genesis_Customizer_Base, you must create a register method.', 'baconbar' ) );
		}

		//* Customizer scripts
		if ( method_exists( $this, 'scripts' ) ) {
			add_action( 'customize_preview_init', 'scripts' );
		}

	}

	protected function get_field_name( $name ) {
		return sprintf( '%s[%s]', $this->settings_field, $name );
	}

	protected function get_field_id( $id ) {
		return sprintf( '%s[%s]', $this->settings_field, $id );
	}

	protected function get_field_value( $key ) {
		return genesis_get_option( $key, $this->settings_field );
	}

	function sanitize_text( $input ) {
		return wp_kses_post( force_balance_tags( $input ) );
	}

}
endif; // End class exists check.



/**
 *
 */
class Bacon_Bar_Customizer extends Genesis_Customizer_Base {

	/**
	 * Settings field.
	 */
	public $settings_field   = 'bacon-settings';
	public $control_priority = 0;

	/**
	 *
	 */
	public function register( $wp_customize ) {

		$this->content( $wp_customize );
		$this->display( $wp_customize );

	}

	private function content( $wp_customize ) {

		$settings = baconbar_get_data();

		$wp_customize->add_section(
			'baconbar_content',
			array(
				'title'    => __( 'Bacon Bar Content', 'baconbar' ),
				'priority' => 200,
			)
		);

		$wp_customize->add_setting(
			$this->get_field_name( 'baconbar_teaser_text' ),
			array(
				'default' => $settings['teaser_text'],
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			'baconbar_teaser_text',
			array(
				'label'    => __( 'Bacon Bar Action Text', 'baconbar' ),
				'section'  => 'baconbar_content',
				'settings' => $this->get_field_name( 'baconbar_teaser_text' ),
				'type'     => 'text',
				'priority' => $this->control_priority++,
			)
		);

		$wp_customize->add_setting(
			$this->get_field_name( 'baconbar_button_text' ),
			array(
				'default' => $settings['button_text'],
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			'baconbar_button_text',
			array(
				'label'    => __( 'Bacon Bar Button Text', 'baconbar' ),
				'section'  => 'baconbar_content',
				'settings' => $this->get_field_name( 'baconbar_button_text' ),
				'type'     => 'text',
				'priority' => $this->control_priority++,
			)
		);

		$wp_customize->add_setting(
			$this->get_field_name( 'baconbar_button_url' ),
			array(
				'default' => $settings['button_url'],
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			'baconbar_button_url',
			array(
				'label'    => __( 'Bacon Bar Button URL', 'baconbar' ),
				'section'  => 'baconbar_content',
				'settings' => $this->get_field_name( 'baconbar_button_url' ),
				'type'     => 'text',
				'priority' => $this->control_priority++,
			)
		);

		$wp_customize->add_setting(
			$this->get_field_name( 'baconbar_target_blank' ),
			array(
				'default' => $settings['target_blank'],
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			'baconbar_target_blank',
			array(
				'label' => __( 'Open Button Link in a New Window?', 'baconbar' ),
				'section' => 'baconbar_content',
				'settings' => $this->get_field_name( 'baconbar_target_blank' ),
				'type' => 'checkbox',
				'priority' => $this->control_priority++,
			)
		);

	}

	private function display( $wp_customize ) {

		$settings = baconbar_get_data();

		$wp_customize->add_section(
			'baconbar_display',
			array(
				'title'    => __( 'Bacon Bar Display Options', 'baconbar' ),
				'priority' => 200,
			)
		);

		$wp_customize->add_setting(
			$this->get_field_name( 'baconbar_position' ),
			array(
				'default' => $settings['position'],
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			'baconbar_position',
			array(
				'label'    => __( 'Bacon Bar Position', 'baconbar' ),
				'section'  => 'baconbar_display',
				'settings' => $this->get_field_name( 'baconbar_position' ),
				'type'     => 'select',
				'priority' => $this->control_priority++,
				'choices' => array(
					'above' => __( 'Above Site', 'baconbar' ),
					'below' => __( 'Below Site', 'baconbar' ),
				),
			)
		);

		$wp_customize->add_setting(
			$this->get_field_name( 'baconbar_sticky' ),
			array(
				'default' => $settings['is_sticky'],
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			'baconbar_sticky',
			array(
				'label' => __( 'Make the bacon bar sticky?', 'baconbar' ),
				'section' => 'baconbar_display',
				'settings' => $this->get_field_name( 'baconbar_sticky' ),
				'type' => 'checkbox',
				'priority' => $this->control_priority++,
			)
		);

		$wp_customize->add_setting(
			$this->get_field_name( 'baconbar_size' ),
			array(
				'default' => $settings['size'],
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			'baconbar_size',
			array(
				'label'    => __( 'Bacon Bar Size', 'baconbar' ),
				'section'  => 'baconbar_display',
				'settings' => $this->get_field_name( 'baconbar_size' ),
				'type'     => 'select',
				'priority' => $this->control_priority++,
				'choices' => array(
					'large'  => __( 'Large - 80px Tall', 'baconbar' ),
					'medium' => __( 'Medium - 50px Tall', 'baconbar' ),
					'small'  => __( 'Small - 30px Tall', 'baconbar' ),
				),
			)
		);

		$wp_customize->add_setting(
			$this->get_field_name( 'baconbar_has_border' ),
			array(
				'default' => $settings['has_border'],
				'type'    => 'option',
			)
		);

		$wp_customize->add_control(
			'baconbar_has_border',
			array(
				'label' => __( 'Add a border to the bacon bar?', 'baconbar' ),
				'section' => 'baconbar_display',
				'settings' => $this->get_field_name( 'baconbar_has_border' ),
				'type' => 'checkbox',
				'priority' => $this->control_priority++,
			)
		);

		$settings = array(
			'baconbar_bg_color'           => __( 'Bacon Bar Background Color', 'baconbar' ),
			'baconbar_text_color'         => __( 'Bacon Bar Text Color', 'baconbar' ),
			'baconbar_button_color'       => __( 'Bacon Bar Button Color', 'baconbar' ),
			'baconbar_button_hover_color' => __( 'Bacon Bar Button Hover Color', 'baconbar' ),
			'baconbar_button_text_color'  => __( 'Bacon Bar Button Text Color', 'baconbar' ),
		);

		foreach ( $settings as $setting => $label ) {

			$field_name = $this->get_field_name( $setting );

			$wp_customize->add_setting(
				$field_name,
				array(
					'default'           => '',
					'type'              => 'option',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
				new WP_Customize_Color_Control(
					$wp_customize,
					$setting,
					array(
						'label'    => $label,
						'section'  => 'baconbar_display',
						'priority' => $this->control_priority++,
						'settings' => $field_name,
					)
				)
			);

		}
	}

}

add_action( 'init', 'baconbar_customizer_init' );
/**
 *
 */
function baconbar_customizer_init() {
	new Bacon_Bar_Customizer;
}
