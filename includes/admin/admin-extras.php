<?php

// includes/admin-extras

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
 * @since  1.0.0
 *
 * @param  array $btc_links (Default) Array of plugin action links.
 * @return strings $btc_links Settings & Menu Admin links.
 */
function ddw_btc_custom_taxonomy_links( $btc_links ) {

	$btc_tax_link = '';

	/** Add settings link only if user has permission */
	if ( current_user_can( ddw_btc_capability_submenu() ) ) {

		/** Taxonomy Page link */
		$btc_tax_link = sprintf(
			'<a class="dashicons-before dashicons-category" href="%s" title="%s">%s</a>',
			esc_url( admin_url( ddw_btc_taxonomy_admin_url() ) ),
			/* translators: Title attribute for Toolbar Extras "Plugin settings" link */
			esc_html__( 'Builder Template Categories', 'builder-template-categories' ),
			esc_attr_x( 'Template Categories', 'For Builder Template Categories Plugin', 'builder-template-categories' )
		);

	}  // end if

	/** Set the order of the links */
	array_unshift( $btc_links, $btc_tax_link );

	/** Display plugin settings links */
	return apply_filters(
		'btc/filter/plugins_page/tax_link',
		$btc_links
	);

}  // end function


add_filter( 'plugin_row_meta', 'ddw_btc_plugin_links', 10, 2 );
/**
 * Add various support links to Plugins page.
 *
 * @since  1.0.0
 *
 * @uses   ddw_btc_get_info_link()
 *
 * @param  array  $btc_links (Default) Array of plugin meta links
 * @param  string $btc_file  URL of base plugin file
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
		$btc_links[] = ddw_btc_get_info_link( 'url_wporg_forum', esc_html_x( 'Support', 'Plugins page listing', 'builder-template-categories' ) );

		/* translators: Plugins page listing */
		$btc_links[] = ddw_btc_get_info_link( 'url_translate', esc_html_x( 'Translations', 'Plugins page listing', 'builder-template-categories' ) );

		/* translators: Plugins page listing */
		$btc_links[] = ddw_btc_get_info_link( 'url_donate', esc_html_x( 'Donate', 'Plugins page listing', 'builder-template-categories' ), 'button-primary' );

	}  // end if plugin links

	/** Output the links */
	return apply_filters(
		'btc/filter/plugins_page/more_links',
		$btc_links
	);

}  // end function


add_filter( 'plugins_api_result', 'ddw_btc_add_plugins_api_results', 11, 3 );
/**
 * Filter plugin fetching API results to inject plugin "Multisite Toolbar Additions".
 *
 * @since   1.0.0
 *
 * Code heavily inspired by original code from Remy Perona/ WP-Rocket.
 * @author  Remy Perona
 * @link    https://wp-rocket.me/
 * @license GPL-2.0+
 *
 * @uses    ddw_tbex_is_block_editor_active()
 *
 * @param   object|WP_Error $result Response object or WP_Error.
 * @param   string          $action The type of information being requested from the Plugin Install API.
 * @param   object          $args   Plugin API arguments.
 *
 * @return array Updated array of results.
 */
function ddw_btc_add_plugins_api_results( $result, $action, $args ) {

	/** Bail early if no results wanted, or results are empty */
	if ( ddw_btc_is_tbex_active()
		|| ddw_btc_is_clpinst_active()
		|| empty( $args->browse )
	) {
		return $result;
	}

	/** Bail early if plugin installer tabs are not available */
	if ( 'featured' !== $args->browse
		&& 'recommended' !== $args->browse
		&& 'popular' !== $args->browse
	) {
		return $result;
	}

	/** Bail early if results page is empty */
	if ( ! isset( $result->info[ 'page' ] ) || 1 < $result->info[ 'page' ] ) {
		return $result;
	}

	$query_fields = array(
		'icons'             => TRUE,
		'active_installs'   => TRUE,
		'short_description' => TRUE,
		'group'             => TRUE,
	);

	/** Results for specific plugins (slugs) */
	$tbex_query_args      = array( 'slug' => 'toolbar-extras', 'fields' => $query_fields, );
	$elementor_query_args = array( 'slug' => 'elementor', 'fields' => $query_fields, );
	$fep_query_args       = array( 'slug' => 'flexible-elementor-panel', 'fields' => $query_fields, );
	$ccp_query_args       = array( 'slug' => 'kt-tinymce-color-grid', 'fields' => $query_fields, );
	$dagb_query_args      = array( 'slug' => 'disable-gutenberg', 'fields' => $query_fields, );
	$simplecss_query_args = array( 'slug' => 'simple-css', 'fields' => $query_fields, );
	$cs_query_args        = array( 'slug' => 'code-snippets', 'fields' => $query_fields, );
	$czs_query_args       = array( 'slug' => 'customizer-search', 'fields' => $query_fields, );
	$czei_query_args      = array( 'slug' => 'customizer-export-import', 'fields' => $query_fields, );
	$dbwfe_query_args     = array( 'slug' => 'dashboard-welcome-for-elementor', 'fields' => $query_fields, );
	$llar_query_args      = array( 'slug' => 'limit-login-attempts-reloaded', 'fields' => $query_fields, );
	$aopz_query_args      = array( 'slug' => 'autoptimize', 'fields' => $query_fields, );
	$spl_query_args       = array( 'slug' => 'swift-performance-lite', 'fields' => $query_fields, );
	$de_query_args        = array( 'slug' => 'debug-elementor', 'fields' => $query_fields, );

	$tbex_data      = plugins_api( 'plugin_information', $tbex_query_args );
	$elementor_data = plugins_api( 'plugin_information', $elementor_query_args );
	$fep_data       = plugins_api( 'plugin_information', $fep_query_args );
	$ccp_data       = plugins_api( 'plugin_information', $ccp_query_args );
	$dagb_data      = plugins_api( 'plugin_information', $dagb_query_args );
	$simplecss_data = plugins_api( 'plugin_information', $simplecss_query_args );
	$cs_data        = plugins_api( 'plugin_information', $cs_query_args );
	$czs_data       = plugins_api( 'plugin_information', $czs_query_args );
	$czei_data      = plugins_api( 'plugin_information', $czei_query_args );
	$dbwfe_data     = plugins_api( 'plugin_information', $dbwfe_query_args );
	$llar_data      = plugins_api( 'plugin_information', $llar_query_args );
	$aopz_data      = plugins_api( 'plugin_information', $aopz_query_args );
	$spl_data       = plugins_api( 'plugin_information', $spl_query_args );
	$de_data        = plugins_api( 'plugin_information', $de_query_args );

	/** Hook in our results */
	if ( 'featured' === $args->browse && ! ddw_btc_is_tbex_active() ) {

		/** Set the default to empty */
		$result->plugins = array();

		array_push( $result->plugins, $tbex_data, $elementor_data, $ccp_data, $simplecss_data, $cs_data, $czs_data, $czei_data, $dbwfe_data, $llar_data, $aopz_data, $spl_data, $de_data );

	} elseif ( 'recommended' === $args->browse ) {

		array_unshift( $result->plugins, $tbex_data, $aopz_data, $spl_data, $elementor_data );

	} elseif ( 'popular' === $args->browse ) {

		array_unshift( $result->plugins, $tbex_data, $elementor_data );

	}  // end if

	return $result;

}  // end function


