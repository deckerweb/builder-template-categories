<?php

// includes/integrations/integration-kadence-woocommerce-elementor

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_kadence_woocommerce_elementor' );
/**
 * Register Kadence WooCommerce Elementor plugin (free & Pro versions!).
 *
 * @since 1.1.0
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_kadence_woocommerce_elementor( array $integrations ) {

	/** Integrate with free base version of the plugin */
	$integrations[ 'kadence-elementor-woocommerce-single' ] = array(
		'label'          => __( 'Kadence Elementor Single Product Templates', 'builder-template-categories' ) . ddw_btc_string_for_woocommerce(),
		'submenu_hook'   => 'edit.php?post_type=product',
		'post_type'      => 'ele-product-template',
		'template_label' => 'template',
		'admin_url'      => 'edit.php?post_type=ele-product-template',
	);

	/** Optionally integrate with Pro version of plugin - if active */
	if ( ddw_btc_is_kadence_woocommerce_elementor_pro_active() ) {

		$integrations[ 'kadence-elementor-woocommerce-archive' ] = array(
			'label'          => __( 'Kadence Elementor Product Archive Templates', 'builder-template-categories' ) . ddw_btc_string_for_woocommerce(),
			'submenu_hook'   => 'edit.php?post_type=product',
			'post_type'      => 'ele-p-arch-template',
			'template_label' => 'template',
			'admin_url'      => 'edit.php?post_type=ele-p-arch-template',
		);

		$integrations[ 'kadence-elementor-woocommerce-checkout' ] = array(
			'label'          => __( 'Kadence Elementor Checkout Templates', 'builder-template-categories' ) . ddw_btc_string_for_woocommerce(),
			'submenu_hook'   => 'edit.php?post_type=product',
			'post_type'      => 'ele-check-template',
			'template_label' => 'template',
			'admin_url'      => 'edit.php?post_type=ele-check-template',
		);

	}  // end if

	/** Return active integrations */
	return $integrations;

}  // end function


/**
 * Set flag for WooCommerce product type template
 *
 * @since 1.1.0
 */
add_filter( 'btc/filter/is_type/woo', '__return_true' );


add_action( 'admin_menu', 'ddw_btc_remove_submenu_for_kadence_post_types', 999 );
/**
 * Since we added support for THREE post types for this integration we need to
 *   remove two of the submenus in the admin again. Otherwise it would be highly
 *   confusing for users.
 *
 * @since 1.1.0
 */
function ddw_btc_remove_submenu_for_kadence_post_types() {

	/** Bail early if Pro version of plugin is not active */
	if ( ! ddw_btc_is_kadence_woocommerce_elementor_pro_active() ) {
		return;
	}

	remove_submenu_page(
		'edit.php?post_type=product',
		'edit-tags.php?taxonomy=builder-template-category&post_type=ele-p-arch-template'
	);

	remove_submenu_page(
		'edit.php?post_type=product',
		'edit-tags.php?taxonomy=builder-template-category&post_type=ele-check-template'
	);

}  // end function
