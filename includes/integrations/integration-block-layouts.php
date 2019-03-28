<?php

// includes/integrations/integration-block-layouts

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_block_layouts' );
/**
 * Register Block Layouts.
 *
 * @since 1.2.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_block_layouts( array $integrations ) {

	$integrations[ 'block-layouts' ] = array(
		'label'          => __( 'Block Layouts', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=blocks_layout',
		'post_type'      => 'blocks_layout',
		'template_label' => 'layout',
		'admin_url'      => 'edit.php?post_type=blocks_layout',
	);

	return $integrations;

}  // end function
