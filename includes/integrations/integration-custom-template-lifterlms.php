<?php

// includes/integrations/integration-custom-template-lifterlms

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_custom_template_lifterlms' );
/**
 * Register Custom Template for LifterLMS plugin.
 *
 * @since 1.3.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_custom_template_lifterlms( array $integrations ) {

	$integrations[ 'custom-template-lifterlms' ] = array(
		'label'          => __( 'LifterLMS Custom Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'llms-settings',
		'post_type'      => 'bsf-custom-template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=bsf-custom-template',
	);

	return $integrations;

}  // end function
