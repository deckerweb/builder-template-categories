<?php

// includes/run-integrations

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_init', 'ddw_btc_integrations_add_taxonomy', 100 );
/**
 * Loop through every supported integration's post type and add our custom
 *   taxonomy 'builder-template-category'.
 *   Note: This is a dynamic process - once an integration is deactivated or
 *         de-installed the "mapping" gets "lost". At least visually in the
 *         admin, the mapping in WordPress is kept until the terms are deleted
 *         and the taxonomy gets unregistered.
 *
 * @since 1.0.0
 *
 * @uses ddw_btc_get_integrations()
 */
function ddw_btc_integrations_add_taxonomy() {

	$integrations = ddw_btc_get_integrations();

	foreach ( $integrations as $integration ) {
		
		register_taxonomy_for_object_type( 'builder-template-category', $integration[ 'post_type' ] );

	}  // end foreach

}  // end function


add_action( 'admin_menu', 'ddw_btc_integrations_add_admin_submenus', 600 );
/**
 * Add admin submenu item for each supported integration's post type.
 *   Note: The post type is added as additional param to the admin URL.
 *
 * @since 1.0.0
 * @since 1.1.0 Add firing filter to change bulk actions label.
 *
 * @uses ddw_btc_get_integrations()
 * @uses ddw_btc_taxonomy_admin_url()
 * @uses ddw_btc_string_template()
 * @uses ddw_btc_capability_submenu()
 */
function ddw_btc_integrations_add_admin_submenus() {

	/** Get all active integrations */
	$integrations = ddw_btc_get_integrations();

	/** Iterate through all integrations to add submenu and to fire other tasks */
	foreach ( $integrations as $integration ) {

		/** Build unique taxonomy URL for each supported post type */
		$btc_tax_url = ddw_btc_taxonomy_admin_url() . '&post_type=' . $integration[ 'post_type' ];

		/** Add extra submenu for each active integration */
		add_submenu_page(
			$integration[ 'submenu_hook' ],
			ddw_btc_string_template( $integration[ 'template_label' ] ),
			ddw_btc_string_template( $integration[ 'template_label' ] ),
			ddw_btc_capability_submenu(),
			$btc_tax_url
		);

		/**
		 * Add this point in the iteration fire another filter to tweak a bulk
		 *   edit title label
		 * @since 1.1.0
		 * @see ddw_btc_bulk_actions_edit_title()
		 */
		add_filter( 'bulk_actions-edit-' . $integration[ 'post_type' ], 'ddw_btc_bulk_actions_edit_title' );

	}  // end foreach

}  // end function


/**
 * Tweak title for the "Edit" bulk action for all post types of current active
 *   integrations.
 *
 * @since 1.1.0
 *
 * @param $actions Holds all current bulk actions for a post type.
 * @return array Tweaked array of all bulk actions for a post type.
 */
function ddw_btc_bulk_actions_edit_title( $actions ) {
  
	$actions[ 'edit' ] = esc_html_x(
		'Edit, add Category etc.',
		'Tweaked label for "Edit" bulk action',
		'builder-template-categories'
	);
  
	return $actions;
  
}  // end function


add_action( 'restrict_manage_posts', 'ddw_btc_filter_post_type_by_taxonomy', 100 );
/**
 * Display a custom taxonomy dropdown for the post type overview table.
 *   This will only be added for supported integrations and their post types.
 *
 * The below code was used from/ inspired by:
 * @author Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 *
 * @since 1.0.0
 * @since 1.1.0 Changed taxonomy label to our own logic via
 *              ddw_btc_string_template().
 *
 * @uses ddw_btc_get_integrations()
 * @uses ddw_btc_string_template()
 * @uses wp_dropdown_categories()
 *
 * @global $GLOBALS[ 'pagenow' ]
 */
function ddw_btc_filter_post_type_by_taxonomy() {

	$integrations = ddw_btc_get_integrations();

	foreach ( $integrations as $integration ) {

		$post_type = sanitize_key( $integration[ 'post_type' ] );
		$taxonomy  = 'builder-template-category';

		if ( $post_type == $GLOBALS[ 'typenow' ] ) {

			$selected      = isset( $_GET[ $taxonomy ] ) ? sanitize_key( wp_unslash( $_GET[ $taxonomy ] ) ) : '';
			$info_taxonomy = get_taxonomy( $taxonomy );
			$tax_label     = sprintf(
				/* translators: %s - Category label based on content type, for example: All Template Categories, All Block Categories etc. */
				esc_attr__( 'All %s', 'builder-template-categories' ),
				ddw_btc_string_template( $integration[ 'template_label' ] )
			);

			wp_dropdown_categories(
				array(
					'show_option_all' => $tax_label,
					'taxonomy'        => $taxonomy,
					'name'            => $taxonomy,
					'orderby'         => 'name',
					'selected'        => $selected,
					'show_count'      => FALSE,
					'hide_empty'      => FALSE,
				)
			);

		}  // end if

	}  // end foreach

}  // end function


