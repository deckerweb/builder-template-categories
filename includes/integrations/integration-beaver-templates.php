<?php

// includes/integrations/integration-beaver-templates

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_beaver_builder_templates' );
/**
 * Register plugins:
 *   - Beaver Builder (Pro)
 *   - Beaver Themer
 *
 * @since 1.6.0
 *
 * @uses ddw_btc_is_beaver_builder_active()
 * @uses ddw_btc_is_beaver_themer_active()
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_beaver_builder_templates( array $integrations ) {

	if ( ddw_btc_is_beaver_builder_active() ) {
		
		$integrations[ 'beaver-builder-templates' ] = array(
			'label'          => __( 'Beaver Builder Templates', 'builder-template-categories' ),
			'submenu_hook'   => 'edit.php?post_type=fl-builder-template',
			'post_type'      => 'fl-builder-template',
			'template_label' => 'template',
			'admin_url'      => 'edit.php?post_type=fl-builder-template',
		);

	}  // end if

	if ( ddw_btc_is_beaver_themer_active() ) {

		$integrations[ 'beaver-themer-templates' ] = array(
			'label'          => __( 'Beaver Themer Templates', 'builder-template-categories' ),
			'submenu_hook'   => 'edit.php?post_type=fl-builder-template',
			'post_type'      => 'fl-theme-layout',
			'template_label' => 'template',
			'admin_url'      => 'edit.php?post_type=fl-theme-layout',
		);

	}  // end if

	return $integrations;

}  // end function


add_action( 'admin_menu', 'ddw_btc_remove_submenu_for_beaver_themer', 999 );
/**
 * If both supported official Beaver plugins are active at the same time, we
 *   need to remove one of the (identical) submenus in the admin again.
 *   Otherwise it would be highly confusing for users.
 *
 * @since 1.6.0
 *
 * @uses ddw_btc_is_beaver_builder_active()
 * @uses ddw_btc_is_beaver_themer_active()
 */
function ddw_btc_remove_submenu_for_beaver_themer() {

	if ( ddw_btc_is_beaver_builder_active() && ddw_btc_is_beaver_themer_active() ) {

		$page = remove_submenu_page(
			'edit.php?post_type=fl-builder-template',
			'edit-tags.php?taxonomy=builder-template-category&post_type=fl-theme-layout'
		);

	}  // end if

}  // end function
