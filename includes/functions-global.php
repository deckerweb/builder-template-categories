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
		apply_filters(
			'btc/filter/capability/submenu',
			'edit_theme_options'
		)
	);

}  // end function


/**
 * Return array of registered integrations and their arguments.
 *
 * Plugins and themes can hook into the 'btc_filter_get_integrations' filter to
 *   register their own integration.
 *
 * @since 1.0.0
 *
 * @return array Filterable array of registered integrations.
 */
function ddw_btc_get_integrations() {

	/** Set integrations array */
	$integrations = array(
		'default-none' => array(
			'label'          => esc_attr__( 'No Integration registered', 'builder-template-categories' ),
			'submenu_hook'   => null,
			'post_type'      => 'btc-custom-post-type',
			'template_label' => 'template',
			'admin_url'      => null,
		),
	);

	/** Allow the array to be filtered (= adding more integrations) */
	$integrations = (array) apply_filters(
		'btc/filter/integrations/all',
		$integrations,
		array()
	);

	/** Escape the values of the array */
	foreach ( $integrations as $integration => $integration_data ) {

		$integration                          = sanitize_key( $integration );
		$integration_data[ 'label' ]          = esc_attr( $integration_data[ 'label' ] );
		$integration_data[ 'submenu_hook' ]   = esc_url( $integration_data[ 'submenu_hook' ] );
		$integration_data[ 'post_type' ]      = sanitize_key( $integration_data[ 'post_type' ] );
		$integration_data[ 'template_label' ] = sanitize_key( $integration_data[ 'template_label' ] );
		$integration_data[ 'admin_url' ]      = esc_url( $integration_data[ 'admin_url' ] );

	}  // end foreach

	/** Return registered integrations */
	return (array) $integrations;

}  // end function


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
 * Get specific post types from integrations for re-usage, summarized after
 *   label types (content types).
 *
 * @since 1.1.0
 * @since 1.2.0 Added "Field", "Box", "Bar" and "Hook" content types.
 * @since 1.3.0 Added "Filter" content type.
 * @since 1.4.1 Added "Section" content type.
 * @since 1.4.3 Added "Flow" and "Section" content types.
 *
 * @uses ddw_btc_get_integrations()
 *
 * @param string $all_types Optional string param used as a flag, to enable
 *                          alternative return of all post types in one single
 *                          array (not summarized!).
 * @return array Filterable array of post type keys, summarized after content
 *               type.
 */
function ddw_btc_get_integration_post_types( $all_types = '' ) {

	/** Get array with all active integrations */
	$integrations = ddw_btc_get_integrations();

	/** Setup array of certain post types as content types (array keys) */
	$post_types = array(
		'templates'  => array(),
		'popups'     => array(),
		'layouts'    => array(),
		'listings'   => array(),
		'libraries'  => array(),
		'elements'   => array(),
		'blocks'     => array(),
		'lightboxes' => array(),
		'post-types' => array(),
		'fields'     => array(),
		'boxes'      => array(),
		'bars'       => array(),
		'hooks'      => array(),
		'filters'    => array(),
		'sections'   => array(),
		'flows'      => array(),
		'snippets'   => array(),
		'btcdefault' => array( 'btc-template' ),
	);

	$post_types_all = array();

	/**
	 * Iterate through all integrations and collect the post types for the
	 *   defined content types
	 */
	foreach ( $integrations as $integration ) {

		if ( 'template' === $integration[ 'template_label' ] ) {
			$post_types[ 'templates' ][] = $integration[ 'post_type' ];
		}

		if ( 'popup' === $integration[ 'template_label' ] ) {
			$post_types[ 'popups' ][] = $integration[ 'post_type' ];
		}

		if ( 'layout' === $integration[ 'template_label' ] ) {
			$post_types[ 'layouts' ][] = $integration[ 'post_type' ];
		}

		if ( 'listing' === $integration[ 'template_label' ] ) {
			$post_types[ 'listings' ][] = $integration[ 'post_type' ];
		}

		if ( 'library' === $integration[ 'template_label' ] ) {
			$post_types[ 'libraries' ][] = $integration[ 'post_type' ];
		}

		if ( 'element' === $integration[ 'template_label' ] ) {
			$post_types[ 'elements' ][] = $integration[ 'post_type' ];
		}

		if ( 'block' === $integration[ 'template_label' ] ) {
			$post_types[ 'blocks' ][] = $integration[ 'post_type' ];
		}

		if ( 'lightbox' === $integration[ 'template_label' ] ) {
			$post_types[ 'lightboxes' ][] = $integration[ 'post_type' ];
		}

		if ( 'post-type' === $integration[ 'template_label' ] ) {
			$post_types[ 'post-types' ][] = $integration[ 'post_type' ];
		}

		if ( 'field' === $integration[ 'template_label' ] ) {
			$post_types[ 'fields' ][] = $integration[ 'post_type' ];
		}

		if ( 'box' === $integration[ 'template_label' ] ) {
			$post_types[ 'boxes' ][] = $integration[ 'post_type' ];
		}

		if ( 'bar' === $integration[ 'template_label' ] ) {
			$post_types[ 'bars' ][] = $integration[ 'post_type' ];
		}

		if ( 'hook' === $integration[ 'template_label' ] ) {
			$post_types[ 'hooks' ][] = $integration[ 'post_type' ];
		}

		if ( 'filter' === $integration[ 'template_label' ] ) {
			$post_types[ 'filters' ][] = $integration[ 'post_type' ];
		}

		if ( 'section' === $integration[ 'template_label' ] ) {
			$post_types[ 'sections' ][] = $integration[ 'post_type' ];
		}

		if ( 'flow' === $integration[ 'template_label' ] ) {
			$post_types[ 'flows' ][] = $integration[ 'post_type' ];
		}

		if ( 'snippet' === $integration[ 'template_label' ] ) {
			$post_types[ 'snippets' ][] = $integration[ 'post_type' ];
		}

		$post_types_all[] = $integration[ 'post_type' ];

	}  // end foreach

	/**
	 * If $all_keys param is set to 'all' return all post types,
	 *   non-summarized.
	 */
	if ( 'all' === sanitize_key( $all_types ) ) {
		return $post_types_all;
	}

	/**
	 * Return filterable array of collected post types - summarized after
	 *   content types.
	 */
	return apply_filters(
		'btc/filter/integrations/post_types',
		$post_types
	);

}  // end function


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

	/** Check $_GET for post ID/ post type */
	if ( isset( $_GET[ 'post' ] ) ) {

		return sanitize_key( get_post_type( wp_unslash( $_GET[ 'post' ] ) ) );

	} elseif ( isset( $_GET[ 'post_type' ] ) ) {

		return sanitize_key( wp_unslash( $_GET[ 'post_type' ] ) );

	}  // end if

	/** Fallback: We do not know the post type! */
	return null;

}  // end function


