<?php

/*  
 #	function used for Login
 #	@return messages
 #	function name wplrf_login_request
*/
add_action( 'wp_ajax_nopriv_wplrf_login_request', 'wplrf_login_request' );
add_action( 'wp_ajax_wplrf_login_request', 'wplrf_login_request' );

function wplrf_login_request() 
{
	# check username and password
	if(isset($_POST['wplrf_username']) && isset($_POST['wplrf_password']) ) 
	{
		# define empty varibles
		$data = array();
      	$status = $message = $title = $msg_text = "";

      	# get post value using sanitize_text_field
		$username = sanitize_text_field($_POST['wplrf_username']);
      	$password = sanitize_text_field($_POST['wplrf_password']);

      	# check username empty or not
      	if(empty($username))
      	{
        	$status  = "error";
        	$message = "Please Enter UserName.";
        	$title  = "Username";	
      	} # check password empty or not
      	else if(empty($password))
      	{
      		$status     = "error";
            $message  = "Please Enter Password.";
            $title   = "Password";
	        
	    }
      	else
      	{ 
      		# check username or email exists or not
	      	if ( email_exists( $username ) || username_exists( $username ) ) 
	      	{
	      		# check entered value email or not
	      		if(is_email($username))
			    {
			    	$getuser = get_user_by( 'email',$username );
			    }
			    else
			    {
			    	$getuser = get_user_by('login', $username);
			    }
	      		
	      		# get user id
				$get_user_id = $getuser->ID;
				
				# get user activation status
				$actvation_status = esc_attr(get_user_meta($get_user_id,"wplrf_user_activation_status",true));
				# get user block status
	      		$block_status = esc_attr(get_user_meta($get_user_id,"wplrf_user_status_block",true));

	      		# check user activation status
				if(empty($actvation_status))
				{
					$status  = "error";
			        $msg_text = "Your account is not activate. Please active your account using activation link which is sent by email.";
			        $title   = "Account Activation Required";
			        $message = strip_tags(apply_filters( 'wplrf_account_activation_text', $msg_text ));
				}
				elseif($block_status == "yes")
				{
					$status  = "error";
			        $msg_text = "It looks like your account has been blocked. Please contact your admin to unblock it.";
			        $title   = "Account Blocked";
			        $message = strip_tags(apply_filters( 'wplrf_account_blocked_text', $msg_text ));
				}
				else
				{
				    # logged in current user
				    $creds = array('user_login' => $username, 'user_password' =>  $password, 'remember' => true );
				    $user = wp_signon( $creds, false );
				    # set loggin as current logged user
				    wp_set_current_user($user->ID); 
				    wp_set_auth_cookie($user->ID, true, false );    
				    do_action( 'wp_login', $username );

				    # check if sussess logged in or not
				    if ( is_wp_error($user) )
				    {
				        //echo $user->get_error_message();
				        if('incorrect_password' == $user->get_error_code())
				        {
				        	$msg_text = "The password you entered for the username $username is incorrect. ";
				        	$message = strip_tags(apply_filters( 'wplrf_account_incorect_password_text', $msg_text ));
				        }
				        else
				        {
				        	$message =  $user->get_error_message();
				       	}
			            $status   = "error";
			            $title    = "Login Failed";			        
				    }
				    else
				    {
				    	$status     = "success";
			            $msg_text  = "Login successfully.";
			            $message = strip_tags(apply_filters( 'wplrf_account_login_success_text', $msg_text ));
			            $title  = "Login";
				    }
				}
		  	}
		  	else
		  	{
		  		$status  = "error";
		        $msg_text = "Invalid Username or Email.";
		        $message = strip_tags(apply_filters( 'wplrf_account_invalid_user_text', $msg_text ));
		        $title   = "User";
		  	}
		}
	}
	else
	{
		$message =  "Something Wrong.";
	    $status    = "error";
        $title   = "Something Wrong!";
	}

	$data = array(
            "status"     => $status,
            "message"  => $message,
            "title"   => $title
	        );
    echo json_encode($data);
    wp_die();
}

