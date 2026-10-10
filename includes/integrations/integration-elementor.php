<?php

// includes/integrations/integration-elementor

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_elementor' );
/**
 * Register Elementor Page Builder.
 *
 * Elementor submenu slug info (both: 'edit.php?post_type=elementor_library'):
 *  - Elementor 2.4.0+: \Elementor\TemplateLibrary\Source_Local::ADMIN_MENU_SLUG
 *  - Elementor pre 2.4.0: \Elementor\Settings::PAGE_ID
 *
 * @since 1.0.0
 * @since 1.4.2 Improved third-party plugin compat.
 * @since 1.4.3 Enhanced for Elementor v2.4.0+ compat.
 *
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_elementor( array $integrations ) {

	$elementor_submenu_hook = 'edit.php?post_type=elementor_library';

	$integrations[ 'elementor' ] = array(
		'label'          => __( 'Elementor My Templates', 'builder-template-categories' ),
		'submenu_hook'   => $elementor_submenu_hook,
		'post_type'      => 'elementor_library',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=elementor_library',
		'block_editor'   => 'register_early',	// for third-party plugin compat reasons
	);

	return $integrations;

}  // end function


add_action( 'elementor/finder/register', 'ddw_btc_elementor_finder_add_items' );
/**
 * Add "Builder Template Categories" category to the Elementor Finder
 *   (Elementor v2.3.0+).
 *
 * @since 1.4.0
 *
 * @param object $categories_manager

 * @return void
 */
function ddw_btc_elementor_finder_add_items( $categories_manager ) {
	if ( ! current_user_can( ddw_btc_capability_submenu() ) || ! class_exists( 'Elementor\Core\Common\Modules\Finder\Base_Category' ) || ! is_object( $categories_manager ) || ! method_exists( $categories_manager, 'register' ) ) {
		return;
	}


	/** Include the Finder Category class file */
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/elementor-finder.php' );

	/** Add the BTC category */
	$categories_manager->register( new DDW_BTC_Finder_Category() );

}  // end function
