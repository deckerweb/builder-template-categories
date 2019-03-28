<?php

// includes/integrations/integration-page-builder-framework

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_page_builder_framework' );
/**
 * Register Page Builder Framework theme.
 *
 * @since 1.5.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_page_builder_framework( array $integrations ) {

	$integrations[ 'pbf-sections' ] = array(
		'label'          => __( 'Page Builder Framework Sections', 'builder-template-categories' ),
		'submenu_hook'   => 'themes.php',
		'post_type'      => 'wpbf_hooks',
		'template_label' => 'section',
		'admin_url'      => 'edit.php?post_type=wpbf_hooks',
		'block_editor'   => 'register_early',
	);

	return $integrations;

}  // end function
