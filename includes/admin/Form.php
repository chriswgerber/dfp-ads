<?php
/**
 * Abstract class for building forms.
 *
 * Class abstraction for simple form functions.
 *
 * @link       http://www.chriswgerber.com/dfp-ads
 * @since      0.2.0
 *
 * @package    WordPress
 * @subpackage DFP-Ads
 */
namespace DFP_Ads\Admin;

Abstract Class Form {

	/**
	 * Page Title
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @var string
	 */
	public $title;

	/**
	 * String to call settings fields
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @var string
	 */
	public $settings_fields;

	/**
	 * String to call settings sections
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @var string
	 */
	public $settings_sections;

	/**
	 * @since  0.2.0
	 * @access public
	 *
	 * @var array
	 */
	public $values;

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
	 * Coagulates the functions into a form on the front-end.
	 *
	 * Abstract
	 *
	 * @since  0.0.1
	 * @access public
	 */
	abstract public function render_form();

	/**
	 * Adds the title to the page.
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @param $title string Form Title
	 */
	public function form_title( $title = null ) {
		// Takes specialized title, or uses default if empty.
		$title = ( $title === null ? $this->title : $title );
		// Echos title
		echo "<h2>$title</h2>";
	}

	/**
	 * Creates input
	 *
	 * @TODO   Add Labels
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param $args array
	 */
	public function text( $args ) {
		// Why is it so nested?
		$args  = $args[0];
		$id    = $this->options_str . '[' . $args['id'] . ']';
		$field = $args['field'];
		$title = $args['title'];
		$value = ( ! isset( $this->values[ $args['id'] ] ) ? '' : $this->values[ $args['id'] ] );
		?>
		<div>
			<input type="<?php _e( $field, 'dfp-ads' ); ?>"
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
	 * Creates Select Options for widget
	 *
	 * @TODO   Add Labels
	 *
	 * @since  0.2.0
	 * @access public
	 *
	 * @param $args Array
	 */
	public function ads_dropdown( $args ) {
		// Why is it so nested?
		$args = $args[0];
		// Field values
		$id    = $this->options_str . '[' . $args['id'] . ']';
		$title = $args['title'];
		$value = ( ! isset( $this->values[ $args['id'] ] ) ? '' : $this->values[ $args['id'] ] );
		?>
		<div>
			<select id="<?php _e( $id, 'dfp-ads' ); ?>" name="<?php _e( $id, 'dfp-ads' ); ?>">
				<?php dfp_ad_select_options( $value ); ?>
			</select>
			<?php if ( isset( $args['description'] ) ) { ?>
				<p><em><?php _e( $args['description'], 'dfp-ads' ); ?></em></p>
			<?php } ?>
		</div>
		<?php
	}

	/**
	 * Creates checkbox input
	 *
	 * @TODO   Add Labels
	 *
	 * @since  0.3.0
	 * @access public
	 *
	 * @param $args array
	 */
	public function checkbox( $args ) {
		// Why is it so nested?
		$args    = $args[0];
		$id      = $this->options_str . '[' . $args['id'] . ']';
		$field   = $args['field'];
		$title   = $args['title'];
		$value   = ( ! isset( $this->values[ $args['id'] ] ) ? '' : $this->values[ $args['id'] ] );
		$checked = ( $value == 'on' ? 'checked' : '' );
		?>
		<div>
			<input type="<?php _e( $field, 'dfp-ads' ); ?>"
			       id="<?php _e( $id, 'dfp-ads' ); ?>"
			       name="<?php _e( $id, 'dfp-ads' ); ?>"
				<?php _e( $checked ); ?> />
			<?php
			if ( isset( $args['description'] ) ) {
				echo '<p><em>' . $args['description'] . '</em></p>';
			}
			?>
		</div>
		<?php
	}

	/**
	 * Button Function
	 *
	 * Creates an HTML button.
	 *
	 * @since  0.0.1
	 * @access public
	 *
	 * @param $value   string Value of the submit button
	 * @param $primary bool Mark a button as a primary button
	 */
	public function button( $value, $primary = false ) {
		$value = wp_strip_all_tags( $value, true );
		$button_type = ( $primary === false ? 'button-secondary' : 'button-primary' )
		?>
		<input type="submit" name="submit" id="submit" class="button <?php echo $button_type; ?>"
		       value="<?php echo $value; ?>">
		<?php
	}

	/**
	 * Simple method for accessing a submit button
	 *
	 * @since  0.0.1
	 * @access public
	 */
	public function submit_button() {
		$this->button( "Save Changes", true );
	}
}