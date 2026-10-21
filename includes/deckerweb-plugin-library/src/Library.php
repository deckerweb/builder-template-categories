<?php
/** Copyright 2026 David Decker – DECKERWEB. SPDX-License-Identifier: GPL-2.0-or-later */
namespace Deckerweb\PluginLibrary\V1_1_0;
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** WordPress-native, embedded catalog. Settings are shared across host plugins. */
final class Library {
	const VERSION = '1.1.0';
	const OPTION = 'deckerweb_library_settings_v1';
	const MANAGED = 'deckerweb_library_installed_v1';
	private array $chosen;
	private array $hosts;
	private Catalog $catalog;
	private bool $network = false;
 private ?object $explicit_upgrader = null;
	/**
	 * Initialize the component with validated host paths and shared runtime configuration.
	 *
	 * @param array $chosen Elected candidate including host main file and embedded directory.
	 * @param array $hosts All registered host candidates used for shared integration.
	 * @return void No return value.
	 */
	public function __construct( array $chosen, array $hosts ) {
		$this->chosen = $chosen; $this->hosts = $hosts;
		$this->catalog = new Catalog( $chosen['dir'] );
  I18n::configure( $chosen );
	}

	/**
	 * Translate an English message through the elected host domain.
	 *
	 * @param string $en English source message.
	 * @param string $de Legacy optional argument; translation resources determine the result.
	 * @return string Translated English source using the elected host domain.
	 */
	public static function t( string $en, string $de = '' ): string {
  return I18n::text( $en );
 }
	/**
	 * Read shared preferences with safe defaults without creating per-host options.
	 *
	 * @return array Normalized shared discovery, online-source and deletion preferences.
	 */
	public static function settings(): array {
		$saved = get_site_option( self::OPTION, [] );
		$saved = is_array( $saved ) ? $saved : [];
		return [ 'enabled' => ! isset( $saved['enabled'] ) || ! empty( $saved['enabled'] ), 'online' => ! empty( $saved['online'] ), 'delete_settings' => ! empty( $saved['delete_settings'] ), 'catalog_url' => is_string( $saved['catalog_url'] ?? null ) ? ( $saved['catalog_url'] !== '' ? $saved['catalog_url'] : Catalog::DEFAULT_URL ) : Catalog::DEFAULT_URL ];
	}
	/**
	 * Attach the elected runtime to native WordPress administration and update hooks.
	 *
	 * @return void No return value.
	 * Registers WordPress hooks or local assets for the current request.
	 */
	public function register(): void {
		add_action( 'admin_post_dwl_view', [ $this, 'save_view' ] );
  add_action( 'wp_ajax_dwl_conflict_dismiss', [ $this, 'dismiss_conflict' ] );
  add_action( 'admin_post_dwl_conflict_dismiss', [ $this, 'dismiss_conflict' ] );
  add_action( 'admin_notices', [ $this, 'conflict_notice' ] );
  add_action( 'network_admin_notices', [ $this, 'conflict_notice' ] );
  add_filter( 'install_plugins_tabs', [ $this, 'tabs' ] );
		add_action( 'install_plugins_deckerweb', [ $this, 'render' ] );
		add_action( 'admin_notices', [ $this, 'notice' ] );
		add_action( 'network_admin_notices', [ $this, 'notice' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'assets' ] );
		add_action( 'admin_menu', [ $this, 'menu' ] );
		add_action( 'network_admin_menu', [ $this, 'menu' ] );
		add_action( 'admin_post_dwl_preferences', [ $this, 'preferences' ] );
		add_action( 'admin_post_dwl_dismiss', [ $this, 'dismiss' ] );
		add_action( 'wp_ajax_dwl_controls', [ $this, 'inline_controls' ] );
		add_action( 'wp_ajax_dwl_inline_status', [ $this, 'inline_status' ] );
		add_action( 'wp_ajax_dwl_inline', [ $this, 'inline_action' ] );
		add_action( 'admin_post_dwl_install', [ $this, 'install' ] );
		add_action( 'admin_post_dwl_update', [ $this, 'update' ] );
		add_action( 'admin_post_dwl_activate', [ $this, 'activate' ] );
		add_action( 'admin_post_dwl_refresh', [ $this, 'refresh' ] );
		add_action( 'activate_plugin', [ $this, 'activation_guard' ], 0, 2 );
		add_filter( 'pre_set_site_transient_update_plugins', [ $this, 'updates' ] );
		add_filter( 'upgrader_pre_download', [ $this, 'update_download' ], 10, 4 );
		foreach ( $this->hosts as $host ) {
			add_filter( 'plugin_action_links_' . plugin_basename( $host['host'] ), [ $this, 'links' ] );
			add_filter( 'network_admin_plugin_action_links_' . plugin_basename( $host['host'] ), [ $this, 'links' ] );
		}
	}
 /** Save the current user's view through the elected runtime's owned callback.
  * @return void Delegates to the nonce- and capability-checked handler, which terminates the request.
  */
 public function save_view(): void { Experience::save(); }
 /** Render at most one local conflict notice through an owned runtime callback.
  * @return void Emits escaped markup only for authorized relevant administration screens.
  */
 public function conflict_notice(): void { Experience::notice(); }
 /** Dismiss a conflict notice for the current user through an owned callback.
  * @return void Delegates to the authorized handler, returning JSON or a native admin redirect.
  */
 public function dismiss_conflict(): void { Experience::dismiss(); }

	/**
	 * Add the optional catalog link to the host plugin action links.
	 *
	 * @param array $links Existing host plugin action links.
	 * @return array Host action links with the optional catalog entry appended.
	 */
	public function links( array $links ): array {
		if ( self::settings()['enabled'] && current_user_can( 'install_plugins' ) ) { $links['deckerweb_library'] = '<a href="' . esc_url( self_admin_url( 'plugin-install.php?tab=deckerweb' ) ) . '">' . esc_html( self::t( 'More by deckerweb' ) ) . '</a>'; }
		return $links;
	}
	/**
	 * Expose the catalog tab only when enabled and permitted.
	 *
	 * @param array $tabs Existing installer tab labels.
	 * @return array Native installation tabs including the permitted catalog tab.
	 */
	public function tabs( array $tabs ): array {
		if ( self::settings()['enabled'] && current_user_can( 'install_plugins' ) ) { $tabs['deckerweb'] = 'deckerweb'; }
		return $tabs;
	}
 /** Read a bounded scalar query value for navigation and read-only status only.
  * @param string $key Expected query parameter name.
  * @return string|null Sanitized unslashed scalar, or null for missing/non-scalar input.
  * This method does not authorize state changes; write endpoints verify their own nonces.
  */
 public static function query( string $key ): ?string {
  // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only navigation, filtering or status; no stored changes are authorized here.
  return isset( $_GET[$key] ) && is_string( $_GET[$key] ) ? substr( sanitize_text_field( wp_unslash( $_GET[$key] ) ), 0, 150 ) : null;
 }

