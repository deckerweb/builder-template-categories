<?php

// includes/admin/admin-help

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Help content when on adding/edit our Taxonomy terms.
 *
 * @since 1.0.0
 */
function ddw_btc_tax_edit_info_content() {

	$output = '<div class="notice notice-info">';

	$output .= sprintf(
		'<p class="description">%s:</p>',
		esc_attr__( 'These Template Categories are globally available for Administrators within the Admin Dashboard and can be used to organize the template libraries for the following active Plugins and/or Themes', 'builder-template-categories' )
	);

	$output .= '<ul style="margin-left: 10px;">';

	/** Get all integrations */
	$integrations = ddw_btc_get_integrations();

	/** Add label for each active integration */
	foreach ( $integrations as $integration => $integration_data ) {

		if ( 'default-none' !== $integration ) {

			$output .= sprintf(
				'<li class="dashicons-before dashicons-category"> <a href="%1$s">%2$s</a></li>',
				esc_url( admin_url( $integration_data[ 'admin_url' ] ) ),
				esc_attr( $integration_data[ 'label' ] )
			);

		}  // end if

	}  // end foreach

	$output .= '</ul>';
	$output .= '</div>';

	echo $output;

}  // end function


add_action( 'builder-template-category_pre_add_form', 'ddw_btc_tax_pre_info', 10, 1 );
/**
 * Display help content when adding a new term to our Taxonomy.
 *
 * @since 1.0.0
 *
 * @uses  ddw_btc_tax_edit_info_content()
 */
function ddw_btc_tax_pre_info( $taxonomy = 'builder-template-category' ) {

	/** Bail early if user wants no info */
	if ( apply_filters( 'btc/filter/help_content/tax_pre_info', FALSE ) ) {
		return;
	}

	ddw_btc_tax_edit_info_content();

}  // end function


add_action( 'builder-template-category_term_edit_form_top', 'ddw_btc_term_edit_info', 10, 2 );
/**
 * Display our help content when editing a term of our Taxonomy.
 *
 * @since 1.0.0
 *
 * @uses  ddw_btc_tax_edit_info_content()
 */
function ddw_btc_term_edit_info( $tag, $taxonomy = 'builder-template-category' ) {

	/** Bail early if user wants no info */
	if ( apply_filters( 'btc/filter/help_content/tax_pre_info', FALSE ) ) {
		return;
	}

	ddw_btc_tax_edit_info_content();

}  // end function


/**
 * Determine if the current screen is a post type edit screen of an active
 *   integration.
 *
 * @since  1.1.0
 *
 * @uses   ddw_btc_get_integration_post_types()
 *
 * @param  object $current_screen This global (via get_current_screen()) holds
 *                                the current screen object.
 * @return bool If current screen matches the base or post type of an
 *              integration return TRUE, otherwise FALSE.
 */
function ddw_btc_is_post_type_edit_screen( $current_screen ) {

	return (
		( 'edit' == $current_screen->base || 'post' == $current_screen->base || 'post-new' == $current_screen->base )
		&& in_array( $current_screen->post_type, ddw_btc_get_integration_post_types( 'all' ) )
	);

}  // end function


/**
 * Determine if the current screen is the taxonomy edit screen of our own
 *   taxonomy.
 *
 * @since  1.1.0
 *
 * @param  object $current_screen This global (via get_current_screen()) holds
 *                                the current screen object.
 * @return bool If current screen matches the ID of our taxonomy return TRUE,
 *              otherwise FALSE.
 */
function ddw_btc_is_taxonomy_edit_screen( $current_screen ) {

	return ( 'edit-builder-template-category' == $current_screen->id );

}  // end function


add_action( 'load-edit.php', 'ddw_btc_load_content_help', 15 );
add_action( 'load-post.php', 'ddw_btc_load_content_help', 15 );
add_action( 'load-post-new.php', 'ddw_btc_load_content_help', 15 );
add_action( 'load-edit-tags.php', 'ddw_btc_content_help', 15 );
/**
 * Create and display plugin help tab content.
 *   Load on edit screens for our supported hook engine's post types.
 *
 * @since  1.1.0
 *
 * @see    ddw_btc_content_help()
 *
 * @uses   ddw_btc_is_post_type_edit_screen()
 * @uses   ddw_btc_is_taxonomy_edit_screen()
 * @uses   add_thickbox()
 *
 * @global mixed $GLOBALS[ 'btc_edit_screen' ]
 */
function ddw_btc_load_content_help() {

	$GLOBALS[ 'btc_edit_screen' ] = get_current_screen();

	/** Check for proper admin screen & permissions */
	if ( ! $GLOBALS[ 'btc_edit_screen' ] ) {
		return;
	}

	/** Add the help tab for certain post type and taxonomy edit screens */
	if ( ddw_btc_is_post_type_edit_screen( $GLOBALS[ 'btc_edit_screen' ] )
		|| ddw_btc_is_taxonomy_edit_screen( $GLOBALS[ 'btc_edit_screen' ] )
	) {

		ddw_btc_content_help();

		/** Optionally add Thickbox JS & CSS (for video content) */
		add_thickbox();

	}  // end if

}  // end function


