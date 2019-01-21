<?php

// includes/integrations/integration-stylepress-elementor

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_stylepress_elementor' );
/**
 * Register StylePress for Elementor plugin.
 *
 * @since 1.2.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_stylepress_elementor( array $integrations ) {

	$integrations[ 'stylepress-elementor' ] = array(
		'label'          => __( 'StylePress Templates for Elementor', 'builder-template-categories' ),
		'submenu_hook'   => 'dtbaker-stylepress',
		'post_type'      => 'dtbaker_style',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=dtbaker_style',
	);

	return $integrations;

}  // end function


add_action( 'admin_menu', 'ddw_btc_add_submenu_stylepress_elementor_style_cpt' );
/**
 * Since "StylePress" has no classic post type list table for its
 *   "Styles" ('dtbaker_style') post type, we just add this here.
 *
 * @since 1.2.0
 *
 * @uses add_submenu_page()
 */
function ddw_btc_add_submenu_stylepress_elementor_style_cpt() {

	add_submenu_page(
		'dtbaker-stylepress',
		esc_html__( 'Styles Overview', 'builder-template-categories' ),
		esc_html__( 'Styles Overview', 'builder-template-categories' ),
		'edit_theme_options',
		esc_url( admin_url( 'edit.php?post_type=dtbaker_style' ) )
	);

}  // end function
