<?php

// includes/register-taxonomy

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'init', 'ddw_btc_register_templates_taxonomy', 20 );
/**
 * Register Taxonomy for categorizing Templates for use in Page Builder contexts.
 *
 * @since 1.0.0
 *
 * @uses  register_taxonomy()
 */
function ddw_btc_register_templates_taxonomy() {

	/** Set taxonomy labels, filterable */
	$tax_labels = apply_filters(
		'btc/filter/taxonomy/labels',
		array(
			'name'                       => _x( 'Template Categories', 'Taxonomy General Name', 'builder-template-categories' ),
			'singular_name'              => _x( 'Template Category', 'Taxonomy Singular Name', 'builder-template-categories' ),
			'menu_name'                  => __( 'Taxonomy', 'builder-template-categories' ),
			'all_items'                  => __( 'All Template Categories', 'builder-template-categories' ),
			'parent_item'                => __( 'Parent Template Category', 'builder-template-categories' ),
			'parent_item_colon'          => __( 'Parent Template Category:', 'builder-template-categories' ),
			'new_item_name'              => __( 'New Template Category Name', 'builder-template-categories' ),
			'add_new_item'               => __( 'Add New Template Category', 'builder-template-categories' ),
			'edit_item'                  => __( 'Edit Template Category', 'builder-template-categories' ),
			'update_item'                => __( 'Update Template Category', 'builder-template-categories' ),
			'view_item'                  => __( 'View Template Category', 'builder-template-categories' ),
			'separate_items_with_commas' => __( 'Separate Template Categories with commas', 'builder-template-categories' ),
			'add_or_remove_items'        => __( 'Add or remove categories', 'builder-template-categories' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'builder-template-categories' ),
			'popular_items'              => __( 'Popular Categories', 'builder-template-categories' ),
			'search_items'               => __( 'Search Template Categories', 'builder-template-categories' ),
			'not_found'                  => __( 'No Template Categories found.', 'builder-template-categories' ),
			'no_terms'                   => __( 'No Template Categories', 'builder-template-categories' ),
			//'items_list'                 => __( 'Items list', 'builder-template-categories' ),
			//'items_list_navigation'      => __( 'Items list navigation', 'builder-template-categories' ),
		)
	);

	/** Set taxonomy args, filterable */
	$args = apply_filters(
		'btc/filter/taxonomy/args',
		array(
			'labels'            => $tax_labels,
			'hierarchical'      => TRUE,
			'public'            => FALSE,
			'show_ui'           => TRUE,
			'show_admin_column' => TRUE,
			'show_in_nav_menus' => FALSE,
			'show_tagcloud'     => FALSE,
			'show_in_rest'      => FALSE,
			'description'       => __( 'Template Categories for templates of Page Builders or similar libraries', 'builder-template-categories' ) 
		)
	);

	/** Finally, register the taxonomy */
	register_taxonomy(
		'builder-template-category',
		'btc-custom-post-type',
		$args
	);

}  // end function


//add_action( 'init', 'ddw_btc_add_predefined_terms', 25 );
/**
 * Add predefined taxonomy terms for our taxonomy.
 *   Terms: General, Frontpage, Pages, Landing Pages, Sections, Hooks, Testing
 *
 * @since 1.0.0
 *
 * @uses  wp_insert_term()
 */
function ddw_btc_add_predefined_terms() {

	/** Set taxonomy */
	$taxonomy = 'builder-template-category';

	/** Set predefined terms, filterable */
	$terms = apply_filters(
		'btc/filter/taxonomy/predefined_terms',
		array(

			'0' => array(
				'name'        => esc_attr_x( 'General', 'Taxonomy term title', 'builder-template-categories' ),
				'slug'        => sanitize_key( _x( 'general', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
				'description' => _x( 'General templates', 'Taxonomy term description', 'builder-template-categories' ),
			),
			'1' => array(
				'name'        => esc_attr_x( 'Frontpage', 'Taxonomy term title', 'builder-template-categories' ),
				'slug'        => sanitize_key( _x( 'frontpage', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
				'description' => _x( 'Templates for the Frontpage/ Homepage', 'Taxonomy term description', 'builder-template-categories' ),
			),
			'2' => array(
				'name'        => esc_attr_x( 'Pages', 'Taxonomy term title', 'builder-template-categories' ),
				'slug'        => sanitize_key( _x( 'pages', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
				'description' => _x( 'Templates for Pages', 'Taxonomy term description', 'builder-template-categories' ),
			),
			'3' => array(
				'name'        => esc_attr_x( 'Landing Pages', 'Taxonomy term title', 'builder-template-categories' ),
				'slug'        => sanitize_key( _x( 'landing-pages', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
				'description' => _x( 'Templates for Landing Pages', 'Taxonomy term description', 'builder-template-categories' ),
			),
			'4' => array(
				'name'        => esc_attr_x( 'Sections', 'Taxonomy term title', 'builder-template-categories' ),
				'slug'        => sanitize_key( _x( 'sections', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
				'description' => _x( 'Templates for Sections/ Content Blocks', 'Taxonomy term description', 'builder-template-categories' ),
			),
			'5' => array(
				'name'        => esc_attr_x( 'Hooks', 'Taxonomy term title', 'builder-template-categories' ),
				'slug'        => sanitize_key( _x( 'hooks', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
				'description' => _x( 'Templates for Action Hooks', 'Taxonomy term description', 'builder-template-categories' ),
			),
			'6' => array(
				'name'        => esc_attr_x( 'Testing', 'Taxonomy term title', 'builder-template-categories' ),
				'slug'        => sanitize_key( _x( 'testing', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
				'description' => _x( 'Templates just for testing purposes', 'Taxonomy term description', 'builder-template-categories' ),
			),

		)  // end array
	);

	/** Insert all predefined terms */
	foreach ( $terms as $term_key => $term ) {

		if ( ! term_exists( $term[ 'slug' ], 'builder-template-category' ) ) {

			wp_insert_term(
				$term[ 'name' ],
				$taxonomy, 
				array(
					'description' => $term[ 'description' ],
					'slug'        => $term[ 'slug' ],
				)
			);

			unset( $term );

		}  // end if

	}  // end foreach

}  // end function