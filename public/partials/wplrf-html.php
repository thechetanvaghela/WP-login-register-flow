<?php 
	
	if (!is_user_logged_in()) 
	{ 
		?>
		<div class="wplrf-model-html-wrapper" id="wplrf-model-html-wrapper">
		<?php if(isset($_GET['wplrf_login']) && !empty($_GET['wplrf_login']) && isset($_GET['wplrf_key']) && !empty($_GET['wplrf_key']))
		{
			?>
			<div id="wplrf-model-html">
				<div id="wplrf-reset-password-container" class="wplrf-modal">
					<div id="" class="wplrf-modal-content animate">
						<div class="wplrf-modal-heading">
							<h2><?php esc_html_e( 'Reset Password', 'wplrf' ); ?></h2>
						</div>
						<form class="reset-password" method="post">
							<div class="wplrf-container"> 
							<p class="">
								<input type="password" class="wplrf-input-text" name="wplrf-new-password" id="wplrf-new-password" value="<?php echo ( ! empty( $_POST['wplrf-new-password'] ) ) ? esc_attr( wp_unslash( $_POST['wplrf-new-password'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'New Password', 'wplrf' ); ?>" />
							</p>
							<p class="">
								<input class="wplrf-input-text" type="password" name="wplrf-confirm-password" id="wplrf-confirm-password" placeholder="<?php esc_html_e( 'Confirm password', 'wplrf' ); ?>" />
							</p>
							<p class="">
								<input type="hidden" id="wplrf_user_name" value="<?php echo esc_attr($_GET['wplrf_login']); ?>" />
								<input type="hidden" id="wplrf_user_key" value="<?php echo esc_attr($_GET['wplrf_key']); ?>" />
								<button type="button" class="button" id="wplrf-reset-password-btn" name="wplrf-reset-password" value="<?php esc_attr_e( 'Reset Password', 'wplrf' ); ?>"><?php esc_html_e( 'Reset Password', 'wplrf' ); ?></button>
							</p>
							<p class="">
							<button type="button" class="button wplrf-close-btn" name="wplrf-close-btn" value="<?php esc_attr_e( 'Close', 'wplrf' ); ?>"><?php esc_html_e( 'Close', 'wplrf' ); ?></button>
							</p>
							</div>			
						</form>
					</div>
				</div>
			</div>
			<?php
		}
		elseif(isset($_GET['wplrf_activation_key']) && !empty($_GET['wplrf_activation_key']) && isset($_GET['wplrf_user']) && !empty($_GET['wplrf_user']))
		{
			global $wpdb;
			$actvation_key = esc_attr(get_user_meta($_GET['wplrf_user'],"wplrf_user_activation_key",true));
			$actvation_status = esc_attr(get_user_meta($_GET['wplrf_user'],"wplrf_user_activation_status",true));

			$resend_activation_link = false; 
	        if (!empty($actvation_status) && empty($actvation_key)) {
            	$reason =  "Already Activated";
            	$message =  "Your account already Activated.";
			    $msg_status  = "wplrf-error";
	        }
	         elseif (empty($actvation_status) && empty($actvation_key)) {
            	$reason =  "Activation Key Expired.";
            	$message =  "Your Activation Key has been Expired.";
			    $msg_status    = "wplrf-error";
			    $resend_activation_link = true; 
	        }
	        elseif ($actvation_key != $_GET['wplrf_activation_key'])
	        {
	        	$message =  "Your Activation Key is Invalid.";
            	$reason =  "Invalid Key.";
			    $msg_status    = "wplrf-error";
			    $resend_activation_link = true; 
	        }
	        elseif ($actvation_key == $_GET['wplrf_activation_key'] && empty($actvation_status))
	        {
			    update_user_meta($_GET['wplrf_user'],"wplrf_user_activation_key","");
			    update_user_meta($_GET['wplrf_user'],"wplrf_user_activation_status",1);
				$message =  "Your account has been activated successfully.";
				$reason =  "Account Activation.";
			    $msg_status    = "wplrf-success";
			}
			?>
			<div id="wplrf-model-html">
				<div id="wplrf-account-activation-container" class="wplrf-modal">
					<div id="" class="wplrf-modal-content animate">
						<div class="wplrf-modal-heading">
							<h2><?php esc_html_e( $reason, 'wplrf' ); ?></h2>
						</div>
							<div class="wplrf-container"> 
							<p class="<?php echo $msg_status; ?>">
								<?php esc_html_e( $message, 'wplrf' ); ?>
							</p>
							<?php 
							if($resend_activation_link)
							{
								?><p>
									<input type="hidden" id="wplrf_user_id" value="<?php echo esc_attr($_GET['wplrf_user']); ?>" />
									<button type="button" class="button" id="wplrf_resend_activation_link" value="<?php esc_attr_e( 'Resend Activation Link', 'wplrf' ); ?>"><?php esc_html_e( 'Resend Activation Link', 'wplrf' ); ?></button>
								</p>
								<?php
							}
							else
							{
							?>
							<p class="activation-btns">
								<button type="button" class="button" id="wplrf-return-to-login" value="<?php esc_attr_e( 'Return To Login', 'wplrf' ); ?>"><?php esc_html_e( 'Return To Login', 'wplrf' ); ?></button>
								<!-- <a href="javascript:void(0);" id="wplrf-return-to-login"><?php esc_html_e( 'Return To Login', 'wplrf' ); ?></a> -->
							</p>
							<?php 
							}
							?>
							<p class="">
							<button type="button" class="button wplrf-close-btn" name="wplrf-close-btn" value="<?php esc_attr_e( 'Close', 'wplrf' ); ?>"><?php esc_html_e( 'Close', 'wplrf' ); ?></button>
							</p>
							</div>	
					</div>
				</div>
			</div>
			<?php
		}
		else
		{
			$allow_register = esc_attr(get_option('wplrf-account-allow-register'));
			$allow_register = !empty($allow_register) ? $allow_register : "no";
		?>
		<div id="wplrf-model-html"> 
			<div id="wplrf-login-container" class="wplrf-modal"> 
		 		<div  class="wplrf-modal-content animate">
		 			<div  class="wplrf-modal-heading">
						<h2><?php esc_html_e( 'Login', 'wplrf' ); ?></h2>
					</div>
					<form class="wplrf-login" method="post">
						<div class="wplrf-container"> 
						<p class="">
							<!-- <label for="wplrf-username"><?php //esc_html_e( 'Username or email address', 'wplrf' ); ?>&nbsp;<span class="required">*</span></label> -->
							<input type="text" class="wplrf-input-text" name="wplrf-username" id="wplrf-username" value="<?php echo ( ! empty( $_POST['wplrf-username'] ) ) ? esc_attr( wp_unslash( $_POST['wplrf-username'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Username or email address', 'wplrf' ); ?>" />
						</p>
						<p class="">
							<!-- <label for="wplrf-password"><?php //esc_html_e( 'Password', 'wplrf' ); ?>&nbsp;<span class="required">*</span></label> -->
							<input class="wplrf-input-text" type="password" name="wplrf-password" id="wplrf-password"  placeholder="<?php esc_html_e( 'Password', 'wplrf' ); ?>" />
						</p>
						<p class="">
							<?php wp_nonce_field( 'wplrf-login', 'wplrf-login-nonce' ); ?>
							<button type="button" class="button" id="wplrf-login-btn" name="login" value="<?php esc_attr_e( 'Log in', 'wplrf' ); ?>"><?php esc_html_e( 'Log in', 'wplrf' ); ?></button>
						</p>
						<p class="lost_password">
							<a href="javascript:void(0);" id="wplrf-lost-password-btn"><?php esc_html_e( 'Lost your password?', 'wplrf' ); ?></a>
							<?php if(!empty($allow_register) && $allow_register == "yes"){ ?> | 
							<a href="javascript:void(0);" id="wplrf-return-to-register-btn"><?php esc_html_e( 'Register', 'wplrf' ); ?></a>
							<?php } ?>
						</p>
						<p class="">
							<button type="button" class="button wplrf-close-btn" name="wplrf-close-btn" value="<?php esc_attr_e( 'Close', 'wplrf' ); ?>"><?php esc_html_e( 'Close', 'wplrf' ); ?></button>
						</p>
						</div>
					</form>
				</div>
			</div>
			<?php if(!empty($allow_register) && $allow_register == "yes"){ ?>
			<div id="wplrf-register-container" class="wplrf-modal"> 
				<div class="wplrf-modal-content animate">
					<div  class="wplrf-modal-heading">
						<h2><?php esc_html_e( 'Register', 'wplrf' ); ?></h2>
					</div>
					<form method="post" class="register wplrf-register">
						<div class="wplrf-container"> 
						<p class="">
							<!-- <label for="wplrf-reg-username"><?php //esc_html_e( 'Username', 'wplrf' ); ?>&nbsp;<span class="required">*</span></label> -->
							<input type="text" class="wplrf-input-text" name="wplrf-reg-username" id="wplrf-reg-username" value="<?php echo ( ! empty( $_POST['wplrf-reg-username'] ) ) ? esc_attr( wp_unslash( $_POST['wplrf-reg-username'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Username', 'wplrf' ); ?>"/>
						</p>
						<p class="">
							<!-- <label for="wplrf-reg-email"><?php //esc_html_e( 'Email address', 'wplrf' ); ?>&nbsp;<span class="required">*</span></label> -->
							<input type="email" class="wplrf-input-text" name="email" id="wplrf-reg-email" value="<?php echo ( ! empty( $_POST['wplrf-reg-email'] ) ) ? esc_attr( wp_unslash( $_POST['wplrf-reg-email'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'Email address', 'wplrf' ); ?>"/>
						</p>
						<p class="">
							<!-- <label for="wplrf-reg-password"><?php //esc_html_e( 'Password', 'wplrf' ); ?>&nbsp;<span class="required">*</span></label> -->
							<input type="password" class="wplrf-input-text" name="wplrf-reg-password" id="wplrf-reg-password" placeholder="<?php esc_html_e( 'Password', 'wplrf' ); ?>"/>
						</p>
						<p class="">
							<?php wp_nonce_field( 'wplrf-register', 'wplrf-register-nonce' ); ?>
							<button type="button" class="button" name="wplrf-register-btn" id="wplrf-register-btn" value="<?php esc_attr_e( 'Register', 'wplrf' ); ?>"><?php esc_html_e( 'Register', 'wplrf' ); ?></button>
						</p>
						<p class="return-btns">
							<a href="javascript:void(0);" id="wplrf-return-to-login-btn"><?php esc_html_e( 'Return To Login', 'wplrf' ); ?></a>
						</p>
						<p class="">
							<button type="button" class="button wplrf-close-btn" name="wplrf-close-btn" value="<?php esc_attr_e( 'Close', 'wplrf' ); ?>"><?php esc_html_e( 'Close', 'wplrf' ); ?></button>
						</p>
						</div>
					</form>
				</div>	
			</div>	
			<?php } ?>
			<div id="wplrf-lost-password-container" class="wplrf-modal"> 
				<div class="wplrf-modal-content animate">
					<div  class="wplrf-modal-heading">
			        <h2><?php esc_html_e( 'Lost Password', 'wplrf' ); ?></h2>	  
			        </div>  
			      	<form method="post" class="lost_reset_password" onsubmit="return false;">
			      		<div class="wplrf-container"> 
			      		<?php 
			      		$lostpasstxt = 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.';
			      		$lostpasstxt = strip_tags(apply_filters( 'wplrf_lost_pass_popup_text', $lostpasstxt )); ?>
						<p><?php echo __( $lostpasstxt, 'wplrf' ) ; ?></p>

						<p class="">
							<!-- <label for="wplrf_valid_user_login"><?php //esc_html_e( 'Username or email', 'wplrf' ); ?></label> -->
							<input class="wplrf-input-text" type="text" name="wplrf_valid_user_login" id="wplrf_valid_user_login" placeholder="<?php esc_html_e( 'Username or email', 'wplrf' ); ?>" />
						</p>
						<div class="clear"></div>
						<p class="">
							<button type="button" class="button" id="wplrf-user-lost-password-btn" value="<?php esc_attr_e( 'Reset password', 'wplrf' ); ?>"><?php esc_html_e( 'Reset password', 'wplrf' ); ?></button>
						</p>
						<p class="return-btns">
							<a href="javascript:void(0);" id="wplrf-return-to-login-btn"><?php esc_html_e( 'Return To Login', 'wplrf' ); ?></a> 
							<?php if(!empty($allow_register) && $allow_register == "yes"){ ?> |  
							<a href="javascript:void(0);" id="wplrf-return-to-register-btn"><?php esc_html_e( 'Register', 'wplrf' ); ?></a>
							<?php } ?>
						</p>
						<p class="">
							<button type="button" class="button wplrf-close-btn" name="wplrf-close-btn" value="<?php esc_attr_e( 'Close', 'wplrf' ); ?>"><?php esc_html_e( 'Close', 'wplrf' ); ?></button>
						</p>
						</div>
					</form>
				</div>
			</div>
		</div>
		<?php
		}
		?>
		</div>
	<?php 
	}
	else
	{
		?>
		<div class="wplrf-model-html-wrapper" id="wplrf-model-html-wrapper">
			<?php global $userdata,$user_identity; ?>
			<div class="wplrf-modal" id="wplrf-logged-user-container">
				<div class="wplrf-modal-content animate" id="logged-user ">
					<div  class="wplrf-modal-heading">
						<h3>Welcome, <?php echo $user_identity; ?></h3>
					</div>
				<div class="wplrf-container"> 
					<div class="wplrf-usericon">
						<p class="">
						<?php echo get_avatar($userdata->ID, 60); ?>
						</p>
					</div>
					<div class="userinfo">
						<p>You&rsquo;re logged in as <strong><?php echo $user_identity; ?></strong></p>
						<p>
						<?php 
						echo '<a href="javascript:void(0);" id="wplrf-return-change-password-btn">'.esc_html( 'Change Password', 'wplrf' ).'</a>';  
						?>
							| <a href="<?php echo wp_logout_url(home_url()); ?>" title="Logout">Logout</a>

						</p>
						<p class="">
							<button type="button" class="button wplrf-close-btn" name="wplrf-close-btn" value="<?php esc_attr_e( 'Close', 'wplrf' ); ?>"><?php esc_html_e( 'Close', 'wplrf' ); ?></button>
						</p>
					</div>
				</div>
				</div>
			</div>

			<div id="wplrf-change-password-container" class="wplrf-modal"> 
				<div  class="wplrf-modal-content animate">
						<div  class="wplrf-modal-heading">
							<h3><?php esc_attr_e( 'Change Password', 'wplrf' ); ?></h3>
						</div>
				      <form class="change-password" method="post">
				      	<div class="wplrf-container"> 
						<p class="">
							<!-- <label for="wplrf-change-new-password"><?php //esc_html_e( 'New Password', 'wplrf' ); ?>&nbsp;<span class="required">*</span></label> -->
							<input type="password" class="wplrf-input-text" name="wplrf-change-new-password" id="wplrf-change-new-password"value="<?php echo ( ! empty( $_POST['wplrf-change-new-password'] ) ) ? esc_attr( wp_unslash( $_POST['wplrf-change-new-password'] ) ) : ''; ?>" placeholder="<?php esc_html_e( 'New Password', 'wplrf' ); ?>"/>
						</p>
						<p class="">
							<!-- <label for="wplrf-change-confirm-password"><?php //esc_html_e( 'Confirm password', 'wplrf' ); ?>&nbsp;<span class="required">*</span></label> -->
							<input class="wplrf-input-text" type="password" name="wplrf-change-confirm-password" id="wplrf-change-confirm-password" placeholder="<?php esc_html_e( 'Confirm password', 'wplrf' ); ?>" />
						</p>
						<p class="">
							<input type="hidden" id="wplrf_get_user_id" value="<?php echo $userdata->ID; ?>" />
							<button type="button" class="button" id="wplrf-change-password-btn" name="Change-password" value="<?php esc_attr_e( 'Change Password', 'wplrf' ); ?>"><?php esc_html_e( 'Change Password', 'wplrf' ); ?></button>
						</p>
						<p class="return-btns">
							<a href="javascript:void(0);" id="wplrf-return-to-account-btn"><?php esc_html_e( 'Return to My Account', 'wplrf' ); ?></a>
						</p>
						<p class="">
							<button type="button" class="button wplrf-close-btn" name="wplrf-close-btn" value="<?php esc_attr_e( 'Close', 'wplrf' ); ?>"><?php esc_html_e( 'Close', 'wplrf' ); ?></button>
						</p>
						</div>		
					</form>
				</div>
			 </div>
		</div>
		<?php
	}
$show_icon = esc_attr(get_option('wplrf-account-icon-show'));
$display_at = esc_attr(get_option('wplrf-account-icon-display-at'));
$display_at = !empty($display_at) ? $display_at : "left";
?>
<?php if(!empty($show_icon) && $show_icon == "yes"){?>
<a class="wplrf-account-btn">
	<div class="wplrf-account-button-container <?php echo esc_attr($display_at);?>">
		<img src="<?php echo esc_url(plugin_dir_url( __FILE__ ).'images/wplrf-account-icon.png');?>" alt="" />
	</div>
</a>
<?php } ?>