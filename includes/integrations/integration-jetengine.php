<?php

// includes/integrations/integration-jetengine

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_jetengine' );
/**
 * Register JetEngine plugin.
 *
 * @since 1.0.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_jetengine( array $integrations ) {

	$integrations[ 'jetengine' ] = array(
		'label'          => __( 'JetEngine Listing Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'jet-engine',
		'post_type'      => 'jet-engine',
		'template_label' => 'listing',
		'admin_url'      => 'edit.php?post_type=jet-engine',
	);

	return $integrations;

}  // end function
