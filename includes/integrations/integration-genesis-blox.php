<?php

// includes/integrations/integration-genesis-blox

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_blox' );
/**
 * Register Blox plugin (for Genesis).
 *
 * @since  1.0.0
 *
 * @param  array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_blox( array $integrations ) {

	$integrations[ 'genesis-blox' ] = array(
		'label'          => __( 'Blox Global Blocks (for Genesis)', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=blox',
		'post_type'      => 'blox',
		'template_label' => 'block',
		'admin_url'      => 'edit.php?post_type=blox',
		'add_tax_column' => 'yes',
	);

	return $integrations;

}  // end function


add_action( 'add_meta_boxes', 'ddw_btc_add_categories_metabox_blox', 200 );
/**
 * Display our taxonomy meta box on Blox's edit screens for Global Blocks.
 *   This is necessary as Blox removes all metaboxes it does not want at
 *   priority 100. So we bring in ours at priority 200 ;-).
 *
 * @since 1.0.0
 *
 * @see   https://developer.wordpress.org/reference/functions/add_meta_box/
 *
 * @uses  add_meta_box()
 * @uses  post_categories_meta_box() Original function from WP core, used as callback here.
 * @uses  ddw_btc_string_template()
 */
function ddw_btc_add_categories_metabox_blox() {

	add_meta_box(
		'builder-template-category',
		ddw_btc_string_template( 'block' ),	//esc_attr__( 'Block Categories', 'builder-template-categories' ),
		'post_categories_meta_box',	// WP Core callback function for taxonomies - what we need!
		'blox',		// post type
		'side',		// context
		'default',	// priority
		array(		// args for the above callback function
			'taxonomy' => 'builder-template-category',
		)
	);

}  // end function


/**
 * Set flag for Block type template
 *
 * @since 1.2.0
 */
add_filter( 'btc/filter/is_type/block', '__return_true' );


add_filter( 'blox_admin_column_titles', 'ddw_btc_add_tax_column_blox' );
/**
 * Manually add our tax column to the post type list table. This is a needed
 *   step as the automatic adding doesn't work for this (customized) post type
 *   list table.
 *   Note: The core default filter 'manage_edit-blox_columns' is not working
 *         here as 'Blox' plugin already has customized columns - but luckily
 *         provides its own filters :).
 *
 * @since  1.4.0
 *
 * @uses   ddw_btc_string_template()
 *
 * @param  array $columns Array that holds all columns.
 * @return array Modified array of columns.
 */
function ddw_btc_add_tax_column_blox( $columns ) {

	$columns[ 'builder-template-category' ] = ddw_btc_string_template( 'block' );

	return $columns;

}  // end function