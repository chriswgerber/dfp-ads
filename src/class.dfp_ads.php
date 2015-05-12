<?php
/**
 * Class DFP_Ads
 *
 * @link  http://www.chriwgerber.com/dfp-ads/
 * @since 0.0.1
 *
 * @package    WordPress
 * @subpackage DFP-Ads
 */
Class DFP_Ads {

	/**
	 * Loads Google Ads JS to header
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @var string $google_ad_script_name
	 */
	public $google_ad_script_name = 'google_ad_js';

	/**
	 * Name of the javascript file.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @var string $script_name
	 */
	public $script_name = 'dfp_ads';

	/**
	 * DFP Account ID. Includes the two slashes
	 *
	 * @since 0.0.1
	 * @access public
	 * @var string $account_id
	 */
	public $account_id;

	/**
	 * Stores the URI of the directory
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @var string $dir_uri
	 */
	public $dir_uri;

	/**
	 * Ad Positions - Array
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @var DFP_Ad_Position
	 */
	public $positions;

	/**
	 * Sets page level targeting
	 *
	 * @access public
	 * @since 0.0.1
	 *
	 * @var array
	 */
	public $page_targeting = array(
		'Page'    => '',
		'Category' => array(),
		'Tag'      => array(),
	);

	/**
	 * PHP5 Constructor
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function __construct() {

		/** Creates DFP_Ads Shortcode */
		add_shortcode( 'dfp_ads', array( $this, 'shortcode' ) );
	}

	/**
	 * Set DFP Property Code
	 *
	 * Sets the DFP Property Code. An 8-digit integer
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @param $id int Code ID Number
	 *
	 * @return bool|string
	 */
	public function set_account_id( $id ) {
		$this->account_id = '/' . $id . '/';

		return ( isset($this->account_id) ? $this->account_id : false );
	}

	/**
	 * Sets all ad targetting
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @return mixed
	 */
	public function set_targeting(  ) {
		global $post;
		// Page Title
		$this->page_targeting['Page'] = $this->get_page_targeting();
		// Categories
		$this->page_targeting['Category'] = $this->get_category_targeting();
		// Tags
		$this->page_targeting['Tag'] = $this->get_tag_targeting();
	}

	/**
	 *
	 */
	public function send_ads_to_js( $dfp_ads ) {
		// Copy the original
		$object = clone $this;

		$object->set_targeting();
		$object->positions = dfp_get_ad_positions();
		$object->script_name = null;
		$object->dir_uri = null;

		return $object;
	}

	/**
	 * Adds URL sections to targetting
	 *
	 * @since 0.0.1
	 * @access protected
	 *
	 * @return array|string
	 */
	protected function get_page_targeting() {
		$array = explode( '/', substr( str_replace( home_url(), '', dfp_get_url() ), 1, -1 ) );
		return ( count($array) < 1 ? array('Home') : $array );
	}

	/**
	 * Sets the category targeting on the object
	 *
	 * @since 0.0.1
	 * @access protected
	 *
	 * @return array|string
	 */
	protected function get_category_targeting() {
		global $post;
		$targets = array();

		$categories = get_the_category( $post->ID );
		foreach( $categories as $c ){
			$cat = get_category( $c );
			$targets[] = $cat->name;
		}
		return ( count($targets) < 1 ? '' : $targets );
	}

	/**
	 * Sets the tag targeting on the object
	 *
	 * @since 0.0.1
	 * @access protected
	 *
	 * @return array|string
	 */
	protected function get_tag_targeting() {
		global $post;
		$targets = array();
		$tags = get_the_tags( $post->ID );
		if ( $tags ) {
			foreach( $tags as $tag ){
				$targets[] = $tag->name;
			}
		}
		return ( count($targets) < 1 ? '' : $targets );
	}

	/**
	 * Registers Scripts. Localizes data to interstitial_ad.js
	 *
	 * @access public
	 * @since 0.0.1
	 *
	 * @return mixed
	 */
	public function scripts_and_styles() {
		// Google Ads JS Script
		wp_register_script(
			$this->google_ad_script_name,
			$this->dir_uri . '/js/google-ads.js',
			array( 'jquery' ),
			false,
			false
		);
		wp_enqueue_script( $this->google_ad_script_name );
		// Preps the script
		wp_register_script(
			$this->script_name,
			$this->dir_uri . '/js/dfp-ads.js',
			array( $this->google_ad_script_name, 'jquery' ),
			false,
			false
		);
		/* Get the Final Ad Positions */
		$ad_positions = apply_filters( 'pre_dfp_ads_to_js', $this);
		// Send data to front end.
		wp_localize_script( $this->script_name, 'dfp_ad_object', array($ad_positions) );
		wp_enqueue_script( $this->script_name );
	}

	/**
	 * Display Shortcode
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @param $atts array
	 */
	public function shortcode( $atts ){
		dfp_ad_position( $atts['id'] );
	}

}