/**
 * Create and display plugin help tab content.
 *   Load on edit screens for our supported hook engine's post types.
 *
 * @since  1.1.0
 *
 * @see    ddw_btc_content_help_tab()
 * @see    ddw_btc_content_help_sidebar()
 *
 * @uses   WP_Screen::add_help_tab()
 * @uses   WP_Screen::set_help_sidebar()
 *
 * @global mixed $GLOBALS[ 'btc_edit_screen' ]
 */
function ddw_btc_content_help() {

	$GLOBALS[ 'btc_edit_screen' ] = get_current_screen();

	/** Add the new help tab */
	$GLOBALS[ 'btc_edit_screen' ]->add_help_tab(
		array(
			'id'       => 'btc-edit-help',
			'title'    => esc_html__( 'Builder Template Categories', 'builder-template-categories' ),
			'callback' => apply_filters(
				'btc/filter/content/help_tab',
				'ddw_btc_content_help_tab'
			),
		)
	);

	/** Add additional help sidebar */
	$GLOBALS[ 'btc_edit_screen' ]->set_help_sidebar( ddw_btc_content_help_sidebar() );

	/** Some subtle CSS styling additions ... ;-) */
	?>
		<style type='text/css'>
			/** Dashicons commons */
			#tab-link-btc-edit-help a:before {
				display: inline-block;
				-webkit-font-smoothing: antialiased;
				font-family: 'dashicons';
				font-weight: 400;
				vertical-align: top;
			}

			/** Our help tab */
			#tab-link-btc-edit-help a:before {
				clear: left;
				content: "\f106";
				float: left;
				margin: 1px 5px 25px -3px;
			}
			#tab-panel-btc-edit-help .dashicons-before:before {
				margin-right: 3px;
				vertical-align: top;
			}

			/** Help tab content */
			.btc-help-version {
				opacity: .6;
			}
			.help-tab-content .btc-help-integrations-group li {
				list-style: none;
			}
			.btc-help-integrations-list small code {
				font-size: 80%;
			}
			.btc-help-sidebar-icons:before {
				margin-right: 4px;
				text-decoration: none !important;
			}
			.btc-help-notice.dashicons-info:before {
				clear: left;
				float: left;
				font-size: 20px;
				margin-right: 10px !important;
				margin-top: 3px;
				opacity: .77;
			}
			.btc-help-notice {
				margin-left: 9px;
				padding: 5px 10px;
			}
			.btc.dashicons-thumbs-up:before {
				margin-top: 2px;
			}
		</style>
	<?php

}  // end function


/**
 * Build listing of current active integrations for the help tab content.
 *
 * @since  1.1.0
 *
 * @uses   ddw_btc_get_integrations()
 *
 * @return string Markup and strings of current active integrations list.
 */
function ddw_btc_content_help_integrations_list() {

	/** Get array with all active integrations */
	$integrations = ddw_btc_get_integrations();

	$integrations[ 'default-none' ] = null;

	$output = '<ul class="btc-help-integrations-group">';

	foreach ( $integrations as $integration => $integration_data ) {

		if ( 'default-none' !== $integration ) {

			$output .= sprintf(
				'<li class="btc-help-integrations-list dashicons-before dashicons-category"><a href="%1$s">%2$s</a> &ndash; <small>%3$s: %4$s / %5$s: %6$s</small></li>',
				esc_url( admin_url( $integration_data[ 'admin_url' ] ) ),
				esc_attr( $integration_data[ 'label' ] ),
				__( 'Content Type', 'builder-template-categories' ),
				ddw_btc_string_content_type( sanitize_key( $integration_data[ 'template_label' ] ) ),
				__( 'Post Type', 'builder-template-categories' ),
				'<code>' . sanitize_key( $integration_data[ 'post_type' ] ) . '</code>'
			);

		}  // end if

	}  // end foreach

	$output .= '</ul>';

	/** Return the output - string/markup */
	return $output;

}  // end function


/**
 * Content for help tab.
 *
 * @since  1.1.0
 *
 * @uses   ddw_btc_content_help_integrations_list()
 *
 * @return string Complete help content markup and content as a string.
 */
