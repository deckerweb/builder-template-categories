<?php

// includes/integrations/integration-popup-maker

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_popup_maker' );
/**
 * Register Popup Maker plugin.
 *
 * @since 1.0.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_popup_maker( array $integrations ) {

	$integrations[ 'popup-maker' ] = array(
		'label'          => __( 'Popup Maker Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=popup',
		'post_type'      => 'popup',
		'template_label' => 'popup',
		'admin_url'      => 'edit.php?post_type=popup',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Popup type template
 *
 * @since 1.1.0
 */
add_filter( 'btc/filter/is_type/popup', '__return_true' );
