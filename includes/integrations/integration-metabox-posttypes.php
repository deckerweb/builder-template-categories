<?php

// includes/integrations/integration-metabox-posttypes

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_metabox_posttypes' );
/**
 * Register Meta Box plugin - Add-Ons for Post Types and Taxonomies.
 *
 * @since 1.1.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_metabox_posttypes( array $integrations ) {

	if ( ddw_btc_is_metabox_posttype_active() ) {
		
		$integrations[ 'metabox-posttype-templates' ] = array(
			'label'          => __( 'Meta Box Post Type Registrations', 'builder-template-categories' ),
			'submenu_hook'   => 'meta-box',
			'post_type'      => 'mb-post-type',
			'template_label' => 'post-type',
			'admin_url'      => 'edit.php?post_type=mb-post-type',
		);

	}  // end if

	if ( ddw_btc_is_metabox_taxonomy_active() ) {

		$integrations[ 'metabox-taxonomy-templates' ] = array(
			'label'          => __( 'Meta Box Taxonomy Registrations', 'builder-template-categories' ),
			'submenu_hook'   => 'meta-box',
			'post_type'      => 'mb-taxonomy',
			'template_label' => 'post-type',
			'admin_url'      => 'edit.php?post_type=mb-taxonomy',
		);

	}  // end if

	return $integrations;

}  // end function


add_action( 'admin_menu', 'ddw_btc_remove_submenu_for_metabox_taxonomy', 999 );
/**
 * If both supported Meta Box Add-Ons are active at the same time, we need to
 *   remove one of the (identical) submenus in the admin again. Otherwise it
 *   would be highly confusing for users.
 *
 * @since 1.1.0
 */
function ddw_btc_remove_submenu_for_metabox_taxonomy() {

	if ( ddw_btc_is_metabox_posttype_active() && ddw_btc_is_metabox_taxonomy_active() ) {

		$page = remove_submenu_page(
			'meta-box',
			'edit-tags.php?taxonomy=builder-template-category&post_type=mb-taxonomy'
		);

	}  // end if

}  // end function
