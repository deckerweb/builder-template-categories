<?php
/** Load the supported template libraries. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ddw_btc_integrations = array(
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

foreach ( $ddw_btc_integrations as $ddw_btc_integration => $ddw_btc_available ) {
	if ( $ddw_btc_available ) {
		require_once BTC_PLUGIN_DIR . 'includes/integrations/integration-' . $ddw_btc_integration . '.php';
	}
}
unset( $ddw_btc_integrations, $ddw_btc_integration, $ddw_btc_available );
