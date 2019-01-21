<?php

// includes/integrations/integration-lazy-blocks

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_lazy_blocks' );
/**
 * Register Lazy Blocks.
 *
 * @since 1.2.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_lazy_blocks( array $integrations ) {

	$integrations[ 'lazy-blocks' ] = array(
		'label'          => __( 'Lazy Block Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=lazyblocks',
		'post_type'      => 'lazyblocks',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=lazyblocks',
	);

	return $integrations;

}  // end function
