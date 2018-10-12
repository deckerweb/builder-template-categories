<?php

// includes/integrations/integration-loomisoft-content-blocks

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_loomisoft_content_blocks' );
/**
 * Register Reusable Content & Text Blocks by Loomisoft.
 *
 * @since  1.2.0
 *
 * @param  array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_loomisoft_content_blocks( array $integrations ) {

	$integrations[ 'loomisoft-content-blocks' ] = array(
		'label'          => __( 'Loomisoft Reusable Content Blocks', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=lscontentblock',
		'post_type'      => 'lscontentblock',
		'template_label' => 'block',
		'admin_url'      => 'edit.php?post_type=lscontentblock',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Block type template
 *
 * @since 1.2.0
 */
add_filter( 'btc/filter/is_type/block', '__return_true' );