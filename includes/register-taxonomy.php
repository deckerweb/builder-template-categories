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


/**
 * Build translated taxonomy labels for the current screen or REST post type.
 *
 * @param string|null $content_type Translated content type, or null for the default.
 * @return array Taxonomy labels, including existing label filter overrides.

 * @since 1.9.0
 */
function ddw_btc_get_taxonomy_labels( $content_type = null ) {

	// One shared taxonomy across builders; distinguish it from Core pattern categories.
	$content_type = 'Builder';

	/** Set taxonomy labels, filterable */
	return apply_filters(
		'btc/filter/taxonomy/labels',
		array(
			'name'                       => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				_x( '%s Categories', 'Taxonomy General Name', 'builder-template-categories' ),
				$content_type
			),
			'singular_name'              => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				_x( '%s Category', 'Taxonomy Singular Name', 'builder-template-categories' ),
				$content_type
			),
			'all_items'                  => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'All %s Categories', 'builder-template-categories' ),
				$content_type
			),
			'parent_item'                => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'Parent %s Category', 'builder-template-categories' ),
				$content_type
			),
			'parent_item_colon'          => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'Parent %s Category:', 'builder-template-categories' ),
				$content_type
			),
			'new_item_name'              => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'New %s Category Name', 'builder-template-categories' ),
				$content_type
			),
			'add_new_item'               => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'Add New %s Category', 'builder-template-categories' ),
				$content_type
			),
			'edit_item'                  => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'Edit %s Category', 'builder-template-categories' ),
				$content_type
			),
			'update_item'                => sprintf(
				/* translators: %s - translated template content type. */
				__( 'Update %s Category', 'builder-template-categories' ),
				$content_type
			),
			'view_item'                  => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'View %s Category', 'builder-template-categories' ),
				$content_type
			),
			'separate_items_with_commas' => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'Separate %s Categories with commas', 'builder-template-categories' ),
				$content_type
			),
			'add_or_remove_items'        => __( 'Add or remove categories', 'builder-template-categories' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'builder-template-categories' ),
			'popular_items'              => __( 'Popular Categories', 'builder-template-categories' ),
			'search_items'               => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'Search %s Categories', 'builder-template-categories' ),
				$content_type
			),
			'not_found'                  => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'No %s Categories found.', 'builder-template-categories' ),
				$content_type
			),
			'no_terms'                   => sprintf(
				/* translators: %s - Label name for default content type, "Template" */
				__( 'No %s Categories', 'builder-template-categories' ),
				$content_type
			),
			//'items_list'                 => __( 'Items list', 'builder-template-categories' ),
			//'items_list_navigation'      => __( 'Items list navigation', 'builder-template-categories' ),
		)
	);


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

 * @return void
 */
function ddw_btc_register_templates_taxonomy() {

	$tax_labels = ddw_btc_get_taxonomy_labels();

	/** Set taxonomy args, filterable */
	$args = apply_filters(
		'btc/filter/taxonomy/args',
		array(
			'labels'            => $tax_labels,	//ddw_btc_get_taxonomy_labels(),
			'hierarchical'      => TRUE,
			'public'            => FALSE,
			'show_ui'           => current_user_can( ddw_btc_capability_submenu() ),
			'show_in_menu'      => FALSE,
			'capabilities'      => array(
				'manage_terms' => ddw_btc_capability_submenu(),
				'edit_terms'   => ddw_btc_capability_submenu(),
				'delete_terms' => ddw_btc_capability_submenu(),
				'assign_terms' => ddw_btc_capability_submenu(),
			),
			'show_admin_column' => current_user_can( ddw_btc_capability_submenu() ),
			'rewrite'           => FALSE,
			'show_in_nav_menus' => FALSE,
			'show_tagcloud'     => FALSE,
			'show_in_rest'      => TRUE,	//FALSE,
			'description'       => __( 'Template Categories for templates of Page Builders or similar libraries', 'builder-template-categories' )
		)
	);

	$post_types = ddw_btc_get_integration_post_types( 'all' );

	/** Finally, register the taxonomy */
	register_taxonomy(
		'builder-template-category',
		$post_types,	//'btc-custom-post-type',
		$args
	);

}  // end function





/**
 * Default template categories for newly activated sites, filterable.

 * @since 1.9.0
 * @return array Default term definitions.
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
	if ( ! is_string( $taxonomy ) || ! taxonomy_exists( $taxonomy ) ) {
		return;
	}
	// Never refill an existing category collection or duplicate translated defaults.
	$existing = get_terms( array( 'taxonomy' => $taxonomy, 'hide_empty' => false, 'fields' => 'ids', 'number' => 1 ) );
	if ( is_wp_error( $existing ) || ! empty( $existing ) ) {
		return;
	}
	$terms = ddw_btc_get_predefined_terms();
	if ( ! is_array( $terms ) ) {
		return;
	}
	foreach ( $terms as $term ) {
		if ( ! is_array( $term ) || ! isset( $term['name'], $term['slug'], $term['description'] ) || ! is_string( $term['name'] ) || ! is_string( $term['slug'] ) || ! is_string( $term['description'] ) ) {
			continue;
		}
		if ( ! term_exists( $term['slug'], $taxonomy ) ) {
			wp_insert_term( $term['name'], $taxonomy, array( 'slug' => $term['slug'], 'description' => $term['description'] ) );
		}
	}
}


add_filter( 'rest_prepare_taxonomy', 'ddw_btc_rest_taxonomy_labels', 10, 3 );
/**
 * Supply Gutenberg with translated labels for the requested integration.
 * REST requests have no admin screen; do not change the shared taxonomy object.
 *
 * @param WP_REST_Response $response Prepared response.
 * @param WP_Taxonomy      $taxonomy Registered taxonomy.
 * @param WP_REST_Request  $request  REST request.
 * @return WP_REST_Response

 * @since 1.9.0
 */