	/**
	 * Enqueue local assets only on the catalog and Library settings screens.
	 *
	 * @param string $hook WordPress admin screen hook suffix.
	 * @return void No return value.
	 * Registers WordPress hooks or local assets for the current request.
	 */
	public function assets( string $hook ): void {
		if ( ! current_user_can( 'install_plugins' ) ) { return; }
		if ( ( $hook === 'plugin-install.php' && self::query( 'tab' ) === 'deckerweb' ) || str_contains( $hook, 'deckerweb-library' ) || ( in_array($hook,['plugins.php','update-core.php'],true) && Experience::conflicts() ) ) {
			wp_enqueue_style( 'deckerweb-plugin-library', plugins_url( 'assets/library.css', $this->chosen['dir'] . '/bootstrap.php' ), [], self::VERSION );
   wp_enqueue_script( 'deckerweb-plugin-library', plugins_url( 'assets/library.js', $this->chosen['dir'] . '/bootstrap.php' ), [ 'jquery', 'updates' ], self::VERSION . '.1', true );
   wp_localize_script( 'deckerweb-plugin-library', 'dwlInline', [ 'url' => admin_url( 'admin-ajax.php' ), 'installing' => self::t( 'Installing…' ), 'activating' => self::t( 'Activating…' ), 'updating' => self::t( 'Updating…' ), 'failed' => self::t( 'The request could not be completed. Check the plugin status before trying again.' ), 'cancelled' => self::t( 'Action cancelled.' ), 'status' => self::t( 'Check status' ), 'checking' => self::t( 'Checking status…' ), 'active' => self::t('Active'), 'networkActive' => self::t('Network active'), 'inactive' => self::t('Installed · inactive'), 'copied' => self::t( 'Copied.' ), 'copyManual' => self::t( 'Select and copy the text.' ), 'forbidden' => self::t( 'Permission denied. Reload the page and check your permissions.' ), 'interrupted' => self::t( 'Another component interrupted the request. If Git Updater is active, temporarily deactivate it and retry.' ), 'saved' => self::t( 'Settings saved.' ) ] );
		}
	}
	/**
	 * Show the dismissible introduction once for the current permitted administrator.
	 *
	 * @return void No return value.
	 * Outputs escaped administration markup.
	 */
	public function notice(): void {
		global $pagenow;
		if ( $pagenow !== 'plugin-install.php' || self::query( 'tab' ) === 'deckerweb' || ! self::settings()['enabled'] || ! current_user_can( 'install_plugins' ) || get_user_meta( get_current_user_id(), 'deckerweb_library_intro_seen_v1', true ) ) { return; }
		// Once per administrator, not once per request and not once per host plugin.
		update_user_meta( get_current_user_id(), 'deckerweb_library_intro_seen_v1', 1 );
		echo '<div class="notice notice-info"><p><strong>' . esc_html( self::t( 'Discover more plugins by deckerweb' ) ) . '</strong><br>' . esc_html( self::t( 'You already use one of my plugins. Find selected additions in the deckerweb tab.' ) ) . ' <a href="' . esc_url( self_admin_url( 'plugin-install.php?tab=deckerweb' ) ) . '">' . esc_html( self::t( 'View plugins' ) ) . '</a></p>';
		$this->form( 'dismiss', '', self::t( 'Dismiss permanently' ), 'button-link', [ 'location' => 'installer' ] );
		echo '<p></p></div>';
	}
	/**
	 * Register the shared settings page in its permitted administration scope.
	 *
	 * @return void No return value.
	 * Registers WordPress hooks or local assets for the current request.
	 */
	public function menu(): void {
		$cap = is_network_admin() ? 'manage_network_options' : 'manage_options';
		if ( is_multisite() && ! is_network_admin() ) { return; }
		add_submenu_page( is_network_admin() ? 'settings.php' : 'options-general.php', 'deckerweb Plugin Library', 'deckerweb Plugin Library', $cap, 'deckerweb-library', [ $this, 'settings_page' ] );
	}
	/**
	 * Build the catalog URL for the current site or network administration scope.
	 *
	 * @return string Catalog administration URL in the current site or network scope.
	 */
	private function catalog_url(): string { return ( $this->network ? network_admin_url( 'plugin-install.php?tab=deckerweb' ) : self_admin_url( 'plugin-install.php?tab=deckerweb' ) ); }
	/**
	 * Build the shared settings URL for the current administration scope.
	 *
	 * @return string Shared settings URL for the current administration scope.
	 */
	private function settings_url(): string { return is_multisite() ? network_admin_url( 'settings.php?page=deckerweb-library' ) : admin_url( 'options-general.php?page=deckerweb-library' ); }
	/**
	 * Build a nonce-protected administration URL for the requested catalog action.
	 *
	 * @param string $action Nonce and action identifier.
	 * @param string $slug Approved catalog plugin slug.
	 * @return string Administration action URL before nonce decoration.
	 */
	private function action_url( string $action, string $slug = '' ): string {
		return add_query_arg( [ 'action' => 'dwl_' . $action, 'slug' => $slug, 'network' => ( is_network_admin() || $this->network ) ? '1' : '0' ], admin_url( 'admin-post.php' ) );
	}
	/**
	 * Output an escaped, nonce-protected form for one catalog action.
	 *
	 * @param string $action Nonce and action identifier.
	 * @param string $slug Approved catalog plugin slug.
	 * @param string $label Localized action label.
	 * @param string $class Escaped CSS class list for the submit control.
	 * @param array $extra Additional action fields or native upgrader context.
	 * @return void No return value.
	 * Outputs escaped administration markup.
	 */
	private function form( string $action, string $slug, string $label, string $class = 'button', array $extra = [] ): void {
		echo '<form method="post" action="' . esc_url( $this->action_url( $action, $slug ) ) . '" class="dwl-action" data-dwl-action="' . esc_attr( $action ) . '" data-dwl-slug="' . esc_attr( $slug ) . '" data-dwl-network="' . ( ( is_network_admin() || $this->network ) ? '1' : '0' ) . '">';
		wp_nonce_field( 'dwl_' . $action . '_' . $slug );
		foreach ( $extra as $key => $value ) { echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '">'; }
		echo '<button type="submit" class="' . esc_attr( $class ) . '">' . esc_html( self::t( $label ) ) . '</button></form>';
	}
	/**
	 * Select the localized display field from a validated catalog entry.
	 *
	 * @param array $entry Validated approved catalog entry and dependency metadata.
	 * @param string $key Display field name selected from the validated localized entry.
	 * @return string Requested catalog field in the current locale, falling back to English.
	 */
	private static function text( array $entry, string $key ): string {
		return str_starts_with( determine_locale(), 'de' ) && isset( $entry[$key . '_de'] ) ? $entry[$key . '_de'] : $entry[$key];
	}

	/**
	 * Choose an explicit safe catalog color or a stable local pastel for initials.
	 *
	 * @param array $entry Validated catalog identity and optional hexadecimal color.
	 * @return string Six-digit CSS hexadecimal color, stable across users and requests.
	 */
	private static function fallback_color( array $entry ): string {
		$explicit = $entry['icon_background'] ?? null;
		if ( is_string( $explicit ) && preg_match( '/^#[a-fA-F0-9]{6}$/D', $explicit ) ) { return $explicit; }
		$palette = [ '#DDEBE8', '#E7E2EF', '#DFE7F0', '#F1E3D7', '#E1E8DC', '#E9E1F1', '#E3EAF3', '#EEE6D9' ];
		$identity = (string) ( $entry['slug'] ?? $entry['repository'] ?? 'deckerweb' );
		return $palette[ hexdec( substr( hash( 'sha256', $identity ), 0, 4 ) ) % count( $palette ) ];
	}