/*  
 #	function used for user registration
 #	@return messages
 #	function name wplrf_register_request
*/
add_action( 'wp_ajax_nopriv_wplrf_register_request', 'wplrf_register_request' );
add_action( 'wp_ajax_wplrf_register_request', 'wplrf_register_request' );

function wplrf_register_request() 
{
	# check username, emai; and password
	if(isset($_POST['wplrf_reg_username']) && isset($_POST['wplrf_reg_email']) && isset($_POST['wplrf_reg_password']) ) 
	{
		# get post value using sanitize_text_field
		$reg_username = sanitize_text_field($_POST['wplrf_reg_username']);
      	$reg_email = sanitize_text_field( $_POST['wplrf_reg_email']);
      	$reg_password = sanitize_text_field($_POST['wplrf_reg_password']);

      	# define empty variables
      	$data = array();
      	$status = $message = $title = $msg_text = "";
     
     	# validations
      	if(empty($reg_username))
      	{
      		$status  = "error";
        	$message = "Please Enter Username.";
        	$title  = "Username";
      	}
      	else if(username_exists( $reg_username))
	    {
	    	$status     = "error";
            $msg_text  = "Username Already exists, Try Different userame.";
            $message = strip_tags(apply_filters( 'wplrf_username_already_exists_text', $msg_text ));
            $title   = "Username";
	    }
      	else if(empty($reg_email))
      	{
	      	$status     = "error";
            $message  = "Please Enter Email.";
            $title   = "Email";
	    }
	    else if(!is_email($reg_email))
      	{
	      	$status     = "error";
            $message  = "Please Enter Valid Email.";
            $title   = "Valid Email";
	    }
	    else if(email_exists( $reg_email))
	    {
	    	$status     = "error";
            $message  = "Email Already exists, Try Different Email.";
            $message = strip_tags(apply_filters( 'wplrf_email_already_exists_text', $msg_text ));
            $title   = "Password";
	    }
      	else if(empty($reg_password))
      	{
      		$status     = "error";
            $message  = "Please Enter Password.";
            $title   = "Password";
	    }
	    else if(strlen($reg_password) < 8)
      	{
      		$status     = "error";
            $message  = "Please enter minimum 8 characters in Password.";
            $title   = "Password";
	    }
      	else
      	{ 
      		# arguments for insert user
      		$WP_array = array (
		        'user_login'    =>  $reg_username,
		        'user_email'    =>  $reg_email,
		        'user_pass'     =>  $reg_password,
		    ) ;
      		# insert user into database
		    $user_id = wp_insert_user( $WP_array ) ;
		    
		    # get predefined role by WPLRF admin settings
		    $wplrf_user_role = esc_attr(get_option('wplrf-account-user-role'));
		    # if empty then role set as subscriber
		    $selected_role = !empty($wplrf_user_role) ? $wplrf_user_role : "subscriber";
		    # update user role
		    wp_update_user( array ('ID' => $user_id, 'role' => $selected_role) ) ;

		    # check is user success
		    if( is_wp_error( $user_id  ) ) {
			    $message =  $user_id->get_error_message();
			    $status     = "error";
	            $title   = "Registration Failed";
			}
			else
			{
				$msg_text =  "Registration successfully.";
				$message = strip_tags(apply_filters( 'wplrf_account_register_success_text', $msg_text ));
			    $status    = "success";
	            $title   = "Registration";
	            
	            # update registered by WPLRD plugin yes
	            update_user_meta($user_id,"registration_by_wplrf","yes");
	            # by default user is not blocked
	            update_user_meta($user_id,"wplrf_user_status_block","no");

	            #Account Activation Email to user
	            $send_activation_email = wplrf_activation_email_to_new_user($user_id);
	            if($send_activation_email)
	            {
	            	$msg_text .= " Email has been successfully sent."; //. to user whose email is $reg_email;
	            	$message = strip_tags(apply_filters( 'wplrf_register_successed_email_text', $msg_text ));
	            }
	            else
	            {
	            	$msg_text .= " Email failed to sent";  //to user whose email is . $reg_email;
	            	$message = strip_tags(apply_filters( 'wplrf_register_failed_email_text', $msg_text ));
	            }

	            # getWelcome Email to user from settings
	            $send_mail = esc_attr(get_option('wplrf-account-send-mail'));
	            if(!empty($send_mail) && $send_mail == "yes"){	
	            	
	            	# Send Welcome Mail
	            	$sent_email = wplrf_send_welcome_email_to_new_user($user_id);
		            if($sent_email)
		            {
		            	$msg_text .= " Email has been successfully sent to user whose email is " . $reg_email;
		            	$message = strip_tags(apply_filters( 'wplrf_welcome_email_success_text', $msg_text ));
		            }
		            else
		            {
		            	$msg_text .= " Email failed to sent to user whose email is " . $reg_email;
		            	$message = strip_tags(apply_filters( 'wplrf_welcome_email_failed_text', $msg_text ));
		            }
	        	}
			}
		}
	}
	else
	{
		$message =  "Something Wrong.";
	    $status    = "error";
        $title   = "Something Wrong!";
	}

	$data = array(
		            "status"     => $status,
		            "message"  => $message,
		            "title"   => $title
			        );
    echo json_encode($data);
    wp_die();
}


