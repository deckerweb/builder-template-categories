<?php

// includes/integrations/integration-cmb2-admin-extension

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_cmb2_admin_extension' );
/**
 * Register CMB2 Admin Extension plugin.
 *
 * @since 1.3.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_cmb2_admin_extension( array $integrations ) {

	$integrations[ 'cmb2-admin-extension' ] = array(
		'label'          => __( 'CMB2 Meta Boxes', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=meta_box',
		'post_type'      => 'meta_box',
		'template_label' => 'box',
		'admin_url'      => 'edit.php?post_type=meta_box',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Box type template
 *
 * @since 1.3.0
 */
add_filter( 'btc/filter/is_type/box', '__return_true' );
