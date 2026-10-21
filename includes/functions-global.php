<?php

// includes/functions-global

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Get the - filtered - capability for showing the submenus.
 *
 * @since 1.0.0
 *
 * @return string Key for the submenu capability.
 */
function ddw_btc_capability_submenu() {

	return sanitize_key(
		(string) apply_filters(
			'btc/filter/capability/submenu',
			'edit_theme_options'
		)
	);

}  // end function


/**
 * Return array of registered integrations and their arguments.
 *
 * Plugins and themes can hook into the 'btc/filter/integrations/all' filter to
 *   register their own integration.
 *
 * @since 1.0.0
 *
 * @return array Filterable array of registered integrations.
 */
function ddw_btc_get_integrations() {
	$integrations = (array) apply_filters( 'btc/filter/integrations/all', array(), array() );
	$valid = array();
	foreach ( $integrations as $id => $integration ) {
		if ( ! is_array( $integration ) || ! isset( $integration['post_type'], $integration['template_label'], $integration['label'], $integration['submenu_hook'], $integration['admin_url'] ) ) {
			continue;
		}
		if ( ! is_string( $id ) ) {
			continue;
		}
		foreach ( array( 'post_type', 'template_label', 'label', 'submenu_hook', 'admin_url' ) as $key ) {
			if ( ! is_string( $integration[$key] ) ) {
				continue 2;
			}
		}
		$integration['post_type'] = sanitize_key( $integration['post_type'] );
		$integration['template_label'] = sanitize_key( $integration['template_label'] );
		if ( ! post_type_exists( $integration['post_type'] ) ) {
			continue;
		}
		$key = sanitize_key( $id );
		if ( '' !== $key && '' !== $integration['post_type'] && '' !== $integration['template_label'] ) {
			$valid[$key] = $integration;
		}
	}
	return $valid;
}


/**
 * Admin URL for the taxonomy (overview table).
 *
 * @since 1.0.0
 *
 * @return string Admin URL for the taxonomy (taxonomy table).
 */
function ddw_btc_taxonomy_admin_url() {

	return 'edit-tags.php?taxonomy=builder-template-category';

}  // end function


/**
 * Collect supported post types, optionally grouped by content type.

 * @since 1.9.0
 * @param string $all_types Use all to return a flat list.
 * @return array Post-type keys or groups.
 */
function ddw_btc_get_integration_post_types( $all_types = '' ) {
	$groups = array( 'templates' => array(), 'patterns' => array(), 'elements' => array(), 'layouts' => array(), 'libraries' => array() );
	$keys = array( 'template' => 'templates', 'pattern' => 'patterns', 'element' => 'elements', 'layout' => 'layouts', 'library' => 'libraries' );
	$all = array();
	foreach ( ddw_btc_get_integrations() as $integration ) {
		$type = $integration['template_label'];
		$groups[$keys[$type] ?? $type][] = $integration['post_type'];
		$all[] = $integration['post_type'];
	}
	if ( 'all' === $all_types ) {
		return array_values( array_unique( $all ) );
	}
	return apply_filters( 'btc/filter/integrations/post_types', $groups );
}

/** Return the content type declared by an active integration.
 * @since 1.9.0
 * @param string $post_type Post-type key.
 * @return string|null Content-type key, or null if unsupported.
 */
function ddw_btc_get_content_type_for_post_type( $post_type ) {
	foreach ( ddw_btc_get_integrations() as $integration ) {
		if ( $post_type === $integration['post_type'] ) {
			return $integration['template_label'];
		}
	}
	return null;
}


/**
 * Get only those post types from our registered, active integrations which
 *   stated explicit 'block_editor' support in the registering array.
 *   This is needed for registering our taxonomy so that the taxonomy meta box
 *   is appearing for those post types in the Block Editor (Gutenberg).
 *
 * @since 1.3.0
 *
 * @uses ddw_btc_get_integrations()
 *
 * @param string $keys_only Flag string to optionally output only a single
 *                           array with all post type keys.
 * @return array Filterable array with the full sub arrays for each integration.
 */
function ddw_btc_get_post_types_for_block_editor( $keys_only = '' ) {

	/** Get array with all active integrations */
	$integrations = ddw_btc_get_integrations();

	/** Setup arrays */
	$post_types_block_editor = array();
	$post_type_keys          = array();

	/** Iterate through all integrations and collect the post types */
	foreach ( $integrations as $integration => $integration_data ) {

		if ( isset( $integration_data[ 'block_editor' ] )
			&& 'register_early' === $integration_data[ 'block_editor' ]
		) {

			$post_types_block_editor[ $integration ] = $integration_data;

			$post_type_keys[] = $integration_data[ 'post_type' ];
		}

	}  // end foreach

	/**
	 * If $keys_only param is set to 'keys_only' return all post types keys
	 *   in a single array.
	 */
	if ( 'keys_only' === sanitize_key( $keys_only ) ) {
		return $post_type_keys;
	}

	/** Return filterable array of collected post types */
	return apply_filters(
		'btc/filter/integrations/post_types/block_editor',
		$post_types_block_editor
	);

}  // end function


/**
 * Within WP-Admin get the current post type of the current admin screen. We
 *   need that for the label tweaking - see ddw_btc_tweak_taxonomy_labels() in
 *   file includes/run-integrations.php.
 *
 *   Inspired by @link https://gist.github.com/DomenicF/3ebcf7d53ce3182854716c4d8f1ab2e2
 *
 * @since 1.1.0
 *
 * @return string|null String of post type or null if no post type available.
 */
