<?php
/** 
 * Implementation of CSV Import Tool
 *
 * Implements Ddeboer's CSV Importer.
 *
 * @link  http://www.chriswgerber.com/dfp-ads/
 * @since 0.2.0
 *
 * @package    WordPress
 * @subpackage DFP-Ads
 */
use Ddeboer\DataImport\Reader\CsvReader;

Class DFP_Ads_CSV_Reader implements DFP_CSV_Data_Interface {

	/**
	 * File to work with
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @var SplFileObject $file
	 */
	public $file;

	/**
	 * File to work with
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @var SplFileObject $file
	 */
	public $reader;

	/**
	 * PHP5 Constructor
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param CsvReader     $reader
	 * @param SplFileObject $file
	 */
	public function __construct( CSVReader $reader, SplFileObject $file ) {
		$this->reader = $reader;
		$this->file   = $file;
	}

	/**
	 * Opens a file to read contents
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @return mixed
	 */
	public function open_file() {

	}

	/**
	 * Closes the file and frees up memory
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @return mixed
	 */
	public function close_file() {

	}

	/**
	 * Gets data from the file
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @return mixed
	 */
	public function get_data() {

	}

	/**
	 * Returns data for the next row
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @return mixed
	 */
	public function get_next_row() {

	}

	/**
	 * Returns data for previous row
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @return mixed
	 */
	public function get_previous_row() {

	}

}