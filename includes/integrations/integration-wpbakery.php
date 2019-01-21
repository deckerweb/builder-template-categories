<?php

// includes/integrations/integration-wpbakery

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_wpbakery_page_builder' );
/**
 * Register Grid Templates for 'WPBakery Page Builder' (formerly known as
 *   'Visual Composer').
 *   Also, optionally register "Templatera" plugin, a premium Add-On for
 *   'WPBakery Page Builder'.
 *
 * @since 1.0.0
 * @since 1.1.0 Partly refactoring.
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_wpbakery_page_builder( array $integrations ) {

	/** If Add-On plugin "Templatera" is active */
	if ( ddw_btc_is_wpbakery_templatera_active() ) {

		$integrations[ 'wpbakery-templatera' ] = array(
			'label'          => __( 'WPBakery Page Builder Templates', 'builder-template-categories' ),
			'submenu_hook'   => 'vc-general',
			'post_type'      => 'templatera',
			'template_label' => 'template',
			'admin_url'      => 'edit.php?post_type=templatera',
		);

	}  // end if

	/** Default built-in Grid Builder (Templates) */
	$integrations[ 'wpbakery-grid-templates' ] = array(
		'label'          => __( 'WPBakery Grid Builder Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'vc-general',
		'post_type'      => 'vc_grid_item',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=vc_grid_item',
	);

	return $integrations;

}  // end function


add_action( 'admin_menu', 'ddw_btc_remove_submenu_for_wpbakery_post_types', 999 );
/**
 * Since we added support for up to TWO post types for this integration we need
 *   to remove one of the submenus in the admin again - in the case both are
 *   active at the same time. Otherwise it would be highly confusing for users.
 *
 * @since 1.1.0
 *
 * @uses remove_submenu_page()
 */
function ddw_btc_remove_submenu_for_wpbakery_post_types() {

	/** Bail early if Pro version of plugin is not active */
	if ( ! ddw_btc_is_wpbakery_templatera_active() ) {
		return;
	}

	remove_submenu_page(
		'vc-general',
		'edit-tags.php?taxonomy=builder-template-category&post_type=vc_grid_item'
	);

}  // end function
