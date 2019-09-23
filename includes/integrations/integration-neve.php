<?php

// includes/integrations/integration-neve

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_neve_pro' );
/**
 * Register Neve theme - Pro Add-On.
 *
 * @since 1.7.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_neve_pro( array $integrations ) {

	$integrations[ 'neve-layouts' ] = array(
		'label'          => __( 'Neve Custom Layouts', 'builder-template-categories' ),
		'submenu_hook'   => 'themes.php',
		'post_type'      => 'neve_custom_layouts',
		'template_label' => 'layout',
		'admin_url'      => 'edit.php?post_type=neve_custom_layouts',
		'block_editor'   => 'register_early',
	);

	return $integrations;

}  // end function
