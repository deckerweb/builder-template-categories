<?php

// includes/integrations/integration-elements-kit

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_elementskit' );
/**
 * Register Elements Kit plugin.
 *
 * @since 1.7.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_elementskit( array $integrations ) {

	$integrations[ 'elementskit-templates' ] = array(
		'label'          => __( 'Elements Kit Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'elementskit',
		'post_type'      => 'elementskit_template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=elementskit_template',
	);

	return $integrations;

}  // end function