add_filter( 'parse_query', 'ddw_btc_convert_id_to_term_in_query', 10, 3 );
/**
 * Execute the taxonomy filter within the post type overview table.
 *   This will only be added for supported integrations and their post types.
 *
 * The below code was used from/ inspired by:
 * @author Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 *
 * @since 1.0.0
 *
 * @see ddw_btc_filter_post_type_by_taxonomy()
 *
 * @uses ddw_btc_get_integrations()
 *
 * @global object $GLOBALS[ 'pagenow' ]
 */
function ddw_btc_convert_id_to_term_in_query( $query ) {

	$integrations = ddw_btc_get_integrations();

	foreach ( $integrations as $integration ) {

		$post_type = sanitize_key( $integration[ 'post_type' ] );
		$taxonomy  = 'builder-template-category';
		$q_vars    = &$query->query_vars;

		if ( 'edit.php' === $GLOBALS[ 'pagenow' ]
			&& isset( $q_vars[ 'post_type' ] )
			&& $q_vars[ 'post_type' ] == $post_type
			&& isset( $q_vars[ $taxonomy ] )
			&& is_numeric( $q_vars[ $taxonomy ] )
			&& $q_vars[ $taxonomy ] != 0
		) {

			$term                = get_term_by( 'id', $q_vars[ $taxonomy ], $taxonomy );
			$q_vars[ $taxonomy ] = $term->slug;

		}  // end if

	}  // end foreach

}  // end function


add_filter( 'manage_posts_columns', 'ddw_btc_tweak_taxonomy_column_title' );
/**
 * Tweak the taxonomy List Table columns label so it fits to the content type of
 *   the current integration.
 *
 *   Note: Fires intentionally on the "global" filter 'manage_posts_columns' to
 *         catch all integration post types.
 *
 * @since 1.1.0
 * @since 1.2.0 Added checks for "Field", "Box", "Bar" and "Hook" content types.
 * @since 1.3.0 Added checks for "Filter" content type.
 * @since 1.4.1 Added checks for "Section" content type.
 * @since 1.4.3 Added checks for "Flow" and "Section" content types.
 *
 * @uses ddw_btc_get_integration_post_types()
 * @uses ddw_btc_string_template()
 *
 * @param array $columns Array which holds all Post Types list table columns labels.
 * @return array Tweaked $columns array.
 */
function ddw_btc_tweak_taxonomy_column_title( $columns ) {  
	
	/** Get current Admin screen object */
	$current_screen = get_current_screen();

	/** Get our specific, relevant post types from the integrations as an array */
	$post_types = (array) ddw_btc_get_integration_post_types();

	/**
	 * Check current Admin post type with our array and set taxonomy label
	 *   string if proper match.
	 */
	if ( in_array( $current_screen->post_type, $post_types[ 'popups' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'popup' );
	}

	if ( in_array( $current_screen->post_type, $post_types[ 'listings' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'listing' );
	}

	if ( in_array( $current_screen->post_type, $post_types[ 'blocks' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'block' );
	}

	if ( in_array( $current_screen->post_type, $post_types[ 'libraries' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'library' );
	}

	if ( in_array( $current_screen->post_type, $post_types[ 'elements' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'element' );
	}

	if ( in_array( $current_screen->post_type, $post_types[ 'layouts' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'layout' );
	}

	if ( in_array( $current_screen->post_type, $post_types[ 'lightboxes' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'lightbox' );
	}

	if ( in_array( $current_screen->post_type, $post_types[ 'post-types' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'post-type' );
	}

	if ( in_array( $current_screen->post_type, $post_types[ 'fields' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'field' );
	}

	if ( in_array( $current_screen->post_type, $post_types[ 'boxes' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'box' );
	}

	if ( in_array( $current_screen->post_type, $post_types[ 'bars' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'bar' );
	}

	if ( in_array( $current_screen->post_type, $post_types[ 'hooks' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'hook' );
	}

	if ( in_array( $current_screen->post_type, $post_types[ 'filters' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'filter' );
	}

	if ( in_array( $current_screen->post_type, $post_types[ 'sections' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'section' );
	}

	if ( in_array( $current_screen->post_type, $post_types[ 'flows' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'flow' );
	}

	if ( in_array( $current_screen->post_type, $post_types[ 'snippets' ] ) ) {
		$columns[ 'taxonomy-builder-template-category' ] = ddw_btc_string_template( 'snippet' );
	}

	/** Return array of column label strings */
	return $columns;

}  // end function


add_filter( 'btc/filter/string/default_content_type', 'ddw_btc_tweak_taxonomy_labels' );
/**
 * For certain post types of our integrations tweak the taxonomy labels, based
 *   on content type of the integration.
 *   Example: "Popup" integrations then switch to "Popup Categories" strings
 *            (instead of "Template Categories").
 *
 * @since 1.1.0
 * @since 1.2.0 Added checks for "Field", "Box", "Bar" and "Hook" content types.
 * @since 1.3.0 Added checks for "Filter" content type.
 * @since 1.4.1 Added checks for "Section" content type.
 * @since 1.4.3 Added checks for "Flow" and "Section" content types.
 *
 * @uses ddw_btc_get_integration_post_types()
 * @uses ddw_btc_string_content_type()
 *
 * @return string Taxonomy label string based on content type of the integration
 *                (post type).
 */
function ddw_btc_tweak_taxonomy_labels() {

	/** Bail early if not in Admin context */
	if ( ! is_admin() ) {
		return;
	}

	/** Get our specific, relevant post types from the integrations as an array */
	$post_types = (array) ddw_btc_get_integration_post_types();

	/**
	 * Check current Admin post type with our array and return label string if
	 *   proper match.
	 */
	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'popups' ] ) ) {
		return ddw_btc_string_content_type( 'popup' );
	}

	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'layouts' ] ) ) {
		return ddw_btc_string_content_type( 'layout' );
	}

	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'libraries' ] ) ) {
		return ddw_btc_string_content_type( 'library' );
	}

	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'listings' ] ) ) {
		return ddw_btc_string_content_type( 'listing' );
	}

	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'blocks' ] ) ) {
		return ddw_btc_string_content_type( 'block' );
	}

	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'elements' ] ) ) {
		return ddw_btc_string_content_type( 'element' );
	}

	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'lightboxes' ] ) ) {
		return ddw_btc_string_content_type( 'lightbox' );
	}

	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'post-types' ] ) ) {
		return ddw_btc_string_content_type( 'post-type' );
	}

	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'fields' ] ) ) {
		return ddw_btc_string_content_type( 'field' );
	}

	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'boxes' ] ) ) {
		return ddw_btc_string_content_type( 'box' );
	}

	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'bars' ] ) ) {
		return ddw_btc_string_content_type( 'bar' );
	}

	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'hooks' ] ) ) {
		return ddw_btc_string_content_type( 'hook' );
	}

	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'filters' ] ) ) {
		return ddw_btc_string_content_type( 'filter' );
	}

	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'sections' ] ) ) {
		return ddw_btc_string_content_type( 'section' );
	}

	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'flows' ] ) ) {
		return ddw_btc_string_content_type( 'flow' );
	}

	if ( in_array( ddw_btc_admin_get_current_post_type(), $post_types[ 'snippets' ] ) ) {
		return ddw_btc_string_content_type( 'snippet' );
	}

	/** If no match, return the default string ("Template") */
	return ddw_btc_string_content_type( 'btcdefault' );

}  // end function


