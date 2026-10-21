<?php
/** Shared bootstrap protocol 2. Copyright 2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 * This bootstrap remains parseable on PHP 7.4; runtime requirements are checked before include.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! function_exists( 'deckerweb_library_bootstrap_text_v090' ) ) {
 /**
  * Translate an early fallback through an available host domain without loading a runtime.
  * @param string $message English source message.
  * @param array $candidates Registered host metadata in deterministic election order.
  * @return string Host translation or English when no usable domain/resource is available.
  * Loads only local component translation resources; never executes component PHP.
  */
 function deckerweb_library_bootstrap_text_v090( string $message, array $candidates ): string {
  foreach ( $candidates as $candidate ) {
   if ( ! is_string( $candidate['host'] ?? null ) || ! is_readable( $candidate['host'] ) ) { continue; }
   $headers = get_file_data( $candidate['host'], array( 'domain' => 'Text Domain' ) );
   $domain = $headers['domain'] ?? '';
   if ( ! is_string( $domain ) || ! preg_match( '/^[a-z0-9-]+$/D', $domain ) ) { continue; }
   $locale = determine_locale();
   if ( in_array( $locale, array( 'de_DE', 'de_DE_formal' ), true ) && is_string( $candidate['dir'] ?? null ) ) {
    $resource = $candidate['dir'] . '/languages/' . $locale . '.mo';
    if ( is_readable( $resource ) ) { load_textdomain( $domain, $resource, $locale ); }
   }
   return translate( $message, $domain );
  }
  return $message;
 }
}

