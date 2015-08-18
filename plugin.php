<?php
/**
 * DFP Ad Manager Bootstrap File
 *
 * @wordpress-plugin
 * Plugin Name:       DFP - DoubleClick Ad Manager
 * Plugin URI:        http://www.chriswgerber.com/dfp-ads/
 * Description:       Manages ad code for DoubleClick for Publishers
 * Author:            Chris W. Gerber
 * Author URI:        http://www.chriswgerber.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       dfp-ads
 * Github Plugin URI: https://github.com/ThatGerber/dfp-ads
 * GitHub Branch:     stable
 * Version:           0.3.2
 *
 * The Plugin File
 *
 * @link              http://www.chriswgerber.com/dfp-ads
 * @since             0.0.1
 * @subpackage        DFP-Ads
 */
/* Autoload */
require_once 'vendor/autoload.php';
/* Includes */
include 'includes/Functions.php';
include 'includes/Globals_Container.php';
include 'includes/DFP_Ads.php';
include 'includes/Post_Type.php';
include 'includes/Position.php';
include 'includes/admin/Form.php';
include 'includes/admin/Input.php';
include 'includes/admin/Settings_Form.php';
include 'includes/admin/Import_Form.php';
include 'includes/admin/Admin.php';
include 'widget/widget.ad_position.php';

/* Namespaces */
use DFP_Ads\DFP_Ads as DFP_Ads;
use DFP_Ads\Post_Type as DFP_Ads_Post_Type;
use DFP_Ads\Admin\Input as DFP_Ads_Input;
use DFP_Ads\Admin\Settings_Form as DFP_Ads_Settings_Form;
use DFP_Ads\Admin\Import_Form as DFP_Ads_Import_Form;
use DFP_Ads\Admin as DFP_Ads_Admin;

if ( ! defined( 'DFP_CONCAT_SCRIPTS' ) ) {
	define( 'DFP_CONCAT_SCRIPTS', true );
}
/*
 * Initialization for Post Type
 */
$dfp_post_type = new DFP_Ads_Post_Type();
add_action( 'init', array( $dfp_post_type, 'create_post_type' ), 0, 0 );
add_action( 'add_meta_boxes', array( $dfp_post_type, 'add_meta_boxes' ), 10, 2 );
add_action( "save_post_{$dfp_post_type->name}", array( $dfp_post_type, 'save_meta_box' ), 10, 2 );
add_action( 'dfp_ads_fields', array( $dfp_post_type, 'add_inputs' ) );
/* Custom Columns */
add_filter( "manage_{$dfp_post_type->name}_posts_columns",
	array( $dfp_post_type, 'add_shortcode_column' ) );
add_action( "manage_{$dfp_post_type->name}_posts_custom_column",
	array( $dfp_post_type, 'shortcode_column_value' ), 10, 1 );
// Ads Shortcode Reference
add_action( 'dfp_ads_metabox_top', array( $dfp_post_type, 'ad_position_shortcode' ) );
// Creates the settings table
add_action( 'dfp_ads_metabox_middle', array( $dfp_post_type, 'settings_table' ), 9 );
/* Begin creating the new ads objects */
$dfp_ads          = new DFP_Ads();
$dfp_ads->dir_uri = plugins_url( null, __FILE__ );
$dfp_ads->set_account_id( dfp_get_settings_value( 'dfp_property_code' ) );
$dfp_ads->set_asynchronous_loading( dfp_get_settings_value( 'dfp_synchronous_tags' ) );
/*
 * Enqueues the styles and scripts into WordPress. When this action runs
 * it also will grab all of the positions and other filtered in information
 */
add_action( 'wp_enqueue_scripts', array( $dfp_ads, 'scripts_and_styles' ), 100 );
/* Sets Menu Position. Default 20 */
add_filter( 'dfp_ads_menu_position', ( function ( $pos ) {
	return 79;
} ), 10 );
/*
 * Adds input fields to the DFP_Ads post type.
 *
 * Any number can be added at any time, they must have the array keys listed
 * below.
 *
 * @see DFP_Ads_Input
 *
 * Mandatory values
 * array(
 *     'id'    => '',
 *     'type'  => '',
 *     'name'  => '',
 *     'label' => '',
 *     'value' => ''
 * )
 *
 */
