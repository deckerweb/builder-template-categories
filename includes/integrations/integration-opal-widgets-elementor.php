<?php

// includes/integrations/integration-opal-widgets-elementor

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_opal_widgets_elementor' );
/**
 * Register Opal Widgets for Elementor plugin.
 *
 * @since 1.3.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_opal_widgets_elementor( array $integrations ) {

	$integrations[ 'opal-widgets-elementor-header' ] = array(
		'label'          => __( 'Opal Header Templates for Elementor', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=header',
		'post_type'      => 'header',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=header',
	);

	$integrations[ 'opal-widgets-elementor-footer' ] = array(
		'label'          => __( 'Opal Footer Templates for Elementor', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=footer',
		'post_type'      => 'footer',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=footer',
	);

	return $integrations;

}  // end function