function ddw_btc_content_help_tab() {

	$btc_info = (array) ddw_btc_info_values();

	$btc_space_helper = '<div style="height: 10px;"></div>';

	/** Content: Builder Hooks Connector plugin */
	echo '<h3>' . __( 'Plugin', 'builder-template-categories' ) . ': ' . __( 'Builder Template Categories', 'builder-template-categories' ) . ' <small class="btc-help-version">v' . BTC_PLUGIN_VERSION . '</small></h3>';

	/** Content: Dynamically list integrations */
	printf(
		'<p>' . __( 'Currently active integrations where the %s taxonomy is applied to better internally organize templates for various content types', 'builder-template-categories' ) . ':</p>',
		'<em>' . __( 'Builder Template Categories', 'builder-template-categories' ) . '</em>'
	);

	echo ddw_btc_content_help_integrations_list();

	/** Content: Explain bulk add categories */
	$video_bulk_add = sprintf(
		'<a class="thickbox" href="%s" title="%s"><span class="dashicons-before dashicons-video-alt3"></span>%s</a>',
		ddw_btc_get_info_url( 'video_bulk_add_tb' ),
		esc_html__( 'Video Overview: Bulk Add Template Categories', 'builder-template-categories' ),
		esc_attr__( 'video overview', 'builder-template-categories' )
	);

	printf(
		/* translators: 1 - string "Bulk Actions" / 2 - Label "Edit, add Category etc." / 3 - video link markup with title "video overview" */
		'<p class="btc-help-notice dashicons-before dashicons-info">' . __( 'You can bulk add template categories to more than one template at once in your template post type overview table, using the %1$s drop-down menu. The action will be labeled like %2$s. See a short %3$s of this feature.', 'builder-template-categories' ) . '</p>',
		'<em>' . __( 'Bulk Actions', 'builder-template-categories' ) . '</em>',
		'<em>' . __( 'Edit, add Category etc.', 'builder-template-categories' ) . '</em>',
		$video_bulk_add
	);

	/** Content: More info */
	printf(
		'<p class="btc-help-notice dashicons-before dashicons-info">%1$s %2$s</p>',
		__( 'The template categories are global and are applied automatically to all current active integrations.', 'builder-template-categories' ),
		__( 'The category description can be used for internal notices for your team members for example.', 'builder-template-categories' )
	);

	/** Further help content */
	echo $btc_space_helper . '<p><h4 style="font-size: 1.1em;">' . __( 'Important plugin links:', 'builder-template-categories' ) . '</h4>' .

		ddw_btc_get_info_link( 'url_plugin', esc_html__( 'Plugin website', 'builder-template-categories' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_btc_get_info_link( 'url_plugin_faq', esc_html_x( 'FAQ', 'Help tab info', 'builder-template-categories' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_btc_get_info_link( 'url_wporg_forum', esc_html_x( 'Support', 'Help tab info', 'builder-template-categories' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_btc_get_info_link( 'url_fb_group', esc_html_x( 'Facebook Group', 'Help tab info', 'builder-template-categories' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_btc_get_info_link( 'url_translate', esc_html_x( 'Translations', 'Help tab info', 'builder-template-categories' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_btc_get_info_link( 'url_donate', esc_html_x( 'Donate', 'Help tab info', 'builder-template-categories' ), 'button button-primary dashicons-before dashicons-thumbs-up btc' ) .

		sprintf(
			'<p><a href="%1$s" target="_blank" rel="nofollow noopener noreferrer" title="%2$s">%2$s</a> &#x000A9; %3$s <a href="%4$s" target="_blank" rel="noopener noreferrer" title="%5$s">%5$s</a></p>',
			esc_url( $btc_info[ 'url_license' ] ),
			esc_attr( $btc_info[ 'license' ] ),
			ddw_btc_coding_years(),
			esc_url( $btc_info[ 'author_uri' ] ),
			esc_html( $btc_info[ 'author' ] )
		);

}  // end function


/**
 * Content for Help Tab Sidebar.
 *   Note: Content/Markup has to be returned instead of echoed, as the
 *         set_help_sidebar() method already is echoing its content.
 *
 * @since  1.1.0
 *
 * @return string Complete help sidebar markup and content as a string.
 */
function ddw_btc_content_help_sidebar() {

	$btc_help_sidebar_content = '<h4>' . __( 'Customize', 'builder-template-categories' ) . ':</h4>' .
		'<p>' . ddw_btc_get_info_link( 'url_snippets', esc_html__( 'Code Snippets', 'builder-template-categories' ), 'btc-help-sidebar-icons dashicons-before dashicons-editor-code' ) . '</p>';

	$btc_help_sidebar_content .= '<h4>' . __( 'Connect', 'builder-template-categories' ) . ':</h4>' .
		'<p><strong>' . ddw_btc_get_info_link( 'url_fb_group', __( 'Facebook Group', 'builder-template-categories' ), 'btc-help-sidebar-icons dashicons-before dashicons-facebook' ) . '</strong></p>' .
		'<p>' . ddw_btc_get_info_link( 'url_twitter', 'Twitter', 'btc-help-sidebar-icons dashicons-before dashicons-twitter' ) . '</p>' .
		'<p>' . ddw_btc_get_info_link( 'url_github_follow', 'GitHub', 'btc-help-sidebar-icons dashicons-before dashicons-admin-users' ) . '</p>' .
		'<p>' . ddw_btc_get_info_link( 'author_uri', 'DECKERWEB', 'btc-help-sidebar-icons dashicons-before dashicons-networking' ) . '</p>' .
		'<p>' . ddw_btc_get_info_link( 'url_wporg_profile', 'WordPress.org', 'btc-help-sidebar-icons dashicons-before dashicons-wordpress' ) . '</p>';

	return apply_filters(
		'btc/filter/content/help_sidebar',
		$btc_help_sidebar_content
	);

}  // end function
