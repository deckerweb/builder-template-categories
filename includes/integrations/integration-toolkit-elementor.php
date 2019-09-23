<?php

// includes/integrations/integration-toolkit-elementor

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_toolkit_for_elementor' );
/**
 * Register ToolKit for Elementor plugin.
 *
 * @since 1.7.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_toolkit_for_elementor( array $integrations ) {

	$integrations[ 'toolkitfe-templates' ] = array(
		'label'          => __( 'ToolKit for Elementor Templates', 'builder-template-categories' ),
		'submenu_hook'   => \Elementor\Settings::PAGE_ID,
		'post_type'      => 'toolkit_template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=toolkit_template',
	);

	return $integrations;

}  // end function
