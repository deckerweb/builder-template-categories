<?php

// includes/integrations/integration-bsf-sidebar-manager

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_bsf_sidebar_manager' );
/**
 * Register Sidebar Manager (by BSF) plugin.
 *
 * @since 1.6.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_bsf_sidebar_manager( array $integrations ) {

	$integrations[ 'bsf-sidebar-manager' ] = array(
		'label'          => __( 'Light Sidebar Manager - Sidebars', 'builder-template-categories' ),
		'submenu_hook'   => 'themes.php',	// 'edit.php?post_type=bsf-sidebar',
		'post_type'      => 'bsf-sidebar',
		'template_label' => 'sidebar',
		'admin_url'      => 'edit.php?post_type=bsf-sidebar',
	);

	return $integrations;

}  // end function
