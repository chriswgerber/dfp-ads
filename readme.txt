=== DFP Ad Manager ===

Stable tag: trunk
Contributors: chriswgerber
Requires at least: 3.0.0
Tested up to: 4.2.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: dfp, doubleclick, ads, ad trafficking, ad ops

Simpler management of DFP (DoubleClick for Publishers) ad positions

== Description ==

**For simple management of DoubleClick for Publishers ad positions.**

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

Visit [chriswgerber.com/dfp-ads/](http://www.chriswgerber.com/dfp-ads/) for screenshots and more information.

== Frequently Asked Questions ==

Submit your questions at [chriswgerber.com/contact/](http://www.chriswgerber.com/contact/)

== Upgrade Notice ==

If you're coming from the pre-release, many features have been changed and improved. You will be required to re-setup your network.

== Changelog ==

= 0.2.0

* Added functionality for importing DFP Ads
* Added Travis CI Integration.
* Added Composer
* Begin Unit Testing
* Added Code Coverage Reporting
* Updated JS to make extensions easier
* Added Asynchronous ad loading
* Made plugin compatible with PHP 5.3

= 0.1.0
* Initial Pre-Release