add_filter( DFP_Ads_Post_Type::FIELDS_FILTER, ( function ( $fields ) {
	// Ad Code
	$fields[] = new DFP_Ads_Input(
		array(
			'id'    => 'dfp_ad_code', // Input ID
			'type'  => 'text',        // Type of Input
			'name'  => 'dfp_ad_code', // Name of Input
			'label' => 'Code',        // Label / Setting Name
			'value' => '',            // Value for the field
		)
	);
	// Ad Position Name
	$fields[] = new DFP_Ads_Input(
		array(
			'id'    => 'dfp_position_name',
			'type'  => 'text',
			'name'  => 'dfp_position_name',
			'label' => 'Name',
			'value' => '',
		)
	);
	// Sizes
	$fields[] = new DFP_Ads_Input(
		array(
			'id'    => 'dfp_position_sizes',
			'type'  => 'textarea',
			'name'  => 'dfp_position_sizes',
			'label' => 'Ad Sizes',
			'value' => '',
		)
	);
	// Out of Page
	$fields[] = new DFP_Ads_Input(
		array(
			'id'    => 'dfp_out_of_page',
			'type'  => 'checkbox',
			'name'  => 'dfp_out_of_page',
			'label' => 'Out of Page Slot',
			'value' => '',
		)
	);

	return $fields;
} ), 10 );
/**
 * This filter is run before the ad positions are sent to javascript. It is
 * the time when additional data can be dumped in and sent to front-end scripts.
 *
 * Use it to filter in additional custom positions, targetting data, etc.
 */
add_filter( 'pre_dfp_ads_to_js', array( $dfp_ads, 'send_ads_to_js' ), 1 );
/* Settings/Import Page */
if ( is_admin() ) {
	/* Section headings */
	add_filter( 'dfp_ads_settings_sections', ( function ( $sections ) {
		$sections['ad_positions'] = array(
			'id'    => 'general_settings',
			'title' => 'General Settings'
		);

		return $sections;
	} ) );
	/* Section Fields */
	add_filter( 'dfp_ads_settings_fields', ( function ( $fields ) {
		$fields['dfp_property_code']    = array(
			'id'          => 'dfp_property_code',
			'field'       => 'text',
			'callback'    => 'text',
			'title'       => 'DFP Property Code',
			'section'     => 'general_settings',
			'description' => 'Enter your DoubleClick for Publishers Property Code.'
		);
		$fields['dfp_synchronous_tags'] = array(
			'id'          => 'dfp_synchronous_tags',
			'field'       => 'checkbox',
			'callback'    => 'checkbox',
			'title'       => 'Use Synchronous Ad Tags',
			'section'     => 'general_settings',
			'description' => '<em>DFP Ad Manager uses asynchronous tags by default. Choose this option if
								your site is unable to support DoubleClick\'s asynchronous tags</em>'
		);

		return $fields;
	} ) );
	// Settings Page
	$ad_form               = new DFP_Ads_Settings_Form;
	$ad_admin              = new DFP_Ads_Admin( $ad_form );
	$ad_admin->menu_title  = 'Settings';
	$ad_admin->plugin_slug = 'settings';
	$ad_admin->options_str = 'DFP_Ads_Settings';
	$ad_admin->options_grp = 'DFP_Ads_Settings_group';
	$ad_admin->page_title  = 'Ad Manager Settings';
	$ad_admin->user_cap    = 'manage_options';
	$ad_admin->post_type   = $dfp_post_type->name;
	add_action( 'admin_menu', array( $ad_admin, 'register_menu_page' ) );
	add_action( 'admin_init', array( $ad_admin, 'menu_page_init' ) );
	/*
	 * Import Page
	 */
	add_filter( 'dfp_ads_import_sections', ( function ( $sections ) {
		$sections['import_data'] = array(
			'id'    => 'import_data',
			'title' => 'Import from CSV'
		);

		return $sections;
	} ) );
	add_filter( 'dfp_ads_import_fields', ( function ( $fields ) {
		$fields['file_import'] = array(
			'id'          => 'import_csv',
			'field'       => 'file',
			'callback'    => 'file',
			'title'       => 'Import CSV from DFP',
			'section'     => 'import_data',
			'description' => 'Upload a CSV File directly from DoubleClick for Publishers'
		);

		return $fields;
	} ) );
	$import_form           = new DFP_Ads_Import_Form;
	$ad_admin              = new DFP_Ads_Admin( $import_form );
	$ad_admin->menu_title  = 'Import';
	$ad_admin->plugin_slug = 'import';
	$ad_admin->options_str = 'DFP_Ads_Import';
	$ad_admin->options_grp = 'DFP_Ads_Import_group';
	$ad_admin->page_title  = 'Import Positions';
	$ad_admin->user_cap    = 'manage_options';
	$ad_admin->post_type   = $dfp_post_type->name;
	add_action( 'admin_menu', array( $ad_admin, 'register_menu_page' ) );
	add_action( 'admin_init', array( $ad_admin, 'menu_page_init' ) );
}
/*
 * Widget
 */
add_action( 'widgets_init', ( function ( $fields ) {
	register_widget( "DFP_Ads_Widget" );
} ) );
