<?php

// includes/integrations/integration-brizy

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_brizy' );
/**
 * Register Brizy Page Builder.
 *
 * @since 1.0.1
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_brizy( array $integrations ) {

	$integrations[ 'brizy' ] = array(
		'label'          => __( 'Brizy Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'brizy-settings',
		'post_type'      => 'brizy_template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=brizy_template',
	);

	return $integrations;

}  // end function
