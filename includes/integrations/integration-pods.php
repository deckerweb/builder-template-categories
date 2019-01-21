<?php

// includes/integrations/integration-pods

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_pods' );
/**
 * Register Pods plugin.
 *
 * @since 1.0.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_pods( array $integrations ) {

	$integrations[ 'pods-templates' ] = array(
		'label'          => __( 'Pods Templates', 'builder-template-categories' ) . ddw_btc_string_for_cpt_fields(),
		'submenu_hook'   => 'pods-add-new',
		'post_type'      => '_pods_template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=_pods_template',
	);

	return $integrations;

}  // end function
