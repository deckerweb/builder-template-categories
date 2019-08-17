<?php

// includes/integrations/integration-givewp

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_givewp' );
/**
 * Register GiveWP Donations plugin.
 *
 * @since 1.6.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_givewp( array $integrations ) {

	$integrations[ 'givewp' ] = array(
		'label'          => __( 'Give Donation Forms', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=give_forms',
		'post_type'      => 'give_forms',
		'template_label' => 'form',
		'admin_url'      => 'edit.php?post_type=give_forms',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Form type template
 *
 * @since 1.6.0
 */
add_filter( 'btc/filter/is_type/form', '__return_true' );


add_filter( 'manage_edit-give_forms_columns', 'ddw_btc_add_tax_column_give_forms', 10, 1 );
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
function ddw_btc_add_tax_column_give_forms( $columns ) {

	$columns[ 'builder-template-category' ] = ddw_btc_string_template( 'form' );

	return $columns;

}  // end function


/**
 * Needed step to add the custom data to the added column in the post type list
 *   table. Will run at hook 'manage_{$post_type}_posts_custom_column'.
 *
 * @since 1.6.0
 */
ddw_btc_prepare_tax_column_add( 'give_forms' );
