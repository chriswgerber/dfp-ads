<?php
/**
 * DFP Ads Test Class
 * @see DFP_Ads
 *
 * @since 0.1.0
 * @author Chris W. Gerber <chriswgerber@gmail.com>
 */

class Test_DFP_Ads extends WP_UnitTestCase {

	/**
	 * @see DFP_Ads::script_name
	 */
	public function test_script_name_is_dfp_ads() {
        $this->_dfp_ads = new DFP_Ads();
		$this->assertEquals( 'dfp_ads', $this->_dfp_ads->script_name );
	}

	/**
	 * @see DFP_Ads::set_account_id
	 */
	public function test_set_account_id() {
        $this->_dfp_ads = new DFP_Ads();
		$account_id = $this->_dfp_ads->set_account_id( '35190362' );

		$this->assertEquals( '/35190362/', $account_id );
	}
}
