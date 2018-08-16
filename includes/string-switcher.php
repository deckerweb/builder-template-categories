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
 * Build string "Categories".
 *
 * @since  1.0.0
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
 * @since  1.0.0
 *
 * @param  string $string_type Type of the template string.
 * @return string Full, filterable, string output "{Template String Type} Categories".
 */
function ddw_btc_string_template( $string_type ) {

	/** Check type for the possible types and set strings */
	switch ( sanitize_key( $string_type ) ) {

		case 'template':
			$string = sprintf(
				esc_attr__( 'Template %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'library':
			$string = sprintf(
				esc_attr__( 'Library %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'layout':
			$string = sprintf(
				esc_attr__( 'Layout %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'element':
			$string = sprintf(
				esc_attr__( 'Element %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'block':
			$string = sprintf(
				esc_attr__( 'Block %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'popup':
			$string = sprintf(
				esc_attr__( 'Popup %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'lightbox':
			$string = sprintf(
				esc_attr__( 'Lightbox %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'listing':
			$string = sprintf(
				esc_attr__( 'Listing %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		case 'elhf-template':
			$string = sprintf(
				esc_attr__( 'EL HF %s', 'builder-template-categories' ),
				ddw_btc_string_categories()
			);
			break;

		default:
			$string = sprintf(
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
 *
 * @since  1.0.0
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
 *
 * @since  1.0.0
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