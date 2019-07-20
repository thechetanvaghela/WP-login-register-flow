<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://chetanvaghela.cf
 * @since      1.0.0
 *
 * @package    Wp_Login_Register_Flow
 * @subpackage Wp_Login_Register_Flow/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Login_Register_Flow
 * @subpackage Wp_Login_Register_Flow/public
 * @author     Chetan Vaghela <ckvaghela92@gmail.com>
 */
class Wp_Login_Register_Flow_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( 'wplrf-toastr-css', plugin_dir_url( __FILE__ ) . 'css/toastr.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-login-register-flow-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( 'wplrf-toastr-js', plugin_dir_url( __FILE__ ) . 'js/toastr.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-login-register-flow-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name,'wplrf_ajax_object',array('ajaxurl' => admin_url( 'admin-ajax.php' ),));

	}

	/**
	 * Add wplrf html in footer
	 *
	 * @since    1.0.0
	 */
	public function wplrf_html(){
		//ob_start();
		include(WPLRF_PLUGIN_DIR.'public/partials/wplrf-html.php');
		//return ob_get_clean();
	}

}
