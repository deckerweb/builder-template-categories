<?php
/** Load the supported template libraries. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$btc_integrations = array(
	'bricks'               => ddw_btc_is_bricks_active(),
	'elementor'            => ddw_btc_is_elementor_active(),
	'beaver-templates'     => ddw_btc_is_beaver_builder_active() || ddw_btc_is_beaver_themer_active(),
	'divi-templates'       => ddw_btc_is_divi_builder_active(),
	'oxygen-builder'      => ddw_btc_is_oxygen_builder_active(),
	'avada-fusion-builder'=> ddw_btc_is_avada_fusion_builder_active(),
	'generatepress'       => ddw_btc_is_gp_elements_active(),
	'astra'               => ddw_btc_is_astra_layouts_active(),
	'block-editor'        => true,
);

foreach ( $btc_integrations as $btc_integration => $btc_available ) {
	if ( $btc_available ) {
		require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-' . $btc_integration . '.php';
	}
}
unset( $btc_integrations, $btc_integration, $btc_available );
