<?php
/** Copyright 2026 David Decker – DECKERWEB. SPDX-License-Identifier: GPL-2.0-or-later */
namespace Deckerweb\PluginLibrary\V1_1_0;
if ( ! defined( 'ABSPATH' ) ) { exit; }

/** Verify the original release, then normalize a bounded, single-plugin archive. */
final class Package {
	const MAX_DOWNLOAD = 20971520;
	const MAX_EXPANDED = 83886080;
	/**
	 * Download a bounded approved ZIP and return its verified normalized archive.
	 *
	 * @param array $entry Validated approved catalog entry and dependency metadata.
	 * @return string|\WP_Error Verified normalized temporary ZIP path or WP_Error; caller must remove successful files.
	 * Successful temporary archives must be removed by the caller after use.
	 */
	public static function download( array $entry ) {
		if ( ! class_exists( '\ZipArchive' ) ) { return new \WP_Error( 'dwl_zip', Library::t( 'PHP ZIP support is required.' ) ); }
		require_once ABSPATH . 'wp-admin/includes/file.php';
		if ( ! Catalog::download_url( $entry['download_url'], $entry['repository'] ) ) { return new \WP_Error( 'dwl_url', Library::t( 'Untrusted release URL.' ) ); }
		$file = wp_tempnam( 'dwl-' . $entry['slug'] . '.zip' );
		if ( ! $file ) { return new \WP_Error( 'dwl_temp', Library::t( 'Cannot create temporary file.' ) ); }
		self::track( $file );
  $response = wp_safe_remote_get( $entry['download_url'], [
			'user-agent' => 'deckerweb-plugin-library/' . Library::VERSION,
			'timeout' => 45, 'redirection' => 5, 'stream' => true, 'filename' => $file,
			'limit_response_size' => self::MAX_DOWNLOAD + 1,
			'headers' => [ 'Accept' => 'application/octet-stream' ],
		] );
		if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) !== 200 ) {
			self::remove( $file );
			return new \WP_Error( 'dwl_download', Library::t( 'The GitHub release could not be downloaded.' ) );
		}
		$result = self::verify( $file, $entry );
		self::remove( $file );
		return $result;
	}

	/**
	 * Check the original checksum and ZIP safety, then stream a normalized temporary package.
	 *
	 * @param string $file Original ZIP file path.
	 * @param array $entry Validated approved catalog entry and dependency metadata.
	 * @return string|\WP_Error Verified normalized temporary ZIP path or WP_Error; original input file is not removed.
	 * Successful temporary archives must be removed by the caller after use.
	 */
	public static function verify( string $file, array $entry ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		if ( ! class_exists( '\ZipArchive' ) ) { return new \WP_Error( 'dwl_zip', Library::t( 'PHP ZIP support is required.' ) ); }
		if ( ! is_file( $file ) || filesize( $file ) > self::MAX_DOWNLOAD || ! hash_equals( $entry['sha256'], (string) hash_file( 'sha256', $file ) ) ) {
			return new \WP_Error( 'dwl_hash', Library::t( 'The release checksum does not match. Installation stopped.' ) );
		}
		$zip = new \ZipArchive();
		if ( $zip->open( $file ) !== true ) { return new \WP_Error( 'dwl_zip', Library::t( 'Invalid ZIP archive.' ) ); }
		$names = []; $expanded = 0; $seen = [];
		$error = '';
		if ( $zip->numFiles > 3000 ) { $error = 'Archive contains too many files.'; }
		for ( $i = 0; $i < $zip->numFiles && $error === ''; $i++ ) {
			$stat = $zip->statIndex( $i );
			if ( ! is_array( $stat ) ) { $error = 'Cannot read archive entry.'; break; }
			$name = $stat['name'];
			if ( strpos( $name, "\0" ) !== false || strpos( $name, '\\' ) !== false || preg_match( '~(^|/)\.\.?(/|$)~', $name ) || str_starts_with( $name, '/' ) ) { $error = 'Unsafe archive path.'; break; }
			$expanded += (int) $stat['size'];
			if ( $expanded > self::MAX_EXPANDED ) { $error = 'Expanded archive is too large.'; break; }
			$opsys = 0; $attrs = 0;
			$zip->getExternalAttributesIndex( $i, $opsys, $attrs );
			if ( ( ( $attrs >> 16 ) & 0170000 ) === 0120000 ) { $error = 'Archive symlinks are not permitted.'; break; }
			// Old release ZIPs may contain Finder resource forks; never install them.
			if ( str_starts_with( $name, '__MACOSX/' ) || basename( $name ) === '.DS_Store' ) { continue; }
			if ( ! str_starts_with( $name, $entry['slug'] . '/' ) || isset( $seen[$name] ) ) { $error = 'Release must contain exactly the approved plugin directory.'; break; }
			$seen[$name] = true;
			$names[] = $name;
		}
		if ( $error !== '' ) { $zip->close(); return new \WP_Error( 'dwl_package', Library::t( $error ) ); }
  $main_stat = $zip->statName( $entry['plugin_file'] );
  if ( ! is_array( $main_stat ) || $main_stat['size'] > 2097152 ) { $zip->close(); return new \WP_Error( 'dwl_package', Library::t( 'Plugin identity or version does not match the catalog.' ) ); }
  $main = $zip->getFromName( $entry['plugin_file'], 8192 );
		if ( $error === '' && ( ! is_string( $main ) || strlen( $main ) > 2097152 || ! preg_match( '/^[ \t\/*#@]*Version:\s*([^\r\n]+)/mi', substr( $main, 0, 8192 ), $match ) || trim( $match[1] ) !== $entry['version'] ) ) { $error = 'Plugin identity or version does not match the catalog.'; }
		if ( $error === '' && ! preg_match( '/^[ \t\/*#@]*Plugin Name:\s*\S+/mi', substr( $main, 0, 8192 ) ) ) { $error = 'Missing plugin header.'; }
		if ( $error !== '' ) { $zip->close(); return new \WP_Error( 'dwl_package', Library::t( $error ) ); }
		$safe_file = wp_tempnam( 'dwl-' . $entry['slug'] . '-verified.zip' );
		$safe = new \ZipArchive();
  $staging = $safe_file . '-files';
  if ( $safe_file ) { self::track( $safe_file ); self::track( $staging ); }
  $staged = [];
  if ( ! $safe_file || ! mkdir( $staging, 0700 ) ) { $zip->close(); if ( $safe_file ) { self::remove( $safe_file ); } return new \WP_Error( 'dwl_temp', Library::t( 'Cannot create verified archive.' ) ); }
		if ( ! $safe_file || $safe->open( $safe_file, \ZipArchive::OVERWRITE ) !== true ) { $zip->close(); if ( $safe_file ) { self::remove( $safe_file ); rmdir( $staging ); } return new \WP_Error( 'dwl_temp', Library::t( 'Cannot create verified archive.' ) ); }
		foreach ( $names as $name ) {
			if ( str_ends_with( $name, '/' ) ) { $ok = $safe->addEmptyDir( rtrim( $name, '/' ) ); }
			else { $input = $zip->getStream( $name ); $temp = $staging . '/' . count( $staged );
    $output = fopen( $temp, 'xb' ); $staged[] = $temp;
    $expected = $zip->statName( $name )['size'];
    $copied = ( is_resource( $input ) && is_resource( $output ) ) ? stream_copy_to_stream( $input, $output, $expected + 1 ) : false;
    if ( is_resource( $input ) ) { fclose( $input ); } if ( is_resource( $output ) ) { fclose( $output ); }
    $ok = $copied === $expected && $safe->addFile( $temp, $name ); }
			if ( ! $ok ) { $error = 'Cannot normalize archive.'; break; }
		}
		$closed = $safe->close(); $zip->close();
  foreach ( $staged as $temp ) { wp_delete_file( $temp ); } rmdir( $staging ); self::untrack( $staging );
		if ( $error !== '' || ! $closed ) { self::remove( $safe_file ); return new \WP_Error( 'dwl_zip', Library::t( $error ?: 'Cannot finalize archive.' ) ); }
		return $safe_file;
	}
 /**
  * Register a component-owned temporary path for crash cleanup.
  *
  * @param string $path Component-owned temporary file or staging directory path.
  * @return void No return value.
  * May read or change component-owned shared storage; foreign plugin data is preserved.
  */
 private static function track( string $path ): void {
  $paths = get_site_option( 'deckerweb_library_temp_v2', [] );
  /**
   * Keep only existing tracked paths; expired entries need no deletion.
   * @param mixed $p Candidate path from component-owned storage.
   * @return bool Whether the path is a string naming an existing entry.
   */
  $paths = array_values( array_filter( is_array( $paths ) ? $paths : [], static fn( $p ): bool => is_string( $p ) && file_exists( $p ) ) );
  if ( ! in_array( $path, $paths, true ) ) { $paths[] = $path; update_site_option( 'deckerweb_library_temp_v2', $paths ); }
 }
 /**
  * Remove a temporary path from the shared cleanup registry.
  *
  * @param string $path Component-owned temporary file or staging directory path.
  * @return void No return value.
  * May read or change component-owned shared storage; foreign plugin data is preserved.
  */
 private static function untrack( string $path ): void {
  $paths = get_site_option( 'deckerweb_library_temp_v2', [] );
  if ( is_array( $paths ) ) { update_site_option( 'deckerweb_library_temp_v2', array_values( array_diff( $paths, [ $path ] ) ) ); }
 }
 /**
  * Delete a component temporary archive and unregister its cleanup path.
  *
  * @param string $path Component-owned temporary file or staging directory path.
  * @return void No return value.
  */
 public static function remove( string $path ): void { wp_delete_file( $path ); self::untrack( $path ); }

}
