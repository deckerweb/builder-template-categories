<?php

// includes/integrations/integration-happyforms

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_happyforms' );
/**
 * Register HappyForms plugin.
 *
 * @since 1.6.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_happyforms( array $integrations ) {

	$integrations[ 'happyforms' ] = array(
		'label'          => __( 'HappyForms Forms', 'builder-template-categories' ),
		'submenu_hook'   => 'happyforms',		// 'edit.php?post_type=happyform',
		'post_type'      => 'happyform',
		'template_label' => 'form',
		'admin_url'      => 'edit.php?post_type=happyform',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Form type template
 *
 * @since 1.6.0
 */
add_filter( 'btc/filter/is_type/form', '__return_true' );


add_filter( 'manage_edit-happyform_columns', 'ddw_btc_add_tax_column_happyforms', 10, 1 );
/**
 * Manually add our tax column to the post type list table. This is a needed
 *   step as the automatic adding doesn't work for this (customized) post type
 *   list table.
 *
 * @since 1.6.0
 *
 * @uses ddw_btc_string_template()
 *
 * @param array $columns Array that holds all columns.
 * @return array Modified array of columns.
 */
function ddw_btc_add_tax_column_happyforms( $columns ) {

	$columns[ 'builder-template-category' ] = ddw_btc_string_template( 'form' );

	return $columns;

}  // end function


/**
 * Needed step to add the custom data to the added column in the post type list
 *   table. Will run at hook 'manage_{$post_type}_posts_custom_column'.
 *
 * @since 1.6.0
 */
ddw_btc_prepare_tax_column_add( 'happyform' );


/** Execute the following tweaks only for HappyForms free version */
if ( ! defined( 'HAPPYFORMS_UPGRADE_VERSION' ) ) {

	add_action( 'admin_menu', 'ddw_btc_remove_submenu_for_happyforms_upgrade', 100 );
	/**
	 * Remove HappyForms "Upgrade" submenu page, so there's no conflict with our own
	 *   submenu page.
	 *
	 * @since 1.6.0
	 */
	function ddw_btc_remove_submenu_for_happyforms_upgrade() {

		$page = remove_submenu_page(
			'happyforms',
			'https://happyforms.me/upgrade'
		);

	}  // end function


	add_action( 'admin_menu', 'ddw_btc_readd_submenu_for_happyforms_upgrade', 700 );
	/**
	 * Re-add HappyForms "Upgrade" page at a later priority.
	 * 
	 * @since 1.6.0
	 *
	 * @uses happyforms_get_form_controller()
	 */
	function ddw_btc_readd_submenu_for_happyforms_upgrade() {

		$form_controller = happyforms_get_form_controller();

		add_submenu_page(
			'happyforms',
			__( 'HappyForms Upgrade', 'builder-template-categories' ),
			__( 'Upgrade', 'builder-template-categories' ),
			$form_controller->capability,
			'https://happyforms.me/upgrade'
		);

	}  // end function

}  // end if
