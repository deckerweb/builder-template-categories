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
 * @since 1.1.0 Make the default label string "Template" filterable.
 * @since 1.3.0 Added logic for optionally adding post types at registering,
 *              for special Block Editor support.
 *
 * @see ddw_btc_string_default_content_type()
 *
 * @uses ddw_btc_get_post_types_for_block_editor()
 * @uses register_taxonomy()
 */
function ddw_btc_register_templates_taxonomy() {

	/** Set taxonomy labels, filterable */
	$tax_labels = apply_filters(
		'btc/filter/taxonomy/labels',
		array(
			'name'                       => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				_x( '%s Categories', 'Taxonomy General Name', 'builder-template-categories' ),
				ddw_btc_string_default_content_type()
			),
			'singular_name'              => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				_x( '%s Category', 'Taxonomy Singular Name', 'builder-template-categories' ),
				ddw_btc_string_default_content_type()
			),
			'menu_name'                  => __( 'Taxonomy', 'builder-template-categories' ),
			'all_items'                  => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'All %s Categories', 'builder-template-categories' ),
				ddw_btc_string_default_content_type()
			),
			'parent_item'                => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'Parent %s Category', 'builder-template-categories' ),
				ddw_btc_string_default_content_type()
			),
			'parent_item_colon'          => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'Parent %s Category:', 'builder-template-categories' ),
				ddw_btc_string_default_content_type()
			),
			'new_item_name'              => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'New %s Category Name', 'builder-template-categories' ),
				ddw_btc_string_default_content_type()
			),
			'add_new_item'               => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'Add New %s Category', 'builder-template-categories' ),
				ddw_btc_string_default_content_type()
			),
			'edit_item'                  => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'Edit %s Category', 'builder-template-categories' ),
				ddw_btc_string_default_content_type()
			),
			'update_item'                => sprintf(
				__( 'Update %s Category', 'builder-template-categories' ),
				ddw_btc_string_default_content_type()
			),
			'view_item'                  => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'View %s Category', 'builder-template-categories' ),
				ddw_btc_string_default_content_type()
			),
			'separate_items_with_commas' => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'Separate %s Categories with commas', 'builder-template-categories' ),
				ddw_btc_string_default_content_type()
			),
			'add_or_remove_items'        => __( 'Add or remove categories', 'builder-template-categories' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'builder-template-categories' ),
			'popular_items'              => __( 'Popular Categories', 'builder-template-categories' ),
			'search_items'               => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'Search %s Categories', 'builder-template-categories' ),
				ddw_btc_string_default_content_type()
			),
			'not_found'                  => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'No %s Categories found.', 'builder-template-categories' ),
				ddw_btc_string_default_content_type()
			),
			'no_terms'                   => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'No %s Categories', 'builder-template-categories' ),
				ddw_btc_string_default_content_type()
			),
			//'items_list'                 => __( 'Items list', 'builder-template-categories' ),
			//'items_list_navigation'      => __( 'Items list navigation', 'builder-template-categories' ),
		)
	);

	/** Set taxonomy args, filterable */
	$args = apply_filters(
		'btc/filter/taxonomy/args',
		array(
			'labels'            => $tax_labels,	//ddw_btc_get_taxonomy_labels(),
			'hierarchical'      => TRUE,
			'public'            => FALSE,
			'show_ui'           => TRUE,
			'show_admin_column' => TRUE,
			'show_in_nav_menus' => FALSE,
			'show_tagcloud'     => FALSE,
			'show_in_rest'      => TRUE,	//FALSE,
			'description'       => __( 'Template Categories for templates of Page Builders or similar libraries', 'builder-template-categories' )
		)
	);

	/** Set post types to add the taxonomy to */
	$post_types = null;

	$block_editor_types = ddw_btc_get_post_types_for_block_editor( 'keys_only' );

	if ( ! is_null( $block_editor_types ) ) {
		$post_types = $block_editor_types;
	}

	/** Finally, register the taxonomy */
	register_taxonomy(
		'builder-template-category',
		$post_types,	//'btc-custom-post-type',
		$args
	);

}  // end function


add_action( 'admin_menu', 'ddw_btc_inbetween_remove_submenu_for_block_editor_types', 599 );
/**
 * Remove the added taxonomy submenu for integrations that explicitely support
 *   the Block Editor (Gutenberg).
 *   Note: This is a necessary in-between step, as we run our integrations at a
 *   later priority. The reasoning behind is, that we need proper label support
 *   for our template content types, that the WordPress core-added submenus
 *   don't add.
 *
 * @since 1.3.0
 *
 * @uses ddw_btc_get_post_types_for_block_editor()
 *
 * @global array $GLOBALS[ 'submenu' ]
 */
