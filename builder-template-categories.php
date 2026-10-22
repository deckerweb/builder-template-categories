<?php # -*- coding: utf-8 -*-
/**
 * Plugin Name:       Builder Template Categories
 * Plugin URI:        https://github.com/deckerweb/builder-template-categories
 * Description:       Organize WordPress patterns and the template libraries of supported builders and themes with shared categories.
 * Version:           1.9.2
 * Requires at least: 7.0
 * Requires PHP:      8.1
 * Author:            David Decker - DECKERWEB
 * Author URI:        https://github.com/deckerweb
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       builder-template-categories
 * Domain Path:       /languages/
 * Update URI:        https://github.com/deckerweb/builder-template-categories
 * GitHub Plugin URI: https://github.com/deckerweb/builder-template-categories
 *
 * Copyright:         © 2018-2026, David Decker - DECKERWEB
 * SPDX-License-Identifier: GPL-2.0-or-later
 */

/**
 * Exit if called directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Setting constants.
 *
 * @since 1.0.0
 */
/** Plugin version */
define( 'BTC_PLUGIN_VERSION', '1.9.2' );
define( 'BTC_PLUGIN_FILE', __FILE__ );

/** Plugin directory */
define( 'BTC_PLUGIN_DIR', trailingslashit( dirname( __FILE__ ) ) );

/** Plugin base directory */
define( 'BTC_PLUGIN_BASEDIR', trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );


require_once __DIR__ . '/includes/deckerweb-plugin-library/bootstrap.php';
deckerweb_library_register_v2( __FILE__, array(), __DIR__ . '/includes/deckerweb-plugin-library' );
require_once __DIR__ . '/includes/updates.php';

add_action( 'init', 'ddw_btc_load_translations', 1 );
add_action( 'change_locale', 'ddw_btc_load_translations' );
/**
 * Load the text domain for translation of the plugin.
 *
 * @since 1.0.0
 *
 * @uses determine_locale()
 * @uses load_textdomain() To load translations first from WP_LANG_DIR sub folder.
 * @uses load_plugin_textdomain() To additionally load default translations from plugin folder (default).

 * @return void
 */
function ddw_btc_load_translations() {

    /** Set unique textdomain string */
    $btc_textdomain = 'builder-template-categories';

    /** The 'plugin_locale' filter is also used by default in load_plugin_textdomain() */
    $locale = esc_attr(
        apply_filters(
            'plugin_locale',
            determine_locale(),
            $btc_textdomain
        )
    );

    /**
     * WordPress languages directory
     *   Will default to: wp-content/languages/builder-template-categories/builder-template-categories-{locale}.mo
     */
    $btc_wp_lang_dir = trailingslashit( WP_LANG_DIR ) . trailingslashit( $btc_textdomain ) . $btc_textdomain . '-' . $locale . '.mo';

    /** Translations: First, look in WordPress' "languages" folder = custom & update-safe! */
    load_textdomain(
        $btc_textdomain,
        $btc_wp_lang_dir
    );

    // Preserve installed language-pack overrides, then supply new bundled messages.
    load_textdomain( $btc_textdomain, WP_LANG_DIR . '/plugins/' . $btc_textdomain . '-' . $locale . '.mo', $locale );
    load_textdomain( $btc_textdomain, BTC_PLUGIN_DIR . 'languages/' . $btc_textdomain . '-' . $locale . '.mo', $locale );
    load_plugin_textdomain( $btc_textdomain, plugin_rel_path: BTC_PLUGIN_BASEDIR . 'languages' );

}  // end function


/** Include global functions */
require_once BTC_PLUGIN_DIR . 'includes/functions-global.php';

/** Include (global) conditionals functions */
require_once BTC_PLUGIN_DIR . 'includes/functions-conditionals.php';

/** Include string functions */
require_once BTC_PLUGIN_DIR . 'includes/string-switcher.php';


add_action( 'init', 'ddw_btc_setup_plugin', 5 );
/**
 * Finally setup the plugin for the main tasks.
 *
 * @since 1.0.0

 * @return void
 */
