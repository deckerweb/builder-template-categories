<?php

// includes/integrations/integration-reusable-templates

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_reusable_templates' );
/**
 * Register Reusable Templates plugin.
 *
 * @since 1.6.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_reusable_templates( array $integrations ) {

	$integrations[ 'we-reusable-templates' ] = array(
		'label'          => __( 'Reusable Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'themes.php',	// 'edit.php?post_type=we-sidebar-builder',
		'post_type'      => 'we-sidebar-builder',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=we-sidebar-builder',
	);

	return $integrations;

}  // end function


add_filter( 'manage_edit-we-sidebar-builder_columns', 'ddw_btc_add_tax_column_reusable_templates', 10, 1 );
/**
 * Manually add our tax column to the post type list table. This is a needed
 *   step as the automatic adding doesn't work for this (customized) post type
 *   list table.
 *
 * @since 1.6.0
 *
 * @uses ddw_btc_string_template()
 *
 * @param array $columns Array that holds all columns.
 * @return array Modified array of columns.
 */
function ddw_btc_add_tax_column_reusable_templates( $columns ) {

	$columns[ 'builder-template-category' ] = ddw_btc_string_template( 'template' );

	return $columns;

}  // end function


/**
 * Needed step to add the custom data to the added column in the post type list
 *   table. Will run at hook 'manage_{$post_type}_posts_custom_column'.
 *
 * @since 1.6.0
 */
ddw_btc_prepare_tax_column_add( 'we-sidebar-builder' );
