<?php
/** Copyright 2026 David Decker – DECKERWEB. SPDX-License-Identifier: GPL-2.0-or-later */
if ( ! defined( 'ABSPATH' ) ) { exit; }
require_once __DIR__ . '/src/I18n.php';
require_once __DIR__ . '/src/History.php';
require_once __DIR__ . '/src/Catalog.php';
require_once __DIR__ . '/src/Requirements.php';
require_once __DIR__ . '/src/Package.php';
require_once __DIR__ . '/src/Experience.php';
require_once __DIR__ . '/src/Library.php';
/**
 * Create and register the elected administration runtime after compatibility checks.
 *
 * @param array $chosen Elected host candidate with absolute embedded directory.
 * @param array $hosts Registered host candidates for shared integration.
 * @return \Deckerweb\PluginLibrary\V1_1_0\Library Registered elected runtime.
 * Registers native WordPress hooks; does not install or activate other plugins.
 */
return static function( array $chosen, array $hosts ) {
	$runtime = new \Deckerweb\PluginLibrary\V1_1_0\Library( $chosen, $hosts );
	$runtime->register();
	return $runtime;
};
