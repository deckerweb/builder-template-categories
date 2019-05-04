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
 *
 * @param array $btc_links (Default) Array of plugin action links.
 * @return strings $btc_links Settings & Menu Admin links.
 */
function ddw_btc_custom_taxonomy_links( $btc_links ) {

	$btc_tax_link = '';

	/** Add settings link only if user has permission */
	if ( current_user_can( ddw_btc_capability_submenu() ) ) {

		/** Taxonomy Page link */
		$btc_tax_link = sprintf(
			'<a href="%s" title="%s"><span class="dashicons-before dashicons-category"></span> %s</a>',
			esc_url( admin_url( ddw_btc_taxonomy_admin_url() ) ),
			/* translators: Title attribute for Builder Template Categories taxonomy link */
			esc_html__( 'Builder Template Categories', 'builder-template-categories' ),
			esc_attr_x( 'Template Categories', 'For Builder Template Categories Plugin', 'builder-template-categories' )
		);

	}  // end if

	/** Set the order of the links */
	if ( ! empty( $btc_tax_link ) ) {
		array_unshift( $btc_links, $btc_tax_link );
	}

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

		?>
			<style type="text/css">
				tr[data-plugin="<?php echo $btc_file; ?>"] .plugin-version-author-uri a.dashicons-before:before {
					font-size: 17px;
					margin-right: 2px;
					opacity: .85;
					vertical-align: sub;
				}
			</style>
		<?php

		/* translators: Plugins page listing */
		$btc_links[] = ddw_btc_get_info_link( 'url_wporg_forum', esc_html_x( 'Support', 'Plugins page listing', 'builder-template-categories' ), 'dashicons-before dashicons-sos' );

		/* translators: Plugins page listing */
		$btc_links[] = ddw_btc_get_info_link( 'url_fb_group', esc_html_x( 'Facebook Group', 'Plugins page listing', 'builder-template-categories' ), 'dashicons-before dashicons-facebook' );

		/* translators: Plugins page listing */
		$btc_links[] = ddw_btc_get_info_link( 'url_translate', esc_html_x( 'Translations', 'Plugins page listing', 'builder-template-categories' ), 'dashicons-before dashicons-translation' );

		/* translators: Plugins page listing */
		$btc_links[] = ddw_btc_get_info_link( 'url_snippets', esc_html_x( 'Code Snippets', 'Plugins page listing', 'builder-template-categories' ), 'dashicons-before dashicons-editor-code' );

		/* translators: Plugins page listing */
		$btc_links[] = ddw_btc_get_info_link( 'url_donate', esc_html_x( 'Donate', 'Plugins page listing', 'builder-template-categories' ), 'button dashicons-before dashicons-thumbs-up' );

		/* translators: Plugins page listing */
		$btc_links[] = ddw_btc_get_info_link( 'url_newsletter', esc_html_x( 'Join our Newsletter', 'Plugins page listing', 'builder-template-categories' ), 'button-primary dashicons-before dashicons-awards' );

	}  // end if plugin links

	/** Output the links */
	return apply_filters(
		'btc/filter/plugins_page/more_links',
		$btc_links
	);

}  // end function


add_filter( 'admin_footer_text', 'ddw_btc_admin_footer_text' );
/**
 * Modifies the "Thank you" text displayed in the WP Admin footer.
 *   Fired by 'admin_footer_text' filter.
 *
 * @since 1.0.0
 * @since 1.4.3 Tweaked rating link.
 *
 * @uses ddw_btc_get_info_url()
 *
 * @param string $footer_text The content that will be printed.
 * @return string The content that will be printed.
 */
function ddw_btc_admin_footer_text( $footer_text ) {

	$current_screen = get_current_screen();
	$is_btc_screen  = ( $current_screen && FALSE !== strpos( $current_screen->id, 'edit-builder-template-category' ) );

	if ( $is_btc_screen ) {

		$rating = sprintf(
			/* translators: %s - 5 stars icons */
			'<a href="' . ddw_btc_get_info_url( 'url_wporg_review' ) . '" target="_blank" rel="nofollow noopener noreferrer">' . __( '%s rating', 'builder-template-categories' ) . '</a>',
			'&#9733;&#9733;&#9733;&#9733;&#9733;'
		);

		$footer_text = sprintf(
			/* translators: 1 - Plugin name "Builder Template Categories" / 2 - label "5 star rating" */
			__( 'Enjoyed %1$s? Please leave us a %2$s. We really appreciate your support!', 'builder-template-categories' ),
			'<strong>' . __( 'Builder Template Categories', 'builder-template-categories' ) . '</strong>',
			$rating
		);

	}  // end if

	return $footer_text;

}  // end function


