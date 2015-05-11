<?php
/**
 * Form page for importing data.
 *
 * Description.
 *
 * @link  http://www.chriswgerber.com/dfp-ads
 * @since 0.2.0
 *
 * @package    WordPress
 * @subpackage DFP-Ads
 */
use Ddeboer\DataImport\Reader\CsvReader;

class DFP_Ads_Import_Form extends DFP_Ads_Form {

	public $csv_importer;

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
	                <?php
	                $submit_value = ( isset( $_POST['submit'] ) ? $_POST['submit'] : '' );
	                switch ( $submit_value ) :
		                // We're importing a CSV
		                case 'Import CSV':
			                $this->import_csv( $_FILES['DFP_Ads_Import']['tmp_name']['import_csv'] );
		                    break;
		                // Display Import Form
		                default;
							$this->import_form();
					endswitch;
	                ?>
                </div>
            </div>
	        <div class="postbox">
                <div class="inside">
	                <h3>$_POST</h3>
	                <?php var_dump( $_POST ); ?>
                </div>
	        </div>
	        <div class="postbox">
		        <div class="inside">
	                <h3>$_FILES</h3>
	                <?php var_dump( $_FILES ); ?>
                </div>
            </div>
        </div>
        <?php
    }

	public function import_form() {
		?>
		<form id="CSVImport" name="CSVImport" method="post" enctype="multipart/form-data">
            <?php settings_fields( $this->settings_fields ); ?>
            <?php do_settings_sections( $this->settings_sections ); ?>
            <?php $this->button( 'Import CSV' ); ?>
		</form>
		<?php
	}

	public function import_csv( $file ) {
		echo '<h3>Choose the positions to import</h3>';
		echo '<form id="CSVImport" name="CSVImport" method="post" enctype="multipart/form-data">';
		$file   = new \SplFileObject( $file );
		$reader = new CsvReader($file);
		$reader->setHeaderRowNumber(0);
		$csv = new DFP_Ads_CSV_Reader( $reader, $file );
		$this->results_table( $reader );
		echo '<br />';
		$this->button( 'Confirm Import', true );
		echo '</form>';
	}

	public function results_table( $reader ) {
		?>
		<table>
			<thead>
			<tr>
				<th>Select</th>
				<th>Code</th>
				<th>Name</th>
				<th>Sizes</th>
			</tr>
			</thead>
			<tbody>
		<?php foreach ($reader as $row) { ?>
			<tr>
				<td><input type="checkbox" /></td>
				<td><?php _e( $row['#Code']); ?></td>
				<td><?php _e( $row['Name'] ); ?></td>
				<td><?php _e( $row['Sizes'] ); ?></td>
			</tr>
		<?php } ?>
			</tbody>
		</table>
		<?php
	}

	public function return_button( $text ) {
		echo '<form id="return" name="return" method="post">';
		$this->button( $text );
		echo '</form>';
	}

	public function file( $args ) {
		// Nested args....
		$args = $args[0];
		// Field values
		$id     = $this->options_str . '[' . $args['id'] . ']';
		?><input id="<?php _e( $id, 'dfp-ads' ); ?>" name="<?php _e( $id, 'dfp-ads' ); ?>" type="file" /><?php
	}
}