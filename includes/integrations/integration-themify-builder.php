<?php

// includes/integrations/integration-themify-builder

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_themify_builder' );
/**
 * Register Themify Builder Page Builder.
 *
 * @since 1.1.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_themify_builder( array $integrations ) {

	$integrations[ 'themify-builder-layouts' ] = array(
		'label'          => __( 'Themify Builder Layouts', 'builder-template-categories' ),
		'submenu_hook'   => 'themify-builder',
		'post_type'      => 'tbuilder_layout',
		'template_label' => 'layout',
		'admin_url'      => 'edit.php?post_type=tbuilder_layout',
	);

	$integrations[ 'themify-builder-layout-parts' ] = array(
		'label'          => __( 'Themify Builder Layout Parts', 'builder-template-categories' ),
		'submenu_hook'   => 'themify-builder',
		'post_type'      => 'tbuilder_layout_part',
		'template_label' => 'layout',
		'admin_url'      => 'edit.php?post_type=tbuilder_layout_part',
	);

	return $integrations;

}  // end function


add_action( 'admin_menu', 'ddw_btc_remove_submenu_for_themify_layout_parts', 999 );
/**
 * Since we added support for TWO post types for this integration we need to
 *   remove one of the submenus in the admin again. Otherwise it would be highly
 *   confusing for users.
 *
 * @since 1.1.0
 *
 * @uses remove_submenu_page()
 */
function ddw_btc_remove_submenu_for_themify_layout_parts() {

	$page = remove_submenu_page(
		'themify-builder',
		'edit-tags.php?taxonomy=builder-template-category&post_type=tbuilder_layout_part'
	);

}  // end function
