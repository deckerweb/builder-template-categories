<?php

// includes/integrations/integration-hf-elementor

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_header_footer_elementor' );
/**
 * Register Header Footer for Elementor plugin.
 *
 * @since 1.0.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_header_footer_elementor( array $integrations ) {

	$integrations[ 'header-footer-elementor' ] = array(
		'label'          => __( 'Header &amp; Footer Templates for Elementor', 'builder-template-categories' ),
		'submenu_hook'   => 'themes.php',
		'post_type'      => 'elementor-hf',
		'template_label' => 'elhf-template',
		'admin_url'      => 'edit.php?post_type=elementor-hf',
	);

	return $integrations;

}  // end function
