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
 * baconbar_default_options function.
 *
 * This function stores the default Bacon Bar options. It can be filtered using baconbar_default_options.
 *
 * @return $options, filtered by baconbar_default_options
 *
 * @since 1.0.0
 *
 */
function baconbar_default_options() {
	$options = array(
		'baconbar_button_url'   => '',
		'baconbar_button_text'  => '',
		'baconbar_target_blank' => '',
		'baconbar_teaser_text'  => '',
		'baconbar_above_site'   => '1',
		'baconbar_below_site'   => '',
		'baconbar_sticky_bar'   => '',
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

	add_action( 'load-'.$_baconbar_settings_hook, 'baconbar_settings_scripts' );
	add_action( 'load-'.$_baconbar_settings_hook, 'baconbar_settings_boxes' );
}


/* Setup our scripts
------------------------------------------------------------ */

/**
 * baconbar_settings_scripts function.
 *
 * This function enqueues the scripts needed for the Bacon Bar Settings settings page.
 *
 * @global $_baconbar_settings_hook
 *
 * @since 1.0.0
 *
 */
function baconbar_settings_scripts() {
	global $_baconbar_settings_hook;
	wp_enqueue_script( 'common' );
	wp_enqueue_script( 'wp-lists' );
	wp_enqueue_script( 'postbox' );
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
	add_meta_box( 'baconbar-styles-box',  __( 'Bacon Bar Styles', 'baconbar' ),  'baconbar_styles_metabox',  $_baconbar_settings_hook, 'main' );
	add_meta_box( 'baconbar-general-box', __( 'Bacon Bar Options', 'baconbar' ), 'baconbar_general_metabox', $_baconbar_settings_hook, 'main' );
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

	<p><?php _e( 'Add the content which will appear in your bacon bar.', 'baconbar' ); ?></p>
	<p>
		<label for="<?php echo $field . $button_text; ?>"><?php _e( 'Enter your button text:', 'baconbar' ); ?></label><br />
		<input type="text" name="<?php echo $field . $button_text; ?>" id="<?php echo  $field . $button_text; ?>" value="<?php echo esc_attr( genesis_get_option( 'baconbar_button_text', $field ) ) ?>" size="50" />
	</p>
	<p>
		<label for="<?php echo $field . $button_url; ?>"><?php _e( 'Enter your button URL:', 'baconbar' ); ?></label><br />
		<input type="text" name="<?php echo $field . $button_url; ?>" id="<?php echo  $field . $button_url; ?>" value="<?php echo esc_attr( genesis_get_option( 'baconbar_button_url', $field ) ) ?>" size="50" />

		<label for="<?php echo $field . $target_blank; ?>">
			<input type="checkbox" name="<?php echo $field . $target_blank; ?>" id="<?php echo $field . $target_blank; ?>" value="1" <?php checked( 1, genesis_get_option( 'baconbar_target_blank', $field ) ); ?> />
		<?php _e( 'Open in a new Window?', 'baconbar' ); ?></label>
	</p>
	<p>
		<label for="<?php echo $field . $teaser_text; ?>"><?php _e( 'Enter text you would like to display in your bacon bar:', 'baconbar' ); ?></label>
	</p>

	<textarea name="<?php echo $field . $teaser_text; ?>" id="<?php echo $field . $teaser_text; ?>" cols="78" rows="2"><?php echo esc_textarea(  genesis_get_option( 'baconbar_teaser_text', $field ) ); ?></textarea>

	<?php

}

/**
 * Bacon Bar style options.
 *
 * Callback function for the Bacon Bar Settings style metabox.
 *
 * @since 1.0.0
 *
 */
function baconbar_styles_metabox() {

	$field        = BACON_SETTINGS_FIELD;
	$button_url   = '[baconbar_button_url]';
	$target_blank = '[baconbar_target_blank]';
	$button_text  = '[baconbar_button_text]';
	$teaser_text  = '[baconbar_teaser_text]';

	?>

	<p><?php _e( 'Adjust the colors and styles for your baocn bar.', 'baconbar' ); ?></p>
	<p>
		<input type="checkbox" name="<?php echo $field . $facebook_link; ?>" id="<?php echo $field . $facebook_link; ?>" value="1" <?php checked( 1, genesis_get_option( 'baconbar_facebook_link', $field ) ); ?> />
		<label for="<?php echo $field . $facebook_link; ?>"><?php _e( 'Include a Facebook Like button on your posts?', 'baconbar' ); ?></label>
	</p>
	<p>
		<input type="checkbox" name="<?php echo $field; ?>[baconbar_twitter_link]" id="<?php echo $field; ?>[baconbar_twitter_link]" value="1" <?php checked( 1, genesis_get_option( 'baconbar_twitter_link', $field ) ); ?> />
		<label for="<?php echo $field; ?>[baconbar_twitter_link]"><?php _e( 'Include a Twitter Tweet button on your posts?', 'baconbar' ); ?></label>
	</p>
	<p>
		<input type="checkbox" name="<?php echo $field; ?>[baconbar_google_link]" id="<?php echo $field; ?>[baconbar_google_link]" value="1" <?php checked( 1, genesis_get_option( 'baconbar_google_link', $field ) ); ?> />
		<label for="<?php echo $field; ?>[baconbar_google_link]"><?php _e( 'Include a Google Plus button on your posts?', 'baconbar' ); ?></label>
	</p>
	<?php

}

/**
 * Bacon Bar general options.
 *
 * Callback function for the Bacon Bar Settings general metabox.
 *
 * @since 1.0.0
 *
 */
function baconbar_general_metabox() {

	$field = BACON_SETTINGS_FIELD;
	$above_site = '[baconbar_above_site]';
	$below_site = '[baconbar_below_site]';
	$sticky_bar = '[baconbar_sticky_bar]';

	?>

	<p><?php _e( 'Select options to change how your bacon bar works.', 'baconbar' ); ?></p>
	<p>
		<input type="checkbox" name="<?php echo $field . $above_site; ?>" id="<?php echo $field . $above_site; ?>" value="1" <?php checked( 1, genesis_get_option( 'baconbar_above_site', $field ) ); ?> />
		<label for="<?php echo $field . $above_site; ?>"><?php _e( 'Include the bacon bar above your site? (Header Bar)', 'baconbar' ); ?></label>
	</p>
	<p>
		<input type="checkbox" name="<?php echo $field; ?>[baconbar_google_link]" id="<?php echo $field; ?>[baconbar_google_link]" value="1" <?php checked( 1, genesis_get_option( 'baconbar_google_link', $field ) ); ?> />
		<label for="<?php echo $field; ?>[baconbar_google_link]"><?php _e( 'Include the bacon bar below your site? (Footer bar)', 'baconbar' ); ?></label>
	</p>
	<p>
		<input type="checkbox" name="<?php echo $field . $facebook_link; ?>" id="<?php echo $field . $facebook_link; ?>" value="1" <?php checked( 1, genesis_get_option( 'baconbar_facebook_link', $field ) ); ?> />
		<label for="<?php echo $field . $facebook_link; ?>"><?php _e( 'Make the bacon bar sticky? (Fixed position)', 'baconbar' ); ?></label>
	</p>
	<?php

}


/* Set the screen layout to one column
------------------------------------------------------------ */

add_filter( 'screen_layout_columns', 'baconbar_settings_layout_columns', 10, 2 );
/**
 * baconbar_settings_layout_columns function.
 *
 * This function sets the column layout to one for the Bacon Bar Settings settings page.
 *
 * @param mixed $columns
 * @param mixed $screen
 * @return $columns
 *
 * @since 1.0.0
 *
 */
function baconbar_settings_layout_columns( $columns, $screen ) {
	global $_baconbar_settings_hook;
	if ( $screen == $_baconbar_settings_hook ) {
		$columns[$_baconbar_settings_hook] = 1;
	}
	return $columns;
}


/* Build our theme options page
------------------------------------------------------------ */

/**
 * baconbar_options_page function.
 *
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
	<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready( function($) {
			// close postboxes that should be closed
			$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
			// postboxes setup
			postboxes.add_postbox_toggles('<?php echo $_baconbar_settings_hook; ?>');
		});
		//]]>
	</script>

<?php }