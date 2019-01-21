<?php

// includes/integrations/integration-generatepress

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_generatepress' );
/**
 * Register GeneratePress theme.
 *
 * @since 1.0.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_generatepress( array $integrations ) {

	$integrations[ 'generatepress' ] = array(
		'label'          => __( 'GeneratePress Elements', 'builder-template-categories' ),
		'submenu_hook'   => 'themes.php',
		'post_type'      => 'gp_elements',
		'template_label' => 'element',
		'admin_url'      => 'edit.php?post_type=gp_elements',
	);

	return $integrations;

}  // end function
