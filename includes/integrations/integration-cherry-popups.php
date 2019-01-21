<?php

// includes/integrations/integration-cherry-popups

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_cherry_popups' );
/**
 * Register Cherry PopUps plugin.
 *
 * @since 1.1.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_cherry_popups( array $integrations ) {

	$integrations[ 'cherry-popups' ] = array(
		'label'          => __( 'Cherry PopUps Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=cherry_popups',
		'post_type'      => 'cherry_popups',
		'template_label' => 'popup',
		'admin_url'      => 'edit.php?post_type=cherry_popups',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Popup type template
 *
 * @since 1.1.0
 */
add_filter( 'btc/filter/is_type/popup', '__return_true' );
