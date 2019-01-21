<?php

// includes/integrations/integration-avada-fusion-builder

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_avada_fusion_builder' );
/**
 * Register Avada Theme with Fusion Builder plugin.
 *
 * @since 1.4.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_avada_fusion_builder( array $integrations ) {

	$integrations[ 'avada-fusion-builder-templates' ] = array(
		'label'          => __( 'Avada Fusion Builder Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'fusion-builder-options',
		'post_type'      => 'fusion_template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=fusion_template',
	);

	$integrations[ 'avada-fusion-builder-elements' ] = array(
		'label'          => __( 'Avada Fusion Builder Elements', 'builder-template-categories' ),
		'submenu_hook'   => 'fusion-builder-options',
		'post_type'      => 'fusion_element',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=fusion_element',
	);

	return $integrations;

}  // end function


add_action( 'admin_menu', 'ddw_btc_remove_submenu_for_avada_post_types', 999 );
/**
 * Since we added support for up to TWO post types for this integration we need
 *   to remove one of the submenus in the admin again - in the case both are
 *   active at the same time. Otherwise it would be highly confusing for users.
 *
 * @since 1.4.0
 *
 * @uses remove_submenu_page()
 */
function ddw_btc_remove_submenu_for_avada_post_types() {

	remove_submenu_page(
		'fusion-builder-options',
		'edit-tags.php?taxonomy=builder-template-category&post_type=fusion_element'
	);

}  // end function


add_action( 'admin_menu', 'ddw_btc_add_submenu_avada_fusion_builder_cpts', 999 );
/**
 * Since "Avada Fusion Builder" only has a tweaked, custom post type list table
 *   for its post types ('fusion_template', 'fusion_element'), we just add two
 *   overview tables here.
 *
 * @since 1.4.0
 *
 * @uses add_submenu_page()
 */
function ddw_btc_add_submenu_avada_fusion_builder_cpts() {

	add_submenu_page(
		'fusion-builder-options',
		esc_html__( 'Templates Overview', 'builder-template-categories' ),
		esc_html__( 'Templates Overview', 'builder-template-categories' ),
		'edit_theme_options',
		esc_url( admin_url( 'edit.php?post_type=fusion_template' ) )
	);

	add_submenu_page(
		'fusion-builder-options',
		esc_html__( 'Elements Overview', 'builder-template-categories' ),
		esc_html__( 'Elements Overview', 'builder-template-categories' ),
		'edit_theme_options',
		esc_url( admin_url( 'edit.php?post_type=fusion_element' ) )
	);

}  // end function
