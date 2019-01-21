<?php

// includes/integrations/integration-reusable-content-blocks

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_reusable_content_blocks' );
/**
 * Register Reusable Content Blocks plugin.
 *
 * @since 1.3.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_reusable_content_blocks( array $integrations ) {

	$integrations[ 'reusable-content-blocks-gb' ] = array(
		'label'          => __( 'Reusable Content Blocks', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=rc_blocks',
		'post_type'      => 'rc_blocks',
		'template_label' => 'block',
		'admin_url'      => 'edit.php?post_type=rc_blocks',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Block type template
 *
 * @since 1.3.0
 */
add_filter( 'btc/filter/is_type/block', '__return_true' );
