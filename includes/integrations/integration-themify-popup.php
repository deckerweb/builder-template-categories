<?php

// includes/integrations/integration-themify-popup

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_themify_popup' );
/**
 * Register Themify Popup plugin.
 *
 * @since 1.1.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_themify_popup( array $integrations ) {

	$integrations[ 'themify-popup' ] = array(
		'label'          => __( 'Themify Popup Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=themify_popup',
		'post_type'      => 'themify_popup',
		'template_label' => 'popup',
		'admin_url'      => 'edit.php?post_type=themify_popup',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Popup type template
 *
 * @since 1.1.0
 */
add_filter( 'btc/filter/is_type/popup', '__return_true' );