/*  
*	function used for Lost password reset
*	@return messages
*	function name wplrf_lost_password_request
*/
add_action( 'wp_ajax_nopriv_wplrf_lost_password_request', 'wplrf_lost_password_request' );
add_action( 'wp_ajax_wplrf_lost_password_request', 'wplrf_lost_password_request' );

function wplrf_lost_password_request() 
{
	if(isset($_POST['wplrf_user_login'])) 
	{
		$user_login = sanitize_text_field($_POST['wplrf_user_login']);
      	
      	$data = array();
      	$status = $message = $title = "";
      
      	if(empty($user_login))
      	{
        	$status  = "error";
        	$message = "Please Enter Username or Email.";
        	$title  = "Username";
        	
      	}
      	else
      	{ 
	      	if ( email_exists( $user_login ) || username_exists( $user_login ) ) 
	      	{
			    // Stuff to do when email address exists
			    if(is_email($user_login))
			    {
			    	$user = get_user_by( 'email',$user_login );
			    }
			    else
			    {
			    	$user = get_user_by('login', $user_login);
			    }
	      		
				$user_id = $user->ID;
   				$user_email = $user->user_email;
			    $sent_email = wplrf_send_password_reset_mail($user_id);
			    if($sent_email)
	            {
	            	$msg_text = " Email has been successfully sent to user.";//whose email is  . $user_email;
	            	$message = strip_tags(apply_filters( 'wplrf_lost_pass_mail_success_send_text', $msg_text ));
	            }
	            else
	            {
	            	$msg_text = " Email failed to sent to user.";//whose email is . $user_email;
	            	$message = strip_tags(apply_filters( 'wplrf_lost_pass_mail_fail_send_text', $msg_text ));
	            }
	            $status  = "success";
        		$title  = "Lost Password";
		  	}
		  	else
		  	{
	            $status  = "error";
	            $message = "Invalid username or email.";
	            $title   = "Invalid";
		  	}
		}
	}
	else
	{
		$message =  "Something Wrong.";
	    $status    = "error";
        $title   = "Something Wrong!";
	}

	$data = array(
        "status"     => $status,
        "message"  => $message,
        "title"   => $title
        );
    echo json_encode($data);
    wp_die();
}

/*  
*	function used for Reset password 
*	@return messages
*	function name wplrf_reset_password_request
*/
add_action( 'wp_ajax_nopriv_wplrf_reset_password_request', 'wplrf_reset_password_request' );
add_action( 'wp_ajax_wplrf_reset_password_request', 'wplrf_reset_password_request' );

