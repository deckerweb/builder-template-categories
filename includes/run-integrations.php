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
 * @uses  ddw_btc_get_integrations()
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
 *
 * @uses  ddw_btc_get_integrations()
 * @uses  ddw_btc_taxonomy_admin_url()
 * @uses  ddw_btc_string_template()
 * @uses  ddw_btc_capability_submenu()
 */
function ddw_btc_integrations_add_admin_submenus() {

	$integrations = ddw_btc_get_integrations();

	foreach ( $integrations as $integration ) {

		$btc_tax_url = ddw_btc_taxonomy_admin_url() . '&post_type=' . $integration[ 'post_type' ];

		add_submenu_page(
			$integration[ 'submenu_hook' ],
			ddw_btc_string_template( $integration[ 'template_label' ] ),
			ddw_btc_string_template( $integration[ 'template_label' ] ),
			ddw_btc_capability_submenu(),
			$btc_tax_url
		);

	}  // end foreach

}  // end function


add_action( 'restrict_manage_posts', 'ddw_btc_filter_post_type_by_taxonomy', 100 );
/**
 * Display a custom taxonomy dropdown for the post type overview table.
 *   This will only be added for supported integrations and their post types.
 *
 * The below code was used from/ inspired by:
 * @author Mike Hemberger
 * @link   http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 *
 * @since  1.0.0
 *
 * @uses   ddw_btc_get_integrations()
 * @uses   wp_dropdown_categories()
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
				esc_attr__( 'All %s', 'builder-template-categories' ),
				$info_taxonomy->label
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
 *  This will only be added for supported integrations and their post types.
 *
 * The below code was used from/ inspired by:
 * @author Mike Hemberger
 * @link   http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 *
 * @since  1.0.0
 *
 * @see    ddw_btc_filter_post_type_by_taxonomy()
 *
 * @uses   ddw_btc_get_integrations()
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