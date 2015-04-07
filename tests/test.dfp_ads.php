<?php
/**
 * DFP Ads Test Class
 * @see DFP_Ads
 */
require ("inc/class.dfp_ads.php");

class Test_DFP_Ads extends PHPUnit_Framework_TestCase {

	private $_dfp_ads;

	protected function setUp() {
		$this->_dfp_ads = new DFP_Ads();
	}

	protected function tearDown() {
		$this->_dfp_ads = NULL;
	}

	/**
	 * @see DFP_Ads::script_name
	 */
	public function test_script_name_is_dfp_ads() {
		$this->assertEquals( 'dfp_ads', $this->_dfp_ads->script_name );
	}

	/**
	 * @see DFP_Ads::set_account_id
	 */
	public function test_set_account_id() {
		$account_id = $this->_dfp_ads->set_account_id( '35190362' );

		$this->assertEquals( '/35190362/', $account_id );
	}
}