<?php

// includes/integrations/integration-jetsmartfilters

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_jetsmartfilters' );
/**
 * Register JetSmartFilters plugin.
 *
 * @since 1.3.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_jetsmartfilters( array $integrations ) {

	$integrations[ 'jetsmartfilters' ] = array(
		'label'          => __( 'JetSmartFilters Filter Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=jet-smart-filters',
		'post_type'      => 'jet-smart-filters',
		'template_label' => 'filter',
		'admin_url'      => 'edit.php?post_type=jet-smart-filters',
	);

	return $integrations;

}  // end function
