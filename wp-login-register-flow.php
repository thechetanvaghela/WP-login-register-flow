<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://chetanvaghela.cf
 * @since             1.0.0
 * @package           Wp_Login_Register_Flow
 *
 * @wordpress-plugin
 * Plugin Name:       WP Login Register Flow
 * Plugin URI:        http://chetanvaghela.cf
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Chetan Vaghela
 * Author URI:        http://chetanvaghela.cf
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-login-register-flow
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WP_LOGIN_REGISTER_FLOW_VERSION', '1.0.0' );

define( 'WPLRF_PLUGIN_DIR', plugin_dir_path(__FILE__) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-login-register-flow-activator.php
 */
function activate_wp_login_register_flow() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-login-register-flow-activator.php';
	Wp_Login_Register_Flow_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-login-register-flow-deactivator.php
 */
function deactivate_wp_login_register_flow() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-login-register-flow-deactivator.php';
	Wp_Login_Register_Flow_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_login_register_flow' );
register_deactivation_hook( __FILE__, 'deactivate_wp_login_register_flow' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-login-register-flow.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_login_register_flow() {

	$plugin = new Wp_Login_Register_Flow();
	$plugin->run();

}
run_wp_login_register_flow();
