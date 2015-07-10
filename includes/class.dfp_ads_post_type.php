<?php
/**
 * Class DFP_Ads_Post_Type
 *
 * @link  http://www.chriwgerber.com/dfp-ads
 * @since 0.0.1
 *
 * @package    WordPress
 * @subpackage DFP-Ads
 */

class DFP_Ads_Post_Type {

	/**
	 * @const Name of the action that runs in the metabox fields.
	 *
	 * @since 0.0.1
	 * @access public
	 */
	CONST FIELDS_FILTER = 'dfp_ads_metabox_fields';

	/**
	 * Name of the custom post type
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @var string
	 */
	public $name = 'dfp_ads';

	/**
	 * Array of DFP_Ads_Input objects
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @var array
	 */
	public $inputs;

	/**
	 * Metabox Nonce. For Security Reasons
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @var string
	 */
	public $nonce = 'dfp_meta_nonce';

	/**
	 * Create Post Type
	 *
	 * Creates the custom post type for ad positions.
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function create_post_type() {

		$labels = array(
			'name'                => _x( 'Ad Positions', 'Post Type General Name', 'dfp-ads' ),
			'singular_name'       => _x( 'Ad Position', 'Post Type Singular Name', 'dfp-ads' ),
			'menu_name'           => __( 'Ad Positions', 'dfp-ads' ),
			'parent_item_colon'   => __( 'Parent Positions:', 'dfp-ads' ),
			'all_items'           => __( 'All Ad Positions', 'dfp-ads' ),
			'view_item'           => __( 'View Ad Position', 'dfp-ads' ),
			'add_new_item'        => __( 'Add New Position', 'dfp-ads' ),
			'add_new'             => __( 'Add New', 'dfp-ads' ),
			'edit_item'           => __( 'Edit Position', 'dfp-ads' ),
			'update_item'         => __( 'Update Position', 'dfp-ads' ),
			'search_items'        => __( 'Search Positions', 'dfp-ads' ),
			'not_found'           => __( 'Not found', 'dfp-ads' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'dfp-ads' ),
		);
		$args = array(
			'label'               => __( $this->name, 'dfp-ads' ),
			'description'         => __( 'Ad Positions', 'dfp-ads' ),
			'labels'              => $labels,
			'supports'            => array( 'title' ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'menu_position'       => apply_filters('dfp_ads_menu_position', 20),
			'menu_icon'           => 'dashicons-welcome-widgets-menus',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'rewrite'             => false,
			'capability_type'     => 'page',
		);
		register_post_type( $this->name, $args );
	}

	/**
	 * Add Meta Boxes
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 */
	public function add_meta_boxes() {
		global $post;

		$boxes = array(
			array(
				'id'    => 'ad_pos_settings',
				'title' => 'Ad Position Settings',
				'callback' => array($this, 'settings_box'),
				'name'  => $this->name,
				'context' => 'normal',
				'priority' => 'high',
				'callback_args' => $post->ID
			)
		);

		foreach ( $boxes as $box ) {
			add_meta_box(
				$box['id'],
				$box['title'],
				$box['callback'],
				$box['name'],
				$box['context'],
				$box['priority']
			);
		}

	}

	/**
	 * Saves a metabox
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @param wp_post $post The post object.
	 * @param int $post_id The post ID.
	 */
	public function save_meta_box( $post_id, $post ) {

		$is_valid_nonce = ( isset( $_POST[ $this->nonce ] ) && wp_verify_nonce( $_POST[ $this->nonce ], basename( __FILE__ ) ) ) ? 'true' : 'false';

		// Exits script depending on save status
		if ( wp_is_post_autosave( $post_id ) || wp_is_post_revision( $post_id ) || !$is_valid_nonce ) {

			return;
		}
		$NEW_POST = array();
		// Checks for input and sanitizes/saves if needed
		foreach ( dfp_get_fields() as $input ) {
			if ( isset( $_POST[ $input->name ] ) ) {
				$new_value = sanitize_text_field( $_POST[ $input->name ] );
			} else {
				$new_value = ( isset( $_POST[$input->name] ) ? true : false );
			}
			update_post_meta( $post->ID, $input->name, $new_value );
		}
	}

	/**
	 * Settings Metabox
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @param $post WP_Post
	 */
	public function settings_box( $post ) {
		global $post;
		wp_nonce_field( basename( __FILE__ ), $this->nonce );
		/*
		 * Run functions before the creation of the settings table
		 */
		do_action('dfp_ads_metabox_top');
		/*
		 * Runs functions with the settings table.
		 *
		 * This is the action that queues up the fields.
		 *
		 */
		do_action('dfp_ads_metabox_middle');

		/*
		 * Runs after fields are created.
		 */
		do_action('dfp_ads_metabox_bottom');
	}

	/**
	 * Customize Ad Positions Columns
	 *
	 * Adds columns for codename for ad as well as a
	 * special input for grabbing the shortcode.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @param $columns
	 *
	 * @return array
	 */
	public function add_shortcode_column( $columns ) {

		return array(
			'cb'         => __( '', 'dfp-ads' ),
			'title'      => __( 'Title', 'dfp-ads' ),
			'post_id'      => __( 'Ad ID', 'dfp-ads' ),
			'ad_code'    => __( 'Ad Code', 'dfp-ads' ),
			'short_code' => __( 'Short Code', 'dfp-ads' ),
		);
	}

	/**
	 * Runs action on the created columns.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @param $column array Array of filter columns.
	 */
	public function shortcode_column_value( $column ) {
		global $post;
		switch ( $column ) {

			case 'short_code' :
				dfp_ads_shortcode_field( $post->ID );

				break;

			case 'ad_code' :
				echo get_post_meta( $post->ID, 'dfp_ad_code', true );

				break;

			case 'post_id' :
				_e( $post->ID, 'dfp-ads' );

				break;

		}
	}


	/**
	 * Adds custom fields to metabox from filter
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function add_inputs() {
		global $post;
		/**
		 * @param DFP_Ads_input $input
		 */
		foreach ( dfp_get_fields() as $input ) {
			$input->value = get_post_meta( $post->ID, $input->name, true );
			$input->create_input();
		}
	}

	/**
	 * Call back for the settings table
	 *
	 * Runs the action DFP_Ads_Field, which creates the input fields.
	 *
	 * Queued to run in the CPT meta box.
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function settings_table() {
		/*
		 * Settings Table
		 */
		?>
		<table class="widefat">
			<thead>
			<tr>
				<th><?php _e('Settings', 'dfp-ads'); ?></th>
				<th><?php _e('Value', 'dfp-ads'); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php
			/*
			 * Grab all of the ad positions and turn them into new input fields
			 *
			 * New positions can be filtered in using the filter name established by this class.
			 * That filter should include a new DFP_Ads_Input object that has data for each of
			 * the necessary fields. It should be included in the array.
			 *
			 * Action Name:
			 */
			do_action('dfp_ads_fields');
			?>
			</tbody>
		</table>
	<?php
	}

	/**
	 * Adds Shortcode Input box to metabox.
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function ad_position_shortcode() {
		global $post;
		?>
		<p>
			<strong>Ad Position Shortcode</strong> : <?php dfp_ads_shortcode_field( $post->ID ); ?>
		</p>
		<?php
	}
}