function ddw_btc_admin_get_current_post_type() {
	if ( function_exists( 'get_current_screen' ) ) {
		$screen = get_current_screen();
		if ( $screen && $screen->post_type ) {
			return $screen->post_type;
		}
	}
	if ( isset( $_GET['post'] ) && is_scalar( $_GET['post'] ) ) {
		$type = get_post_type( absint( wp_unslash( $_GET['post'] ) ) );
		return $type ?: null;
	}
	if ( isset( $_GET['post_type'] ) && is_string( $_GET['post_type'] ) ) {
		return sanitize_key( wp_unslash( $_GET['post_type'] ) );
	}
	return null;
}


/**
 * Helper function to fire the 'manage_{$post_type}_posts_custom_column' action
 *   hook for specific post types and at custom priorities if needed.
 *
 * @since 1.4.0
 *
 * @param string  $post_type Given post type to run the action for.
 * @param integer $priority Given priority to run the action at.

 * @return void
 */
function ddw_btc_prepare_tax_column_add( $post_type = '', $priority = 10 ) {

	$post_type = sanitize_key( $post_type );

	add_action(
		'manage_' . $post_type . '_posts_custom_column',
		'ddw_btc_maybe_add_tax_column_data_cpt',
		(int) $priority,
		2
	);

}  // end function


/**
 * Setting internal plugin helper values.
 *
 * @since 1.0.0
 *
 * @return array $btc_info Array of info values.
 */
function ddw_btc_info_values() {

	$btc_info = array(

		'url_snippets'      => 'https://github.com/deckerweb/builder-template-categories/wiki/Code-Snippets',
		'author'            => __( 'David Decker - DECKERWEB', 'builder-template-categories' ),
		'author_uri'        => 'https://github.com/deckerweb',
		'license'           => 'GPL-2.0-or-later',
		'url_license'       => 'https://opensource.org/licenses/GPL-2.0',
		'first_code'        => '2018',

		'url_newsletter'    => 'https://eepurl.com/gbAUUn',
		'url_donate'        => 'https://www.paypal.me/deckerweb',

		'url_plugin'        => 'https://github.com/deckerweb/builder-template-categories',
		'url_plugin_docs'   => 'https://github.com/deckerweb/builder-template-categories/blob/master/docs/guide.md',
		'url_plugin_faq'    => 'https://github.com/deckerweb/builder-template-categories/blob/master/README.md#faq',
		'url_github'        => 'https://github.com/deckerweb/builder-template-categories',
		'url_github_issues' => 'https://github.com/deckerweb/builder-template-categories/issues',
		'url_twitter'       => 'https://twitter.com/deckerweb',
		'url_github_follow' => 'https://github.com/deckerweb',
		'video_bulk_add'    => 'https://www.youtube.com/watch?v=KyCY-cGAB9o',
		'video_bulk_add_tb' => '//www.youtube-nocookie.com/embed/KyCY-cGAB9o?rel=0&TB_iframe=true&width=1024&height=576',	// for Thickbox, embed version, no cookies!

	);  // end of array

	return $btc_info;

}  // end function


/**
 * Get URL of specific BTC info value.
 *
 * @since 1.0.0
 *
 * @uses ddw_btc_info_values()
 *
 * @param string $url_key String of value key from array of ddw_btc_info_values()
 * @param bool   $raw     If raw escaping or regular escaping of URL gets used
 * @return string URL for info value.
 */
function ddw_btc_get_info_url( $url_key = '', $raw = FALSE ) {
	$info = ddw_btc_info_values();
	$value = $info[ sanitize_key( $url_key ) ] ?? '';
	return $raw ? esc_url_raw( $value ) : esc_url( $value );
}


/**
 * Get link with complete markup for a specific BTC info value.
 *
 * @since 1.0.0
 *
 * @uses ddw_btc_get_info_url()
 *
 * @param string $url_key String of value key
 * @param string $text    String of text and link attribute
 * @param string $class   String of CSS class
 * @return string HTML markup for linked URL.
 */
function ddw_btc_get_info_link( $url_key = '', $text = '', $class = '' ) {

	$link = sprintf(
		'<a class="%1$s" href="%2$s" target="_blank" rel="nofollow noopener noreferrer" title="%3$s">%3$s</a>',
		strtolower( esc_attr( $class ) ),	//sanitize_html_class( $class ),
		ddw_btc_get_info_url( $url_key ),
		esc_html( $text )
	);

	return $link;

}  // end function


/**
 * Get timespan of coding years for this plugin.
 *
 * @since 1.0.0
 * @since 1.1.0 Improved first year logic.
 *
 * @uses ddw_btc_info_values()
 *
 * @param int $first_year Integer number of first year
 * @return string Timespan of years.
 */
function ddw_btc_coding_years( $first_year = '' ) {

	$btc_info = (array) ddw_btc_info_values();

	$first_year = ( empty( $first_year ) ) ? absint( $btc_info[ 'first_code' ] ) : absint( $first_year );

	/** Set year of first released code */
	$code_first_year = ( gmdate( 'Y' ) == $first_year || 0 === $first_year ) ? '' : $first_year . '&#x02013;';

	return $code_first_year . gmdate( 'Y' );

}  // end function
