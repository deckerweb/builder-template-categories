<?php

// includes/integrations/integration-epic-news-elements

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_epic_news_elements' );
/**
 * Register Epic News Elements plugin.
 *
 * @since 1.4.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_epic_news_elements( array $integrations ) {

	$integrations[ 'epic-news-post-templates' ] = array(
		'label'          => __( 'Epic News Elements - Post Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=custom-post-template',
		'post_type'      => 'custom-post-template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=custom-post-template',
	);

	$integrations[ 'epic-news-archive-templates' ] = array(
		'label'          => __( 'Epic News Elements - Archive Templates', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=archive-template',
		'post_type'      => 'archive-template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=archive-template',
	);

	return $integrations;

}  // end function