function wplrf_reset_password_request() 
{

	if(isset($_POST['wplrf_new_password']) && isset($_POST['wplrf_confirm_password']) && isset($_POST['wplrf_user_name']) && isset($_POST['wplrf_user_key']) ) 
	{
		$user_name = sanitize_text_field($_POST['wplrf_user_name']);
		$user_key = sanitize_text_field($_POST['wplrf_user_key']);
		$new_password = sanitize_text_field($_POST['wplrf_new_password']);
      	$confirm_password = sanitize_text_field($_POST['wplrf_confirm_password']);

      	$data = array();
      	$status = $message = $title = "";
      
		if(!username_exists( $user_name))
	    {
	    	$status     = "error";
            $message  = "Username Not exists.";
            $title   = "Username";
	    }
      	else if(empty($new_password))
      	{
      		$status  = "error";
        	$message = "Please Enter New Password.";
        	$title  = "Username";
      	}
      	else if(empty($confirm_password))
      	{
      		$status  = "error";
        	$message = "Please Enter Confirm Password.";
        	$title  = "Username";
      	}
      	else if(strlen($new_password) < 8)
      	{
      		$status     = "error";
            $message  = "Please Enter minimum 8 characters in Password.";
            $title   = "Password";
	      	
	    }
      	else if($new_password != $confirm_password)
	    {
	    	$status     = "error";
            $message  = "Password did not match.";
            $title   = "Password";
	    }
      	else
      	{
      		$user_logded = get_user_by('login', $user_name);
      		$user_id = $user_logded->ID;
		    
      		 // Verify key / login combo
	        $user = check_password_reset_key( $user_key, $user_name);
	        if ( ! $user || is_wp_error( $user ) ) {
	            if ( $user && $user->get_error_code() === 'expired_key' ) {
	            	$msg_text =  "Key Expired.";
	            	$message = strip_tags(apply_filters( 'wplrf_reset_pass_expired_key_text', $msg_text ));
				    $status    = "error";
		            $title   = "Key Expired";
	                //wp_redirect( home_url( 'member-login?login=expiredkey' ) );
	            } else {
	            	$msg_text =  "Invalid Key.";
	            	$message = strip_tags(apply_filters( 'wplrf_reset_pass_invalid_key_text', $msg_text ));
				    $status    = "error";
		            $title   = "Key Invalid";
	                //wp_redirect( home_url( 'member-login?login=invalidkey' ) );
	            }
	            //exit;
	        }
	        else
	        {
			    wp_update_user(array('ID' => $user_id, 'user_pass' => $new_password));

			    if( is_wp_error( $user_id  ) ) {
				    $message =  $user_id->get_error_message();
				    $status     = "error";
		            $title   = "Failed";
				}
				else
				{
					$msg_text =  "Password Reset successfully.";
					$message = strip_tags(apply_filters( 'wplrf_reset_pass_success_text', $msg_text ));
				    $status    = "success";
		            $title   = "Reset Password";
		            
				}
			}
		}
	}
	else
	{
		$message =  "Something Wrong.";
	    $status    = "error";
        $title   = "Something Wrong!";
	}

	$data = array(
            "status"     => $status,
            "message"  => $message,
            "title"   => $title
	        );
    echo json_encode($data);
    wp_die();
}


/*  
*	function used for Change password 
*	@return messages
*	function name wplrf_change_password_request
*/
add_action( 'wp_ajax_nopriv_wplrf_change_password_request', 'wplrf_change_password_request' );
add_action( 'wp_ajax_wplrf_change_password_request', 'wplrf_change_password_request' );

