<?php

// includes/integrations/integration-metabox-builder

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_metabox_builder' );
/**
 * Register Meta Box Builder plugin.
 *
 * @since 1.3.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_metabox_builder( array $integrations ) {

	$integrations[ 'metabox-builder' ] = array(
		'label'          => __( 'Meta Box Field Groups', 'builder-template-categories' ),
		'submenu_hook'   => 'meta-box',
		'post_type'      => 'meta-box',
		'template_label' => 'field',
		'admin_url'      => 'edit.php?post_type=meta-box',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Field type template
 *
 * @since 1.3.0
 */
add_filter( 'btc/filter/is_type/field', '__return_true' );
