<?php
/**
 * DFP Ad Position Test Class
 * @see DFP_Ad_Position
 *
 * @since 0.1.0
 * @author Chris W. Gerber <chriswgerber@gmail.com>
 */

class Test_DFP_Ad_Position extends WP_UnitTestCase {

    /** @var DFP_Ad_Position */
    protected $_dfp_ad_position;

    /** @var int */
    protected $ad_post_id;

    /* Post Defaults */
    protected $dfp_position_name = 'Ad Position 1';
    protected $ad_title     = 'Ad Position 1';
    protected $dfp_ad_code  = 'ad_position_1';
    protected $dfp_ad_sizes = '300x600';
    protected $out_of_page  = 0;

    /**
     * Creates the Ad position or returns the ID
     *
     * @return int
     */
    protected function ad_position_id() {
        $user_id = $this->factory->user->create();
        $post = array(
            'post_content' => '',
            'post_title'   => $this->ad_title,
            'post_status'  => 'publish',
            'post_type'    => 'dfp_ads',
            'post_author'  => $user_id,
        );
        $ad_post_id = $this->factory->post->create( $post );
        $this->assertTrue( update_post_meta( $ad_post_id, 'dfp_ad_code', $this->dfp_ad_code ) );
        $this->assertTrue( update_post_meta( $ad_post_id, 'dfp_position_name', $this->dfp_position_name ) );
        $this->assertTrue( update_post_meta( $ad_post_id, 'dfp_position_sizes', $this->dfp_ad_sizes ) );
        $this->assertTrue( update_post_meta( $ad_post_id, 'dfp_out_of_page', $this->out_of_page ) );

        return $ad_post_id;
    }

    /**
     * Returns the DFP Ad Position object
     *
     * Creates the DFP Ad Object. Returns the current object if it has already
     * been created.
     *
     * @return DFP_Ad_Position
     */
    protected function dfp_ad_position() {

        return new DFP_Ad_Position( $this->ad_position_id() );
    }

    /**
     * Test of the Post ID is being set as integer
     */
    public function test_post_id_is_int() {
        $is_int = is_int( $this->dfp_ad_position()->post_id );
        $this->assertTrue( $is_int );
    }

    /**
     * Test of the Post ID is being set as integer
     */
    public function test_ad_position_is_string() {
        $is_string = is_string( $this->dfp_ad_position()->title );
        $this->assertTrue( $is_string );
    }

    /**
     * Test of the Post ID is being set as integer
     */
    public function test_ad_size_string_to_array() {
        $this->assertContains( 300, $this->dfp_ad_position()->sizes );
        $this->assertContains( 600, $this->dfp_ad_position()->sizes );
    }

    /**
     * Test of the Post ID is being set as integer
     */
    public function test_out_of_page() {
        $this->assertFalse( $this->dfp_ad_position()->out_of_page );
    }


}
