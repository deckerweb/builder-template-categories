<?php

// includes/integrations/integration-cartflows

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_cartflows' );
/**
 * Register CartFlows plugin.
 *
 * @since 1.5.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_cartflows( array $integrations ) {

	$integrations[ 'cartflows' ] = array(
		'label'          => __( 'CartFlows Checkout Flows', 'builder-template-categories' ) . ddw_btc_string_for_woocommerce(),
		'submenu_hook'   => 'cartflows',	//'edit.php?post_type=cartflows_flow',
		'post_type'      => 'cartflows_flow',
		'template_label' => 'flow',
		'admin_url'      => 'edit.php?post_type=cartflows_flow',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Flow type template
 *
 * @since 1.5.0
 */
add_filter( 'btc/filter/is_type/flow', '__return_true' );
