<?php
class WPLRFAdminSettings {

	# WPLRFAdminSettings class constructor
	function __construct() {
		# define admin menu hook
		add_action( 'admin_menu', array($this, 'wplrf_setting_admin_menu' ) );
	}
	
	/*
	#	create admin menu page and sub pages
	#	function : wplrf_setting_admin_menu
	#	hooks : add_menu_page , add_submenu_page
	*/
	function wplrf_setting_admin_menu() {

		add_menu_page('WPLRF','WPLRF','manage_options','wplrf_settings_page',array($this, 'wplrf_settings_page' ),'dashicons-groups');
		add_submenu_page('wplrf_settings_page','Manage Users','Manage Users','manage_options','wplrf_users_settings_page',array($this, 'wplrf_users_settings_page' ));
	}
	
	/*
	#	Admin menu page and sub pages settings
	# 	add plugin settings
	#	function : wplrf_settings_page
	*/
	function wplrf_settings_page() {

		# define empty variables
		$form_msg = $acount_options = $show_icon = $postion_value = $account_show = $display_at = $get_display_at = $yes_checked = $no_checked = $aselected = $selected = $left_checked = $center_checked = $right_checked = $allow_register = $allow_reg_yes_checked = $allow_reg_no_checked = $$allow_reg_value = $allow_reg = $send_value = $send_status = $send_mail = $send_yes = $send_no = $wplrf_user_role = $user_default_role = "";
		
		# if user can manage options
		if ( current_user_can('manage_options') ) {

			# submit form acrion
	        if (isset($_POST['wplrf-form-settings'])) {

	        	# verifing nonce
	        	if ( ! isset( $_POST['wplrf_setting_field_nonce'] ) || ! wp_verify_nonce( $_POST['wplrf_setting_field_nonce'], 'wplrf_setting_action_nonce' ) ) {
				    # form data not saved message
				    $form_msg = '<b style="color:red;">Sorry, your nonce did not verify.</b>';
				} else {
					
					# Acount Icon option
		        	if (isset($_POST['wplrf-account-icon-show'])) {
		        		$account_show = sanitize_text_field($_POST['wplrf-account-icon-show']);
		        		# update Acount Icon option value
		        		update_option('wplrf-account-icon-show', $account_show);
		        		if($account_show == "yes")
		        		{
		        			 # Acount Icon postion option
				        	if (isset($_POST['wplrf-account-icon-display-at'])) {
				                $postion_value = sanitize_text_field($_POST['wplrf-account-icon-display-at']);
				                $display_at = !empty($postion_value) ? $postion_value : "left";
				                # update Acount Icon postion value
				                update_option('wplrf-account-icon-display-at', $display_at);				           
			            	}
			            	
			            }
			         }

			         # Send Welcome mail option
		            if (isset($_POST['wplrf-account-send-mail'])) {
		                $send_value = sanitize_text_field($_POST['wplrf-account-send-mail']);
		                $send_status = !empty($send_value) ? $send_value : "no";
		                 # update Send Welcome mail option value
		                update_option('wplrf-account-send-mail', $send_status);				           
		            }

		            # Allow user register option
	            	if (isset($_POST['wplrf-account-allow-register'])) {
		                $allow_reg_value = sanitize_text_field($_POST['wplrf-account-allow-register']);
		                $allow_reg = !empty($allow_reg_value) ? $allow_reg_value : "yes";
		                # update Allow user register option value
		                update_option('wplrf-account-allow-register', $allow_reg);				           
	            	}

	            	if (isset($_POST['wplrf-account-user-role'])) {
		                $user_default_role = sanitize_text_field($_POST['wplrf-account-user-role']);
		                $user_default_role = !empty($user_default_role) ? $user_default_role : "subscriber";
		                update_option('wplrf-account-user-role', $user_default_role);				           
	            	}

	            	# form data saved message
			         $form_msg = '<b style="color:green;">Settings Saved.</b><br/>';
		            
	         	}
	    	}
		}

		# get value of account icon show
        $show_icon = esc_attr(get_option('wplrf-account-icon-show'));

        # get value of account register allow
        $allow_register = esc_attr(get_option('wplrf-account-allow-register'));

        # get value send welcome mail
        $send_mail = esc_attr(get_option('wplrf-account-send-mail'));

        # get value of account icon position
        $get_display_at = esc_attr(get_option('wplrf-account-icon-display-at'));

        # get value of account default role
        $wplrf_user_role = esc_attr(get_option('wplrf-account-user-role'));
		?>
		<!-- WPLRF Settings -->
		<div class="wrap">
			<h2><?php esc_html_e('Login Register Flow Settings','wplrf'); ?></h2>
			<div id="wplrf-setting-container">
				<div id="wplrf-body">
					<div id="wplrf-body-content">
						<div class="">
							<br/><?php _e($form_msg,'wplrf'); ?><hr/><br/>
							<form method="post">

								<!-- Show Account Icon Section -->
                                 <table>
                                 <tr valign="top">
                                  <th scope="row"><label for="wplrf-account-icon-show"><?php _e('Show Account Icon ? &nbsp;&nbsp;&nbsp;   ','wplrf'); ?></label></th>
                                  <td>	
                                  		<?php $yes_checked = ($show_icon == "yes") ? 'checked="checked"' : "";?>
                                  		<?php $no_checked = ($show_icon == "no") ? 'checked="checked"' : "";?>
                                  		<input type="radio" name="wplrf-account-icon-show" id="icon-show-yes" value="yes" <?php echo $yes_checked; ?> ><label for="icon-show-yes"><?php _e('Yes','wplrf'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
                                  		<input type="radio" name="wplrf-account-icon-show" id="icon-show-no" value="no" <?php echo $no_checked; ?>><label for="icon-show-no"><?php _e('No','wplrf'); ?></label>
                                  		
                                    </td>
                                  </tr>
                                   </table>
                                  <!-- Show Account Icon Section End-->
                                  <?php if(!empty($show_icon) && $show_icon == "yes"){?>
                                  	<br/><hr><br/>
                                  	<!-- Show Account Icon position Section -->
                                  	 <table>
		                                  <tr valign="top">
		                                  <th scope="row"><label for="wplrf-account-icon-display-at"><?php _e('Account Icon Position : ','wplrf'); ?></label></th>
		                                  <td>

		                                  		<?php $left_checked = ($get_display_at == "left") ? 'checked="checked"' : "";?>
		                                  		<?php $center_checked = ($get_display_at == "center") ? 'checked="checked"' : "";?>
		                                  		<?php $right_checked = ($get_display_at == "right") ? 'checked="checked"' : "";?>

		                                  		<input type="radio" name="wplrf-account-icon-display-at" id="display-at-left" value="left" <?php echo esc_attr($left_checked); ?> ><label for="display-at-left"><?php _e(esc_attr('Left'),'wplrf'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;

		                                  		<input type="radio" name="wplrf-account-icon-display-at" id="display-at-center" value="center" <?php echo esc_attr($center_checked); ?>><label for="display-at-center"><?php _e(esc_attr('Center'),'wplrf'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;

		                                  		<input type="radio" name="wplrf-account-icon-display-at" id="display-at-right" value="right" <?php echo esc_attr($right_checked); ?>><label for="display-at-right"><?php _e(esc_attr('Right'),'wplrf'); ?></label>
		                                    </td>
		                                  </tr>
                                 	 </table>
                                 	 <!-- Show Account Icon position Section End-->
                                  	<?php } ?>
                                  		<br/><hr><br/>
                                  	<!-- Allow user section -->
	                                  <table>
			                                  <tr valign="top">
			                                  <th scope="row"><label for="wplrf-account-allow-register"><?php _e('Allow User Register &nbsp;&nbsp;&nbsp; ','wplrf'); ?></label></th>
			                                  <td>
			                                  		<?php $allow_reg_yes_checked = ($allow_register == "yes") ? 'checked="checked"' : "";?>
			                                  		<?php $allow_reg_no_checked = ($allow_register == "no") ? 'checked="checked"' : "";?>
			                                  		<input type="radio" name="wplrf-account-allow-register" id="allow-reg-yes" value="yes" <?php echo $allow_reg_yes_checked; ?> ><label for="allow-reg-yes"><?php _e('Yes','wplrf'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
			                                  		<input type="radio" name="wplrf-account-allow-register" id="allow-reg-no" value="no" <?php echo $allow_reg_no_checked; ?>><label for="allow-reg-no"><?php _e('No','wplrf'); ?></label>
			                                    </td>
			                                  </tr>
	                                  </table>
	                                  <!-- Allow user section end-->
	                                  <br/><hr><br/>

	                                  <!-- Send welcome mail section -->
                                 	 <table>
		                                 <tr valign="top">
		                                  <th scope="row"><label for="wplrf-account-send-mail"><?php _e('Send Welcome Mail to User ? &nbsp;&nbsp;&nbsp;   ','wplrf'); ?></label></th>
		                                  <td>	
		                                  		<?php $send_yes = ($send_mail == "yes") ? 'checked="checked"' : "";?>
		                                  		<?php $send_no = ($send_mail == "no") ? 'checked="checked"' : "";?>
		                                  		<input type="radio" name="wplrf-account-send-mail" id="send-mail-yes" value="yes" <?php echo $send_yes; ?> ><label for="send-mail-yes"><?php _e('Yes','wplrf'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
		                                  		<input type="radio" name="wplrf-account-send-mail" id="send-mail-no" value="no" <?php echo $send_no; ?>><label for="send-mail-no"><?php _e('No','wplrf'); ?></label>
		                                    </td>
		                                  </tr>
                                   		</table>
                                   		 <!-- Send welcome mail section end -->
	                                  <br/><hr><br/>
	                                   <!-- Select default role for registration section -->
	                                  <table>
			                                  <tr valign="top">
			                                  <th scope="row"><label for="wplrf-account-user-role"><?php _e('Select Role for register user &nbsp;&nbsp;&nbsp; ','wplrf'); ?></label></th>
			                                  <td>
			                                  		<?php $selected_role = !empty($wplrf_user_role) ? $wplrf_user_role : "subscriber";  ?>
			                                  		<select name="wplrf-account-user-role" id="wplrf-account-user-role">
													   <?php wp_dropdown_roles($selected_role); ?>
													</select>
			                                  </td>
			                                  </tr>
	                                  </table>
	                                  <!-- Select default role for registration section end-->
	                                  <br/><hr><br/>
	                                  	 <!-- Shortcode section -->
		                                  <table>
				                                  <tr valign="top">
				                                  <th scope="row"><label for="wplrf-account-link-shortcode"><?php _e('Use Shortcode for Link &nbsp;&nbsp;&nbsp; ','wplrf'); ?></label></th>
				                                  <td>
				                                  		<input type="text" readonly value="<?php echo "[wplrf-account-link]";?>" size="50"><br/><br/>
				                                  		<input type="text" readonly value="<?php echo '[wplrf-account-link link_text=\'My Account\']';?>" size="50"><br/><br/>
				                                  		
				                                  	<span><b><?php echo htmlspecialchars("<?php echo do_shortcode('[wplrf-account-link]'); ?>"); ?></b></span><br/><br/>
				                                  	<span><b><?php echo htmlspecialchars("<?php echo do_shortcode('[wplrf-account-link link_text=\"My Account\"]'); ?>");?></b></span>
				                                  </td>
				                                  </tr>
		                                  </table>
		                                   <!-- Shortcode section End-->
                                    <br/><hr>
                                  <?php wp_nonce_field( 'wplrf_setting_action_nonce', 'wplrf_setting_field_nonce' ); ?>
                                  <?php  submit_button( 'Save Settings', 'primary', 'wplrf-form-settings'  ); ?>
							</form>
						</div>
					</div>
				</div>
				<br class="clear">
			</div>
		</div>
	<?php
	}

	/*
	#	Manage user pages settings
	#	function : wplrf_users_settings_page
	*/
	function wplrf_users_settings_page() {
		$wplrf_registered_users_List = new wplrf_registered_users_List();
        $wplrf_registered_users_List->prepare_items();

		?>
		<div class="wrap">
			<h2><?php _e('WPLRF Registered Users','wplrf'); ?></h2>

			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2">
					<div id="post-body-content">
						<div class="meta-box-sortables ui-sortable">
							<form method="post">
								<?php
								$wplrf_registered_users_List->display();
								?>
							</form>
						</div>
					</div>
				</div>
				<br class="clear">
			</div>
		</div>
		<?php
	}
}
new WPLRFAdminSettings;


/*
#	check WP_List_Table calss exists. if not then include
#	Class : WP_List_Table
*/
if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Create a new table class that will extend the WP_List_Table
 */
class wplrf_registered_users_List extends WP_List_Table
{
    /**
     * Prepare the items for the table to process
     *
     * @return Void
     */
    public function prepare_items()
    {
    	# user block/unblock action
    	$this->process_block_action();

        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ) );
        $perPage = 10;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);
        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );
        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }
    /**
     * Override the parent columns method. Defines the columns to use in your listing table
     *
     * @return Array
     */
    public function get_columns()
    {

        $columns = array(
        	'cb'      => '',
            'user_login'=> 'User Name',
            'user_email' => 'Email',
            'user_registered' => 'Registered Date',
            'user_action' => 'Action',
        );
        return $columns;
    }
    /**
     * Define which columns are hidden
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }
    /**
     * Define the sortable columns
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array('user_login' => array('user_login', false));
    }

    /**
     * Get the table data
     *
     * @return Array
     */
    private function table_data()
    {
    	# block nonce
    	$block_user_nonce = wp_create_nonce( 'wplrf_block_user_nonce' );
    	$data = array();
    	global $wpdb;

    	#get only register by this plugin
 		//$sql = "SELECT * FROM $wpdb->users LEFT JOIN $wpdb->usermeta ON $wpdb->users.ID = $wpdb->usermeta.user_id WHERE meta_key = 'registration_by_wplrf' AND meta_value = 'yes';";

    	#get all users
 		//$sql = "SELECT * FROM $wpdb->users";

 		#get all users excepts admins
 		$sql = "SELECT * FROM $wpdb->users INNER JOIN $wpdb->usermeta ON $wpdb->users.ID = $wpdb->usermeta.user_id WHERE $wpdb->usermeta.meta_key = 'wp_capabilities' AND $wpdb->usermeta.meta_value NOT LIKE '%administrator%' ORDER BY $wpdb->users.user_login";

		$data = $wpdb->get_results( $sql, 'ARRAY_A' );

		foreach ($data as $key => $value) {
			
			$block_action_text = "";
			$block_action = "";
			# get block status for users
			$block_status = esc_attr(get_user_meta($value["ID"],"wplrf_user_status_block",true));
			if($block_status == "yes")
			{
				$block_action_text = "Unblock";
				$block_action = "wplrf_unblock";
			}
			elseif($block_status == "no")
			{
				$block_action_text = "Block";
				$block_action = "wplrf_block";
			}
			else
			{
				$block_action_text = "Block";
				$block_action = "wplrf_block";
			}
			# add link in user action columns
			$data[$key]['user_action'] = sprintf( '<a href="?page=%s&action=%s&wplrf_user=%s&_wpnonce=%s">%s</a>', esc_attr('wplrf_users_settings_page'),$block_action, $value["ID"], $block_user_nonce,$block_action_text);
		}
        return $data;
    }

    /**
	 # update user status : block/unblock
	 # function : wplrf_manage_user
	*/
    function wplrf_manage_user( $id, $block_user ) {
    	# update status
		update_user_meta($id,"wplrf_user_status_block", $block_user);
	}

	/**
	 * Returns the count of records in the database.
	 *
	 * @return null|string
	 */
	function record_count() {
		global $wpdb;
		$count = $wpdb->get_var( $wpdb->prepare(
			"SELECT COUNT(*) FROM $wpdb->users
			LEFT JOIN $wpdb->usermeta ON $wpdb->users.ID = $wpdb->usermeta.user_id
			WHERE meta_key = 'registration_by_wplrf'
			AND meta_value = 'yes';"
		, $level ));
		return $count;
	}

	/** Text displayed when no customer data is available */
	function no_items() {
		_e( 'No Users avaliable.', 'wplrf' );
	}

    /**
     * Define what data to show on each column of the table
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'user_login':
            case 'user_email':
            case 'user_registered':
            case 'user_action':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ;
        }
    }

    /**
	 * Render the bulk edit checkbox
	 *
	 * @param array $item
	 *
	 * @return string
	 */
	function column_cb( $item ) {
		return "";
	}

	/**
	 * Method for name column
	 *
	 * @param array $item an array of DB data
	 *
	 * @return string
	 */
	public  function column_name( $item ) {

		/*$block_user_nonce = wp_create_nonce( 'wplrf_block_user' );

		$title = '<strong>' . $item['user_login'] . '</strong>';

		$actions = [
			'edit' => sprintf( '<a href="?page=%s&action=%s&wplrf_user=%s&_wpnonce=%s">Edit</a>', esc_attr('wplrf_users_settings_page'), 'edit', absint( $item['id'] ), $block_user_nonce ),
			
		];

		return $title . $this->row_actions( $actions );*/
	}

    /**
     * Allows you to sort the data by the variables set in the $_GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b )
    {
        // Set defaults
        $orderby = 'user_login';
        $order = 'asc';
        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }
        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }
        $result = strcmp( $a[$orderby], $b[$orderby] );
        if($order === 'asc')
        {
            return $result;
        }
        return -$result;
    }

    /**
     # process_block_action
     # function for block/unblock users
     */
    public function process_block_action() {

		if ( 'wplrf_block' === $this->current_action() || 'wplrf_unblock' === $this->current_action()) {
			// In our file that handles the request, verify the nonce.
			$nonce = esc_attr( $_REQUEST['_wpnonce'] );

			if ( ! wp_verify_nonce( $nonce, 'wplrf_block_user_nonce' ) ) {
				die( 'Go get a life script kiddies' );
			}
			else {

				if ( 'wplrf_block' === $this->current_action() ) {
					$block_user = "yes";
				}
				elseif ('wplrf_unblock' === $this->current_action()) {
					$block_user = "no";
				}
				# send to update user status
				self::wplrf_manage_user( absint( $_GET['wplrf_user'] ), $block_user );
		        wp_redirect('admin.php?page=wplrf_users_settings_page');
				exit;
			}
		}
		
	}

}
