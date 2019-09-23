<?php

// includes/integrations/integration-flo-forms

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_flo_forms' );
/**
 * Register Flo Forms plugin.
 *
 * @since 1.7.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_flo_forms( array $integrations ) {

	$integrations[ 'flo-forms' ] = array(
		'label'          => __( 'Flo Forms', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=flo_forms',
		'post_type'      => 'flo_forms',
		'template_label' => 'form',
		'admin_url'      => 'edit.php?post_type=flo_forms',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Form type template
 *
 * @since 1.7.0
 */
add_filter( 'btc/filter/is_type/form', '__return_true' );
