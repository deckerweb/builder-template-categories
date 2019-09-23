<?php

// includes/integrations/integration-woody-snippets

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_woody_snippets' );
/**
 * Register Woody Snippets plugin.
 *
 * @since 1.7.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_woody_snippets( array $integrations ) {

	$integrations[ 'woody-snippets' ] = array(
		'label'          => __( 'Woody Snippets', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=wbcr-snippets',
		'post_type'      => 'wbcr-snippets',
		'template_label' => 'snippet',
		'admin_url'      => 'edit.php?post_type=wbcr-snippets',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Snippet type template
 *
 * @since 1.7.0
 */
add_filter( 'btc/filter/is_type/snippet', '__return_true' );


add_filter( 'manage_edit-wbcr-snippets', 'ddw_btc_add_tax_column_woody_snippets', 15, 1 );
/**
 * Manually add our tax column to the post type list table. This is a needed
 *   step as the automatic adding doesn't work for this (customized) post type
 *   list table.
 *
 * @since 1.7.0
 *
 * @uses ddw_btc_string_template()
 *
 * @param array $columns Array that holds all columns.
 * @return array Modified array of columns.
 */
function ddw_btc_add_tax_column_woody_snippets( $columns ) {

	$columns[ 'builder-template-category' ] = ddw_btc_string_template( 'snippet' );

	return $columns;

}  // end function


/**
 * Needed step to add the custom data to the added column in the post type list
 *   table. Will run at hook 'manage_{$post_type}_posts_custom_column'.
 *
 * @since 1.7.0
 */
ddw_btc_prepare_tax_column_add( 'wbcr-snippets' );


add_action( 'add_meta_boxes', 'ddw_btc_add_categories_metabox_woody_snippets', 100 );
/**
 * Display our taxonomy meta box on Blox's edit screens for Global Blocks.
 *   This is necessary as Blox removes all metaboxes it does not want at
 *   priority 100. So we bring in ours at priority 200 ;-).
 *
 * @since 1.7.0
 *
 * @see https://developer.wordpress.org/reference/functions/add_meta_box/
 *
 * @uses add_meta_box()
 * @uses post_categories_meta_box() Original function from WP core, used as callback here.
 */
function ddw_btc_add_categories_metabox_woody_snippets() {

    add_meta_box(
    	'builder-template-category',
    	esc_attr__( 'Snippet Categories', 'builder-template-categories' ),
    	'post_categories_meta_box',	// WP Core callback function for taxonomies - what we need!
    	'blox',		// post type
    	'side',		// context
    	'default',	// priority
    	array(		// args for the above callback function
    		'taxonomy' => 'builder-template-category',
            'title'    => esc_attr__( 'Snippet Categories', 'builder-template-categories' ),
    	)
    );

}  // end function
