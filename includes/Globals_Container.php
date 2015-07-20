<?php
/**
 * Series of methods for accessing superglobals
 *
 * Simplifies the process of accessing superglobals through methods
 * that automatically grab post data or add filters. In order to improve
 * code quality, all requests for $_POST, $_SERVER, etc., variables
 * should be done through methods found here.
 *
 * @link       http://www.chriswgerber.com/dfp-ads
 * @since      0.3.1
 *
 * @package    WordPress
 * @subpackage DFP-Ads
 */
namespace DFP_Ads;

Class Globals_Container {

	/**
	 * Returns a $_POST variable without any filtering.
	 *
	 * If you just want to get a variable back and filter it later,
	 * this is the function. Does not perform any action on the returned
	 * data, just returns it.
	 *
	 * @since  0.3.0
	 * @access public
	 *
	 * @param string $var
	 *
	 * @return mixed
	 */
	public static function get_post_var( $var ) {

		return filter_input( INPUT_POST, $var );
	}

	/**
	 * @param string $var
	 *
	 * @return bool
	 */
	public static function post_var_exists( $var ) {

		return ( self::get_post_var( $var ) != true ? false : true );
	}

	/**
	 * @param      $var
	 * @param      $filter
	 * @param null $flags
	 *
	 * @return mixed
	 */
	static function filter_post_var( $var, $filter, $flags = null ) {

		return filter_input( INPUT_POST, $var, $filter, $flags );
	}
}