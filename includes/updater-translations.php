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
        case 'Catalog diagnostics require a public catalog provider.':
            return __( 'Catalog diagnostics require a public catalog provider.', 'builder-template-categories' );
        case 'Catalog approval':
            return __( 'Catalog approval', 'builder-template-categories' );
        case 'Package download':
            return __( 'Package download', 'builder-template-categories' );
        case 'Checksum verification':
            return __( 'Checksum verification', 'builder-template-categories' );
        case 'Archive verification':
            return __( 'Archive verification', 'builder-template-categories' );
        case 'The update server could not be reached. Try again later.':
            return __( 'The update server could not be reached. Try again later.', 'builder-template-categories' );
        case 'The update request timed out. Try again later.':
            return __( 'The update request timed out. Try again later.', 'builder-template-categories' );
        case 'The update server address could not be resolved.':
            return __( 'The update server address could not be resolved.', 'builder-template-categories' );
        case 'The secure connection to the update server failed.':
            return __( 'The secure connection to the update server failed.', 'builder-template-categories' );
        case 'The update server returned an unsuccessful HTTP response.':
            return __( 'The update server returned an unsuccessful HTTP response.', 'builder-template-categories' );
        case 'The update provider did not return valid update data.':
            return __( 'The update provider did not return valid update data.', 'builder-template-categories' );
        case 'The package does not match the approved checksum. Installation was stopped.':
            return __( 'The package does not match the approved checksum. Installation was stopped.', 'builder-template-categories' );
        case 'The archive or plugin identity could not be verified. Installation was stopped.':
            return __( 'The archive or plugin identity could not be verified. Installation was stopped.', 'builder-template-categories' );
        case 'Update stopped at %1$s: %2$s':
            /* translators: 1: update stage, 2: fixed explanation. */
            return __( 'Update stopped at %1$s: %2$s', 'builder-template-categories' );
        case 'HTTP status: %d.':
            /* translators: %d: HTTP error status. */
            return __( 'HTTP status: %d.', 'builder-template-categories' );
        case 'Invalid private download limits.':
            return __( 'Invalid private download limits.', 'builder-template-categories' );
        case 'Invalid package cleanup provider.':
            return __( 'Invalid package cleanup provider.', 'builder-template-categories' );
        case 'Safe package cleanup is unavailable for this update provider.':
            return __( 'Safe package cleanup is unavailable for this update provider.', 'builder-template-categories' );
        case 'The update package identity, version or requirements could not be verified.':
            return __( 'The update package identity, version or requirements could not be verified.', 'builder-template-categories' );
        default:
            return $message;
    }
};
