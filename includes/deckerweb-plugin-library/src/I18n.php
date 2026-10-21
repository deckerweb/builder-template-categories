<?php
/** Copyright 2026 David Decker – DECKERWEB. SPDX-License-Identifier: GPL-2.0-or-later */
namespace Deckerweb\PluginLibrary\V1_1_0;
if ( ! defined( 'ABSPATH' ) ) { exit; }
/** Load component messages into the elected host's existing domain, never an extra domain. */
final class I18n {
 private static string $domain = '';
 private static string $dir = '';
 private static string $host_languages = '';
 private static string $locale = ''; 
 /**
  * Select the elected host domain and component language resource paths.
  *
  * @param array $host Elected host metadata with absolute main-file path.
  * @return void No return value.
  */
 public static function configure( array $host ): void {
  $headers = get_file_data( $host['host'], [ 'domain' => 'Text Domain', 'path' => 'Domain Path' ] );
  $domain = $headers['domain'] ?: basename( dirname( $host['host'] ) );
  self::$domain = preg_match( '/^[a-z0-9-]+$/D', $domain ) ? $domain : '';
  self::$dir = $host['dir'];
  $path = $headers['path'] ?: '/languages/';
  self::$host_languages = strpos( $path, '..' ) === false ? dirname( plugin_basename( $host['host'] ) ) . '/' . trim( $path, '/' ) : '';
  self::$locale = ''; 
 }
 /**
  * Load the current locale into the host domain and translate one source message.
  *
  * @param string $message English source message.
  * @return string Translated message or original English when no translation is available.
  */
 public static function text( string $message ): string {
  $locale = determine_locale();
  if ( self::$domain === '' ) { return $message; }
  if ( self::$locale !== $locale || ! is_textdomain_loaded( self::$domain ) ) {
   if ( self::$locale !== '' && self::$locale !== $locale ) {
    unload_textdomain( self::$domain, true );
    if ( self::$host_languages !== '' ) { load_plugin_textdomain( self::$domain, false, self::$host_languages ); }
   }
   if ( in_array( $locale, [ 'de_DE', 'de_DE_formal' ], true ) ) {
    // load_textdomain merges messages into the host domain; host resources retain precedence.
    load_textdomain( self::$domain, self::$dir . '/languages/' . $locale . '.mo', $locale );
   }
   self::$locale = $locale;
  }
  return translate( $message, self::$domain );
 }
 /**
  * Format a component date using site preferences and localized day or month names.
  *
  * @param string $iso ISO date from the local release history.
  * @return string Localized formatted date using the current site date format.
  */
 public static function date( string $iso ): string {
  $format = get_option( 'date_format' );
  if ( $format === 'F j, Y' ) { $format = self::text( $format ); }
  $result = wp_date( $format, strtotime( $iso . ' UTC' ), new \DateTimeZone( 'UTC' ) );
  if ( ! in_array( determine_locale(), [ 'de_DE', 'de_DE_formal' ], true ) ) { return $result; }
  $names = [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'Jan', 'Feb', 'Mar', 'Apr', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun' ];
  $map = []; foreach ( $names as $name ) { $map[$name] = self::text( $name ); }
  return strtr( $result, $map );
 }

}
