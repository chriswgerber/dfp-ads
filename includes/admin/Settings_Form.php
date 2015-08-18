<?php
/**
 * Functions for building a form
 *
 * Description.
 *
 * @link       http://www.chriswgerber.com/dfp-ads
 * @since      0.0.1
 *
 * @package    WordPress
 * @subpackage DFP-Ads
 */
namespace DFP_Ads\Admin;

class Settings_Form extends Form {

	/**
	 * Coagulates the functions into a form on the front-end.
	 *
	 * @since  0.0.1
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
}