<?php

// includes/integrations/integration-block-areas

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_block_areas' );
/**
 * Register Block Areas plugin.
 *
 * @since 1.6.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_block_areas( array $integrations ) {

	$integrations[ 'block-areas' ] = array(
		'label'          => __( 'Block Areas', 'builder-template-categories' ),
		'submenu_hook'   => 'themes.php',	// 'edit.php?post_type=block_area',
		'post_type'      => 'block_area',
		'template_label' => 'area',
		'admin_url'      => 'edit.php?post_type=block_area',
		'block_editor'   => 'register_early',
	);

	return $integrations;

}  // end function
