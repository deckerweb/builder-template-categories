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
 * @uses ddw_btc_is_elementor_version()
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_elementor( array $integrations ) {

	// version_compare( ELEMENTOR_VERSION, '2.4.0-beta1', '>=' )
	/** Set submenu hook based on Elementor version */
	$elementor_submenu_hook = ddw_btc_is_elementor_version( 'core', '2.4.0-beta1', '>=' ) ? \Elementor\TemplateLibrary\Source_Local::ADMIN_MENU_SLUG : \Elementor\Settings::PAGE_ID;

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


add_action( 'admin_menu', 'ddw_btc_remove_submenu_for_elementor', 601 );
/**
 * Since Elementor 2.4.0 we need to apply some tweaks:
 *   - Remove our taxonomy submenu first
 *   - Unset other submenu values made by Elementor
 *
 * @since 1.4.3
 *
 * @see ddw_btc_add_submenu_elementor_template_categories()
 *
 * @uses ddw_btc_is_elementor_version()
 * @uses remove_submenu_page()
 */
function ddw_btc_remove_submenu_for_elementor() {

	/** Only execute for Elementor v2.4.0+ */
	if ( ddw_btc_is_elementor_version( 'core', '2.4.0-beta1', '>=' ) ) {

		$page = remove_submenu_page(
			'edit.php?post_type=elementor_library',
			'edit-tags.php?taxonomy=builder-template-category&post_type=elementor_library'
		);

		unset( $GLOBALS[ 'submenu' ][ 'edit.php?post_type=elementor_library' ][16] );
		
		unset( $GLOBALS[ 'submenu' ][ 'edit.php?post_type=elementor_library' ][15] );
		if ( isset( $GLOBALS[ 'submenu' ][ 'edit.php?post_type=elementor_library' ][15] ) ) {
			$GLOBALS[ 'submenu' ][ 'edit.php?post_type=elementor_library' ][15] = null;
		}
		
	}  // end if

}  // end function


add_action( 'admin_menu', 'ddw_btc_add_submenu_elementor_template_categories', 900 );
/**
 * Since Elementor 2.4.0 we need to apply some tweaks:
 *   - Re-add Elementor Categories submenu
 *   - Re-add our taxonomy submenu
 *
 * @since 1.4.3
 *
 * @see ddw_btc_remove_submenu_for_elementor()
 *
 * @uses ddw_btc_is_elementor_version()
 * @uses add_submenu_page()
 * @uses ddw_btc_string_add_new()
 */
function ddw_btc_add_submenu_elementor_template_categories() {

	/** Bail early if pre Elementor v2.4.0 */
	if ( ddw_btc_is_elementor_version( 'core', '2.4.0-beta1', '<=' ) ) {
		return;
	}

	$elementor_label = get_taxonomy_labels( get_taxonomy( 'elementor_library_category' ) );
	
	add_submenu_page(
		'edit.php?post_type=elementor_library',
		$elementor_label->name,
		$elementor_label->name,
		'edit_posts',
		'edit-tags.php?taxonomy=elementor_library_category&post_type=elementor_library'
	);
	
	add_submenu_page(
		'edit.php?post_type=elementor_library',
		ddw_btc_string_template( 'template' ),
		ddw_btc_string_template( 'template' ),
		'edit_theme_options',
		'edit-tags.php?taxonomy=builder-template-category&post_type=elementor_library'
	);

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


/**
 * Set flag for Popup type template for Elementor Pro v2.4.0+ which includes a
 *   Popup Builder by default.
 *
 * @since 1.4.3
 */
if ( ddw_btc_is_elementor_pro_active() && ddw_btc_is_elementor_version( 'pro', '2.4.0-beta1', '>=' ) ) {
	add_filter( 'btc/filter/is_type/popup', '__return_true' );
}
