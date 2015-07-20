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
namespace DFP_Ads\Admin;

use DFP_Ads\Globals_Container as DFP_Ads_Globals;
use Ddeboer\DataImport\Reader\CsvReader;

class Import_Form extends Form {

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
	                $submit_value = ( DFP_Ads_Globals::post_var_exists( 'submit' ) ? DFP_Ads_Globals::get_post_var('submit') : '' );
	                switch ( $submit_value ) :
		                // We're importing a CSV
		                case 'Import CSV':
			                $this->prepare_data( $_FILES['DFP_Ads_Import']['tmp_name']['import_csv'] );
		                    break;
                        case 'Confirm Import':
                            $this->import_data();
                            $this->return_button('Return to Importer');
                            break;
		                // Display Import Form
		                default;
							$this->import_form();
					endswitch;
	                ?>
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
            </div>
        </div>
        <div class="postbox ">
            <div class="inside">
                <p>
                    For instructions on how to import from CSV, visit
                    <a href="http://www.chriswgerber.com/dfp-ads/import-from-csv" target="_blank">www.chriswgerber.com/dfp-ads/import-from-csv</a>.</p>
		<?php
	}

	public function prepare_data( $file ) {
		echo '<h3>Choose the positions to import</h3>';
		echo '<form id="CSVImport" name="CSVImport" method="post" enctype="multipart/form-data">';
		$file   = new \SplFileObject( $file );
		$reader = new CsvReader($file);
		$reader->setHeaderRowNumber(0);
		$this->results_table( $reader );
        $this->setup_data( $reader );
		echo '<br />';
		$this->button( 'Confirm Import', true );
		echo '</form>';
	}

	/**
     * @TODO Add Labels
     *
	 * @param $reader
     */
	public function results_table( $reader ) {
		?>
		<table>
			<thead>
			<tr>
				<th align="center">Select</th>
				<th align="center">Code</th>
				<th align="center">Name</th>
				<th align="center">Sizes</th>
			</tr>
			</thead>
			<tbody>
		<?php foreach ( $reader as $row ) { ?>
			<tr>
				<td align="center"><input type="checkbox" id="code[<?php _e( $row['#Code']); ?>]" name="code[<?php _e( $row['#Code']); ?>]" value="<?php _e( $row['#Code']); ?>" /></td>
				<td><?php _e( $row['#Code']); ?></td>
				<td><?php _e( $row['Name'] ); ?></td>
				<td><?php _e( $row['Sizes'] ); ?></td>
			</tr>
		<?php } ?>
			</tbody>
		</table>
		<?php
	}

    public function import_data() {
        $data = get_transient( 'import_data' );
        $new_positions = DFP_Ads_Globals::filter_post_var( 'code', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY );
        foreach ( $data as $position ) {
            if ( array_key_exists ( $position['#Code'], $new_positions ) ) {
                echo 'Added Position <kbd>' . $position['#Code'] . '</kbd>.<br />';
                $this->add_position( $position );
            }

        }
    }

    /**
     * Sets up data to be imported
     *
     * @param CSVReader $reader
     */
    public function setup_data( $reader ) {
        $transient = array();
        foreach ( $reader as $key => $value ) {
            $transient[$key] = $value;
        }
        set_transient( 'import_data', $transient, 30 );
    }

	public function return_button( $text ) {
		echo '<form id="return" name="return" method="post">';
        echo '<br />';
		$this->button( $text );
		echo '</form>';
	}

    public function add_position( $position ) {
        $post = array(
            'post_content' => $position['Description'],
            'post_title'   => $position['#Code'],
            'post_status'  => 'publish',
            'post_type'    => 'dfp_ads',
            'post_author'  => get_current_user_id(),
        );
        $ad_post_id = wp_insert_post( $post );
        update_post_meta( $ad_post_id, 'dfp_ad_code', $position['#Code'] );
        update_post_meta( $ad_post_id, 'dfp_position_name', $position['Name'] );
        update_post_meta( $ad_post_id, 'dfp_position_sizes', $position['Sizes'] );
    }

	public function file( $args ) {
		// Nested args....
		$args = $args[0];
		// Field values
		$id     = $this->options_str . '[' . $args['id'] . ']';
		?><input id="<?php _e( $id, 'dfp-ads' ); ?>" name="<?php _e( $id, 'dfp-ads' ); ?>" type="file" /><?php
	}
}