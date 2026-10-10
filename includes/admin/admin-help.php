<?php
/** Contextual help for supported template screens. */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'load-edit.php', 'ddw_btc_load_content_help', 15 );
add_action( 'load-post.php', 'ddw_btc_load_content_help', 15 );
add_action( 'load-post-new.php', 'ddw_btc_load_content_help', 15 );
add_action( 'load-edit-tags.php', 'ddw_btc_load_content_help', 15 );
/**
 * Add contextual help only to the plugin's existing admin screens.
 * @since 1.9.0
 * @return void
 */
function ddw_btc_load_content_help() {
	$screen = get_current_screen();
	if ( ! $screen || ! current_user_can( ddw_btc_capability_submenu() ) ) {
		return;
	}
	if ( 'builder-template-category' !== $screen->taxonomy && ! in_array( $screen->post_type, ddw_btc_get_integration_post_types( 'all' ), true ) ) {
		return;
	}
	$screen->add_help_tab( array( 'id' => 'btc-help', 'title' => 'Builder Template Categories', 'callback' => 'ddw_btc_content_help_tab' ) );
}
/**
 * Render escaped local help and the maintenance notice.
 * @since 1.9.0
 * @return void
 */
function ddw_btc_content_help_tab() {
	echo '<h3>Builder Template Categories 1.9.0</h3><p>' . esc_html__( 'Feature development ended with version 1.9.0. Only security updates may follow if needed, no later than December 31, 2027.', 'builder-template-categories' ) . '</p>';
	echo '<p>' . esc_html__( 'Create categories in your template library submenu. Assign them to templates or patterns and use the list-table dropdown to filter items.', 'builder-template-categories' ) . '</p>';
	echo '<p>' . esc_html__( 'Categories provided by Builder Template Categories. Independent of WordPress pattern categories.', 'builder-template-categories' ) . '</p>';
	echo '<ul>';
	foreach ( ddw_btc_get_integrations() as $integration ) {
		echo '<li><a href="' . esc_url( admin_url( $integration['admin_url'] ) ) . '">' . esc_html( $integration['label'] ) . '</a></li>';
	}
	echo '</ul><p><a href="' . esc_url( ddw_btc_get_info_url( 'url_plugin_docs' ) ) . '">' . esc_html__( 'Documentation', 'builder-template-categories' ) . '</a> · <a href="https://github.com/deckerweb/builder-content-guide">Builder Content Guide</a></p>';
}
