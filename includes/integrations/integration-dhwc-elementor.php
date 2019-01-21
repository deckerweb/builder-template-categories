<?php

// includes/integrations/integration-dhwc-elementor

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_dhwc_elementor' );
/**
 * Register DHWC Elementor plugin.
 *
 * @since 1.0.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_dhwc_elementor( array $integrations ) {

	$integrations[ 'dhwc-elementor' ] = array(
		'label'          => __( 'DHWC Elementor Product Templates', 'builder-template-categories' ) . ddw_btc_string_for_woocommerce(),
		'submenu_hook'   => 'edit.php?post_type=product',
		'post_type'      => 'dhwc_template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=dhwc_template',
	);

	return $integrations;

}  // end function


/**
 * Set flag for WooCommerce product type template
 *
 * @since 1.1.0
 */
add_filter( 'btc/filter/is_type/woo', '__return_true' );
