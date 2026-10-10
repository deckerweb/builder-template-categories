<?php

// includes/admin/admin-extras

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Add "Custom Taxonomy" link to Plugins page.
 *
 * @since 1.0.0
 * @since 1.6.0 Overall code improvements.
 *
 * @param array $action_links (Default) Array of plugin action links.
 * @return array Modified array of plugin action links.
 */
function ddw_btc_custom_taxonomy_links( $action_links = [] ) {

	$btc_links = array();

	/** Add settings link only if user has permission */
	if ( current_user_can( ddw_btc_capability_submenu() ) ) {

		/** Taxonomy Page link */
		$btc_links[ 'btc-taxonomy' ] = sprintf(
			'<a href="%s" title="%s"><span class="dashicons-before dashicons-category"></span> %s</a>',
			esc_url( admin_url( ddw_btc_taxonomy_admin_url() ) ),
			/* translators: Title attribute for Builder Template Categories taxonomy link */
			esc_html__( 'Builder Template Categories', 'builder-template-categories' ),
			ddw_btc_string_template( 'template' )
		);

	}  // end if

	/** Display plugin settings links */
	return apply_filters(
		'btc/filter/plugins_page/tax_link',
		array_merge( $btc_links, $action_links ),
		$btc_links 		// additional param
	);

}  // end function


add_filter( 'plugin_row_meta', 'ddw_btc_plugin_links', 10, 2 );
/**
 * Add various support links to Plugins page.
 *
 * @since 1.0.0
 *
 * @uses ddw_btc_get_info_link()
 *
 * @param array  $btc_links (Default) Array of plugin meta links
 * @param string $btc_file  Path of base plugin file
 * @return array $btc_links Array of plugin link strings to build HTML markup.
 */
function ddw_btc_plugin_links( $btc_links, $btc_file ) {

	/** Capability check */
	if ( ! current_user_can( 'install_plugins' ) ) {
		return $btc_links;
	}

	/** List additional links only for this plugin */
	if ( $btc_file === BTC_PLUGIN_BASEDIR . 'builder-template-categories.php' ) {

		/* translators: Plugins page listing */
		$btc_links[] = ddw_btc_get_info_link(
			'url_snippets',
			esc_html_x( 'Code Snippets', 'Plugins page listing', 'builder-template-categories' ),
			'dashicons-before dashicons-editor-code'
		);

		/* translators: Plugins page listing */
		$btc_links[] = ddw_btc_get_info_link(
			'url_donate',
			esc_html_x( 'Donate', 'Plugins page listing', 'builder-template-categories' ),
			'button dashicons-before dashicons-thumbs-up'
		);

		/* translators: Plugins page listing */
		$btc_links[] = ddw_btc_get_info_link(
			'url_newsletter',
			esc_html_x( 'Join our Newsletter', 'Plugins page listing', 'builder-template-categories' ),
			'button-primary dashicons-before dashicons-awards'
		);

	}  // end if plugin links

	/** Output the links */
	return apply_filters(
		'btc/filter/plugins_page/more_links',
		$btc_links
	);

}  // end function


add_filter( 'debug_information', 'ddw_btc_site_health_add_debug_info', 7 );
/**
 * Add additional plugin related info to the Site Health Debug Info section.
 *   (Only relevant for WordPress 5.2 or higher)
 *
 * @link https://make.wordpress.org/core/2019/04/25/site-health-check-in-5-2/
 *
 * @since 1.5.1
 *
 * @uses ddw_btc_get_integrations()
 * @uses ddw_btc_tax_edit_info_content()
 *
 * @param array $debug_info Array holding all Debug Info items.
 * @return array Modified array of Debug Info.
 */
function ddw_btc_site_health_add_debug_info( $debug_info ) {

	/** Get all integrations */
	$get_integrations    = ddw_btc_get_integrations();
	$integrations_output = '';

	/** Collect string for each active integration */
	foreach ( $get_integrations as $integration => $integration_data ) {

		if ( 'default-none' !== $integration ) {

			$integrations_output .= sprintf(
				'%1$s (%2$s), ',
				esc_html( $integration_data[ 'label' ] ),
				sanitize_key( $integration_data[ 'post_type' ] )
			);

		}  // end if

	}  // end foreach

	$integrations_output = ( empty( $integrations_output ) ) ? esc_html__( 'No integration(s) active', 'builder-template-categories' ) : $integrations_output;

	/** Add our Debug info */
	$debug_info[ 'builder-template-categories' ] = array(
		'label'  => esc_html__( 'Builder Template Categories', 'builder-template-categories' ) . ' (' . esc_html__( 'Plugin', 'builder-template-categories' ) . ')',
		'fields' => array(
			'btc_plugin_version' => array(
				'label' => __( 'Plugin version', 'builder-template-categories' ),
				'value' => BTC_PLUGIN_VERSION,
			),
			'current_active_integrations' => array(
				'label' => __( 'Current active integrations', 'builder-template-categories' ),
				'value' => $integrations_output,
			),
		),
	);

	/** Return modified Debug Info array */
	return $debug_info;

}  // end function
