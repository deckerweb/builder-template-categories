<?php

// includes/integrations/integration-oceanwp

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_oceanwp' );
/**
 * Register OceanWP theme.
 *
 * @since 1.0.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_oceanwp( array $integrations ) {

	$integrations[ 'generatepress' ] = array(
		'label'          => __( 'OceanWP Library', 'builder-template-categories' ),
		'submenu_hook'   => 'oceanwp-panel',
		'post_type'      => 'oceanwp_library',
		'template_label' => 'library',
		'admin_url'      => 'edit.php?post_type=oceanwp_library',
	);

	return $integrations;

}  // end function
