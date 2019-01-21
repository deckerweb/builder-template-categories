<?php

// includes/integrations/integration-templementor

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_templementor' );
/**
 * Register Templementor plugin.
 *
 * @since 1.1.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_templementor( array $integrations ) {

	$integrations[ 'templementor' ] = array(
		'label'          => __( 'Templementor Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=elementor_library',
		'post_type'      => 'tpm_templates',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=tpm_templates',
	);

	return $integrations;

}  // end function
