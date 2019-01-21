<?php

// includes/integrations/integration-custom-field-suite

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_custom_field_suite' );
/**
 * Register Custom Field Suite plugin.
 *
 * @since 1.3.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_custom_field_suite( array $integrations ) {

	$integrations[ 'custom-field-suite' ] = array(
		'label'          => __( 'Custom Field Suite Field Groups', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=cfs',
		'post_type'      => 'cfs',
		'template_label' => 'field',
		'admin_url'      => 'edit.php?post_type=cfs',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Field type template
 *
 * @since 1.3.0
 */
add_filter( 'btc/filter/is_type/field', '__return_true' );


add_action( 'admin_menu', 'ddw_btc_add_submenu_cfs_addnew' );
/**
 * Since "Custom Field Suite" plugin has no left-hand "Add New" submenu in
 *   the addmin, we add this so it becomes more convenient for users.
 *
 * @since 1.3.0
 *
 * @uses add_submenu_page()
 * @uses ddw_btc_string_add_new()
 */
function ddw_btc_add_submenu_cfs_addnew() {

	add_submenu_page(
		'edit.php?post_type=cfs',
		ddw_btc_string_add_new(),
		ddw_btc_string_add_new(),
		'edit_theme_options',
		esc_url( admin_url( 'post-new.php?post_type=cfs' ) )
	);

}  // end function
