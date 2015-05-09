<?php
/**
 * DFP Ad Position Test Class
 * @see DFP_Ad_Position
 *
 * @since 0.1.0
 * @author Chris W. Gerber <chriswgerber@gmail.com>
 */

class Test_DFP_Ad_Position extends WP_UnitTestCase {

    /** @var int */
    protected $ad_post_id;

    protected $ad_title     = 'Ad Position 1';
    protected $dfp_ad_code  = 'ad_position_1';
    protected $dfp_position_name = 'Ad Position 1';
    protected $dfp_ad_sizes = '300x600, 300x600';
    protected $out_of_page  = null;

    /**
     * Creates the Ad position or returns the ID
     *
     * @return int
     */
    protected function ad_position_id() {
        if ( $this->ad_post_id === null ) {
            $user_id = $this->factory->user->create();
            $post = array(
                'post_content'   => '',
                'post_title'     => 'Ad Position',
                'post_status'    => 'publish',
                'post_type'      => 'dfp_ads',
                'post_author'    => $user_id,
            );
            $this->ad_post_id = $this->factory->post->create( $post );
            add_post_meta( $this->ad_post_id, 'dfp_ad_code', $this->dfp_ad_code );
            add_post_meta( $this->ad_post_id, 'dfp_position_name', $this->dfp_position_name );
            add_post_meta( $this->ad_post_id, 'dfp_out_of_page', $this->out_of_page );
        }

        return $this->ad_post_id;
    }

    /**
     * Test of the Post ID is being set as integer
     */
    public function test_post_id_is_int() {
        $_dfp_ad_position = new DFP_Ad_Position( $this->ad_position_id() );
        $is_int = is_int( $_dfp_ad_position->post_id );
        $this->assertTrue( $is_int );
    }


}