/**
 * Helper function to fire the 'manage_{$post_type}_posts_custom_column' action
 *   hook for specific post types and at custom priorities if needed.
 *
 * @since 1.4.0
 *
 * @param string  $post_type Given post type to run the action for.
 * @param integer $priority Given priority to run the action at.
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

	/** Get current user */
	$user = wp_get_current_user();

	/** Build Newsletter URL */
	$url_nl = sprintf(
		'https://deckerweb.us2.list-manage.com/subscribe?u=e09bef034abf80704e5ff9809&amp;id=380976af88&amp;MERGE0=%1$s&amp;MERGE1=%2$s',
		esc_attr( $user->user_email ),
		esc_attr( $user->user_firstname )
	);

	$btc_info = array(

		'url_translate'     => 'https://translate.wordpress.org/projects/wp-plugins/builder-template-categories',
		'url_wporg_faq'     => 'https://wordpress.org/plugins/builder-template-categories/#faq',
		'url_wporg_forum'   => 'https://wordpress.org/support/plugin/builder-template-categories',
		'url_wporg_review'  => 'https://wordpress.org/support/plugin/builder-template-categories/reviews/?filter=5/#new-post',
		'url_wporg_profile' => 'https://profiles.wordpress.org/daveshine/',
		'url_fb_group'      => 'https://www.facebook.com/groups/deckerweb.wordpress.plugins/',
		'url_snippets'      => 'https://github.com/deckerweb/builder-template-categories/wiki/Code-Snippets',
		'author'            => __( 'David Decker - DECKERWEB', 'builder-template-categories' ),
		'author_uri'        => 'https://deckerweb.de/',
		'license'           => 'GPL-2.0-or-later',
		'url_license'       => 'https://opensource.org/licenses/GPL-2.0',
		'first_code'        => '2018',

		'url_newsletter'    => $url_nl,
		'url_donate'        => 'https://www.paypal.me/deckerweb',

		'url_plugin'        => 'https://github.com/deckerweb/builder-template-categories',
		'url_plugin_docs'   => 'https://github.com/deckerweb/builder-template-categories/wiki',
		'url_plugin_faq'    => 'https://wordpress.org/plugins/builder-template-categories/#faq',
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

	$btc_info = (array) ddw_btc_info_values();

	$output = esc_url( $btc_info[ sanitize_key( $url_key ) ] );

	if ( TRUE === $raw ) {
		$output = esc_url_raw( $btc_info[ esc_attr( $url_key ) ] );
	}

	return $output;

}  // end function


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
	$code_first_year = ( date( 'Y' ) == $first_year || 0 === $first_year ) ? '' : $first_year . '&#x02013;';

	return $code_first_year . date( 'Y' );

}  // end function
