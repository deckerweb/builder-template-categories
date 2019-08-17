<?php

// includes/integrations/integration-divi-templates

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_divi_builder_templates' );
/**
 * Register plugin/ themes:
 *   - Divi Builder (plugin version)
 *   - Divi Theme
 *   - Extra Theme
 *
 * @since 1.6.0
 *
 * @uses ddw_btc_is_extra_theme_active()
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_divi_builder_templates( array $integrations ) {

	$submenu_hook = ddw_btc_is_extra_theme_active() ? 'et_extra_options' : 'et_divi_options';
		
	$integrations[ 'divi-builder-templates' ] = array(
		'label'          => __( 'Divi Builder Templates', 'builder-template-categories' ),
		'submenu_hook'   => $submenu_hook,
		'post_type'      => 'et_pb_layout',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=et_pb_layout',
	);

	if ( ddw_btc_is_extra_theme_active() && post_type_exists( 'layout' ) ) {

		$integrations[ 'divi-builder-layouts' ] = array(
			'label'          => __( 'Extra Category Layout Templates', 'builder-template-categories' ),
			'submenu_hook'   => 'et_extra_options',
			'post_type'      => 'layout',
			'template_label' => 'template',
			'admin_url'      => 'edit.php?post_type=layout',
		);

	}  // end if

	return $integrations;

}  // end function


add_action( 'admin_menu', 'ddw_btc_remove_submenu_for_extra_layout', 999 );
/**
 * If both supported official Divi template post types are existing at the same
 *   time, we need to remove one of the (identical) submenus in the admin again.
 *   Otherwise it would be highly confusing for users.
 *
 * @since 1.6.0
 *
 * @uses ddw_btc_is_extra_theme_active()
 */
function ddw_btc_remove_submenu_for_extra_layout() {

	if ( ddw_btc_is_extra_theme_active() ) {

		$page = remove_submenu_page(
			'et_extra_options',
			'edit-tags.php?taxonomy=builder-template-category&post_type=layout'
		);

	}  // end if

}  // end function
