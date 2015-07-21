<?php

/**
 * DFP Ad Position Test Class
 * @see    DFP_Ad_Position
 *
 * @since  0.1.0
 * @author Chris W. Gerber <chriswgerber@gmail.com>
 *
 * @coversDefaultClass \DFP_Ads\Position
 */
class Test_DFP_Ad_Position extends WP_UnitTestCase {

	/**
	 * Ad position object for testing.
	 *
	 * @var Position
	 */
	protected $_dfp_ad_position;

	/**
	 * Post ID of the created post.
	 *
	 * @var int
	 */
	protected $post_id;

	/* Post Defaults */
	protected $dfp_position_name = 'Ad Position 1';
	protected $ad_title = 'Ad Position 1';
	protected $dfp_ad_code = 'ad_position_1';
	protected $dfp_ad_sizes = '300x600';
	protected $out_of_page = true;

	/**
	 * Sets up the ad position that we'll be testing.
	 *
	 * @since 0.3.1
	 */
	public function setUp() {
		parent::setUp();
		$user_id       = $this->factory->user->create();
		$post          = array(
			'post_content' => '',
			'post_title'   => $this->ad_title,
			'post_status'  => 'publish',
			'post_type'    => 'dfp_ads',
			'post_author'  => $user_id,
		);
		$this->post_id = $this->factory->post->create( $post );
		update_post_meta( $this->post_id, 'dfp_ad_code', $this->dfp_ad_code );
		update_post_meta( $this->post_id, 'dfp_position_name', $this->dfp_position_name );
		update_post_meta( $this->post_id, 'dfp_position_sizes', $this->dfp_ad_sizes );
		update_post_meta( $this->post_id, 'dfp_out_of_page', $this->out_of_page );
		$this->_dfp_ad_position = new \DFP_Ads\Position( $this->post_id );
	}

	/**
	 * Determine that values are able to be added to the post ID
	 *
	 * @since 0.3.1
	 *
	 * @test
	 * @covers ::<public>
	 */
	public function update_post_meta() {
		$ad_post_id = $this->_dfp_ad_position->post_id;
		$this->assertTrue( update_post_meta( $ad_post_id, 'dfp_ad_code', 'NewCode_2015' ) );
		$this->assertTrue( update_post_meta( $ad_post_id, 'dfp_position_name', 'NewCode_2015_Position' ) );
		$this->assertTrue( update_post_meta( $ad_post_id, 'dfp_position_sizes', '200x100' ) );
		$this->assertTrue( update_post_meta( $ad_post_id, 'dfp_out_of_page', false ) );
	}

	/**
	 * Test of the Post ID is being set as integer.
	 *
	 * @test
	 * @covers ::<public>
	 */
	public function post_id_is_int() {
		$is_int = is_int( $this->_dfp_ad_position->post_id );
		$this->assertTrue( $is_int );
	}

	/**
	 * Stored Post ID is the same as provided ID.
	 *
	 * @test
	 * @covers ::<public>
	 */
	public function post_id_is_equal(  ) {
		$are_equal = ( $this->post_id = $this->_dfp_ad_position->post_id ? true : false );
		$this->assertTrue( $are_equal );
	}

	/**
	 * Check that the title is being set as a string.
	 *
	 * @test
	 * @covers ::<public>
	 */
	public function ad_position_title_is_string() {
		$is_string = is_string( $this->_dfp_ad_position->title );
		$this->assertTrue( $is_string );
		$is_string = is_string( $this->_dfp_ad_position->ad_name );
		$this->assertTrue( $is_string );
		$is_string = is_string( $this->_dfp_ad_position->position_tag );
		$this->assertTrue( $is_string );
	}

	/**
	 * Check that the string image size value is being converted into an array
	 *
	 * @test
	 * @covers ::<public>
	 */
	public function ad_size_string_to_array() {
		$this->assertContains( 300, $this->_dfp_ad_position->sizes );
		$this->assertContains( 600, $this->_dfp_ad_position->sizes );
	}

	/**
	 * Page is being properly set as out-of-page
	 *
	 * @test
	 * @covers ::<public>
	 */
	public function out_of_page() {
		$this->assertTrue( $this->_dfp_ad_position->out_of_page );
	}

	/**
	 * Tests for the ad position HTML.
	 *
	 * @test
	 * @covers ::get_position
	 * @covers ::display_position
	 * @covers DFP_Ads\DFP_Ads::shortcode
	 */
	public function valid_ad_position() {
		$is_string = is_string( $this->_dfp_ad_position->get_position() );
		$this->assertTrue( $is_string, 'Ad Position is not a string' );
		$this->assertXmlStringEqualsXmlString( $this->ad_position(), $this->_dfp_ad_position->get_position() );
	}

	/**
	 * Creates an ad position for DFP. This is the format it must be in.
	 *
	 * @return string
	 */
	private function ad_position() {
		$position_tag   = $this->_dfp_ad_position->position_tag;
		$ad_name        = $this->_dfp_ad_position->ad_name;
		$position_class = 'dfp_ad_pos';
		$html           = <<<HERENOW
<!-- $ad_name -->
<div id="$position_tag" class="$position_tag $ad_name $position_class">
			<script type='text/javascript'>
				googletag.cmd.push(function () {
					googletag.display('$position_tag');
				});
			</script>
</div>
HERENOW;

		return $html;
	}

}
