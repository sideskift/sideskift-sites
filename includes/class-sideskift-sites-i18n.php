<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://sideskift.dk
 * @since      1.0.0
 *
 * @package    Sideskift_Sites
 * @subpackage Sideskift_Sites/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Sideskift_Sites
 * @subpackage Sideskift_Sites/includes
 * @author     Henrik Gregersen <henrik@sideskift.dk>
 */
class Sideskift_Sites_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'sideskift-sites',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
