<?php
/**
 * DFP Ad Position Test Class
 * @see DFP_Ad_Position
 *
 * @since 0.1.0
 * @author Chris W. Gerber <chriswgerber@gmail.com>
 */

class Test_DFP_Ad_Position extends PHPUnit_Framework_TestCase {

	private $_dfp_ad_position;

	/**
	 * Set up the test
	 */
	protected function setUp() {
		$this->_dfp_ad_position = new DFP_Ad_Position();
	}

	/**
	 * Tear down the test
	 */
	protected function tearDown() {
		$this->_dfp_ads = NULL;
	}

}
