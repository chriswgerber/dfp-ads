# DFP Ad Manager

[![Build Status](https://travis-ci.org/ThatGerber/dfp-ads.svg)](https://travis-ci.org/ThatGerber/dfp-ads) [![Code Climate](https://codeclimate.com/github/ThatGerber/dfp-ads/badges/gpa.svg)](https://codeclimate.com/github/ThatGerber/dfp-ads) [![Test Coverage](https://codeclimate.com/github/ThatGerber/dfp-ads/badges/coverage.svg)](https://codeclimate.com/github/ThatGerber/dfp-ads)

Table of Contents

* [Description](#Description)
* [Installation/Set Up](#Installation)
   * [Install Plugin](#Install)
   * [Set Up Ad Network](#NetworkSetup)
* [About](#About)
   * [Purpose](#Purpose)
   * [Goals](#Goals)
* [Roadmap](#Roadmap)
* [Frequently Asked Questions](#FAQ)
* [Changelog](#Changelog)

<a name="Description"></a>  
## Description

Contributors: chriswgerber  
Requires at least: 3.0.0  
Tested up to: 4.2.2  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html  
Tags: dfp, doubleclick, ads, ad trafficking, ad ops  

Simpler management of DFP (*DoubleClick for Publishers*) ad positions

<a name="Installation"></a>
## Installation

<a name="#Install"></a>
### Install plugin

1. Download Zip File
2. Navigate to your website's admin page: `example.com/wp-admin/`
3. Go to Plugins, "Add New"
4. At the top of the page, choose "Upload Plugin"
5. Upload zip file and install now
6. Activate plugin

<a name="NetworkSetup"></a>
### Set Up Ad Network

1. Visit [https://www.google.com/dfp/](https://www.google.com/dfp/) and get your Account ID
    1. To find your Account ID, go to Settings. On the left sidebar, choose "Network Settings" and "All Network Settings". 
    2. Copy your "Network Code". It should be an 8-digit integer for identifying your ad network.
2. Visit the Ad Positions "Settings" in the WordPress Admin page.
3. Add the DFP Network Code for Identifying the ad network for ad positions.

<a name="About"></a>
### About

<a name="Purpose"></a>
#### Purpose

Tired of dealing with creating and fixing the ad positions after each change, I decided to create a plugin that would make it easier to manage individual ad positions and add targeting for each of those positions.

<a name="Goals"></a>
#### Goals

The goal is to create a core set of functions that power a set of ad positions defined in DoubleClick. These ad positions will take custom targeting and display information passed through page level and individual tags.

Managing the tags will be made simple through an import function that works directly with the DFP export tools.

<a name="Roadmap"></a>
## Roadmap

Below are a list of items that need to be completed before the plugin is ready for release. 

* Filter taxonomy names and values into page-level targeting for positions.
* More precise validation of input values in custom metaboxes for ad positions.
* Improve documentation on plugin.

### Other priorities

* Full Test Suite for current code and all new features.

<a name="FAQ"></a>
## Frequently Asked Questions

Submit your questions at [chriswgerber.com/contact/](http://www.chriswgerber.com/contact/)

<a name="Changelog"></a>
## Changelog

### 0.2.1

* Fixed issue where settings were not being called.

### 0.2.0

* Added functionality for importing DFP Ads
* Added Travis CI Integration.
* Added Composer
* Begin Unit Testing
* Added Code Coverage Reporting
* Updated JS to make extensions easier
* Added Asynchronous ad loading
* Made plugin compatible with PHP 5.3

### 0.1.0
* Initial pre-release

[cwg]: http://www.chriswgerber.com/
[dfp-ads]: http://www.chriswgerber.com/dfp-ads