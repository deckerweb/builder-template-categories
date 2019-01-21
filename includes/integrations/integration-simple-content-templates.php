<?php

// includes/integrations/integration-simple-content-templates

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_simple_content_templates' );
/**
 * Register Simple Content Templates.
 *
 * @since 1.4.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_simple_content_templates( array $integrations ) {

	$integrations[ 'simple-content-templates' ] = array(
		'label'          => __( 'Simple Content Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=act_template',
		'post_type'      => 'act_template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=act_template',
	);

	return $integrations;

}  // end function
