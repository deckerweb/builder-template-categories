<?php

// includes/integrations/integration-anywhere-elementor

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_anywhere_elementor' );
/**
 * Register AnyWhere Elementor plugin.
 *
 * @since 1.0.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_anywhere_elementor( array $integrations ) {

	$integrations[ 'anywhere-elementor' ] = array(
		'label'          => __( 'AnyWhere Elementor Global Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=ae_global_templates',
		'post_type'      => 'ae_global_templates',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=ae_global_templates',
	);

	return $integrations;

}  // end function


/**
 * Set flag for WooCommerce product type template
 *
 * @since 1.1.0
 */
add_filter( 'btc/filter/is_type/woo', '__return_true' );
