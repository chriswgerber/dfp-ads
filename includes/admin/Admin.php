<?php
/**
 * DFP Ads Admin
 *
 * @since      0.0.1
 *
 * @package    WordPress
 * @subpackage DFP-Ads
 */
namespace DFP_Ads;

class Admin {

	/**
	 * Title of the menu page
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @var string
	 */
	public $menu_title;

	/**
	 * User capability necessary to access page
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @var string
	 */
	public $user_cap;

	/**
	 * Slug for the page
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @var string
	 */
	public $plugin_slug;

	/**
	 * String identifier for the options
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @var string
	 */
	public $options_str;

	/**
	 * String identifier for the options group
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @var string
	 */
	public $options_grp;

	/**
	 * Settings Page Title
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @var string
	 */
	public $page_title;

	/**
	 * Sections of content
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @var array
	 */
	public $sections = array();

	/**
	 * Stores the Form creation object. Form creation functions run through here.
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @var Admin\Form
	 */
	public $form;

	/**
	 * Individual fields to be added
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @var array
	 */
	public $fields = array();

	/**
	 * Created by page registration
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @var string $hook_suffix
	 */
	private $hook_suffix = '';

	/**
	 * Tells the settings page which menu item to queue on
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @var string
	 */
	public $post_type;

	/**
	 * Form Input Values
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @var array
	 */
	public $values;

	/**
	 * PHP5 Constructor
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @param Admin\Form $form Handles form functions.
	 */
	public function __construct( Admin\Form $form ) {
		$this->form = $form;
	}

	/**
	 * Register the Menu Page.
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function register_menu_page() {
		$this->sections    = apply_filters( strtolower( $this->options_str ) . '_sections', array() );
		$this->fields      = apply_filters( strtolower( $this->options_str ) . '_fields', array() );
		$this->values      = get_option( $this->options_str );
		$this->hook_suffix = add_submenu_page(
			'edit.php?post_type=' . $this->post_type,
			$this->page_title,     // Page Title
			$this->menu_title,     // Menu Title
			$this->user_cap,       // Capability
			$this->plugin_slug,    // Menu Slug
			array( $this, 'form' ) // Function
		);
	}

	/*
	 * Initialization function for the settings page.
	 *
	 * Sets up the settings and calls the view.
	 *
	 * Also pulls in errors/update notifications
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function menu_page_init() {
		// Register settings
		$this->register_settings();
		// Creates the settings var to be referred to
		$this->add_sections();
		// Errors
		add_action( 'admin_notices', array( $this, 'add_errors' ) );
	}

	/**
	 * Displays Form. WordPress requires a function be used to display the input form.
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function form() {
		$this->form->values            = $this->values;
		$this->form->options_str       = $this->options_str;
		$this->form->title             = $this->page_title;
		$this->form->settings_fields   = $this->options_grp;
		$this->form->settings_sections = $this->plugin_slug;
		$this->form->render_form();
	}


	/**
	 * Register the plugin settings in WordPress.
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function register_settings() {
		// register our settings
		register_setting(
			$this->options_grp,
			$this->options_str,
			array( $this, 'options_validate' )
		);
	}

	/**
	 * Create form for plugin settings.
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function add_sections() {

		if ( $this->sections ) {
			foreach ( $this->sections as $section ) {
				$this->create_settings_section( $section );
			}
		}

		if ( $this->fields ) {
			foreach ( $this->fields as $setting ) {
				$this->create_settings_field( $setting );
			}
		}
	}

	/**
	 * Sanitize and validate input. Accepts an array, return a sanitized array.
	 *
	 * @TODO   Set up validation
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @param array $input
	 *
	 * @return array $new_input
	 */
	public function options_validate( $input ) {

		return $input;
	}

	/**
	 * Basic section callback. Creates the settings header.
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @param $args array
	 */
	public function basic_section_callback( $args ) {

	}

	/**
	 * Creates input
	 *
	 * @TODO   Add Labels
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @param $args array
	 */
	public function basic_input_callback( $args ) {
		// Why is it so nested?
		$args = $args[0];
		// Field values
		$id     = $this->options_str . '[' . $args['id'] . ']';
		$title  = $args['title'];
		$values = get_option( $this->options_str );
		$value  = $values[ $args['id'] ];
		?>
		<div>
			<input type="<?php echo $args->field; ?>"
			       id="<?php _e( $id, 'dfp-ads' ); ?>"
			       name="<?php _e( $id, 'dfp-ads' ); ?>"
			       value="<?php _e( $value, 'dfp-ads' ); ?>"/>
			<?php
			if ( isset( $args['description'] ) ) {
				echo '<p><em>' . $args['description'] . '</em></p>';
			}
			?>
		</div>
		<?php
	}

	/**
	 * Creates the settings sections
	 *
	 * @since  0.0.1
	 * @access protected
	 *
	 * @param array $section ID = input ID,
	 *                       Title = Name of field,
	 */
	protected function create_settings_section( $section ) {
		add_settings_section(
			$section['id'], //    'basic_settings', // ID
			$section['title'], // 'Tags', // Title
			array( $this, 'basic_section_callback' ), // Callback
			$this->plugin_slug // Page
		);
	}

	/**
	 * Creates settings fields
	 *
	 * @since  0.0.1
	 * @access protected
	 *
	 * @param array $settings
	 *              ID = input ID,
	 *              Title = Name of field,
	 *              Field = Type of field,
	 *              Callback = Callback function
	 *              Description = Description below field
	 */
	protected function create_settings_field( $settings ) {
		add_settings_field(
			$settings['id'], // ID
			$settings['title'], // Title
			array( $this->form, $settings['callback'] ), // Callback
			$this->plugin_slug, // Page
			$settings['section'], // Section
			array( $settings ) // Args
		);
	}

	/**
	 * Queue up the errors
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function add_errors() {
		settings_errors( $this->options_str );
	}

	/**
	 * Add Error or Update Message to admin page.
	 *
	 * Will warn users of an issue or add a message saying it was successful.
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @param string $message Message to send to user
	 * @param string $type    Type of Message: Error / Updated
	 */
	public function new_error( $message, $type ) {
		add_settings_error(
			$this->options_str,
			'settings_updated',
			$message,
			$type
		);
	}
}