add_filter( 'admin_footer_text', 'ddw_btc_admin_footer_text' );
/**
 * Modifies the "Thank you" text displayed in the WP Admin footer.
 *   Fired by 'admin_footer_text' filter.
 *
 * @since  1.0.0
 *
 * @param  string $footer_text The content that will be printed.
 * @return string The content that will be printed.
 */
function ddw_btc_admin_footer_text( $footer_text ) {

	$current_screen = get_current_screen();
	$is_btc_screen  = ( $current_screen && FALSE !== strpos( $current_screen->id, 'edit-builder-template-category' ) );

	if ( $is_btc_screen ) {

		$footer_text = sprintf(
			/* translators: 1 - Builder Template Categories / 2 - Link to plugin review */
			__( 'Enjoyed %1$s? Please leave us a %2$s rating. We really appreciate your support!', 'builder-template-categories' ),
			'<strong>' . __( 'Builder Template Categories', 'builder-template-categories' ) . '</strong>',
			'<a href="https://wordpress.org/support/plugin/builder-template-categories/reviews/?filter=5#new-post" target="_blank" rel="noopener noreferrer">&#9733;&#9733;&#9733;&#9733;&#9733;</a>'
		);

	}  // end if

	return $footer_text;

}  // end function


/**
 * Help content when on adding/edit our Taxonomy terms.
 *
 * @since 1.0.0
 */
function ddw_btc_tax_edit_info_content() {

	$output = '<div class="notice notice-info">';

	$output .= sprintf(
		'<p class="description">%s:</p>',
		esc_attr__( 'These Template Categories are globally available for Administrators within the Admin Dashboard and can be used to organize the template libraries for the following active Plugins and/or Themes', 'builder-template-categories' )
	);

	$output .= '<ul style="margin-left: 10px;">';

	/** Get all integrations */
	$integrations = ddw_btc_get_integrations();

	/** Add label for each active integration */
	foreach ( $integrations as $integration => $integration_data ) {

		if ( 'default-none' !== $integration ) {

			$output .= sprintf(
				'<li class="dashicons-before dashicons-category"> <a href="%1$s">%2$s</a></li>',
				esc_url( admin_url( $integration_data[ 'admin_url' ] ) ),
				esc_attr( $integration_data[ 'label' ] )
			);

		}  // end if

	}  // end foreach

	$output .= '</ul>';
	$output .= '</div>';

	echo $output;

}  // end function


add_action( 'builder-template-category_pre_add_form', 'ddw_btc_tax_pre_info', 10, 1 );
/**
 * Display help content when adding a new term to our Taxonomy.
 *
 * @since 1.0.0
 */
function ddw_btc_tax_pre_info( $taxonomy = 'builder-template-category' ) {

	/** Bail early if user wants no info */
	if ( apply_filters( 'btc/filter/help_content/tax_pre_info', FALSE ) ) {
		return;
	}

	ddw_btc_tax_edit_info_content();

}  // end function


add_action( 'builder-template-category_term_edit_form_top', 'ddw_btc_term_edit_info', 10, 2 );
/**
 * Display our help content when editing a term of our Taxonomy.
 *
 * @since 1.0.0
 */
function ddw_btc_term_edit_info( $tag, $taxonomy = 'builder-template-category' ) {

	/** Bail early if user wants no info */
	if ( apply_filters( 'btc/filter/help_content/tax_pre_info', FALSE ) ) {
		return;
	}

	ddw_btc_tax_edit_info_content();

}  // end function