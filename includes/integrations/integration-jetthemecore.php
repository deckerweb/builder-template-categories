<?php

// includes/integrations/integration-jetthemecore

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_jetthemecore' );
/**
 * Register JetThemeCore plugin.
 *
 * @since 1.0.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_jetthemecore( array $integrations ) {

	$integrations[ 'jetthemecore' ] = array(
		'label'          => __( 'JetThemeCore My Library', 'builder-template-categories' ),
		'submenu_hook'   => 'jet-theme-core',
		'post_type'      => 'jet-theme-core',
		'template_label' => 'library',
		'admin_url'      => 'edit.php?post_type=jet-theme-core',
	);

	return $integrations;

}  // end function
