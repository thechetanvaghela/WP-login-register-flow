/*!
 * Custom JS
 */


/*Display Warning,errors,Success Messages*/
function toastrmsg(type,msg,title)
{
   
   toastr.options = {
      "closeButton": true,
      "debug": false,
      "tapToDismiss" : true,
      "newestOnTop": true,
      "progressBar": true,
      "positionClass": "toast-screen-center",  //"toast-top-center","toast-top-full-width","toast-bottom-center"
      "preventDuplicates": true,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    }

    toastr[type](msg,title);
}

/*Validate Email Function*/
function validateEmail($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test( $email );
}


jQuery(document).ready(function($) {

		if((window.location.href.indexOf('?wplrf_key=') > 0) && (window.location.href.indexOf('&wplrf_login=') > 0)  ) {
		    setTimeout(function() {
		     		show_wplrf_model();
		    },1000);
  		}
  		if((window.location.href.indexOf('?wplrf_activation_key=') > 0) && (window.location.href.indexOf('&wplrf_user=') > 0)  ) {
		    setTimeout(function() {		     	
		     	show_wplrf_model();
		    },1000);
  		}
  		if((window.location.href.indexOf('?wplrf_login=true') > 0) ) {
		    setTimeout(function() {
		     	show_wplrf_model();
		    },1000);
  		}
	
		function hide_wplrf_model() {
			   $(".wplrf-account-button-container").show();

			   $("#wplrf-reset-password-container").hide();
			   $("#wplrf-account-activation-container").hide();
		       $("#wplrf-login-container").hide();
		       $("#wplrf-register-container").hide();
		       $("#wplrf-lost-password-container").hide();

		       $("#wplrf-logged-user-container").hide();
		       $("#wplrf-change-password-container").hide();
		}

		function show_wplrf_model() {
        	$("#wplrf-login-container").show();
        	$("#wplrf-logged-user-container").show();
        	$("#wplrf-account-activation-container").show();
        	$("#wplrf-reset-password-container").show();
        	$(".wplrf-account-button-container").hide();
    	}

		$(document).keyup(function(e) {
	         if (e.key === "Escape") { // escape key maps to keycode `27`
	          hide_wplrf_model();
	        }
	    });

	    $(document).on('click', '.wplrf-account-btn', function (event) {
	    	show_wplrf_model();
	    });

	    $(document).on('click', '.wplrf-close-btn', function (event) {
	    	hide_wplrf_model();
	    });

	    hide_wplrf_model();
	    
        
        $(document).on('click', '#wplrf-return-to-account-btn', function (event) {
            event.preventDefault();
            $(".wplrf-modal").hide();
            $("#wplrf-logged-user-container").show();
         });

        $(document).on('click', '#wplrf-return-to-login-btn', function (event) {
            event.preventDefault();
            $(".wplrf-modal").hide();
            $("#wplrf-login-container").show();
         });
          $(document).on('click', '#wplrf-return-to-register-btn', function (event) {
            event.preventDefault();
            $(".wplrf-modal").hide();
            $("#wplrf-register-container").show();
         });
        $(document).on('click', '#wplrf-lost-password-btn', function (event) {
            event.preventDefault();
            $(".wplrf-modal").hide();
            $("#wplrf-lost-password-container").show();

         });
        $(document).on('click', '#wplrf-return-change-password-btn', function (event) {
            event.preventDefault();
            $(".wplrf-modal").hide();
            $("#wplrf-change-password-container").show();
         });

         $(document).on('click', '.activation-btns #wplrf-return-to-login', function (event) {
            event.preventDefault();
            onlyUrl = window.location.href.replace(window.location.search,'');
            setTimeout(function(){ window.location.href = onlyUrl+"?wplrf_login=true"; }, 1000);
         });
        /*Login*/
        $(document).on('click', '#wplrf-login-btn', function (event) {
            event.preventDefault();

            var username = $("#wplrf-username").val();
            var password = $("#wplrf-password").val();
            
            if($.trim(username).length == 0 && $.trim(password).length == 0)
            {
                toastrmsg('error',"Please Enter Username and Password.","Username/password"); //info,errors,warning,success
                return false;
            }
            else if($.trim(username).length == 0)
            {
               toastrmsg('error',"Please Enter Username.","Username"); //info,errors,warning,success
                return false;
            }
            else if($.trim(password).length == 0)
            {
               toastrmsg('error',"Please Enter Password.","Password"); //info,errors,warning,success
                return false;
            }
                
            $.ajax({
                url: wplrf_ajax_object.ajaxurl, // or example_ajax_obj.ajaxurl if using on frontend
                type : 'POST',
                dataType: 'JSON',
                data: {
                    'action': 'wplrf_login_request',
                    'wplrf_username' : username,
                    'wplrf_password' : password
                },
                success:function(data) {
                    // This outputs the result of the ajax request
                    toastrmsg(data.status,data.message,data.title);
                    if(data.status == "success")
                    {
                        setTimeout(function(){ location.reload(); }, 3000);
                    }

                    //data.status
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });  
                       
        });


        $("#wplrf-username , #wplrf-password").keyup(function(event) {
            if (event.keyCode === 13) {
                $("#wplrf-login-btn").click();
            }
        });


        /*Registration*/
        $(document).on('click', '#wplrf-register-btn', function (event) {
            event.preventDefault();

            var reg_username = $("#wplrf-reg-username").val();
            var reg_email = $("#wplrf-reg-email").val();
            var reg_password = $("#wplrf-reg-password").val();
            
            if($.trim(reg_username).length == 0 && $.trim(reg_email).length == 0 && $.trim(reg_password).length == 0)
            {
                toastrmsg('error',"Please Enter Username,Email and Password.","Username/Email/password"); //info,errors,warning,success
                return false;
            }
            else if($.trim(reg_username).length == 0)
            {
               toastrmsg('error',"Please Enter Username.","Username"); //info,errors,warning,success
                return false;
            }
            else if($.trim(reg_email).length == 0)
            {
               toastrmsg('error',"Please Enter Email.","Password"); //info,errors,warning,success
                return false;
            }
            else if(!validateEmail(reg_email))
            {
               toastrmsg('error',"Please Enter Valid Email.","Valid Email"); //info,errors,warning,success
                return false;
            }
            else if($.trim(reg_password).length == 0)
            {
               toastrmsg('error',"Please Enter Password.","Password"); //info,errors,warning,success
                return false;
            }
            else if($.trim(reg_password).length < 8)
            {
               toastrmsg('error',"Please Enter minimum 8 characters in Password.","Password"); //info,errors,warning,success
                return false;
            }
                
            $.ajax({
                url: wplrf_ajax_object.ajaxurl, // or example_ajax_obj.ajaxurl if using on frontend
                type : 'POST',
                dataType: 'JSON',
                data: {
                    'action': 'wplrf_register_request',
                    'wplrf_reg_username' : reg_username,
                    'wplrf_reg_email' : reg_email,
                    'wplrf_reg_password' : reg_password
                },
                success:function(data) {
                    // This outputs the result of the ajax request
                    toastrmsg(data.status,data.message,data.title);
                    if(data.status == "success")
                    {
                        //setTimeout(function(){ location.reload(); }, 3000);
                       $("#wplrf-reg-username").val("");
                       $("#wplrf-reg-email").val("");
                       $("#wplrf-reg-password").val("");
                    }

                    //data.status
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });  
                       
        });

         $("#wplrf-reg-username, #wplrf-reg-email, #wplrf-reg-password").keyup(function(event) {
            if (event.keyCode === 13) {
                $("#wplrf-register-btn").click();
            }
        });

         /*Lost Password*/
         $(document).on('click', '#wplrf-user-lost-password-btn', function (event) {
            event.preventDefault();
            var user_login = $("#wplrf_valid_user_login").val();
            //var user_nonce = $("#user-lost-password-nonce").val();
            if($.trim(user_login).length == 0)
            {
               toastrmsg('error',"Please Enter Username or Email.","Username/Email"); //info,errors,warning,success
                return false;
            }
            $.ajax({
                url: wplrf_ajax_object.ajaxurl, // or example_ajax_obj.ajaxurl if using on frontend
                type : 'POST',
                dataType: 'JSON',
                data: {
                    'action': 'wplrf_lost_password_request',
                    'wplrf_user_login' : user_login,
                    //'user_nonce' : user_nonce 
                },
                success:function(data) {
                    // This outputs the result of the ajax request
                    toastrmsg(data.status,data.message,data.title);
                    if(data.status == "success")
                    {
                        //setTimeout(function(){ location.reload(); }, 3000);
                         $("#wplrf_valid_user_login").val("");
                    }
                    //data.status
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });  
                       
        });

         $("#wplrf_valid_user_login").keyup(function(event) {
            if (event.keyCode === 13) {
                $("#wplrf-user-lost-password-btn").click();
            }
        });

         /*Reset Password*/
         $(document).on('click', '#wplrf-reset-password-btn', function (event) {
            event.preventDefault();

            var user_name = $("#wplrf_user_name").val();
            var user_key = $("#wplrf_user_key").val();
            var new_password = $("#wplrf-new-password").val();
            var confirm_password = $("#wplrf-confirm-password").val();
            
            if($.trim(new_password).length == 0 && $.trim(confirm_password).length == 0 )
            {
                toastrmsg('error',"Please Enter New Password and Confirm password.","Password"); //info,errors,warning,success
                return false;
            }
            else if($.trim(new_password).length == 0)
            {
               toastrmsg('error',"Please Enter New Password.","New Password"); //info,errors,warning,success
                return false;
            }
            else if($.trim(new_password).length < 8)
            {
               toastrmsg('error',"Please Enter minimum 8 characters in Password.","Password"); //info,errors,warning,success
                return false;
            }
            else if($.trim(confirm_password).length == 0)
            {
               toastrmsg('error',"Please Enter Confirm Password.","Confirm Password"); //info,errors,warning,success
                return false;
            }
            else if(new_password != confirm_password)
            {
               toastrmsg('error',"Password did not match.","Password"); //info,errors,warning,success
                return false;
            }
            
                
            $.ajax({
                url: wplrf_ajax_object.ajaxurl, // or example_ajax_obj.ajaxurl if using on frontend
                type : 'POST',
                dataType: 'JSON',
                data: {
                    'action': 'wplrf_reset_password_request',
                    'wplrf_new_password' : new_password,
                    'wplrf_user_name' : user_name,
                    'wplrf_user_key' : user_key,
                    'wplrf_confirm_password' : confirm_password
                },
                success:function(data) {
                    // This outputs the result of the ajax request
                    toastrmsg(data.status,data.message,data.title);
                    if(data.status == "success")
                    {
                        //setTimeout(function(){ location.reload(); }, 3000);
                       $("#wplrf-new-password").val("");
                       $("#wplrf-confirm-password").val("");
                       onlyUrl = window.location.href.replace(window.location.search,'');
                       setTimeout(function(){ window.location.href = onlyUrl+"?wplrf_login=true"; }, 3000);
                    }

                    //data.status
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });  
                       
        });

         $("#wplrf-new-password, #wplrf-confirm-password").keyup(function(event) {
            if (event.keyCode === 13) {
                $("#wplrf-reset-password-btn").click();
            }
        });


         /*Change Password*/
         $(document).on('click', '#wplrf-change-password-btn', function (event) {
            event.preventDefault();

            var get_user_id = $("#wplrf_get_user_id").val();
            var new_password = $("#wplrf-change-new-password").val();
            var confirm_password = $("#wplrf-change-confirm-password").val();
            
            if($.trim(new_password).length == 0 && $.trim(confirm_password).length == 0 )
            {
                toastrmsg('error',"Please Enter New Password and Confirm password.","Password"); //info,errors,warning,success
                return false;
            }
            else if($.trim(new_password).length == 0)
            {
               toastrmsg('error',"Please Enter New Password.","New Password"); //info,errors,warning,success
                return false;
            }
            else if($.trim(new_password).length < 8)
            {
               toastrmsg('error',"Please Enter minimum 8 characters in Password.","Password"); //info,errors,warning,success
                return false;
            }
            else if($.trim(confirm_password).length == 0)
            {
               toastrmsg('error',"Please Enter Confirm Password.","Confirm Password"); //info,errors,warning,success
                return false;
            }
            else if(new_password != confirm_password)
            {
               toastrmsg('error',"Password did not match.","Password"); //info,errors,warning,success
                return false;
            }
            
                
            $.ajax({
                url: wplrf_ajax_object.ajaxurl, // or example_ajax_obj.ajaxurl if using on frontend
                type : 'POST',
                dataType: 'JSON',
                data: {
                    'action': 'wplrf_change_password_request',
                    'wplrf_change_new_password' : new_password,
                    'wplrf_get_user_id' : get_user_id,
                    'wplrf_change_confirm_password' : confirm_password
                },
                success:function(data) {
                    // This outputs the result of the ajax request
                    toastrmsg(data.status,data.message,data.title);
                    if(data.status == "success")
                    {
                        //setTimeout(function(){ location.reload(); }, 3000);
                       $("#wplrf-change-new-password").val("");
                       $("#wplrf-change-confirm-password").val("");
                        setTimeout(function(){ location.reload(); }, 2000);
                    }

                    //data.status
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });  
                       
        });

         $("#wplrf-change-new-password, #wplrf-change-confirm-password").keyup(function(event) {
            if (event.keyCode === 13) {
                $("#wplrf-change-password-btn").click();
            }
        });


          $(document).on('click', '#wplrf_resend_activation_link', function (event) {
            event.preventDefault();
           	var wplrf_user_id = $("#wplrf_user_id").val();
            if($.trim(wplrf_user_id).length == 0)
            {
                toastrmsg('error',"Invalid User.","Resend Activation Link"); //info,errors,warning,success
                return false;
            }
            
            $.ajax({
                url: wplrf_ajax_object.ajaxurl, // or example_ajax_obj.ajaxurl if using on frontend
                type : 'POST',
                dataType: 'JSON',
                data: {
                    'action': 'wplrf_activation_email_to_new_user',
                    'wplrf_user_id' : wplrf_user_id,
                },
                success:function(data) {
                	//console.log(data);
                    // This outputs the result of the ajax request
                    toastrmsg(data.status,data.message,data.title);
                    if(data.status == "success")
                    {
                      
                       //onlyUrl = window.location.href.replace(window.location.search,'');
                       //setTimeout(function(){ window.location.href = onlyUrl+"?wplrf_login=true"; }, 3000);
                    }

                    //data.status
                },
                error: function(errorThrown){
                    console.log(errorThrown);
                }
            });  
         });
    
});