<?php

/**
 * Fired during plugin activation
 *
 * @link       cedcommerce
 * @since      1.0.0
 *
 * @package    Importer
 * @subpackage Importer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Importer
 * @subpackage Importer/includes
 * @author     Sabreen Shakeel <sabreenshakeel@cedcoss.com>
 */
class Importer_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		$upload = wp_upload_dir();
		$upload_dir = $upload['basedir'];
		$upload_dir = $upload_dir . '/Importer_uploads';
		// print_r($upload_dir);
		if (! is_dir($upload_dir)) {
		mkdir( $upload_dir, 0700 );
		}

	}

}
