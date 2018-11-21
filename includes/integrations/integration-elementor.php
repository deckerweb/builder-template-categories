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
 * @since  1.0.0
 *
 * @param  array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_elementor( array $integrations ) {

	$integrations[ 'elementor' ] = array(
		'label'          => __( 'Elementor My Templates', 'builder-template-categories' ),
		'submenu_hook'   => \Elementor\Settings::PAGE_ID,	// 'edit.php?post_type=elementor_library',
		'post_type'      => 'elementor_library',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=elementor_library',
	);

	return $integrations;

}  // end function


add_action( 'elementor/finder/categories/init', 'ddw_btc_elementor_finder_add_items' );
/**
 * Add "Builder Template Categories" category to the Elementor Finder
 *   (Elementor v2.3.0+).
 *
 * @since 1.4.0
 *
 * @param object $categories_manager
 */
function ddw_btc_elementor_finder_add_items( $categories_manager ) {

	/** Include the Finder Category class file */
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/elementor-finder.php' );

	/** Add the BTC category */
	$categories_manager->add_category( 'builder-template-categories', new DDW_BTC_Finder_Category() );

}  // end function
