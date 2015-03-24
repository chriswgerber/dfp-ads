<?php
/** 
 * Functions for building a form
 *
 * Description.
 *
 * @link  http://www.chriswgerber.com/dfp-ads
 * @since 0.0.1
 *
 * @package    WordPress
 * @subpackage DFP-Ads
 */

class DFP_Ads_Form {

	/**
	 * @var string Page Title
	 */
	public $title;

	/**
	 * String to call settings fields
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @var string
	 */
	public $settings_fields;

	/**
	 * String to call settings sections
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @var string
	 */
	public $settings_sections;

	/**
	 * Coagulates the functions into a form on the front-end.
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function render_form() {
		?>
		<div class="wrap">
			<?php $this->form_title(); ?>
			<div class="postbox ">
				<div class="inside">
					<form method="post" action="options.php">
						<?php settings_fields( $this->settings_fields ); ?>
						<?php do_settings_sections( $this->settings_sections ); ?>
						<?php $this->submit_button(); ?>
					</form>
				</div>
			</div>
		</div>

		<?php
	}

	/**
	 * Adds the title to the page.
	 *
	 * @since 0.0.1
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
	 * Button Function
	 *
	 * Creates an HTML button.
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @param $value string Value of the submit button
	 * @param $primary bool Mark a button as a primary button
	 */
	public function button( $value, $primary = false ) {
		$value = wp_strip_all_tags( $value, true );
		$button_type = ($primary === false ? 'button-secondary' : 'button-primary' )
		?>
		<input type="submit" name="submit" id="submit" class="button <?php echo $button_type; ?>" value="<?php echo $value; ?>">
		<?php
	}

	/**
	 * Simple method for accessing a submit button
	 *
	 * @since 0.0.1
	 * @access public
	 */
	public function submit_button() {
		$this->button("Save Changes", true);
	}

	/**
	 * Creates Select Options for widget
	 *
	 * @since 0.0.1
	 * @access public
	 *
	 * @param $value string Current field value
	 */
	public function ad_select_options( $value ) {
		$positions = dfp_get_ad_positions();
		foreach ( $positions as $position ) {
			echo '<option' . selected( $value, $position->post_id ) . ' value="' . $position->post_id . '">' . $position->title . '</option>';
		}
	}

}