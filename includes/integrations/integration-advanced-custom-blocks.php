<?php

// includes/integrations/integration-advanced-custom-blocks

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_advanced_custom_blocks' );
/**
 * Register Advanced Custom Blocks.
 *
 * @since 1.2.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_advanced_custom_blocks( array $integrations ) {

	$integrations[ 'advanced-custom-blocks' ] = array(
		'label'          => __( 'Advanced Custom Blocks', 'builder-template-categories' ),
		'submenu_hook'   => 'acb',		// 'edit.php?post_type=acb_block'
		'post_type'      => 'acb_block',
		'template_label' => 'block',
		'admin_url'      => 'edit.php?post_type=acb_block',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Block type template
 *
 * @since 1.2.0
 */
add_filter( 'btc/filter/is_type/block', '__return_true' );


add_action( 'admin_menu', 'ddw_btc_add_submenu_acb_addnew' );
/**
 * Since "Advanced Custom Blocks" plugin has no left-hand "Add New" submenu in
 *   the addmin, we add this so it becomes more convenient for users.
 *
 * @since 1.2.0
 *
 * @uses add_submenu_page()
 * @uses ddw_btc_string_add_new()
 */
function ddw_btc_add_submenu_acb_addnew() {

	add_submenu_page(
		'acb',		// 'edit.php?post_type=acb_block'
		ddw_btc_string_add_new(),
		ddw_btc_string_add_new(),
		'edit_theme_options',
		esc_url( admin_url( 'post-new.php?post_type=acb_block' ) )
	);

}  // end function
