<?php

// includes/integrations/integration-ht-script

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_ht_script' );
/**
 * Register HT Script (free & Pro) plugin.
 *
 * @since 1.6.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_ht_script( array $integrations ) {

	$integrations[ 'ht-script' ] = array(
		'label'          => __( 'HT Script - Header &amp; Footer Scripts', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=ihafs_script',
		'post_type'      => 'ihafs_script',
		'template_label' => 'script',
		'admin_url'      => 'edit.php?post_type=ihafs_script',
	);

	return $integrations;

}  // end function


add_filter( 'manage_edit-ihafs_script_columns', 'ddw_btc_add_tax_column_ht_script', 10, 1 );
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
function ddw_btc_add_tax_column_ht_script( $columns ) {

	$columns[ 'builder-template-category' ] = ddw_btc_string_template( 'script' );

	return $columns;

}  // end function


/**
 * Needed step to add the custom data to the added column in the post type list
 *   table. Will run at hook 'manage_{$post_type}_posts_custom_column'.
 *
 * @since 1.6.0
 */
ddw_btc_prepare_tax_column_add( 'ihafs_script' );
