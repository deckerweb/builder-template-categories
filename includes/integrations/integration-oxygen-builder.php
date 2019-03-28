<?php

// includes/integrations/integration-oxygen-builder

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_oxygen_builder' );
/**
 * Register Oxygen Builder (works with v1.x and v2.x+).
 *
 * @since 1.0.0
 * @since 1.5.0 Added User Library Elements post type.
 *
 * @uses ddw_btc_is_oxygen_user_library_active()
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_oxygen_builder( array $integrations ) {

	/** For: Oxygen Templates ('ct_template') */
	$integrations[ 'oxygen-builder' ] = array(
		'label'          => __( 'Oxygen Builder Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'ct_dashboard_page',
		'post_type'      => 'ct_template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=ct_template',
	);

	/** For: Oxygen User Elements Libraray ('?') */
	if ( ddw_btc_is_oxygen_user_library_active() ) {

		$integrations[ 'oxygen-elements-library' ] = array(
			'label'          => __( 'Oxygen User Elements Library', 'builder-template-categories' ),
			'submenu_hook'   => 'edit.php?post_type=oxy_user_library',
			'post_type'      => 'oxy_user_library',
			'template_label' => 'library',
			'admin_url'      => 'edit.php?post_type=oxy_user_library',
		);

	}  // end if

	return $integrations;

}  // end function
