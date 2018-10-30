<?php

// includes/integrations/integration-advanced-custom-fields

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_advanced_custom_fields' );
/**
 * Register Advanced Custom Fields (Pro) plugin.
 *
 * @since  1.3.0
 *
 * @param  array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_advanced_custom_fields( array $integrations ) {

	$integrations[ 'advanced-custom-fields' ] = array(
		'label'          => __( 'Advanced Custom Fields Field Groups', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=acf-field-group',
		'post_type'      => 'acf-field-group',
		'template_label' => 'field',
		'admin_url'      => 'edit.php?post_type=acf-field-group',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Field type template
 *
 * @since 1.3.0
 */
add_filter( 'btc/filter/is_type/field', '__return_true' );