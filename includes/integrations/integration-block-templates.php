<?php

// includes/integrations/integration-block-templates

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_block_templates' );
/**
 * Register Gutenberg Templates (Block Templates).
 *
 * @since 1.4.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_block_templates( array $integrations ) {

	$integrations[ 'gutenberg-block-templates' ] = array(
		'label'          => __( 'Gutenberg Block Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=gutenberg-template',
		'post_type'      => 'gutenberg-template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=gutenberg-template',
		'block_editor'   => 'register_early',
	);

	return $integrations;

}  // end function


add_filter( 'manage_edit-gutenberg-template_columns', 'ddw_btc_add_tax_column_block_templates', 20, 1 );
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
function ddw_btc_add_tax_column_block_templates( $columns ) {

	$columns[ 'builder-template-category' ] = ddw_btc_string_template( 'template' );

	return $columns;

}  // end function


/**
 * Needed step to add the custom data to the added column in the post type list
 *   table. Will run at hook 'manage_{$post_type}_posts_custom_column'.
 *
 * @since 1.4.0
 */
ddw_btc_prepare_tax_column_add( 'gutenberg-template' );
