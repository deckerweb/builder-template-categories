<?php

// includes/integrations/integration-widget-content-blocks

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_widget_content_blocks' );
/**
 * Register Widget Content Blocks.
 *
 * @since 1.2.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_widget_content_blocks( array $integrations ) {

	$integrations[ 'widget-content-blocks' ] = array(
		'label'          => __( 'Widget Content Blocks', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=wysiwyg-widget',
		'post_type'      => 'wysiwyg-widget',
		'template_label' => 'block',
		'admin_url'      => 'edit.php?post_type=wysiwyg-widget',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Block type template
 *
 * @since 1.2.0
 */
add_filter( 'btc/filter/is_type/block', '__return_true' );
