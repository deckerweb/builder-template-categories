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
 * 1) Page Builder integrations:
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Plugin: Elementor (free)
 * @since 1.0.0
 */
if ( ddw_btc_is_elementor_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-elementor.php';
}


/**
 * Plugin: Brizy
 * @since 1.0.1
 */
if ( ddw_btc_is_brizy_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-brizy.php';
}


/**
 * Plugin: Templatera (for 'WPBakery Page Builder', formerly known as 'Visual Composer')
 * @since 1.0.0
 * @since 1.1.0 File name & conditional change.
 */
if ( ddw_btc_is_wpbakery_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-wpbakery.php';
}


/**
 * Plugin: Oxygen Builder (works with v1.x and v2.0+)
 * @since 1.0.0
 */
if ( ddw_btc_is_oxygen_builder_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-oxygen-builder.php';
}


/**
 * Plugin: Themify Builder
 * @since 1.1.0
 */
if ( ddw_btc_is_themify_builder_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-themify-builder.php';
}


/**
 * Plugin: BoldGrid Post and Page Builder
 * @since 1.0.0
 */
if ( ddw_btc_is_boldgrid_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-boldgrid.php';
}


/**
 * Plugin: Global Blocks for Cornerstone
 * @since 1.0.0
 */
if ( ddw_btc_is_cornerstone_global_blocks_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-cornerstone-global-blocks.php';
}


/**
 * Plugin: Visual Composer Website Builder (2018)
 * @since 1.4.0
 */
if ( ddw_btc_is_visual_composer_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-visual-composer.php';
}



/**
 * 2) Theme integrations:
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Theme: GeneratePress Elements - via "GP Premium" Add-On Plugin (Premium)
 * @since 1.0.0
 */
if ( ddw_btc_is_gp_elements_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-generatepress.php';
}


/**
 * Theme: OceanWP - via "Ocean Extra" Add-On Plugin (free)
 * @since 1.0.0
 */
if ( ddw_btc_is_owp_library_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-oceanwp.php';
}


/**
 * Theme: Astra - via "Astra Pro" Add-On Plugin (Premium)
 * @since 1.0.0
 */
if ( ddw_btc_is_astra_layouts_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-astra.php';
}


/**
 * Plugin: Blox - for Genesis Child Themes
 * @since 1.0.0
 */
if ( ddw_btc_is_blox_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-genesis-blox.php';
}


/**
 * Theme: Avada - via integrated "Fusion Builder" plugin
 * @since 1.4.0
 */
if ( ddw_btc_is_avada_fusion_builder_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-avada-fusion-builder.php';
}


/**
 * Theme: Customify - via "Customify Pro" Add-On Plugin (Premium)
 * @since 1.5.0
 */
if ( ddw_btc_is_customify_hooks_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-customify.php';
}


/**
 * Theme: Page Builder Framework - via "WPBF Premium" Add-On Plugin (Premium)
 * @since 1.5.0
 */
if ( ddw_btc_is_pbf_sections_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-page-builder-framework.php';
}


/**
 * Theme: Suki - via "Suki Pro" Add-On Plugin (Premium)
 * @since 1.5.0
 */
if ( ddw_btc_is_suki_blocks_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-suki.php';
}



/**
 * 3) Plugin integrations - for Elementor Page Builder:
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Plugin: AnyWhere Elementor (free)
 * @since 1.0.0
 */
if ( ddw_btc_is_anywhere_elementor_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-anywhere-elementor.php';
}


/**
 * Plugin: JetThemeCore - via Kava Pro/ CrocoBlock (Premium)
 * @since 1.0.0
 */
if ( ddw_btc_is_jetthemecore_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-jetthemecore.php';
}


/**
 * Plugin: JetWooBuilder for Elementor
 * @since 1.0.0
 */
if ( ddw_btc_is_jetwoobuilder_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-jetwoobuilder.php';
}


/**
 * Plugin: JetEngine for Elementor
 * @since 1.0.0
 */
