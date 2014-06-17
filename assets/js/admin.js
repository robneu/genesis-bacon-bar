jQuery(document).ready(function($){
	// close postboxes that should be closed
	$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
	// postboxes setup
	postboxes.add_postbox_toggles('<?php echo $_baconbar_settings_hook; ?>');
	// Add color picker to the correct fields.
    $('.color-picker').wpColorPicker();
});