add_filter( 'debug_information', 'ddw_btc_site_health_add_debug_info', 12 );
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
	 *   get users obsessed with fullfilling a 100% where there are non-problems!
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


/**
 * Inline CSS fix for Plugins page update messages.
 *
 * @since 1.0.1
 *
 * @see ddw_btc_plugin_update_message()
 * @see ddw_btc_multisite_subsite_plugin_update_message()
 */
function ddw_btc_plugin_update_message_style_tweak() {

	?>
		<style type="text/css">
			.btc-update-message p:before,
			.update-message.notice p:empty {
				display: none !important;
			}
		</style>
	<?php

}  // end function


add_action( 'in_plugin_update_message-' . BTC_PLUGIN_BASEDIR . 'builder-template-categories.php', 'ddw_btc_plugin_update_message', 10, 2 );
/**
 * On Plugins page add visible upgrade/update notice in the overview table.
 *   Note: This action fires for regular single site installs, and for Multisite
 *         installs where the plugin is activated Network-wide.
 *
 * @since 1.0.1
 *
 * @param object $data
 * @param object $response
 * @return string Echoed string and markup for the plugin's upgrade/update
 *                notice.
 */
function ddw_btc_plugin_update_message( $data, $response ) {

	if ( isset( $data[ 'upgrade_notice' ] ) ) {

		ddw_btc_plugin_update_message_style_tweak();

		printf(
			'<div class="update-message btc-update-message">%s</div>',
			wpautop( $data[ 'upgrade_notice' ] )
		);

	}  // end if

}  // end function


add_action( 'after_plugin_row_wp-' . BTC_PLUGIN_BASEDIR . 'builder-template-categories.php', 'ddw_btc_multisite_subsite_plugin_update_message', 10, 2 );
/**
 * On Plugins page add visible upgrade/update notice in the overview table.
 *   Note: This action fires for Multisite installs where the plugin is
 *         activated on a per site basis.
 *
 * @since 1.0.1
 *
 * @param string $file
 * @param object $plugin
 * @return string Echoed string and markup for the plugin's upgrade/update
 *                notice.
 */
function ddw_btc_multisite_subsite_plugin_update_message( $file, $plugin ) {

	if ( is_multisite() && version_compare( $plugin[ 'Version' ], $plugin[ 'new_version' ], '<' ) ) {

		$wp_list_table = _get_list_table( 'WP_Plugins_List_Table' );

		ddw_btc_plugin_update_message_style_tweak();

		printf(
			'<tr class="plugin-update-tr"><td colspan="%s" class="plugin-update update-message notice inline notice-warning notice-alt"><div class="update-message btc-update-message"><h4 style="margin: 0; font-size: 14px;">%s</h4>%s</div></td></tr>',
			$wp_list_table->get_column_count(),
			$plugin[ 'Name' ],
			wpautop( $plugin[ 'upgrade_notice' ] )
		);

	}  // end if

}  // end function


/**
 * Optionally tweaking Plugin API results to make more useful recommendations to
 *   the user.
 *
 * @since 1.0.0
 * @since 1.0.1 Complete refactoring, using library class DDWlib Plugin
 *              Installer Recommendations
 */

add_filter( 'ddwlib_plir/filter/plugins', 'ddw_btc_register_extra_plugin_recommendations' );
/**
 * Register specific plugins for the class "DDWlib Plugin Installer
 *   Recommendations".
 *   Note: The top-level array keys are plugin slugs from the WordPress.org
 *         Plugin Directory.
 *
 * @since 1.0.1
 * @since 1.4.0 Added new Block Editor recommendations.
 *
 * @uses ddw_btc_is_elementor_active()
 * @uses ddw_btc_is_block_editor_active()
 * @uses ddw_btc_is_block_editor_wanted()
 *
 * @param array $plugins Array holding all plugin recommendations, coming from
 *                       the class and the filter.
 * @return array Filtered array of all plugin recommendations.
 */
