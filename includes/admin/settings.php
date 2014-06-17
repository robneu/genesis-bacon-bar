<?php
/**
 * Genesis Bacon Bar Settings
 *
 * @package      Genesis Bacon Bar
 * @author       Robert Neu <http://wpbacon.com/>
 * @copyright    Copyright (c) 2014, FAT Media, LLC
 * @license      GPL2+
 *
 */

// Exit if accessed directly
defined( 'WPINC' ) or die;

/* Setup default options
------------------------------------------------------------ */

/**
 * This function stores the default Bacon Bar options.
 * It can be filtered using baconbar_default_options.
 *
 * @return $options, filtered by baconbar_default_options
 * @since  1.0.0
 *
 */
function baconbar_default_options() {
	$options = array(
		'baconbar_button_url'         => '',
		'baconbar_button_text'        => '',
		'baconbar_target_blank'       => '',
		'baconbar_teaser_text'        => '',
		'baconbar_bg_color'           => '',
		'baconbar_text_color'         => '',
		'baconbar_button_color'       => '',
		'baconbar_button_hover_color' => '',
		'baconbar_button_text_color'  => '',
		'baconbar_position'           => 'above',
		'baconbar_sticky'             => '',
	);
	return apply_filters( 'baconbar_default_options', $options );
}


/* Sanitize any inputs
------------------------------------------------------------ */

add_action( 'genesis_settings_sanitizer_init', 'baconbar_sanitize_inputs' );
/**
 * baconbar_sanitize_inputs function.
 *
 * This function accesses Genesis' sanitization class to sanitize all users inputs and options in the Bacon Bar Settings settings area.
 *
 * @since 1.0.0
 *
 */
function baconbar_sanitize_inputs() {
	genesis_add_option_filter( 'url', BACON_SETTINGS_FIELD, array( 'baconbar_button_url' ) );
	genesis_add_option_filter( 'safe_html', BACON_SETTINGS_FIELD, array( 'baconbar_button_text', 'baconbar_target_blank', 'baconbar_teaser_text' ) );
}


/* Register our settings and add the options to the database
------------------------------------------------------------ */

add_action( 'admin_init', 'baconbar_register_settings' );
/**
 * baconbar_register_settings function.
 *
 * This function registers the settings for use in the Bacon Bar settings area. It also restores default options when
 * the Reset button is selected.
 *
 * @since 1.0.0
 *
 */
function baconbar_register_settings() {
	register_setting( BACON_SETTINGS_FIELD, BACON_SETTINGS_FIELD );
	add_option( BACON_SETTINGS_FIELD, baconbar_default_options() );

	if ( genesis_get_option( 'reset', BACON_SETTINGS_FIELD ) ) {
		update_option( BACON_SETTINGS_FIELD, baconbar_default_options() );
		genesis_admin_redirect( BACON_SETTINGS_FIELD, array( 'reset' => 'true' ) );
		exit;
	}
}


/* Admin notices for when options are saved/reset
------------------------------------------------------------ */

add_action( 'admin_notices', 'baconbar_settings_notice' );
/**
 * baconbar_settings_notice function.
 *
 * This function displays admin notices when the user updates Bacon Bar Settings' theme settings area.
 *
 * @since 1.0.0
 *
 */
function baconbar_settings_notice() {
	if ( ! isset( $_REQUEST['page'] ) || $_REQUEST['page'] != BACON_SETTINGS_FIELD ) {
		return;
	}

	if ( isset( $_REQUEST['reset'] ) && 'true' == $_REQUEST['reset'] ) {
		echo '<div id="message" class="updated"><p><strong>' . __( 'Settings reset.', 'baconbar' ) . '</strong></p></div>';
	}

	elseif ( isset( $_REQUEST['settings-updated'] ) && 'true' == $_REQUEST['settings-updated'] ) {
		echo '<div id="message" class="updated"><p><strong>' . __( 'Settings saved.', 'baconbar' ) . '</strong></p></div>';
	}
}


/* Register our theme options page
------------------------------------------------------------ */

add_action( 'admin_menu', 'baconbar_theme_options' );
/**
 * baconbar_theme_options function.
 *
 * This function registers the Bacon Bar Settings settings page and prepares the styles, scripts and metaboxes to be loaded.
 *
 * @global $_baconbar_settings_hook
 *
 * @since 1.0.0
 *
 */
function baconbar_theme_options() {
	global $_baconbar_settings_hook;
	$_baconbar_settings_hook = add_submenu_page( 'genesis', 'Bacon Bar Settings', 'Bacon Bar Settings', 'edit_theme_options', BACON_SETTINGS_FIELD, 'baconbar_options_page' );

	add_action( 'load-'.$_baconbar_settings_hook, 'baconbar_settings_styles' );
	add_action( 'load-'.$_baconbar_settings_hook, 'baconbar_settings_scripts' );
	add_action( 'load-'.$_baconbar_settings_hook, 'baconbar_settings_boxes' );
}


/* Setup our scripts
------------------------------------------------------------ */

