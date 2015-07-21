<?php
/**
 * DFP Ads Test Class
 * @see DFP_Ads\DFP_Ads
 *
 * @since 0.1.0
 * @author Chris W. Gerber <chriswgerber@gmail.com>
 *
 * @coversDefaultClass DFP_Ads\DFP_Ads
 */

class Test_DFP_Ads extends WP_UnitTestCase {

	/**
	 * @var DFP_Ads\DFP_Ads
	 */
	protected $_dfp_ads;

	/**
	 * Setup
	 */
	public function setUp() {
		parent::setUp();
		$this->_dfp_ads = new DFP_Ads\DFP_Ads();
	}

	/**
	 * Checks for a script name to parse.
	 *
	 * @test
	 */
	public function script_name_is_dfp_ads() {
		$this->assertEquals( 'dfp_ads', $this->_dfp_ads->script_name );
	}

	/**
	 * Check if the Account ID is set correctly.
	 *
	 * @test
	 * @covers ::set_account_id
	 */
	public function set_account_id() {
		$account_id = $this->_dfp_ads->set_account_id( '35190362' );

		$this->assertEquals( '/35190362/', $account_id );
	}

	/**
	 * Checks the value for Asynchronous loading
	 *
	 * Checks three cases: True, null, 'on'.
	 *
	 * @since 0.3.1
	 *
	 * @test
	 * @covers ::set_asynchronous_loading
	 */
	public function set_asynch_loading() {
		$load = $this->_dfp_ads->set_asynchronous_loading( true );
		$this->assertFalse( $load );
		$load = $this->_dfp_ads->set_asynchronous_loading( null );
		$this->assertTrue( $load );
		$load = $this->_dfp_ads->set_asynchronous_loading( 'on' );
		$this->assertFalse( $load );
	}

	/**
	 * Determines if values are being sent to javascript
	 * or not by the filter, then checks to make sure it has
	 * the necessary information.
	 *
	 * @since 0.3.1
	 *
	 * @test
	 * @covers ::send_ads_to_js
	 * @covers ::set_targeting
	 * @covers ::get_page_targeting
	 * @covers ::get_category_targeting
	 * @covers ::get_tag_targeting
	 */
	public function ads_sent_to_js() {
		$this->_dfp_ads->set_account_id( '35190362' );
		$this->_dfp_ads->set_asynchronous_loading( null );

		$js_object = $this->_dfp_ads->send_ads_to_js( $this->_dfp_ads );
		$this->assertInstanceOf( 'DFP_Ads\DFP_Ads', $js_object );

		$results = json_encode( $js_object );
		$object = array(
			'account_id' => '/35190362/',
			'asynch' => true,
			'dir_uri' => null,
			'google_ad_script_name' => 'google_ad_js',
			'page_targeting' => (object) array (
				'Page'     => array( 'Home' ),
				'Category' => '',
				'Tag'      => '',
			),
			'positions' => array(),
			'script_name' => null
		);
		$this->assertJsonStringEqualsJsonString( json_encode( $object ), $results );
	}

}