function ddw_btc_rest_taxonomy_labels( $response, $taxonomy, $request ) {

	if ( 'builder-template-category' !== $taxonomy->name ) {
		return $response;
	}

	$post_type = $request->get_param( 'type' );
	if ( ! is_string( $post_type ) || ! in_array( $post_type, (array) $taxonomy->object_type, true ) ) {
		return $response;
	}

	foreach ( ddw_btc_get_integrations() as $integration ) {
		if ( $post_type !== $integration['post_type'] ) {
			continue;
		}

		$labels = ddw_btc_get_taxonomy_labels( ddw_btc_string_content_type( $integration['template_label'] ) );
		$data   = $response->get_data();

		// Respect context and _fields: update only fields already in the response.
		if ( isset( $data['name'] ) ) {
			$data['name'] = $labels['name'];
		}
		if ( isset( $data['labels'] ) ) {
			$data['labels'] = array_replace( (array) $data['labels'], array_intersect_key( $labels, (array) $data['labels'] ) );
		}

		$response->set_data( $data );
		break;
	}

	return $response;

}


add_filter( 'rest_pre_dispatch', 'ddw_btc_rest_terms_permissions', 10, 3 );
/**
 * Restrict internal template categories to the configured taxonomy capability.
 *
 * @since 1.9.0
 * @param mixed           $result  Previously short-circuited REST result.
 * @param WP_REST_Server  $server  REST server.
 * @param WP_REST_Request $request Current request.
 * @return mixed Original result, or an authorization error for our term route.
 */
function ddw_btc_rest_terms_permissions( $result, $server, $request ) {
	$taxonomy = get_taxonomy( 'builder-template-category' );
	if ( ! $taxonomy ) {
		return $result;
	}
	$namespace = $taxonomy->rest_namespace ?: 'wp/v2';
	$base = $taxonomy->rest_base ?: $taxonomy->name;
	$prefix = '/' . trim( $namespace, '/' ) . '/' . trim( $base, '/' );
	$route = $request->get_route();
	if ( ( $route === $prefix || str_starts_with( $route, $prefix . '/' ) ) && ! current_user_can( $taxonomy->cap->assign_terms ) ) {
		return new WP_Error( 'rest_forbidden', __( 'Sorry, you are not allowed to access template categories.', 'builder-template-categories' ), array( 'status' => rest_authorization_required_code() ) );
	}
	return $result;
}

add_action( 'admin_notices', 'ddw_btc_category_origin_notice' );
/**
 * Explain which plugin owns this taxonomy in its management screen.
 *
 * @since 1.9.0
 * @return void
 */
function ddw_btc_category_origin_notice() {
	$screen = get_current_screen();
	if ( ! is_admin() || ! $screen || 'edit-tags' !== $screen->base || 'builder-template-category' !== $screen->taxonomy || ! current_user_can( ddw_btc_capability_submenu() ) ) {
		return;
	}

	$links = array();
	$types = array();
	foreach ( ddw_btc_get_integrations() as $integration ) {
		$post_type = get_post_type_object( $integration['post_type'] );
		if ( ! $post_type || ! is_object_in_taxonomy( $post_type->name, 'builder-template-category' ) ) {
			continue;
		}
		$label = esc_html( $integration['label'] );
		if ( current_user_can( $post_type->cap->edit_posts ) ) {
			$label = '<a href="' . esc_url( admin_url( $integration['admin_url'] ) ) . '">' . $label . '</a>';
		}
		$links[] = $label;
		$types[$post_type->name] = '<code>' . esc_html( $post_type->name ) . '</code>';
	}

	echo '<div class="notice notice-info"><p><strong>' . esc_html__( 'Available on this website', 'builder-template-categories' ) . '</strong><br>';
	echo esc_html__( 'Builder Categories organize these template libraries on this website. The listed libraries share the same set of categories.', 'builder-template-categories' ) . '</p>';
	if ( $links ) {
		echo '<p>' . wp_kses_post( implode( ' · ', $links ) ) . '</p>';
		echo '<details><summary>' . esc_html__( 'Technical details: post types', 'builder-template-categories' ) . '</summary><p>' . wp_kses_post( implode( ', ', $types ) ) . '</p></details>';
	} else {
		echo '<p>' . esc_html__( 'No supported template libraries are currently available.', 'builder-template-categories' ) . '</p>';
	}
	echo '<p>' . esc_html__( 'Categories provided by Builder Template Categories. Independent of WordPress pattern categories.', 'builder-template-categories' ) . '</p></div>';
}
