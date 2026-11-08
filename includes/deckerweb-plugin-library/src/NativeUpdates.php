<?php
/** Copyright 2026 David Decker – DECKERWEB. SPDX-License-Identifier: GPL-2.0-or-later */
namespace Deckerweb\PluginLibrary\V1_3_0;
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** Read existing WordPress update offers without requesting releases or consulting catalog versions. */
final class NativeUpdates {
 /**
  * Read the ordinary WordPress update state; never starts an update check.
  * @return mixed Existing update transient, or false when WordPress has no stored result.
  */
 public static function snapshot() { return get_site_transient( 'update_plugins' ); }

 /**
  * Select a structurally valid, forward update for the exact installed plugin.
  * @param array $entry Catalog identity; catalog version and package are deliberately unused.
  * @param array $plugins Current installed headers keyed by plugin basename.
  * @param mixed $state Existing WordPress update state, or null to read it once.
  * @return object|null A detached ordinary update offer, or null when no forward offer exists.
  */
 public static function offer( array $entry, array $plugins, $state = null ): ?object {
  $file = $entry['plugin_file'];
  $installed = $plugins[$file]['Version'] ?? null;
  if ( ! is_string( $installed ) || ! self::version( $installed ) ) { return null; }
  $state = $state ?? self::snapshot();
  $offer = is_object( $state ) && is_array( $state->response ?? null ) ? ( $state->response[$file] ?? null ) : null;
  if ( ! is_object( $offer ) && ! is_array( $offer ) ) { return null; }
  $offer = (object) (array) $offer;
  if ( ( $offer->plugin ?? $file ) !== $file || ! is_string( $offer->new_version ?? null ) || ! self::version( $offer->new_version ) || ! version_compare( $offer->new_version, $installed, '>' ) || ! empty( $offer->dwl_managed ) ) { return null; }
  if ( ! is_string( $offer->package ?? null ) || strlen( $offer->package ) > 4096 || preg_match( '/[\x00-\x20\x7f]/', $offer->package ) ) { return null; }
  $url = wp_parse_url( $offer->package );
  if ( ! is_array( $url ) || ( $url['scheme'] ?? '' ) !== 'https' || empty( $url['host'] ) || isset( $url['user'] ) || isset( $url['pass'] ) || isset( $url['fragment'] ) ) { return null; }
  return $offer;
 }

 /**
  * Bound displayed and submitted versions without accepting paths, markup or arbitrary objects.
  * @param string $version Installed or normally offered version string.
  * @return bool Whether the version is a bounded WordPress-style version identifier.
  */
 public static function version( string $version ): bool {
  return (bool) preg_match( '/^[0-9][0-9A-Za-z.+_-]{0,63}$/D', $version );
 }

 /**
  * Explain platform limits from the update provider, never from the catalog release.
  * @param object $offer Valid ordinary WordPress update offer.
  * @return array Localized unmet WordPress/PHP requirements; Core also checks the actual archive.
  */
 public static function issues( object $offer ): array {
  global $wp_version;
  $issues = [];
  foreach ( [ 'requires'=>[ $wp_version, 'Requires WordPress %s or newer.' ], 'requires_php'=>[ PHP_VERSION, 'Requires PHP %s or newer.' ] ] as $key=>$rule ) {
   $minimum = $offer->$key ?? '';
   if ( is_string( $minimum ) && self::version( $minimum ) && version_compare( $rule[0], $minimum, '<' ) ) { $issues[] = sprintf( Library::t( $rule[1] ), $minimum ); }
  }
  return $issues;
 }
}
