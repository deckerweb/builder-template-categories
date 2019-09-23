<?php

// includes/integrations/integration-boxzilla

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_boxzilla' );
/**
 * Register Boxzilla plugin.
 *
 * @since 1.7.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_boxzilla( array $integrations ) {

	$integrations[ 'boxzilla-boxes' ] = array(
		'label'          => __( 'Boxzilla Boxes', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=boxzilla-box',
		'post_type'      => 'boxzilla-box',
		'template_label' => 'box',
		'admin_url'      => 'edit.php?post_type=boxzilla-box',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Box type template
 *
 * @since 1.7.0
 */
add_filter( 'btc/filter/is_type/box', '__return_true' );


/**
 * Set flag for Popup type template
 *
 * @since 1.7.0
 */
add_filter( 'btc/filter/is_type/popup', '__return_true' );
