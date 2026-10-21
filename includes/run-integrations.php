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


add_action( 'init', 'ddw_btc_integrations_add_taxonomy', 100 );
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

 * @return void
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

 * @return void
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
 * @param array $actions Holds all current bulk actions for a post type.
 * @return array Tweaked array of all bulk actions for a post type.
 */
function ddw_btc_bulk_actions_edit_title( $actions ) {

	if ( ! isset( $actions['edit'] ) || ! current_user_can( ddw_btc_capability_submenu() ) ) {
		return $actions;
	}
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

 * @return void
 */
function ddw_btc_filter_post_type_by_taxonomy() {
	if ( ! current_user_can( ddw_btc_capability_submenu() ) ) {
		return;
	}


	$integrations = ddw_btc_get_integrations();

	foreach ( $integrations as $integration ) {

		$post_type = sanitize_key( $integration[ 'post_type' ] );
		$taxonomy  = 'builder-template-category';

		if ( $post_type === ( $GLOBALS['typenow'] ?? '' ) ) {

			$selected      = isset( $_GET[ $taxonomy ] ) && is_scalar( $_GET[ $taxonomy ] ) ? absint( wp_unslash( $_GET[ $taxonomy ] ) ) : 0;
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


add_action( 'parse_query', 'ddw_btc_convert_id_to_term_in_query' );
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

 * @param WP_Query $query Query being parsed.
 * @return void
 */
function ddw_btc_convert_id_to_term_in_query( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() || 'edit.php' !== ( $GLOBALS['pagenow'] ?? '' ) ) {
		return;
	}
	$taxonomy = 'builder-template-category';
	$post_type = $query->get( 'post_type' );
	$value = $query->get( $taxonomy );
	if ( ! is_string( $post_type ) || ! ddw_btc_get_content_type_for_post_type( $post_type ) || ! is_scalar( $value ) || ! ctype_digit( (string) $value ) || 0 === (int) $value ) {
		return;
	}
	$term = get_term( (int) $value, $taxonomy );
	if ( ! $term || is_wp_error( $term ) ) {
		$query->set( 'post__in', array( 0 ) );
		$query->set( $taxonomy, '' );
		return;
	}
	$query->set( $taxonomy, $term->slug );
}


add_filter( 'manage_posts_columns', 'ddw_btc_tweak_taxonomy_column_title' );
add_action( 'current_screen', 'ddw_btc_register_list_table_column' );
/**
 * Restore the taxonomy column after builders customize their list tables.
 *
 * @since 1.9.0
 * @param WP_Screen $screen Current admin screen.
 * @return void
 */
function ddw_btc_register_list_table_column( $screen ) {
	if ( 'edit' === $screen->base && ddw_btc_get_content_type_for_post_type( $screen->post_type ) ) {
		add_filter( 'manage_' . $screen->post_type . '_posts_columns', 'ddw_btc_tweak_taxonomy_column_title', 100 );
	}
}
/**
 * Use the active integration content type for the taxonomy column.

 * @since 1.9.0
 * @param array $columns Existing list-table columns.
 * @return array Column titles.
 */
function ddw_btc_tweak_taxonomy_column_title( $columns ) {
	if ( ! current_user_can( ddw_btc_capability_submenu() ) ) {
		unset( $columns['taxonomy-builder-template-category'], $columns['builder-template-category'] );
		return $columns;
	}
	$screen = get_current_screen();
	$type = $screen ? ddw_btc_get_content_type_for_post_type( $screen->post_type ) : null;
	if ( $type ) {
		$key = 'taxonomy-builder-template-category';
		$label = ddw_btc_string_template( $type );
		if ( isset( $columns[$key] ) ) {
			$columns[$key] = $label;
		} else {
			// Keep the builder's columns and place ours immediately before Date.
			$updated = array();
			foreach ( $columns as $name => $title ) {
				if ( 'date' === $name ) {
					$updated[$key] = $label;
				}
				$updated[$name] = $title;
			}
			if ( ! isset( $updated[$key] ) ) {
				$updated[$key] = $label;
			}
			$columns = $updated;
		}
	}
	return $columns;
}


add_filter( 'btc/filter/string/default_content_type', 'ddw_btc_tweak_taxonomy_labels' );
/**
 * Resolve the admin content type and preserve the translated REST fallback.

 * @since 1.9.0
 * @param string $default_content_type Translated fallback label.
 * @return string Translated content-type label.
 */
function ddw_btc_tweak_taxonomy_labels( $default_content_type ) {
	if ( ! is_admin() ) {
		return $default_content_type;
	}
	$type = ddw_btc_get_content_type_for_post_type( ddw_btc_admin_get_current_post_type() );
	return $type ? ddw_btc_string_content_type( $type ) : $default_content_type;
}


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
	$post_type = sanitize_key( get_post_type( $post_id ) );

	if ( $column_name === $taxonomy && current_user_can( ddw_btc_capability_submenu() ) ) {

		$terms = get_the_terms( $post_id, $taxonomy );

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {

			$output = array();

			foreach ( $terms as $term ) {
				$output[] = '<a href="' . esc_url( admin_url( 'edit.php?' . $taxonomy . '='.  $term->slug . '&post_type=' . $post_type ) ) . '">' . esc_html( $term->name ) . '</a>';
			}

			echo wp_kses_post( join( ', ', $output ) );

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

		if ( get_current_screen() && 'edit-builder-template-category' === get_current_screen()->id && $integration_data[ 'post_type' ] === get_current_screen()->post_type ) {

			$GLOBALS[ 'submenu_file' ] = 'edit-tags.php?taxonomy=builder-template-category&post_type=' . $integration_data[ 'post_type' ];
			$parent_file = $integration_data[ 'submenu_hook' ];

		}  // end if

	}  // end foreach

	return $parent_file;

}  // end function


add_action( 'registered_post_type', 'ddw_btc_attach_late_post_type', 10, 1 );
/**
 * Attach categories when a supported post type is registered after init 20.
 * @since 1.9.0
 * @param string $post_type Newly registered post-type key.
 * @return void
 */
function ddw_btc_attach_late_post_type( $post_type ) {
	if ( taxonomy_exists( 'builder-template-category' ) && ddw_btc_get_content_type_for_post_type( $post_type ) ) {
		register_taxonomy_for_object_type( 'builder-template-category', $post_type );
	}
}