if ( ddw_btc_is_jetengine_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-jetengine.php';
}


/**
 * Plugin: Header Footer for Elementor
 * @since 1.0.0
 */
if ( ddw_btc_is_hfelementor_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-hf-elementor.php';
}


/**
 * Plugin: PopBoxes for Elementor
 * @since 1.0.0
 */
if ( ddw_btc_is_popboxes_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-popboxes.php';
}


/**
 * Plugin: DHWC Elementor
 * @since 1.0.0
 */
if ( ddw_btc_is_dhwc_elementor_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-dhwc-elementor.php';
}


/**
 * Plugin: JetPopup
 * @since 1.1.0
 */
if ( ddw_btc_is_jetpopup_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-jetpopup.php';
}


/**
 * Plugin: Templementor
 * @since 1.1.0
 */
if ( ddw_btc_is_templementor_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-templementor.php';
}


/**
 * Plugin: Kadence WooCommerce Elementor
 * @since 1.1.0
 */
if ( ddw_btc_is_kadence_woocommerce_elementor_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-kadence-woocommerce-elementor.php';
}


/**
 * Plugin: StylePress for Elementor
 * @since 1.2.0
 */
if ( ddw_btc_is_stylepress_elementor_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-stylepress-elementor.php';
}


/**
 * Plugin: Opal Widgets for Elementor
 * @since 1.3.0
 */
if ( ddw_btc_is_opal_widgets_elementor_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-opal-widgets-elementor.php';
}


/**
 * Plugin: JetSmartFilters
 * @since 1.3.0
 */
if ( ddw_btc_is_jetsmartfilters_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-jetsmartfilters.php';
}


/**
 * Plugin: Epic News Elements
 * @since 1.4.0
 */
if ( ddw_btc_is_epic_news_elements_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-epic-news-elements.php';
}



/**
 * 4) Plugin integrations - everything else:
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Plugin: Popup Maker
 * @since 1.0.0
 */
if ( ddw_btc_is_popup_maker_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-popup-maker.php';
}


/**
 * Plugin: Thrive Lightboxes (as part of Thrive Architect)
 * @since 1.0.0
 */
if ( ddw_btc_is_thrive_lightboxes_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-thrive-lightboxes.php';
}


/**
 * Plugin: WP Show Posts
 * @since 1.0.0
 */
if ( ddw_btc_is_wpshowposts_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-wpshowposts.php';
}


/**
 * Plugin: Pods
 * @since 1.0.0
 */
if ( ddw_btc_is_pods_templates_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-pods.php';
}


/**
 * Plugin: Cherry PopUps
 * @since 1.1.0
 */
if ( ddw_btc_is_cherry_popups_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-cherry-popups.php';
}


/**
 * Plugin: Themify Popup
 * @since 1.1.0
 */
if ( ddw_btc_is_themify_popup_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-themify-popup.php';
}


/**
 * Plugin: Meta Box Post Type and Meta Box Taxonomy Add-Ons
 * @since 1.1.0
 */
if ( ddw_btc_is_metabox_posttype_active() || ddw_btc_is_metabox_taxonomy_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-metabox-posttypes.php';
}


/**
 * Plugin: Reusable Content & Text Blocks by Loomisoft
 * @since 1.2.0
 */
if ( ddw_btc_is_loomisoft_content_blocks_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-loomisoft-content-blocks.php';
}


/**
 * Plugin: Content Blocks (Custom Post Widget)
 * @since 1.2.0
 */
if ( ddw_btc_is_content_blocks_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-content-blocks.php';
}


/**
 * Plugin: Text Blocks
 * @since 1.2.0
 */
if ( ddw_btc_is_text_blocks_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-text-blocks.php';
}


/**
 * Plugin: Widget Content Blocks
 * @since 1.2.0
 */
if ( ddw_btc_is_widget_content_blocks_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-widget-content-blocks.php';
}


/**
 * Plugin: Dev Content Blocks
 * @since 1.2.0
 */
