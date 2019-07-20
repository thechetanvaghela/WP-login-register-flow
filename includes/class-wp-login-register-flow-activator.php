<?php

/**
 * Fired during plugin activation
 *
 * @link       http://chetanvaghela.cf
 * @since      1.0.0
 *
 * @package    Wp_Login_Register_Flow
 * @subpackage Wp_Login_Register_Flow/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Login_Register_Flow
 * @subpackage Wp_Login_Register_Flow/includes
 * @author     Chetan Vaghela <ckvaghela92@gmail.com>
 */
class Wp_Login_Register_Flow_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		# allow login access to already registerd user before activate plugin

		# get all users IDs
		$users = get_users( array( 'fields' => array( 'ID' ) ) );
		foreach($users as $user_id){
		   # Check user registered by WPLRF
	       $is_by_wplrf = get_user_meta ($user_id->ID,"registration_by_wplrf",true);
	       if($is_by_wplrf != "yes")
	       {
	       		# update registered by
	       	 	update_user_meta($user_id->ID,"registration_by_wplrf","no");
	       	 	# update activation key
	       	 	update_user_meta($user_id->ID,"wplrf_user_activation_key","");
	       	 	# update activation status to active
		    	update_user_meta($user_id->ID,"wplrf_user_activation_status",1);
	       }
		}

	}

}
