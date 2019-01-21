<?php

// includes/integrations/integration-easy-content-templates

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_easy_content_templates' );
/**
 * Register Easy Content Templates.
 *
 * @since 1.4.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_easy_content_templates( array $integrations ) {

	$integrations[ 'easy-content-templates' ] = array(
		'label'          => __( 'Easy Content Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=ec-template',
		'post_type'      => 'ec-template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=ec-template',
	);

	return $integrations;

}  // end function
