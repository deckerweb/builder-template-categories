<?php

// includes/integrations/integration-reusable-blocks-extended

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'manage_edit-wp_block_columns', 'ddw_btc_add_tax_column_reusable_blocks_extended', 10, 1 );
/**
 * Manually add our tax column to the post type list table. This is a needed
 *   step as the automatic adding doesn't work for this (customized) post type
 *   list table.
 *
 * @since 1.8.0
 *
 * @uses ddw_btc_string_template()
 *
 * @param array $columns Array that holds all columns.
 * @return array Modified array of columns.
 */
function ddw_btc_add_tax_column_reusable_blocks_extended( $columns ) {

	$columns[ 'builder-template-category' ] = ddw_btc_string_template( 'block' );

	return $columns;

}  // end function


/**
 * Needed step to add the custom data to the added column in the post type list
 *   table. Will run at hook 'manage_{$post_type}_posts_custom_column'.
 *
 * @since 1.8.0
 */
ddw_btc_prepare_tax_column_add( 'wp_block' );