if ( ! function_exists( 'deckerweb_library_register_v2' ) ) {
 /**
  * Register a runtime candidate without executing its version file.
  *
  * @param string $plugin_file Absolute host main-file path.
  * @param array $config Optional host integration configuration.
  * @param string|null $library_dir Absolute embedded directory, or null for this bootstrap directory.
  * @return void No return value.
  */
 function deckerweb_library_register_v2( string $plugin_file, array $config = [], ?string $library_dir = null ): void {
  $library_dir = $library_dir ?: __DIR__;
  $manifest = $library_dir . '/compatibility.json';
  if ( is_readable( $manifest ) ) {
   $data = json_decode( (string) file_get_contents( $manifest ), true );
   $version = is_array( $data ) ? ( $data['version'] ?? '' ) : '';
  } else {
   $file = $library_dir . '/version.php';
   $text = is_readable( $file ) ? file_get_contents( $file, false, null, 0, 8192 ) : '';
   $version = preg_match( "/return\\s+'([0-9]+\\.[0-9]+\\.[0-9]+)'\\s*;/", (string) $text, $match ) ? $match[1] : '';
  }
  if ( ! is_string( $version ) || ! preg_match( '/^\d+\.\d+\.\d+$/D', $version ) ) { $GLOBALS['deckerweb_library_invalid_hosts_v2'] = true; return; }
  $GLOBALS['deckerweb_library_candidates_v1'][] = [ 'version' => $version, 'dir' => $library_dir, 'host' => $plugin_file, 'config' => $config ];
 }
}
if ( ! function_exists( 'deckerweb_library_register' ) ) {
 /**
  * Delegate legacy registration to protocol two when no older function owns it.
  *
  * @param string $plugin_file Absolute host main-file path.
  * @param array $config Optional host integration configuration.
  * @param string|null $library_dir Absolute embedded directory, or null for this bootstrap directory.
  * @return void No return value.
  */
 function deckerweb_library_register( string $plugin_file, array $config = [], ?string $library_dir = null ): void {
  deckerweb_library_register_v2( $plugin_file, $config, $library_dir );
 }
}
if ( ! function_exists( 'deckerweb_library_elect_v090' ) ) {
 /**
  * Elect the highest compatible complete runtime before legacy election executes.
  *
  * @return void No return value.
  */
 function deckerweb_library_elect_v090(): void {
  remove_action( 'plugins_loaded', 'deckerweb_library_elect_v1', PHP_INT_MAX );
  remove_action( 'plugins_loaded', 'deckerweb_library_elect_v2', PHP_INT_MAX - 1 );
  if ( ! empty( $GLOBALS['deckerweb_library_runtime_v1'] ) ) { return; }
  if ( ! is_admin() && ! wp_doing_cron() && ! ( defined( 'WP_CLI' ) && WP_CLI ) ) { return; }
  global $wp_version;
  $candidates = $GLOBALS['deckerweb_library_candidates_v1'] ?? [];
  /**
   * Order candidates by descending component version and deterministic host tie-break.
   * @param array $a First registered candidate.
   * @param array $b Second registered candidate.
   * @return int Negative when a precedes b, positive when b precedes a, zero when equal.
   */
  usort( $candidates, static function( array $a, array $b ): int {
   $comparison = version_compare( $b['version'], $a['version'] );
   return $comparison ?: strcmp( $a['host'], $b['host'] );
  } );
  foreach ( $candidates as $candidate ) {
   $manifest_file = $candidate['dir'] . '/compatibility.json';
   $manifest = is_file( $manifest_file ) ? json_decode( (string) file_get_contents( $manifest_file ), true ) : null;
   // Legacy 0.1–0.3 copies have the documented PHP 8 / WP 6.4 baseline.
   if ( ! $manifest && in_array( $candidate['version'], [ '0.1.0', '0.2.0', '0.3.0' ], true ) ) { $manifest = [ 'version' => $candidate['version'], 'protocol' => 1, 'requires_php' => '8.0', 'requires_wp' => '6.4', 'files' => [ 'runtime.php', 'src/Catalog.php', 'src/Requirements.php', 'src/Package.php', 'src/Library.php', 'catalog.json' ] ]; }
   if ( ! is_array( $manifest ) || ( $manifest['version'] ?? '' ) !== $candidate['version'] || ! in_array( $manifest['protocol'] ?? 0, [ 1, 2 ], true ) || ! is_array( $manifest['files'] ?? null ) ) { continue; }
   if ( ! preg_match( '/^\d+\.\d+(?:\.\d+)?$/D', $manifest['requires_php'] ?? '' ) || ! preg_match( '/^\d+\.\d+(?:\.\d+)?$/D', $manifest['requires_wp'] ?? '' ) || version_compare( PHP_VERSION, $manifest['requires_php'], '<' ) || version_compare( $wp_version, $manifest['requires_wp'], '<' ) ) { continue; }
   $complete = true;
   foreach ( $manifest['files'] as $file ) { if ( ! is_string( $file ) || strpos( $file, '..' ) !== false || ! preg_match( '~^[a-zA-Z0-9_/.-]+$~D', $file ) || ! is_file( $candidate['dir'] . '/' . $file ) || ! is_readable( $candidate['dir'] . '/' . $file ) ) { $complete = false; break; } }
   if ( ! $complete || ! is_file( $candidate['dir'] . '/runtime.php' ) ) { continue; }
   if ( $manifest['protocol'] === 2 ) {
    if ( ! is_array( $manifest['hashes'] ?? null ) ) { continue; }
    foreach ( $manifest['files'] as $file ) {
     $expected = $manifest['hashes'][$file] ?? '';
     if ( ! is_string( $expected ) || ! preg_match( '/^[a-f0-9]{64}$/D', $expected ) || ! hash_equals( $expected, (string) hash_file( 'sha256', $candidate['dir'] . '/' . $file ) ) ) { $complete = false; break; }
    }
    if ( ! $complete ) { continue; }
   }
   try {
    $factory = require $candidate['dir'] . '/runtime.php';
    if ( ! is_callable( $factory ) ) { break; }
    $GLOBALS['deckerweb_library_runtime_v1'] = $factory( $candidate, $candidates );
    return;
   } catch ( \Throwable $error ) { /* A partial include cannot safely retry the same namespace. */ break; }
  }
  if ( $candidates || ! empty( $GLOBALS['deckerweb_library_invalid_hosts_v2'] ) ) {
   /**
    * Render a localized compatibility notice for administrators allowed to install plugins.
    * @return void Outputs escaped markup; does not change plugin state.
    */
   $notice = static function() use ( $candidates ): void {
    if ( ! current_user_can( 'install_plugins' ) ) { return; }
    echo '<div class="notice notice-warning"><p>' . esc_html( deckerweb_library_bootstrap_text_v090( 'The deckerweb catalog could not load. Check platform requirements and the complete Library integration in the host plugin.', $candidates ) ) . '</p></div>';
   };
   add_action( 'admin_notices', $notice ); add_action( 'network_admin_notices', $notice );
  }
 }
}
// Earlier priority prevents a legacy callback from selecting an incompatible copy.
add_action( 'plugins_loaded', 'deckerweb_library_elect_v090', PHP_INT_MAX - 2 );

