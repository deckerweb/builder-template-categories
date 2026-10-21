<?php
/** Native GitHub updates with host-owned package identity checks. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'init', 'ddw_btc_register_updater', 20 );
add_filter( 'upgrader_source_selection', 'ddw_btc_validate_update_source', 30, 4 );

/**
 * Register one shared updater with translated messages and optional catalog approval.
 *
 * @since 1.9.1
 * @return void
 */
function ddw_btc_register_updater() {
	if ( ! class_exists( '\Deckerweb\GitHubReleaseUpdater\V2\Updater' ) ) {
		require_once __DIR__ . '/deckerweb-github-release-updater-v2.php';
	}
	if ( ! defined( '\Deckerweb\GitHubReleaseUpdater\V2\Updater::SUPPORTS_HOST_TRANSLATIONS' ) || ! defined( '\Deckerweb\GitHubReleaseUpdater\V2\Updater::SUPPORTS_CATALOG_PROVIDER' ) ) {
		add_action( 'admin_notices', 'ddw_btc_updater_notice' );
		add_action( 'network_admin_notices', 'ddw_btc_updater_notice' );
		return;
	}
	$repository = 'https://github.com/deckerweb/builder-template-categories';
	$options = deckerweb_library_updater_options_v1( BTC_PLUGIN_FILE, $repository );
	$options['translate'] = require __DIR__ . '/updater-translations.php';
	try {
		$updater = new \Deckerweb\GitHubReleaseUpdater\V2\Updater(
			BTC_PLUGIN_FILE,
			$repository,
			'Builder Template Categories',
			__( 'Organize WordPress patterns and the template libraries of supported builders and themes with shared categories.', 'builder-template-categories' ),
			array( 'icons' => array( '1x' => plugins_url( 'assets/icon-128x128.png', BTC_PLUGIN_FILE ), '2x' => plugins_url( 'assets/icon-256x256.png', BTC_PLUGIN_FILE ) ) ),
			$options
		);
		$updater->register();
	} catch ( \InvalidArgumentException $error ) {
		add_action( 'admin_notices', 'ddw_btc_updater_notice' );
		add_action( 'network_admin_notices', 'ddw_btc_updater_notice' );
	}
}

/**
 * Explain a shared engine conflict only on update-related screens to authorized users.
 *
 * @since 1.9.1
 * @return void
 */
function ddw_btc_updater_notice() {
	$screen = get_current_screen();
	if ( current_user_can( 'update_plugins' ) && $screen && in_array( $screen->base, array( 'plugins', 'update-core', 'update' ), true ) ) {
		echo '<div class="notice notice-warning"><p>' . esc_html__( 'Builder Template Categories requires a newer shared deckerweb Updater. Please update the other deckerweb plugins.', 'builder-template-categories' ) . '</p></div>';
	}
}

/**
 * Reject wrong identity, version or requirements before replacing this installed plugin.
 *
 * @since 1.9.1
 * @param string|WP_Error $source Normalized extracted directory or prior error.
 * @param string         $remote_source Parent extraction directory supplied by Core.
 * @param object         $upgrader Calling Core upgrader.
 * @param array          $context Update metadata, including native bulk per-item metadata.
 * @return string|WP_Error Verified source directory or a localized rejection.
 */
function ddw_btc_validate_update_source( $source, $remote_source, $upgrader, $context ) {
	$basename = plugin_basename( BTC_PLUGIN_FILE );
	if ( is_wp_error( $source ) || ( $context['plugin'] ?? '' ) !== $basename ) {
		return $source;
	}
	if ( ( isset( $context['type'] ) && 'plugin' !== $context['type'] ) || ( isset( $context['action'] ) && 'update' !== $context['action'] ) ) {
		return $source;
	}
	$bulk = $upgrader instanceof Plugin_Upgrader && true === $upgrader->bulk;
	if ( ! $bulk && ( ( $context['type'] ?? '' ) !== 'plugin' || ( $context['action'] ?? '' ) !== 'update' ) ) {
		return $source;
	}
	global $wp_filesystem, $wp_version;
	$invalid = new WP_Error( 'btc_invalid_update', __( 'The update package could not be verified. The installed version has been preserved.', 'builder-template-categories' ) );
	$main = trailingslashit( $source ) . 'builder-template-categories.php';
	if ( ! $wp_filesystem || ! $wp_filesystem->is_file( $main ) || $wp_filesystem->size( $main ) > 65536 || is_link( $main ) ) {
		return $invalid;
	}
	$text = $wp_filesystem->get_contents( $main );
	if ( ! is_string( $text ) ) {
		return $invalid;
	}
	$headers = array();
	foreach ( array( 'Plugin Name', 'Text Domain', 'Update URI', 'Version', 'Requires at least', 'Requires PHP' ) as $key ) {
		preg_match( '/^[ \t\/*#@]*' . preg_quote( $key, '/' ) . ':\s*(.+)$/mi', substr( $text, 0, 8192 ), $match );
		$headers[$key] = trim( $match[1] ?? '' );
	}
	$updates = get_site_transient( 'update_plugins' );
	$offer = is_object( $updates ) ? ( $updates->response[$basename] ?? null ) : null;
	if ( 'Builder Template Categories' !== $headers['Plugin Name'] || 'builder-template-categories' !== $headers['Text Domain'] || 'https://github.com/deckerweb/builder-template-categories' !== $headers['Update URI'] || ! is_object( $offer ) || $headers['Version'] !== ( $offer->new_version ?? '' ) || ! preg_match( '/^\d+\.\d+\.\d+$/D', $headers['Version'] ) || ! version_compare( $headers['Version'], BTC_PLUGIN_VERSION, '>' ) ) {
		return $invalid;
	}
	foreach ( array( 'Requires at least' => $wp_version, 'Requires PHP' => PHP_VERSION ) as $key => $installed ) {
		if ( ! preg_match( '/^\d+\.\d+(?:\.\d+)?$/D', $headers[$key] ) || version_compare( $installed, $headers[$key], '<' ) ) {
			return $invalid;
		}
	}
	return $source;
}
