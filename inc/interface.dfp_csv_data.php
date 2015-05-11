<?php
/** 
 * Interface for working with CSV Data
 *
 * List of requirements for working with CSV data.
 *
 * @link  http://www.chriswgerber.com/dfp-ads/
 * @since 0.2.0
 *
 * @package    WordPress
 * @subpackage DFP-Ads
 */

Interface DFP_CSV_Data_Interface {

	/**
	 * Opens a file to read contents
	 *
	 * @return mixed
	 */
	public function open_file();

	/**
	 * Closes the file and frees up memory
	 *
	 * @return mixed
	 */
	public function close_file();

	/**
	 * Gets data from the file
	 *
	 * @return mixed
	 */
	public function get_data();

	/**
	 * Returns data for the next row
	 *
	 * @return mixed
	 */
	public function get_next_row();

	/**
	 * Returns data for previous row
	 *
	 * @return mixed
	 */
	public function get_previous_row();

}