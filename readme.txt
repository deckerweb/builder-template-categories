=== Builder Template Categories ===
Contributors: deckerweb
Tags: templates, categories, builders, patterns
Requires at least: 7.0
Requires PHP: 8.1
Stable tag: 1.9.2
Tested up to: 7.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Shared project categories for supported WordPress template libraries. Final feature release.

== Development ended ==
Development ended with version 1.9.0. WordPress and modern builders now cover the original tasks, and workflows have changed. Only security updates may follow if needed, no later than December 31, 2027.

Explore Builder Content Guide: https://github.com/deckerweb/builder-content-guide
More tools: Builder Shortcode Extras, Bricks QuickNav and Breakdance QuickNav (links in README.md).

== Description ==
Maintenance 1.9.2 includes Library 1.1.0 and Updater 2.2.1 (GPL-2.0-or-later, David Decker). Online catalog retrieval is off by default; catalog, installation and update requests contact GitHub, which can see the requesting IP address. No telemetry. See README.md for details.

Organize the retained template libraries in WordPress admin. Existing categories and assignments are preserved. Version 1.9.0 removed 72 older integration files. Current requirements are WordPress 7.0 / PHP 8.1.

Builder Categories belong to this plugin and are independent of the native WordPress pattern categories. Existing terms and assignments are preserved. The two taxonomies are not automatically synchronized.

== Installation ==
1. Back up your database and plugin files.
2. Upload the ZIP through Plugins > Add Plugin > Upload Plugin.
3. Activate and open a supported template library.
4. Create categories, assign them and filter the list table.

== Frequently Asked Questions ==
= Will there be more updates? =
Only necessary security fixes, no later than December 31, 2027.

= Are existing categories deleted? =
No. Deactivation and uninstall retain categories and assignments.

= Which integrations remain? =
WordPress user patterns, Elementor, Bricks, Beaver Builder / Themer, Divi, Oxygen Classic, Avada, GeneratePress Elements and Astra Pro layouts.

= Who can use internal categories? =
Users with edit_theme_options by default. The capability is filterable.

= Does it migrate to Builder Content Guide? =
No automatic migration. The guide is an independent plugin.

== Changelog ==
= 1.9.2 =
* Fixed: Reliable GitHub updates with bundled Updater 2.2.1 when an older copy was loaded first.

= 1.9.1 =
* Improved: Shared Library 1.1.0 and Updater 2.2.0 integration with host package validation.
* Fixed: Late escaping in category output.
* Misc: PHP 8.1 minimum; existing feature freeze and security deadline retained.

= 1.9.0 =
* Native Patterns menu: saved patterns, add pattern and Builder Categories, with existing WordPress permissions.
* Improved: Reduced integrations and removed legacy and unrelated behavior.
* Fixed: Block-editor translations, REST permissions, invalid category IDs, safe output and Multisite initialization.
* Misc: WordPress 7.0 / PHP 8.0 minimum; final feature release. Possible security fixes end by December 31, 2027.

== Upgrade Notice ==
= 1.9.2 =
Updates the bundled updater to 2.2.1. Existing settings, categories and minimum requirements are unchanged.

= 1.9.1 =
Requires PHP 8.1. Adds shared Library and native GitHub updates as a maintenance exception. Categories are retained. Feature freeze and security deadline December 31, 2027 remain unchanged.
