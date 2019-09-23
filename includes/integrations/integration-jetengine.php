<?php

// includes/integrations/integration-jetengine

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Check if JetEngine "Booking Forms" feature is active or not.
 *
 * @since 1.7.0
 *
 * @uses jet_engine()->modules->is_module_active()
 *
 * @return bool TRUE if setting is enabled, FALSE otherwise.
 */
function ddw_btc_is_jetengine_forms_active() {

	/** Bail early if function does not exist */
	if ( ! function_exists( 'jet_engine' ) ) {
		return FALSE;
	}

	return jet_engine()->modules->is_module_active( 'booking-forms' );

}  // end function


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_jetengine' );
/**
 * Register JetEngine plugin.
 *
 * @since 1.0.0
 * @since 1.7.0 Added Form categories.
 *
 * @uses ddw_btc_is_jetengine_forms_active()
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_jetengine( array $integrations ) {

	$integrations[ 'jetengine' ] = array(
		'label'          => __( 'JetEngine Listing Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'jet-engine',
		'post_type'      => 'jet-engine',
		'template_label' => 'listing',
		'admin_url'      => 'edit.php?post_type=jet-engine',
	);

	if ( ddw_btc_is_jetengine_forms_active() ) {

		$integrations[ 'jetengine-forms' ] = array(
			'label'          => __( 'JetEngine Forms', 'builder-template-categories' ),
			'submenu_hook'   => 'jet-engine',
			'post_type'      => 'jet-engine-booking',
			'template_label' => 'form',
			'admin_url'      => 'edit.php?post_type=jet-engine-booking',
		);

	}  // end if

	return $integrations;

}  // end function


/**
 * Set flag for Form type template
 *
 * @since 1.7.0
 */
if ( ddw_btc_is_jetengine_forms_active() ) {
	add_filter( 'btc/filter/is_type/form', '__return_true' );
}
