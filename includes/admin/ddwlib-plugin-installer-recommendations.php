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
 * @license http://www.gnu.org/licenses GNU General Public License
 * @version 1.0.0
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
		 */
		public function __construct() {

			add_filter(
				'plugins_api_result',
				array( 'DDWlib_Plugin_Installer_Recommendations', 'plugins_api_result' ),
				11,
				3
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

			/** Set array */
			$get_plugins = array();

			/** Loop through plugin data arguments */
			foreach ( $plugins as $plugin_slug => $plugin_data ) {

				if ( 'yes' === $plugin_data[ sanitize_key( $tab ) ] ) {

					$get_plugins[ sanitize_key( $plugin_slug ) ] = plugins_api(
						'plugin_information',
						array(
							'slug'   => sanitize_key( $plugin_slug ),
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