function ddw_btc_inbetween_remove_submenu_for_block_editor_types() {

	$types = ddw_btc_get_post_types_for_block_editor();

	if ( ! is_null( $types ) ) {

		foreach ( $types as $type => $type_data ) {
			
			$submenu_hook = $type_data[ 'submenu_hook' ];

			unset( $GLOBALS[ 'submenu' ][ $submenu_hook ][15] );

		}  // end foreach

	}  // end if

}  // end function


/**
 * Setup predefined taxonomy terms for our taxonomy.
 *   Default terms: General, Frontpage, Pages, Landing Pages, Sections, Hooks
 *   and Testing. Plus, more terms depending on various conditions and contexts.
 *
 * @since 1.0.0
 * @since 1.1.0 Added optional terms for products, as well as popups.
 * @since 1.2.0 Added optional terms for blocks, fields, boxes, bars and hooks.
 * @since 1.4.3 Added optional terms for flows and snippets; moved declaration
 *              into own function for reusability.
 *
 * @uses ddw_btc_is_woocommerce_active()
 * @uses ddw_btc_is_elementor_pro_active()
 * @uses ddw_btc_is_elementor_version()
 * @uses ddw_btc_is_block_editor_active()
 *
 * @return array Filterable array of predefined terms, plus arguments.
 */
