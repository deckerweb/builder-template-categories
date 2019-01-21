<?php

// includes/integrations/integration-block-lab

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_block_lab' );
/**
 * Register Block Lab.
 *
 * @since 1.4.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_block_lab( array $integrations ) {

	$integrations[ 'block-lab' ] = array(
		'label'          => __( 'Block Lab Blocks', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=block_lab',
		'post_type'      => 'block_lab',
		'template_label' => 'block',
		'admin_url'      => 'edit.php?post_type=block_lab',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Block type template
 *
 * @since 1.4.0
 */
add_filter( 'btc/filter/is_type/block', '__return_true' );


add_filter( 'manage_edit-block_lab_columns', 'ddw_btc_add_tax_column_block_lab', 20, 1 );
/**
 * Manually add our tax column to the post type list table. This is a needed
 *   step as the automatic adding doesn't work for this (customized) post type
 *   list table.
 *
 * @since 1.4.0
 *
 * @uses ddw_btc_string_template()
 *
 * @param array $columns Array that holds all columns.
 * @return array Modified array of columns.
 */
function ddw_btc_add_tax_column_block_lab( $columns ) {

	$columns[ 'builder-template-category' ] = ddw_btc_string_template( 'block' );

	return $columns;

}  // end function


/**
 * Needed step to add the custom data to the added column in the post type list
 *   table. Will run at hook 'manage_{$post_type}_posts_custom_column'.
 *
 * @since 1.4.0
 */
ddw_btc_prepare_tax_column_add( 'block_lab' );