/**
 * Execute the action fired in hook 'manage_{$post_type}_posts_custom_column',
 *   triggered via our helper function ddw_btc_prepare_tax_column_add().
 *
 * Optionally add our taxonomy as column data in the post list table. This is
 *   necessary for those post types where the WordPress default taxonomy
 *   registering doesn't add the column by default. The label setup happens on
 *   the integration level, though, as this is dependent on the template content
 *   type.
 *
 * @since 1.4.0
 *
 * @see ddw_btc_prepare_tax_column_add() in functions-global.php
 *
 * @param string $column_name
 * @param int $post_id ID of the current post in the table.
 * @return null
 */
function ddw_btc_maybe_add_tax_column_data_cpt( $column_name, $post_id ) {

	$taxonomy  = 'builder-template-category';
	$post_type = sanitize_key( get_query_var( 'post_type' ) );

	if ( $column_name == $taxonomy ) {

		$terms = get_the_terms( $post_id, $taxonomy );

		if ( ! empty( $terms ) ) {

			$output = array();

			foreach ( $terms as $term ) {
				$output[] = '<a href="' . esc_url( admin_url( 'edit.php?' . $taxonomy . '='.  $term->slug . '&post_type=' . $post_type ) ) . '">' . $term->name . '</a>';
			}

			echo join( ', ', $output );

		} else {

			echo '&mdash;';

		}  // end if
	
	}  // end if

}  // end function


add_filter( 'parent_file', 'ddw_btc_parent_submenu_tweaks', 5 );
/**
 * When viewing our taxonomy within the Admin, properly highlight it as the
 *   'submenu', and the integrations menu hook as the 'parent file'. This
 *   creates the wanted behavior for a lot of integrations where it is not
 *   happening by default.
 *
 * @since 1.4.0
 *
 * @uses ddw_btc_get_integrations()
 * @uses get_current_screen()
 *
 * @global string $GLOBALS[ 'submenu_file' ]
 *
 * @param string $parent_file The filename of the parent menu.
 * @return string $parent_file The tweaked filename of the parent menu.
 */
function ddw_btc_parent_submenu_tweaks( $parent_file ) {

	/** Get array with all active integrations */
	$integrations = ddw_btc_get_integrations();

	foreach ( $integrations as $integration => $integration_data ) {

		if ( 'edit-builder-template-category' === get_current_screen()->id && $integration_data[ 'post_type' ] === get_current_screen()->post_type ) {

			$GLOBALS[ 'submenu_file' ] = 'edit-tags.php?taxonomy=builder-template-category&post_type=' . $integration_data[ 'post_type' ];
			$parent_file = $integration_data[ 'submenu_hook' ];

		}  // end if

	}  // end foreach

	return $parent_file;

}  // end function
