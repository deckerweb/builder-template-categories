<?php
/** Shared uninstall protocol 3, with a protocol-2 compatibility entry point. No activation is needed to detect installed hosts.
 * Copyright 2026 David Decker – DECKERWEB. SPDX-License-Identifier: GPL-2.0-or-later
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! function_exists( 'deckerweb_library_uninstall_v3' ) ) {
 /**
  * Clean component-owned temporary data only after the final installed host is removed.
  *
  * @param string $host_file Absolute host main-file path matching WP_UNINSTALL_PLUGIN.
  * @return bool True when last-host cleanup completes; false when ownership or remaining hosts prevent cleanup.
  * May read or change component-owned shared storage; foreign plugin data is preserved.
  * Queues a final ownership recheck after native batch deletion completes.
  */
 function deckerweb_library_uninstall_v3( string $host_file ): bool {
  if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) { return false; }
  // Core may process several uninstall.php files in one request while retaining
  // the first WP_UNINSTALL_PLUGIN constant. Recheck final ownership at shutdown.
  static $final_check_queued = false;
  if ( ! $final_check_queued && is_file( dirname( $host_file ) . '/uninstall.php' ) && is_file( dirname( $host_file ) . '/includes/deckerweb-plugin-library/bootstrap.php' ) ) {
   $final_check_queued = true;
   $first_host = WP_PLUGIN_DIR . '/' . WP_UNINSTALL_PLUGIN;
   /**
    * Recheck shared ownership after native deletion finishes its full batch.
    * @return void Runs guarded cleanup; installed hosts still protect shared data.
    */
   register_shutdown_function( static function() use ( $first_host ): void { deckerweb_library_uninstall_v3( $first_host ); } );
  }
  if ( plugin_basename( $host_file ) !== WP_UNINSTALL_PLUGIN ) { return false; }
  require_once ABSPATH . 'wp-admin/includes/plugin.php';
  wp_clean_plugins_cache( false );
  $current = plugin_basename( $host_file );
  foreach ( get_plugins() as $file => $info ) {
   if ( $file === $current ) { continue; }
   $dir = dirname( WP_PLUGIN_DIR . '/' . $file );
   // Conservative detection supports old copies without an ownership marker.
   if ( is_file( $dir . '/includes/deckerweb-plugin-library/bootstrap.php' ) || is_file( $dir . '/deckerweb-plugin-library/bootstrap.php' ) ) { return false; }
  }
  global $wpdb;
  // Remove abandoned component action locks only after the final host is uninstalled.
  $lock_blog = is_multisite() ? get_main_site_id( get_main_network_id() ) : get_current_blog_id();
  $switched = $lock_blog !== get_current_blog_id();
  if ( $switched ) { switch_to_blog( $lock_blog ); }
  $lock_names = $wpdb->get_col( $wpdb->prepare( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s", $wpdb->esc_like( 'dwl_inline_lock_' ) . '%' ) );
  foreach ( $lock_names as $name ) { if ( preg_match( '/^dwl_inline_lock_[a-z0-9-]+$/D', $name ) ) { delete_option( $name ); } }
  if ( $switched ) { restore_current_blog(); }
  $networks = is_multisite() ? get_networks( [ 'fields' => 'ids', 'number' => 0 ] ) : [ null ];
  $delete_intro = false;
  $all_networks_delete = true;
  $temporary = [];
  foreach ( $networks as $network_id ) {
   $settings = is_multisite() ? get_network_option( $network_id, 'deckerweb_library_settings_v1', [] ) : get_option( 'deckerweb_library_settings_v1', [] );
   $delete = is_array( $settings ) && ! empty( $settings['delete_settings'] );
   if ( ! $delete ) { $all_networks_delete = false; }
   $temps = is_multisite() ? get_network_option( $network_id, 'deckerweb_library_temp_v2', [] ) : get_option( 'deckerweb_library_temp_v2', [] );
   if ( is_array( $temps ) ) { $temporary = array_merge( $temporary, $temps ); }
   if ( is_multisite() ) { delete_network_option( $network_id, 'deckerweb_library_temp_v2' ); } else { delete_option( 'deckerweb_library_temp_v2' ); }
   // Delete only the component's documented catalog-transient namespace.
   if ( is_multisite() ) {
    $names = $wpdb->get_col( $wpdb->prepare( "SELECT meta_key FROM {$wpdb->sitemeta} WHERE site_id = %d AND (meta_key LIKE %s OR meta_key LIKE %s)", $network_id, $wpdb->esc_like( '_site_transient_dwl_catalog_' ) . '%', $wpdb->esc_like( '_site_transient_timeout_dwl_catalog_' ) . '%' ) );
   } else {
    $names = $wpdb->get_col( $wpdb->prepare( "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s", $wpdb->esc_like( '_site_transient_dwl_catalog_' ) . '%', $wpdb->esc_like( '_site_transient_timeout_dwl_catalog_' ) . '%' ) );
   }
   foreach ( $names as $name ) {
    if ( ! preg_match( '/^_site_transient_(?:timeout_)?dwl_catalog_[a-f0-9]{32}(?:_061)?(?:_updates)?(?:_last|_retry)?$/D', $name ) ) { continue; }
    if ( is_multisite() ) { delete_network_option( $network_id, $name ); } else { delete_option( $name ); }
   }
   // Remove known keys from persistent object caches as well as database storage.
   $urls = is_multisite() ? get_network_option( $network_id, 'deckerweb_library_cache_keys_v2', [] ) : get_option( 'deckerweb_library_cache_keys_v2', [] );
   $urls = is_array( $urls ) ? $urls : [];
   if ( ! empty( $settings['catalog_url'] ) && is_string( $settings['catalog_url'] ) ) { $urls[] = 'dwl_catalog_' . md5( $settings['catalog_url'] ); }
   foreach ( $urls as $key ) {
    if ( ! is_string( $key ) || ! preg_match( '/^dwl_catalog_[a-f0-9]{32}(?:_061)?$/D', $key ) ) { continue; }
    // Cover both generations even when only a legacy base survived in the registry.
    $base = preg_replace( '/_061$/D', '', $key );
    foreach ( [ $base, $base . '_061' ] as $generation ) {
     foreach ( [ '', '_last', '_retry', '_updates', '_updates_last', '_updates_retry' ] as $suffix ) { wp_cache_delete( $generation . $suffix, 'site-transient' ); }
    }
   }
   if ( is_multisite() ) { delete_network_option( $network_id, 'deckerweb_library_cache_keys_v2' ); }
   else { delete_option( 'deckerweb_library_cache_keys_v2' ); }
   if ( $delete ) {
    foreach ( [ 'deckerweb_library_settings_v1', 'deckerweb_library_installed_v1' ] as $key ) {
     if ( is_multisite() ) { delete_network_option( $network_id, $key ); } else { delete_option( $key ); }
    }
    $delete_intro = true;
   }
  }
  // User introduction status is global: retain unless all networks requested deletion.
  if ( $delete_intro ) {
   foreach ( $networks as $network_id ) {
    $remaining = is_multisite() ? get_network_option( $network_id, 'deckerweb_library_settings_v1', false ) : get_option( 'deckerweb_library_settings_v1', false );
    if ( $remaining !== false ) { $delete_intro = false; break; }
   }
  }
  if ( $delete_intro && $all_networks_delete ) { delete_metadata( 'user', 0, 'deckerweb_library_intro_seen_v1', '', true ); delete_metadata( 'user', 0, 'deckerweb_library_view_v1', '', true ); delete_metadata( 'user', 0, 'deckerweb_git_updater_notice_v1', '', true ); }
  // Package staging is cleaned immediately; only tracked crash leftovers are removed.
  $temp_registry = array_unique( array_filter( $temporary, 'is_string' ) );
  foreach ( is_array( $temp_registry ) ? $temp_registry : [] as $path ) {
   $base = realpath( get_temp_dir() ); $real = is_string( $path ) ? realpath( $path ) : false;
   if ( ! $base || ! $real || dirname( $real ) !== $base || ! preg_match( '/^dwl-[a-zA-Z0-9_.-]+$/D', basename( $real ) ) ) { continue; }
   if ( is_dir( $real ) ) { foreach ( glob( $real . '/*' ) ?: [] as $part ) { if ( is_file( $part ) && ! is_link( $part ) ) { wp_delete_file( $part ); } } rmdir( $real ); }
   elseif ( is_file( $real ) && ! is_link( $path ) ) { wp_delete_file( $real ); }
  }
  return true;
 }
}

if ( ! function_exists( 'deckerweb_library_uninstall_v2' ) ) {
 /**
  * Delegate protocol-two hosts to current cleanup when no earlier copy owns the alias.
  *
  * @param string $host_file Absolute main-file path matching WP_UNINSTALL_PLUGIN.
  * @return bool Whether final-host cleanup was performed; retained hosts/data return false.
  */
 function deckerweb_library_uninstall_v2( string $host_file ): bool {
  return deckerweb_library_uninstall_v3( $host_file );
 }
}
