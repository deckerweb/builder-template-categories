<?php

// includes/load-integrations

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Plugin: Elementor (free)
 * @since 1.0.0
 */
if ( ddw_btc_is_elementor_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-elementor.php' );
}


/**
 * Theme: GeneratePress Elements - via "GP Premium" Add-On Plugin (Premium)
 * @since 1.0.0
 */
if ( ddw_btc_is_gp_elements_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-generatepress.php' );
}


/**
 * Theme: OceanWP - via "Ocean Extra" Add-On Plugin (free)
 * @since 1.0.0
 */
if ( ddw_btc_is_owp_library_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-oceanwp.php' );
}


/**
 * Theme: Astra - via "Astra Pro" Add-On Plugin (Premium)
 * @since 1.0.0
 */
if ( ddw_btc_is_astra_layouts_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-astra.php' );
}


/**
 * Plugin: AnyWhere Elementor (free)
 * @since 1.0.0
 */
if ( ddw_btc_is_anywhere_elementor_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-anywhere-elementor.php' );
}


/**
 * Plugin: JetThemeCore - via Kava Pro/ CrocoBlock (Premium)
 * @since 1.0.0
 */
if ( ddw_btc_is_jetthemecore_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-jetthemecore.php' );
}


/**
 * Plugin: JetWooBuilder for Elementor
 * @since 1.0.0
 */
if ( ddw_btc_is_jetwoobuilder_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-jetwoobuilder.php' );
}


/**
 * Plugin: JetEngine for Elementor
 * @since 1.0.0
 */
if ( ddw_btc_is_jetengine_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-jetengine.php' );
}


/**
 * Plugin: Blox - for Genesis Child Themes
 * @since 1.0.0
 */
if ( ddw_btc_is_blox_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-genesis-blox.php' );
}


/**
 * Plugin: Oxygen Builder (works with v1.x and v2.0+)
 * @since 1.0.0
 */
if ( ddw_btc_is_oxygen_builder_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-oxygen-builder.php' );
}


/**
 * Plugin: Popup Maker
 * @since 1.0.0
 */
if ( ddw_btc_is_popup_maker_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-popup-maker.php' );
}


/**
 * Plugin: Header Footer for Elementor
 * @since 1.0.0
 */
if ( ddw_btc_is_hfelementor_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-hf-elementor.php' );
}


/**
 * Plugin: PopBoxes for Elementor
 * @since 1.0.0
 */
if ( ddw_btc_is_popboxes_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-popboxes.php' );
}


/**
 * Plugin: Thrive Lightboxes (as part of Thrive Architect)
 * @since 1.0.0
 */
if ( ddw_btc_is_thrive_lightboxes_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-thrive-lightboxes.php' );
}


/**
 * Plugin: BoldGrid Post and Page Builder
 * @since 1.0.0
 */
if ( ddw_btc_is_boldgrid_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-boldgrid.php' );
}


/**
 * Plugin: WP Show Posts
 * @since 1.0.0
 */
if ( ddw_btc_is_wpshowposts_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-wpshowposts.php' );
}


/**
 * Plugin: Pods
 * @since 1.0.0
 */
if ( ddw_btc_is_pods_templates_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-pods.php' );
}


/**
 * Plugin: DHWC Elementor
 * @since 1.0.0
 */
if ( ddw_btc_is_dhwc_elementor_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-dhwc-elementor.php' );
}


/**
 * Plugin: Templatera (for 'WPBakery Page Builder', formerly known as 'Visual Composer')
 * @since 1.0.0
 */
if ( ddw_btc_is_wpbakery_templatera_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-wpbakery-templatera.php' );
}


/**
 * Plugin: Global Blocks for Cornerstone
 * @since 1.0.0
 */
if ( ddw_btc_is_cornerstone_global_blocks_active() ) {
	require_once( BTC_PLUGIN_DIR . 'includes/integrations/integration-cornerstone-global-blocks.php' );
}