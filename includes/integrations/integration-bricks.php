<?php

// includes/integrations/integration-bricks

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_bricks' );
/**
 * Register Bricks Builder.
 *
 * @since 1.8.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_bricks( array $integrations ) {

	$integrations[ 'bricks-builder' ] = array(
		'label'          => __( 'Bricks Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'bricks',
		'post_type'      => 'bricks_template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=bricks_template',
	);

	return $integrations;

}  // end function


add_filter( 'parent_file', 'ddw_btc_bricks_template_parent', 5 );
/**
 * When editing Bricks Templates in WordPress Admin (not in Builder itself),
 *   show the correct admin menu parent.
 *
 * @since 1.8.0
 *
 * @global string $GLOBALS[ 'submenu_file' ]
 *
 * @param  string $parent_file The filename of the parent menu.
 * @return string $parent_file The tweaked filename of the parent menu.
 */
function ddw_btc_bricks_template_parent( $parent_file ) {

    if ( 'bricks_template' === get_current_screen()->post_type ) {
        $GLOBALS[ 'submenu_file' ] = 'edit.php?post_type=bricks_template';
        $parent_file = 'bricks';
    }

    return $parent_file;

}  // end function
