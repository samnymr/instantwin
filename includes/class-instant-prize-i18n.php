<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://rightglobalgroup.com/
 * @since      4.1.0
 *
 * @package    Instant_Prize
 * @subpackage Instant_Prize/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      4.1.0
 * @package    Instant_Prize
 * @subpackage Instant_Prize/includes
 * @author     Right Global Group <info@rightglobalgroup.com>
 */
class Instant_Prize_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    4.1.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'instant-prize',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
