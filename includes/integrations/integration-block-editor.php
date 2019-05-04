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
 * @since 1.2.0
 * @since 1.3.0 Enhanced for WordPress 5.0-beta1 or higher.
 *
 * @param array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function ddw_btc_register_integration_wp_block_editor( array $integrations ) {

	$post_type = 'wp_block';

	$integrations[ 'wp-block-editor' ] = array(
		'label'          => __( 'Block Editor Reusable Blocks', 'builder-template-categories' ),
		'submenu_hook'   => 'edit.php?post_type=' . $post_type,
		'post_type'      => $post_type,
		'template_label' => 'block',
		'admin_url'      => 'edit.php?post_type=' . $post_type,
		'block_editor'   => 'register_early',
	);

	return $integrations;

}  // end function


/**
 * Set flag for Block type template
 *
 * @since 1.2.0
 */
add_filter( 'btc/filter/is_type/block', '__return_true' );


/**
 * Show 'wp_block' UI for post type - this is only for WordPress 5.0 or higher
 *   (beginning with WordPress version 5.0-beta1 or higher). Here we need to add
 *   the complete admin page for the post type (as it will be otherwise in
 *   hidden state).
 *
 * @since 1.3.0
 */
if ( version_compare( $GLOBALS[ 'wp_version' ], '5.0-beta1', '>=' )
	&& apply_filters( 'btc/filter/wp_block/post_type_ui', TRUE )
) {

	add_action( 'admin_menu', 'ddw_btc_maybe_add_menu_wpblock_posttype' );
	/**
	 * Add the appropriate admin menu - using the post type list table page as
	 *   the callback.
	 *
	 * @since 1.3.0
	 * @since 1.5.1 Perfect integration with Toolbar Extras v1.4.3+.
	 *
	 * @see WP Core /wp-includes/post.php for 'wp_block' capabilities
	 *
	 * @uses ddw_btc_is_tbex_reusable_blocks()
	 * @uses add_menu_page()
	 * @uses add_submenu_page()
	 */
	function ddw_btc_maybe_add_menu_wpblock_posttype() {
		
		/**
		 * Bail early if the same stuff as below is already added by
		 *   Toolbar Extras plugin.
		 */
		if ( ddw_btc_is_tbex_reusable_blocks() ) {
			return;
		}

		/** Add "Blocks" top-level Admin menu, below "Comments" */
	    add_menu_page(
	        _x( 'Reusable Blocks', 'Admin page title', 'builder-template-categories' ),
	        _x( 'Blocks', 'Admin menu label', 'builder-template-categories' ),
	        'publish_posts',
	        'edit.php?post_type=wp_block',
	        '',
	        'dashicons-screenoptions',
	        '25.1'	// directly after comments
	    );

	    /** "Blocks" submenu: "Add New" (Reusable Block) */
	    add_submenu_page(
	    	'edit.php?post_type=wp_block',
	        _x( 'Add New Reusable Block', 'Admin page title', 'builder-template-categories' ),
	        _x( 'Add New', 'Admin menu label', 'builder-template-categories' ),
	        'publish_posts',
	        'post-new.php?post_type=wp_block'
	    );

	}  // end function

	//add_action( 'admin_head', 'ddw_btc_remove_wpblock_addnew_button' );

}  // end if WP 5.0 check


/**
 * Show 'wp_block' UI for post type - this is only for backwards compatibility
 *   with WordPress up to 4.9.8, with active "Gutenberg" plugin.
 *
 * @since 1.2.0
 * @since 1.3.0 Tweaked for WP Core 5.0 compat.
 */
if ( version_compare( $GLOBALS[ 'wp_version' ], '4.9.999', '<=' )
	&& apply_filters( 'btc/filter/wp_block/post_type_ui', TRUE )
) {

	add_action( 'init', 'ddw_btc_maybe_open_wpblock_posttype', 1111 );
	/**
	 * Show UI for the 'wp_block' post type to make the Reusable Blocks (Block
	 *   Editor, Gutenberg) always visible and more accessible.
	 *
	 *   Note: Code concept based on:
	 * @author Jeff Starr
	 * @link https://perishablepress.com/delete-shared-saved-gutenberg-blocks/
	 *
	 * @since 1.2.0
	 *
	 * @global object $GLOBALS[ 'wp_post_types' ]
	 */
	function ddw_btc_maybe_open_wpblock_posttype() {

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
		//add_action( 'admin_menu', 'ddw_btc_maybe_remove_wpblock_addnew', 999 );

	}  // end function


	/**
	 * Remove the "Add New" submenu for 'wp_block' post type as it is not relevant.
	 *
	 * @since 1.2.0
	 *
	 * @uses remove_submenu_page()
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
	 * @since 1.2.0
	 *
	 * @param array  $args      Array that holds all registered post type arguments.
	 * @param string $post_type String of registered post type to tweak.
	 * @return array Array of tweaked post type arguments.
	 */
	function ddw_btc_tweak_posttype_wpblock( $args, $post_type ) {

		$post_type = 'wp_block';

		$args[ 'menu_icon' ] = 'dashicons-screenoptions';

		return $args;

	}  // end function

}  // end if WP 5.0 check


//add_action( 'admin_head', 'ddw_btc_remove_wpblock_addnew_button', 100 );
/**
 * Hide the "Add New" button for the 'wp_block' post type UI.
 *   Note: This is (currently?) necessary as the "Add New" button brings WSOD/
 *         has no effect as of now. (Reusable blocks are added in-post when
 *         editing.)
 *
 * @since 1.3.0
 */
function ddw_btc_remove_wpblock_addnew_button() {

	/** Add our inline CSS styles: */
	?>
		<style type="text/css">
			.post-type-wp_block .page-title-action {
				display: none !important;
			}
		</style>
	<?php

}  // end function