function ddw_btc_setup_plugin() {

	/** Register Templates taxonomy */
	require_once BTC_PLUGIN_DIR . 'includes/register-taxonomy.php';

	/** Load available integrations */
	require_once BTC_PLUGIN_DIR . 'includes/load-integrations.php';

	/** Finally, execute the available integrations */
	require_once BTC_PLUGIN_DIR . 'includes/run-integrations.php';

	/** Include admin helper functions */
	if ( is_admin() && current_user_can( ddw_btc_capability_submenu() ) ) {
		require_once BTC_PLUGIN_DIR . 'includes/admin/admin-help.php';
		require_once BTC_PLUGIN_DIR . 'includes/admin/admin-extras.php';
	}

	/** Add links to Settings and Menu pages to Plugins page */
	if ( is_admin() && current_user_can( ddw_btc_capability_submenu() ) ) {

		add_filter(
			'plugin_action_links_' . plugin_basename( __FILE__ ),
			'ddw_btc_custom_taxonomy_links'
		);

		add_filter(
			'network_admin_plugin_action_links_' . plugin_basename( __FILE__ ),
			'ddw_btc_custom_taxonomy_links'
		);

	}  // end if

}  // end function


/**
 * Steps of the plugin activation routine.
 *
 * @since 1.0.0
 *
 * @see plugin file includes/register-taxonomy.php
 *
 * @uses ddw_btc_load_translations()
 * @uses ddw_btc_register_templates_taxonomy()
 * @uses ddw_btc_add_predefined_terms()

 * @return void
 */
function ddw_btc_plugin_activation_routine() {

	/**
	 * During run of the activation hook no other hooks and functions are
	 *   available, so we need to load them temporarily.
	 * @link https://premium.wpmudev.org/blog/activate-deactivate-uninstall-hooks/
	 */

	require_once BTC_PLUGIN_DIR . 'includes/load-integrations.php';
	require_once BTC_PLUGIN_DIR . 'includes/register-taxonomy.php';

	ddw_btc_register_templates_taxonomy();

	/** Add predefined terms */
	if ( apply_filters( 'btc/filter/terms/add_predefined', TRUE ) ) {

		/** For our own taxonomy */
		ddw_btc_add_predefined_terms( 'builder-template-category' );


	}  // end if

}  // end function


register_activation_hook( __FILE__, 'ddw_btc_run_plugin_activation' );
/**
 * On plugin activation register the plugin's custom taxonomy and add predefined
 *   terms.
 *
 * @since 1.0.0
 *
 * @link https://leaves-and-love.net/blog/making-plugin-multisite-compatible/
 *
 * @uses ddw_btc_plugin_activation_routine()

 * @param bool $network_wide Whether activation is network-wide.
 * @return void
 */
function ddw_btc_run_plugin_activation( $network_wide ) {
	if ( ! is_multisite() || ! $network_wide ) {
		ddw_btc_plugin_activation_routine();
		return;
	}
	$offset = 0;
	do {
		$ids = get_sites( array( 'fields' => 'ids', 'network_id' => get_current_network_id(), 'number' => 100, 'offset' => $offset, 'orderby' => 'id', 'order' => 'ASC' ) );
		foreach ( $ids as $id ) {
			switch_to_blog( $id );
			try {
				ddw_btc_plugin_activation_routine();
			} finally {
				restore_current_blog();
			}
		}
		$offset += count( $ids );
	} while ( 100 === count( $ids ) );
}


add_action( 'wp_initialize_site', 'ddw_btc_network_new_site_run_plugin_activation', 200, 1 );
/**
 * When creating a new Site within a Multisite Network run the plugin activation
 *   routine - if Builder Template Categories is activated Network-wide.
 *   Note: The 'wp_initialize_site' hook fires only in Multisite.
 *
 * @since 1.0.0
 *
 * @uses ddw_btc_plugin_activation_routine()

 * @param WP_Site $new_site Newly initialized site.
 * @return void
 */
function ddw_btc_network_new_site_run_plugin_activation( $new_site ) {
	if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	if ( ! is_plugin_active_for_network( plugin_basename( __FILE__ ) ) ) {
		return;
	}
	switch_to_blog( $new_site->blog_id );
	try {
		ddw_btc_plugin_activation_routine();
	} finally {
		restore_current_blog();
	}
}
