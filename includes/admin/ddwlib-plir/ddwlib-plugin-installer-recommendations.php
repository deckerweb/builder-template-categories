<?php

/**
 * DDWlib Plugin Installer Recommendations
 *
 * Copyright (C) 2018-2019 David Decker - DECKERWEB <https://deckerweb.de>
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
 * @license http://www.gnu.org/licenses GNU General Public License
 * @version 1.4.1
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
		 * Class version.
		 *
		 * @access private
		 *
		 * @since 1.3.0
		 */
		private static $version = '1.4.0';


		/**
		 * Constructor. Hooks all interactions into correct areas to start the class.
		 *
		 * @since 1.0.0
		 * @since 1.1.0 Added two more filter functions, plus two more actions.
		 */
		public function __construct() {

			/** Tabs: Re-add hidden "Newest" / Add deckerweb Plugins tab */
			add_filter( 'install_plugins_tabs', array( 'DDWlib_Plugin_Installer_Recommendations', 'plugin_installer_tweak_tabs' ), 5, 1 );

			/** Add version number to plugin cards */
			add_filter( 'plugin_install_action_links', array( 'DDWlib_Plugin_Installer_Recommendations', 'plugin_install_action_links' ), 10, 2 );

			/** Filter Plugins API results (the main purpose!) */
			add_filter( 'plugins_api_result', array( 'DDWlib_Plugin_Installer_Recommendations', 'plugins_api_result' ), 11, 3 );


			/** Deckerweb Plugins tab (Installer page) */
			add_filter( 'install_plugins_table_api_args_ddwplugins', array( 'DDWlib_Plugin_Installer_Recommendations', 'install_plugins_table_api_args_ddwplugins' ), 1 );
			add_action( 'install_plugins_ddwplugins', array( 'DDWlib_Plugin_Installer_Recommendations', 'install_plugins_ddwplugins' ) );


			/** Style tweaks for Plugin & Theme Installer */
			add_action( 'admin_enqueue_scripts', array( 'DDWlib_Plugin_Installer_Recommendations', 'register_styles' ) );
			add_action( 'admin_head-plugin-install.php', array( 'DDWlib_Plugin_Installer_Recommendations', 'installer_styles' ), 15 );
			add_action( 'admin_head-theme-install.php', array( 'DDWlib_Plugin_Installer_Recommendations', 'installer_styles' ), 15 );


			/** Deckerweb Plugins view on Plugins page */
			add_filter( 'show_advanced_plugins', array( 'DDWlib_Plugin_Installer_Recommendations', 'filter_ddwplugins' ), 100 );
			add_filter( 'show_network_active_plugins', array( 'DDWlib_Plugin_Installer_Recommendations', 'filter_ddwplugins' ), 100 );

			add_action( 'check_admin_referer', array( 'DDWlib_Plugin_Installer_Recommendations', 'filter_ddwplugins_referer' ), 10, 2 );

			add_filter( 'views_plugins', array( 'DDWlib_Plugin_Installer_Recommendations', 'plugins_view_ddwplugins' ) );
			add_filter( 'views_plugins-network', array( 'DDWlib_Plugin_Installer_Recommendations', 'plugins_view_ddwplugins' ) );

			add_filter( 'all_plugins', array( 'DDWlib_Plugin_Installer_Recommendations', 'prepare_plugins_view_ddwplugins' ) );

		}  // end method


		/**
		 * Define the query fields to be used for the API request.
		 *
		 * @since 1.0.0
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
		 * @since 1.0.0
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
		 * @since 1.0.0
		 *
		 * @param string $tab The tab of the plugin installer (as array key).
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
		 * @since 1.0.0
		 * 
		 * @param object|WP_Error $result Response object or WP_Error.
		 * @param string          $action The type of information being requested from the Plugin Install API.
		 * @param object          $args   Plugin API arguments.
		 * @return object|WP_Error Updated object (array) of results.
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
		 * @since 1.1.0
		 *
		 * @return array Filterable array of strings.
		 */
		static function get_strings() {

			return apply_filters(
				'ddwlib_plir/filter/strings/plugin_installer',
				array(
					'newest'         => 'Newest',
					'version'        => 'Version',
					'ddwplugins_tab' => 'deckerweb Plugins',
					'tab_title'      => 'deckerweb Plugins',
					'tab_slogan'     => 'Great helper tools for Site Builders to save time and get more productive',
					'tab_info'       => sprintf(
						'You can use any of our free plugins or premium plugins from %s',
						'<a href="https://deckerweb-plugins.com/" target="_blank" rel="nofollow noopener noreferrer">deckerweb Plugins</a>'
					),
					'tab_newsletter' => 'Join our newsletter',
					'tab_fbgroup'    => 'Facebook User Group',
					'plugins_view'   => 'deckerweb',
				)
			);

		}  // end method


		/**
		 * Plugin installer: re-add (originally) hidden tab "Newest" back to the
		 *   stack.
		 *   Note: The render function for the tab is still part of WordPress
		 *         Core!
		 *
		 * @since 1.1.0
		 * @since 1.3.0 Added 'deckerweb Plugins' tab.
		 * @since 1.4.1 Added ClassicPress compat.
		 *
		 * @param array $tabs Array of plugin installer tabs.
		 * @return array Tweaked array of tabs for plugin installer toolbar.
		 */
		static function plugin_installer_tweak_tabs( $tabs ) {

			/** Get array of label strings */
			$labels = DDWlib_Plugin_Installer_Recommendations::get_strings();

			/** Re-enable hidden tab from core */
			if ( ! defined( 'CLPINST_PLUGIN_VERSION' ) && ! function_exists( 'classicpress_version' ) ) {
				$tabs[ 'new' ] = esc_attr( $labels[ 'newest' ] );
			}

			$tabs[ 'ddwplugins' ] = esc_attr( $labels[ 'ddwplugins_tab' ] );

			/** Return tweaked tabs array */
			return $tabs;

		}  // end method


		/**
		 * Add plugin version to plugin card overview.
		 *
		 * @since 1.1.0
		 *
		 * @param array $action_links Collected action links in plugin card.
		 * @param array $plugin       Values from Plugins API for each plugin.
		 * @return array $action_links Array of tweaked action links in plugin
		 *                             card.
		 */
		static function plugin_install_action_links( $action_links, $plugin ) {

			/** Bail early if plugin "Cleaner Plugin Installer" is active */
			if ( defined( 'CLPINST_PLUGIN_VERSION' ) ) {
				return $action_links;
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
		 * Get URI. - Helper method to get proper file path URI.
		 *
		 * @since 1.3.0
		 *
		 * @return mixed URL.
		 */
		public static function _get_uri() {

			$path       = wp_normalize_path( dirname( __FILE__ ) );
			$theme_dir  = wp_normalize_path( get_template_directory() );
			$plugin_dir = wp_normalize_path( WP_PLUGIN_DIR );

			if ( strpos( $path, $theme_dir ) !== FALSE ) {

				return trailingslashit( get_template_directory_uri() . str_replace( $theme_dir, '', $path ) );

			} elseif ( strpos( $path, $plugin_dir ) !== FALSE ) {

				return plugin_dir_url( __FILE__ );

			} elseif ( strpos( $path, dirname( plugin_basename( __FILE__ ) ) ) !== FALSE ) {

				return plugin_dir_url( __FILE__ );

			}  // end if

			return;

		}  // end method


		/**
		 * Set the API params for the installer tab 'ddwplugins'.
		 *
		 * @since 1.3.0
		 *
		 * @global string $paged
		 * @global string $tab
		 *
		 * @return array $args Modified array of arguments for this tab
		 *                     ('ddwplugins').
		 */
		static function install_plugins_table_api_args_ddwplugins() {

			global $paged, $tab;

			wp_reset_vars( array( 'tab' ) );

			$defined_class = new WP_Plugin_Install_List_Table();
			$paged         = $defined_class->get_pagenum();

			$per_page = 30;

			$args = array(
				'page'     => $paged,
				'per_page' => $per_page,
				'fields'   => array(
					'last_updated'    => TRUE,
					'icons'           => TRUE,
					'active_installs' => TRUE
				),

				// Send the locale and installed plugin slugs to the API so it can provide context-sensitive results.
				'locale'   => get_user_locale(),
			);

			/** Add author filter for our plugins */
			$args[ 'author' ] = 'wpautobahn';

			return $args;

		}  // end method


		/**
		 * Render the installer tab 'ddwplugins'.
		 *
		 * @since 1.3.0
		 *
		 * @global string $GLOBALS[ 'tab' ]
		 * @global object $GLOBALS[ 'wp_list_table' ]
		 */
		static function install_plugins_ddwplugins() {

			/** Get array of label strings */
			$labels = DDWlib_Plugin_Installer_Recommendations::get_strings();

			/** Build output */
			$output = sprintf(
				'<div class="ddwplugins-preface">
					<a href="https://deckerweb-plugins.com/" target="_blank" rel="nofollow noopener noreferrer">
						<img class="ddwplugins-logo" src="%1$s" width="%2$s" height="%2$s" alt="Logo deckerweb Plugins" />
					</a>
					<div class="ddwplugins-text">
						<h3>%3$s</h3>
						<h4>%4$s</h4>
						<p>%5$s</p>
						<p><a class="button" href="https://www.facebook.com/groups/deckerweb.wordpress.plugins/" target="_blank" rel="nofollow noopener noreferrer">%6$s</a> &nbsp; <a class="button" href="https://eepurl.com/gbAUUn" target="_blank" rel="nofollow noopener noreferrer">%7$s</a></p>
					</div>
				</div><div class="clear"></div>',
				self::_get_uri() . 'deckerweb-plugins-logo.png',	// 1
				'150',												// 2
				esc_attr( $labels[ 'ddwplugins_tab' ] ),			// 3
				esc_attr( $labels[ 'tab_slogan' ] ),				// 4
				wp_kses_post( $labels[ 'tab_info' ] ),				// 5
				esc_attr( $labels[ 'tab_fbgroup' ] ),				// 6
				esc_attr( $labels[ 'tab_newsletter' ] )				// 7
			);

			/** Render output */
			if ( 'ddwplugins' === $GLOBALS[ 'tab' ] && 'search' !== $GLOBALS[ 'tab' ] ) {

				echo $output;

			} else {

				echo '';

			}  // end if

			/** Render plugin list table form based on API args */
			?>
				<form id="plugin-filter" method="post">
					<?php $GLOBALS[ 'wp_list_table' ]->display(); ?>
				</form>
			<?php

		}  // end method


		/**
		 * Enqueue Scripts.
		 *
		 * @since 1.3.0
		 *
		 * @return void
		 */
		static function register_styles() {

			wp_register_style(
				'ddwlib-plir-styles',
				self::_get_uri() . 'ddwlib-plir-styles.css',
				array(),
				self::$version
			);

		}  // end method

		/**
		 * Add (CSS inline) style tweaks to the following areas:
		 *   - Plugin cards (plugin installer results)
		 *   - Plugin uploader
		 *   - Theme uploader
		 *
		 * @since 1.1.0
		 * @since 1.2.0 Added more styles for plugin cards. Dark mode support.
		 * @since 1.3.0 Moved CSS into own stylesheet. WP Enqueue declaration.
		 */
		static function installer_styles() {

			/** Bail early if no styles wanted */
			if ( apply_filters( 'ddwlib_plir/filter/remove_installer_styles', FALSE ) ) {
				return;
			}

			wp_enqueue_style( 'ddwlib-plir-styles' );

		}  // end method


		/**
		 * For new view on Plugins page create the filter logic - this will
		 *   group/show all plugins by deckerweb.
		 *
		 * @since 1.4.0
		 *
		 * @global object $plugins
		 *
		 * @param bool $plugin_menu Whether to show advanced menu or not.
		 * @return mixed
		 */
		static function filter_ddwplugins( $plugin_menu ) {

			global $plugins;

			if ( is_array( $plugins ) ) {

				foreach ( $plugins[ 'all' ] as $plugin_slug => $plugin_data ) {

					if ( FALSE !== strpos( $plugin_data[ 'AuthorName' ], 'David Decker' ) || FALSE !== strpos( $plugin_data[ 'AuthorName' ], 'DECKERWEB' ) ) {

						$plugins[ 'ddwplugins' ][ $plugin_slug ]             = $plugins[ 'all' ][ $plugin_slug ];
						$plugins[ 'ddwplugins' ][ $plugin_slug ][ 'plugin' ] = $plugin_slug;

						/** replicate the next step. */
						if ( current_user_can( 'update_plugins' ) ) {

							$current = get_site_transient( 'update_plugins' );

							if ( isset( $current->response[ $plugin_slug ] ) ) {
								$plugins[ 'ddwplugins' ][ $plugin_slug ][ 'update' ] = TRUE;
							}

						}  // end if user permission check

					}  // end if Plugin Name/Data check

				}  // end foreach

			}  // end if Array check

			return $plugin_menu;

		}  // end method


		/**
		 * Check for proper admin referer to only set "deckerweb" view if
		 *   conditions are met.
		 *
		 * @since 1.4.0
		 *
		 * @global string $status
		 *
		 * @param string    $action The nonce action.
		 * @param false|int $result Result of the nonce.
		 */
		static function filter_ddwplugins_referer( $action, $result ) {

			if ( ! function_exists( 'get_current_screen' ) ) {
				return;
			}

			$screen = get_current_screen();

			if ( is_object( $screen )
				&& 'plugins' === $screen->base
				&& ! empty( $_REQUEST[ 'plugin_status' ] ) && 'ddwplugins' === sanitize_key( wp_unslash( $_REQUEST[ 'plugin_status' ] ) )
			) {

				global $status;

				$status = 'ddwplugins';

			}  // end if

		}  // end method


		/**
		 * Make the "deckerweb" view as an default view (menu) and update the
		 *   view/menu name.
		 *
		 * @since 1.4.0
		 *
		 * @uses DDWlib_Plugin_Installer_Recommendations::get_strings()
		 *
		 * @param string[] $views Array that holds all views.
		 * @return mixed
		 */
		static function plugins_view_ddwplugins( $views ) {

			global $status, $plugins;

			if ( ! empty( $plugins[ 'ddwplugins' ] ) ) {

				$class = '';

				if ( 'ddwplugins' === $status ) {
					$class = 'current';
				}

				/** Get array of label strings */
				$labels = DDWlib_Plugin_Installer_Recommendations::get_strings();

				$views[ 'ddwplugins' ] = sprintf(
					'<a class="%s" href="plugins.php?plugin_status=ddwplugins"> %s <span class="count">(%s) </span></a>',
					$class,
					esc_attr( $labels[ 'plugins_view' ] ),	// "deckerweb"
					absint( count( $plugins[ 'ddwplugins' ] ) )
				);
			}

			return $views;

		}  // end method


		/**
		 * Set the "deckerweb" as the main view (menu) when admin click on the
		 *   "deckerweb" view on Plugins page.
		 *
		 * @since 1.4.0
		 *
		 * @global string $status
		 *
		 * @param array $plugins Array of plugins to display in the list table.
		 * @return mixed
		 */
		static function prepare_plugins_view_ddwplugins( $plugins ) {

			global $status;

			if ( isset( $_REQUEST[ 'plugin_status' ] ) && 'ddwplugins' === sanitize_key( wp_unslash( $_REQUEST[ 'plugin_status' ] ) ) ) {
				$status = 'ddwplugins';
			}

			return $plugins;

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
		 * @uses DDWlib_Plugin_Installer_Recommendations()
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
