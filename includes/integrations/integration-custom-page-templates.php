<?php

// includes/integrations/integration-custom-page-templates

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_custom_page_templates' );
/**
 * Register Custom Page Templates.
 *
 * @since 1.4.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_custom_page_templates( array $integrations ) {

	/** Page templates */
	$integrations[ 'cpt-custom-page-templates' ] = array(
		'label'          => __( 'Custom Page Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=cptemplate',
		'post_type'      => 'cptemplate',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=cptemplate',
	);

	/** Post type registrations */
	$integrations[ 'cpt-custom-post-types' ] = array(
		'label'          => __( 'Custom Post Type Registrations', 'builder-template-categories' ),
		'submenu_hook'   => 'cptemplates_general',
		'post_type'      => 'cpt_cpt',
		'template_label' => 'post-type',
		'admin_url'      => 'edit.php?post_type=cpt_cpt',
	);

	/** Taxonomy registrations */
	$integrations[ 'cpt-custom-taxonomies' ] = array(
		'label'          => __( 'Custom Taxonomy Registrations', 'builder-template-categories' ),
		'submenu_hook'   => 'cptemplates_general',
		'post_type'      => 'cpt_tax',
		'template_label' => 'post-type',
		'admin_url'      => 'edit.php?post_type=cpt_tax',
	);

	return $integrations;

}  // end function


add_action( 'admin_menu', 'ddw_btc_remove_submenu_for_cptemplates', 999 );
/**
 * Remove one of the (identical) post type tax submenus in the admin again.
 *   Otherwise it would be highly confusing for users.
 *
 * @since 1.4.0
 */
function ddw_btc_remove_submenu_for_cptemplates() {

	$page = remove_submenu_page(
		'cptemplates_general',
		'edit-tags.php?taxonomy=builder-template-category&post_type=cpt_tax'
	);

}  // end function
