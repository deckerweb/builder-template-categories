<?php

// includes/integrations/integration-loomisoft-content-blocks

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_loomisoft_content_blocks' );
/**
 * Register Reusable Content & Text Blocks by Loomisoft.
 *
 * @since 1.2.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_loomisoft_content_blocks( array $integrations ) {

	$integrations[ 'loomisoft-content-blocks' ] = array(
		'label'          => __( 'Loomisoft Reusable Content Blocks', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=lscontentblock',
		'post_type'      => 'lscontentblock',
		'template_label' => 'block',
		'admin_url'      => 'edit.php?post_type=lscontentblock',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Block type template
 *
 * @since 1.2.0
 */
add_filter( 'btc/filter/is_type/block', '__return_true' );


add_filter( 'manage_edit-lscontentblock_columns', 'ddw_btc_add_tax_column_loomisoft_content_blocks', 10, 1 );
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
function ddw_btc_add_tax_column_loomisoft_content_blocks( $columns ) {

	$columns[ 'builder-template-category' ] = ddw_btc_string_template( 'block' );

	return $columns;

}  // end function


/**
 * Needed step to add the custom data to the added column in the post type list
 *   table. Will run at hook 'manage_{$post_type}_posts_custom_column'.
 *
 * @since 1.4.0
 */
ddw_btc_prepare_tax_column_add( 'lscontentblock' );