if ( ddw_btc_is_dev_content_blocks_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-dev-content-blocks.php';
}


/**
 * Plugin: Advanced Custom Fields (Pro)
 * @since 1.3.0
 */
if ( ddw_btc_is_advanced_custom_fields_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-advanced-custom-fields.php';
}


/**
 * Plugin: Custom Field Suite
 * @since 1.3.0
 */
if ( ddw_btc_is_custom_field_suite_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-custom-field-suite.php';
}


/**
 * Plugin: CMB2 Admin Extension
 * @since 1.3.0
 */
if ( ddw_btc_is_cmb2_admin_extension_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-cmb2-admin-extension.php';
}


/**
 * Plugin: Meta Box Builder
 * @since 1.3.0
 */
if ( ddw_btc_is_meta_box_builder_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-metabox-builder.php';
}


/**
 * Plugin: Custom Template for LifterLMS
 * @since 1.3.0
 */
if ( ddw_btc_is_custom_template_lifterlms_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-custom-template-lifterlms.php';
}


/**
 * Plugin: Custom Template for LearnDash
 * @since 1.3.0
 */
if ( ddw_btc_is_custom_template_learndash_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-custom-template-learndash.php';
}


/**
 * Plugin: Reusable Content Blocks
 * @since 1.3.0
 */
if ( ddw_btc_is_reusable_content_blocks_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-reusable-content-blocks.php';
}


/**
 * Plugin: Master Popups
 * @since 1.4.0
 */
if ( ddw_btc_is_master_popups_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-master-popups.php';
}


/**
 * Plugin: Smart Footer System
 * @since 1.4.0
 */
if ( ddw_btc_is_smart_footer_system_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-smart-footer-system.php';
}


/**
 * Plugin: Easy Content Templates
 * @since 1.4.0
 */
if ( ddw_btc_is_easy_content_templates_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-easy-content-templates.php';
}


/**
 * Plugin: Simple Content Templates
 * @since 1.4.0
 */
if ( ddw_btc_is_simple_content_templates_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-simple-content-templates.php';
}


/**
 * Plugin: Custom Page Templates
 * @since 1.4.0
 */
if ( ddw_btc_is_custom_page_templates_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-custom-page-templates.php';
}


/**
 * Plugin: CartFlows
 * @since 1.5.0
 */
if ( ddw_btc_is_cartflows_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-cartflows.php';
}



/**
 * 5) Block Editor (Gutenberg) integrations - WP Core, plugins etc.:
 * @since 1.2.0
 * -----------------------------------------------------------------------------
 */

/**
 * Plugin: Gutenberg / WP Core 5.0+
 * @since 1.2.0
 * @since 1.4.0 Additional checks if Gutenberg disabled.
 * @since 1.4.3 Additional checks if Block Editor is wanted or not.
 */
if ( ddw_btc_is_block_editor_active() && ddw_btc_is_block_editor_wanted() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-block-editor.php';
}


/**
 * Plugin: Lazy Blocks
 * @since 1.2.0
 */
if ( ddw_btc_is_lazy_blocks_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-lazy-blocks.php';
}


/**
 * Plugin: Block Lab
 * @since 1.4.0
 */
if ( ddw_btc_is_block_lab_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-block-lab.php';
}


/**
 * Plugin: Advanced Custom Blocks
 * @since 1.2.0
 */
if ( ddw_btc_is_advanced_custom_blocks_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-advanced-custom-blocks.php';
}


/**
 * Plugin: Blocks Layouts
 * @since 1.2.0
 */
if ( ddw_btc_is_block_layouts_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-block-layouts.php';
}


/**
 * Plugin: Square Happiness Placeholder Block
 * @since 1.2.0
 */
if ( ddw_btc_is_sqh_placeholder_block_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-sqh-placeholder-block.php';
}


/**
 * Plugin: Gutenberg Templates (Block Templates)
 * @since 1.4.0
 */
if ( ddw_btc_is_block_templates_active() ) {
	require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-block-templates.php';
}
