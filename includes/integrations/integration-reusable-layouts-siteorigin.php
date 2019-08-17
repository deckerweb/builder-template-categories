<?php

// includes/integrations/integration-reusable-layouts-siteorigin

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_reusable_layouts_siteorigin' );
/**
 * Register Reusable Layouts for SiteOrigin plugin.
 *
 * @since 1.6.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_reusable_layouts_siteorigin( array $integrations ) {

	$integrations[ 'reusable-layouts-siteorigin' ] = array(
		'label'          => __( 'Reusable Layouts for SiteOrigin', 'builder-template-categories' ),
		'submenu_hook'   => 'themes.php',	// 'edit.php?post_type=echelonso_layout',
		'post_type'      => 'echelonso_layout',
		'template_label' => 'layout',
		'admin_url'      => 'edit.php?post_type=echelonso_layout',
	);

	return $integrations;

}  // end function