function wplrf_change_password_request() 
{

	if(isset($_POST['wplrf_change_new_password']) && isset($_POST['wplrf_change_confirm_password']) && isset($_POST['wplrf_get_user_id']) ) 
	{
		$get_user_id = sanitize_text_field($_POST['wplrf_get_user_id']);
		$new_password = sanitize_text_field($_POST['wplrf_change_new_password']);
      	$confirm_password = sanitize_text_field($_POST['wplrf_change_confirm_password']);

      	$data = array();
      	$status = $message = $title = "";
      
		if(empty($new_password))
      	{
      		$status  = "error";
        	$message = "Please Enter New Password.";
        	$title  = "Username";
      	}
      	else if(empty($confirm_password))
      	{
      		$status  = "error";
        	$message = "Please Enter Confirm Password.";
        	$title  = "Username";
      	}
      	else if(strlen($new_password) < 8)
      	{
      		$status     = "error";
            $message  = "Please Enter minimum 8 characters in Password.";
            $title   = "Password";
	      	
	    }
      	else if($new_password != $confirm_password)
	    {
	    	$status     = "error";
            $message  = "Password did not match.";
            $title   = "Password";
	    }
      	else
      	{ 
      		// Get current logged-in user.
			$user = wp_get_current_user();
			// Change password.
			wp_set_password($new_password, $user->ID);
			// Log-in again.
		    $user_id= $user->ID;
		    if( is_wp_error( $user_id  ) ) {
			    $message =  $user_id->get_error_message();
			    $status     = "error";
	            $title   = "Failed";
			}
			else
			{
				wp_set_auth_cookie($user->ID);
				wp_set_current_user($user->ID);
				do_action('wp_login', $user->user_login, $user);
				$msg_text =  "Password Reset successfully.".$user_login;
				$message = strip_tags(apply_filters( 'wplrf_change_pass_success_text', $msg_text ));
			    $status    = "success";
	            $title   = "Reset Password";
			}
		}
	}
	else
	{
		$message =  "Something Wrong.";
	    $status    = "error";
        $title   = "Something Wrong!";
	}

	$data = array(
            "status"     => $status,
            "message"  => $message,
            "title"   => $title
	        );
    echo json_encode($data);
    wp_die();
}
/*  
*	function used for Send Account Activation email
*	@return messages
*	function name wplrf_activation_email_to_new_user
*/
add_action( 'wp_ajax_nopriv_wplrf_activation_email_to_new_user', 'wplrf_activation_email_to_new_user' );
add_action( 'wp_ajax_wplrf_activation_email_to_new_user', 'wplrf_activation_email_to_new_user' );

