<?php
/** Copyright 2026 David Decker – DECKERWEB. SPDX-License-Identifier: GPL-2.0-or-later */
namespace Deckerweb\PluginLibrary\V1_1_0;
if ( ! defined( 'ABSPATH' ) ) { exit; }
/** Native installation with explicit, previously verified plugin identity for cooperating filters. */
final class CatalogInstaller extends \Plugin_Upgrader {
 private string $file;
 /** Bind one verified plugin identity to this native installer.
  * @param \WP_Upgrader_Skin $skin Native AJAX or administration skin.
  * @param string $file Validated catalog plugin basename.
  * @return void Initializes the native upgrader without changing other plugin actions.
  */
 public function __construct( \WP_Upgrader_Skin $skin, string $file ) { parent::__construct($skin); $this->file=$file; }
 /** Preserve native install behavior while supplying the known plugin identity.
  * @param array $options Native run options from Plugin_Upgrader::install.
  * @return array|false|\WP_Error Native upgrade result; existing filters remain registered.
  */
 public function run( $options ) { $options['hook_extra']['plugin']=$this->file; return parent::run($options); }
}
