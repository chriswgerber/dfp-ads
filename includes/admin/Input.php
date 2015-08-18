<?php
/**
 * An Input for DFP Ads
 *
 * Input functions for creating a field/metabox input
 *
 * @link       http://www.chriswgerber.com/dfp-ads
 * @since      0.0.1
 *
 * @package    WordPress
 * @subpackage DFP-Ads
 */
namespace DFP_Ads\Admin;

class Input {

	/**
	 * Input Type
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @var string
	 */
	public $type;

	/**
	 * Input name
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Input ID
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @var string
	 */
	public $id;

	/**
	 * Input Label
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @var string
	 */
	public $label;

	/**
	 * Input value
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @var string|int
	 */
	public $value;

	/**
	 * Input Validation Callback
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @var string|array Callback method for verification/saving
	 */
	public $callback;

	/**
	 * PHP5 Constructor
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @param $field array Optional
	 */
	public function __construct( $field = null ) {

		if ( $field !== null ) {
			// Set some defaults.
			$this->id    = $this->get_field_value( $field['id'] );
			$this->type  = $this->get_field_value( $field['type'] );
			$this->name  = $this->get_field_value( $field['name'] );
			$this->label = $this->get_field_value( $field['label'] );
			$this->value = $this->get_field_value( $field['value'] );
		}
	}

	/**
	 * Creates input field for CPT Meta Box
	 *
	 * Creates a new input row for a custom field in the CPT Input box. Must be wrapped
	 * in a < table > tag.
	 *
	 * @access public
	 * @since 0.0.1
	 *
	 * returns an HTML input
	 */
	public function create_input(){
		global $post;
		?>
		<tr>
			<td><label for="<?php echo $this->id; ?>" class="dfp-row-title"><?php printf( __( $this->label, 'dfp-ads' ) ); ?></label></td>
			<td align="left">
				<?php
				switch( $this->type ) :
					// Text Input
					case 'text' :
						?>
						<input type="<?php echo $this->type; ?>" name="<?php echo $this->name; ?>" id="<?php echo $this->id; ?>" value="<?php $this->field_value($this->value); ?>" size="50" />
						<?php
						break;

					// Text Area
					case 'textarea' :
						?>
						<textarea name="<?php echo $this->name; ?>" id="<?php echo $this->id; ?>" cols="49" rows="2"><?php echo esc_textarea( $this->get_field_value( $this->value ) ); ?></textarea>
						<?php
						break;

					// Text Area
					case 'checkbox' :
						?>
						<input type="<?php echo $this->type; ?>" name="<?php echo $this->name; ?>" id="<?php echo $this->id; ?>"<?php checked( $this->value, 1 ); ?> value="1" />
						<?php
						break;

				endswitch;
				?>
			</td>
		</tr>
		<?php
	}

	/**
	 * Field Value
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @see    DFP_Ads_Post_Type::get_field_value
	 *
	 * @param $value
	 *
	 * Echoes out value.
	 */
	public function field_value( $value ) {

		echo $this->get_field_value( $value );
	}

	/**
	 * Checks if a value is set before trying to return it.
	 *
	 * This prevents unnecessary errors from occurring for undefined indices.
	 * It's not designed to provided any security.
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @param $value int|string|null
	 *
	 * @return mixed
	 */
	public function get_field_value( $value ) {

		return ( ( isset( $value ) && $value != null ) ? $value : null );
	}

}