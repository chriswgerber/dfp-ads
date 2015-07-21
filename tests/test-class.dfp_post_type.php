<?php

/**
 * Tests for the Post_Type
 *
 * Creates tests for the DFP_Ads Post Type
 *
 * @since      0.3.1
 * @author     Chris W. Gerber <chriswgerber@gmail.com>
 *
 * @coversDefaultClass \DFP_Ads\Post_Type
 *
 * @package    WordPress
 * @subpackage DFP-Ads
 */
class Test_Post_Type extends WP_UnitTestCase {

	/**
	 * @var DFP_Ads\Post_Type
	 */
	protected $_post_type;

	protected $post_type_name = 'dfp_ads';

	protected $_dfp_ad_position;
	protected $post_id;
	protected $dfp_position_name = 'Ad Position 1';
	protected $ad_title          = 'Ad Position 1';
	protected $dfp_ad_code       = 'ad_position_1';
	protected $dfp_ad_sizes      = '300x600';
	protected $out_of_page       = true;

	/**
	 * The Set Up
	 */
	public function setUp() {
		parent::setUp();
		$this->_post_type = new DFP_Ads\Post_Type;
		$user_id       = $this->factory->user->create();
		$post          = array(
			'post_content' => '',
			'post_title'   => $this->ad_title,
			'post_status'  => 'publish',
			'post_type'    => $this->_post_type->name,
			'post_author'  => $user_id,
		);
		$this->post_id = $this->factory->post->create( $post );
		$this->_dfp_ad_position = $this->new_ad_position();
		global $post;
		$post = get_post( $this->post_id );
		$dfp_post_type    = $this->_post_type;
	}

	/**
	 * Creates a new ad position for testing purposes.
	 *
	 * @return \DFP_Ads\Position
	 */
	protected function new_ad_position() {
		update_post_meta( $this->post_id, 'dfp_ad_code', $this->dfp_ad_code );
		update_post_meta( $this->post_id, 'dfp_position_name', $this->dfp_position_name );
		update_post_meta( $this->post_id, 'dfp_position_sizes', $this->dfp_ad_sizes );
		update_post_meta( $this->post_id, 'dfp_out_of_page', $this->out_of_page );

		return new \DFP_Ads\Position( $this->post_id );
	}

	/**
	 * @test
	 */
	public function test_check_post_type_exists() {
		$args             = array();
		$post_types       = get_post_types( $args, 'objects' );
		$post_type_exists = false;
		foreach ( $post_types as $post_type ) {
			if ( $post_type->name === $this->post_type_name ) {
				$post_type_exists = true;
			}
		}
		$this->assertTrue( $post_type_exists );
	}

	/**
	 * @test
	 */
	public function test_post_type_settings_box() {
		ob_start();
		$this->return_html_settings_box();
		$known_settings = ob_get_contents();
		ob_end_clean();
		$new = implode( '', $this->remove_whitespace_from_array( explode( '	', $known_settings ) ) );

		ob_start();
		$this->_post_type->settings_table();
		$unknown_settings = ob_get_contents();
		ob_end_clean();
		$new2 = implode( '', $this->remove_whitespace_from_array( explode( '	', $unknown_settings ) ) );

		$this->assertXmlStringEqualsXmlString( $new, $new2 );

	}

	/**
	 * Gets rid of a heck of a lot of whitespace
	 */
	private function remove_whitespace_from_array( $input ) {
		if ( ! is_array( $input ) ) {

			return trim( $input );
		}

		return array_map( array( $this, 'remove_whitespace_from_array' ), $input );
	}

	/**
	 * Returns expected HTMl of settings box
	 */
	private function return_html_settings_box() {
		?>
		<table class="widefat">
			<thead>
			<tr>
				<th>Settings</th>
				<th>Value</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td><label for="dfp_ad_code" class="dfp-row-title">Code</label></td>
				<td align="left">
					<input type="text" name="dfp_ad_code" id="dfp_ad_code" value="ad_position_1" size="50" />
				</td>
			</tr>
			<tr>
				<td><label for="dfp_position_name" class="dfp-row-title">Name</label></td>
				<td align="left">
					<input type="text" name="dfp_position_name" id="dfp_position_name" value="Ad Position 1" size="50" />
				</td>
			</tr>
			<tr>
				<td><label for="dfp_position_sizes" class="dfp-row-title">Ad Sizes</label></td>
				<td align="left">
					<textarea name="dfp_position_sizes" id="dfp_position_sizes" cols="49" rows="2">300x600</textarea>
				</td>
			</tr>
			<tr>
				<td><label for="dfp_out_of_page" class="dfp-row-title">Out of Page Slot</label></td>
				<td align="left">
					<input type="checkbox" name="dfp_out_of_page" id="dfp_out_of_page" checked="checked" value="1" />
				</td>
			</tr>
			</tbody>
		</table>
		<?php
	}

}
