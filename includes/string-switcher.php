<?php

// includes/string-switcher

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * String for the default content type, filterable.
 *   Default: "Template"
 *
 * @since 1.1.0
 *
 * @see ddw_btc_register_templates_taxonomy()
 *
 * @return string Filtered string output "Template".
 */
function ddw_btc_string_default_content_type() {

	return esc_attr(
		apply_filters(
			'btc/filter/string/default_content_type',
			__( 'Template', 'builder-template-categories' )
		)
	);

}  // end function


/**
 * Build content type string (for example "Popup" or "Block").
 *   Note: This function is especially needed for our
 *         'btc/filter/string/default_content_type' filter.
 *
 * @since 1.1.0
 * @since 1.2.0 Added "Field", "Box", "Bar" and "Hook" content types.
 * @since 1.3.0 Added "Filter" content type.
 * @since 1.4.1 Added "Section" content type.
 * @since 1.4.3 Added "Flow" and "Section" content types.
 *
 * @param string $content_type Type of content string stands for.
 * @return string String output based on content type.
 */
function ddw_btc_string_content_type( $content_type ) {

	/** Check type for the possible types and set strings */
	switch ( sanitize_key( $content_type ) ) {

		case 'library':
			$string = esc_attr__( 'Library', 'builder-template-categories' );
			break;

		case 'layout':
			$string = esc_attr__( 'Layout', 'builder-template-categories' );
			break;

		case 'element':
			$string = esc_attr__( 'Element', 'builder-template-categories' );
			break;

		case 'block':
			$string = esc_attr__( 'Block', 'builder-template-categories' );
			break;

		case 'popup':
			$string = esc_attr__( 'Popup', 'builder-template-categories' );
			break;

		case 'lightbox':
			$string = esc_attr__( 'Lightbox', 'builder-template-categories' );
			break;

		case 'listing':
			$string = esc_attr__( 'Listing', 'builder-template-categories' );
			break;

		case 'post-type':
			$string = esc_attr__( 'Post Type', 'builder-template-categories' );
			break;

		case 'field':
			$string = esc_attr__( 'Field', 'builder-template-categories' );
			break;

		case 'box':
			$string = esc_attr__( 'Box', 'builder-template-categories' );
			break;

		case 'bar':
			$string = esc_attr__( 'Bar', 'builder-template-categories' );
			break;

		case 'hook':
			$string = esc_attr__( 'Hook', 'builder-template-categories' );
			break;

		case 'filter':
			$string = esc_attr__( 'Filter', 'builder-template-categories' );
			break;

		case 'section':
			$string = esc_attr__( 'Sections', 'builder-template-categories' );
			break;

		case 'flow':
			$string = esc_attr__( 'Flows', 'builder-template-categories' );
			break;

		case 'snippet':
			$string = esc_attr__( 'Snippets', 'builder-template-categories' );
			break;

		default:
			$string = esc_attr__( 'Template', 'builder-template-categories' );

	}  // end switch

	/** Finally, output the string */
	return $string;

}  // end function


/**
 * Build string "Categories".
 *
 * @since 1.0.0
 *
 * @return string Filtered string output "Categories".
 */
function ddw_btc_string_categories() {

	return esc_attr(
		apply_filters(
			'btc/filter/string/categories',
			__( 'Categories', 'builder-template-categories' )
		)
	);

}  // end function


/**
 * Build string "{Template String Type} Categories".
 *
 * @since 1.0.0
 * @since 1.1.0 Added "Post Type" content type.
 * @since 1.2.0 Added "Field", "Box", "Bar" and "Hook" content types.
 * @since 1.3.0 Added "Filter" content type.
 * @since 1.4.1 Added "Section" content type.
 * @since 1.4.3 Added "Flow" and "Section" content types.
 *
 * @uses ddw_btc_string_categories()
 *
 * @param string $string_type Type of the template string.
 * @return string Full, filterable, string output "{Template String Type} Categories".
 */
function ddw_btc_string_template( $string_type ) {

	/** Check type for the possible types and set strings */
	switch ( sanitize_key( $string_type ) ) {

		case 'template':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Template Categories) */
				esc_attr__( 'Template %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'library':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Library Categories) */
				esc_attr__( 'Library %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'layout':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Layout Categories) */
				esc_attr__( 'Layout %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'element':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Element Categories) */
				esc_attr__( 'Element %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'block':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Block Categories) */
				esc_attr__( 'Block %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'popup':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Popup Categories) */
				esc_attr__( 'Popup %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'lightbox':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Lightbox Categories) */
				esc_attr__( 'Lightbox %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'listing':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Listing Categories) */
				esc_attr__( 'Listing %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'elhf-template':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: ELHF Categories - "EL HF" stands for Elementor Header Footer Builder plugin) */
				esc_attr__( 'EL HF %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'post-type':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Post Type Categories) */
				esc_attr__( 'Post Type %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'field':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Field Categories) */
				esc_attr__( 'Field %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'box':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Box Categories) */
				esc_attr__( 'Box %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'bar':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Bar Categories) */
				esc_attr__( 'Bar %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'hook':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Hook Categories) */
				esc_attr__( 'Hook %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'filter':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Filter Categories) */
				esc_attr__( 'Filter %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'section':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Section Categories) */
				esc_attr__( 'Section %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'flow':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Flow Categories) */
				esc_attr__( 'Flow %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'snippet':
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Snippet Categories) */
				esc_attr__( 'Snippet %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		default:
			$string = sprintf(
				/* translators: %s - label "Categories" (for example: Template Categories) */
				esc_attr__( 'Template %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);

	}  // end switch

	/** Finally, output the complete template string, filterable */
	return apply_filters(
		'btc/filter/strings/template',
		$string,
		$string_type
	);

}  // end function


/**
 * Build string " (for WooCommerce)".
 *   Note: Space before the brackets is intended :).
 *
 * @since 1.0.0
 *
 * @return string Filtered string output " (for WooCommerce)".
 */
function ddw_btc_string_for_woocommerce() {

	return esc_attr(
		apply_filters(
			'btc/filter/string/for_woocommerce',
			sprintf(
				' (%s)',
				__( 'for WooCommerce', 'builder-template-categories' )
			)
		)
	);

}  // end function


/**
 * Build string " (for Post Types, Taxonomies, Fields)".
 *   Note: Space before the brackets is intended :).
 *
 * @since 1.0.0
 *
 * @return string Filtered string output " (for Post Types, Taxonomies, Fields)".
 */
function ddw_btc_string_for_cpt_fields() {

	return esc_attr(
		apply_filters(
			'btc/filter/string/for_cpt_fields',
			sprintf(
				' (%s)',
				__( 'for Post Types, Taxonomies, Fields', 'builder-template-categories' )
			)
		)
	);

}  // end function


/**
 * Build string "Add New".
 *
 * @since 1.3.0
 *
 * @return string Translateable string "Add New".
 */
function ddw_btc_string_add_new() {

	return esc_html__( 'Add New', 'builder-template-categories' );

}  // end function
