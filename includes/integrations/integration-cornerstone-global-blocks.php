<?php

// includes/integrations/integration-cornerstone-global-blocks

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_cornerstone_global_blocks' );
/**
 * Register Global Blocks for Cornerstone plugin.
 *
 * @since 1.0.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_cornerstone_global_blocks( array $integrations ) {

	$integrations[ 'cornerstone-global-blocks' ] = array(
		'label'          => __( 'Global Content Blocks for Cornerstone Page Builder', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=global-blocks',
		'post_type'      => 'global-blocks',
		'template_label' => 'block',
		'admin_url'      => 'edit.php?post_type=global-blocks',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Block type template
 *
 * @since 1.2.0
 */
add_filter( 'btc/filter/is_type/block', '__return_true' );
