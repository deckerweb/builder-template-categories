<?php

// includes/integrations/integration-popup-maker

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_master_popups' );
/**
 * Register Popup Maker plugin.
 *
 * @since 1.0.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_master_popups( array $integrations ) {

	$integrations[ 'master-popups' ] = array(
		'label'          => __( 'Master Popup Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=master-popups',
		'post_type'      => 'master-popups',
		'template_label' => 'popup',
		'admin_url'      => 'edit.php?post_type=master-popups',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Popup type template
 *
 * @since 1.4.0
 */
add_filter( 'btc/filter/is_type/popup', '__return_true' );


add_action( 'add_meta_boxes', 'ddw_btc_add_categories_metabox_master_popups', 200 );
/**
 * Display our taxonomy meta box on Blox's edit screens for Global Blocks.
 *   This is necessary as Blox removes all metaboxes it does not want at
 *   priority 100. So we bring in ours at priority 200 ;-).
 *
 * @since 1.4.0
 *
 * @see https://developer.wordpress.org/reference/functions/add_meta_box/
 *
 * @uses add_meta_box()
 * @uses post_categories_meta_box() Original function from WP core, used as callback here.
 * @uses ddw_btc_string_template()
 */
function ddw_btc_add_categories_metabox_master_popups() {

    add_meta_box(
    	'builder-template-category',
    	ddw_btc_string_template( 'popup' ),
    	'post_categories_meta_box',	// WP Core callback function for taxonomies - what we need!
    	'master-popups',	// post type
    	'advanced',			// context
    	'high',				// priority
    	array(				// args for the above callback function
    		'taxonomy' => 'builder-template-category',
    	)
    );

}  // end function


add_filter( 'manage_edit-master-popups_columns', 'ddw_btc_add_tax_column_master_popups', 10, 1 );
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
function ddw_btc_add_tax_column_master_popups( $columns ) {

	$columns[ 'builder-template-category' ] = ddw_btc_string_template( 'popup' );

	return $columns;

}  // end function


/**
 * Needed step to add the custom data to the added column in the post type list
 *   table. Will run at hook 'manage_{$post_type}_posts_custom_column'.
 *
 * @since 1.4.0
 */
ddw_btc_prepare_tax_column_add( 'master-popups' );
