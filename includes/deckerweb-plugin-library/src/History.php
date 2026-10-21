<?php
/** Copyright 2026 David Decker – DECKERWEB. SPDX-License-Identifier: GPL-2.0-or-later */
namespace Deckerweb\PluginLibrary\V1_1_0;
if ( ! defined( 'ABSPATH' ) ) { exit; }
/** Structured, escaped local history. One dialog per Library page, no shared host-footer replacement. */
final class History {
 /**
  * Output escaped local release history with keyboard-accessible dialog controls.
  *
  * @param string $dir Absolute embedded Library directory.
  * @return void No return value.
  * Outputs escaped administration markup.
  */
 public static function render( string $dir ): void {
  $data = json_decode( (string) file_get_contents( $dir . '/history.json' ), true );
  if ( ! is_array( $data ) ) { return; }
  $de = str_starts_with( determine_locale(), 'de' );
  $history_url = 'https://github.com/deckerweb/deckerweb-plugin-library/blob/main/docs/CHANGELOG' . ($de ? '-de' : '') . '.md';
  echo '<span>© 2026 <a href="https://github.com/deckerweb" target="_blank" rel="noopener noreferrer">David Decker – DECKERWEB</a></span> <a href="' . esc_url($history_url) . '" target="_blank" rel="noopener noreferrer" class="button-link" data-dwl-history>' . esc_html( Library::t( 'Changelog' ) ) . '</a>';
  echo '<dialog hidden id="dwl-history" aria-labelledby="dwl-history-title"><div class="dwl-dialog-top"><h2 id="dwl-history-title">' . esc_html( Library::t( 'Library changelog' ) ) . '</h2><form method="dialog"><button type="submit" class="button" data-dwl-close autofocus>' . esc_html( Library::t( 'Close' ) ) . '</button></form></div>';
  foreach ( array_slice( $data, 0, 7 ) as $release ) {
   echo '<section><h3>' . esc_html( $release['version'] ) . '</h3>';
   if ( ! empty( $release['date'] ) ) { echo '<p>' . esc_html( I18n::date( $release['date'] ) ) . '</p>'; }
   foreach ( [ 'New', 'Improved', 'Fixed', 'Misc' ] as $category ) {
    $entries = $release['changes'][$category] ?? [];
    if ( ! $entries ) { continue; }
    echo '<h4 class="dwl-badge dwl-' . esc_attr( strtolower( $category ) ) . '">' . esc_html( Library::t( $category ) ) . '</h4><ul>';
    foreach ( $entries as $entry ) { echo '<li>' . esc_html( $entry[$de ? 'de' : 'en'] ) . '</li>'; }
    echo '</ul>';
   }
   echo '</section>';
  }
  echo '</dialog>';
 }
}
