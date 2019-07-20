=== WP Login Register Flow ===
Contributors: thechetanvaghela
Donate link: http://chetanvaghela.cf
Tags:  Wordpress Login, Front-end login, Registration , Change password, Reset Password, Account , Ajax based login register , login register via popup
Requires at least: 3.0.1
Tested up to: 5.2
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Wordpress Login, Registration flow process ajax based.

== Description ==

WP Login Register Flow is ajax based wordpress login and registration process. it will give access to users change/reset password

Change texts of messages using filters : 

# Login success
add_filter('wplrf_account_login_success_text','wplrf_account_login_success_text_callback');

# Invalid user
add_filter('wplrf_account_invalid_user_text','wplrf_account_invalid_user_text_callback');

# Incorrect user
add_filter('wplrf_account_incorect_password_text','wplrf_account_incorect_password_text_callback');

# user blocked
add_filter('wplrf_account_blocked_text','wplrf_account_blocked_text_callback');

# My Account Link text
add_filter('wplrf_account_btn_text','wplrf_account_btn_text_callback');

# Register Email Already Exists
add_filter('wplrf_email_already_exists_text','wplrf_email_already_exists_text_callback');

# Register Username Already Exists
add_filter('wplrf_username_already_exists_text','wplrf_username_already_exists_text_callback');

# Register Successfully
add_filter('wplrf_account_register_success_text','wplrf_account_register_success_text_callback');

# Register Email send successfully
add_filter('wplrf_register_successed_email_text','wplrf_register_successed_email_text_callback');

# Register Email failed to send
add_filter('wplrf_register_failed_email_text','wplrf_register_failed_email_text_callback');

# welcome Email send successfully
add_filter('wplrf_welcome_email_success_text','wplrf_welcome_email_success_text_callback');

# welcome Email failed to send
add_filter('wplrf_welcome_email_failed_text','wplrf_welcome_email_failed_text_callback');

# Lost password Email send successfully
add_filter('wplrf_lost_pass_mail_success_send_text','wplrf_lost_pass_mail_success_send_text_callback');

# Lost password Email failed to send
add_filter('wplrf_lost_pass_mail_fail_send_text','wplrf_lost_pass_mail_fail_send_text_callback');

# Reset password Expired key
add_filter('wplrf_reset_pass_expired_key_text','wplrf_reset_pass_expired_key_text_callback');

# Reset password Invalid key
add_filter('wplrf_reset_pass_invalid_key_text','wplrf_reset_pass_invalid_key_text_callback');

# Reset password successfully
add_filter('wplrf_reset_pass_success_text','wplrf_reset_pass_success_text_callback');

# Change password successfully
add_filter('wplrf_change_pass_success_text','wplrf_change_pass_success_text_callback');

# Activation Email Send successfully
add_filter('wplrf_activation_link_send_success_text','wplrf_activation_link_send_success_text_callback');

# Lost Password Popup text
add_filter('wplrf_lost_pass_popup_text','wplrf_lost_pass_popup_text_callback');


### Features And Options:
* Wordpress login, Registration, Forgot passwpord, change password.
* Email Verification for Account Activation.
* Allow/Disallow Users to Register from frontend. 
* Block/unblock users to prevent login for frontend.
* Assign Default role for new registered user.
* send welcome email.
* Use Shortcode for display Link.
* set Account icon position for login/register popup.
* Change Toster messages using filters hook. 

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the "Woo Cart Popup" plugin through the 'Plugins' screen in WordPress
3. Click on Woo Cart Popup on the dashboard.

== Frequently Asked Questions ==

= How to setup Plugin? =

Does not required any setup. Just activate the plugin and set the postion of popup to display.

== Screenshots ==

1. wplrf-account-activation
2. wplrf-admin-manage-user
3. wplrf-admin-settings
4. wplrf-lchange-password
5. wplrf-logged-user-profile
6. wplrf-login
7. wplrf-lost-password
8. wplrf-register
9. wplrf-resend-activation-key
10. wplrf-reset-password



== Changelog ==
= 1.0.0 =
* Initial Public Release.