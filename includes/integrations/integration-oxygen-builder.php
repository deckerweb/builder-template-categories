<?php

// includes/integrations/integration-oxygen-builder

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_oxygen_builder' );
/**
 * Register Oxygen Builder (2.0+ required).
 *
 * @since  1.0.0
 *
 * @param  array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_oxygen_builder( array $integrations ) {

	$integrations[ 'oxygen-builder' ] = array(
		'label'          => __( 'Oxygen Builder Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'ct_dashboard_page',
		'post_type'      => 'ct_template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=ct_template',
	);

	return $integrations;

}  // end function