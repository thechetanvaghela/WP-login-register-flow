<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://chetanvaghela.cf
 * @since      1.0.0
 *
 * @package    Wp_Login_Register_Flow
 * @subpackage Wp_Login_Register_Flow/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Login_Register_Flow
 * @subpackage Wp_Login_Register_Flow/admin
 * @author     Chetan Vaghela <ckvaghela92@gmail.com>
 */
class Wp_Login_Register_Flow_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->load_required_files();

	}

	/**
	 * Load the required dependencies files for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - ChatAdmin_class. create admin menu page of the plugin.
	 * - ChatMessage_List. Defines WP_List_Table functionality.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_required_files() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-login-register-flow-admin-setting.php';

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Login_Register_Flow_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Login_Register_Flow_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-login-register-flow-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Login_Register_Flow_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Login_Register_Flow_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-login-register-flow-admin.js', array( 'jquery' ), $this->version, false );

	}

}
