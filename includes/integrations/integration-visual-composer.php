<?php

// includes/integrations/integration-visual-composer

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_visual_composer' );
/**
 * Register Grid Templates for 'Visual Composer Website Builder' (the new one,
 *   not the old, now renamed "WPBakery").
 *   Also, optionally register "Global Templates" module, a official premium
 *   Add-On from the VC Hub.
 *
 * @since 1.4.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_visual_composer( array $integrations ) {

	/** If Hub (Premium) Module "Global Templates" is active */
	if ( ddw_btc_is_vc_global_templates_active() ) {

		$integrations[ 'visual-composer-global-templates' ] = array(
			'label'          => __( 'Visual Composer Global Templates', 'builder-template-categories' ),
			'submenu_hook'   => 'vcv-settings',		// 'edit.php?post_type=vcv_headers',
			'post_type'      => 'vcv_templates',
			'template_label' => 'template',
			'admin_url'      => 'edit.php?post_type=vcv_templates',
		);

	}  // end if

	/** Default built-in Header Builder (Templates) */
	$integrations[ 'visual-composer-header-templates' ] = array(
		'label'          => __( 'Visual Composer Header Builder Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'vcv-settings',		// 'edit.php?post_type=vcv_headers',
		'post_type'      => 'vcv_headers',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=vcv_headers',
	);

	/** Default built-in Footer Builder (Templates) */
	$integrations[ 'visual-composer-footer-templates' ] = array(
		'label'          => __( 'Visual Composer Footer Builder Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'vcv-settings',		// 'edit.php?post_type=vcv_headers',
		'post_type'      => 'vcv_footers',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=vcv_footers',
	);

	/** Default built-in Siderbars Builder (Templates) */
	$integrations[ 'visual-composer-sidebar-templates' ] = array(
		'label'          => __( 'Visual Composer Sidebar Builder Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'vcv-settings',		// 'edit.php?post_type=vcv_headers',
		'post_type'      => 'vcv_sidebars',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=vcv_sidebars',
	);

	return $integrations;

}  // end function


add_action( 'admin_menu', 'ddw_btc_remove_submenu_for_visual_composer_post_types', 999 );
/**
 * Since we added support for up to FOUR post types for this integration we need
 *   to remove up to three of the submenus in the admin again. Otherwise it
 *   would be highly confusing for users.
 *
 * @since 1.4.0
 *
 * @uses remove_submenu_page()
 */
function ddw_btc_remove_submenu_for_visual_composer_post_types() {

	if ( ddw_btc_is_vc_global_templates_active() ) {

		remove_submenu_page(
			'vcv-settings',
			'edit-tags.php?taxonomy=builder-template-category&post_type=vcv_headers'
		);

	}  // end if

	remove_submenu_page(
		'vcv-settings',
		'edit-tags.php?taxonomy=builder-template-category&post_type=vcv_footers'
	);

	remove_submenu_page(
		'vcv-settings',
		'edit-tags.php?taxonomy=builder-template-category&post_type=vcv_sidebars'
	);

}  // end function
