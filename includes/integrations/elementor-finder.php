<?php

// includes/integrations/elementor-finder

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


class DDW_BTC_Finder_Category extends \Elementor\Core\Common\Modules\Finder\Base_Category {

	/**
	 * Get title.
	 *
	 * @since  1.4.0
	 *
	 * @access public
	 *
	 * @return string
	 */
	public function get_title() {

		return _x( 'Add-On: Builder Template Categories', 'Title in Elementor Finder', 'builder-template-categories' );

	}  // end method


	/**
	 * Get category items.
	 *
	 * @since  1.4.0
	 *
	 * @access public
	 *
	 * @uses   ddw_btc_get_info_url()
	 *
	 * @param  array $options
	 * @return array $items Array of additional Finder items.
	 */
	public function get_category_items( array $options = [] ) {

		$items = [
			'taxonomy' => [
				'title'    => _x( 'Template Categories', 'Title in Elementor Finder', 'builder-template-categories' ),
				'url'      => admin_url( 'edit-tags.php?taxonomy=builder-template-category' ),
				'icon'     => 'tabs',
				'keywords' => [ 'category', 'categories', 'builder', 'templates', 'library', 'elements', 'blocks', 'page builder', 'popups', 'lightboxes', 'hooks', 'fields', 'filters', 'bars', 'boxes' ],
				'description' => __( 'Manage template categories for site builders', 'builder-template-categories' ),
			],
			'resources' => [
				'title'    => _x( 'Help Resources - Builder Template Categories', 'Title in Elementor Finder', 'builder-template-categories' ),
				'url'      => ddw_btc_get_info_url( 'url_wporg_faq' ),
				'icon'     => 'info',
				'keywords' => [ 'help', 'support', 'docs', 'documentation', 'faq', 'knowledge base' ],
				'description' => __( 'FAQ and documentation for the plugin', 'builder-template-categories' ),
			],
			'code-snippets' => [
				'title'    => _x( 'Code Snippets - Builder Template Categories', 'Title in Elementor Finder', 'builder-template-categories' ),
				'url'      => ddw_btc_get_info_url( 'url_snippets' ),
				'icon'     => 'editor-code',
				'keywords' => [ 'code snippets', 'snippets', 'developer', 'customize', 'wiki' ],
				'description' => __( 'These allow for tweaks and customizations', 'builder-template-categories' ),
			],
		];

		return $items;

	}  // end method

}  // end of class