if ( ! function_exists( 'deckerweb_library_updater_options_v1' ) ) {
 /**
  * Provide lazy public catalog callbacks without changing host updater ownership.
  *
  * @param string $plugin_file Absolute host main-file path.
  * @param string $repository Exact public GitHub repository URL.
  * @return array Lazy release/package provider callbacks for the exact public host identity.
  */
 function deckerweb_library_updater_options_v1( string $plugin_file, string $repository ): array {
  $file = plugin_basename( $plugin_file );
  return [
   /**
    * Read approved metadata only for the configured public host identity.
    * @param string $repo Requested repository URL.
    * @param string $basename Requested plugin basename.
    * @param bool $fresh Require an uncached approval.
    * @return array|false|null Metadata, direct-mode fallback, or refused approval.
    */
   'release_provider' => static function( string $repo, string $basename, bool $fresh = false ) use ( $repository, $file ) {
    $runtime = $GLOBALS['deckerweb_library_runtime_v1'] ?? null;
    if ( $repo !== $repository || $basename !== $file ) { return null; }
    return is_object( $runtime ) && method_exists( $runtime, 'updater_release' ) ? $runtime->updater_release( $repo, $basename, $fresh ) : false;
   },
   /**
    * Verify an offered package for the configured public host identity.
    * @param string $repo Requested repository URL.
    * @param string $basename Requested plugin basename.
    * @param string $package Offered public ZIP URL.
    * @return string|\WP_Error Owned verified archive path or controlled failure.
    */
   'package_provider' => static function( string $repo, string $basename, string $package ) use ( $repository, $file ) {
    $runtime = $GLOBALS['deckerweb_library_runtime_v1'] ?? null;
    if ( $repo !== $repository || $basename !== $file || ! is_object( $runtime ) || ! method_exists( $runtime, 'updater_package' ) ) { return new \WP_Error( 'dwl_offline', deckerweb_library_bootstrap_text_v090( 'The approved package could not be verified.', $GLOBALS['deckerweb_library_candidates_v1'] ?? array() ) ); }
    return $runtime->updater_package( $repo, $basename, $package );
   },
  ];
 }
}

