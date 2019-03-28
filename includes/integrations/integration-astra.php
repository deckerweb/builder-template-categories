<?php

// includes/integrations/integration-astra

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_astra' );
/**
 * Register Astra theme.
 *
 * @since 1.0.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_astra( array $integrations ) {

	$integrations[ 'astra-layouts' ] = array(
		'label'          => __( 'Astra Custom Layouts', 'builder-template-categories' ),
		'submenu_hook'   => 'themes.php',
		'post_type'      => 'astra-advanced-hook',
		'template_label' => 'layout',
		'admin_url'      => 'edit.php?post_type=astra-advanced-hook',
	);

	return $integrations;

}  // end function
