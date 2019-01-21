<?php

// includes/integrations/integration-wpshowposts

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_wpshowposts' );
/**
 * Register WP Show Posts plugin.
 *
 * @since 1.0.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_wpshowposts( array $integrations ) {

	$integrations[ 'wp-show-posts' ] = array(
		'label'          => __( 'WP Show Posts Listings', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=wp_show_posts',
		'post_type'      => 'wp_show_posts',
		'template_label' => 'listing',
		'admin_url'      => 'edit.php?post_type=wp_show_posts',
	);

	return $integrations;

}  // end function


/**
 * Sadly we need to remove the original WP Show Posts meta box removal function
 *   to let our metabox (see: ddw_btc_add_categories_metabox_wpshowposts())
 *   appear.
 *
 * @since 1.0.0
 */
remove_action( 'add_meta_boxes', 'wpsp_remove_metaboxes', 99 );


add_action( 'add_meta_boxes', 'ddw_btc_add_categories_metabox_wpshowposts' );
/**
 * Display our taxonomy meta box on Blox's edit screens for Global Blocks.
 *   This is necessary as Blox removes all metaboxes it does not want at
 *   priority 100. So we bring in ours at priority 200 ;-).
 *
 * @since 1.0.0
 *
 * @see https://developer.wordpress.org/reference/functions/add_meta_box/
 *
 * @uses add_meta_box()
 * @uses post_categories_meta_box() Original function from WP core, used as callback here.
 */
function ddw_btc_add_categories_metabox_wpshowposts() {

    add_meta_box(
    	'builder-template-category',
    	esc_attr__( 'Listing Categories', 'builder-template-categories' ),
    	'post_categories_meta_box',	// WP Core callback function for taxonomies - what we need!
    	'blox',		// post type
    	'side',		// context
    	'default',	// priority
    	array(		// args for the above callback function
    		'taxonomy' => 'builder-template-category',
            'title'    => esc_attr__( 'Listing Categories', 'builder-template-categories' ),
    	)
    );

}  // end function