function ddw_btc_register_extra_plugin_recommendations( array $plugins ) {

	/** Remove our own slug when we are already active :) */
	if ( isset( $plugins[ 'builder-template-categories' ] ) ) {
		$plugins[ 'builder-template-categories' ] = null;
	}

	/** Add new keys to recommendations */
	$plugins[ 'custom-css-js' ] = array(
		'featured'    => 'yes',
		'recommended' => 'yes',
		'popular'     => 'no',
	);

  	/** Register additional Elementor plugin recommendations */
  	$plugins_elementor = array();

  	if ( ddw_btc_is_elementor_active() ) {

		$plugins_elementor = array(
			'anywhere-elementor' => array(
				'featured'    => 'yes',
				'recommended' => 'yes',
				'popular'     => 'yes',
			),
			'templementor' => array(
				'featured'    => 'yes',
				'recommended' => 'yes',
				'popular'     => 'no',
			),
		);

	}  // end if

  	/** Register additional Block Editor (Gutenberg) plugin recommendations */
  	$plugins_block_editor = array();

  	if ( ddw_btc_is_block_editor_active() && ddw_btc_is_block_editor_wanted() ) {

		$plugins_block_editor = array(
			'ultimate-addons-for-gutenberg' => array(
				'featured'    => 'yes',
				'recommended' => 'yes',
				'popular'     => 'yes',
			),
			'kadence-blocks' => array(
				'featured'    => 'yes',
				'recommended' => 'yes',
				'popular'     => 'yes',
			),
			'disable-gutenberg-blocks' => array(
				'featured'    => 'yes',
				'recommended' => 'yes',
				'popular'     => 'no',
			),
			'block-builder' => array(
				'featured'    => 'yes',
				'recommended' => 'yes',
				'popular'     => 'yes',
			),
			'lazy-blocks' => array(
				'featured'    => 'yes',
				'recommended' => 'yes',
				'popular'     => 'no',
			),
			'block-lab' => array(
				'featured'    => 'yes',
				'recommended' => 'yes',
				'popular'     => 'no',
			),
			'manager-for-gutenberg' => array(
				'featured'    => 'no',
				'recommended' => 'yes',
				'popular'     => 'no',
			),
		);

	}  // end if

	/** Merge with the existing recommendations and return */
	return array_merge( $plugins, $plugins_elementor, $plugins_block_editor );
  
}  // end function

/** Optionally add string translations for the library */
if ( ! function_exists( 'ddwlib_plir_strings_plugin_installer' ) ) :

	add_filter( 'ddwlib_plir/filter/strings/plugin_installer', 'ddwlib_plir_strings_plugin_installer' );
	/**
	 * Optionally, make strings translateable for included library "DDWlib Plugin
	 *   Installer Recommendations".
	 *   Strings:
	 *    - "Newest" --> tab in plugin installer toolbar
	 *    - "Version:" --> label in plugin installer plugin card
	 *
	 * @since 1.1.0
	 * @since 1.5.0 Added new strings.
	 *
	 * @param array $strings Holds all filterable strings of the library.
	 * @return array Array of tweaked translateable strings.
	 */
	function ddwlib_plir_strings_plugin_installer( $strings ) {

		$strings[ 'newest' ] = _x(
			'Newest',
			'Plugin installer: Tab name in installer toolbar',
			'builder-template-categories'
		);

		$strings[ 'version' ] = _x(
			'Version:',
			'Plugin card: plugin version',
			'builder-template-categories'
		);

		$strings[ 'ddwplugins_tab' ] = _x(
			'deckerweb Plugins',
			'Plugin installer: Tab name in installer toolbar',
			'builder-template-categories'
		);

		$strings[ 'tab_title' ] = _x(
			'deckerweb Plugins',
			'Plugin installer: Page title',
			'builder-template-categories'
		);

		$strings[ 'tab_slogan' ] = __( 'Great helper tools for Site Builders to save time and get more productive', 'builder-template-categories' );

		$strings[ 'tab_info' ] = sprintf(
			__( 'You can use any of our free plugins or premium plugins from %s', 'builder-template-categories' ),
			'<a href="https://deckerweb-plugins.com/" target="_blank" rel="nofollow noopener noreferrer">' . $strings[ 'tab_title' ] . '</a>'
		);

		$strings[ 'tab_newsletter' ] = __( 'Join our Newsletter', 'builder-template-categories' );

		$strings[ 'tab_fbgroup' ] = __( 'Facebook User Group', 'builder-template-categories' );

		return $strings;

	}  // end function

endif;  // function check

/** Include class DDWlib Plugin Installer Recommendations */
require_once BTC_PLUGIN_DIR . 'includes/admin/ddwlib-plir/ddwlib-plugin-installer-recommendations.php';
