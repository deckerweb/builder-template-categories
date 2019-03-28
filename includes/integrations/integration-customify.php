<?php

// includes/integrations/integration-customify

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_customify' );
/**
 * Register Customify theme.
 *
 * @since 1.5.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_customify( array $integrations ) {

	$integrations[ 'customify-hooks' ] = array(
		'label'          => __( 'Customify Hooks', 'builder-template-categories' ),
		'submenu_hook'   => 'themes.php',
		'post_type'      => 'customify_hook',
		'template_label' => 'hook',
		'admin_url'      => 'edit.php?post_type=customify_hook',
	);

	return $integrations;

}  // end function