if ( ! function_exists( 'deckerweb_library_activation_handoff_v3' ) ) {
 /**
  * Elect a newer verified target-host runtime before its native activation guard runs.
  *
  * Reads registered candidates and their compatibility manifests and file hashes.
  * If no runtime exists, runs the normal election. A successful handoff loads the
  * target factory, removes callbacks owned by the previous Library object and
  * replaces the shared runtime global. A failed factory removes newly added hooks
  * and retains the previous runtime. Existing updater callbacks remain registered.
  *
  * @param string $plugin Plugin basename WordPress is about to activate.
  * @param bool $network Whether activation targets the current network; accepted for
  *                      the native hook contract, not used to select a runtime.
  * @return void Returns without replacing an existing runtime if no verified,
  *              newer compatible target copy can be loaded successfully.
  * @since 0.6.1
  */
 function deckerweb_library_activation_handoff_v3( string $plugin, bool $network ): void {
  $old = $GLOBALS['deckerweb_library_runtime_v1'] ?? null;
  if ( ! is_object( $old ) ) { deckerweb_library_elect_v090(); return; }
  if ( ! defined( get_class( $old ) . '::VERSION' ) ) { return; }
  $candidates = $GLOBALS['deckerweb_library_candidates_v1'] ?? [];
  /**
   * Order candidates by descending component version and deterministic host tie-break.
   * @param array $a First registered candidate.
   * @param array $b Second registered candidate.
   * @return int Negative when a precedes b, positive when b precedes a, zero when equal.
   */
  usort( $candidates, static function( array $a, array $b ): int { return version_compare( $b['version'], $a['version'] ) ?: strcmp( $a['host'], $b['host'] ); } );
  global $wp_version, $wp_filter;
  foreach ( $candidates as $candidate ) {
   if ( version_compare( $candidate['version'], constant( get_class( $old ) . '::VERSION' ), '<=' ) ) { return; }
   // This handoff understands protocol two and only candidates registered by the target.
   if ( plugin_basename( $candidate['host'] ) !== $plugin ) { continue; }
   $manifest_file = $candidate['dir'] . '/compatibility.json';
   $m = is_readable( $manifest_file ) ? json_decode( (string) file_get_contents( $manifest_file ), true ) : null;
   if ( ! is_array( $m ) || ( $m['protocol'] ?? 0 ) !== 2 || ( $m['version'] ?? '' ) !== $candidate['version'] || ! is_array( $m['files'] ?? null ) || ! is_array( $m['hashes'] ?? null ) ) { continue; }
   if ( ! preg_match( '/^\d+\.\d+(?:\.\d+)?$/D', $m['requires_php'] ?? '' ) || ! preg_match( '/^\d+\.\d+(?:\.\d+)?$/D', $m['requires_wp'] ?? '' ) || version_compare( PHP_VERSION, $m['requires_php'], '<' ) || version_compare( $wp_version, $m['requires_wp'], '<' ) ) { continue; }
   $valid = in_array( 'runtime.php', $m['files'], true );
   foreach ( $m['files'] as $file ) {
    if ( ! is_string( $file ) || strpos( $file, '..' ) !== false || ! preg_match( '~^[a-zA-Z0-9_/.-]+$~D', $file ) || ! is_readable( $candidate['dir'] . '/' . $file ) || ! is_string( $m['hashes'][$file] ?? null ) || ! preg_match( '/^[a-f0-9]{64}$/D', $m['hashes'][$file] ) || ! hash_equals( $m['hashes'][$file], (string) hash_file( 'sha256', $candidate['dir'] . '/' . $file ) ) ) { $valid = false; break; }
   }
   if ( ! $valid ) { continue; }
   $before = [];
   foreach ( $wp_filter as $tag => $hook ) {
    if ( $hook instanceof \WP_Hook ) { foreach ( $hook->callbacks as $priority => $callbacks ) { $before[$tag][$priority] = array_keys( $callbacks ); } }
   }
   try {
    $factory = require $candidate['dir'] . '/runtime.php';
    if ( ! is_callable( $factory ) ) { throw new \RuntimeException( 'Invalid Library factory.' ); }
    $next = $factory( $candidate, $candidates );
    if ( ! is_object( $next ) || ! defined( get_class( $next ) . '::VERSION' ) || constant( get_class( $next ) . '::VERSION' ) !== $candidate['version'] ) { throw new \RuntimeException( 'Invalid Library runtime.' ); }
   } catch ( \Throwable $error ) {
    // Undo hooks added by an unsuccessful factory, retaining the previously elected guard.
    foreach ( $wp_filter as $tag => $hook ) {
     if ( ! $hook instanceof \WP_Hook ) { continue; }
     foreach ( $hook->callbacks as $priority => $callbacks ) {
      foreach ( $callbacks as $id => $callback ) { if ( ! in_array( $id, $before[$tag][$priority] ?? [], true ) ) { remove_filter( $tag, $callback['function'], $priority ); } }
     }
    }
    return;
   }
   foreach ( $wp_filter as $tag => $hook ) {
    if ( ! $hook instanceof \WP_Hook ) { continue; }
    foreach ( $hook->callbacks as $priority => $callbacks ) {
     foreach ( $callbacks as $callback ) {
      $function = $callback['function'];
      if ( is_array( $function ) && ( $function[0] ?? null ) === $old ) { remove_filter( $tag, $function, $priority ); }
     }
    }
   }
   $GLOBALS['deckerweb_library_runtime_v1'] = $next;
   return;
  }
 }
}
// The negative priority runs before older Library activation guards (priority zero).
add_action( 'activate_plugin', 'deckerweb_library_activation_handoff_v3', -100, 2 );
