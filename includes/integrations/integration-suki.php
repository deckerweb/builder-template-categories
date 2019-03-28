<?php

// includes/integrations/integration-suki

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_suki' );
/**
 * Register Suki theme.
 *
 * @since 1.5.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_suki( array $integrations ) {

	$integrations[ 'suki-blocks' ] = array(
		'label'          => __( 'Suki Custom Blocks', 'builder-template-categories' ),
		'submenu_hook'   => 'themes.php',
		'post_type'      => 'suki_block',
		'template_label' => 'block',
		'admin_url'      => 'edit.php?post_type=suki_block',
		'block_editor'   => 'register_early',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Block type template
 *
 * @since 1.5.0
 */
add_filter( 'btc/filter/is_type/block', '__return_true' );
