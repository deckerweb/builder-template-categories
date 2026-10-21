<?php
/** Copyright 2026 David Decker – DECKERWEB. SPDX-License-Identifier: GPL-2.0-or-later */
namespace Deckerweb\PluginLibrary\V1_1_0;
if ( ! defined( 'ABSPATH' ) ) { exit; }
/** Personal catalog presentation and local, data-minimized diagnostics. */
final class Experience {
 const META = 'deckerweb_library_view_v1';
 const MODES = [ 'standard' => 'Standard', 'az' => 'Name A–Z', 'za' => 'Name Z–A', 'updated' => 'Recently updated', 'random' => 'Discover randomly' ];
 /** Read normalized preferences for the current user without changing shared settings.
  * @return array Bounded view preferences and a stable random seed.
  */
 public static function view(): array {
  $v = get_user_meta( get_current_user_id(), self::META, true ); $v = is_array( $v ) ? $v : [];
  return [ 'sort' => isset( self::MODES[$v['sort'] ?? ''] ) ? $v['sort'] : 'standard', 'seed' => is_string( $v['seed'] ?? null ) && preg_match( '/^[a-f0-9]{32}$/D', $v['seed'] ) ? $v['seed'] : md5( 'dwl:' . get_current_user_id() ), 'search' => is_string( $v['search'] ?? null ) ? substr( $v['search'], 0, 150 ) : '', 'series' => is_string( $v['series'] ?? null ) ? sanitize_key( $v['series'] ) : '', 'compatible' => ! empty( $v['compatible'] ) ];
 }
 /** Persist an authorized explicit view submission; GET navigation never writes preferences.
  * @return void Updates only the current user's view metadata after POST, nonce and capability checks.
  */
 public static function save(): void {
  if ( ( isset( $_SERVER['REQUEST_METHOD'] ) && is_string( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) !== 'POST' || ! current_user_can( 'install_plugins' ) || ! is_string( $_POST['dwl_view_nonce'] ?? null ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['dwl_view_nonce'] ) ), 'dwl_view' ) ) { wp_die( esc_html( Library::t( 'Permission denied.' ) ), '', [ 'response' => 403 ] ); }
  $v = self::view();
  if ( isset( $_POST['dwl_reset'] ) ) { $v = [ 'sort'=>'standard', 'seed'=>md5( wp_generate_uuid4() ), 'search'=>'', 'series'=>'', 'compatible'=>false ]; }
  else {
   $mode = is_string( $_POST['dwl_sort'] ?? null ) ? sanitize_key( wp_unslash( $_POST['dwl_sort'] ) ) : '';
   if ( ! isset( self::MODES[$mode] ) ) { wp_die( esc_html( Library::t( 'Invalid sort order.' ) ) ); }
   $v['sort']=$mode; $v['search']=is_string( $_POST['dwl_search'] ?? null ) ? substr( sanitize_text_field( wp_unslash( $_POST['dwl_search'] ) ), 0, 150 ) : '';
   $v['series']=is_string( $_POST['dwl_series'] ?? null ) ? sanitize_key( wp_unslash( $_POST['dwl_series'] ) ) : ''; $v['compatible']=( isset( $_POST['dwl_compatible'] ) && is_string( $_POST['dwl_compatible'] ) ? sanitize_text_field( wp_unslash( $_POST['dwl_compatible'] ) ) : '' ) === '1';
   if ( isset( $_POST['dwl_shuffle'] ) ) { $v['seed']=md5( wp_generate_uuid4() ); $v['sort']='random'; }
  }
  update_user_meta( get_current_user_id(), self::META, $v );
  wp_safe_redirect( self_admin_url( 'plugin-install.php?tab=deckerweb' ) ); exit;
 }
 /** Sort a validated catalog without changing entry keys or installation identity.
  * @param array $entries Entries keyed by plugin slug.
  * @param array $view Normalized current-user view.
  * @return array Sorted entries with stable ties and missing dates last.
  */
 public static function ordered( array $entries, array $view ): array {
  $mode=$view['sort']; $seed=$view['seed'];
  /** Compare display fields only, with deterministic slug ties.
   * @param array $a First validated entry.
   * @param array $b Second validated entry.
   * @return int Relative display ordering; does not mutate either entry.
   */
  uasort( $entries, static function( array $a, array $b ) use ( $mode, $seed ): int {
   $tie=strcmp( $a['slug'], $b['slug'] );
   if ( $mode==='random' ) { return strcmp( hash( 'sha256', $seed . $a['slug'] ), hash( 'sha256', $seed . $b['slug'] ) ) ?: $tie; }
   if ( $mode==='updated' ) { return ( ( strtotime( $b['published_at'] ?? '' ) ?: 0 ) <=> ( strtotime( $a['published_at'] ?? '' ) ?: 0 ) ) ?: $tie; }
   if ( $mode==='az' || $mode==='za' ) { $n=strnatcasecmp( remove_accents( $a['name'] ), remove_accents( $b['name'] ) ); return ( $mode==='za' ? -$n : $n ) ?: $tie; }
   return ( ( $a['sort_order'] ?? 10000 ) <=> ( $b['sort_order'] ?? 10000 ) ) ?: $tie;
  } ); return $entries;
 }
 /** Identify active known Git Updater distributions locally by main file and publisher identity.
  * @return array Active matching plugin basenames with version and activation scope; no remote requests.
  */
 public static function conflicts(): array {
  require_once ABSPATH . 'wp-admin/includes/plugin.php'; $result=[];
  foreach ( get_plugins() as $file=>$headers ) {
   if ( ! in_array( basename( $file ), [ 'git-updater.php', 'github-updater.php' ], true ) || ! is_plugin_active( $file ) ) { continue; }
   $identity=implode( ' ', [ $headers['PluginURI'] ?? '', $headers['AuthorURI'] ?? '', $headers['Author'] ?? '' ] );
   if ( ! preg_match( '~afragen|Andy Fragen|git-updater\.com|github-updater\.com~i', $identity ) ) { continue; }
   $result[$file]=[ 'version'=>sanitize_text_field( $headers['Version'] ?? '' ), 'network'=>is_plugin_active_for_network( $file ) ];
  } return $result;
 }
 /** Display a shared per-user dismissible conflict warning on relevant administrator screens.
  * @return void Escaped notice output; never deactivates plugins or makes network requests.
  */
 public static function notice(): void {
  global $pagenow;
  if ( ! current_user_can( 'install_plugins' ) || ! in_array( $pagenow, [ 'plugins.php', 'plugin-install.php', 'update-core.php', 'options-general.php', 'settings.php' ], true ) ) { return; }
  if ( in_array( $pagenow, [ 'settings.php','options-general.php' ], true ) && Library::query( 'page' )!=='deckerweb-library' ) { return; }
  $conflicts=self::conflicts(); if ( ! $conflicts ) { return; }
  $fingerprint=hash( 'sha256', wp_json_encode( $conflicts ) );
  if ( get_user_meta( get_current_user_id(), 'deckerweb_git_updater_notice_v1', true )===$fingerprint || ! empty( $GLOBALS['deckerweb_git_updater_notice_v1'] ) ) { return; }
  $GLOBALS['deckerweb_git_updater_notice_v1']=true;
  echo '<div class="notice notice-warning"><p>' . esc_html( Library::t( 'Git Updater is active. If a deckerweb installation or update fails, temporarily deactivate Git Updater and retry. Reactivate it afterwards if other plugins or themes need it. Only leave it disabled when those extensions have another reliable update provider.' ) ) . ' <a href="' . esc_url( is_multisite() && in_array( true, array_column( $conflicts,'network' ), true ) ? network_admin_url('plugins.php') : self_admin_url('plugins.php') ) . '">' . esc_html( Library::t('Manage installed plugins') ) . '</a></p><form method="post" action="' . esc_url(admin_url('admin-post.php')) . '"><input type="hidden" name="action" value="dwl_conflict_dismiss">';
  wp_nonce_field('dwl_conflict_dismiss'); echo '<p><button class="button-link" type="submit">' . esc_html(Library::t('Dismiss this notice')) . '</button></p></form></div>';
 }
 /** Dismiss only the current locally detected conflict fingerprint for this user.
  * @return void Checks authorization, writes user metadata and returns to native plugin administration.
  */
 public static function dismiss(): void {
  if ( ( isset( $_SERVER['REQUEST_METHOD'] ) && is_string( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' )!=='POST' || ! current_user_can('install_plugins') ) { wp_die(esc_html(Library::t('Permission denied.')),'',['response'=>403]); }
  check_admin_referer('dwl_conflict_dismiss');update_user_meta(get_current_user_id(),'deckerweb_git_updater_notice_v1',hash('sha256',wp_json_encode(self::conflicts())));
  if (wp_doing_ajax()) {wp_send_json_success();}
  wp_safe_redirect(self_admin_url('plugins.php'));exit;
 }
 /** Render copyable non-sensitive diagnostics within the existing settings page.
  * @param array $chosen Elected runtime and its host file.
  * @param array $hosts Registered component candidates.
  * @param array $status Catalog provenance summary.
  * @return void Escaped expandable diagnostic output, without filesystem paths or secrets.
  */
 public static function diagnostics( array $chosen, array $hosts, array $status ): void {
  $data=[ 'Library'=>Library::VERSION,'Host'=>plugin_basename($chosen['host']),'Registered copies'=>count($hosts),'WordPress'=>get_bloginfo('version'),'PHP'=>PHP_VERSION,'Multisite'=>is_multisite()?'yes':'no','Catalog'=>$status,'Git Updater'=>self::conflicts() ];
  echo '<details class="dwl-diagnostics"><summary>' . esc_html(Library::t('Technical information')) . '</summary><p>' . esc_html(Library::t('These details contain component versions and catalog status, without credentials or site content.')) . '</p><textarea id="dwl-diagnostics" readonly rows="12" class="large-text code" aria-label="' . esc_attr(Library::t('Technical information')) . '">' . esc_textarea(wp_json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES)) . '</textarea><p><button type="button" class="button" data-dwl-copy>' . esc_html(Library::t('Copy diagnostic information')) . '</button><span role="status" data-dwl-copy-status></span></p></details>';
 }
}
