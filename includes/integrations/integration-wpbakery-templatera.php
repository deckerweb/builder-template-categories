<?php

// includes/integrations/integration-wpbakery-templatera

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_wpbakery_templatera' );
/**
 * Register Templatera plugin (for 'WPBakery Page Builder', formerly known as 'Visual Composer').
 *
 * @since  1.0.0
 *
 * @param  array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_wpbakery_templatera( array $integrations ) {

	$integrations[ 'wpbakery-templatera' ] = array(
		'label'          => __( 'WPBakery Page Builder Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'vc-general',
		'post_type'      => 'templatera',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=templatera',
	);

	return $integrations;

}  // end function