/**
 * baconbar_settings_styles function.
 *
 * This function enqueues the scripts needed for the Bacon Bar Settings settings page.
 *
 * @global $_baconbar_settings_hook
 *
 * @since 1.0.0
 *
 */
function baconbar_settings_styles() {
	global $_baconbar_settings_hook;
	$css_uri = BACON_BAR_URL . 'assets/css/';
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_style( 'baconbar-admin', $css_uri .'admin-style.css', array(), '1.0.0' );
}

/**
 * This function enqueues the scripts needed for the Bacon Bar Settings settings page.
 *
 * @global $_baconbar_settings_hook
 * @since 1.0.0
 *
 */
function baconbar_settings_scripts() {
	global $_baconbar_settings_hook;
	$js_uri = BACON_BAR_URL . 'assets/js/';
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'wp-lists' );
	wp_enqueue_script( 'postbox' );
    wp_enqueue_script( 'baconbar-admin', $js_uri .'admin.js', array( 'wp-color-picker' ), '1.0.0', true );
}


/* Setup our metaboxes
------------------------------------------------------------ */

/**
 * baconbar_settings_boxes function.
 *
 * This function sets up the metaboxes to be populated by their respective callback functions.
 *
 * @global $_baconbar_settings_hook
 *
 * @since 1.0.0
 *
 */
function baconbar_settings_boxes() {
	global $_baconbar_settings_hook;
	add_meta_box( 'baconbar-content-box', __( 'Bacon Bar Content', 'baconbar' ), 'baconbar_content_metabox', $_baconbar_settings_hook, 'main' );
	add_meta_box( 'baconbar-position-box', __( 'Bacon Bar Position', 'baconbar' ), 'baconbar_position_metabox', $_baconbar_settings_hook, 'main' );
	add_meta_box( 'baconbar-colors-box',  __( 'Bacon Bar Colors', 'baconbar' ),  'baconbar_colors_metabox',  $_baconbar_settings_hook, 'main' );
}

/* Add our custom post metabox for social sharing
------------------------------------------------------------ */

/**
 * baconbar_content_metabox function.
 *
 * Callback function for the Bacon Bar Settings content metabox.
 *
 * @since 1.0.0
 *
 */
function baconbar_content_metabox() {
	$field        = BACON_SETTINGS_FIELD;
	$button_url   = '[baconbar_button_url]';
	$target_blank = '[baconbar_target_blank]';
	$button_text  = '[baconbar_button_text]';
	$teaser_text  = '[baconbar_teaser_text]';
	?>

	<h4><?php _e( 'Add the content which will appear in your bacon bar.', 'baconbar' ); ?></h4>
	<p>
		<label for="<?php echo $field . $teaser_text; ?>"><?php _e( 'Enter text you would like to display in your bacon bar:', 'baconbar' ); ?></label>
		<input type="text" class="widefat" name="<?php echo $field . $teaser_text; ?>" id="<?php echo $field . $teaser_text; ?>" value="<?php echo esc_textarea(  genesis_get_option( 'baconbar_teaser_text', $field ) ); ?>" />
	</p>
	<p class="one-half first">
		<label for="<?php echo $field . $button_text; ?>"><?php _e( 'Enter your button text:', 'baconbar' ); ?></label><br />
		<input type="text" class="widefat" name="<?php echo $field . $button_text; ?>" id="<?php echo  $field . $button_text; ?>" value="<?php echo esc_attr( genesis_get_option( 'baconbar_button_text', $field ) ) ?>" />
	</p>
	<p class="one-half">
		<label for="<?php echo $field . $button_url; ?>"><?php _e( 'Enter your button link URL:', 'baconbar' ); ?></label><br />
		<input type="text" class="widefat" name="<?php echo $field . $button_url; ?>" id="<?php echo  $field . $button_url; ?>" value="<?php echo esc_attr( genesis_get_option( 'baconbar_button_url', $field ) ) ?>" />
	</p>
	<p>
		<label for="<?php echo $field . $target_blank; ?>">
			<input type="checkbox" name="<?php echo $field . $target_blank; ?>" id="<?php echo $field . $target_blank; ?>" value="1" <?php checked( 1, genesis_get_option( 'baconbar_target_blank', $field ) ); ?> />
		<?php _e( 'Open Button Link in a new Window?', 'baconbar' ); ?></label>
	</p>
	<?php
}

/**
 * Bacon Bar position options.
 *
 * Callback function for the Bacon Bar Settings position metabox.
 *
 * @since 1.0.0
 *
 */