function wplrf_activation_email_to_new_user($user_id) {
		
		if(isset($_POST['wplrf_user_id']) && !empty($_POST['wplrf_user_id'])) 
		{
			$user_id = sanitize_text_field($_POST['wplrf_user_id']);
		}
		//$user = get_userdata($user_id);
		$user = get_user_by('id', $user_id);
        $user_email = $user->user_email;  
        $user_login = $user->user_login;
       
        $code = sha1( $user_id . time() );  
        //$code = get_password_reset_key( $user );
       
        update_user_meta($user_id,"wplrf_user_activation_status",0);
        update_user_meta($user_id,"wplrf_user_activation_key",$code);

        $activation_url = esc_url_raw(home_url()."/?wplrf_activation_key=$code&wplrf_user=" . $user_id);
        $activation_link = '<a href="'.$activation_url.'">'.$activation_url.'</a>';
         
        
	    $body = "Hi ".$user_login.",<br>";
	    $body .= "Click here to active your account: <br>";
	    $body .= $activation_link.'<br>';	  
      	$subject = "Activation link";
    	$headers = array('Content-Type: text/html; charset=UTF-8');
        if (wp_mail($user_email, $subject, $body, $headers)) {
	     	 //error_log("email has been successfully sent to user whose email is " . $user_email);
        	if(isset($_POST['wplrf_user_id']) && !empty($_POST['wplrf_user_id'])) 
			{
				if ( $user === false ) {
					$status     = "error";
		            $message  = "Can not find user.";
		            $title   = "User Not Valid";
				}
				else
				{
					$status     = "success";
		            $msg_text  = "Activation Link Sent via email. Please check your email and active account.";
		            $message = strip_tags(apply_filters( 'wplrf_activation_link_send_success_text', $msg_text ));

		            $title   = "Mail Sent";
	           	}
				$data = array(
			            "status"     => $status,
			            "message"  => $message,
			            "title"   => $title
				        );
			    echo json_encode($data);
			    wp_die();
			}
			else
			{
	      		return true;
	      	}
	    }else{
	      	if(isset($_POST['wplrf_user_id']) && !empty($_POST['wplrf_user_id'])) 
			{
				if ( $user === false ) {
					$status     = "error";
		            $message  = "Can not find user.";
		            $title   = "User Not Valid";
				}
				else
				{
					$message =  "Something Wrong.";
				    $status    = "error";
			        $title   = "Something Wrong!";
	           	}
				$data = array(
			            "status"     => $status,
			            "message"  => $message,
			            "title"   => $title
				        );
			    echo json_encode($data);
			    wp_die();
			}
			else
			{
	      		return false;
	      	}
	    }


}
/*  
*	function used for Send welcome email
*	@return messages
*	function name wplrf_send_welcome_email_to_new_user
*/
function wplrf_send_welcome_email_to_new_user($user_id) {
    $user = get_userdata($user_id);
    $user_email = $user->user_email;
    // for simplicity, lets assume that user has typed their first and last name when they sign up
    //$user_full_name = $user->user_firstname . $user->user_lastname;
    $user_full_name = $user->user_login;

    // Now we are ready to build our welcome email
    $to = $user_email;
    $subject = "Hi " . $user_full_name . ", welcome to our site!";
    $body = '
              <h1>Dear ' . $user_full_name . ',</h1></br>
              <p>Thank you for joining our site. Your account is now active.</p>
              <p>Please go ahead and navigate around your account.</p>
              <p>Let me know if you have further questions, I am here to help.</p>
              <p>Enjoy the rest of your day!</p>
              <p>Kind Regards,</p>
              <p>WPLRF</p>
    ';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    if (wp_mail($to, $subject, $body, $headers)) {
     	 //error_log("email has been successfully sent to user whose email is " . $user_email);
      return true;
    }else{
      	//error_log("email failed to sent to user whose email is " . $user_email);
      	return false;
    }
}

/*  
*	function used for Send password reset email
*	@return messages
*	function name wplrf_send_password_reset_mail
*/
function wplrf_send_password_reset_mail($user_id){

    $user = get_user_by('id', $user_id);
    $firstname = $user->first_name;
    $email = $user->user_email;
    $reset_pass_key = get_password_reset_key( $user );
    $user_login = $user->user_login;
    $rp_link = '<a href="' . home_url()."/?wplrf_key=$reset_pass_key&wplrf_login=" . rawurlencode($user_login) . '">' . home_url()."/?wplrf_key=$reset_pass_key&wplrf_login=" . rawurlencode($user_login) . '</a>';

    if ($firstname == "") $firstname = "User";
    $message = "Hi ".$firstname.",<br>";
    $message .= "Click here to Reset the password for your account: <br>";
    $message .= $rp_link.'<br>';

    //deze functie moet je zelf nog toevoegen. 
   $subject = __("Your account on ".get_bloginfo( 'name'));
   $headers = array();

   add_filter( 'wp_mail_content_type', function( $content_type ) {return 'text/html';});
   $headers[] = 'From: '.get_bloginfo( 'name').' <info@your-domain.com>'."\r\n";
   if(wp_mail( $email, $subject, $message, $headers))
   {
   		return $rp_link;
   }
   else
   {
   		return $rp_link;
   }
   // Reset content-type to avoid conflicts -- http://core.trac.wordpress.org/ticket/23578
   remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
}