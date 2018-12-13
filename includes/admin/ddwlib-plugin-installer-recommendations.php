<?php

/**
 * DDWlib Plugin Installer Recommendations
 *
 * Copyright (C) 2018 David Decker - DECKERWEB <https://deckerweb.de>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package DDWlib Plugin Installer Recommendations
 * @author  David Decker
 * @license GPL-2.0-or-later http://www.gnu.org/licenses GNU General Public License
 * @version 1.2.1
 * @link    https://github.com/deckerweb/ddwlib-plugin-installer-recommendations
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Optionally tweaking Plugin API results to present more useful and relevant
 *   recommendations to the user.
 *
 *   Note: Tweak gets only loaded if library is not already active in another
 *         plugin.
 *
 * @since 1.0.0
 * @since 1.1.0 Added "Newest" tab; version number to plugin cards; CSS styles.
 */
if ( ! class_exists( 'DDWlib_Plugin_Installer_Recommendations' ) ) :

	/**
	 * Class DDWlib Plugin Installer Recommendations
	 */
	class DDWlib_Plugin_Installer_Recommendations {

		/**
		 * Constructor. Hooks all interactions into correct areas to start the class.
		 *
		 * @since 1.0.0
		 * @since 1.1.0 Added two more filter functions, plus two more actions.
		 */
		public function __construct() {

			/** Re-add hidden "Newest" tab */
			add_filter(
				'install_plugins_tabs',
				array( 'DDWlib_Plugin_Installer_Recommendations', 'plugin_installer_tweak_tabs' ),
				5,
				1
			);

			/** Add version number to plugin cards */
			add_filter(
				'plugin_install_action_links',
				array( 'DDWlib_Plugin_Installer_Recommendations', 'plugin_install_action_links' ),
				10,
				2
			);

			/** Filter Plugins API results (the main purpose!) */
			add_filter(
				'plugins_api_result',
				array( 'DDWlib_Plugin_Installer_Recommendations', 'plugins_api_result' ),
				11,
				3
			);

			/** Style tweaks for Plugin & Theme Installer */
			add_action(
				'admin_head-plugin-install.php',
				array( 'DDWlib_Plugin_Installer_Recommendations', 'installer_styles' ),
				15
			);

			add_action(
				'admin_head-theme-install.php',
				array( 'DDWlib_Plugin_Installer_Recommendations', 'installer_styles' ),
				15
			);

		}  // end method


		/**
		 * Define the query fields to be used for the API request.
		 *
		 * @since  1.0.0
		 *
		 * @return array Array of query fields as Plugins API arguments.
		 */
		static function query_fields() {
						
			return apply_filters(
				'ddwlib_plir/filter/query_fields',
				array(
					'icons'             => TRUE,
					'active_installs'   => TRUE,
					'short_description' => TRUE,
					'group'             => TRUE,
				)
			);

		}  // end method


		/**
		 * Define the - filterable - core array of recommended plugins.
		 *   Can be filtered by plugins & themes via the filter:
		 *   'ddwlib_parr/filter/plugins'
		 *
		 * @since  1.0.0
		 *
		 * @return array Filterable array of recommended plugins.
		 */
		static function recommended_plugins() {

			$core_plugins = array(
				'toolbar-extras' => array(		// by deckerweb	
					'featured'    => 'yes',
					'recommended' => 'yes',
					'popular'     => 'yes',
				),
				'elementor' => array(
					'featured'    => 'yes',
					'recommended' => 'yes',
					'popular'     => 'yes',
				),
				'disable-gutenberg' => array(
					'featured'    => 'yes',
					'recommended' => 'yes',
					'popular'     => 'yes',
				),
				'kt-tinymce-color-grid' => array(		// Central Color Palette
					'featured'    => 'yes',
					'recommended' => 'yes',
					'popular'     => 'no',
				),
				'simple-css' => array(
					'featured'    => 'yes',
					'recommended' => 'no',
					'popular'     => 'no',
				),
				'builder-template-categories' => array(		// by deckerweb		
					'featured'    => 'yes',
					'recommended' => 'yes',
					'popular'     => 'no',
				),
				'iconpress-lite' => array(
					'featured'    => 'yes',
					'recommended' => 'yes',
					'popular'     => 'no',
				),
				'code-snippets' => array(
					'featured'    => 'yes',
					'recommended' => 'yes',
					'popular'     => 'yes',
				),
				'customizer-search' => array(
					'featured'    => 'yes',
					'recommended' => 'yes',
					'popular'     => 'no',
				),
				'customizer-export-import' => array(
					'featured'    => 'yes',
					'recommended' => 'yes',
					'popular'     => 'no',
				),
				'dashboard-welcome-for-elementor' => array(
					'featured'    => 'yes',
					'recommended' => 'no',
					'popular'     => 'no',
				),
				'limit-login-attempts-reloaded' => array(
					'featured'    => 'yes',
					'recommended' => 'yes',
					'popular'     => 'yes',
				),
				'autoptimize' => array(
					'featured'    => 'yes',
					'recommended' => 'yes',
					'popular'     => 'no',
				),
				'swift-performance-lite' => array(
					'featured'    => 'yes',
					'recommended' => 'yes',
					'popular'     => 'no',
				),
				'duplicate-post' => array(
					'featured'    => 'no',
					'recommended' => 'no',
					'popular'     => 'yes',
				),
				'page-links-to' => array(
					'featured'    => 'no',
					'recommended' => 'yes',
					'popular'     => 'yes',
				),
				'widget-options' => array(
					'featured'    => 'no',
					'recommended' => 'yes',
					'popular'     => 'yes',
				),
				'wpforms-lite' => array(
					'featured'    => 'no',
					'recommended' => 'no',
					'popular'     => 'yes',
				),
				'caldera-forms' => array(
					'featured'    => 'no',
					'recommended' => 'no',
					'popular'     => 'yes',
				),
				'formidable' => array(
					'featured'    => 'no',
					'recommended' => 'no',
					'popular'     => 'yes',
				),
				'tablepress' => array(
					'featured'    => 'no',
					'recommended' => 'yes',
					'popular'     => 'yes',
				),
				'autodescription' => array(		// The SEO Framework
					'featured'    => 'no',
					'recommended' => 'yes',
					'popular'     => 'yes',
				),
				'wp-seopress' => array(		// SEOPress
					'featured'    => 'no',
					'recommended' => 'no',
					'popular'     => 'yes',
				),
				'login-designer' => array(
					'featured'    => 'no',
					'recommended' => 'yes',
					'popular'     => 'yes',
				),
				'members' => array(
					'featured'    => 'no',
					'recommended' => 'yes',
					'popular'     => 'yes',
				),
				'regenerate-thumbnails' => array(
					'featured'    => 'no',
					'recommended' => 'no',
					'popular'     => 'yes',
				),
				'antispam-bee' => array(
					'slug'        => 'antispam-bee',
					'featured'    => 'no',
					'recommended' => 'yes',
					'popular'     => 'yes',
				),
				'all-in-one-wp-migration' => array(
					'featured'    => 'no',
					'recommended' => 'no',
					'popular'     => 'yes',
				),
				'updraftplus' => array(
					'featured'    => 'no',
					'recommended' => 'yes',
					'popular'     => 'yes',
				),
				'backwpup' => array(
					'featured'    => 'no',
					'recommended' => 'no',
					'popular'     => 'yes',
				),
			);

			/** Return filterable array of core recommended plugins */
			return (array) apply_filters(
				'ddwlib_plir/filter/plugins',
				$core_plugins
			);

		}  // end method


		/**
		 * Get all plugins for the specified plugin installer tab - that have
		 *   the appropiate array key ('featured', 'recommended', 'popular') set
		 *   to 'yes'.
		 *
		 * @since  1.0.0
		 *
		 * @param  string $tab The tab of the plugin installer (as array key).
		 * @return array Array of plugins for the specified tab with the proper
		 *               Plugins API arguments.
		 */
		static function get_plugins( $tab = '' ) {

			/** Prepare data & values */
			$plugins = (array) DDWlib_Plugin_Installer_Recommendations::recommended_plugins();
			$fields  = (array) DDWlib_Plugin_Installer_Recommendations::query_fields();
			$tab     = sanitize_key( $tab );

			/** Set array */
			$get_plugins = array();

			/** Loop through plugin data arguments */
			foreach ( $plugins as $plugin_slug => $plugin_data ) {

				if ( 'yes' === $plugin_data[ $tab ] ) {

					$plugin_slug = sanitize_key( $plugin_slug );

					$get_plugins[ $plugin_slug ] = plugins_api(
						'plugin_information',
						array(
							'slug'   => $plugin_slug,
							'fields' => $fields,
						)
					);

				}  // end if

			}  // end foreach

			/** Return the results for a certain $tab param */
			return $get_plugins;

		}  // end method


		/**
		 * Filter plugin fetching API results to inject multiple plugin recommendations
		 *   - all via WordPress.org Plugin Directory.
		 *
		 * @since   1.0.0
		 * 
		 * @param   object|WP_Error $result Response object or WP_Error.
		 * @param   string          $action The type of information being requested from the Plugin Install API.
		 * @param   object          $args   Plugin API arguments.
		 *
		 * @return array Updated array of results.
		 */
		static function plugins_api_result( $result, $action, $args ) {

			/** Bail early if results are empty */
			if ( empty( $args->browse ) ) {
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

			/** Hook in our results */
			if ( 'featured' === $args->browse ) {

				$result->plugins = DDWlib_Plugin_Installer_Recommendations::get_plugins( 'featured' );

			} elseif ( 'recommended' === $args->browse ) {

				$result->plugins = DDWlib_Plugin_Installer_Recommendations::get_plugins( 'recommended' );

			} elseif ( 'popular' === $args->browse ) {

				$result->plugins = DDWlib_Plugin_Installer_Recommendations::get_plugins( 'popular' );

			}  // end if

			/** Finally, render the result of the Plugins API request */
			return $result;

		}  // end method


		/**
		 * Set needed default strings, make them filterable for plugins.
		 *
		 * @since  1.1.0
		 *
		 * @return array Filterable array of strings.
		 */
		static function get_strings() {

			return apply_filters(
				'ddwlib_plir/filter/strings/plugin_installer',
				array(
					'newest'  => 'Newest',
					'version' => 'Version',
				)
			);

		}  // end method


		/**
		 * Plugin installer: re-add (originally) hidden tab "Newest" back to the
		 *   stack.
		 *   Note: The render function for the tab is still part of WordPress
		 *         Core!
		 *
		 * @since  1.1.0
		 *
		 * @param  array $tabs Array of plugin installer tabs.
		 * @return array Tweaked array of tabs for plugin installer toolbar.
		 */
		static function plugin_installer_tweak_tabs( $tabs ) {

			/** Bail early if plugin "Cleaner Plugin Installer" is active */
			if ( defined( 'CLPINST_PLUGIN_VERSION' ) ) {
				return $tabs;
			}

			/** Get array of label strings */
			$labels = DDWlib_Plugin_Installer_Recommendations::get_strings();

			/** Re-enable hidden tab from core */
			$tabs[ 'new' ] = esc_attr( $labels[ 'newest' ] );

			/** Return tweaked tabs array */
			return $tabs;

		}  // end method


		/**
		 * Add plugin version to plugin card overview.
		 *
		 * @since  1.1.0
		 *
		 * @param  array $action_links Collected action links in plugin card.
		 * @param  array $plugin       Values from Plugins API for each plugin.
		 * @return array $action_links Array of tweaked action links in plugin
		 *                             card.
		 */
		static function plugin_install_action_links( $action_links, $plugin ) {

			/** Bail early if plugin "Cleaner Plugin Installer" is active */
			if ( defined( 'CLPINST_PLUGIN_VERSION' ) ) {
				return;
			}

			/** Get array of label strings */
			$labels = DDWlib_Plugin_Installer_Recommendations::get_strings();

			/** Add to the action links */
			$action_links[] = sprintf(
				'<div><small>%s %s</small></div>',
				esc_attr( $labels[ 'version' ] ),
				wp_kses_data( $plugin[ 'version' ] )
			);

			/** Render output */
			return $action_links;

		}  // end method


		/**
		 * Add (CSS inline) style tweaks to the following areas:
		 *   - Plugin cards (plugin installer results)
		 *   - Plugin uploader
		 *   - Theme uploader
		 *
		 * @since 1.1.0
		 * @since 1.2.0 Added more styles for plugin cards. Dark mode support.
		 */
		static function installer_styles() {

			/** Bail early if no styles wanted */
			if ( apply_filters( 'ddwlib_plir/filter/remove_installer_styles', FALSE ) ) {
				return;
			}

			/** Add CSS inline styles */
			?>
				<style type="text/css">
					/** Plugin cards */
					.plugin-card:hover {
						background: #ffffd9;
						border: 1px solid #bbb;
					}
					.plugin-card-bottom {
						background: #f2f2f2;
					}
					.plugin-card:hover > .plugin-card-bottom {
						background: #e1e1e1;
					}
					.plugin-install-php .tablenav .tablenav-pages {
						margin-top: 15px;
						margin-bottom: 15px;
					}
					.plugin-action-buttons div small {
						margin-left: 10px;
					}

					.dark-mode .plugin-card:hover {
						background: #404C58 !important;
						border-color: #090909 !important;
					}
					.dark-mode .plugin-card:hover > .plugin-card-bottom {
						background: #111921 !important;
					}
					.dark-mode .plugin-action-buttons div small {
						color: #bbc8d4;
					}

					/** Plugin cards: buttons */
					#wpwrap .plugin-action-buttons .button-disabled {
						background-color: #d9edc2 !important;
						border-color: #b2ce96 !important;
						color: #555 !important;
					}
					.plugin-action-buttons .update-now,
					.plugin-action-buttons .install-now.updating-message {
						background-color: #fef5c4;
					}
					.plugin-action-buttons .activate-now,
					.plugin-action-buttons .activate-now:focus,
					.dark-mode .plugin-action-buttons .activate-now,
					.dark-mode .plugin-action-buttons .activate-now:focus {
						background-color: #e2e2f9;
						border-color: #bebde9;
						color: #333;
					}
					.plugin-action-buttons a.activate-now:before {
						color: #999;  /* #f56e28; */
						content: "\f106";
						display: inline-block;
						font: 400 20px/1 dashicons;
						margin: 3px 5px 0 -2px;
						speak: none;
						-webkit-font-smoothing: antialiased;
						-moz-osx-font-smoothing: grayscale;
						vertical-align: top;
					}

					/** Plugin cards: compatibility */
					.plugin-card .compatibility-compatible:before,
					.plugin-card .compatibility-compatible strong {
						color: #0b0 !important;
					}
					.plugin-card .compatibility-incompatible:before,
					.plugin-card .compatibility-incompatible strong {
						color: #f00 !important;
					}

					/** Plugin & Theme uploaders */
					.upload-plugin .wp-upload-form,
					.upload-theme .wp-upload-form {
    					padding: 20px;
    					margin: 20px auto;
    					max-width: 80%;
    					text-align: center;
					}
					input#pluginzip,
					input#themezip {
					    background-color: #ffffe8;
					    border: 4px dashed #b4b9be;
					    display: inline-block;
					    font-size: 135%;
					    padding: 20px;
					    width: 100% !important;
					}
					input#pluginzip:hover,
					input#themezip:hover {
					    background-color: #ffffd9;
					}
					input#install-plugin-submit,
					input#install-theme-submit {
						display: inline-block;
						font-size: 120%;
						margin-top: 20px;
					}
					.dark-mode input#pluginzip,
					.dark-mode input#themezip {
						background-color: #404C58;
						border-color: #23282d;
					}
					.dark-mode input#pluginzip:hover,
					.dark-mode input#themezip:hover {
					    background-color: #50626f;
					}
				</style>
			<?php

		}  // end method

	}  // end of class


	/**
	 * If not already, instantiate the class now.
	 *
	 * @since 1.0.0
	 */
	if ( ! function_exists( 'ddwlib_plir_admin_init' ) ) :

		add_action( 'admin_init', 'ddwlib_plir_admin_init', 15 );
		/**
		 * Finally, run the class.
		 *
		 * @since 1.0.0
		 *
		 * @uses  DDWlib_Plugin_Installer_Recommendations()
		 */
		function ddwlib_plir_admin_init() {

			/** Bail early if user has no permission */
			if ( ! current_user_can( 'install_plugins' ) ) {
				return;
			}

			/** Instantiate the main class */
			new DDWlib_Plugin_Installer_Recommendations();

		}  // end function

	endif;  // class instantiation

endif;  // DDWlib_Plugin_Installer_Recommendations() check