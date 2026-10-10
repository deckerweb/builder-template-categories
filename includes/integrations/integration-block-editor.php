<?php
/** Expose the native WordPress pattern screens and their categories. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_wp_block_editor' );
add_action( 'admin_menu', 'ddw_btc_add_patterns_admin_menu', 50 );

/**
 * Make the native pattern library directly accessible without duplicate menus.
 *
 * @since 1.9.0
 * @return void
 */
function ddw_btc_add_patterns_admin_menu() {
	global $menu, $submenu;

	$post_type = get_post_type_object( 'wp_block' );
	if ( ! $post_type || ! current_user_can( $post_type->cap->edit_posts ) ) {
		return;
	}

	$parent = 'edit.php?post_type=wp_block';
	$exists = false;
	foreach ( (array) $menu as $item ) {
		if ( isset( $item[2] ) && $parent === $item[2] ) {
			$exists = true;
			break;
		}
	}
	if ( ! $exists ) {
		add_menu_page( $post_type->labels->name, $post_type->labels->name, $post_type->cap->edit_posts, $parent, '', 'dashicons-screenoptions', 22 );
	}

	$items = array(
		$parent => array( $post_type->labels->all_items, $post_type->cap->edit_posts ),
		'post-new.php?post_type=wp_block' => array( $post_type->labels->add_new_item, $post_type->cap->create_posts ),
	);
	foreach ( $items as $slug => $data ) {
		$found = false;
		foreach ( $submenu[$parent] ?? array() as $item ) {
			if ( isset( $item[2] ) && $slug === $item[2] ) {
				$found = true;
				break;
			}
		}
		if ( ! $found ) {
			add_submenu_page( $parent, $data[0], $data[0], $data[1], $slug );
		}
	}
}
/**
 * Register the native WordPress pattern integration.
 * @since 1.9.0
 * @param array $integrations Registered integrations.
 * @return array Updated integrations.
 */
function ddw_btc_register_integration_wp_block_editor( array $integrations ) {
	$integrations['wp-block-editor'] = array(
		'label'          => __( 'Patterns', 'default' ),
		'submenu_hook'   => 'edit.php?post_type=wp_block',
		'post_type'      => 'wp_block',
		'template_label' => 'pattern',
		'admin_url'      => 'edit.php?post_type=wp_block',
		'block_editor'   => 'register_early',
	);
	return $integrations;
}
