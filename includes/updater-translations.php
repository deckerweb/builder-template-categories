<?php
/** Copy into the host adapter and replace the builder-template-categories textdomain with its literal domain. */
defined( 'ABSPATH' ) || exit;
/**
 * Resolve an updater source string in the host textdomain.
 * @param string $message English updater message.
 * @return string Translated host message, or original source text.
 */
return static function ( string $message ): string {
    // Literal calls let the host's normal translation extractor collect every source string.
    switch ( $message ) {
        case 'Private mode must be boolean.':
            return __( 'Private mode must be boolean.', 'builder-template-categories' );
        case 'Invalid authentication provider.':
            return __( 'Invalid authentication provider.', 'builder-template-categories' );
        case 'The plugin must be installed in a stable slug directory.':
            return __( 'The plugin must be installed in a stable slug directory.', 'builder-template-categories' );
        case 'Invalid GitHub repository URL.':
            return __( 'Invalid GitHub repository URL.', 'builder-template-categories' );
        case 'The private update could not be authorized. Check the repository credentials and refresh updates.':
            return __( 'The private update could not be authorized. Check the repository credentials and refresh updates.', 'builder-template-categories' );
        case 'Could not create the update download file.':
            return __( 'Could not create the update download file.', 'builder-template-categories' );
        case 'The private update download failed. Check credentials and try again.':
            return __( 'The private update download failed. Check credentials and try again.', 'builder-template-categories' );
        case 'Could not access the update filesystem.':
            return __( 'Could not access the update filesystem.', 'builder-template-categories' );
        case 'GitHub release does not contain the plugin main file.':
            return __( 'GitHub release does not contain the plugin main file.', 'builder-template-categories' );
        case 'Could not prepare the GitHub release package.':
            return __( 'Could not prepare the GitHub release package.', 'builder-template-categories' );
        case 'See the release on GitHub.':
            return __( 'See the release on GitHub.', 'builder-template-categories' );
        case 'Git Updater is active. If a deckerweb installation or update fails, temporarily deactivate Git Updater and retry. Reactivate it afterwards if other plugins or themes need it. Only leave it disabled when those extensions have another reliable update provider.':
            return __( 'Git Updater is active. If a deckerweb installation or update fails, temporarily deactivate Git Updater and retry. Reactivate it afterwards if other plugins or themes need it. Only leave it disabled when those extensions have another reliable update provider.', 'builder-template-categories' );
        case 'Manage installed plugins':
            return __( 'Manage installed plugins', 'builder-template-categories' );
        case 'Dismiss this notice':
            return __( 'Dismiss this notice', 'builder-template-categories' );
        case 'Permission denied.':
            return __( 'Permission denied.', 'builder-template-categories' );
        case 'Public catalog callbacks require both providers and cannot be used in private mode.':
            return __( 'Public catalog callbacks require both providers and cannot be used in private mode.', 'builder-template-categories' );
        case 'The approved release could not be verified.':
            return __( 'The approved release could not be verified.', 'builder-template-categories' );
        case 'The approved release changed. Refresh updates first.':
            return __( 'The approved release changed. Refresh updates first.', 'builder-template-categories' );
        default:
            return $message;
    }
};
