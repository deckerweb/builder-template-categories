<?php

// includes/integrations/integration-block-editor

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'btc/filter/integrations/all', 'ddw_btc_register_integration_wp_block_editor' );
/**
 * Register default WP Blocks = Gutenberg Reusable Blocks (WP Block Editor).
 *
 * @since  1.2.0
 *
 * @param  array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_wp_block_editor( array $integrations ) {

	$integrations[ 'wp-block-editor' ] = array(
		'label'          => __( 'Block Editor Reusable Blocks', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=wp_block',
		'post_type'      => 'wp_block',
		'template_label' => 'block',
		'admin_url'      => 'edit.php?post_type=wp_block',
	);

	return $integrations;

}  // end function


add_action( 'init', 'ddw_btc_maybe_open_wpblock_posttype', 1111 );
/**
 * Show UI for the 'wp_block' post type to make the Reusable Blocks (Block
 *   Editor, Gutenberg) always visible and more accessible.
 *
 *   Note: Code concept based on:
 * @author Jeff Starr
 * @link   https://perishablepress.com/delete-shared-saved-gutenberg-blocks/
 *
 * @since  1.2.0
 *
 * @global object $GLOBALS[ 'wp_post_types' ]
 */
function ddw_btc_maybe_open_wpblock_posttype() {
	
	/** Bail early if user wants no info */
	if ( apply_filters( 'btc/filter/wp_block/post_type_ui', FALSE ) ) {
		return;
	}

	$post_type = 'wp_block';
	
	if ( empty( $GLOBALS[ 'wp_post_types' ][ $post_type ] )
		|| ! is_object( $GLOBALS[ 'wp_post_types' ][ $post_type ] )
		|| empty( $GLOBALS[ 'wp_post_types' ][ $post_type ]->labels)
	) {
		return;
	}
	
	$GLOBALS[ 'wp_post_types' ][ $post_type ]->show_ui      = TRUE;
	$GLOBALS[ 'wp_post_types' ][ $post_type ]->show_in_menu = TRUE;
	//$GLOBALS[ 'wp_post_types' ][ $post_type ]->_edit_link   = 'post.php?post=%d';
	
	/** Remove the "Add New" submenu which was added to the actions above */
	add_action( 'admin_menu', 'ddw_btc_maybe_remove_wpblock_addnew', 999 );

}  // end function


/**
 * Set flag for Block type template
 *
 * @since 1.2.0
 */
add_filter( 'btc/filter/is_type/block', '__return_true' );


/**
 * Remove the "Add New" submenu for 'wp_block' post type as it is not relevant.
 *
 * @since 1.2.0
 *
 * @uses  remove_submenu_page()
 */
function ddw_btc_maybe_remove_wpblock_addnew() {

	$page = remove_submenu_page(
		'edit.php?post_type=wp_block',
		'post-new.php?post_type=wp_block'
	);

}  // end function


add_filter( 'register_post_type_args', 'ddw_btc_tweak_posttype_wpblock', 10, 2 );
/**
 * Tweak the admin for the 'wp_block' post type to make it more relevant and
 *   useful.
 *
 * @since  1.2.0
 *
 * @param  array  $args      Array that holds all registered post type arguments.
 * @param  string $post_type String of registered post type to tweak.
 * @return array Array of tweaked post type arguments.
 */
function ddw_btc_tweak_posttype_wpblock( $args, $post_type ) {

	$post_type = 'wp_block';

	$args[ 'menu_icon' ] = 'dashicons-screenoptions';

	return $args;

}  // end function