	/**
	 * Select a local original icon or a subdued text fallback for a catalog card.
	 *
	 * @param array $entry Validated approved catalog entry and dependency metadata.
	 * @return string Escaped local icon HTML or the muted initials fallback.
	 */
	private function icon( array $entry ): string {
		// Only bundled PNG files; catalog metadata never triggers remote image requests.
		$file = str_starts_with( determine_locale(), 'de' ) ? ( $entry['icon_de'] ?? $entry['icon'] ?? '' ) : ( $entry['icon'] ?? '' );
		if ( $file && is_file( $this->chosen['dir'] . '/' . $file ) ) {
			return '<img src="' . esc_url( add_query_arg( 'ver', self::VERSION, plugins_url( $file, $this->chosen['dir'] . '/bootstrap.php' ) ) ) . '" alt="" width="54" height="54">';
		}
		return '<span class="dwl-icon-fallback" style="background-color:' . esc_attr( self::fallback_color( $entry ) ) . '">' . esc_html( $entry['icon_label'] ?? 'DW' ) . '</span>';
	}
	/**
	 * Output the filtered catalog with separate installation and activation controls.
	 *
	 * @return void No return value.
	 * Outputs escaped administration markup.
	 */
	public function render(): void {
		if ( ! current_user_can( 'install_plugins' ) ) { wp_die( esc_html( self::t( 'Permission denied.' ) ), '', [ 'response' => 403 ] ); }
		if ( ! self::settings()['enabled'] ) {
			echo '<p>' . esc_html( self::t( 'The catalog is hidden.' ) ) . ' <a href="' . esc_url( $this->settings_url() ) . '">' . esc_html( self::t( 'Library settings' ) ) . '</a></p>'; return;
		}
		update_user_meta( get_current_user_id(), 'deckerweb_library_intro_seen_v1', 1 );
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		$entries = $this->catalog->entries();
		if ( is_wp_error( $entries ) ) { echo '<div class="notice notice-error"><p>' . esc_html( $entries->get_error_message() ) . '</p></div>'; return; }
		$entries += $this->catalog->previews();
		$plugins = get_plugins();
  $view = Experience::view();
  $entries = Experience::ordered( $entries, $view );
		$search = self::query( 'dwl_search' ) ?? $view['search'];
		$compatible = self::query( 'dwl_compatible' ) !== null ? self::query( 'dwl_compatible' ) === '1' : $view['compatible'];
  $available_series = [];
  foreach ( $entries as $entry ) { foreach ( Catalog::series( $entry ) as $membership ) { $available_series[$membership] = true; } }
  $series = self::query( 'dwl_series' ) !== null && isset( $available_series[ self::query( 'dwl_series' ) ] ) ? self::query( 'dwl_series' ) : ( isset( $available_series[$view['series']] ) ? $view['series'] : '' );
  $reset_url = self_admin_url( 'plugin-install.php?tab=deckerweb' );
		echo '<div id="deckerweb-library"><div class="dwl-heading"><div><h2>' . esc_html( self::t( 'Small plugins. Practical improvements.' ) ) . '</h2><p>' . esc_html( self::t( 'Selected by deckerweb · Installed from GitHub releases' ) ) . '</p></div><a href="' . esc_url( $this->settings_url() ) . '">' . esc_html( self::t( 'Library settings' ) ) . '</a></div>';
		if ( self::query( 'dwl_done' ) !== null ) { echo '<div class="notice notice-success inline"><p>' . esc_html( self::t( 'Done. The plugin is active.' ) ) . '</p></div>'; }
		if ( $this->catalog->status === 'offline' ) { echo '<div class="notice notice-warning inline"><p>' . esc_html( self::t( 'The online catalog is unavailable. Showing cached or bundled entries; online approval is checked again before installation.' ) ) . '</p></div>'; }
  $catalog_status = $this->catalog->summary();
  echo '<p class="dwl-catalog-status">' . esc_html( self::t( $catalog_status['source'] === 'online' ? 'Online catalog' : ( $catalog_status['source'] === 'offline' ? 'Cached or bundled catalog' : 'Bundled catalog' ) ) . ' · ' . $catalog_status['revision'] . ( $catalog_status['checked_at'] ? ' · ' . self::t( 'Last successful check: ' ) . wp_date( 'Y-m-d H:i', $catalog_status['checked_at'] ) : '' ) ) . '</p>';
  $series_controls = '<fieldset class="dwl-series-filter"><legend>' . esc_html( self::t( 'Plugin series' ) ) . '</legend>';
  $series_labels = [];
  $definitions = reset( $entries )['_series_definitions'] ?? [];
  /**
   * Compare validated series display orders.
   * @param array $a First definition.
   * @param array $b Second definition.
   * @return int Numeric order comparison without persistent side effects.
   */
  uasort( $definitions, static fn( array $a, array $b ): int => $a['order'] <=> $b['order'] );
  foreach ( $definitions as $id => $definition ) { $series_labels[$id] = self::text( $definition, 'name' ); }
  $series_labels += Catalog::SERIES;
  foreach ( [ '' => self::t( 'All' ) ] + $series_labels as $key => $label ) {
   if ( $key !== '' && ! isset( $available_series[$key] ) ) { continue; }
   $series_controls .= '<button type="submit" class="button' . ( $series === $key ? ' dwl-series-selected' : '' ) . '" name="dwl_series" value="' . esc_attr( $key ) . '" aria-pressed="' . ( $series === $key ? 'true' : 'false' ) . '">' . esc_html( self::t( $label ) ) . '</button>';
  }
  $series_controls .= '</fieldset>';
  echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" class="dwl-filter"><input type="hidden" name="action" value="dwl_view"><input type="hidden" name="dwl_view_nonce" value="' . esc_attr( wp_create_nonce( 'dwl_view' ) ) . '"><button type="submit" name="dwl_series" value="' . esc_attr( $series ) . '" hidden>' . esc_html( self::t( 'Filter' ) ) . '</button>' . wp_kses( $series_controls, [ 'fieldset'=>[ 'class'=>true ], 'legend'=>[], 'button'=>[ 'type'=>true, 'class'=>true, 'name'=>true, 'value'=>true, 'aria-pressed'=>true ] ] ) . '<div class="dwl-filter-controls"><label>' . esc_html( self::t( 'Search this catalog' ) ) . ' <input type="search" name="dwl_search" value="' . esc_attr( $search ) . '"></label><label><input type="checkbox" name="dwl_compatible" value="1" ' . checked( $compatible, true, false ) . ' aria-describedby="dwl-compatible-help"> ' . esc_html( self::t( 'Fits my installation' ) ) . '</label><button type="submit" class="button" name="dwl_series" value="' . esc_attr( $series ) . '">' . esc_html( self::t( 'Filter' ) ) . '</button>';
  echo '<label>' . esc_html( self::t( 'Sort by' ) ) . ' <select name="dwl_sort">';
  foreach ( Experience::MODES as $mode=>$label ) { echo '<option value="' . esc_attr($mode) . '" ' . selected($view['sort'],$mode,false) . '>' . esc_html(self::t($label)) . '</option>'; }
  echo '</select></label><button class="button" type="submit" name="dwl_shuffle" value="1"' . ($view['sort']==='random'?'':' hidden') . '>' . esc_html(self::t('Shuffle again')) . '</button><button class="button-link dwl-reset" type="submit" name="dwl_reset" value="1">' . esc_html(self::t('Reset view')) . '</button>';
  echo '</div><p id="dwl-compatible-help" class="dwl-filter-help">' . esc_html( self::t( 'Shows plugins whose platform and dependency requirements are met in this site or network. Without this filter, plugins with missing requirements remain visible.' ) ) . '</p></form>
';
  if ( $series !== '' || $search !== '' || $compatible ) {
   echo '<div class="dwl-active-filters">' . esc_html(self::t('Active filters: ')) . ' ';
   foreach ( [ 'series'=>$series !== '' ? ($series_labels[$series] ?? $series) : '', 'search'=>$search, 'compatible'=>$compatible ? self::t('Fits my installation') : '' ] as $key=>$label ) {
    if ($label==='') {continue;} echo '<form class="dwl-filter-chip" method="post" action="' . esc_url(admin_url('admin-post.php')) . '"><input type="hidden" name="action" value="dwl_view"><input type="hidden" name="dwl_view_nonce" value="' . esc_attr(wp_create_nonce('dwl_view')) . '">';
    foreach ( ['dwl_sort'=>$view['sort'],'dwl_series'=>$key==='series'?'':$series,'dwl_search'=>$key==='search'?'':$search,'dwl_compatible'=>$key==='compatible'?'0':($compatible?'1':'0')] as $field=>$value ) {echo '<input type="hidden" name="' . esc_attr($field) . '" value="' . esc_attr($value) . '">';}
    echo '<button class="button" type="submit" aria-label="' . esc_attr(self::t('Remove filter: ') . $label) . '">' . esc_html($label) . ' ×</button></form>';
   } echo '</div>';
  }
		echo '<div class="dwl-grid">'; $count = 0;
		foreach ( $entries as $entry ) {
			$name = self::text( $entry, 'name' ); $description = self::text( $entry, 'description' );
			if ( $series !== '' && ! in_array( $series, Catalog::series( $entry ), true ) ) { continue; }
			$issues = ! empty( $entry['_preview'] ) ? [ self::t( 'Release 1.0.0 is being prepared. Installation will be available after package verification.' ) ] : Requirements::check( $entry, $plugins );
			if ( $search !== '' && stripos( remove_accents( $name . ' ' . $description ), remove_accents( $search ) ) === false ) { continue; }
			if ( $compatible && $issues ) { continue; }
			$count++;
			$installed = isset( $plugins[$entry['plugin_file']] );
			$active = $installed && ( is_network_admin() ? is_plugin_active_for_network( $entry['plugin_file'] ) : is_plugin_active( $entry['plugin_file'] ) );
			$series_badges = '';
			foreach ( Catalog::series( $entry ) as $membership ) { $series_badges .= '<span class="dwl-series-badge dwl-series-' . esc_attr( $membership ) . '">' . esc_html( $series_labels[$membership] ) . '</span>'; }
			echo '<article class="dwl-card"><div class="dwl-body"><div class="dwl-title"><div class="dwl-icon" aria-hidden="true">' . wp_kses( $this->icon( $entry ), [ 'img'=>[ 'src'=>true, 'alt'=>true, 'width'=>true, 'height'=>true ], 'span'=>[ 'class'=>true, 'style'=>true ] ] ) . '</div><div><h3>' . esc_html( $name ) . '</h3><span class="dwl-meta">deckerweb · ' . esc_html( self::text( $entry, 'category' ) ?: self::t( 'WordPress' ) ) . '</span>' . wp_kses( $series_badges, [ 'span'=>[ 'class'=>true ] ] ) . '</div></div><p>' . esc_html( $description ) . '</p>';

   if ( $installed ) { echo '<p class="dwl-install-state">' . esc_html( self::t( is_plugin_active_for_network( $entry['plugin_file'] ) ? 'Network active' : ( $active ? 'Active' : 'Installed · inactive' ) ) . ( version_compare( $entry['version'], $plugins[$entry['plugin_file']]['Version'] ?? '0', '>' ) ? ' · ' . self::t( 'Update available' ) : '' ) ) . '</p>'; }
			if ( isset( $entry['github_stars'], $entry['stars_checked_at'] ) ) {
				echo '<p class="dwl-stars"><a href="' . esc_url( 'https://github.com/' . $entry['repository'] . '/stargazers' ) . '" target="_blank" rel="noopener noreferrer"><span aria-hidden="true">★</span> ' . esc_html( number_format_i18n( $entry['github_stars'] ) . ' ' . self::t( 'GitHub Stars' ) ) . '</a> <span class="dwl-meta">' . esc_html( self::t( 'As of ' ) . I18n::date( $entry['stars_checked_at'] ) ) . '</span></p>';
			}
			if ( ! empty( $entry['_preview'] ) ) { echo '<button class="button" disabled>' . esc_html( self::t( 'Release in preparation' ) ) . '</button>'; }
   elseif ( $installed && version_compare( $entry['version'], $plugins[$entry['plugin_file']]['Version'] ?? '0', '>' ) && current_user_can( 'update_plugins' ) ) {
    $update_issues = Requirements::check( $entry, $plugins, is_plugin_active_for_network( $entry['plugin_file'] ), false );
    if ( ! $update_issues && $this->update_identity( $entry, $plugins[$entry['plugin_file']] ) ) { $this->form( 'update', $entry['slug'], sprintf( self::t( 'Update to %s' ), $entry['version'] ), 'button button-primary' ); }
    else { echo '<p class="dwl-meta">' . esc_html( $update_issues ? implode( ' ', $update_issues ) : self::t( 'The installed plugin identity could not be verified for this catalog update.' ) ) . '</p>'; }
   }
			elseif ( $active ) { echo '<span class="dwl-active">' . esc_html( self::t( 'Already active' ) ) . '</span>'; }
			elseif ( $issues ) { echo '<button class="button" disabled>' . esc_html( $installed ? self::t( 'Activate' ) : self::t( 'Install now' ) ) . '</button>'; }
			elseif ( $installed && current_user_can( 'activate_plugin', $entry['plugin_file'] ) ) { $this->form( 'activate', $entry['slug'], is_network_admin() ? self::t( 'Network activate' ) : self::t( 'Activate' ), 'button button-primary' ); }
			elseif ( ! $installed ) { $this->form( 'install', $entry['slug'], self::t( 'Install now' ), 'button' ); }
			else { echo '<span>' . esc_html( self::t( 'Installed' ) ) . '</span>'; }
   $advisory = Requirements::check( $entry, $plugins, null, true, true );
   if ( $advisory ) { echo '<p class="dwl-meta">' . esc_html( self::t( 'Affected features remain paused until their requirements are met.' ) . ' ' . implode( ' ', $advisory ) ) . '</p>'; }
			if ( $issues ) { echo '<div class="dwl-requirements"><ul>'; foreach ( $issues as $issue ) { echo '<li>' . esc_html( $issue ) . '</li>'; } echo '</ul><a href="' . esc_url( self_admin_url( 'plugins.php' ) ) . '">' . esc_html( self::t( 'Manage installed plugins' ) ) . '</a></div>'; }
			if ( $installed && ( $plugins[$entry['plugin_file']]['Version'] ?? '' ) !== $entry['version'] ) { echo '<p class="dwl-meta">' . esc_html( self::t( 'The requirements below describe the offered release.' ) ) . '</p>'; }
			echo '<details class="dwl-details"><summary>' . esc_html( self::t( 'Details & requirements' ) ) . '</summary><p>WordPress ≥ ' . esc_html( $entry['requires_wp'] ) . ' · PHP ≥ ' . esc_html( $entry['requires_php'] ) . '</p>';
			foreach ( Requirements::dependencies_for( $entry, $plugins, false ) as $dep ) { echo '<p>' . esc_html( $dep['name'] . ( $dep['min_version'] !== '' ? ' ≥ ' . $dep['min_version'] : '' ) ) . ( isset( $dep['url'] ) ? ' · <a href="' . esc_url( $dep['url'] ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( self::t( 'Product website' ) ) . '</a>' : '' ) . '</p>'; }
			echo '<p><a href="' . esc_url( 'https://github.com/' . $entry['repository'] ) . '" target="_blank" rel="noopener noreferrer">' . esc_html( self::t( 'Repository & documentation' ) ) . '</a></p><p class="dwl-meta">' . esc_html( self::t( ! empty( $entry['_preview'] ) ? 'Requirements shown are preliminary until the stable release is verified.' : 'Release checksum is verified before installation. Activation is a separate step.' ) ) . '</p></details></div><footer><span>' . esc_html( self::t( 'Source: GitHub' ) ) . '</span><span>' . esc_html( ! empty( $entry['_preview'] ) ? self::t( 'Planned: ' ) . $entry['version'] : ( $installed ? self::t( 'Installed: ' ) . $plugins[$entry['plugin_file']]['Version'] : 'v' . $entry['version'] ) ) . '</span></footer></article>';
		}
		echo '</div>';
		if ( ! $count ) { echo '<p>' . esc_html( self::t( 'No approved plugins match this selection.' ) ) . '</p>'; }
		echo '<div class="dwl-bottom"><span>' . esc_html( self::t( 'Library' ) ) . ' ' . esc_html( self::VERSION ) . ' · ' . esc_html( self::t( 'Only approved releases' ) ) . '</span>';
		$this->form( 'preferences', '', self::t( 'Hide catalog' ), 'button-link', [ 'enabled' => '0', 'hide_only' => '1' ] );
		if ( self::settings()['online'] ) { $this->form( 'refresh', '', self::t( 'Refresh catalog' ), 'button-link' ); }
		History::render( $this->chosen['dir'] ); echo '</div></div>';
	}

	/**
	 * Output the shared preferences and explained last-host deletion option.
	 *
	 * @return void No return value.
	 * Outputs escaped administration markup.
	 */
	public function settings_page(): void {
		$cap = is_multisite() ? 'manage_network_options' : 'manage_options';
		if ( ! current_user_can( $cap ) ) { wp_die( esc_html( self::t( 'Permission denied.' ) ), '', [ 'response' => 403 ] ); }
		$s = self::settings();
		echo '<div class="wrap"><h1>deckerweb Plugin Library</h1>';
		if ( self::query( 'saved' ) !== null ) { echo '<div id="dwl-settings-saved" class="notice notice-success"><p>' . esc_html( self::t( 'Library settings saved.' ) ) . '</p></div>'; }
		echo '<form method="post" action="' . esc_url( $this->action_url( 'preferences' ) ) . '" data-dwl-action="preferences" data-dwl-network="' . ( is_multisite() ? '1' : '0' ) . '">'; wp_nonce_field( 'dwl_preferences_' );
		echo '<table class="form-table" role="presentation"><tr><th scope="row">' . esc_html( self::t( 'Visibility' ) ) . '</th><td><label><input type="checkbox" name="enabled" value="1" ' . checked( $s['enabled'], true, false ) . '> ' . esc_html( self::t( 'Show deckerweb under Add Plugins' ) ) . '</label></td></tr>';
		echo '<tr><th scope="row">' . esc_html( self::t( 'Online catalog' ) ) . '</th><td><label><input type="checkbox" name="online" value="1" ' . checked( $s['online'], true, false ) . '> ' . esc_html( self::t( 'Retrieve approved catalog updates online' ) ) . '</label><p class="description">' . esc_html( self::t( 'Optional. The bundled catalog works immediately. Catalog requests are cached for 24 hours. No site URL, plugin list or usage data is sent.' ) ) . '</p><p><label for="dwl-catalog-url">' . esc_html( self::t( 'Catalog URL' ) ) . '</label><br><input type="url" id="dwl-catalog-url" name="catalog_url" value="' . esc_attr( $s['catalog_url'] ) . '" class="regular-text" placeholder="https://…/catalog.json"></p><p class="description">' . esc_html( self::t( 'Only HTTPS on raw.githubusercontent.com/deckerweb. The server receives the requesting IP address. GitHub is contacted when installing a release.' ) ) . '</p></td></tr></table>';
		echo '<p><label><input type="checkbox" name="delete_settings" value="1" ' . checked( $s['delete_settings'], true, false ) . '> ' . esc_html( self::t( 'Delete Library settings when removing the last host plugin' ) ) . '</label></p><p class="description">' . esc_html( self::t( 'Off by default. Applies only when no other host is installed, including inactive hosts. Removes Library settings, installation records and introduction status. Installed plugins, their content and other plugin settings remain unchanged. Network data is shared across sites.' ) ) . '</p>';
  Experience::diagnostics( $this->chosen, $this->hosts, $this->catalog->summary() );
  submit_button( self::t( 'Save settings' ) ); echo '</form><p class="dwl-settings-catalog-link"><a class="button button-secondary" href="' . esc_url( self_admin_url( 'plugin-install.php?tab=deckerweb' ) ) . '">' . esc_html( self::t( 'Open catalog' ) ) . '</a></p>'; echo '<div id="deckerweb-library" class="dwl-settings-footer"><div class="dwl-settings-brand"><img src="' . esc_url( plugins_url( 'assets/library-icon.svg', $this->chosen['dir'] . '/bootstrap.php' ) ) . '" width="52" height="52" alt="" aria-hidden="true"><div><strong>deckerweb Library</strong> <span>' . esc_html( self::VERSION ) . '</span><br>'; History::render( $this->chosen['dir'] ); echo '</div></div></div></div>'; 
	}
	/**
	 * Reject non-POST requests, invalid nonces or insufficient capabilities before mutation.
	 *
	 * @param string $action Nonce and action identifier.
	 * @param string $cap WordPress capability required for the action.
	 * @param string $slug Approved catalog plugin slug.
	 * @return void No return value.
	 */
	private function authorize( string $action, string $cap, string $slug = '' ): void {
		if ( ( isset( $_SERVER['REQUEST_METHOD'] ) && is_string( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) !== 'POST' ) { wp_die( esc_html( self::t( 'POST required.' ) ), '', [ 'response' => 405 ] ); }
		if ( ! current_user_can( $cap ) ) { wp_die( esc_html( self::t( 'Permission denied.' ) ), '', [ 'response' => 403 ] ); }
		$this->network = is_multisite() && ( isset( $_REQUEST['network'] ) && is_string( $_REQUEST['network'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['network'] ) ) : '' ) === '1';
		if ( $this->network && ! current_user_can( 'manage_network_plugins' ) ) { wp_die( esc_html( self::t( 'Network permission denied.' ) ), '', [ 'response' => 403 ] ); }
		check_admin_referer( 'dwl_' . $action . '_' . $slug );
	}
	/**
	 * Read the requested plugin slug as a sanitized scalar.
	 *
	 * @return string Sanitized scalar request slug, or an empty string for missing/invalid input.
	 */
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read identity only; each caller verifies its slug-bound nonce before effects.
 private function slug(): string { return isset( $_REQUEST['slug'] ) && is_string( $_REQUEST['slug'] ) ? sanitize_key( wp_unslash( $_REQUEST['slug'] ) ) : ''; }
	/**
	 * Resolve one currently approved entry, requiring fresh remote approval when online.
	 *
	 * @param string $slug Approved catalog plugin slug.
	 * @param bool $fresh Require a successful uncached source read.
	 * @return array One freshly approved entry; terminates with a user-facing error if absent.
	 */
	private function entry( string $slug, bool $fresh = true ): array {
		if ( ! self::settings()['enabled'] ) { wp_die( esc_html( self::t( 'The catalog is disabled.' ) ), '', [ 'response' => 403 ] ); }
		$entries = $this->catalog->entries( $fresh );
		if ( is_wp_error( $entries ) ) { wp_die( esc_html( $entries->get_error_message() ) ); }
		if ( ! isset( $entries[$slug] ) ) { wp_die( esc_html( self::t( 'This release is not approved.' ) ), '', [ 'response' => 404 ] ); }
		return $entries[$slug];
	}
	/**
	 * Reject an action when platform, dependency or network requirements are unmet.
	 *
	 * @param array $entry Validated approved catalog entry and dependency metadata.
	 * @param bool|null $network Network activation context; null derives it from the current admin scope.
	 * @return void No return value.
	 */
	private function enforce_requirements( array $entry, ?bool $network = null ): void {
		$issues = Requirements::check( $entry, null, $network ?? $this->network );
		if ( $issues ) { wp_die( esc_html( implode( ' ', $issues ) ) ); }
	}
	/**
	 * Validate and save shared preferences or hide discovery without removing update protection.
	 *
	 * @return void No return value.
	 * May read or change component-owned shared storage; foreign plugin data is preserved.
	 */
	public function preferences(): void {
		$this->authorize( 'preferences', is_multisite() ? 'manage_network_options' : 'manage_options' );
  check_admin_referer( 'dwl_preferences_' );
		$s = self::settings();
		if ( ! empty( $_POST['hide_only'] ) ) { $s['enabled'] = false; }
		else {
			$url = isset( $_POST['catalog_url'] ) && is_string( $_POST['catalog_url'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['catalog_url'] ) ) ) : '';
			if ( ( isset( $_POST['catalog_url'] ) && is_string( $_POST['catalog_url'] ) && trim( sanitize_text_field( wp_unslash( $_POST['catalog_url'] ) ) ) !== '' && $url === '' ) || ( isset( $_POST['catalog_url'] ) && ! is_string( $_POST['catalog_url'] ) ) || ( $url !== '' && ! Catalog::trusted_source( $url ) ) ) { wp_die( esc_html( self::t( 'The catalog URL is not an allowed first-party HTTPS endpoint.' ) ) ); }
			if ( ! empty( $_POST['online'] ) && $url === '' ) { wp_die( esc_html( self::t( 'Enter a catalog URL first.' ) ) ); }
			$s = [ 'enabled' => ! empty( $_POST['enabled'] ), 'online' => ! empty( $_POST['online'] ), 'catalog_url' => $url, 'delete_settings' => ! empty( $_POST['delete_settings'] ) ];
		}
		update_site_option( self::OPTION, $s );
		wp_safe_redirect( add_query_arg( 'saved', '1', $this->settings_url() ) ); exit;
	}
	/**
	 * Record the current user introduction dismissal and return to the installer.
	 *
	 * @return void No return value.
	 */
	public function dismiss(): void {
		$this->authorize( 'dismiss', 'install_plugins' );
		update_user_meta( get_current_user_id(), 'deckerweb_library_intro_seen_v1', 1 );
		wp_safe_redirect( $this->network ? network_admin_url( 'plugin-install.php' ) : admin_url( 'plugin-install.php' ) ); exit;
	}
	/**
	 * Refresh approved online metadata without waiting for the display cache.
	 *
	 * @return void No return value.
	 */
	public function refresh(): void {
		$this->authorize( 'refresh', 'install_plugins' );
		$result = $this->catalog->entries( true );
		if ( is_wp_error( $result ) ) { wp_die( esc_html( $result->get_error_message() ) ); }
		wp_safe_redirect( $this->catalog_url() ); exit;
	}
 /**
  * Save preferences, dismiss discovery or refresh metadata without leaving administration.
  * @return void Sends authorized JSON; settings remain shared and remote approval stays bounded.
  */
 public function inline_controls(): void {
  $operation = is_string( $_POST['operation'] ?? null ) ? sanitize_key( wp_unslash( $_POST['operation'] ) ) : '';
  if ( ( isset( $_SERVER['REQUEST_METHOD'] ) && is_string( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) !== 'POST' || ! in_array( $operation, [ 'preferences', 'dismiss', 'refresh' ], true ) || ! is_string( $_POST['_wpnonce'] ?? null ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'dwl_' . $operation . '_' ) ) { wp_send_json_error( [ 'message' => self::t( 'Permission denied.' ) ], 403 ); }
  $this->network = is_multisite() && ( isset( $_POST['network'] ) && is_string( $_POST['network'] ) ? sanitize_text_field( wp_unslash( $_POST['network'] ) ) : '' ) === '1';
  $capability = $operation === 'preferences' ? ( is_multisite() ? 'manage_network_options' : 'manage_options' ) : 'install_plugins';
  if ( ! current_user_can( $capability ) || ( is_multisite() && ! current_user_can( 'manage_network_plugins' ) ) ) { wp_send_json_error( [ 'message' => self::t( 'Permission denied.' ) ], 403 ); }
  if ( $operation === 'preferences' ) {
   $settings = self::settings();
   if ( ! empty( $_POST['hide_only'] ) ) { $settings['enabled'] = false; }
   else {
    $url = is_string( $_POST['catalog_url'] ?? null ) ? trim( sanitize_text_field( wp_unslash( $_POST['catalog_url'] ) ) ) : '';
    if ( ( isset( $_POST['catalog_url'] ) && is_string( $_POST['catalog_url'] ) && trim( sanitize_text_field( wp_unslash( $_POST['catalog_url'] ) ) ) !== '' && $url === '' ) || ( isset( $_POST['catalog_url'] ) && ! is_string( $_POST['catalog_url'] ) ) || ( $url !== '' && ! Catalog::trusted_source( $url ) ) ) { wp_send_json_error( [ 'message' => self::t( 'The catalog URL is not an allowed first-party HTTPS endpoint.' ) ] ); }
    if ( ! empty( $_POST['online'] ) && $url === '' ) { wp_send_json_error( [ 'message' => self::t( 'Enter a catalog URL first.' ) ] ); }
    $settings = [ 'enabled' => ! empty( $_POST['enabled'] ), 'online' => ! empty( $_POST['online'] ), 'catalog_url' => $url, 'delete_settings' => ! empty( $_POST['delete_settings'] ) ];
   }
   update_site_option( self::OPTION, $settings );
  } elseif ( $operation === 'dismiss' ) { update_user_meta( get_current_user_id(), 'deckerweb_library_intro_seen_v1', 1 ); }
  else {
   if ( ! self::settings()['enabled'] ) { wp_send_json_error( [ 'message' => self::t( 'The catalog is disabled.' ) ], 403 ); }
   $entries = $this->catalog->entries( true ); if ( is_wp_error( $entries ) ) { wp_send_json_error( [ 'message' => $entries->get_error_message() ] ); }
  }
  wp_send_json_success( [ 'message' => self::t( $operation === 'refresh' ? 'Catalog refreshed.' : 'Settings saved.' ) ] );
 }

 /**
  * Reconcile a card after a lost AJAX response without installing or activating anything.
  * @return void Sends nonce/capability-protected JSON with current physical plugin state.
  * Fresh catalog approval is required before returning a new activation action.
  */
 public function inline_status(): void {
  $slug = $this->slug();
  $operation = isset( $_POST['operation'] ) && is_string( $_POST['operation'] ) ? sanitize_key( wp_unslash( $_POST['operation'] ) ) : '';
  if ( ( isset( $_SERVER['REQUEST_METHOD'] ) && is_string( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) !== 'POST' || ! in_array( $operation, [ 'install', 'activate', 'update' ], true )
   || ! is_string( $_POST['_wpnonce'] ?? null ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'dwl_' . $operation . '_' . $slug ) ) { wp_send_json_error( [ 'message' => self::t( 'Permission denied.' ) ], 403 ); }
  $this->network = is_multisite() && ( isset( $_POST['network'] ) && is_string( $_POST['network'] ) ? sanitize_text_field( wp_unslash( $_POST['network'] ) ) : '' ) === '1';
  if ( ! current_user_can( $operation === 'install' ? 'install_plugins' : ( $operation === 'update' ? 'update_plugins' : 'activate_plugins' ) ) || ( $this->network && ! current_user_can( 'manage_network_plugins' ) ) ) { wp_send_json_error( [ 'message' => self::t( 'Permission denied.' ) ], 403 ); }
  if ( ! self::settings()['enabled'] ) { wp_send_json_error( [ 'message' => self::t( 'The catalog is disabled.' ) ], 403 ); }
  $entries = $this->catalog->entries( true );
  if ( is_wp_error( $entries ) || ! isset( $entries[$slug] ) ) { wp_send_json_error( [ 'message' => is_wp_error( $entries ) ? $entries->get_error_message() : self::t( 'This release is not approved.' ) ] ); }
  $entry = $entries[$slug];
  $main = is_multisite() ? get_main_site_id( get_main_network_id() ) : get_current_blog_id();
  $switched = $main !== get_current_blog_id(); if ( $switched ) { switch_to_blog( $main ); }
  $lock = get_option( 'dwl_inline_lock_' . $slug, '' );
  if ( $switched ) { restore_current_blog(); }
  if ( is_string( $lock ) && $lock !== '' && (int) $lock >= time() - 900 ) { wp_send_json_success( [ 'pending' => true, 'message' => self::t( 'The action is still running. Check its status again.' ) ] ); }
  require_once ABSPATH . 'wp-admin/includes/plugin.php';
  wp_clean_plugins_cache( false ); $plugins = get_plugins();
  $installed = isset( $plugins[$entry['plugin_file']] );
  $active = $installed && ( $this->network ? is_plugin_active_for_network( $entry['plugin_file'] ) : is_plugin_active( $entry['plugin_file'] ) );
  $response = [ 'installed' => $installed, 'active' => $active, 'network_active' => $installed && is_plugin_active_for_network($entry['plugin_file']), 'message' => self::t( $active ? 'Already active' : ( $installed ? 'Installed' : 'Not installed. You can try again.' ) ) ];
  if ( $operation === 'update' ) {
   $response['updated'] = $installed && version_compare( $plugins[$entry['plugin_file']]['Version'] ?? '0', $entry['version'], '>=' );
   $response['version'] = $plugins[$entry['plugin_file']]['Version'] ?? '';
   $response['message'] = $response['updated'] ? self::t( 'Updated' ) : self::t( 'The update has not been confirmed. You can try again.' );
   if ( ! $response['updated'] ) { $response['installed'] = false; $response['active'] = false; }
   if ( $response['updated'] && ! $active && current_user_can( 'activate_plugin', $entry['plugin_file'] ) && ! Requirements::check( $entry, $plugins, $this->network ) ) { $response['next'] = [ 'nonce' => wp_create_nonce( 'dwl_activate_' . $slug ), 'label' => self::t( $this->network ? 'Network activate' : 'Activate' ) ]; }
   wp_send_json_success( $response );
  }
  if ( $installed && ! $active && current_user_can( 'activate_plugin', $entry['plugin_file'] ) && ! Requirements::check( $entry, $plugins, $this->network ) ) {
   $response['next'] = [ 'nonce' => wp_create_nonce( 'dwl_activate_' . $slug ), 'label' => self::t( $this->network ? 'Network activate' : 'Activate' ) ];
  }
  wp_send_json_success( $response );
 }

 /**
  * Install or activate a freshly approved package without leaving its catalog card.
  *
  * @return void Sends a JSON response and terminates the AJAX request.
  * Checks capabilities, nonce, network scope and package identity; releases its action lock.
  */
 public function inline_action(): void {
  if ( ( isset( $_SERVER['REQUEST_METHOD'] ) && is_string( $_SERVER['REQUEST_METHOD'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) : '' ) !== 'POST' ) { wp_send_json_error( [ 'message' => self::t( 'POST required.' ) ], 405 ); }
  $slug = $this->slug();
  $operation = isset( $_POST['operation'] ) && is_string( $_POST['operation'] ) ? sanitize_key( wp_unslash( $_POST['operation'] ) ) : '';
  if ( ! in_array( $operation, [ 'install', 'activate', 'update' ], true ) || ! is_string( $_POST['_wpnonce'] ?? null ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'dwl_' . $operation . '_' . $slug ) ) { wp_send_json_error( [ 'message' => self::t( 'Permission denied.' ) ], 403 ); }
  $this->network = is_multisite() && ( isset( $_POST['network'] ) && is_string( $_POST['network'] ) ? sanitize_text_field( wp_unslash( $_POST['network'] ) ) : '' ) === '1';
  if ( ! current_user_can( $operation === 'install' ? 'install_plugins' : ( $operation === 'update' ? 'update_plugins' : 'activate_plugins' ) ) || ( $this->network && ! current_user_can( 'manage_network_plugins' ) ) ) { wp_send_json_error( [ 'message' => self::t( 'Permission denied.' ) ], 403 ); }
  if ( ! self::settings()['enabled'] ) { wp_send_json_error( [ 'message' => self::t( 'The catalog is disabled.' ) ], 403 ); }
  $entries = $this->catalog->entries( true );
  if ( is_wp_error( $entries ) ) { wp_send_json_error( [ 'message' => $entries->get_error_message() ] ); }
  if ( ! isset( $entries[$slug] ) ) { wp_send_json_error( [ 'message' => self::t( 'This release is not approved.' ) ], 404 ); }
  $entry = $entries[$slug];
  $issues = Requirements::check( $entry, null, $operation === 'update' ? is_plugin_active_for_network( $entry['plugin_file'] ) : $this->network, $operation !== 'update' );
  if ( $issues ) { wp_send_json_error( [ 'message' => implode( ' ', $issues ) ] ); }
  $lock = 'dwl_inline_lock_' . $slug;
  $lock_blog = is_multisite() ? get_main_site_id( get_main_network_id() ) : get_current_blog_id();
  if ( $lock_blog !== get_current_blog_id() ) { switch_to_blog( $lock_blog ); $switched = true; } else { $switched = false; }
  $lock_value = time() . ':' . wp_generate_uuid4();
  $previous = get_option( $lock );
  if ( is_string( $previous ) && (int) $previous < time() - 900 ) {
   // Recover abandoned requests; compare the stored token before deletion.
   global $wpdb;
   $wpdb->delete( $wpdb->options, [ 'option_name' => $lock, 'option_value' => $previous ] );
   wp_cache_delete( $lock, 'options' );
  }
  $locked = add_option( $lock, $lock_value, '', false );
  if ( $switched ) { restore_current_blog(); }
  if ( ! $locked ) { wp_send_json_error( [ 'message' => self::t( 'Another action for this plugin is running. Please wait.' ) ] ); }
  $lock_held = true;
  /**
   * Release only this request's atomic installation-wide option lock.
   * @return void Removes the lock from the main network site and restores blog context.
   */
  $release_lock = static function() use ( $lock, $lock_blog, $lock_value, &$lock_held ): void {
   if ( ! $lock_held ) { return; }
   $switched = $lock_blog !== get_current_blog_id();
   if ( $switched ) { switch_to_blog( $lock_blog ); }
   if ( get_option( $lock ) === $lock_value ) { delete_option( $lock ); }
   if ( $switched ) { restore_current_blog(); }
   $lock_held = false;
  };
  register_shutdown_function( $release_lock );
  $package = null; $response = []; $error = null; $level = ob_get_level(); ob_start();
  try {
   require_once ABSPATH . 'wp-admin/includes/plugin.php';
   require_once ABSPATH . 'wp-admin/includes/file.php';
   if ( $operation === 'update' ) {
    $response = $this->perform_update( $entry );
   } elseif ( $operation === 'install' ) {
    if ( is_dir( WP_PLUGIN_DIR . '/' . $entry['slug'] ) ) { throw new \RuntimeException( self::t( 'This plugin directory already exists. Use the installed plugin; it will not be overwritten.' ) ); }
    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
    require_once __DIR__ . '/CatalogInstaller.php';
    $skin = new \WP_Ajax_Upgrader_Skin();
    $upgrader = new CatalogInstaller( $skin, $entry['plugin_file'] );
    if ( ! $upgrader->fs_connect( [ WP_CONTENT_DIR, WP_PLUGIN_DIR ] ) ) {
     $response = [ 'credentials' => true, 'message' => self::t( 'Filesystem credentials are required.' ) ];
    } else {
     $package = Package::download( $entry );
     if ( is_wp_error( $package ) ) { throw new \RuntimeException( $package->get_error_message() ); }
     $result = $upgrader->install( $package, [ 'clear_update_cache' => false, 'overwrite_package' => false ] );
     if ( $result !== true || $skin->get_errors()->has_errors() ) { throw new \RuntimeException( is_wp_error( $result ) ? $result->get_error_message() : ( $skin->get_errors()->has_errors() ? $skin->get_errors()->get_error_message() : self::t( 'Installation failed.' ) ) ); }
     wp_clean_plugins_cache( false );
     $managed = get_site_option( self::MANAGED, [] ); $managed = is_array( $managed ) ? $managed : [];
     $managed[$entry['plugin_file']] = $entry['repository']; update_site_option( self::MANAGED, $managed );
     $response = [ 'installed' => true, 'message' => self::t( 'Installed' ) ];
    }
   } else {
    if ( ! current_user_can( 'activate_plugin', $entry['plugin_file'] ) ) { throw new \RuntimeException( self::t( 'Permission denied.' ) ); }
    if ( ! is_file( WP_PLUGIN_DIR . '/' . $entry['plugin_file'] ) ) { throw new \RuntimeException( self::t( 'Plugin is not installed.' ) ); }
    $result = activate_plugin( $entry['plugin_file'], '', $this->network, false );
    if ( is_wp_error( $result ) ) { throw new \RuntimeException( $result->get_error_message() ); }
    $response = [ 'active' => true, 'network_active' => $this->network, 'message' => self::t( $this->network ? 'Network active' : 'Active' ) ];
   }
   if ( ! empty( $response['installed'] ) && ( empty( $response['updated'] ) || ! ( $this->network ? is_plugin_active_for_network( $entry['plugin_file'] ) : is_plugin_active( $entry['plugin_file'] ) ) ) ) {
    $issues = Requirements::check( $entry, null, $this->network );
    if ( ! $issues && current_user_can( 'activate_plugin', $entry['plugin_file'] ) ) {
     $response['next'] = [ 'nonce' => wp_create_nonce( 'dwl_activate_' . $slug ), 'label' => self::t( $this->network ? 'Network activate' : 'Activate' ) ];
    } elseif ( $issues ) { $response['message'] .= ' ' . implode( ' ', $issues ); }
   }
  } catch ( \Throwable $exception ) { $error = wp_strip_all_tags( $exception->getMessage() ); }
  finally {
   if ( is_string( $package ) ) { Package::remove( $package ); }
   while ( ob_get_level() > $level ) { ob_end_clean(); }
   $release_lock();
  }
  if ( $error !== null ) { wp_send_json_error( [ 'message' => $error, 'operation' => $operation, 'code' => 'dwl_' . $operation . '_failed' ] ); }
  if ( ! empty( $response['credentials'] ) ) { wp_send_json_error( $response ); }
  wp_send_json_success( $response );
 }

 /**
  * Match installed header identity to the exact approved repository before explicit adoption.
  * @param array $entry Approved catalog metadata.
  * @param array $headers Installed plugin header metadata.
  * @return bool Whether name and a repository identity header match without a foreign Update URI.
  */
 private function update_identity( array $entry, array $headers ): bool {
  $repo = 'https://github.com/' . $entry['repository'];
  if ( ( $headers['Name'] ?? '' ) !== $entry['name'] ) { return false; }
  if ( ! empty( $headers['UpdateURI'] ) && rtrim( $headers['UpdateURI'], '/' ) !== $repo ) { return false; }
  $custom = get_file_data( WP_PLUGIN_DIR . '/' . $entry['plugin_file'], [ 'github' => 'GitHub Plugin URI' ] );
  return rtrim( $headers['PluginURI'] ?? '', '/' ) === $repo || rtrim( $headers['UpdateURI'] ?? '', '/' ) === $repo || rtrim( $custom['github'] ?? '', '/' ) === $repo;
 }

 /**
  * Match an existing update offer to the explicitly approved release identity.
  * @param array $entry Validated catalog entry with pinned asset URL and version.
  * @param mixed $existing Native updater offer; no fields are trusted implicitly.
  * @return bool True for the exact asset or same-repository, same-tag GitHub source archive.
  * A matching source URL is never downloaded; only the independently verified catalog asset is used.
  */
 private static function compatible_offer( array $entry, $existing ): bool {
  if ( ! is_array( $existing ) && ! is_object( $existing ) ) { return false; }
  $offer = (array) $existing;
  if ( ( $offer['new_version'] ?? null ) !== $entry['version'] || ( isset( $offer['plugin'] ) && $offer['plugin'] !== $entry['plugin_file'] ) || ! is_string( $offer['package'] ?? null ) ) { return false; }
  if ( $offer['package'] === $entry['download_url'] ) { return true; }
  $url = wp_parse_url( $offer['package'] );
  if ( ! is_array( $url ) || ( $url['scheme'] ?? '' ) !== 'https' || ( $url['host'] ?? '' ) !== 'api.github.com' ) { return false; }
  foreach ( [ 'user', 'pass', 'port', 'query', 'fragment' ] as $part ) { if ( isset( $url[$part] ) ) { return false; } }
  if ( preg_match( '/[\x00-\x20\x7f]/', $offer['package'] ) ) { return false; }
  if ( ! preg_match( '~^https://github\.com/' . preg_quote( $entry['repository'], '~' ) . '/releases/download/([a-zA-Z0-9_.-]+)/[a-zA-Z0-9_.-]+\.zip$~D', $entry['download_url'], $tag ) ) { return false; }
  return ( $url['path'] ?? '' ) === '/repos/' . $entry['repository'] . '/zipball/' . $tag[1];
 }

 /**
  * Update an explicitly selected installed plugin through the native upgrader and verified package.
  * @param array $entry Freshly approved catalog metadata with exact package hash.
  * @return array Result flags and message; credentials flag requests the native modal.
  * @throws \RuntimeException On identity, policy, competing offer or upgrader failure.
  * Registers successful adoption only after upgrade; retains native activation/data behavior.
  */
 private function perform_update( array $entry ): array {
  if ( ! current_user_can( 'update_plugins' ) || ( is_multisite() && ! current_user_can( 'manage_network_plugins' ) ) ) { throw new \RuntimeException( self::t( 'Permission denied.' ) ); }
  require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
  $plugins = get_plugins(); $file = $entry['plugin_file'];
  if ( ! isset( $plugins[$file] ) || ! $this->update_identity( $entry, $plugins[$file] ) ) { throw new \RuntimeException( self::t( 'The installed plugin identity could not be verified for this catalog update.' ) ); }
  if ( ! version_compare( $entry['version'], $plugins[$file]['Version'] ?? '0', '>' ) ) { return [ 'updated' => true, 'message' => self::t( 'Already up to date.' ) ]; }
  $issues = Requirements::check( $entry, $plugins, is_plugin_active_for_network( $file ), false );
  if ( $issues ) { throw new \RuntimeException( implode( ' ', $issues ) ); }
  $current = get_site_transient( 'update_plugins' );
  $existing = is_object( $current ) ? ( $current->response[$file] ?? null ) : null;
  if ( $existing && ! self::compatible_offer( $entry, $existing ) ) { throw new \RuntimeException( self::t( 'Another updater provides a different release. Refresh updates before continuing.' ) ); }
  $skin = new \WP_Ajax_Upgrader_Skin(); $upgrader = new \Plugin_Upgrader( $skin );
  if ( ! $upgrader->fs_connect( [ WP_CONTENT_DIR, WP_PLUGIN_DIR ] ) ) { return [ 'credentials' => true, 'message' => self::t( 'Filesystem credentials are required.' ) ]; }
  $package = Package::download( $entry );
  if ( is_wp_error( $package ) ) { throw new \RuntimeException( $package->get_error_message() ); }
  $offer = (object) [ 'slug' => $entry['slug'], 'plugin' => $file, 'new_version' => $entry['version'], 'package' => $entry['download_url'], 'url' => 'https://github.com/' . $entry['repository'] ];
  $temporary = is_object( $current ) ? clone $current : (object) [ 'checked' => [], 'response' => [] ];
  $temporary->response[$file] = $offer;
  /**
   * Supply the already verified package only to this exact native update request.
   * @param mixed $reply Existing download result.
   * @param string $url Native requested package URL.
   * @param mixed $instance Native upgrader instance.
   * @param array $extra Native context with plugin basename.
   * @return mixed Verified archive path for this request, otherwise the previous result.
   */
  $download = static function( $reply, string $url, $instance, array $extra ) use ( $file, $entry, $package, $upgrader ) { if ( $instance !== $upgrader || ( $extra['plugin'] ?? '' ) !== $file ) { return $reply; } if (is_wp_error($reply)) { return $reply; } return $url === $entry['download_url'] ? $package : new \WP_Error( 'dwl_release_changed', self::t( 'The approved release changed. Refresh updates first.' ) ); };
  /**
   * Keep this explicit verified native update bound to its approved asset.
   * @param mixed $value Core update state after other updater filters.
   * @return mixed Copy with only the selected plugin offer replaced; unrelated offers remain intact.
   * Registered only around this one native upgrade and removed in finally.
   */
  $approved_offer = static function( $value ) use ( $file, $offer ) {
   if ( ! is_object( $value ) ) { return $value; }
   $copy = clone $value;
   $copy->response = is_array( $copy->response ?? null ) ? $copy->response : [];
   $copy->response[$file] = $offer;
   return $copy;
  };
  $this->explicit_upgrader = $upgrader;
  add_filter( 'site_transient_update_plugins', $approved_offer, PHP_INT_MAX );
  add_filter( 'upgrader_pre_download', $download, PHP_INT_MAX, 4 );
  try {
   set_site_transient( 'update_plugins', $temporary );
   $results = $upgrader->bulk_upgrade( [ $file ], [ 'clear_update_cache' => false ] );
   $result = is_array( $results ) ? ( $results[$file] ?? false ) : $results;
   if ( ! is_array( $result ) || $skin->get_errors()->has_errors() ) { throw new \RuntimeException( is_wp_error( $result ) ? $result->get_error_message() : ( $skin->get_errors()->has_errors() ? $skin->get_errors()->get_error_message() : self::t( 'Update failed.' ) ) ); }
   wp_clean_plugins_cache( false ); $after = get_plugins();
   if ( ! isset( $after[$file] ) || $after[$file]['Version'] !== $entry['version'] ) { throw new \RuntimeException( self::t( 'The update has not been confirmed. You can try again.' ) ); }
   $managed = get_site_option( self::MANAGED, [] ); $managed = is_array( $managed ) ? $managed : [];
   $managed[$file] = $entry['repository']; update_site_option( self::MANAGED, $managed );
   return [ 'updated' => true, 'installed' => true, 'active' => is_plugin_active($file), 'network_active' => is_plugin_active_for_network($file), 'version' => $entry['version'], 'message' => self::t( 'Updated' ) ];
  } finally {
   remove_filter( 'site_transient_update_plugins', $approved_offer, PHP_INT_MAX );
   remove_filter( 'upgrader_pre_download', $download, PHP_INT_MAX ); $this->explicit_upgrader = null; Package::remove( $package );
   // Invalidate the temporary offer rather than overwriting concurrent updater results.
   delete_site_transient( 'update_plugins' );
  }
 }

 /**
  * Perform a native no-JavaScript update inside WordPress administration and return to the catalog.
  * @return void Verifies authorization and terminates after an admin redirect or escaped error.
  */
 public function update(): void {
  $slug = $this->slug(); $this->authorize( 'update', 'update_plugins', $slug ); $entry = $this->entry( $slug );
  require_once ABSPATH . 'wp-admin/includes/plugin.php'; require_once ABSPATH . 'wp-admin/includes/file.php';
  $lock = 'dwl_inline_lock_' . $slug; $blog = is_multisite() ? get_main_site_id( get_main_network_id() ) : get_current_blog_id();
  $token = time() . ':' . wp_generate_uuid4(); $switched = $blog !== get_current_blog_id();
  if ( $switched ) { switch_to_blog( $blog ); }
  $previous = get_option( $lock );
  if ( is_string( $previous ) && (int) $previous < time() - 900 ) { global $wpdb; $wpdb->delete( $wpdb->options, [ 'option_name' => $lock, 'option_value' => $previous ] ); wp_cache_delete( $lock, 'options' ); }
  $locked = add_option( $lock, $token, '', false ); if ( $switched ) { restore_current_blog(); }
  if ( ! $locked ) { wp_die( esc_html( self::t( 'Another action for this plugin is running. Please wait.' ) ) ); }
  /**
   * Release the no-JavaScript update lock without deleting another request's token.
   * @return void Restores blog context and removes only this action's main-site lock.
   */
  $unlock = static function() use ( $lock, $blog, $token ): void {
   $switched = $blog !== get_current_blog_id(); if ( $switched ) { switch_to_blog( $blog ); }
   if ( get_option( $lock ) === $token ) { delete_option( $lock ); }
   if ( $switched ) { restore_current_blog(); }
  };
  register_shutdown_function( $unlock );
  try { $result = $this->perform_update( $entry ); }
  catch ( \Throwable $error ) { wp_die( esc_html( $error->getMessage() ) ); }
  finally { $unlock(); }
  if ( ! empty( $result['credentials'] ) ) { wp_die( esc_html( self::t( 'Filesystem credentials are required. Use the catalog with JavaScript enabled or the native Plugins screen.' ) ) ); }
  wp_safe_redirect( $this->catalog_url() ); exit;
 }

	/**
	 * Verify and install an approved package through the native WordPress upgrader.
	 *
	 * @return void No return value.
	 */
	public function install(): void {
		$slug = $this->slug(); $this->authorize( 'install', 'install_plugins', $slug );
		$entry = $this->entry( $slug ); $this->enforce_requirements( $entry );
		if ( is_dir( WP_PLUGIN_DIR . '/' . $entry['slug'] ) ) { wp_die( esc_html( self::t( 'This plugin directory already exists. Use the installed plugin; it will not be overwritten.' ) ) ); }
		require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		$title = self::t( 'Install deckerweb plugin' );
		if ( $this->network && ! defined( 'WP_NETWORK_ADMIN' ) ) { define( 'WP_NETWORK_ADMIN', true ); }
		// admin-post.php has no initialized sidebar/menu. Use WordPress's native
		// standalone upgrader chrome instead of including admin-header prematurely.
		require_once ABSPATH . 'wp-admin/includes/admin.php';
		$GLOBALS['hook_suffix'] = 'deckerweb-library-install';
		set_current_screen( $this->network ? 'plugin-install-network' : 'plugin-install' );
		wp_enqueue_style( 'common' ); wp_enqueue_style( 'forms' );
		wp_enqueue_style( 'deckerweb-plugin-library', plugins_url( 'assets/library.css', $this->chosen['dir'] . '/bootstrap.php' ), [], self::VERSION );
		/**
		 * Add the installer scope to the native administration body classes.
		 * @param string $classes Existing space-delimited body classes.
		 * @return string Existing classes with the Library installer marker.
		 */
		$body_class = static fn( string $classes ): string => $classes . ' dwl-install';
		add_filter( 'admin_body_class', $body_class );
		iframe_header( esc_html( $title ) );
		remove_filter( 'admin_body_class', $body_class );
		echo '<div class="wrap"><h1>' . esc_html( $title ) . '</h1>';
		$url = wp_nonce_url( $this->action_url( 'install', $slug ), 'dwl_install_' . $slug );
		$credentials = request_filesystem_credentials( $url, '', false, WP_PLUGIN_DIR );
		if ( $credentials === false ) { echo '</div>'; iframe_footer(); return; }
		if ( ! WP_Filesystem( $credentials, WP_PLUGIN_DIR ) ) { request_filesystem_credentials( $url, '', true, WP_PLUGIN_DIR ); echo '</div>'; iframe_footer(); return; }
		$package = Package::download( $entry );
		if ( is_wp_error( $package ) ) { echo '<div class="notice notice-error"><p>' . esc_html( $package->get_error_message() ) . '</p></div>'; }
		else {
			/** Installer skin with wrappers suppressed because this page supplies them. */
			$skin = new class( [ 'type' => 'web', 'url' => $url, 'nonce' => 'dwl_install_' . $slug, 'title' => $title, 'api' => (object) [ 'name' => $entry['name'], 'slug' => $entry['slug'], 'version' => $entry['version'] ] ] ) extends \Plugin_Installer_Skin {
				// The standalone page already owns its heading and wrapper.
				/**
				 * Suppress automatic upgrader skin output while the Library renders its own result.
				 *
				 * @return void No return value.
				 */
				public function header() {}
				/**
				 * Suppress automatic upgrader footer output while the Library renders its own result.
				 *
				 * @return void No return value.
				 */
				public function footer() {}
			};
			$upgrader = new \Plugin_Upgrader( $skin );
			/**
			 * Replace installer activation links with dependency-aware Library actions.
			 * @param array $links Existing installer links.
			 * @param object $api Native plugin information supplied by the installer skin.
			 * @param string $file Installed plugin basename.
			 * @return array Updated action links; unrelated packages remain untouched.
			 */
			$actions = function( array $links, $api, string $file ) use ( $entry ): array {
				unset( $links['activate_plugin'], $links['network_activate'] );
				if ( $file === $entry['plugin_file'] && ! Requirements::check( $entry, null, $this->network ) && current_user_can( 'activate_plugin', $file ) ) {
					ob_start(); $this->form( 'activate', $entry['slug'], $this->network ? self::t( 'Network activate' ) : self::t( 'Activate' ), 'button button-primary' ); $links['dwl_activate'] = ob_get_clean();
				}
				$links['dwl_catalog'] = '<a href="' . esc_url( $this->catalog_url() ) . '">' . esc_html( self::t( 'Back to deckerweb' ) ) . '</a>';
				return $links;
			};
			add_filter( 'install_plugin_complete_actions', $actions, 10, 3 );
			try { $result = $upgrader->install( $package, [ 'clear_update_cache' => false, 'overwrite_package' => false ] ); }
			finally { remove_filter( 'install_plugin_complete_actions', $actions, 10 ); Package::remove( $package ); }
			if ( $result === true ) {
				$managed = get_site_option( self::MANAGED, [] ); $managed = is_array( $managed ) ? $managed : [];
				$managed[$entry['plugin_file']] = $entry['repository']; update_site_option( self::MANAGED, $managed );
			}
		}
		echo '</div>'; iframe_footer();
	}
	/**
	 * Activate an approved installed plugin after current approval and dependency checks.
	 *
	 * @return void No return value.
	 */
	public function activate(): void {
		$slug = $this->slug(); $this->authorize( 'activate', 'activate_plugins', $slug );
		$entry = $this->entry( $slug );
		if ( ! current_user_can( 'activate_plugin', $entry['plugin_file'] ) ) { wp_die( esc_html( self::t( 'Permission denied.' ) ), '', [ 'response' => 403 ] ); }
		$this->enforce_requirements( $entry );
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		if ( ! is_file( WP_PLUGIN_DIR . '/' . $entry['plugin_file'] ) ) { wp_die( esc_html( self::t( 'Plugin is not installed.' ) ) ); }
		$result = activate_plugin( $entry['plugin_file'], '', $this->network, false );
		if ( is_wp_error( $result ) ) { wp_die( esc_html( $result->get_error_message() ) ); }
		wp_safe_redirect( add_query_arg( 'dwl_done', '1', $this->catalog_url() ) ); exit;
	}
	/**
	 * Apply dependency checks to known plugins activated through the ordinary Plugins screen.
	 *
	 * @param string $file Plugin basename identifying the target plugin.
	 * @param bool $network Whether WordPress is activating the target across the network.
	 * @return void No return value.
	 */
	public function activation_guard( string $file, bool $network ): void {
		$managed = get_site_option( self::MANAGED, [] );
		$bundled = json_decode( (string) ( is_file( $this->chosen['dir'] . '/catalog.json' ) ? file_get_contents( $this->chosen['dir'] . '/catalog.json' ) : '' ), true );
		$known = array_column( $bundled['plugins'] ?? [], 'plugin_file' );
		if ( ! in_array( $file, $known, true ) && ! isset( $managed[$file] ) ) { return; }
		// Hiding discovery must never remove runtime dependency protection.
		$entries = $this->catalog->entries();
		if ( is_wp_error( $entries ) ) { return; }
		foreach ( $entries as $entry ) { if ( $entry['plugin_file'] === $file ) { $this->enforce_requirements( $entry, $network ); return; } }
	}
	/**
	 * Add update offers only for Library-managed plugins without their own Update URI.
	 *
	 * @param mixed $transient Native update transient with checked plugin versions and existing offers.
	 * @return mixed The supplied native update transient with eligible managed offers added.
	 */
	public function updates( $transient ) {
		if ( ! is_object( $transient ) || empty( $transient->checked ) ) { return $transient; }
		$managed = get_site_option( self::MANAGED, [] );
		if ( ! is_array( $managed ) || ! $managed ) { return $transient; }
		$entries = $this->catalog->entries( false, true );
		if ( is_wp_error( $entries ) ) { return $transient; }
		require_once ABSPATH . 'wp-admin/includes/plugin.php'; $plugins = get_plugins();
		foreach ( $entries as $e ) {
			$file = $e['plugin_file'];
			if ( ! isset( $managed[$file], $plugins[$file], $transient->checked[$file] ) || $managed[$file] !== $e['repository'] || ! empty( $plugins[$file]['UpdateURI'] ) || isset( $transient->response[$file] ) || ! version_compare( $e['version'], $transient->checked[$file], '>' ) ) { continue; }
			$transient->response[$file] = (object) [ 'id' => 'https://github.com/' . $e['repository'], 'slug' => $e['slug'], 'plugin' => $file, 'new_version' => $e['version'], 'url' => 'https://github.com/' . $e['repository'], 'package' => $e['download_url'], 'requires' => $e['requires_wp'], 'requires_php' => $e['requires_php'], 'dwl_managed' => true ];
		}
		return $transient;
	}
	/**
	 * Verify current approval, dependencies and the exact native update package.
	 *
	 * @param mixed $reply Earlier download result; false means not handled.
	 * @param string $package Exact offered release ZIP URL.
	 * @param mixed $upgrader Native WordPress upgrader instance.
	 * @param array $extra Additional action fields or native upgrader context.
	 * @return mixed Existing handled download, verified local package path, WP_Error, or the original unhandled value.
	 */
	public function update_download( $reply, string $package, $upgrader, array $extra = [] ) {
  if ( $this->explicit_upgrader !== null && $upgrader === $this->explicit_upgrader ) { return $reply; }
  if ( ( $extra['action'] ?? '' ) === 'install' ) { return $reply; }
		$file = $extra['plugin'] ?? '';
		$managed = get_site_option( self::MANAGED, [] );
		if ( ! is_string( $file ) || ! is_array( $managed ) || ! isset( $managed[$file] ) ) { return $reply; }
		if ( false !== $reply ) { return $reply; }
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
		$plugins = get_plugins();
		if ( ! empty( $plugins[$file]['UpdateURI'] ) ) { return $reply; }
		$entries = $this->catalog->entries( true );
		if ( is_wp_error( $entries ) ) { return $entries; }
		foreach ( $entries as $entry ) {
			if ( $entry['plugin_file'] !== $file || $entry['repository'] !== $managed[$file] ) { continue; }
			if ( $package !== $entry['download_url'] ) { return new \WP_Error( 'dwl_release_changed', self::t( 'The approved release changed. Refresh updates first.' ) ); }
			$issues = Requirements::check( $entry, null, is_plugin_active_for_network( $file ), false );
			if ( $issues ) { return new \WP_Error( 'dwl_requirements', implode( ' ', $issues ) ); }
			return Package::download( $entry );
		}
		return new \WP_Error( 'dwl_withdrawn', self::t( 'This release is no longer approved.' ) );
	}
 /**
  * Supply opted-in public host updater metadata from the independent update cache.
  *
  * @param string $repository Exact public GitHub repository URL.
  * @param string $file Plugin basename identifying the target plugin.
  * @param bool $fresh Require a successful uncached source read.
  * @return array|null|false Release metadata, false for direct-updater fallback, or null when approval is refused.
  */
 public function updater_release( string $repository, string $file, bool $fresh = false ) {
  if ( ! self::settings()['online'] ) { return false; }
  $fresh = $fresh || ( is_admin() && current_user_can( 'update_plugins' ) && self::query( 'force-check' ) === '1' );
  $entries = $this->catalog->entries( $fresh, true );
  if ( is_wp_error( $entries ) ) { return null; }
  foreach ( $entries as $entry ) {
   if ( $entry['plugin_file'] !== $file || 'https://github.com/' . $entry['repository'] !== $repository ) { continue; }
   return [ 'version' => $entry['version'], 'package' => $entry['download_url'], 'notes' => self::text( $entry, 'description' ), 'published' => $entry['published_at'] ?? '', 'requires_wp' => $entry['requires_wp'], 'requires_php' => $entry['requires_php'], 'sha256' => $entry['sha256'] ];
  }
  return null;
 }
 /**
  * Download the opted-in host package only after fresh approval and requirement checks.
  *
  * @param string $repository Exact public GitHub repository URL.
  * @param string $file Plugin basename identifying the target plugin.
  * @param string $package Exact offered release ZIP URL.
  * @return string|\WP_Error Verified temporary package path or WP_Error when approval or requirements fail.
  * Successful temporary archives must be removed by the caller after use.
  */
 public function updater_package( string $repository, string $file, string $package ) {
  $entries = $this->catalog->entries( true, true );
  if ( is_wp_error( $entries ) ) { return $entries; }
  foreach ( $entries as $entry ) {
   if ( $entry['plugin_file'] !== $file || 'https://github.com/' . $entry['repository'] !== $repository ) { continue; }
   if ( $package !== $entry['download_url'] ) { return new \WP_Error( 'dwl_release_changed', self::t( 'The approved release changed. Refresh updates first.' ) ); }
   $issues = Requirements::check( $entry, null, is_plugin_active_for_network( $file ), false );
   if ( $issues ) { return new \WP_Error( 'dwl_requirements', implode( ' ', $issues ) ); }
   return Package::download( $entry );
  }
  return new \WP_Error( 'dwl_withdrawn', self::t( 'This release is no longer approved.' ) );
 }

}
