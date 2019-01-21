<?php

// includes/integrations/integration-smart-footer-system

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_smart_footer_system' );
/**
 * Register Smart Footer System.
 *
 * @since 1.4.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_smart_footer_system( array $integrations ) {

	$integrations[ 'smart-footer-system' ] = array(
		'label'          => __( 'Smart Footer Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=sfs-footer',
		'post_type'      => 'sfs-footer',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=sfs-footer',
	);

	return $integrations;

}  // end function
