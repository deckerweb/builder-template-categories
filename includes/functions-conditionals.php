<?php
/** Availability checks for supported template libraries. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Determine whether the supported template library is available.
 * @since 1.9.0
 * @return bool Whether the integration is available.
 */
function ddw_btc_is_bricks_active() {

     return defined( 'BRICKS_VERSION' );

 }  // end function


/**
 * Is Elementor (free) plugin active or not?
 *
 * @since 1.0.0
 *
 * @return bool TRUE if Elementor is active, FALSE otherwise.
 */
function ddw_btc_is_elementor_active() {

	return defined( 'ELEMENTOR_VERSION' );

}  // end function

/**
 * Determine whether the supported template library is available.
 * @since 1.9.0
 * @return bool Whether the integration is available.
 */
function ddw_btc_is_elementor_pro_active() {

	return defined( 'ELEMENTOR_PRO_VERSION' );

}  // end function

/**
 * Determine whether the supported template library is available.
 * @since 1.9.0
 * @return bool Whether the integration is available.
 */
function ddw_btc_is_oxygen_builder_active() {

	return ( defined( 'CT_VERSION' ) || defined( 'OXYGEN_VSB_VERSION' ) );

}  // end function

/**
 * Determine whether the supported template library is available.
 * @since 1.9.0
 * @return bool Whether the integration is available.
 */
function ddw_btc_is_oxygen_user_library_active() {

	if ( ! class_exists( 'OXY_VSB_Connection' ) ) {
		return FALSE;
	}

	$status = get_option( 'oxygen_vsb_enable_connection' );

	return ( 'true' === $status );

}  // end function

/**
 * Determine whether the supported template library is available.
 * @since 1.9.0
 * @return bool Whether the integration is available.
 */
function ddw_btc_is_beaver_builder_active() {

	return class_exists( 'FLBuilderLoader' );

}  // end function

/**
 * Determine whether the supported template library is available.
 * @since 1.9.0
 * @return bool Whether the integration is available.
 */
function ddw_btc_is_beaver_themer_active() {

	return class_exists( 'FLThemeBuilderLoader' );

}  // end function

/**
 * Determine whether the supported template library is available.
 * @since 1.9.0
 * @return bool Whether the integration is available.
 */
function ddw_btc_is_divi_builder_active() {

	return ( defined( 'ET_BUILDER_PRODUCT_VERSION' ) || defined( 'ET_BUILDER_PLUGIN_VERSION' ) );

}  // end function

/**
 * Determine whether the supported template library is available.
 * @since 1.9.0
 * @return bool Whether the integration is available.
 */
function ddw_btc_is_gp_elements_active() {

	return function_exists( 'generate_premium_do_elements' );

}  // end function

/**
 * Determine whether the supported template library is available.
 * @since 1.9.0
 * @return bool Whether the integration is available.
 */
function ddw_btc_is_astra_layouts_active() {

	return ( class_exists( 'Astra_Ext_Extension' ) && Astra_Ext_Extension::is_active( 'advanced-hooks' ) );

}  // end function

/**
 * Determine whether the supported template library is available.
 * @since 1.9.0
 * @return bool Whether the integration is available.
 */
function ddw_btc_is_avada_fusion_builder_active() {

	return ( defined( 'FUSION_BUILDER_VERSION' ) );

}  // end function
