<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://chetanvaghela.cf
 * @since      1.0.0
 *
 * @package    Wp_Login_Register_Flow
 * @subpackage Wp_Login_Register_Flow/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Wp_Login_Register_Flow
 * @subpackage Wp_Login_Register_Flow/includes
 * @author     Chetan Vaghela <ckvaghela92@gmail.com>
 */
class Wp_Login_Register_Flow_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wp-login-register-flow',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