function ddw_btc_get_predefined_terms() {

	/** Set predefined terms, filterable */
	$terms = array(

		'terms_general' => array(
			'name'        => esc_attr_x( 'General', 'Taxonomy term title', 'builder-template-categories' ),
			'slug'        => sanitize_key( _x( 'general', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
			'description' => _x( 'General templates', 'Taxonomy term description', 'builder-template-categories' ),
		),
		'terms_frontpage' => array(
			'name'        => esc_attr_x( 'Frontpage', 'Taxonomy term title', 'builder-template-categories' ),
			'slug'        => sanitize_key( _x( 'frontpage', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
			'description' => _x( 'Templates for the Frontpage/ Homepage', 'Taxonomy term description', 'builder-template-categories' ),
		),
		'terms_pages' => array(
			'name'        => esc_attr_x( 'Pages', 'Taxonomy term title', 'builder-template-categories' ),
			'slug'        => sanitize_key( _x( 'pages', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
			'description' => _x( 'Templates for Pages', 'Taxonomy term description', 'builder-template-categories' ),
		),
		'terms_landing_pages' => array(
			'name'        => esc_attr_x( 'Landing Pages', 'Taxonomy term title', 'builder-template-categories' ),
			'slug'        => sanitize_key( _x( 'landing-pages', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
			'description' => _x( 'Templates for Landing Pages', 'Taxonomy term description', 'builder-template-categories' ),
		),
		'terms_sections' => array(
			'name'        => esc_attr_x( 'Sections', 'Taxonomy term title', 'builder-template-categories' ),
			'slug'        => sanitize_key( _x( 'sections', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
			'description' => _x( 'Templates for Sections/ Content Blocks', 'Taxonomy term description', 'builder-template-categories' ),
		),
		'terms_hooks' => array(
			'name'        => esc_attr_x( 'Hooks', 'Taxonomy term title', 'builder-template-categories' ),
			'slug'        => sanitize_key( _x( 'hooks', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
			'description' => _x( 'Templates for Action Hooks', 'Taxonomy term description', 'builder-template-categories' ),
		),
		'terms_testing' => array(
			'name'        => esc_attr_x( 'Testing', 'Taxonomy term title', 'builder-template-categories' ),
			'slug'        => sanitize_key( _x( 'testing', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
			'description' => _x( 'Templates just for testing purposes', 'Taxonomy term description', 'builder-template-categories' ),
		),

	);  // end array

	/** Optional: WooCommerce product type templates */
	if ( ddw_btc_is_woocommerce_active() && has_filter( 'btc/filter/is_type/woo' ) ) {

		$terms[ 'terms_woo' ] = array(
			'name'        => esc_attr_x( 'Products', 'Taxonomy term title', 'builder-template-categories' ),
			'slug'        => sanitize_key( _x( 'products', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
			'description' => _x( 'Templates for WooCommerce products', 'Taxonomy term description', 'builder-template-categories' ),
		);

	}  // end if

	/** Optional: Popup type templates */
	if ( has_filter( 'btc/filter/is_type/popup' )
		|| ( ddw_btc_is_elementor_pro_active() && ddw_btc_is_elementor_version( 'pro', '2.4.0-beta1', '>=' ) )
	) {

		$terms[ 'terms_popup' ] = array(
			'name'        => esc_attr_x( 'Popups', 'Taxonomy term title', 'builder-template-categories' ),
			'slug'        => sanitize_key( _x( 'popups', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
			'description' => _x( 'Templates for Popups/ Modal Windows', 'Taxonomy term description', 'builder-template-categories' ),
		);

	}  // end if

	/** Optional: Block type templates */
	if ( ddw_btc_is_block_editor_active() || has_filter( 'btc/filter/is_type/block' ) ) {

		$terms[ 'terms_block' ] = array(
			'name'        => esc_attr_x( 'Blocks', 'Taxonomy term title', 'builder-template-categories' ),
			'slug'        => sanitize_key( _x( 'blocks', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
			'description' => _x( 'Templates for Blocks', 'Taxonomy term description', 'builder-template-categories' ),
		);

	}  // end if

	/** Optional: Field type templates */
	if ( has_filter( 'btc/filter/is_type/field' ) ) {

		$terms[ 'terms_field' ] = array(
			'name'        => esc_attr_x( 'Fields', 'Taxonomy term title', 'builder-template-categories' ),
			'slug'        => sanitize_key( _x( 'fields', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
			'description' => _x( 'Templates for Fields', 'Taxonomy term description', 'builder-template-categories' ),
		);

	}  // end if

	/** Optional: Box type templates */
	if ( has_filter( 'btc/filter/is_type/box' ) ) {

		$terms[ 'terms_box' ] = array(
			'name'        => esc_attr_x( 'Boxes', 'Taxonomy term title', 'builder-template-categories' ),
			'slug'        => sanitize_key( _x( 'boxes', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
			'description' => _x( 'Templates for Boxes', 'Taxonomy term description', 'builder-template-categories' ),
		);

	}  // end if

	/** Optional: Bar type templates */
	if ( has_filter( 'btc/filter/is_type/bar' ) ) {

		$terms[ 'terms_bar' ] = array(
			'name'        => esc_attr_x( 'Bars', 'Taxonomy term title', 'builder-template-categories' ),
			'slug'        => sanitize_key( _x( 'bars', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
			'description' => _x( 'Templates for Bars', 'Taxonomy term description', 'builder-template-categories' ),
		);

	}  // end if

	/** Optional: Flow type templates */
	if ( has_filter( 'btc/filter/is_type/flow' ) ) {

		$terms[ 'terms_flow' ] = array(
			'name'        => esc_attr_x( 'Flows', 'Taxonomy term title', 'builder-template-categories' ),
			'slug'        => sanitize_key( _x( 'flows', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
			'description' => _x( 'Templates for Flows', 'Taxonomy term description', 'builder-template-categories' ),
		);

	}  // end if

	/** Optional: Snippet type content */
	if ( has_filter( 'btc/filter/is_type/snippet' ) ) {

		$terms[ 'terms_snippet' ] = array(
			'name'        => esc_attr_x( 'Snippets', 'Taxonomy term title', 'builder-template-categories' ),
			'slug'        => sanitize_key( _x( 'snippets', 'Taxonomy term slug - only lowercase, a-z, 0-9, hyphens!', 'builder-template-categories' ) ),
			'description' => _x( 'Templates for Snippets', 'Taxonomy term description', 'builder-template-categories' ),
		);

	}  // end if

	/** Return the terms array, filterable */
	return apply_filters(
		'btc/filter/taxonomy/predefined_terms',
		$terms
	);

}  // end function


//add_action( 'init', 'ddw_btc_add_predefined_terms', 25 );
/**
 * Add predefined taxonomy terms for our taxonomy.
 *   See ddw_btc_get_predefined_terms() for the (filterable) terms setup.
 *
 * @since 1.0.0
 * @since 1.1.0 Added optional terms for products, as well as popups.
 * @since 1.2.0 Added optional terms for blocks, fields, boxes, bars and hooks.
 * @since 1.4.3 Added optional terms for flows and snippets.
 *
 * @see ddw_btc_get_predefined_terms()
 *
 * @uses ddw_btc_get_predefined_terms() To get all our predefined terms.
 * @uses wp_insert_term() To actually insert the terms if they not yet exist.
 *
 * @param string $taxonomy Registered ID of a given taxonomy.
 * @return void
 */
function ddw_btc_add_predefined_terms( $taxonomy = '' ) {

	/** Set taxonomy */
	$taxonomy = sanitize_key( $taxonomy );	//'builder-template-category';

	$terms = ddw_btc_get_predefined_terms();

	/** Insert all predefined terms */
	if ( ! is_null( $terms ) ) {

		foreach ( $terms as $term_key => $term ) {

			if ( ! term_exists( $term[ 'slug' ], $taxonomy ) ) {

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

	}  // end if

}  // end function