function baconbar_position_metabox() {
	$field = BACON_SETTINGS_FIELD;
	$position   = '[baconbar_position]';
	$sticky_top = '[baconbar_sticky]';
	?>

	<h4><?php _e( 'Select options to change how your bacon bar will display.', 'baconbar' ); ?></h4>
	<p>
		<label for="<?php echo $field . $position; ?>"><?php _e( 'Where would you like to display the bacon bar on your site?', 'baconbar' ); ?></label>
		<select class="widefat" name="<?php echo $field . $position; ?>" id="<?php echo $field . $position; ?>">
			<option value="above" <?php selected( genesis_get_option( 'baconbar_position', $field ), 'above' ) ?>><?php _e( 'Above my site (Header Bar)', 'baconbar' ); ?></option>
			<option value="below" <?php selected( genesis_get_option( 'baconbar_position', $field ), 'below' ) ?>><?php _e( 'Below my site (Footer Bar)', 'baconbar' ); ?></option>
		</select>
	<p>
		<input type="checkbox" name="<?php echo $field . $sticky_top; ?>" id="<?php echo $field . $sticky_top; ?>" value="1" <?php checked( 1, genesis_get_option( 'baconbar_sticky', $field ) ); ?> />
		<label for="<?php echo $field . $sticky_top; ?>"><?php _e( 'Make the bacon bar sticky? (Fixed position)', 'baconbar' ); ?></label>
	</p>
	<?php
}

/**
 * Bacon Bar color options.
 *
 * Callback function for the Bacon Bar Settings color metabox.
 *
 * @since 1.0.0
 *
 */
function baconbar_colors_metabox() {
	$field          = BACON_SETTINGS_FIELD;
	$bg_color       = '[baconbar_bg_color]';
	$text_color     = '[baconbar_text_color]';
	$button_color   = '[baconbar_button_color]';
	$hover_color    = '[baconbar_button_hover_color]';
	$btn_text_color = '[baconbar_button_text_color]';
	?>

	<h4><?php _e( 'Adjust the colors and styles for your bacon bar.', 'baconbar' ); ?></h4>
	<p class="color-pircker-row">
		<span><?php _e( 'Choose the background color for your bacon bar:', 'baconbar' ); ?></span>
		<input type="text" class="color-picker" name="<?php echo $field . $bg_color; ?>" id="<?php echo  $field . $bg_color; ?>" data-default-color="#312D2E" value="<?php echo genesis_get_option( 'baconbar_bg_color', $field ) ?>" />
	</p>
	<p class="color-pircker-row odd">
		<span><?php _e( 'Choose the text color for your bacon bar:', 'baconbar' ); ?></span>
		<input type="text" class="color-picker" name="<?php echo $field . $text_color; ?>" id="<?php echo  $field . $text_color; ?>" data-default-color="#ffffff" value="<?php echo esc_attr( genesis_get_option( 'baconbar_text_color', $field ) ) ?>" />
	</p>
	<p class="color-pircker-row">
		<span><?php _e( 'Choose the button color for your bacon bar:', 'baconbar' ); ?></span>
		<input type="text" class="color-picker" name="<?php echo $field . $button_color; ?>" id="<?php echo  $field . $button_color; ?>" data-default-color="#D55454" value="<?php echo esc_attr( genesis_get_option( 'baconbar_button_color', $field ) ) ?>" />
	</p>
	<p class="color-pircker-row odd">
		<span><?php _e( 'Choose the button hover color for your bacon bar:', 'baconbar' ); ?></span>
		<input type="text" class="color-picker" name="<?php echo $field . $hover_color; ?>" id="<?php echo  $field . $hover_color; ?>" data-default-color="#DE5858" value="<?php echo esc_attr( genesis_get_option( 'baconbar_button_hover_color', $field ) ) ?>" />
	</p>
	<p class="color-pircker-row">
		<span><?php _e( 'Choose the button text color for your bacon bar:', 'baconbar' ); ?></span>
		<input type="text" class="color-picker" name="<?php echo $field . $btn_text_color; ?>" id="<?php echo  $field . $btn_text_color; ?>" data-default-color="#ffffff" value="<?php echo esc_attr( genesis_get_option( 'baconbar_button_text_color', $field ) ) ?>" />
	</p>
	<?php
}


/* Build our theme options page
------------------------------------------------------------ */

/**
 * This function displays the content for the Bacon Bar Settings settings page, builds the forms and outputs the metaboxes.
 *
 * @global $_baconbar_settings_hook
 * @global $screen_layout_columns
 *
 * @since 1.0.0
 *
 */
function baconbar_options_page() {
	global $_baconbar_settings_hook;
	$hide2 = $hide3 = " display: none;";
	?>

	<div id="baconbar" class="wrap genesis-metaboxes">
		<form method="post" action="options.php">

			<?php wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false ); ?>
			<?php wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false ); ?>
			<?php settings_fields( BACON_SETTINGS_FIELD ); ?>

			<h2><?php _e( 'Bacon Bar Settings', 'baconbar' ); ?></h2>
			<p class="top-buttons">
				<input type="submit" class="button button-primary" value="<?php _e( 'Save Settings', 'baconbar' ) ?>" />
				<input type="submit" class="button button-secondary" name="<?php echo BACON_SETTINGS_FIELD; ?>[reset]" value="<?php _e( 'Reset Settings', 'baconbar' ); ?>" onclick="return genesis_confirm('<?php echo esc_js( __( 'Are you sure you want to reset?', 'baconbar' ) ); ?>');" />
			</p>

			<div class="metabox-holder">
				<div class="postbox-container">
					<?php do_meta_boxes( $_baconbar_settings_hook, 'main', null ); ?>
				</div>
			</div>

		</form>
	</div>
<?php }
