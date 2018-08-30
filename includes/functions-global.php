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
 * @since  1.0.0
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
 * @since  1.0.0
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
	$integrations = (array) apply_filters( 'btc/filter/integrations/all', $integrations );

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
 * @since  1.0.0
 *
 * @return string Admin URL for the taxonomy (taxonomy table).
 */
function ddw_btc_taxonomy_admin_url() {

	return 'edit-tags.php?taxonomy=builder-template-category';

}  // end function


/**
 * Setting internal plugin helper values.
 *
 * @since  1.0.0
 *
 * @return array $btc_info Array of info values.
 */
function ddw_btc_info_values() {

	$btc_info = array(

		'url_translate'     => 'https://translate.wordpress.org/projects/wp-plugins/builder-template-categories',
		'url_wporg_faq'     => 'https://wordpress.org/plugins/builder-template-categories/#faq',
		'url_wporg_forum'   => 'https://wordpress.org/support/plugin/builder-template-categories',
		'url_wporg_review'  => 'https://wordpress.org/support/plugin/builder-template-categories/reviews/?filter=5/#new-post',
		'url_wporg_profile' => 'https://profiles.wordpress.org/daveshine/',
		'url_fb_group'      => 'https://www.facebook.com/groups/ToolbarExtras/',
		'url_snippets'      => 'https://github.com/deckerweb/builder-template-categories/wiki/Code-Snippets',
		'author'            => __( 'David Decker - DECKERWEB', 'builder-template-categories' ),
		'author_uri'        => __( 'https://deckerweb.de/', 'builder-template-categories' ),
		'license'           => 'GPL-2.0+',
		'url_license'       => 'https://opensource.org/licenses/GPL-2.0',
		'first_code'        => '2018',
		'url_donate'        => 'https://www.paypal.me/deckerweb',
		'url_plugin'        => 'https://github.com/deckerweb/builder-template-categories',
		'url_plugin_docs'   => 'https://github.com/deckerweb/builder-template-categories/wiki',
		'url_plugin_faq'    => 'https://wordpress.org/plugins/builder-template-categories/#faq',
		'url_github'        => 'https://github.com/deckerweb/builder-template-categories',
		'url_github_issues' => 'https://github.com/deckerweb/builder-template-categories/issues',

	);  // end of array

	return $btc_info;

}  // end function


/**
 * Get URL of specific BTC info value.
 *
 * @since  1.0.0
 *
 * @uses   ddw_btc_info_values()
 *
 * @param  string $url_key String of value key from array of ddw_btc_info_values()
 * @param  bool   $raw     If raw escaping or regular escaping of URL gets used
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
 * @since  1.0.0
 *
 * @uses   ddw_btc_get_info_url()
 *
 * @param  string $url_key String of value key
 * @param  string $text    String of text and link attribute
 * @param  string $class   String of CSS class
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
 * @since  1.0.0
 *
 * @uses   ddw_btc_info_values()
 *
 * @param  int $first_year Integer number of first year
 * @return string Timespan of years.
 */
function ddw_btc_coding_years( $first_year = '' ) {

	$btc_info = (array) ddw_btc_info_values();

	$first_year = ( empty( $first_year ) ) ? absint( $btc_info[ 'first_code' ] ) : absint( $first_year );

	/** Set year of first released code */
	$code_first_year = ( '' !== $first_year && date( 'Y' ) !== $first_year ) ? $first_year . '&#x02013;' : '';

	return $code_first_year . date( 'Y' );

}  // end function