<?php

// includes/integrations/integration-sqh-placeholder-block

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_sqh_placeholder_block' );
/**
 * Register "Square Happiness: Placeholder Block".
 *
 * @since 1.2.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_sqh_placeholder_block( array $integrations ) {

	$integrations[ 'sqh-placeholder-blocks' ] = array(
		'label'          => __( 'Placeholder Blocks by Square Happiness', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=placeholder',
		'post_type'      => 'placeholder',
		'template_label' => 'block',
		'admin_url'      => 'edit.php?post_type=placeholder',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Block type template
 *
 * @since 1.2.0
 */
add_filter( 'btc/filter/is_type/block', '__return_true' );
