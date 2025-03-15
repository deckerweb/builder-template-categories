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
 * Remove unethical Jetpack search results Ads as no one needs these anyway.
 *   Additionally remove other promotions and Ads from Jetpack.
 *
 * @link https://wptavern.com/jetpack-7-1-adds-feature-suggestions-to-plugin-search-results#comment-284531
 *
 * @since 1.6.0
 */
add_filter( 'jetpack_show_promotions', '__return_false', 20 );
add_filter( 'can_display_jetpack_manage_notice', '__return_false', 20 );
add_filter( 'jetpack_just_in_time_msgs', '__return_false', 20 );


/**
 * Remove unethical WooCommerce Ads injections.
 *
 * @since 1.6.0
 */
add_filter( 'woocommerce_allow_marketplace_suggestions', '__return_false' );


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
			esc_attr_x( 'Template Categories', 'For Builder Template Categories Plugin', 'builder-template-categories' )
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


add_action( 'admin_enqueue_scripts', 'ddw_btc_inline_styles_plugins_page', 20 );
/**
 * Add additional inline styles on the admin Plugins page.
 *
 * @since 1.0.0
 * @since 1.7.0 Splitted into function; using wp_add_inline_style() from Core.
 *
 * @uses wp_add_inline_style()
 *
 * @global string $GLOBALS[ 'pagenow' ]
 */
function ddw_btc_inline_styles_plugins_page() {

	/** Bail early if not on plugins.php admin page */
	if ( 'plugins.php' !== $GLOBALS[ 'pagenow' ] ) {
		return;
	}

	$btc_file = BTC_PLUGIN_BASEDIR . 'builder-template-categories.php';

    /**
     * For WordPress Admin Area
     *   Style handle: 'wp-admin' (WordPress Core)
     */
    $inline_css = sprintf(
    	'
        tr[data-plugin="%s"] .plugin-version-author-uri a.dashicons-before:before {
			font-size: 17px;
			margin-right: 2px;
			opacity: .85;
			vertical-align: sub;
		}

		.btc-update-message p:before,
		.update-message.notice p:empty,
		.update-message.updating-message > p,
		.update-message.notice-success > p,
		.update-message.notice-error > p {
			display: none !important;
		}',
		$btc_file
	);

    wp_add_inline_style( 'wp-admin', $inline_css );

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

	/** Setup strings */
	$string_enabled   = __( 'Enabled', 'builder-template-categories' );
	$string_disabled  = __( 'Disabled', 'builder-template-categories' );

	$block_editor_cpt_ui = apply_filters( 'btc/filter/wp_block/post_type_ui', TRUE );
	
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
			'wpblock_post_type_ui' => array(
				'label' => __( 'Reusable Blocks Post Type UI', 'builder-template-categories' ),
				'value' => ( $block_editor_cpt_ui ) ? $string_enabled : $string_disabled,
			),
		),
	);

	/** Return modified Debug Info array */
	return $debug_info;

}  // end function


if ( ! function_exists( 'ddw_wp_site_health_remove_percentage' ) ) :

	add_action( 'admin_head', 'ddw_wp_site_health_remove_percentage', 100 );
	/**
	 * Remove the "Percentage Progress" display in Site Health feature as this will
	 *   get users obsessed with fulfilling a 100% where there are non-problems!
	 *
	 * @link https://make.wordpress.org/core/2019/04/25/site-health-check-in-5-2/
	 *
	 * @since 1.5.1
	 */
	function ddw_wp_site_health_remove_percentage() {

		/** Bail early if not on WP 5.2+ */
		if ( version_compare( $GLOBALS[ 'wp_version' ], '5.2-beta', '<' ) ) {
			return;
		}

		?>
			<style type="text/css">
				.site-health-progress {
					display: none;
				}
			</style>
		<?php

	}  // end function

endif;