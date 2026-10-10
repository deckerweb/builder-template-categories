<?php
/** Divi template library. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_divi_builder_templates' );
/**
 * Resolve register integration divi builder templates.
 * @since 1.9.0
 * @param mixed $integrations Value used by this callback.
 * @return void
 */
function ddw_btc_register_integration_divi_builder_templates( array $integrations ) {
	$integrations['divi-builder-templates'] = array(
		'label'          => __( 'Divi Builder Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'et_divi_options',
		'post_type'      => 'et_pb_layout',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=et_pb_layout',
	);
	return $integrations;
}
