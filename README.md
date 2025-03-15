# Builder Template Categories - for WordPress Page Builders

Organize your Page Builder Templates in the WordPress Admin. Better overview, don't get lost. Time saver. With extended plugin & theme support.

![Builder Template Categories plugin banner](https://raw.githubusercontent.com/deckerweb/builder-template-categories/master/assets-github/btc-banner.png)

### Tested Compatibility
- **WordPress**: 6.7.2
- **PHP**: 8.3+
- Requires at least: WP 6.7 / PHP 7.4

---

[Support Project](#support-the-project) | [Installation](#installation) | [Description](#description) | [Frequently Asked Questions](#frequently-asked-questions) | [Screenshots](#screenshots) | [Changelog](#changelog) | [Plugin Scope / Disclaimer](#plugin-scope--disclaimer)

---

## Support the Project

If you find this project helpful, consider showing your support by buying me a coffee! Your contribution helps me keep developing and improving this plugin.

Enjoying the plugin? Feel free to treat me to a cup of coffee ☕🙂 through the following options:

- [![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/W7W81BNTZE)
- [Buy me a coffee](https://buymeacoffee.com/daveshine)
- [PayPal donation](https://paypal.me/deckerweb)

---

## Installation

**Quick Install – as Plugin**
1. **Download ZIP:** [**builder-template-categories.zip**](https://github.com/deckerweb/builder-template-categories/releases/latest/download/builder-template-categories.zip)
2. Upload via WordPress Plugins > Add New > Upload Plugin
3. Go to your already active plugin or theme which has the template library and you'll see the additional template category as a new submenu item (for example: "Template Categories").
4. Now enjoy organizing your templates, get better overview and save time ;-)


### Minimum Requirements 

* WordPress version 6.7 or higher
* PHP version 7.4 or higher (better 8.3+)
* MySQL version 5.6 or higher / OR MariaDB 10.1 or higher
* Administrator user with capability `edit_theme_options`
* HTTPS support

---

## Description 

Organize your Page Builder Templates in the WordPress Admin. Time saver, especially for bigger projects. Get a better and faster overview, don't get lost. Filter templates with your categories. With extended plugin & theme support.

[![Video of Plugin's Live Demo and Walkthrough](https://img.youtube.com/vi/9FhIJ2QxOoQ/0.jpg)](https://www.youtube.com/watch?v=9FhIJ2QxOoQ)  
[**original video link**](https://www.youtube.com/watch?v=9FhIJ2QxOoQ) *by plugin developer David Decker*

Out of the box the plugin includes integrations for a lot of awesome Page Builders, Themes and Plugins. If any supported integration is installed & active, the "Builder Template Categories" plugin just applies its additions. The plugin is really lightweight and simple. Just activate and you're done - and can use the categorization.


### ♥️ What the Plugin does? 
- **Better organize** your templates if you have many of them
- **Better overview** for admins and site builders
- **Filtering** in the overview table of a post type (typical WordPress overview) via Dropdown Filter, or Link filter in the row of a post type's post
- For **WordPress 5.0+** with Block Editor (Gutenberg): make the Reusable Blocks visible in Admin and **organize** them - yeah, finally! Your growing collection of reusable blocks needs some organization - this plugin here makes it possible! ;-)
- Only for admins, within the admin - a great helper tool
- No frontend, no scripts, no styles - nothing! :-)
- Lightweight, efficient
- Developer friendly: clean code, inline documentation, lots of filters available


### 🚀 Typical Use Case of this Plugin 
You are building a **big site** with **lots of different templates** across **various template libraries** of different plugins.
Now the "Builder Template Categories" plugin helps you organize those templates better and more efficiently. For example you have a template category "Landing Pages".
This category is now visible in Elementor's "My Templates", as well as in the Theme "GeneratePress" and its "Elements" Module, as well as in "PopBox for Elementor" plugin and also in "Pods" plugin's "Templates".

So in every one of those libraries you can now filter and list all parts of templates for this specific post type that belong to your "Landing Pages" category.

Please note: The categories are global but when filtering only those items are listed that are connected to the specific post type. [See the FAQ for more info on that](https://wordpress.org/plugins/builder-template-categories/#faq)


### 🎉 Supported Page Builders 
* **Elementor Page Builder** Plugin (free version is sufficient) - **My Templates** (for Pages, Sections, and with Elementor Pro even more template types)
* **Brizy Page Builder** Plugin (free version is sufficient) - **Templates** (for Pages, Sections etc.)
* **Oxygen Builder** Plugin (Pro) - **Templates** (for Pages, Layouts, Sections, Theme Builder elements...) -- *Note: also the old Oxygen Visual Site Builder 1.x is supported*  
  **Oxygen User Elements Library** (for Blocks, Layouts, Sections, Theme Builder elements...) -- *Note: only if enabled in Oxygen v2.3 alpha 1 or higher*
* **Visual Composer Website Builder** (the new one, 2018) - **Global Templates** / **Header, Footer, Sidebars Templates**
* **WPBakery Page Builder (the old 'Visual Composer')** Plugin with its **Templatera** template plugin - **Templates** (for Pages, Layouts, etc.)
* **Cornerstone** Page Builder via the "Cornerstone Global Blocks" Plugin (free) - **Global Blocks** (for Content)
* **BoldGrid Post and Page Builder** Plugin (free) - **Blocks (Templates)**
* **Themify Builder** Plugin (Premium version) - **Layouts** (for Layout Parts, Pages, Sections etc.)
* **Avada Fusion Builder** Plugin in the *Avada Theme* (Premium) - **Library** (for Templates, Pages, Layouts, Columns, Rows)
* **Beaver Builder** Plugin (Pro) - **Templates** (for Templates, Pages, Layouts, Rows etc.) - also including *Beaver Themer* support
* **Divi Builder** as Plugin version/ as Divi Theme version/ as Extra Theme version (all Pro) - **Library** (for Templates etc.) - **Category Templates** (for Layouts, Templates etc.)
* [**Gutenberg / Block Editor of WordPress 5.0+**](https://wordpress.org/plugins/gutenberg/) - **Blocks** (for Reusable Blocks - the new core feature)


### 🎨 Supported Themes 
* **Astra Theme** with **Astra Pro** Add-On Plugin - **Custom Layouts** (for Layouts, Headers, Footers, Hooks)
* **GeneratePress Theme** with "GP Premium" Add-On Plugin - **Elements** (for Layouts, Headers, Hooks)
* **OceanWP Theme** with "Ocean Extra" free Plugin - **My Library** (for Layouts, Hooks etc.)
* **Kava Pro Theme/ CrocoBlock Service** with JetThemeCore Plugin - **My Library** (for Layouts, Pages, Headers, Footers, Single, Archive)
* **Genesis Framework** with Genesis Child Themes -- via **Blox Lite** and **Blox** (Pro) Plugins - **Global Content Blocks** (Sections, Hooks)
* **Page Builder Framework** with **WPBF Premium** Add-On Plugin - **Custom Section** (for Sections, Layouts, Hooks etc.)
* **Customify** with **Customify Pro** Add-On Plugin - **Hooks** (for Layouts, Sections, Hooks etc.)
* **Suki** with **Suki Pro** Add-On Plugin - **Custom Blocks** (for Layouts, Sections, Hooks etc.)
* **Neve** with **Neve Pro** Add-On Plugin - **Custom Layouts** (for Layouts, Sections, Hooks etc.)
* **Woostify** with **Woostify Pro** Add-On Plugin - **Header Footer Builder** (for Elementor theming areas - Headers/ Footers)
* **Avada Theme** with Avada Fusion Builder - **Library** (for Templates, Pages, Layouts, Columns, Rows)
* **Divi Theme** with Divi Builder - **Library** (for Templates etc.)
* **Extra Theme** with Divi Builder - **Library** (for Templates etc.) - **Category Templates** (for Layouts, Templates etc.)


### 🚀 Supported Plugins 
* *see Page Builder Plugins above :-)*
* *see Gutenberg-specific Plugins below :-)*
* [**AnyWhere Elementor**](https://wordpress.org/plugins/anywhere-elementor/) Plugin (both, free & Pro version) - **AE Global Templates** (for Layouts, Content, Pages etc.)
* **Kava Pro Theme/ CrocoBlock Service** with JetThemeCore Plugin - **My Library** (for Layouts, Pages, Headers, Footers, Single, Archive)
* **JetEngine for Elementor** Plugin - **Listings** (Templates) - **Forms** (JetEngine Appointment Forms etc.)
* **JetWooBuilder for Elementor** Plugin - **Product Templates** (for WooCommerce Products)
* [**Blox Lite**](https://wordpress.org/plugins/blox-lite/) and **Blox** (Pro) Plugins, both for Genesis Framework - **Global Content Blocks** (for Sections, Hooks)
* **Oxygen Builder** Plugin (Pro) - **Templates** (for Pages, Layouts, Sections, Theme Builder elements...) - **User Elements Library** (Elements, Blocks, Content)
* [**Header Footer for Elementor**](https://wordpress.org/plugins/header-footer-elementor/) Plugin - **Header & Footer Templates** (for Elementor theming areas)
* **DHWC Elementor** Plugin - **Product Templates** (for WooCommerce Products)
* [**Kadence WooCommerce Elementor**](https://wordpress.org/plugins/kadence-woocommerce-elementor/) Plugin - **Product Templates** (for WooCommerce Products)
* [**PopBoxes for Elementor**](https://wordpress.org/plugins/modal-for-elementor/) Plugin - **Popups (Templates)** (for Popups, Lightboxes)
* [**StylePress for Elementor**](https://wordpress.org/plugins/full-site-builder-for-elementor/) Plugin - **Styles (Templates)** (for Theme Templates)
* [**Templementor**](https://wordpress.org/plugins/templementor/) Plugin - **Templates** (for Elementor content)
* **Thrive Lightboxes** Plugin - **Lightboxes (Templates)** (for Lightboxes, Popups)
* [**Popup Maker**](https://wordpress.org/plugins/popup-maker/) Plugin - **Popups (Templates)** (for Popups, Lightboxes)
* [**Pods**](https://wordpress.org/plugins/pods/) Plugin - **Templates** (for Post Types, Taxonomies, Fields, etc.) -- Note: the "Templates" Component needs to be enabled in Pods' settings!
* [**WP Show Posts**](https://wordpress.org/plugins/wp-show-posts/) Plugin - **Listings (Templates)** (for Post Listings)
* **JetSmartFilters** Plugin - **Filters** (Templates for Filter Controls, Listings etc.)
* **JetPopup** Plugin - **Popups** (for Popups)
* [**CartFlows**](https://wordpress.org/plugins/cartflows/) Plugin - **Flows** (for WooCommerce *Checkout* & *Thank You* Pages)
* [**Cherry PopUps**](https://wordpress.org/plugins/cherry-popups/) Plugin - **Popups** (for Popups)
* [**Themify Popup**](https://wordpress.org/plugins/themify-popup/) Plugin - **Popups** (for Popups)
* [**Meta Box Post Types**](https://wordpress.org/plugins/mb-custom-post-type/) Add-On Plugin - **Post Types** (for Post Type registrations)
* [**Meta Box Taxonomy**](https://wordpress.org/plugins/mb-custom-taxonomy/) Add-On Plugin - **Taxonomies** (for Taxonomy registrations)
* [**Content Blocks (Custom Post Widget)**](https://wordpress.org/plugins/custom-post-widget/) Plugin - **Blocks** (for Content)
* [**Reusable Content & Text Blocks (by Loomisoft)**](https://wordpress.org/plugins/loomisoft-content-blocks/) Plugin - **Blocks** (for Content)
* [**Dev Content Blocks**](https://wordpress.org/plugins/dev-content-blocks/) Plugin - **Blocks** (for Content)
* [**Reusable Text Blocks**](https://wordpress.org/plugins/reusable-text-blocks/) Plugin - **Blocks** (for Content, Text)
* [**Widget Content Blocks**](https://wordpress.org/plugins/wysiwyg-widgets/) Plugin - **Blocks** (for Widgets, Content)
* [**Reusable Content Blocks**](https://wordpress.org/plugins/reusable-content-blocks/) Plugin - **Blocks** (for Content, Text, etc.)
* [**Advanced Custom Fields (ACF)**](https://wordpress.org/plugins/advanced-custom-fields/) Plugin (both, free & Pro version) - **Field Groups** (for Custom Fields, Options)
* [**Custom Field Suite**](https://wordpress.org/plugins/custom-field-suite/) Plugin - **Field Groups** (for Custom Fields, Options)
* [**CMB2 Admin Extension**](https://wordpress.org/plugins/cmb2-admin-extension/) Plugin - **Field Groups** (for Custom Fields, Options)
* **Meta Box Builder** and **Meta Box All-In-One (AIO)** Plugins (both Premium) - **Field Groups** (for Custom Fields, Options)
* [**Custom Template for LifterLMS**](https://wordpress.org/plugins/custom-template-lifterlms/) Plugin - **Templates** (for Courses etc.)
* [**Custom Template for LearnDash**](https://wordpress.org/plugins/custom-template-learndash/) Plugin - **Templates** (for Courses etc.)
* [**Opal Widgets for Elementor**](https://wordpress.org/plugins/opal-widgets-for-elementor/) Plugin - **Templates** (for Headers, Footers)
* **Epic News Elements** Plugin - **Templates** (for Posts/ Singular, Archives)
* **Smart Footer System** Plugin - **Templates** (for Footers)
* **Master Popups** Plugin - **Popups** (for Popups)
* [**Easy Content Templates**](https://wordpress.org/plugins/easy-content-templates/) Plugin - **Templates** (for Content)
* [**Simple Content Templates**](https://wordpress.org/plugins/simple-post-template/) Plugin - **Templates** (for Content)
* **Custom Page Templates** Plugin - **Templates** (for Pages, Post Types) / **Post Types** (for Post Type registrations) / **Taxonomies** (for Taxonomy registrations)
* **Beaver Themer** Plugin (Pro) - **Themer Layouts** (for Templates)
* [**Give Donations**](https://wordpress.org/plugins/give/) Plugin - **Donation Forms** (for Forms)
* [**HappyForms**](https://wordpress.org/plugins/happyforms/) Plugin (free & Pro version) - **Forms**
* [**Reusable Layouts for SiteOrigin**](https://wordpress.org/plugins/reusable-layouts-for-siteorigin/) Plugin - **Layouts** (for Templates etc.)
* [**Lightweight Sidebar Manager**](https://wordpress.org/plugins/sidebar-manager/) Plugin - **Sidebars** (for Sidebars, Widget Areas)
* [**Reusable Blocks - Elementor, Beaver Builder, WYSIWYG**](https://wordpress.org/plugins/design-sidebar-using-page-builder/) Plugin - **Templates** (for Sections, Sidebars, etc.)
* [**HT Script (Insert Headers and Footers Code)**](https://wordpress.org/plugins/insert-headers-and-footers-script/) Plugin - **Scripts** (for Custom Code)
* **ToolKit for Elementor** Plugin (Pro) - **My Templates** (for Elementor Templates)
* [**Elements Kit**](https://wordpress.org/plugins/elementskit-lite/) Plugin (free & Pro version) - **My Templates** (for Elementor Templates)
* [**Flo Forms**](https://wordpress.org/plugins/flo-forms/) Plugin - **Forms** (for Contact Forms etc.)
* [**Woody Snippets**](https://wordpress.org/plugins/insert-php/) Plugin - **Snippets** (for Code Snippets, Ad Snippets etc.)
* [**Boxzilla**](https://wordpress.org/plugins/boxzilla/) Plugin (free & Pro version) - **Boxes** (for Popups, Boxes, Sections etc.)
* [**Holler Boxes**](https://wordpress.org/plugins/holler-box/) Plugin - **Boxes** (for Popups, Boxes, Sections etc.)


### 📦 Supported Gutenberg-specific Plugins (Block Editor)
* [**Lazy Blocks**](https://wordpress.org/plugins/lazy-blocks/) Plugin - **Blocks** (Templates for Gutenberg Blocks)
* [**Block Lab**](https://wordpress.org/plugins/block-lab/) Plugin - **Blocks** (Templates & Fields for Gutenberg Blocks)
* [**Advanced Custom Blocks**](https://wordpress.org/plugins/advanced-custom-blocks/) Plugin - **Blocks** (Templates & Fields for Gutenberg Blocks)
* [**Blocks Layouts**](https://wordpress.org/plugins/blocks-layouts/) Plugin - **Layouts** (Layouts for Gutenberg Blocks)
* [**Square Happiness: Placeholder Block**](https://wordpress.org/plugins/placeholder-block-square-happiness/) Plugin - **Blocks** (Placeholders/ Templates for Gutenberg Blocks)
* [**Gutenberg Templates (Block Templates)**](https://wordpress.org/plugins/block-templates/) Plugin - **Templates** (Templates for Gutenberg Blocks)
* [**Block Areas**](https://wordpress.org/plugins/block-areas/) Plugin - **Areas** (Templates for Theme/Block Areas)


### ℹ️ Important: Required/ Recommended for plugin usage 
* Required: User has role `Administrator` (needed capability `edit_theme_options`)
* Required: User is logged in (of course)

---

## Frequently Asked Questions 


### How to apply template categories in bulk?
Applying template categories to more than one template at once is easily possible: just use the built-in "Bulk Actions" from WordPress Core, which are available for any post type.

* Go to the post type of your templates, for example "Elementor My Templates"
* On top of the so-called overview table (Post List Table) look for **Bulk Actions**
* In the table check (select) any template you want to add a category to
* In the Bulk Actions drop-down menu, select the "Edit" action and then click the **Apply** button next to the drop-down --> NOTE: v1.1.0 of our plugin tweaks the label to this **Edit, add Category etc.** to make the whole thing more clear! :-)
* Then assign any category you want to the selected templates
* Don't forget to click the "Save" button once you're done

[![Video of adding template categories via Bulk Action - Live Demo and Walkthrough](https://img.youtube.com/vi/KyCY-cGAB9o/0.jpg)](https://www.youtube.com/watch?v=KyCY-cGAB9o)
[**original video link**](https://www.youtube.com/watch?v=KyCY-cGAB9o) *by plugin developer David Decker*



### Why is the taxonomy "global" and applied to more than one post type? 
The answer is simple: Our taxonomy is only for organizing purposes if you have to manage many, many templates. It is easy to just enter 2 or more different categories if you use more than one of the supported integrations (and therefore have our taxonomy applied to more than one post type).

It would add a lot of bloat to register a "organizing taxonomy" for every supported post type of an integration. This really makes absolutely no sense in my opinion. Of course, you are free to tweak the behavior of the plugin with the built-in filters or WordPress Core functions, filters, actions and classes. Plus, you can at any time easily register any custom taxonomy yourself.

This plugin here is a "quick and easy" solution: install, activate, organize with categories. Done.



### The category counter displays wrong number? 
The counter works fine, really.
The "issue" you're seeing is most likely that: you have more than one of the supported integrations active. Therefore the categories are global and applied to each of the integrations. But the terms count for the categories remains also global.

*Example:*

* Example Category: "Landing Pages"
* for "Landing Pages" - Count in "Elementor My Templates": 5
* for "Landing Pages" - Count in "Astra Custom Layouts": 10

The term **counter** in the **taxonomy list table** will always display: **15**. This is the **global term count**.

Continuing the example: When filtering in "Elementor My Templates" for "Landing Pages" you will get 5 results. Which is fully correct. These are the 5 results that are connected to *this* post type. The same filter in "Astra Custom Layouts" will bring 10, of course, as only these 10 terms are connected to *this* Layouts Post Type. And so on...! :)



### Why is the Administrator Role recommended? 
This plugin only works and makes sense for Administrator users just because the post types it integrates with are mostly only accessable for administrators. The target user group of this plugin are site builders, admins, developers who want to organize their admin area better, plus their website projects.

To customize the capability to make the taxonomy appear in the Admin Dashboard you can use a filter:
```
add_filter( 'btc/filter/capability/submenu', 'btc_custom_capability_submenu' );
/**
 * Plugin: Builder Template Categories - Custom capability.
 *
 * @return string String ID of new capability.
 */
function btc_custom_capability_submenu() {

	return 'edit_posts';

}  // end function
```
([This code snippet as a GitHub Gist](https://gist.github.com/deckerweb/89f5f8d2b8d31073401a80ef6d0f10dc))



### Is Elementor required for this plugin? 
Elementor (free) is not required. But once it is installed and active the integration gets loaded, meaning, the taxonomy for categorizing Elementor templates appears (My Templates Library). This will make organizing templates a breeze ;-)

I totally [recommend Elementor](https://toolbarextras.com/go/elementor/) - so, with it active, this plugin here will make the perfect sense!


### Is Elementor Pro required for this plugin? 
Absolutely not. For the Elementor integration the free version of Elementor is enough as it already adds the template library ("My Templates").

However, I [strongly recommend Elementor Pro](https://toolbarextras.com/go/elementor-pro/) as it is so useful for Non-Coder Designers site builders.



### Where are the other popular Page Builders? 
All the others already have template categories by default, or, on the other hand, cannot be supported with a post type taxonomy.

* Thrive Architect: has category feature already built-in
* SiteOrigin Page Builder: library built-in, but it is currently impossible to extend it with this taxonomy... - only possible via third-party plugin "Reusable Layouts for SiteOrigin" (free, by Echelon) which we already integrated with since our plugin version 1.6.0

*Update:*  
* Brizy Page Builder added template feature in their version 1.0.25 - we added integration with our plugin version 1.0.1
* Visual Composer Website Builder for Headers, Footers, Sidebars, Global Templates - we added integration with our plugin version 1.4.0
* Avada Fusion Builder in *Avada Theme* - we added integration with our plugin version 1.4.0
* Beaver Builder & Beaver Themer - we added integration with our plugin version 1.6.0
* Divi Builder (plugin version, Divi Theme, Extra Theme) - we added integration with our plugin version 1.6.0



### Will other Themes be supported? 
Yes, absolutely. – Once I discover another theme (or via an add-on plugin) which adds a template library but has no categories for organizing I consider adding an integration. Of course, you can also make me aware of other themes and plugins with such libraries.



### Will other third-party Plugins be supported? 
Yes, absolutely. - Once I discover another plugin which adds a template library but has no categories for organizing I consider adding an integration. Of course, you can also make me aware of other themes and plugins with such libraries.



### Does this Plugin work with Gutenberg / WordPress 5.0+ / Block Editor?
Yes, of course! - The plugin is fully compatible with Gutenberg Block Editor which is (becoming) WordPress 5.0+. It even supports the "Reusable Blocks" feature and adds our template category for that. This means, you can now categorize your reusable blocks and edit them from a dedicated screen!

Beyond that, there is already integration with some Gutenberg-specific plugins built-in. More integrations might follow over time.



### Does this Plugin work with Classic Editor and even ClassicPress?
Yes, this plugin works with the Classic Editor plugin perfectly fine.

I will try my best to also have my plugin work perfectly in ClassicPress, the fork of WordPress without Gutenberg. It should already be fully compatible but I will follow all events closely to adjust compat if needed.



### Will this Plugin slow down my site? 
Absolutely not. The plugin will only do its stuff for logged-in Administrator users. It does nothing for visitors of your site. Plugin loads its stuff only when needed and if supported theme/ plugin is active. Plugin was built to be as lightweight as possible.



### Does the Plugin work with Multisite? 
Yes, it works fine in Multisite, you could even activate it Network-wide. However, the taxonomy is only added on a per site basis (if the supported integrations are active). Therefore it makes the most sense to activate the plugin on a per site basis.



### Do I need to have any of the integrations installed?
Technically not. However, without the integrations this plugin doesn't make any sense. So you want to have at least *one* of the integrations installed and activated.

Or, you can also register your own custom integration (see snippets below) if you do not want or need the built-in integrations.

Note: One exception is the new Block Editor since WordPress 5.0+. The Block Editor has a feature called "Reusable Blocks" and this is already natively integrated with our plugin, "Builder Template Categories". So, once you have Gutenberg or WordPress 5.0+ active you already have one native integration active by default ;-).



### Do I still need this plugin since Elementor has its own Category now?
Good question. If you used our plugin, Builder Template Categories, before it's recommended to use it still to not lose your data and for consistency, of course. You absolutely can run both taxonomies side by side. This plugin always plays nice with others! ;-)

And, Builder Template Categories, has a **big advantage** over Elementor's own taxonomy: **our taxonomy is global!** This means, it is used by other integrations at the same time - if those are active side by side with Elementor. This "effect" just makes our plugin way more smart and usable.

**That is especially useful if you work with Elementor, *PLUS* one of these:**

- GeneratePress Elements (GP Premium)
- Astra Custom Layouts (Astra Pro)
- OceanWP Library
- Page Builder Framework Sections (WPBF Premium)
- Genesis Blox plugin (free or Pro)
- One of the Jet Plugins by Zemez Jet (JetWooBuilder, JetThemeCore, JetListing, JetPopop, JetSmartFilters)
- AnyWhere Elementor plugin (free or Pro)
- Templementor

If you ask me: In such a case Builder Template Categories has way more power and makes just more sense, also if you're working with a team.

*Note: Shortly I will also provide ways to disable Elementor's taxonomy if you want.*



### Can I extend or customize the plugin? 
Yes, of course.
There are numerous filters built-in, plus the default filters for taxonomies from WordPress Core apply.

If you want to add support for your own custom library, just declare the following register statement via our filter:
```
add_filter( 'btc/filter/integrations/all', 'btc_register_custom_integration' );
/**
 * Plugin: Builder Template Categories - Register custom integration.
 *
 * @param  array $integrations Holds array of all registered integrations.
 * @return array Tweaked array of registered integrations.
 */
function btc_register_custom_integration( array $integrations ) {

	$post_type = 'your-post-type';

	$submenu_hook = 'your-custom-settings-page';	// as in: your-site.domain/wp-admin/admin.php?page=your-custom-settings-page;
	// or alternative: $submenu_hook = 'edit.php?post_type=' . $post_type;

	$template_label = 'template';	// or: library, layout, element, popup, lightbox, block, listing, post-type, field, box, bar, hook, filter, section, flow, snippet

	$integrations[ 'your-custom-handle-lowercase' ] = array(
		'label'          => __( 'My Custom Templates', 'your-textdomain' ),
		'submenu_hook'   => $submenu_hook,
		'post_type'      => $post_type,
		'template_label' => $template_label,
		'admin_url'      => 'edit.php?post_type=' . $post_type,
	);

	return $integrations;

}  // end function
```
([This code snippet as a GitHub Gist](https://gist.github.com/deckerweb/cae6d2703400601e2e78be3a27e93cfb))

Best practice is to wrap the whole code above in a conditional to check if the theme/ plugin/ post type is active before applying anything from our "Builder Template Categories" stuff.



### More info on Translations? 

* English - default, always included
* German (de_DE): Deutsch - immer dabei! :-)
* For custom and update-safe language files please upload them to `/wp-content/languages/builder-template-categories/` (just create this folder) - This enables you to use fully custom translations that won't be overridden on plugin updates. Also, complete custom English wording is possible with that as well, just use a language file like `builder-template-categories-en_US.mo/.po` to achieve that (for creating one see the following tools).

**Easy WordPress.org plugin translation platform with GlotPress platform:** [**Translate "Builder Template Categories"...**](https://translate.wordpress.org/projects/wp-plugins/builder-template-categories)

*Note:* All my plugins are internationalized/ translateable by default. This is very important for all users worldwide. So please contribute your language to the plugin to make it even more useful. For translating and validating I recommend the awesome ["Poedit Editor"](https://www.poedit.net/), which works fine on Windows, macOS and Linux.



### Some Statistics?
As of version 1.5.0 of the plugin the following was achieved:

* 1 Taxonomy
* 65 Integrations overall
* 1 Core Integration (Gutenberg Block Editor)
* 9 Theme Integrations
* 10 Page Builder Integrations
* 46 Plugin Integrations
* Up to 76 different post types (of integrations) supported
* 16 generic template content types, plus 1 plugin-specific template content type

---

## Screenshots 

### 1. Template Categories for Elementor "My Templates" - Filtering for templates: 1) Dropdown of template categories, 2) Links to template categories
![Template Categories for Elementor "My Templates" - Filtering for templates: 1) Dropdown of template categories, 2) Links to template categories](https://ps.w.org/builder-template-categories/assets/screenshot-01.png)


### 2. List of Template Categories - plus help info about all current active integrations
![List of Template Categories - plus help info about all current active integrations](https://ps.w.org/builder-template-categories/assets/screenshot-02.png)


### 3. Edit a template category: 1) Title is the most important item; 2) Description field ist useful for internal notes or for your team of designers/ site builders etc.
![Edit a template category: 1) Title is the most important item; 2) Description field ist useful for internal notes or for your team of designers/ site builders etc.](https://ps.w.org/builder-template-categories/assets/screenshot-03.png)


### 4. Template categories for "Astra Custom Layouts" - Astra Theme via Astra Pro plugin
![Template categories for "Astra Custom Layouts" - Astra Theme via Astra Pro plugin](https://ps.w.org/builder-template-categories/assets/screenshot-04.png)


### 5. Template categories for "GeneratePress Elements" - GP Premium plugin (v1.7+)
![Template categories for "GeneratePress Elements" - GP Premium plugin (v1.7+)](https://ps.w.org/builder-template-categories/assets/screenshot-05.png)


### 6. Template categories for "OceanWP My Library" - Ocean Extra plugin
![Template categories for "OceanWP My Library" - Ocean Extra plugin](https://ps.w.org/builder-template-categories/assets/screenshot-06.png)


### 7. Edit a template - and set the template category (Example of an Elementor template)
![Edit a template - and set the template category (Example of an Elementor template)](https://ps.w.org/builder-template-categories/assets/screenshot-07.png)


### 8. Post type Bulk Actions: add template category to selected templates in one action step
![Post type Bulk Actions: Add a template category to selected templates in one action step](https://ps.w.org/builder-template-categories/assets/screenshot-08.png)


### 9. Plugins page - list of all plugins - "Builder Template Categories" with link to taxonomy listing table
![Plugins page - list of all plugins - "Builder Template Categories" with link to taxonomy listing table](https://ps.w.org/builder-template-categories/assets/screenshot-09.png)


### 10. Reusable Blocks support in Block Editor (Gutenberg) in WordPress 5.0+ - post type list table (overview)
![Reusable Blocks support in Block Editor (Gutenberg) in WordPress 5.0+ - post type list table (overview)](https://ps.w.org/builder-template-categories/assets/screenshot-10.png)


### 11. Editing a Reusable Block - adding the "Builder Template Categories" taxonomy via the new Block Editor JavaScript-based meta box
![Editing a Reusable Block - adding the "Builder Template Categories" taxonomy via the new Block Editor JavaScript-based meta box](https://ps.w.org/builder-template-categories/assets/screenshot-11.png)


---

## Changelog 

### 1.8.0 – March 2025
_Currently being worked on!_
* Brought back plugin into a more lightweight and working state as it was originally intended!
* Some info links, help texts, plus the _DDWlib Plugin Installer Recommendations_ library got removed, it is no longer wanted/supported anyways
* **Note:** No longer in the .org plugin repo available – thanks to Matt... (I've taken it out myself as I have no longer interest in WordPress.org repo strategy) – just install yourself via ZIP file, see above under [**Installation**](#installation)


### 🎉 1.7.0 - 2019-09-23 
* New: Extended integration with plugin JetEngine (Premium, by Zemez Jet/ CrocoBlock) for Form Categories
* New: Added integration with plugin ToolKit for Elementor (Premium, by ToolKit for Elementor)
* New: Added integration with theme Woostify - Header & Footers via Woostify Pro Add-On plugin (Premium, by BoostifyThemes)
* New: Added integration with plugin Woody Snippets (formerly: Insert PHP) (free, by Webcraftic)
* New: Added integration with plugin ElementsKit Lite/Pro (free/Premium, by wpmet)
* New: Added integration with plugin Flo Forms (free, by Flothemes)
* New: Added integration with plugin Boxzilla (free, by ibericode)
* New: Added integration with plugin Holler Box (free, by Scott Bolinger)
* New: Added integration with theme Neve - Neve Custom Layouts via Neve Pro Add-On plugin (Premium, by ThemeIsle)
* New: Added new template content types "URL/ URLs" and "Redirect/ Redirects"
* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.5.0) - better performance due to the use of transients
* Tweak: Minor code improvements
* Tweak: Updated `.pot` file plus all German translations (formal, informal) and language packs


### 🎉 1.6.0 - 2019-08-16
* New: Added integration with plugin GiveWP Donations (free, by GiveWP/ Impress.org, LLC)
* New: Added integration with plugin Lightweight Sidebar Manager (free, by Brainstorm Force)
* New: Added integration with plugin Reusable Layouts for SiteOrigin (free, by Echelon)
* New: Added integration with plugin Reusable Blocks - Elementor, Beaver Builder, WYSIWYG (free, by WebEmpire)
* New: Added integration with plugin Block Areas (free, by The WP Rig Contributors)
* New: Added integration with plugin HT Script (Insert Headers and Footers Code) (free, by HasThemes)
* New: Added integration with plugin HappyForms (free) and HappyForms Pro (Premium) (both by The Theme Foundry)
* New: Added integration with plugin Beaver Builder (Premium, by The Beaver Builder Team) -- the pro version
* New: Added integration with plugin Beaver Themer (Premium, by The Beaver Builder Team)
* New: Added integration with plugin Divi Builder (Premium, by Elegant Themes)
* New: Added integration with theme Divi (Premium, by Elegant Themes)
* New: Added integration with theme Extra (Premium, by Elegant Themes)
* New: Added new template content types "Sidebar/ Sidebars", "Area/ Areas", "Form/ Forms" and "Script/ Scripts"
* Tweak: Corrected some labels for their singular/plural form
* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.4.1) - feature updates
* Tweak: Minor code improvements
* Tweak: Updated `.pot` file plus all German translations (formal, informal) and language packs


### ⚡ 1.5.1 - 2019-05-03
* *New: Successfully tested with WordPress 5.2*
* *New: Successfully tested with ClassicPress 1.0.1*
* New: Integrated with WordPress 5.2+ new Site Health feature: Builder Template Categories now has an extra section on the Debug Info tab - this is especially helpful for support requests
* Tweak: Refined integration and compatibility with Toolbar Extras v1.4.3 or higher, regarding the Block Editor support
* Tweak: Refined recommended Gutenberg-specific plugins for "Plugin Installer Recommendations" library
* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.4.0) - feature updates
* Tweak: Updated `.pot` file plus all German translations (formal, informal) and language packs


### 🎉 1.5.0 - 2019-03-28
* New: Added integration with theme Page Builder Framework - Custom Sections via WPBF Premium Add-On plugin (Premium, by David Vongries & MapSteps)
* New: Added integration with theme Suki - Custom Blocks via Suki Pro Add-On plugin (Premium, by SukiWP/ David Rozando)
* New: Added integration with theme Customify - Customify Hooks via Customify Pro Add-On plugin (Premium, by WPCustomify/ PressMaximum)
* New: Added integration with plugin CartFlows (free, by CartFlows Inc.)
* New: Added additional integration with plugin Oxygen Builder - Oxygen User Elements Library (*if enabled via Library settings in Oxygen v2.3 alpha 1 or higher*)
* *New: Successfully tested with WordPress 5.1.1*
* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.3.0) - feature updates
* Tweak: Minor code improvements
* Tweak: Updated `.pot` file plus all German translations (formal, informal) and language packs
* Tweak: Enhanced and improved Readme.txt file here


### ⚡ 1.4.3 - 2019-01-21
* New: Additional checks for Block Editor (Gutenberg) integration if one of the popular disabling plugins has disabled it completely (in that case the integration won't be loaded at all!)
* New: Overhauled Elementor integration to be also fully compatible with Elementor 2.4.0 or higher (while still being compatible with older Elementor versions)
* New: Make predefined category terms also available for Elementor built-in "Categories" taxonomy (only for Elementor v2.4.0+)
* New: Added new template content types "Flow/ Flows" and "Snippet/ Snippets"
* New: [Join my newsletter for DECKERWEB WordPress Plugins](https://eepurl.com/gbAUUn) - insider info, plus tutorials and more useful stuff
* Tweak: Updated `.pot` file plus all German translations (formal, informal) and language packs
* Tweak: Enhanced and improved Readme.txt file here - also added new FAQ entry


### ⚡ 1.4.2 - 2018-12-14
* Tweak: Moved admin CSS into proper stylesheet, and enqueue it - this fixes issues users have reported


### ⚡ 1.4.1 - 2018-12-13
* New: Successfully tested with WordPress 5.0.x major release version
* New: Added new template content type "Section/ Sections"
* Tweak: Make sure our help tab is restricted to our own taxonomy only
* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.2.1) - CSS fixes
* Tweak: Updated `.pot` file plus all German translations (formal, informal) and language packs
* Tweak: Enhanced and improved Readme.txt file here


### 🎉 1.4.0 - 2018-11-21
* New: Integration with plugin Epic News Elements (Premium, by Jegtheme) - *an Add-On for Elementor, Block Editor (Gutenberg) and WPBakery Page Builder (old Visual Composer)*
* New: Integration with plugin Master Popups (Premium, by CodexHelp)
* New: Integration with plugin Block Lab (free, by Block Lab) -- *for WordPress Block Editor, also known as "Gutenberg"*
* New: Integration with plugin Gutenberg Templates (Block Templates) (free, by Konstantinos Galanakis) -- *for WordPress Block Editor, also known as "Gutenberg"*
* New: Integration with plugin Visual Composer Website Builder (free/Premium, by The Visual Composer Team) -- Note: this is the new plugin version from 2018, not the old one (now renamed), "WPBakery Page Builder"
* New: Integration with Page Builder plugin Avada Fusion Builder in *Avada Theme* (Premium, by ThemeFusion)
* New: Integration with plugin Smart Footer System (Premium, by Meta Plugin) - compatible with Elementor, Gutenberg, Genesis, Beaver Builder etc.
* New: Integration with plugin Easy Content Templates (free, by Japa Alekhin Llemos)
* New: Integration with plugin Simple Content Templates (free, by Clifton Griffin)
* New: Integration with plugin Custom Page Templates (Premium, by Pavlo Reva)
* New: Added integration with "Elementor Finder" - interactive search since Elementor v2.3.0+
* Tweak: For some integrations (manually) added taxonomy column to the post type list table (overview table) where the automatic adding didn't work (because of customized post types...)
* Tweak: Set proper 'parent file' / 'subemenu file' relations for all integrations - therefore our taxonomy is now highlighted correctly as submenu in the Admin
* Tweak: Updated `.pot` file plus all German translations (formal, informal) and language packs
* Tweak: Enhanced and improved Readme.txt file here


### 🎉 1.3.0 - 2018-10-30
* New: Integration with plugin Advanced Custom Fields (ACF) (free & Pro, by Elliot Condon)
* New: Integration with plugin Custom Field Suite (free, by Matt Gibbs)
* New: Integration with Add-On plugin CMB2 Admin Extension (free, by twoelevenjay) --> Note: This is the UI plugin for the [CMB2 library](https://wordpress.org/plugins/cmb2/) plugin!
* New: Integration with Add-On plugins Meta Box Builder and Meta Box All-In-One (AIO) (both Premium, by Meta Box) --> Note: This is the UI plugin for the [Meta Box](https://wordpress.org/plugins/meta-box/) (fields) plugin!
* New: Integration with plugin Custom Template for LifterLMS (free, by Brainstorm Force)
* New: Integration with plugin Custom Template for LearnDash (free, by Brainstorm Force)
* New: Integration with plugin Opal Widgets for Elementor (free, by WpOpal) - for Header and Footer templates
* New: Integration with plugin Reusable Content Blocks (free, by Safeer)
* New: Integration with plugin JetSmartFilters (Premium, by Zemez Jet/ CrocoBlock)
* New: Added new template content type "Filter/ Filters"
* New: Added 2 new screenshots to show Reusable Block support in Block Editor (Gutenberg)
* New: Successfully tested with WordPress 5.0 Beta 1
* New: [Video of plugin walkthrough and live demo](https://www.youtube.com/watch?v=9FhIJ2QxOoQ)
* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.2.0) - which brings enhanced CSS styles, including for the "Dark Mode" plugin
* Tweak: Updated `.pot` file plus all German translations (formal, informal) and language packs
* Tweak: Enhanced and improved Readme.txt file here - also added some new FAQ entries


### 🎉 1.2.0 - 2018-10-12
* *The Gutenberg Block Editor Support Release ;-)*
* New: Integration with "Gutenberg plugin" / (upcoming) WordPress Version 5.0+: Block categories for new default `wp_block` post type, plus admin enhancements - this lets you manage the "reusable blocks" feature better
* New: Integration with plugin Lazy Blocks (free, by nK) -- *for WordPress Block Editor, also known as "Gutenberg"*
* New: Integration with plugin Advanced Custom Blocks (free, by Rheinard Korf, Luke Carbis, Rob Stinson) -- *for WordPress Block Editor, also known as "Gutenberg"*
* New: Integration with plugin Blocks Layouts (free, by Jordy Meow) -- *for WordPress Block Editor, also known as "Gutenberg"*
* New: Integration with plugin Square Happiness: Placeholder Block (free, by Square Happiness) -- *for WordPress Block Editor, also known as "Gutenberg"*
* New: Integration with plugin StylePress for Elementor (free, by David Baker (dtbaker))
* New: Integration with plugin Content Blocks (Custom Post Widget) (free, by Johan van der Wijk)
* New: Integration with plugin Reusable Content & Text Blocks (free, by Loomisoft)
* New: Integration with plugin Dev Content Blocks (free, by Allon Sacks)
* New: Integration with plugin Text Blocks (free, by Hal Gatewood)
* New: Integration with plugin Widget Content Blocks (free, by Danny van Kooten)
* New: Added new template content types "Field/ Fields", "Box/ Boxes", "Bar/ Bars" and "Hook/ Hooks"
* New: If Fields, Box, Bar or Hook template related integrations are active before plugin installation/activation add predefined terms for "Fields", "Boxes", "Bars" and "Hooks" appropriately
* New: [Facebook Info Page for my WordPress plugins](https://www.facebook.com/deckerweb.wordpress.plugins/), this one included :)
* Tweak: Code, plus code documentation improvements and tweaks
* Tweak: Improved special "translators" comments in code
* Tweak: Updated `.pot` file plus all German translations (formal, informal) and language packs
* Tweak: Enhanced and improved Readme.txt file here


### 🎉 1.1.0 - 2018-09-30
* New: Category labels now fit to the content type (post type) of the integration - popup integrations are now labelled as "Popup Categories", and the same for other types like Blocks, Layouts, Elements etc.
* New: Integration with Page Builder plugin Themify Builder (Premium, by Themify) - note: this applies only to the premium version of this plugin
* New: Integration with plugin JetPopup (free, by Zemez Jet/ CrocoBlock)
* New: Integration with plugin Cherry PopUps (free, by Zemez)
* New: Integration with plugin Templementor (free, by Lcweb)
* New: Integration with plugin Kadence WooCommerce Elementor (free, by Kadence Themes) - for single product templates
* New: Integration with plugin Kadence WooCommerce Elementor Pro (Premium, by Kadence Themes) - for product archive templates and checkout templates
* New: Integration with plugin Themify Popup (free, by Themify)
* New: Integration with Add-On plugins Meta Box Post Types and Meta Box Taxonomy (both free, by Meta Box)
* New: If WooCommerce template related integrations are active before plugin installation/activation add predefined "Products" term
* New: If Popup/Modal template related integrations are active before plugin installation/activation add predefined "Popups" term
* New: In post type list tables for bulk actions the "Edit" label was tweaked to "Edit, add Category etc." to make it more clear for users that template categories (of this plugin) can be added as well in bulk mode
* New: Added help tab with additional info - appearing on the plugin's taxonomy page as well as all edit screens from post types of any active integration
* New: Added a new screenshot to show Bulk Actions - to add template category to more than one template in one action
* New: Created special [Facebook Group for user community support](https://www.facebook.com/groups/deckerweb.wordpress.plugins/) for all plugins from me (David Decker - DECKERWEB), this one here included! ;-) - [please join at facebook!](https://www.facebook.com/groups/deckerweb.wordpress.plugins/)
* Tweak: Partly refactored the WPBakery Page Builder integration - now by default the Grid Builder Templates are integrated, and optionally, if the Templatera templates are active (premium Add-On), these as well -- that way, all makes more sense
* Tweak: Smaller code and inline documentation tweaks, plus improvements
* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.1.0) - which brings smaller additions and enhancements, like CSS styles to the upload areas and plugin cards, plus plugin version number on plugin cards
* Tweak: Updated `.pot` file plus all German translations (formal, informal) and language packs
* Tweak: Enhanced and improved Readme.txt file here - also added new FAQ entry


### ⚡ 1.0.1 - 2018-08-30
* New: Integration with Brizy Templates for Brizy Page Builder - template feature was released in their free version v1.0.25
* New: Added plugin update message also to Plugins page (overview table)
* New: French translations by the community
* Tweak: Added plugins recommendations library by deckerweb to improve the plugin installer tips (old filter function got removed)
* Tweak: Updated `.pot` file plus all German translations (formal, informal) and language packs
* Tweak: Enhanced, improved and corrected Readme.txt file here - also tweaked FAQ entry


### 🎉 1.0.0 - 2018-08-20 
* *Official plugin launch on WordPress.org. Everything's new!*
* New: Including integration for 15 Plugins: Elementor, AnyWhere Elementor, Header Footer for Elementor, Popup Maker, PopBox for Elementor, Thrive Lightboxes, Oxygen Builder (2.0+), Pods, JetEngine for Elementor, JetWooBuilder for Elementor, DHWC Elementor (WooCommerce Templates), WP Show Posts, BoldGrid Post and Page Builder, WPBakery Page Builder (Visual Composer), Global Blocks for Cornerstone
* New: Including integration for 5 Themes: OceanWP, GeneratePress, Astra, Kava Pro (CrocoBlock), Genesis (Blox)
* New: Includes a `composer.json` file in the plugin's root folder - this is great for developers using Composer


### ⚡ 0.9.1 - 2018-08-17 
* New: Added [Code Snippets](https://github.com/deckerweb/builder-template-categories/wiki/Code-Snippets) as GitHub Gists
* New: Added [short and easy "documentation" as Wiki](https://github.com/deckerweb/builder-template-categories/wiki) in official GitHub repository for the plugin
* New: Added integration "WPBakery Page Builder" (the old Visual Composer), via its "Templatera" Add-On plugin


### ⚡ 0.9.0 - 2018-08-16 
* New: Beta release of the plugin on [its public GitHub repository](https://github.com/deckerweb/builder-template-categories)

---

## Plugin Scope / Disclaimer

**Original Idea Behind / Philosophy:** Just a little lightweight plugin for all the Non-Coder site builders out there using plugins or themes with template libraries and wanting to categorize these templates. Just making their daily work and life just a little easier.

This plugin comes as is.

_Disclaimer 1:_ So far I will support the plugin for breaking errors to keep it working. Otherwise support will be very limited. Also, it will NEVER be released to WordPress.org Plugin Repository for a lot of reasons (ah, thanks, Matt!).

_Disclaimer 2:_ All of the above might change. I do all this stuff only in my spare time.

_Most of all:_ Have fun building great sites!!! ;-)

---

Copyright © 2018-2025 David Decker – DECKERWEB.de