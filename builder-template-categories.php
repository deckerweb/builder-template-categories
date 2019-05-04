<?php # -*- coding: utf-8 -*-
/**
 * Main plugin file.
 * @package           Builder Template Categories
 * @author            David Decker
 * @copyright         Copyright (c) 2018-2019, David Decker - DECKERWEB
 * @license           GPL-2.0-or-later
 * @link              https://deckerweb.de/twitter
 *
 * @wordpress-plugin
 * Plugin Name:       Builder Template Categories
 * Plugin URI:        https://github.com/deckerweb/builder-template-categories
 * Description:       This plugin adds a Taxonomy "Template Category" for categorizing templates to make the life of site builders a little bit easier. It integrates with Elementor My Templates, OceanWP My Library, Astra Custom Layouts, GeneratePress Elements, Blox for Genesis, AnyWhere Elementor Global Templates and JetThemeCore My Library (Kava Pro/ CrocoBlock). These categories only appear in the WP-Admin Dashboard and only for the administrator user role (capability 'edit_theme_options').
 * Version:           1.5.1
 * Author:            David Decker - DECKERWEB
 * Author URI:        https://deckerweb.de/
 * License:           GPL-2.0-or-later
 * License URI:       https://opensource.org/licenses/GPL-2.0
 * Text Domain:       builder-template-categories
 * Domain Path:       /languages/
 * Requires WP:       4.7
 * Requires PHP:      5.6
 * GitHub Plugin URI: https://github.com/deckerweb/builder-template-categories
 * GitHub Branch:     master
 *
 * Copyright (c) 2018-2019 David Decker - DECKERWEB
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
define( 'BTC_PLUGIN_VERSION', '1.5.1' );

/** Plugin directory */
define( 'BTC_PLUGIN_DIR', trailingslashit( dirname( __FILE__ ) ) );

/** Plugin base directory */
define( 'BTC_PLUGIN_BASEDIR', trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );


add_action( 'init', 'ddw_btc_load_translations', 1 );
/**
 * Load the text domain for translation of the plugin.
 *
 * @since 1.0.0
 *
 * @uses get_user_locale()
 * @uses load_textdomain() To load translations first from WP_LANG_DIR sub folder.
 * @uses load_plugin_textdomain() To additionally load default translations from plugin folder (default).
 */
function ddw_btc_load_translations() {

	/** Set unique textdomain string */
	$btc_textdomain = 'builder-template-categories';

	/** The 'plugin_locale' filter is also used by default in load_plugin_textdomain() */
	$locale = esc_attr(
		apply_filters(
			'plugin_locale',
			get_user_locale(),
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

	/** Translations: Secondly, look in 'wp-content/languages/plugins/' for the proper .mo file (= default) */
	load_plugin_textdomain(
		$btc_textdomain,
		FALSE,
		BTC_PLUGIN_BASEDIR . 'languages'
	);

}  // end function


/** Include global functions */
require_once BTC_PLUGIN_DIR . 'includes/functions-global.php';

/** Include (global) conditionals functions */
require_once BTC_PLUGIN_DIR . 'includes/functions-conditionals.php';

/** Include string functions */
require_once BTC_PLUGIN_DIR . 'includes/string-switcher.php';


add_action( 'init', 'ddw_btc_setup_plugin' );
/**
 * Finally setup the plugin for the main tasks.
 *
 * @since 1.0.0
 */
function ddw_btc_setup_plugin() {

	/** Bail early if current user has no permission for this plugin */
	if ( ! current_user_can( ddw_btc_capability_submenu() ) ) {
		return;
	}

	/** Register Templates taxonomy */
	require_once BTC_PLUGIN_DIR . 'includes/register-taxonomy.php';

	/** Load available integrations */
	require_once BTC_PLUGIN_DIR . 'includes/load-integrations.php';

	/** Finally, execute the available integrations */
	require_once BTC_PLUGIN_DIR . 'includes/run-integrations.php';

	/** Include admin helper functions */
	if ( is_admin() ) {
		require_once BTC_PLUGIN_DIR . 'includes/admin/admin-help.php';
		require_once BTC_PLUGIN_DIR . 'includes/admin/admin-extras.php';
	}

	/** Add links to Settings and Menu pages to Plugins page */
	if ( ( is_admin() || is_network_admin() ) ) {

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
 * @since 1.4.3 Predefined terms for Elementor's own taxonomy.
 *
 * @see plugin file includes/register-taxonomy.php
 *
 * @uses ddw_btc_load_translations()
 * @uses ddw_btc_register_templates_taxonomy()
 * @uses ddw_btc_add_predefined_terms()
 */
function ddw_btc_plugin_activation_routine() {

	/** Bail early if permissions are not in place */
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	/**
	 * During run of the activation hook no other hooks and functions are
	 *   available, so we need to load them temporarily.
	 * @link https://premium.wpmudev.org/blog/activate-deactivate-uninstall-hooks/
	 */
	ddw_btc_load_translations();

	require_once BTC_PLUGIN_DIR . 'includes/register-taxonomy.php';

	ddw_btc_register_templates_taxonomy();

	/** Add predefined terms */
	if ( apply_filters( 'btc/filter/terms/add_predefined', TRUE ) ) {

		/** For our own taxonomy */
		ddw_btc_add_predefined_terms( 'builder-template-category' );

		/** Optionally for Elementor's built-in tax */
		if ( ddw_btc_is_elementor_version( 'core', '2.4.0-beta1', '>=' ) ) {
			ddw_btc_add_predefined_terms( 'elementor_library_category' );
		}

	}  // end if

}  // end function


register_activation_hook( __FILE__, 'ddw_btc_run_plugin_activation', 10, 1 );
/**
 * On plugin activation register the plugin's custom taxonomy and add predefined
 *   terms.
 *
 * @since 1.0.0
 *
 * @link https://leaves-and-love.net/blog/making-plugin-multisite-compatible/
 *
 * @uses ddw_btc_plugin_activation_routine()
 */
function ddw_btc_run_plugin_activation( $network_wide ) {

	/** 1st case: Network-wide activation in a Multisite Network */
    if ( is_multisite() && $network_wide ) { 

    	$site_ids = get_sites( array( 'fields' => 'ids', 'network_id' => get_current_network_id() ) );

        foreach ( $site_ids as $site_id ) {

        	/** Run Site after Site */
            switch_to_blog( $site_id );

            ddw_btc_plugin_activation_routine();

            restore_current_blog();

        }  // end foreach

    }

    /** 2nd case: Activation on a regular single site install */
    else {

        ddw_btc_plugin_activation_routine();

    }  // end if

}  // end function


add_action( 'wpmu_new_blog', 'ddw_btc_network_new_site_run_plugin_activation', 10, 6 );
/**
 * When creating a new Site within a Multisite Network run the plugin activation
 *   routine - if Toolbar Extras is activated Network-wide.
 *   Note: The 'wpmu_new_blog' hook fires only in Multisite.
 *
 * @since 1.0.0
 *
 * @uses ddw_btc_plugin_activation_routine()
 */
function ddw_btc_network_new_site_run_plugin_activation( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {

    if ( is_plugin_active_for_network( BTC_PLUGIN_BASEDIR . 'builder-template-categories.php' ) ) {

        switch_to_blog( $blog_id );

        ddw_btc_plugin_activation_routine();

        restore_current_blog();

    }  // end if

}  // end function
