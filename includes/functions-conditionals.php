<?php

// includes/functions-conditionals

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Is Toolbar Extras (free) plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if Toolbar Extras is active, otherwise FALSE.
 */
function ddw_btc_is_tbex_active() {

	return ( defined( 'TBEX_PLUGIN_VERSION' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is Cleaner Plugin Installer (free) plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if Cleaner Plugin Installer is active, otherwise FALSE.
 */
function ddw_btc_is_clpinst_active() {

	return ( defined( 'CLPINST_PLUGIN_VERSION' ) ) ? TRUE : FALSE;

}  // end function


/**
 * 1) Page Builder integrations:
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Is Elementor (free) plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if Elementor is active, otherwise FALSE.
 */
function ddw_btc_is_elementor_active() {

	return ( defined( 'ELEMENTOR_VERSION' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is Brizy plugin active or not?
 *
 * @since  1.0.1
 *
 * @return bool TRUE if Brizy is active, otherwise FALSE.
 */
function ddw_btc_is_brizy_active() {

	return ( defined( 'BRIZY_VERSION' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is WPBakery Page Builder plugin active or not?
 *
 * @since  1.1.0
 *s
 * @return bool TRUE if WPBakery Page Builder is active and is at least
 *              version 5.0 or higher, otherwise FALSE.
 */
function ddw_btc_is_wpbakery_active() {

	/**
	 * "Templatera" Add-On needs at least WPBakery Page Builder version 5.0 or
	 *   higher
	 */
	if ( defined( 'WPB_VC_VERSION' )
		&& version_compare( WPB_VC_VERSION, '5.0', '>=' )
	) {
		return TRUE;
	}

	return FALSE;

}  // end function


/**
 * Is Templatera Add-On (WPBakery Page Builder) plugin active or not?
 *
 * @since  1.0.0
 *s
 * @return bool TRUE if Templatera is active, otherwise FALSE.
 */
function ddw_btc_is_wpbakery_templatera_active() {

	return function_exists( 'templatera_init' );

}  // end function


/**
 * Is Oxygen Builder plugin active or not?
 *   Note: Both major versions are supported, the old v1.x (Oxygen Visual Site
 *         Builder), and, the new Oxygen Builder 2.0+. The template post type is
 *         the same for both versions.
 *
 * @since  1.0.0
 *
 * @return bool TRUE if Oxygen Builder is active, otherwise FALSE.
 */
function ddw_btc_is_oxygen_builder_active() {

	return ( defined( 'CT_VERSION' ) || defined( 'OXYGEN_VSB_VERSION' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is BoldGrid Post and Page Builder plugin active or not?
 *
 * @since  1.0.0
 *s
 * @return bool TRUE if BoldGrid is active, otherwise FALSE.
 */
function ddw_btc_is_boldgrid_active() {

	return ( defined( 'BOLDGRID_EDITOR_VERSION' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is Global Blocks for Cornerstone plugin active or not?
 *
 * @since  1.0.0
 *s
 * @return bool TRUE if Global Blocks for Cornerstone is active, otherwise FALSE.
 */
function ddw_btc_is_cornerstone_global_blocks_active() {

	return ( function_exists( 'global_blocks_plugin_init' ) ) ? TRUE : FALSE;

}  // end function



/**
 * 2) Theme integrations:
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Is GeneratePress "Elements" module active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if the module is active, otherwise FALSE.
 */
function ddw_btc_is_gp_elements_active() {

	return ( function_exists( 'generate_premium_do_elements' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is OceanWP "My Library" via "Ocean Extra" plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if the OceanWP library is active, otherwise FALSE.
 */
function ddw_btc_is_owp_library_active() {

	return ( function_exists( 'Ocean_Extra' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is Astra "Custom Layouts" module active or not? (via Pro Addon)
 *
 * @since  1.0.0
 *
 * @return bool TRUE if Astra Pro Custom Layouts module is active, otherwise
 *              FALSE.
 */
function ddw_btc_is_astra_layouts_active() {

	return ( class_exists( 'Astra_Ext_Extension' ) && Astra_Ext_Extension::is_active( 'advanced-hooks' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is Blox plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if Blox Lite or Blox Pro is active, otherwise FALSE.
 */
function ddw_btc_is_blox_active() {

	return ( class_exists( 'Blox_Lite_Main' ) || class_exists( 'Blox_Main' ) ) ? TRUE : FALSE;

}  // end function



/**
 * 3) Plugin integrations - for Elementor Page Builder:
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Is AnyWhere Elementor (free/Pro) plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if AnyWhere Elementor is active, otherwise FALSE.
 */
function ddw_btc_is_anywhere_elementor_active() {

	return ( function_exists( 'WTS_AE_load_plugin_textdomain' ) || function_exists( 'ae_pro_load_plugin_textdomain' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is JetThemeCore plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if JetThemeCore is active, otherwise FALSE.
 */
function ddw_btc_is_jetthemecore_active() {

	return ( class_exists( 'Jet_Theme_Core' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is JetWooBuilder plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if WooCommerce and JetWooBuilder is active, otherwise FALSE.
 */
function ddw_btc_is_jetwoobuilder_active() {

	return ( class_exists( 'WooCommerce' ) && class_exists( 'Jet_Woo_Builder' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is JetEngine plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if JetEngine is active, otherwise FALSE.
 */
function ddw_btc_is_jetengine_active() {

	return ( class_exists( 'Jet_Engine' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is Header Footer for Elementor plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if Header Footer for Elementor is active, otherwise FALSE.
 */
function ddw_btc_is_hfelementor_active() {

	return ( class_exists( 'Header_Footer_Elementor' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is PopBoxes plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if PopBoxes is active, otherwise FALSE.
 */
function ddw_btc_is_popboxes_active() {

	return ( defined( 'MODAL_ELEMENTOR_VERSION' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is JetPopup plugin active or not?
 *
 * @since  1.1.0
 *s
 * @return bool TRUE if JetPopup is active, otherwise FALSE.
 */
function ddw_btc_is_jetpopup_active() {

	return class_exists( 'Jet_Popup' );

}  // end function


/**
 * Is DHWC Elementor plugin active or not?
 *
 * @since  1.0.0
 *s
 * @return bool TRUE if WooCommerce and DHWC Elementor is active, otherwise
 *              FALSE.
 */
function ddw_btc_is_dhwc_elementor_active() {

	return ( class_exists( 'WooCommerce' ) && defined( 'DHWC_ELEMENTOR_VERSION' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is Templementor plugin active or not?
 *
 * @since  1.1.0
 *s
 * @return bool TRUE if Templementor is active, otherwise FALSE.
 */
function ddw_btc_is_templementor_active() {

	return function_exists( 'tpm_plugin_action_links' );

}  // end function


/**
 * Is Kadence WooCommerce Elementor plugin active or not?
 *
 * @since  1.1.0
 *s
 * @return bool TRUE if Kadence WooCommerce Elementor is active, otherwise FALSE.
 */
function ddw_btc_is_kadence_woocommerce_elementor_active() {

	return ( class_exists( 'WooCommerce' ) && class_exists( 'Kadence_Woocommerce_Elementor' ) );

}  // end function


/**
 * Is Kadence WooCommerce Elementor Pro plugin active or not?
 *
 * @since  1.1.0
 *s
 * @return bool TRUE if Kadence WooCommerce Elementor Pro is active, otherwise FALSE.
 */
function ddw_btc_is_kadence_woocommerce_elementor_pro_active() {

	return class_exists( 'Kadence_Woocommerce_Elementor_Pro' );

}  // end function


/**
 * Is StylePress for Elementor plugin active or not?
 *   Note: We need at least v1.2.1 or higher.
 *
 * @since  1.2.0
 *s
 * @return bool TRUE if StylePress for Elementor is active in at least
 *              version 1.2.1 or higher, otherwise FALSE.
 */
function ddw_btc_is_stylepress_elementor_active() {

	return ( defined( 'DTBAKER_ELEMENTOR_VERSION' ) && version_compare( DTBAKER_ELEMENTOR_VERSION, '1.2.1', '>=' ) );

}  // end function



/**
 * 4) Plugin integrations - everything else:
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Is WP Show Posts plugin active or not?
 *
 * @since  1.0.0
 *s
 * @return bool TRUE if WP Show Posts is active, otherwise FALSE.
 */
function ddw_btc_is_wpshowposts_active() {

	return ( defined( 'WPSP_VERSION' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is Pods plugin Templates module active or not?
 *   Note: This requires in Pods' settings that the "Templates" Component has
 *         been enabled.
 *
 * @since  1.0.0
 *s
 * @return bool TRUE if Pods Templates is active, otherwise FALSE.
 */
function ddw_btc_is_pods_templates_active() {

	$pods_components = get_option( 'pods_component_settings' );
	$pods_components = json_decode( $pods_components, TRUE );

	if ( defined( 'PODS_VERSION' )
		&& 0 !== $pods_components[ 'components' ][ 'templates' ]
	) {
		return TRUE;
	}

	return FALSE;

}  // end function


/**
 * Is Popup Maker plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if Popup Maker is active, otherwise FALSE.
 */
function ddw_btc_is_popup_maker_active() {

	return ( class_exists( 'Popup_Maker' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is Thrive Lightboxes plugin active or not?
 *
 * @since  1.0.0
 *
 * @return bool TRUE if Thrive Lightboxes is active, otherwise FALSE.
 */
function ddw_btc_is_thrive_lightboxes_active() {

	return ( class_exists( 'TCB_Lightbox' ) ) ? TRUE : FALSE;

}  // end function


/**
 * Is Cherry PopUps plugin active or not?
 *
 * @since  1.1.0
 *s
 * @return bool TRUE if Cherry PopUps is active, otherwise FALSE.
 */
function ddw_btc_is_cherry_popups_active() {

	return class_exists( 'Cherry_Popups' );

}  // end function


/**
 * Is Themify Builder plugin active or not?
 *
 * @since  1.1.0
 *s
 * @return bool TRUE if Themify Builder is active, otherwise FALSE.
 */
function ddw_btc_is_themify_builder_active() {

	return class_exists( 'Themify_Builder_Model' ) && Themify_Builder_Model::is_premium();

}  // end function


/**
 * Is Themify Popup plugin active or not?
 *
 * @since  1.1.0
 *s
 * @return bool TRUE if Themify Popup is active, otherwise FALSE.
 */
function ddw_btc_is_themify_popup_active() {

	return function_exists( 'themify_popup_setup' );

}  // end function


/**
 * Is Meta Box Post Type Add-On plugin active or not?
 *
 * @since  1.1.0
 *s
 * @return bool TRUE if MB Post Type is active, otherwise FALSE.
 */
function ddw_btc_is_metabox_posttype_active() {

	return function_exists( 'mb_cpt_load' );

}  // end function


/**
 * Is Meta Box Taxonomy Add-On plugin active or not?
 *
 * @since  1.1.0
 *s
 * @return bool TRUE if MB Taxonomy is active, otherwise FALSE.
 */
function ddw_btc_is_metabox_taxonomy_active() {

	return function_exists( 'mb_custom_taxonomy_load' );

}  // end function


/**
 * Is Reusable Content & Text Blocks by Loomisoft plugin active or not?
 *
 * @since  1.2.0
 *s
 * @return bool TRUE if Reusable Content & Text Blocks by Loomisoft is active, otherwise FALSE.
 */
function ddw_btc_is_loomisoft_content_blocks_active() {

	return defined( 'LS_CB_PLUGIN_PATH' );

}  // end function


/**
 * Is Content Blocks (Custom Post Widget) plugin active or not?
 *
 * @since  1.2.0
 *s
 * @return bool TRUE if Content Blocks (Custom Post Widget) is active, otherwise
 *              FALSE.
 */
function ddw_btc_is_content_blocks_active() {

	return function_exists( 'custom_post_widget_plugin_init' );

}  // end function


/**
 * Is Text Blocks plugin active or not?
 *
 * @since  1.2.0
 *s
 * @return bool TRUE if Text Blocks is active, otherwise FALSE.
 */
function ddw_btc_is_text_blocks_active() {

	return function_exists( 'text_block_setup' );

}  // end function


/**
 * Is Widget Content Blocks plugin active or not?
 *
 * @since  1.2.0
 *s
 * @return bool TRUE if Widget Content Blocks is active, otherwise FALSE.
 */
function ddw_btc_is_widget_content_blocks_active() {

	return defined( 'WYWI_VERSION_NUMBER' );

}  // end function


/**
 * Is Dev Content Blocks plugin active or not?
 *
 * @since  1.2.0
 *s
 * @return bool TRUE if Dev Content Blocks is active, otherwise FALSE.
 */
function ddw_btc_is_dev_content_blocks_active() {

	return function_exists( 'dc_dcb_dev_content_block_cpt' );

}  // end function



/**
 * 5) Block Editor (Gutenberg) integrations - WP Core, plugins etc.:
 * @since 1.2.0
 * -----------------------------------------------------------------------------
 */

/**
 * Check if the "Blocks Editor" is available or not. This can currently mean:
 *   1) WordPress is in version 5.0.0+ (will contain blocks editor by default)
 *   2) or, the "Gutenberg" plugin is active (it is the blocks editor)
 *
 * @since  1.2.0
 *
 * @global string $GLOBALS[ 'wp_version' ] 
 * @return bool TRUE if blocks editor available, otherwise FALSE.
 */
function ddw_btc_is_block_editor_active() {

	//return ( defined( 'GUTENBERG_VERSION' ) ) ? TRUE : FALSE;

	if ( version_compare( $GLOBALS[ 'wp_version' ], '5.0.0', '>=' )
		|| defined( 'GUTENBERG_VERSION' )
	) {
		return TRUE;
	}

	return FALSE;

}  // end if


 /**
 * Is Lazy Blocks plugin active or not?
 *
 * @since  1.2.0
 *s
 * @return bool TRUE if Lazy Blocks is active, otherwise FALSE.
 */
function ddw_btc_is_lazy_blocks_active() {

	return class_exists( 'LazyBlocks' );

}  // end function


/**
 * Is Advanced Custom Blocks plugin active or not?
 *
 * @since  1.2.0
 *s
 * @return bool TRUE if Advanced Custom Blocks is active, otherwise FALSE.
 */
function ddw_btc_is_advanced_custom_blocks_active() {

	return function_exists( 'advanced_custom_blocks' );

}  // end function


/**
 * Is Blocks Layouts plugin active or not?
 *
 * @since  1.2.0
 *s
 * @return bool TRUE if Blocks Layouts is active, otherwise FALSE.
 */
function ddw_btc_is_block_layouts_active() {

	return class_exists( 'Meow_MBL_Core' );

}  // end function


/**
 * Is Square Happiness Placeholder Block plugin active or not?
 *
 * @since  1.2.0
 *s
 * @return bool TRUE if Placeholder Block is active, otherwise FALSE.
 */
function ddw_btc_is_sqh_placeholder_block_active() {

	return class_exists( 'SQHP_Placeholder_Init' );

}  // end function