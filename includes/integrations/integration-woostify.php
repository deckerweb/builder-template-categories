<?php

// includes/integrations/integration-woostify

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_woostify' );
/**
 * Register Woostify theme.
 *
 * @since 1.7.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_woostify( array $integrations ) {

	$integrations[ 'woostify-header-footer' ] = array(
		'label'          => __( 'Woostify Pro Header Footer Builder Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'woostify-welcome',
		'post_type'      => 'hf_builder',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=hf_builder',
		'block_editor'   => 'register_early',
	);

	return $integrations;

}  // end function
