<?php

/**
 * Defines the admin-specific functionality of the plugin.
 *
 * @since      1.0
 */
	 
class SimpleForm_Submissions_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0
	 */
	
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0
	 */
	
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0
	 */
	
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

    /**
     * Add new submenu page to Contact admin menu.
     *
     * @since    1.0
     */  
     
    public function admin_menu() {
	    
      $settings = get_option('sform_settings');
      $data_storing = ! empty( $settings['data_storing'] ) ? esc_attr($settings['data_storing']) : 'true';	

      if ( $data_storing == 'true') {
	    global $sform_entrie_page;
        $sform_entrie_page = add_submenu_page(null, __('View Request', 'simpleform-contact-form-submissions'), __('View Request', 'simpleform-contact-form-submissions'), 'activate_plugins', 'sform-entrie', array ($this, 'view_sform_entrie') );
      }

   }
  
    /**
     * Render the submitted message page for this plugin.
     *
     * @since    1.0
     */
     
    public function view_sform_entrie() {
      
      include_once( 'partials/message.php' );
    }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0
	 */
    
    public function enqueue_styles($hook) {

     global $sform_submissions_page;
	 global $sform_entrie_page;
	 if( $hook != $sform_submissions_page && $hook != $sform_entrie_page )
	 return;
	 
	 wp_enqueue_style('sform_submissions_style', plugins_url('/css/admin.css',__FILE__));
	      
	}
	
	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0
	 */
	
	public function enqueue_scripts($hook){
	    		
     global $settings_page;
	 if( $hook != $settings_page )
	 return;

     wp_enqueue_script( 'sform_submissions', plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), $this->version, false );
     wp_localize_script( 'sform_submissions', 'sform_submissions_object', array( 'enable' => esc_html__( 'Check if you want to add the submissions list in the dashboard and enable the form data storing', 'simpleform-contact-form-submissions' ), 'disable' => esc_html__( 'Uncheck if you want to remove the submissions list from the dashboard and disable the form data storing', 'simpleform-contact-form-submissions' ) )); 
	      
	}
	
	/**
	 * Add submissions related fields in settings page.
	 *
	 * @since    1.0
	 */
	
    public function submissions_settings_fields( $id ) {
	    
	 if ( empty($id) ) { 
     $settings = get_option('sform_settings'); 
     $attributes = get_option('sform_attributes');
     } else { 
     $settings_option = get_option('sform_widget_'. $id .'_settings');
     $settings = $settings_option != false ? $settings_option : get_option('sform_settings');
     $attributes_option = get_option('sform_widget_'.$id.'_attributes');
     $attributes = $attributes_option != false ? $attributes_option : get_option('sform_attributes');     
	 }
	
     $data_storing = ! empty( $settings['data_storing'] ) ? esc_attr($settings['data_storing']) : 'true';
     $ip_storing = ! empty( $settings['ip_storing'] ) ? esc_attr($settings['ip_storing']) : 'true';
     $counter = ! empty( $settings['counter'] ) ? esc_attr($settings['counter']) : 'true';
     $columns = ! empty( $settings['data_columns'] ) ? esc_attr($settings['data_columns']) : 'subject,firstname,message,mail,date';	
     $name_field = ! empty( $attributes['name_field'] ) ? esc_attr($attributes['name_field']) : 'visible';
     $checked_name = strpos($columns,'firstname') !== false ? 'checked' : '';
     $lastname_field = ! empty( $attributes['lastname_field'] ) ? esc_attr($attributes['lastname_field']) : 'hidden';
     $checked_lastname = strpos($columns,'family') !== false ? 'checked' : '';
     $checked_fullname = strpos($columns,'from') !== false ? 'checked' : '';
     $email_field = ! empty( $attributes['email_field'] ) ? esc_attr($attributes['email_field']) : 'visible';
     $checked_email = strpos($columns,'mail') !== false ? 'checked' : '';
     $phone_field = ! empty( $attributes['phone_field'] ) ? esc_attr($attributes['phone_field']) : 'hidden';
     $checked_phone = strpos($columns,'phone') !== false ? 'checked' : '';
     $form_type = isset( $_REQUEST['type'] ) && $_REQUEST['type'] == 'widget' ? 'widget' : '';
     ?>
		
     <tr><th class="heading" colspan="2"><span><?php esc_html_e( 'Data Storing Options','simpleform-contact-form-submissions') ?></span></th></tr>	
	 
	 <tr><th id="thstoring" class="option <?php if ($data_storing !='true') { echo 'wide'; } else { echo 'first'; } ?>"><span><?php esc_html_e('Data Storing', 'simpleform-contact-form-submissions' ) ?></span></th><td id="tdstoring" class="checkbox notes <?php if ($data_storing !='true') { echo 'wide'; } else { echo 'first'; } ?>"><label for="data-storing"><input type="checkbox" class="sform" name="data-storing" id="data-storing" value="true" <?php checked( $data_storing, 'true'); ?>><?php _e( 'Enable the form data storing in the database (data will be included only within the notification email if unchecked)', 'simpleform-contact-form-submissions' ); ?></label><p id="storing-description" class="description"><?php if ($data_storing !='true') { esc_html_e('Check if you want to add the submissions list in the dashboard and enable the form data storing', 'simpleform-contact-form-submissions' ); } else { esc_html_e('Uncheck if you want to remove the submissions list from the dashboard and disable the form data storing', 'simpleform-contact-form-submissions' ); } ?></p></td></tr>
						  
	 <tr class="trstoring <?php if ($data_storing !='true') {echo 'unseen';} else {echo 'visible';} ?>"><th class="option"><span><?php esc_html_e('IP Address Storing', 'simpleform-contact-form-submissions' ) ?></span></th><td class="checkbox"><label for="ip-storing"><input id="ip-storing" name="ip-storing" type="checkbox" class="sform" value="true" <?php checked( $ip_storing, 'true'); ?> ><?php _e( 'Enable IP address storing in the database', 'simpleform-contact-form-submissions' ); ?></label></td></tr>

     <tr class="trstoring <?php if ($data_storing !='true') {echo 'unseen';} else {echo 'visible';} ?>" ><th class="option <?php if ( $form_type != '' ) {echo 'last';} ?>"><span><?php esc_html_e( 'Visible Data Columns', 'simpleform' ) ?></span></th><td class="checkbox notes <?php if ( $form_type != '' ) {echo 'last';} ?>"><label for="id"><input type="checkbox" name="columns[]" id="id" class="sform" value="id" <?php if (strpos($columns,'id') !== false) { echo 'checked'; } ?>><?php esc_html_e( 'Request ID', 'simpleforms' ); ?></label><label for="subject"><input type="checkbox" name="columns[]" id="subject" class="sform" value="subject" <?php if (strpos($columns,'subject') !== false) { echo 'checked'; } ?>><?php esc_html_e( 'Subject', 'simpleforms' ); ?></label><?php if ( $name_field != 'hidden' ) {echo '<label for="firstname"><input type="checkbox" name="columns[]" id="firstname" class="sform" value="firstname" ' . $checked_name . '>' . esc_html( 'Name', 'simpleforms' ) .'</label>';}?><?php if ( $lastname_field != 'hidden' ) {echo '<label for="family"><input type="checkbox" name="columns[]" id="family" class="sform" value="family" ' . $checked_lastname . '>' . esc_html( 'Last Name', 'simpleforms' ) .'</label>';}?><?php if ( $name_field != 'hidden' && $lastname_field != 'hidden' ) {echo '<label for="from"><input type="checkbox" name="columns[]" id="from" class="sform" value="from" ' . $checked_fullname . '>' . esc_html( 'Full Name', 'simpleforms' ) .'</label>';}?><label for="message"><input type="checkbox" name="columns[]" id="message" class="sform" value="message" <?php if (strpos($columns,'message') !== false) { echo 'checked'; }?>><?php esc_html_e( 'Message', 'simpleforms' ); ?></label><?php if ( $email_field != 'hidden' ) {echo '<label for="mail"><input type="checkbox" name="columns[]" id="mail" class="sform" value="mail" ' . $checked_email . '>' . esc_html( 'Email', 'simpleforms' ) .'</label>';}?><?php if ( $phone_field != 'hidden' ) {echo '<label for="phone"><input type="checkbox" name="columns[]" id="phone" class="sform" value="phone" ' . $checked_phone . '>' . esc_html( 'Phone', 'simpleforms' ) .'</label>';}?><label for="ip"><input type="checkbox" name="columns[]" id="ip" class="sform" value="ip" <?php if (strpos($columns,'ip') !== false) { echo 'checked'; }?>><?php esc_html_e( 'IP', 'simpleforms' ); ?></label><label for="date"><input type="checkbox" name="columns[]" id="date" class="sform" value="date" <?php if (strpos($columns,'date') !== false) { echo 'checked'; }?>><?php esc_html_e( 'Date', 'simpleforms' ); ?></label><p class="description"><?php esc_html_e( 'Set the default columns that must be displayed in the submissions list table. You can disable the visible columns at any time via "Screen options"', 'simpleform' ) ?></p></td></tr>

     <?php
     if ( $form_type == '' ) { 
     ?>
	 <tr class="trstoring <?php if ($data_storing !='true') {echo 'unseen';} else {echo 'visible';} ?>"><th class="option"><span><?php esc_html_e('Unread Count', 'simpleform-contact-form-submissions' ) ?></span></th><td class="checkbox last"><label for="counter"><input id="counter" name="counter" type="checkbox" class="sform" value="true" <?php checked( $counter, 'true'); ?> ><?php _e( 'Add a notification bubble to Contacts menu item for unread messages', 'simpleform-contact-form-submissions' ); ?></label></td></tr>
     <?php 
	     
     }
		
    }	

	/**
	 * Add submissions related fields values in the settings options array.
	 *
	 * @since    1.0
	 */
	
    public function add_array_submissions_settings() { 
  
     $data_storing = isset($_POST['data-storing']) ? 'true' : 'false';
     $ip_storing = isset($_POST['ip-storing']) ? 'true' : 'false';
     $counter = isset($_POST['counter']) ? 'true' : 'false';
     $columns = isset($_POST['columns']) ? esc_html(trim(implode(",", $_POST['columns']))) : '';
     $widget_id = isset( $_POST['widget-id'] ) ? absint($_POST['widget-id']) : '';
     
     if ( $data_storing == 'false' )  { $ip_storing = 'false'; $counter = 'false'; $columns = ''; }
     
     if ( $widget_id == '' ) { 
       $new_items = array( 'data_storing' => $data_storing, 'ip_storing' => $ip_storing, 'data_columns' => $columns, 'counter' => $counter );
     } else { 
       $new_items = array( 'data_storing' => $data_storing, 'ip_storing' => $ip_storing, 'data_columns' => $columns );
     }
     
     return  $new_items;

    }

	/**
	 * Validate submissions related fields in Settings page.
	 *
	 * @since    1.0
	 */
	
    public function validate_submissions_fields(){
	    
       $data_storing = isset($_POST['data-storing']) ? 'true' : 'false';
       $notification = isset($_POST['notification']) ? 'true' : 'false';   
       $columns = isset($_POST['columns']) ? esc_html(trim(implode(",", $_POST['columns']))) : '';
     
       if ( strpos($columns,'firstname') !== false && strpos($columns,'from') !== false ) {
            echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__('The column Name and the column Full Name cannot both be selected', 'simpleform-contact-form-submissions')  ));
	        exit; 
       }

       if ( strpos($columns,'family') !== false && strpos($columns,'from') !== false ) {
            echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__('The column Last Name and the column Full Name cannot both be selected', 'simpleform-contact-form-submissions')  ));
	        exit; 
       }
	   
	   if ( $data_storing == 'false' && $notification == 'false' ) {
            echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__('The Data Storing option and the Enable Notification option cannot both be disabled. Please keep at least one option enabled!', 'simpleform-contact-form-submissions')  ));
	        exit; 
       }
  
    }
	
	/**
	 * Display submissions list in dashboard.
	 *
	 * @since    1.0
	 */

    public function display_submissions_list($form_id){
    	
     if ( $form_id == '' ) {
      $settings = get_option('sform_settings');
      $where_form = " WHERE form != '0'";
      $last_message = stripslashes(get_transient('sform_last_message'));

	 } else {
      $settings_option = get_option('sform_widget_'. $form_id .'_settings');
      $settings = $settings_option != false ? $settings_option : get_option('sform_settings');
      $where_form = " WHERE form = '". $form_id ."'";
      $last_message = stripslashes(get_transient('sform_last_'.$form_id.'_message'));
     }
     
      $sform_widget = get_option('widget_sform_widget');
      $data_storing = ! empty( $settings['data_storing'] ) ? esc_attr($settings['data_storing']) : 'true';	

     if ( $data_storing == 'true' ) {	
     if ( $form_id == '' || $form_id == '1' || in_array($form_id, array_keys($sform_widget)) ) {	     
      $table = new SForms_Submissions_List_Table();
      $table->prepare_items();
      $table->views(); 
     ?>
     <form id="submissions-table" method="get"><input type="hidden" name="page" value="<?php echo sanitize_key($_REQUEST['page']) ?>"/>
     <?php $table->search_box( __( 'Search' ), 'simpleform-contact-form-submissions');	 
	 $transient_notice = stripslashes(get_transient('sform_action_notice'));
     $notice = $transient_notice != '' ? $transient_notice : '';
     echo $notice; 
     $table->display(); ?></form><?php
	     
	 } else {
     ?>

     <span><?php echo esc_html('There seems to be no form available with ID:', 'simpleform' ) . $form_id; ?></span><p><span class="sf button button-primary"><a href="<?php echo menu_page_url( 'sform-submissions', false ); ?>" style="text-decoration: none; color: #FFF; "><?php esc_html_e('Reload the Submissions page','simpleform') ?></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="sf button button-primary"><a href="<?php echo self_admin_url('widgets.php'); ?>" style="text-decoration: none; color: #FFF; "><?php esc_html_e('Activate SimpleForm Contact Form Widget','simpleform') ?></a></span></p>

     <?php
     }
     } else {
 
      if ( $form_id == '' || $form_id == '1' || in_array($form_id, array_keys($sform_widget)) ) {
      global $wpdb;
      $table_name = $wpdb->prefix . 'sform_submissions';
      $where_day = 'AND date >= UTC_TIMESTAMP() - INTERVAL 24 HOUR';
      $where_week = 'AND date >= UTC_TIMESTAMP() - INTERVAL 7 DAY';
      $where_month = 'AND date >= UTC_TIMESTAMP() - INTERVAL 30 DAY';
      $where_year = 'AND date >= UTC_TIMESTAMP() - INTERVAL 1 YEAR';
      $count_all = $wpdb->get_var("SELECT COUNT(id) FROM $table_name $where_form");
      $count_last_day = $wpdb->get_var("SELECT COUNT(id) FROM $table_name $where_form $where_day ");
      $count_last_week = $wpdb->get_var("SELECT COUNT(id) FROM $table_name $where_form $where_week ");
      $count_last_month = $wpdb->get_var("SELECT COUNT(id) FROM $table_name $where_form $where_month ");
      $count_last_year = $wpdb->get_var("SELECT COUNT(id) FROM $table_name $where_form $where_year ");
      $total_received = $count_all;
      ?>

      <div><ul id="submissions-data"><li class="type"><span class="label"><?php esc_html_e( 'Received', 'simpleform' ); ?></span><span class="value"><?php echo $total_received; ?></span></li><li class="type"><span class="label"><?php esc_html_e( 'This Year', 'simpleform' ); ?></span><span class="value"><?php echo $count_last_year; ?></span></li><li class="type"><span class="label"><?php esc_html_e( 'Last Month', 'simpleform' ); ?></span><span class="value"><?php echo $count_last_month; ?></span></li><li class="type"><span class="label"><?php esc_html_e( 'Last Week', 'simpleform' ); ?></span><span class="value"><?php echo $count_last_week; ?></span></li><li><span class="label"><?php esc_html_e( 'Last Day', 'simpleform' ); ?></span><span class="value"><?php echo $count_last_day; ?></span></li></ul></div>
<?php
	  $icon = version_compare(get_bloginfo('version'),'5.0', '>=') ? 'dashicons-buddicons-pm' : 'dashicons-media-text';
	  if ( $last_message ) {
	  echo '<div id="last-submission"><h3><span class="dashicons '.$icon.'"></span>'.esc_html__('Last Message Received', 'simpleform-contact-form-submissions' ).'</h3>'.$last_message . '</div>'; echo '<div id="submissions-notice" class="unseen"><h3><span class="dashicons dashicons-editor-help"></span>'.esc_html__('Before you go crazy looking for the received messages', 'simpleform-contact-form-submissions' ).'</h3>'.esc_html__('Submissions data is not stored in the WordPress database. Open the General Tab in the Settings page, and check the Data Storing option for enabling the display of messages in the dashboard. By default, only last message is temporarily stored. Therefore, it is recommended that you verify the correct SMTP server configuration in case of use, and always keep the notification email enabled if you want to be sure to receive the messages.', 'simpleform-contact-form-submissions' ).'</div>';
	  }
	  else  {
	  echo '<div id="empty-submission"><h3><span class="dashicons dashicons-info"></span>'.esc_html__('Empty Inbox', 'simpleform-contact-form-submissions' ).'</h3>'.esc_html__('So far, no message has been received yet!', 'simpleform-contact-form-submissions' ).'<p>'.esc_html__('Submissions data is not stored in the WordPress database. Open the General Tab in the Settings page, and check the Data Storing option for enabling the display of messages in the dashboard. By default, only last message is temporarily stored. Therefore, it is recommended that you verify the correct SMTP server configuration in case of use, and always keep the notification email enabled if you want to be sure to receive the messages.', 'simpleform-contact-form-submissions' ).'</div>';
	  }
      } else {
      ?>

      <span><?php echo esc_html('There seems to be no form available with ID:', 'simpleform' ) . $form_id; ?></span><p><span class="sf button button-primary"><a href="<?php echo menu_page_url( 'sform-submissions', false ); ?>" style="text-decoration: none; color: #FFF; "><?php esc_html_e('Reload the Submissions page','simpleform') ?></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="sf button button-primary"><a href="<?php echo self_admin_url('widgets.php'); ?>" style="text-decoration: none; color: #FFF; "><?php esc_html_e('Activate SimpleForm Contact Form Widget','simpleform') ?></a></span></p>
      <?php
     }
     }
	
    }

	/**
	 * Add screen option tab.
	 *
	 * @since    1.0
	 */

    public function submissions_table_options() {
	
	global $sform_submissions_page;
	add_action("load-$sform_submissions_page", array ($this, 'sforms_submissions_list_options') );
    
    }

	/**
	 * Setup function that registers the screen option.
	 *
	 * @since    1.0
	 */

    public function sforms_submissions_list_options() {
	    
      $form_id = isset( $_REQUEST['form'] ) ? absint($_REQUEST['form']) : '';
     
      if ( $form_id == '' ) {
        $settings = get_option('sform_settings');
      } else {
        $settings_option = get_option('sform_widget_'. $form_id .'_settings');
        $settings = $settings_option != false ? $settings_option : get_option('sform_settings');
      }
      
      $data_storing = ! empty( $settings['data_storing'] ) ? esc_attr($settings['data_storing']) : 'true';
      $sform_widget = get_option('widget_sform_widget');
  
      if ( $data_storing == 'true' && ( $form_id == '' || $form_id == '1' || in_array($form_id, array_keys($sform_widget)) ) ) {
      global $table;
      global $sform_submissions_page;
      $screen = get_current_screen();      
           
      if(!is_object($screen) || $screen->id != $sform_submissions_page)
      return;
      $option = 'per_page';
      $args = array( 'label' => esc_attr__('Number of submissions per page', 'simpleform-contact-form-submissions'),'default' => 20,'option' => 'edit_submission_per_page');
      add_screen_option( $option, $args );
      $table = new SForms_Submissions_List_Table(); 
      
     }
  
    }

	/**
	 * Save screen options.
	 *
	 * @since    1.0
	 */

    public function submissions_screen_option($status, $option, $value) {
      
     if ( 'edit_submission_per_page' == $option ) return $value;
     return $status;
    
    }
    
	/**
	 * Register a post type for change the pagination in Screen Options tab.
	 *
	 * @since    1.3
	 */

    public function submission_post_type() {
	
	    $args = array();
	    register_post_type( 'submission', $args );
	    
    }
	
	/**
	 * Render the meta box in the submitted message page.
	 *
	 * @since    1.0
	 */
	
    public function sform_entrie_meta_box_handler($item) {
	    
     ?>
	 <div class="datarow">
	 <div class="thdata first"><?php esc_html_e('From', 'simpleform-contact-form-submissions' ) ?></div>
	 <div class="tddata first"><?php
	    $requester_id = esc_attr($item['requester_id']); 
        if ( isset($requester_id) && $requester_id != 0 ) {
	    $user_info = get_user_by( 'id', $requester_id );
	    $page_user = get_edit_user_link( $requester_id );
		$user_firstname = ! empty($user_info->first_name) ? $user_info->first_name : $user_info->display_name;
		$user_lastname = ! empty($user_info->last_name) ? $user_info->last_name : '';
	    $firstname = $item['name'] != '' && $item['name'] != 'not stored' ? esc_attr($item['name']) : $user_firstname;	    
	    $lastname = $item['lastname'] != '' && $item['lastname'] != 'not stored' ? esc_attr($item['lastname']) : $user_lastname;
        $request_author = trim($firstname.' '.$lastname). ' [ <a href="'.$page_user.'" target="_blank" class="nodecoration">'.$user_info->user_login.'</a> ]<br>'.esc_html__('Registered user', 'simpleform-contact-form-submissions' );
	    }
        else {
	    $firstname = $item['name'] != '' && $item['name'] != 'not stored' ? esc_attr($item['name']) : '';
	    $lastname = $item['lastname'] != '' && $item['lastname'] != 'not stored' ? esc_attr($item['lastname']) : '';
	    if ( !empty($firstname) || !empty($lastname) ):
	    $request_author =  trim($firstname.' '.$lastname) . '<br>'.esc_html__('Anonymous user', 'simpleform-contact-form-submissions' );
	    else:
	    $request_author =  esc_html__('Anonymous user', 'simpleform-contact-form-submissions' );
	    endif;
        }
	    echo $request_author; ?></div>	 
	 </div>
	 
	 <?php
	 $email = $item['email'] != '' && $item['email'] != 'not stored' ? esc_attr($item['email']) : '';
     if ( ! empty($email) ) { ?>
	 <div class="datarow">
     <div class="thdata"><?php esc_html_e('Email', 'simpleform-contact-form-submissions' ) ?></div>		
	 <div class="tddata"><?php echo $email ?></div>
	 </div>
   	 <?php }	 
	 
     global $wpdb;
     $form = $wpdb->get_var($wpdb->prepare("SELECT form FROM {$wpdb->prefix}sform_submissions WHERE id = %d", $item['id']));
     $attributes_option = get_option('XXsform_widget_'. $form .'_attributes');
     $attributes = $attributes_option != false ? $attributes_option : get_option('sform_attributes');     
     
     $phone_field = ! empty( $attributes['phone_field'] ) ? esc_attr($attributes['phone_field']) : 'hidden';

	 $phone = $item['phone'] != '' && $item['phone'] != 'not stored' ? esc_attr($item['phone']) : '';
     if ( ! empty($phone) ) { 
     ?>
	 <div class="datarow">
	 <div class="thdata"><?php esc_html_e('Phone', 'simpleform-contact-form-submissions' ) ?></div>
	 <div class="tddata"><?php echo $phone ?></div>
	 </div>
	 <?php } ?>	 	 
	 
	 <div class="datarow">
	 <div class="thdata"><?php esc_html_e('Date', 'simpleform-contact-form-submissions' ) ?></div>
	 <div class="tddata"><?php $tzcity = get_option('timezone_string'); $tzoffset = get_option('gmt_offset');
       if ( ! empty($tzcity))  { 
       $current_time_timezone = date_create('now', timezone_open($tzcity));
       $timezone_offset =  date_offset_get($current_time_timezone);
       $submission_timestamp = strtotime(esc_attr($item['date'])) + $timezone_offset; 
       }
       else { 
       $timezone_offset =  $tzoffset * 3600;
       $submission_timestamp = strtotime(esc_attr($item['date'])) + $timezone_offset;  
       }
       /* translators: It is used to indicate the time */
       $at = esc_html__('at', 'simpleform-contact-form-submissions');
       echo date_i18n(get_option('date_format'),$submission_timestamp).' '.$at.' '.date_i18n(get_option('time_format'),$submission_timestamp );?>
     </div>
	 </div>
	 
	 <?php     
	 $ip_address = $item['ip'] != '' && $item['ip'] != 'not stored' ? esc_attr($item['ip']) : '';
     if ( ! empty($ip_address) ) { 
     ?>
	 <div class="datarow">
	 <div class="thdata"><?php esc_html_e('IP', 'simpleform-contact-form-submissions' ) ?></div>
	 <div class="tddata"><?php echo $ip_address ?></div>
	 </div>
	 <?php }
	 
	 $subject = $item['subject'] != '' && $item['subject'] != 'not stored' ? esc_attr($item['subject']) : '';
     if ( ! empty($subject) ) { ?>
	 <div class="datarow">
	 <div class="thdata"><?php esc_html_e('Subject', 'simpleform-contact-form-submissions' ) ?></div>
	 <div class="tddata"><span id="subject-input"><?php echo $subject ?></span></div>	
   	 </div>
   	 <?php } ?>
   	 
	 <div class="datarow">
     <div class="thdata last"><?php esc_html_e('Message', 'simpleform-contact-form-submissions' ) ?></div>
     <div class="tddata last"><?php echo esc_attr($item['object'])?></div>
     </div>	
 	 <?php
    
    }
    
	/**
	 * Deactivate plugin if SimpleForm is missing.
	 *
	 * @since    1.0
	 */

    public function detect_core_deactivation() {
	    
	  include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	  		  
      if ( is_network_admin() && ! is_plugin_active_for_network( 'simpleform/simpleform.php' ) ) {
      deactivate_plugins('simpleform-submissions/simpleform-submissions.php');  
      }
      
      else {
       if ( ! class_exists( 'SimpleForm' ) ) {
       deactivate_plugins('simpleform-submissions/simpleform-submissions.php');  
       }
      }
    
    }

 	/**
	 * Fallback for database table updating if plugin is already active.
	 *
	 * @since    1.4
	 */
    
    public function simpleform_db_version_check() {
    
      $current_db_version = SIMPLEFORM_SUBMISSIONS_DB_VERSION; 
      $installed_version = get_option('sform_sub_db_version'); // Before get_site_option
    
      if ( $installed_version != $current_db_version ) {
	    global $wpdb;
	    $wpdb->query("UPDATE {$wpdb->prefix}sform_submissions SET status = 'read' WHERE status = 'new' AND date <= (NOW() - INTERVAL 7 DAY)" );   
        require_once SIMPLEFORM_SUBMISSIONS_PATH . 'includes/class-activator.php';
	    SimpleForm_Submissions_Activator::sform_submissions_settings();
	    SimpleForm_Submissions_Activator::change_db();
      }

    }

 	/**
	 * Add conditional items into the Bulk Actions dropdown for submissions list.
	 *
	 * @since    1.3
	 */

    public function register_sform_actions($bulk_actions) { 
	    
        global $wpdb;
	    $view = isset( $_REQUEST['view'] ) && sanitize_text_field($_REQUEST['view']) == 'trash' ? 'trash' : '';
	    if ( ! empty($view) && $view == 'trash' ) { 
          $bulk_actions['bulk-untrash'] = __('Restore', 'simpleform-contact-form-submissions');
          $bulk_actions['bulk-delete'] = __('Delete', 'simpleform-contact-form-submissions');
        } 
        else { 
          $bulk_actions['bulk-trash'] = __('Move to Trash', 'simpleform-contact-form-submissions');
        } 
        return $bulk_actions;
         
    }
    

 	/**
	 * Add a notification bubble to Contacts menu item.
	 *
	 * @since    1.4
	 */

     public function notification_bubble() { 
	
      $settings = get_option('sform_settings');
      
	  global $wpdb;
      $table_name = $wpdb->prefix . 'sform_submissions';      
      $counter = ! empty( $settings['counter'] ) ? esc_attr($settings['counter']) : 'true';	
      $data_storing = ! empty( $settings['data-storing'] ) ? esc_attr($settings['data-storing']) : 'true';
      $form_id = isset( $_REQUEST['form'] ) ? absint($_REQUEST['form']) : '';
          
      if ( $data_storing == 'true' && $counter == 'true'):
        $id = isset( $_REQUEST['id'] ) ? absint($_REQUEST['id']) : '';        
        if( $form_id != ''){
         $count = $wpdb->get_col($wpdb->prepare("SELECT id FROM $table_name WHERE status = 'new' AND object != '' AND object != 'not stored' AND form = %d", $form_id));
        } else {
         $count = $wpdb->get_col("SELECT id FROM $table_name WHERE status = 'new' AND object != '' AND object != 'not stored' AND form != '0'");
        } 
        $real_count = isset( $_REQUEST['page'] ) && $_REQUEST['page'] == 'sform-entrie' && in_array($id, $count) ? '1' : '0';
        $notification_count = count($count) - $real_count;
        // Use transient + 1 instead of new query 
        $item = $notification_count ? sprintf(__('Contacts', 'simpleform') . ' <span class="awaiting-mod">%d</span>', $notification_count) : __('Contacts', 'simpleform');
        
      else:
        $item = __('Contacts', 'simpleform');
      endif;
      
      
// --------------------------------------------------------------------
      // Temporary patch: remove soon!!!
  	  $shortcode_pages = get_transient( 'sform_shortcode_pages' );
      if ( $shortcode_pages === false ) {
		global $wpdb;
        $query = "SELECT ID, post_title, guid FROM ".$wpdb->posts." WHERE post_content LIKE '%[simpleform]%' AND post_status = 'publish'";
        $results = $wpdb->get_results ($query);
        $shortcode_pages = wp_list_pluck( $results, 'ID' );
        set_transient( 'sform_shortcode_pages', $shortcode_pages, 12 * HOUR_IN_SECONDS );
	  }
	  // End patch
// --------------------------------------------------------------------
    
      return $item;

    }

   public function notification_bubble_vo() { 
	
	  global $wpdb;
      $table_name = $wpdb->prefix . 'sform_submissions';      
      $settings = get_option('sform_settings');
      $counter = ! empty( $settings['counter'] ) ? esc_attr($settings['counter']) : 'true';	
      $data_storing = ! empty( $settings['data-storing'] ) ? esc_attr($settings['data-storing']) : 'true';
           
      if ( $data_storing == 'true' ):
        $id = isset( $_REQUEST['id'] ) ? absint($_REQUEST['id']) : '';
        $count = $wpdb->get_col("SELECT id FROM $table_name WHERE status = 'new'");
        $real_count = isset( $_REQUEST['page'] ) && $_REQUEST['page'] == 'sform-entrie' && in_array($id, $count) ? '1' : '0';
        $notification_count = count($count) - $real_count;
      else:
        $notification_count = '';
      endif;
      
      // Use transient + 1 instead of new query 
      $item = $notification_count ? sprintf(__('Contacts', 'simpleform') . ' <span class="awaiting-mod">%d</span>', $notification_count) : __('Contacts', 'simpleform');
    
      return $item;

    }

   /**
	 * Add action links in the plugin meta row
	 *
	 * @since    1.4
	 */
	
    public function plugin_links( $plugin_actions, $plugin_file ){ 
     
     $new_actions = array();
     
	 if ( SIMPLEFORM_SUBMISSIONS_BASENAME === $plugin_file ) { 
     $new_actions['sform_settings'] = '<a href="' . menu_page_url( 'sform-submissions', false ) . '">' . __('Dashboard', 'simpleform') . '</a> | <a href="' . menu_page_url( 'sform-settings', false ) . '">' . __('Settings', 'simpleform') . '</a>';
	 }

     return array_merge( $new_actions, $plugin_actions );

    }
    
	/**
	 * When user is on a SimpleForm related admin page, display footer text.
	 *
	 * @since    1.4.1
	 */

	public function admin_footer($text) {
		
      $settings = get_option('sform_settings');
      $admin_notices = ! empty( $settings['admin_notices'] ) ? esc_attr($settings['admin_notices']) : 'false';	

	  if ( $admin_notices == 'false' ) {
		global $current_screen;
	    global $wpdb;
        $table_name = $wpdb->prefix . 'sform_submissions'; 
        $count_all = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");

		if ( ! empty( $current_screen->id ) && strpos( $current_screen->id, 'sform' ) !== false && $count_all > 10 ) {
			$plugin = '<strong>SimpleForm</strong>';
			$url1  = '<a href="https://wordpress.org/support/plugin/simpleform/reviews/?filter=5#new-post" target="_blank" rel="noopener noreferrer">&#9733;&#9733;&#9733;&#9733;&#9733;</a>';
			$url2  = '<a href="https://wordpress.org/support/plugin/simpleform/reviews/?filter=5#new-post" target="_blank" rel="noopener noreferrer">WordPress.org</a>';
			$url3  = '<a href="https://wordpress.org/support/plugin/simpleform/" target="_blank" rel="noopener noreferrer">Forum</a>';
			/* translators: $1$s: SimpleForm plugin name; $2$s: WordPress.org review link; $3$s: WordPress.org review link; $4$s: WordPress.org support forum link. */
			$text = '<span id="footer-thankyou">' . sprintf( __( 'If you like %1$s please leave us a %2$s rating on %3$s. If you have new ideas, please tell on %4$s. Thank you for your support!', 'simpleform-contact-form-submissions' ), $plugin, $url1, $url2, $url3 ) . '</span>';
		}
      }	  

      else { 
	      $wptext = sprintf( __( 'Thank you for creating with <a href="%s">WordPress</a>.' ), __( 'https://wordpress.org/' ));
	      $text = '<span id="footer-thankyou">'.$wptext.'</span>'; 
	  }	
        
	  return $text;
		
	}

}