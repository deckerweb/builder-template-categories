<?php

// includes/integrations/integration-text-blocks

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_text_blocks' );
/**
 * Register Content Blocks (Custom Post Widget).
 *
 * @since 1.2.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_text_blocks( array $integrations ) {

	$integrations[ 'hg-text-blocks' ] = array(
		'label'          => __( 'Text Blocks', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=text-blocks',
		'post_type'      => 'text-blocks',
		'template_label' => 'block',
		'admin_url'      => 'edit.php?post_type=text-blocks',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Block type template
 *
 * @since 1.2.0
 */
add_filter( 'btc/filter/is_type/block', '__return_true' );


add_filter( 'manage_edit-text-blocks_columns', 'ddw_btc_add_tax_column_text_blocks', 10, 1 );
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
function ddw_btc_add_tax_column_text_blocks( $columns ) {

	$columns[ 'builder-template-category' ] = ddw_btc_string_template( 'block' );

	return $columns;

}  // end function


/**
 * Needed step to add the custom data to the added column in the post type list
 *   table. Will run at hook 'manage_{$post_type}_posts_custom_column'.
 *
 * @since 1.4.0
 */
ddw_btc_prepare_tax_column_add( 'text-blocks' );
