=== DFP Ad Manager ===

Stable tag: 0.3.2
Contributors: chriswgerber
Requires at least: 3.0.0
Tested up to: 4.2.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: dfp, doubleclick, ads, ad trafficking, ad ops

Simpler management of DFP (DoubleClick for Publishers) ad positions

== Description ==

**For simple management of DoubleClick for Publishers ad positions.**

This plugin is designed to simplify the process of working with DoubleClick for Publishers. Rather than inundate the user with too many options and settings, instead everything is managed within DoubleClick, utilizing WordPress to display the positions.

Page, category, and tag targeting is built-in, with the option to extend on the DoubleClick Javascript library and add even more targeting and send data from the WordPress backend to DoubleClick.

Follow development of the plugin on [Github.com/ThatGerber/dfp-ads](http://github.com/ThatGerber/dfp-ads)

== Installation ==

= Install plugin =

1. Download Zip File
2. Navigate to your website's admin page: `example.com/wp-admin/`
3. Go to Plugins, "Add New"
4. At the top of the page, choose "Upload Plugin"
5. Upload zip file and install now
6. Activate plugin

= Set Up Ad Network =

1. Visit [https://www.google.com/dfp/](https://www.google.com/dfp/) and get your Account ID
    1. To find your Account ID, go to Settings. On the left sidebar, choose "Network Settings" and "All Network Settings".
    2. Copy your "Network Code". It should be an 8-digit integer for identifying your ad network.
2. Visit the Ad Positions "Settings" in the WordPress Admin page.
3. Add the DFP Network Code for Identifying the ad network for ad positions.

== Screenshots ==

1. Full Ad Positions Page
2. Individual Ad Positions Page
3. Position Settings Page
4. Position Import Page

Visit [chriswgerber.com/dfp-ads/](http://www.chriswgerber.com/dfp-ads/) for more information.

== Frequently Asked Questions ==

Submit your questions at [chriswgerber.com/contact/](http://www.chriswgerber.com/contact/).

== Upgrade Notice ==

Update fixes issue with widget rendering.

== Changelog ==

= 0.3.2 =

* Adds `DFP_CONCAT_SCRIPTS` constant. Set as `false` to force the plugin to use un-minified scripts
* Fixes array issue in javascript that would cause ads to not appear.
* Improves build scripts
* Adds Composer.lock file to force support for PHP 5.3 on all `composer install`
* Various code quality improvements.

= 0.3.1 =

* Bugfix - Widget not displays ad position correctly.
* Enhancement - Various code quality improvements.

= 0.3.0 =

* New - Adds option to turn off asynchronous loading.
* Enhancement - Adds class `dfp_ad_pos` to ad tags.
* Bugfix - Fixes shortcode issue where content would always appear at the top of the content area.

= 0.2.5 =

* Bugfix- Ad CPT was overriding page meta. Fix implemented resets post data after use of WP_Query.

= 0.2.4 =

* Fixes build

= 0.2.3 =

* Bug fix

= 0.2.2 =

* Fixed issue where settings were not being called.

= 0.2.1 =

* Bug Fix: Added extra check to make sure plugin didn't attempt to add other CPTs as ad positions.
* Enhancement: Added linting and uglifying to JS. Now serving minified JS.
* Enhancement: Updated directory structure
* Enhancement: Updated Readme to include screenshots and more information.

= 0.2.0 =

* Added functionality for importing DFP Ads
* Added Travis CI Integration.
* Added Composer
* Begin Unit Testing
* Added Code Coverage Reporting
* Updated JS to make extensions easier
* Added Asynchronous ad loading
* Made plugin compatible with PHP 5.3

= 0.1.0 =

* Initial Pre-Release