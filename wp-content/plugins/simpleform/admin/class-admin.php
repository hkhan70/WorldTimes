<?php

/**
 * Defines the admin-specific functionality of the plugin.
 *
 * @since      1.0
 */
	 
class SimpleForm_Admin {

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
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0
     */  
     
    public function sform_admin_menu() {
	    
      $item = esc_html__('Contacts', 'simpleform');           
      $item_menu = apply_filters( 'sform_notification_bubble', $item );
      $hook = add_menu_page(__('Contacts', 'simpleform'), $item_menu,'activate_plugins','sform-submissions', array($this,'display_submissions_page'),'dashicons-email-alt', 24 );      
   
      global $sform_submissions_page;
      $sform_submissions_page = add_submenu_page('sform-submissions', esc_html__('Submissions','simpleform'), esc_html__('Submissions','simpleform'), 'activate_plugins', 'sform-submissions', array($this,'display_submissions_page'));

      global $sform_contact_options_page;
      $sform_contact_options_page = add_submenu_page('sform-submissions', esc_html__('Form Editor', 'simpleform'), esc_html__('Form Editor', 'simpleform'), 'activate_plugins', 'sform-editing', array($this,'display_editing_page'));

      global $settings_page;
      $settings_page = add_submenu_page('sform-submissions', esc_html__('Settings', 'simpleform'), esc_html__('Settings', 'simpleform'), 'manage_options', 'sform-settings', array($this,'display_settings_page'));

      do_action('load_submissions_table_options');
      do_action('sform_submissions_submenu');

   }
  
    /**
     * Render the submissions page for this plugin.
     *
     * @since    1.0
     */
     
    public function display_submissions_page() {
      
      include_once('partials/submissions.php');
   
    }

    /**
     * Render the editing page for this plugin.
     *
     * @since    1.0
     */
    
    public function display_editing_page() {
     
      include_once('partials/editing.php');
    
    }

    /**
     * Render the settings page for this plugin.
     * @since    1.0
     */
    
    public function display_settings_page() {
      
      include_once('partials/settings.php');
    
    }

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0
	 */
    
    public function enqueue_styles($hook) {
	    		
	 wp_register_style( 'sform-style', plugins_url('/css/admin.css',__FILE__));
	 
     global $sform_submissions_page;
     global $sform_contact_options_page;
     global $settings_page;
     global $pagenow;
	   
     if( $hook != $sform_submissions_page && $hook != $sform_contact_options_page && $hook != $settings_page && $pagenow != 'widgets.php' ) 
     return;

	 wp_enqueue_style('sform-style'); 
	      
	}
	
	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0
	 */
	
	public function enqueue_scripts($hook){
	    		
     global $sform_submissions_page;
     global $sform_contact_options_page;
     global $settings_page;

     if( $hook != $sform_submissions_page && $hook != $sform_contact_options_page &&  $hook != $settings_page ) 
     return;
     
     $settings = get_option('sform_settings'); 
     $attributes = get_option('sform_attributes');
     $name_length = isset( $attributes['name_minlength'] ) ? esc_attr($attributes['name_minlength']) : '2';
     $name_numeric_error = ! empty( $settings['incomplete_name'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_name']) == $name_length ? stripslashes(esc_attr($settings['incomplete_name'])) : sprintf( __('Please enter at least %d characters', 'simpleform' ), $name_length );
     $name_generic_error = ! empty( $settings['incomplete_name'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_name']) == '' ? stripslashes(esc_attr($settings['incomplete_name'])) : esc_attr__('Please type your full name', 'simpleform' );
     $lastname_length = isset( $attributes['lastname_minlength'] ) ? esc_attr($attributes['lastname_minlength']) : '2';
     $lastname_numeric_error = ! empty( $settings['incomplete_lastname'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_lastname']) == $lastname_length ? stripslashes(esc_attr($settings['incomplete_lastname'])) : sprintf( __('Please enter at least %d characters', 'simpleform' ), $lastname_length );
     $lastname_generic_error = ! empty( $settings['incomplete_lastname'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_lastname']) == '' ? stripslashes(esc_attr($settings['incomplete_lastname'])) : esc_attr__('Please type your full last name', 'simpleform' );
     $subject_length = isset( $attributes['subject_minlength'] ) ? esc_attr($attributes['subject_minlength']) : '5';
     $subject_numeric_error = ! empty( $settings['incomplete_subject'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_subject']) == $subject_length ? stripslashes(esc_attr($settings['incomplete_subject'])) : sprintf( __('Please enter a subject at least %d characters long', 'simpleform' ), $subject_length );
     $subject_generic_error = ! empty( $settings['incomplete_subject'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_subject']) == '' ? stripslashes(esc_attr($settings['incomplete_subject'])) : esc_attr__('Please type a short and specific subject', 'simpleform' );
     $message_length = isset( $attributes['message_minlength'] ) ? esc_attr($attributes['message_minlength']) : '10';
     $message_numeric_error = ! empty( $settings['incomplete_message'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_message']) == $message_length ? stripslashes(esc_attr($settings['incomplete_message'])) : sprintf( __('Please enter a message at least %d characters long', 'simpleform' ), $message_length );
     $message_generic_error = ! empty( $settings['incomplete_message'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_message']) == '' ? stripslashes(esc_attr($settings['incomplete_message'])) : esc_attr__('Please type a clearer message so we can respond appropriately', 'simpleform' );
     $privacy_string = __( 'privacy policy','simpleform');
     /* translators: It is used in place of placeholder %s in the string: "Please enter an error message to be displayed on %s of the form" */
     $top_position = esc_attr__('top', 'simpleform');
     /* translators: It is used in place of placeholder %s in the string: "Please enter an error message to be displayed on %s of the form" */
     $bottom_position = esc_attr__('bottom', 'simpleform');
     /* translators: It is used in place of placeholder %1$s in the string: "%1$s or %2$s the page content" */
     $edit = __( 'Edit','simpleform');
     /* translators: It is used in place of placeholder %2$s in the string: "%1$s or %2$s the page content" */
     $view = __( 'view','simpleform');
     $page_links = sprintf( __('%1$s or %2$s the page content', 'simpleform'), $edit, $view); 

     wp_enqueue_script( 'sform_saving_options', plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), $this->version, false );
     wp_localize_script( 'sform_saving_options', 'ajax_sform_settings_options_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 	'copy' => esc_html__( 'Copy', 'simpleform' ), 'copied' => esc_html__( 'Copied', 'simpleform' ), 'saving' => esc_html__( 'Saving data in progress', 'simpleform' ), 'loading' => esc_html__( 'Saving settings in progress', 'simpleform' ), 'notes' => esc_html__( 'Create a directory inside your active theme\'s directory, name it "simpleform", copy one of the template files, and name it "custom-template.php"', 'simpleform' ), 'bottomnotes' => esc_html__( 'Display an error message on bottom of the form in case of one or more errors in the fields','simpleform'), 'topnotes' => esc_html__( 'Display an error message on top of the form in case of one or more errors in the fields','simpleform'), 'nofocus' => esc_html__( 'Do not move focus','simpleform'), 'focusout' => esc_html__( 'Set focus to error message outside','simpleform'), 'builder' => esc_html__( 'Change easily the way your contact form is displayed. Choose which fields to use and who should see them:', 'simpleform' ), 'appearance' => esc_html__( 'Tweak the appearance of your contact form to match it better with your site.', 'simpleform' ), 'adminurl' => admin_url(), 'pageurl' => site_url(), 'status' => esc_html__( 'Page in draft status not yet published','simpleform'), 'publish' =>  esc_html__( 'Publish now','simpleform'), 'edit' => $edit, 'view' => $view, 'pagelinks' => $page_links, 'show' => esc_html__( 'Show Configuration Warnings', 'simpleform' ), 'hide' => esc_html__( 'Hide Configuration Warnings', 'simpleform' ), 'cssenabled' => esc_html__( 'Create a directory inside your active theme\'s directory, name it "simpleform", add your CSS stylesheet file, and name it "custom-style.css"', 'simpleform' ), 'cssdisabled' => esc_html__( 'Keep unchecked if you want to use your personal CSS code and include it somewhere in your theme\'s code without using an additional file', 'simpleform' ), 'jsenabled' => esc_html__( 'Create a directory inside your active theme\'s directory, name it "simpleform", add your JavaScript file, and name it "custom-script.js"', 'simpleform' ), 'widgetjs' => esc_html__( 'Create a directory inside your active theme\'s directory, name it "simpleform", add your JavaScript file, and name it "custom-widget-script.js"', 'simpleform' ), 'jsdisabled' => esc_html__( 'Keep unchecked if you want to use your personal JavaScript code and include it somewhere in your theme\'s code without using an additional file', 'simpleform' ), 'showcharacters' => esc_html__('Keep unchecked if you want to use a generic error message without showing the minimum number of required characters', 'simpleform' ), 'hidecharacters' => esc_html__('Keep checked if you want to show the minimum number of required characters and you want to make sure that\'s exactly the number you set for that specific field', 'simpleform' ), 'numnamer' => $name_numeric_error, 'gennamer' => $name_generic_error, 'numlster' => $lastname_numeric_error, 'genlster' => $lastname_generic_error, 'numsuber' => $subject_numeric_error, 'gensuber' => $subject_generic_error, 'nummsger' => $message_numeric_error, 'genmsger' => $message_generic_error, 'privacy' => $privacy_string, 'top' => $top_position, 'bottom' => $bottom_position )); 
	      
	}
	
	/**
	 * Enable SMTP server for outgoing emails
	 *
	 * @since    1.0
	 */

	public function check_smtp_server() {
		
       $settings = get_option('sform_settings');
       $server_smtp = ! empty( $settings['server_smtp'] ) ? esc_attr($settings['server_smtp']) : 'false';
       if ( $server_smtp == 'true' ) { add_action( 'phpmailer_init', array($this,'sform_enable_smtp_server') ); }
       else { remove_action( 'phpmailer_init', 'sform_enable_smtp_server' ); }
   
   }

	/**
	 * Save SMTP server configuration.
	 *
	 * @since    1.0
	 */
	
    public function sform_enable_smtp_server( $phpmailer ) {
   
      $settings = get_option('sform_settings');
      $smtp_host = ! empty( $settings['smtp_host'] ) ? esc_attr($settings['smtp_host']) : '';
      $smtp_encryption = ! empty( $settings['smtp_encryption'] ) ? esc_attr($settings['smtp_encryption']) : '';
      $smtp_port = ! empty( $settings['smtp_port'] ) ? esc_attr($settings['smtp_port']) : '';
      $smtp_authentication = isset( $settings['smtp_authentication'] ) ? esc_attr($settings['smtp_authentication']) : '';
      $smtp_username = ! empty( $settings['smtp_username'] ) ? esc_attr($settings['smtp_username']) : '';
      $smtp_password = ! empty( $settings['smtp_password'] ) ? esc_attr($settings['smtp_password']) : '';
      $username = defined( 'SFORM_SMTP_USERNAME' ) ? SFORM_SMTP_USERNAME : $smtp_username;
      $password = defined( 'SFORM_SMTP_PASSWORD' ) ? SFORM_SMTP_PASSWORD : $smtp_password;
      $phpmailer->isSMTP();
      $phpmailer->Host       = $smtp_host;
      $phpmailer->SMTPAuth   = $smtp_authentication;
      $phpmailer->Port       = $smtp_port;
      $phpmailer->SMTPSecure = $smtp_encryption;
      $phpmailer->Username   = $username;
      $phpmailer->Password   = $password;

    }

	/**
	 * Edit the contact form fields.
	 *
	 * @since    1.0
	 */
	
    public function shortcode_costruction() {

      if( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {	die ( 'Security checked!'); }
      if ( ! wp_verify_nonce( $_POST['verification_nonce'], "ajax-verification-nonce")) { exit("Security checked!"); }   
      if ( ! current_user_can('update_plugins')) { exit("Security checked!"); }   
   
      else { 
	      	   
       $widget_id = isset( $_POST['widget-id'] ) ? absint($_POST['widget-id']) : '';
       $widget_for = isset($_POST['widget-for']) ? sanitize_text_field($_POST['widget-for']) : 'all';
       $widget_editor = isset( $_POST['widget-editor'] ) ? sanitize_text_field($_POST['widget-editor']) : '';
       $form_name_value = isset($_POST['form-name']) ? sanitize_text_field($_POST['form-name']) : '';
       if ( $widget_id == '' ) { 
         $form_name = $form_name_value == '' ? __( 'Contact Us Page','simpleform') : $form_name_value;
       } else {
         $form_name = $form_name_value == '' ? __( 'Contact Form','simpleform') : $form_name_value;
      }
       $introduction_text = isset($_POST['introduction-text']) ? wp_kses_post(trim($_POST['introduction-text'])) : '';
       $bottom_text = isset($_POST['bottom-text']) ? wp_kses_post(trim($_POST['bottom-text'])) : '';    
       $name_field = isset($_POST['name-field']) ? sanitize_text_field($_POST['name-field']) : 'visible';
       $name_visibility = isset($_POST['name-visibility']) ? 'hidden' : 'visible';
       $name_label = isset($_POST['name-label']) ? sanitize_text_field(trim($_POST['name-label'])) : '';
       $name_placeholder = isset($_POST['name-placeholder']) ? sanitize_text_field($_POST['name-placeholder']) : '';
       $name_minlength = isset($_POST['name-minlength']) ? intval($_POST['name-minlength']) : '2';
       $name_maxlength = isset($_POST['name-maxlength']) ? intval($_POST['name-maxlength']) : '0';       
       $name_requirement = isset($_POST['name-requirement']) ? 'required' : 'optional';
       $lastname_field = isset($_POST['lastname-field']) ? sanitize_text_field($_POST['lastname-field']) : 'visible';
       $lastname_visibility = isset($_POST['lastname-visibility']) ? 'hidden' : 'visible';
       $lastname_label = isset($_POST['lastname-label']) ? sanitize_text_field(trim($_POST['lastname-label'])) : '';
       $lastname_placeholder = isset($_POST['lastname-placeholder']) ? sanitize_text_field($_POST['lastname-placeholder']) : '';
       $lastname_minlength = isset($_POST['lastname-minlength']) ? intval($_POST['lastname-minlength']) : '2';
       $lastname_maxlength = isset($_POST['lastname-maxlength']) ? intval($_POST['lastname-maxlength']) : '0';       
       $lastname_requirement = isset($_POST['lastname-requirement']) ? 'required' : 'optional';
       $email_field = isset($_POST['email-field']) ? sanitize_text_field($_POST['email-field']) : 'visible';
       $email_visibility = isset($_POST['email-visibility']) ? 'hidden' : 'visible';
       $email_label = isset($_POST['email-label']) ? sanitize_text_field(trim($_POST['email-label'])) : '';
       $email_placeholder = isset($_POST['email-placeholder']) ? sanitize_text_field($_POST['email-placeholder']) : '';
       $email_requirement = isset($_POST['email-requirement']) ? 'required' : 'optional';
       $phone_field = isset($_POST['phone-field']) ? sanitize_text_field($_POST['phone-field']) : 'visible';
       $phone_visibility = isset($_POST['phone-visibility']) ? 'hidden' : 'visible';
       $phone_label = isset($_POST['phone-label']) ? sanitize_text_field(trim($_POST['phone-label'])) : '';
       $phone_placeholder = isset($_POST['phone-placeholder']) ? sanitize_text_field($_POST['phone-placeholder']) : '';
       $phone_requirement = isset($_POST['phone-requirement']) ? 'required' : 'optional';
       $subject_field = isset($_POST['subject-field']) ? sanitize_text_field($_POST['subject-field']) : 'visible';
       $subject_visibility = isset($_POST['subject-visibility']) ? 'hidden' : 'visible';
       $subject_label = isset($_POST['subject-label']) ? sanitize_text_field(trim($_POST['subject-label'])) : '';
       $subject_placeholder = isset($_POST['subject-placeholder']) ? sanitize_text_field($_POST['subject-placeholder']) : '';
       $subject_minlength = isset($_POST['subject-minlength']) ? intval($_POST['subject-minlength']) : '5';
       $subject_maxlength = isset($_POST['subject-maxlength']) ? intval($_POST['subject-maxlength']) : '0';       
       $subject_requirement = isset($_POST['subject-requirement']) ? 'required' : 'optional';
       $message_visibility = isset($_POST['message-visibility']) ? 'hidden' : 'visible';
       $message_label = isset($_POST['message-label']) ? sanitize_text_field(trim($_POST['message-label'])) : '';
       $message_placeholder = isset($_POST['message-placeholder']) ? sanitize_text_field($_POST['message-placeholder']) : '';
       $message_minlength = isset($_POST['message-minlength']) ? intval($_POST['message-minlength']) : '10';
       $message_maxlength = isset($_POST['message-maxlength']) ? intval($_POST['message-maxlength']) : '0';  
       $consent_field = isset($_POST['consent-field']) ? sanitize_text_field($_POST['consent-field']) : 'visible';
       $consent_label = isset($_POST['consent-label']) ? wp_kses_post(trim($_POST['consent-label'])) : '';    
       $privacy_url = isset($_POST['privacy-page']) && intval($_POST['privacy-page']) > 0 ? get_page_link($_POST['privacy-page']) : '';
       /* translators: It is used within the string "I have read and consent to the %s", and it can be replaced with the hyperlink to the privacy policy page */       
       $privacy_string = __( 'privacy policy','simpleform');
       $link = $privacy_url != '' ? '<a href="' . $privacy_url . '" target="_blank">' . $privacy_string . '</a>' : '';
       $privacy_link = isset($_POST['privacy-link']) && isset($_POST['privacy-page']) && $_POST['privacy-page'] != '' && strpos($consent_label, $link) !== false ? 'true' : 'false';
       $privacy_page = isset($_POST['privacy-page']) ? intval($_POST['privacy-page']) : '0';         
       $consent_requirement = isset($_POST['consent-requirement']) ? 'required' : 'optional';
       $captcha_field = isset($_POST['captcha-field']) ? sanitize_text_field($_POST['captcha-field']) : 'hidden';
       $captcha_label = isset($_POST['captcha-label']) ? sanitize_text_field(trim($_POST['captcha-label'])) : '';
       $submit_label = isset($_POST['submit-label']) ? sanitize_text_field(trim($_POST['submit-label'])) : '';
       $label_position = isset($_POST['label-position']) ? sanitize_key($_POST['label-position']) : 'top';
       $required_sign = isset($_POST['required-sign']) ? 'true' : 'false';
       $required_word = isset($_POST['required-word']) ? sanitize_text_field(trim($_POST['required-word'])) : '';
       $word_position = isset($_POST['word-position']) ? sanitize_key($_POST['word-position']) : 'required';
       $lastname_alignment = isset($_POST['lastname-alignment']) ? sanitize_key($_POST['lastname-alignment']) : 'name';
       $phone_alignment = isset($_POST['phone-alignment']) ? sanitize_key($_POST['phone-alignment']) : 'alone';
       $submit_position = isset($_POST['submit-position']) ? sanitize_text_field($_POST['submit-position']) : 'centred';
       $form_direction = isset($_POST['form-direction']) ? sanitize_key($_POST['form-direction']) : 'ltr';
       
       if ( !empty($widget_id) && !empty($widget_editor) && $widget_editor == 'false' )  { 
            $widget_name =  __('SimpleForm Contact Form Widget', 'simpleform');
            $message = sprintf( __('You need to enable the "Override Editor" option in the %s for the changes to take effect', 'simpleform' ), $widget_name );
	        echo json_encode(array('error' => true, 'update' => false, 'message' => $message ));
	        exit; 
       }
   
       global $wpdb;
       $table_shortcodes = $wpdb->prefix . 'sform_shortcodes';
       if ( $widget_id == '' ) {
       $update_shortcode = $wpdb->update($table_shortcodes, array('name' => $form_name ), array('shortcode' => 'simpleform' ));
       $update_result = $update_shortcode ? 'done' : '';
       }
       else {
       $update_shortcode = $wpdb->update($table_shortcodes, array('name' => $form_name ), array('shortcode' => 'simpleform widget="'.$widget_id.'"' ));
       $update_result = $update_shortcode ? 'done' : '';
       }       

       if ( $privacy_link == 'false' ) { 
	       $privacy_page = '0'; 
           $pattern = '/<a [^>]*>'.$privacy_string.'<\/a>/i';              
           $consent_label = preg_replace($pattern,$privacy_string,html_entity_decode($consent_label));
       }

       if ( $name_maxlength <= $name_minlength && $name_maxlength != 0 ) {
       echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'The maximum name length must not be less than the minimum name length', 'simpleform' ) ));
	   exit;
       }
       
       if ( $name_minlength == 0 && $name_requirement == 'required' ) {
       echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'You cannot set up a minimum length equal to 0 if the name field is required', 'simpleform' ) ));
	   exit;
       }
       
       if ( $lastname_maxlength <= $lastname_minlength && $lastname_maxlength != 0 ) {
       echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'The maximum last name length must not be less than the minimum last name length', 'simpleform' ) ));
	   exit;
       }

       if ( $lastname_minlength == 0 && $lastname_requirement == 'required' ) {
       echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'You cannot set up a minimum length equal to 0 if the last name field is required', 'simpleform' ) ));
	   exit;
       }

       if ( $subject_maxlength <= $subject_minlength && $subject_maxlength != 0 ) {
       echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'The maximum subject length must not be less than the minimum subject length', 'simpleform' ) ));
	   exit;
       }

       if ( $subject_minlength == 0 && $subject_requirement == 'required' ) {
       echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'You cannot set up a minimum length equal to 0 if the subject field is required', 'simpleform' ) ));
	   exit;
       }

       if ( $message_maxlength <= $message_minlength && $message_maxlength != 0 ) {
       echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'The maximum message length must not be less than the minimum message length', 'simpleform' ) ));
	   exit;
       }

       if ( ( $name_visibility == 'hidden' ||  $lastname_visibility == 'hidden' || $email_visibility == 'hidden' || $phone_visibility == 'hidden' || $subject_visibility == 'hidden' || $message_visibility == 'hidden' ) && $label_position == 'inline' ) {	       
	   $message = $form_direction == 'ltr' ? esc_html__( 'Labels cannot be left aligned if you have set a field label as hidden', 'simpleform' ) : esc_html__( 'Labels cannot be right aligned if you have set a field label as hidden', 'simpleform' );    
       echo json_encode(array('error' => true, 'update' => false, 'message' => $message ));
	   exit;
       }

       $attributes = array( 'form_name' => $form_name, 'introduction_text' => $introduction_text, 'bottom_text' => $bottom_text, 'name_field' => $name_field, 'name_visibility' => $name_visibility, 'name_label' => $name_label, 'name_placeholder' => $name_placeholder, 'name_minlength' => $name_minlength, 'name_maxlength' => $name_maxlength, 'name_requirement' => $name_requirement, 'lastname_field' => $lastname_field, 'lastname_visibility' => $lastname_visibility, 'lastname_label' => $lastname_label, 'lastname_placeholder' => $lastname_placeholder, 'lastname_minlength' => $lastname_minlength, 'lastname_maxlength' => $lastname_maxlength, 'lastname_requirement' => $lastname_requirement, 'email_field' => $email_field, 'email_visibility' => $email_visibility, 'email_label' => $email_label, 'email_placeholder' => $email_placeholder, 'email_requirement' => $email_requirement, 'phone_field' => $phone_field, 'phone_visibility' => $phone_visibility, 'phone_label' => $phone_label, 'phone_placeholder' => $phone_placeholder, 'phone_requirement' => $phone_requirement, 'subject_field' => $subject_field, 'subject_visibility' => $subject_visibility, 'subject_label' => $subject_label, 'subject_placeholder' => $subject_placeholder, 'subject_minlength' => $subject_minlength, 'subject_maxlength' => $subject_maxlength, 'subject_requirement' => $subject_requirement, 'message_visibility' => $message_visibility, 'message_label' => $message_label, 'message_placeholder' => $message_placeholder, 'message_minlength' => $message_minlength, 'message_maxlength' => $message_maxlength, 'consent_field' => $consent_field, 'consent_label' => $consent_label, 'privacy_link' => $privacy_link, 'privacy_page' => $privacy_page, 'consent_requirement' => $consent_requirement, 'captcha_field' => $captcha_field, 'captcha_label' => $captcha_label, 'submit_label' => $submit_label, 'label_position' => $label_position, 'required_sign' => $required_sign, 'required_word' => $required_word, 'word_position' => $word_position, 'lastname_alignment' => $lastname_alignment, 'phone_alignment' => $phone_alignment, 'submit_position' => $submit_position, 'form_direction' => $form_direction );     
       
       if ( $widget_for == 'out' ) {
	      $widget_name_field = isset($_POST['name-field']) ? 'hidden' : 'anonymous';
	      $widget_lastname_field = isset($_POST['lastname-field']) ? 'hidden' : 'anonymous';
          $widget_email_field = isset($_POST['email-field']) ? 'hidden' : 'anonymous';
          $widget_phone_field = isset($_POST['phone-field']) ? 'hidden' : 'anonymous';
          $widget_subject_field = isset($_POST['subject-field']) ? 'hidden' : 'anonymous';
          $widget_consent_field = isset($_POST['consent-field']) ? 'hidden' : 'anonymous';
          $widget_captcha_field = isset($_POST['captcha-field']) ? 'hidden' : 'anonymous';
       }
       elseif ( $widget_for == 'in' ) {
	      $widget_name_field = isset($_POST['name-field']) ? 'hidden' : 'registered';
	      $widget_lastname_field = isset($_POST['lastname-field']) ? 'hidden' : 'registered';
          $widget_email_field = isset($_POST['email-field']) ? 'hidden' : 'registered';
          $widget_phone_field = isset($_POST['phone-field']) ? 'hidden' : 'registered';
          $widget_subject_field = isset($_POST['subject-field']) ? 'hidden' : 'registered';
          $widget_consent_field = isset($_POST['consent-field']) ? 'hidden' : 'registered';
          $widget_captcha_field = isset($_POST['captcha-field']) ? 'hidden' : 'registered';
       }
       else {
	      $widget_name_field = $name_field; 
	      $widget_lastname_field = $lastname_field; 
	      $widget_email_field = $email_field; 
          $widget_phone_field = $phone_field; 
          $widget_subject_field = $subject_field; 
	      $widget_consent_field = $consent_field; 
	      $widget_captcha_field = $captcha_field; 
       }
       
       $widget_attributes = array( 'form_name' => $form_name, 'introduction_text' => $introduction_text, 'bottom_text' => $bottom_text, 'name_field' => $widget_name_field, 'name_visibility' => $name_visibility, 'name_label' => $name_label, 'name_placeholder' => $name_placeholder, 'name_minlength' => $name_minlength, 'name_maxlength' => $name_maxlength, 'name_requirement' => $name_requirement, 'lastname_field' => $widget_lastname_field, 'lastname_visibility' => $lastname_visibility, 'lastname_label' => $lastname_label, 'lastname_placeholder' => $lastname_placeholder, 'lastname_minlength' => $lastname_minlength, 'lastname_maxlength' => $lastname_maxlength, 'lastname_requirement' => $lastname_requirement, 'email_field' => $widget_email_field, 'email_visibility' => $email_visibility, 'email_label' => $email_label, 'email_placeholder' => $email_placeholder, 'email_requirement' => $email_requirement, 'phone_field' => $widget_phone_field, 'phone_visibility' => $phone_visibility, 'phone_label' => $phone_label, 'phone_placeholder' => $phone_placeholder, 'phone_requirement' => $phone_requirement, 'subject_field' => $widget_subject_field, 'subject_visibility' => $subject_visibility, 'subject_label' => $subject_label, 'subject_placeholder' => $subject_placeholder, 'subject_minlength' => $subject_minlength, 'subject_maxlength' => $subject_maxlength, 'subject_requirement' => $subject_requirement, 'message_visibility' => $message_visibility, 'message_label' => $message_label, 'message_placeholder' => $message_placeholder, 'message_minlength' => $message_minlength, 'message_maxlength' => $message_maxlength, 'consent_field' => $widget_consent_field, 'consent_label' => $consent_label, 'privacy_link' => $privacy_link, 'privacy_page' => $privacy_page, 'consent_requirement' => $consent_requirement, 'captcha_field' => $widget_captcha_field, 'captcha_label' => $captcha_label, 'submit_label' => $submit_label, 'label_position' => $label_position, 'required_sign' => $required_sign, 'required_word' => $required_word, 'word_position' => $word_position, 'lastname_alignment' => $lastname_alignment, 'phone_alignment' => $phone_alignment, 'submit_position' => $submit_position, 'form_direction' => $form_direction ); 

       if ( $widget_id == '' ) {
          $update_attributes = update_option('sform_attributes', $attributes); 
       } else {
          $update_attributes = update_option('sform_widget_'.$widget_id.'_attributes', $widget_attributes); 
       }
       
       if ($update_attributes) { $update_result .= 'done'; }

       if ( $update_result ) {
	       
       global $wpdb;
       $query = "SELECT ID, post_title, guid FROM ".$wpdb->posts." WHERE post_content LIKE '%[simpleform]%' AND post_status = 'publish'";
       $results = $wpdb->get_results ($query);
       $shortcode_pages = wp_list_pluck( $results, 'ID' );
       set_transient('sform_shortcode_pages', $shortcode_pages, 0 );
	       
       echo json_encode(array('error' => false, 'update' => true, 'message' => esc_html__( 'The contact form has been updated', 'simpleform' ) ));
	   exit;
       }
   
       else {
       echo json_encode(array('error' => false, 'update' => false, 'message' => esc_html__( 'The contact form has already been updated', 'simpleform' ) ));
	   exit;
       }
      
       die();
       
      }

    }
   
	/**
	 * Edit settings
	 *
	 * @since    1.0
	 */
	
    public function sform_edit_options() {

      if( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {	die ( 'Security checked!'); }
      if ( ! wp_verify_nonce( $_POST['verification_nonce'], "ajax-verification-nonce")) { exit("Security checked!"); }   
      if ( ! current_user_can('update_plugins')) { exit("Security checked!"); }   
   
      else {
	      
	   $previous_settings = get_option('sform_settings'); 
	   $admin_notices = isset($_POST['admin-notices']) ? 'true' : 'false';
       $html5_validation = isset($_POST['html5-validation']) ? 'true' : 'false';
       $focus = isset($_POST['focus']) ? sanitize_key($_POST['focus']) : 'field';
       $ajax_submission = isset($_POST['ajax-submission']) ? 'true' : 'false';
       $spinner = isset($_POST['spinner']) ? 'true' : 'false';
       $template = isset($_POST['form-template']) ? sanitize_text_field($_POST['form-template']) : 'default';
       $stylesheet = isset($_POST['stylesheet']) ? 'true' : 'false';
       $cssfile = isset($_POST['stylesheet-file']) ? 'true' : 'false';
       $javascript = isset($_POST['javascript']) ? 'true' : 'false';
       $uninstall = isset($_POST['deletion']) ? 'true' : 'false';
       $outside_error = isset($_POST['outside-error']) ? sanitize_text_field($_POST['outside-error']) : 'bottom';
       $characters_length = isset($_POST['characters-length']) ? 'true' : 'false';
       $empty_fields = isset($_POST['empty-fields']) ? sanitize_text_field(trim($_POST['empty-fields'])) : '';
       $empty_name = isset($_POST['empty-name']) ? sanitize_text_field(trim($_POST['empty-name'])) : '';
       $empty_lastname = isset($_POST['empty-lastname']) ? sanitize_text_field(trim($_POST['empty-lastname'])) : '';
       $empty_phone = isset($_POST['empty-phone']) ? sanitize_text_field(trim($_POST['empty-phone'])) : '';
       $empty_email = isset($_POST['empty-email']) ? sanitize_text_field(trim($_POST['empty-email'])) : '';
       $empty_subject = isset($_POST['empty-subject']) ? sanitize_text_field(trim($_POST['empty-subject'])) : '';
       $empty_message = isset($_POST['empty-message']) ? sanitize_text_field(trim($_POST['empty-message'])) : '';
       $empty_captcha = isset($_POST['empty-captcha']) ? sanitize_text_field(trim($_POST['empty-captcha'])) : '';
       $incomplete_name = isset($_POST['incomplete-name']) ? sanitize_text_field(trim($_POST['incomplete-name'])) : '';
       $invalid_name = isset($_POST['invalid-name']) ? sanitize_text_field(trim($_POST['invalid-name'])) : '';
       $name_error = isset($_POST['name-error']) ? sanitize_text_field(trim($_POST['name-error'])) : '';
       $incomplete_lastname = isset($_POST['incomplete-lastname']) ? sanitize_text_field(trim($_POST['incomplete-lastname'])) : '';
       $invalid_lastname = isset($_POST['invalid-lastname']) ? sanitize_text_field(trim($_POST['invalid-lastname'])) : '';
       $lastname_error = isset($_POST['lastname-error']) ? sanitize_text_field(trim($_POST['lastname-error'])) : '';
       $invalid_email = isset($_POST['invalid-email']) ? sanitize_text_field(trim($_POST['invalid-email'])) : '';
       $email_error = isset($_POST['email-error']) ? sanitize_text_field(trim($_POST['email-error'])) : '';       
       $invalid_phone = isset($_POST['invalid-phone']) ? sanitize_text_field(trim($_POST['invalid-phone'])) : '';
       $phone_error = isset($_POST['phone-error']) ? sanitize_text_field(trim($_POST['phone-error'])) : '';
       $incomplete_subject = isset($_POST['incomplete-subject']) ? sanitize_text_field(trim($_POST['incomplete-subject'])) : '';
       $invalid_subject = isset($_POST['invalid-subject']) ? sanitize_text_field(trim($_POST['invalid-subject'])) : '';
       $subject_error = isset($_POST['subject-error']) ? sanitize_text_field(trim($_POST['subject-error'])) : '';
       $incomplete_message = isset($_POST['incomplete-message']) ? sanitize_text_field(trim($_POST['incomplete-message'])) : '';
       $invalid_message = isset($_POST['invalid-message']) ? sanitize_text_field(trim($_POST['invalid-message'])) : '';
       $message_error = isset($_POST['message-error']) ? sanitize_text_field(trim($_POST['message-error'])) : '';
       $consent_error = isset($_POST['consent-error']) ? sanitize_text_field(trim($_POST['consent-error'])) : '';
       $invalid_captcha = isset($_POST['invalid-captcha']) ? sanitize_text_field(trim($_POST['invalid-captcha'])) : '';
       $captcha_error = isset($_POST['captcha-error']) ? sanitize_text_field(trim($_POST['captcha-error'])) : '';
       $honeypot_error = isset($_POST['honeypot-error']) ? sanitize_text_field(trim($_POST['honeypot-error'])) : '';
       $server_error = isset($_POST['server-error']) ? sanitize_text_field(trim($_POST['server-error'])) : '';
       $ajax_error = isset($_POST['ajax-error']) ? sanitize_text_field(trim($_POST['ajax-error'])) : '';
       $success_action =  isset($_POST['success-action']) ? sanitize_key($_POST['success-action']) : '';
       $success_message = isset($_POST['success-message']) ? wp_kses_post(trim($_POST['success-message'])) : '';
       $confirmation_page = isset($_POST['confirmation-page']) ? sanitize_text_field($_POST['confirmation-page']) : '';
       $thanks_url = ! empty($confirmation_page) ? esc_url_raw(get_the_guid( $confirmation_page )) : ''; 
       $server_smtp = isset($_POST['server-smtp']) ? 'true' : 'false';
       $smtp_host = isset($_POST['smtp-host']) ? sanitize_text_field(trim($_POST['smtp-host'])) : '';
       $smtp_encryption = isset($_POST['smtp-encryption']) ? sanitize_key($_POST['smtp-encryption']) : '';
       $smtp_port = isset($_POST['smtp-port']) ? sanitize_text_field(trim($_POST['smtp-port'])) : '';
       $smtp_authentication = isset($_POST['smtp-authentication']) ? 'true' : 'false';
       $smtp_username = isset($_POST['smtp-username']) ? sanitize_text_field(trim($_POST['smtp-username'])) : '';
       $smtp_password = isset($_POST['smtp-password']) ? sanitize_text_field(trim($_POST['smtp-password'])) : '';
       $username = defined( 'SFORM_SMTP_USERNAME' ) ? SFORM_SMTP_USERNAME : $smtp_username;
       $password = defined( 'SFORM_SMTP_PASSWORD' ) ? SFORM_SMTP_PASSWORD : $smtp_password;
       $notification = isset($_POST['notification']) ? 'true' : 'false';       
       $notification_recipient = isset($_POST['notification-recipient']) ? sanitize_text_field(trim($_POST['notification-recipient'])) : '';
       $notification_recipients = str_replace(' ', '', $notification_recipient);
       $bcc = isset($_POST['bcc']) ? sanitize_text_field(trim($_POST['bcc'])) : '';      
       $notification_bcc = str_replace(' ', '', $bcc);
       $notification_email = isset($_POST['notification-email']) ? sanitize_text_field(trim($_POST['notification-email'])) : '';
       $notification_name = isset($_POST['notification-name']) ? sanitize_key($_POST['notification-name']) : '';
       $custom_sender = isset($_POST['custom-sender']) ? sanitize_text_field(trim($_POST['custom-sender'])) : '';
       $notification_subject = isset($_POST['notification-subject']) ? sanitize_key($_POST['notification-subject']) : '';
       $custom_subject = isset($_POST['custom-subject']) ? sanitize_text_field(trim($_POST['custom-subject'])) : '';
       // $notification_message = isset($_POST['notification-message']) ? wp_kses_post(trim($_POST['notification-message'])) : '';
       $notification_reply = isset($_POST['notification-reply']) ? 'true' : 'false';       
       $submission_number = isset($_POST['submission-number']) ? 'hidden' : 'visible';
       $autoresponder = isset($_POST['autoresponder']) ? 'true' : 'false';
       $autoresponder_email = isset($_POST['autoresponder-email']) ? sanitize_text_field(trim($_POST['autoresponder-email'])) : '';
       $autoresponder_name = isset($_POST['autoresponder-name']) ? sanitize_text_field(trim($_POST['autoresponder-name'])) : '';
       $autoresponder_subject = isset($_POST['autoresponder-subject']) ? sanitize_text_field(trim($_POST['autoresponder-subject'])) : '';
       $autoresponder_message = isset($_POST['autoresponder-message']) ? wp_kses_post(trim($_POST['autoresponder-message'])) : '';
       $autoresponder_reply = isset($_POST['autoresponder-reply']) ? sanitize_text_field(trim($_POST['autoresponder-reply'])) : '';
	   $form_pageid = ! empty( $previous_settings['form_pageid'] ) && get_post_status($previous_settings['form_pageid']) ? absint($previous_settings['form_pageid']) : '';  
	   $confirmation_pageid = ! empty( $previous_settings['confirmation_pageid'] ) && get_post_status($previous_settings['confirmation_pageid']) ? absint($previous_settings['confirmation_pageid']) : '';	         
                     
       if ( $stylesheet != 'true' )  { $cssfile = 'false'; }
       
       if ( $ajax_submission != 'true' )  { $spinner = 'false'; }
		
       if ( $html5_validation == 'false' && $focus == 'alert' )  { 
	        echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'Focus is automatically set to first invalid field if HTML5 validation is not disabled', 'simpleform' ) ));
	        exit; 
       }

       if ( $success_action == 'message' )  { $confirmation_page = ''; }

       if ( $server_smtp == 'true' && $notification == 'false' && $autoresponder == 'false' )  { 
	        echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'The SMTP server for outgoing email cannot be enabled if the notification or confirmation email is not enabled', 'simpleform' ) ));
	        exit; 
       }
        
	   if (  $server_smtp == 'true' && empty($smtp_host) ) {
            echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'Please enter the SMTP address', 'simpleform' ) ));
	        exit; 
       }

	   if (  $server_smtp == 'true' && empty($smtp_encryption) ) {
            echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'Please enter the encryption type to relay outgoing email to the SMTP server', 'simpleform' )  ));
	        exit; 
       }

	   if (  $server_smtp == 'true' && empty($smtp_port) ) {
            echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'Please enter the port to relay outgoing email to the SMTP server', 'simpleform' )  ));
	        exit; 
       }
        
	   if (  $server_smtp == 'true' && ! ctype_digit(strval($smtp_port)) ) {
            echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'Please enter a valid port to relay outgoing email to the SMTP server', 'simpleform' ) ));
	        exit; 
       }

	   if (  $server_smtp == 'true' && $smtp_authentication == 'true' && empty( $username ) ) { 
            echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'Please enter username to log in to SMTP server', 'simpleform' )  ));
	        exit; 
       }
	
	   if (  $server_smtp == 'true' && $smtp_authentication == 'true' &&  ! empty($username) && ! is_email( $username ) ) {
            echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'Please enter a valid email address to log in to SMTP server', 'simpleform' )  ));
	        exit; 
       }
        
	   if (  $server_smtp == 'true' && $smtp_authentication == 'true' && empty( $password ) ) {
            echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'Please enter password to log in to SMTP server', 'simpleform' )  ));
	        exit; 
       }
 
       if (has_action('sforms_validate_submissions_settings')):
	       do_action('sforms_validate_submissions_settings');	
	   else:
       if ( $notification == 'false' )  { 
 	        echo json_encode(array('error' => true, 'update' => false, 'message' => esc_html__( 'You need to enable the notification email', 'simpleform' ) ));
	        exit; 
       }
	   endif;
	
       $settings = array(
	             'form_pageid' => $form_pageid,
	             'confirmation_pageid' => $confirmation_pageid,	
	             'admin_notices' => $admin_notices, 
	             'html5_validation' => $html5_validation,
	             'focus' => $focus,
                 'ajax_submission' => $ajax_submission,
                 'spinner' => $spinner,
                 'form_template' => $template,
                 'stylesheet' => $stylesheet,
                 'stylesheet_file' => $cssfile, 
                 'javascript' => $javascript,
                 'deletion_data' => $uninstall, 
                 'outside_error' => $outside_error,
                 'characters_length' => $characters_length,
                 'empty_fields' => $empty_fields,
                 'empty_name' => $empty_name,
                 'empty_lastname' => $empty_lastname,
                 'empty_phone' => $empty_phone,
                 'empty_email' => $empty_email,
                 'empty_subject' => $empty_subject,
                 'empty_message' => $empty_message,
                 'empty_captcha' => $empty_captcha,
                 'incomplete_name' => $incomplete_name, 
                 'invalid_name' => $invalid_name, 
                 'name_error' => $name_error,      
                 'incomplete_lastname' => $incomplete_lastname, 
                 'invalid_lastname' => $invalid_lastname, 
                 'lastname_error' => $lastname_error,      
                 'invalid_email' => $invalid_email,  
                 'email_error' => $email_error,  
                 'invalid_phone' => $invalid_phone, 
                 'phone_error' => $phone_error,      
                 'incomplete_subject' => $incomplete_subject, 
                 'invalid_subject' => $invalid_subject,  
                 'subject_error' => $subject_error,                    
                 'incomplete_message' => $incomplete_message,    
                 'invalid_message' => $invalid_message,
                 'message_error' => $message_error,
                 'consent_error' => $consent_error,
                 'invalid_captcha' => $invalid_captcha,    
                 'captcha_error' => $captcha_error,    
                 'honeypot_error' => $honeypot_error,    
                 'server_error' => $server_error, 
                 'ajax_error' => $ajax_error,        
                 'success_action' => $success_action,         
                 'success_message' => $success_message, 
                 'confirmation_page' => $confirmation_page,        
                 'thanks_url' => $thanks_url,
                 'server_smtp' => $server_smtp,
                 'smtp_host' => $smtp_host,
                 'smtp_encryption' => $smtp_encryption,
                 'smtp_port' => $smtp_port,
                 'smtp_authentication' => $smtp_authentication,
                 'smtp_username' => $smtp_username,
                 'smtp_password' => $smtp_password,
                 'notification' => $notification,
                 'notification_recipient' => $notification_recipients,
                 'bcc' => $notification_bcc,
                 'notification_email' => $notification_email,
                 'notification_name' => $notification_name,
                 'custom_sender' => $custom_sender,
                 'notification_subject' => $notification_subject,
                 'custom_subject' => $custom_subject,
                 // 'notification_message' => $notification_message,
                 'notification_reply' => $notification_reply,
                 'submission_number' => $submission_number,  
                 'autoresponder' => $autoresponder, 
                 'autoresponder_email' => $autoresponder_email,
                 'autoresponder_name' => $autoresponder_name,
                 'autoresponder_subject' => $autoresponder_subject,
                 'autoresponder_message' => $autoresponder_message,
                 'autoresponder_reply' => $autoresponder_reply,                 
                 ); 
 
       $submissions_fields = array('additional_fields' => '');
       $additional_sform_settings = array_merge($settings, apply_filters( 'sform_submissions_settings_filter', $submissions_fields ));
       $update_result = update_option('sform_settings', $additional_sform_settings); 
       
       if ( $update_result ) {
	       
	     global $wpdb;
         $query = "SELECT ID, post_title, guid FROM ".$wpdb->posts." WHERE post_content LIKE '%[simpleform]%' AND post_status = 'publish'";
         $results = $wpdb->get_results ($query);
         $shortcode_pages = wp_list_pluck( $results, 'ID' );
         set_transient('sform_shortcode_pages', $shortcode_pages, 0 );
	       
	     echo json_encode( array( 'error' => false, 'update' => true, 'message' => esc_html__( 'Settings were successfully saved', 'simpleform' ) ) ); 
	     exit; 
       }
      
       else {
	     echo json_encode( array( 'error' => false, 'update' => false, 'message' => esc_html__( 'Settings have already been saved', 'simpleform' ) ) );
	     exit; 	   
       }
  	         
      die();
      
      }

    }  
    
	/**
	 * Return shortcode properties
	 *
	 * @since    1.0
	 */
	
    public function sform_form_filter($attribute) { 
		
     global $wpdb;
     $table_name = $wpdb->prefix . 'sform_shortcodes';
     
     
     if ($attribute == '') {
     $form_values = $wpdb->get_row( "SELECT * FROM {$table_name}", ARRAY_A );  
     }
     else {
     $form_values = $wpdb->get_row( "SELECT * FROM {$table_name} WHERE shortcode LIKE '%{$attribute}%'", ARRAY_A );  
     }
     
     return $form_values;
     
    } 

    /**
     * Deleting the table whenever a single site into a network is deleted.
     *
     * @since    1.2
     */

    public function on_delete_blog($tables) {
      
      global $wpdb;
      $tables[] = $wpdb->prefix . 'sform_submissions';
      return $tables;
			
    }
    
	/**
	 * Add the link to the Privacy Policy page in the consent label.
	 *
	 * @since    1.9.2
	 */
	
    public function setting_privacy() {

      if( 'POST' !== $_SERVER['REQUEST_METHOD'] ) {	die ( 'Security checked!'); }
      if ( ! wp_verify_nonce( $_POST['verification_nonce'], "ajax-verification-nonce")) { exit("Security checked!"); }   
      if ( ! current_user_can('update_plugins')) { exit("Security checked!"); }   
   
      else { 
       
        $page = isset($_POST['page-id']) ? absint($_POST['page-id']) : 0;   
        $privacy_label = isset($_POST['consent-label']) ? wp_kses_post(trim($_POST['consent-label'])): ''; 
        /* translators: It is used within the string "I have read and consent to the %s", and it can be replaced with the hyperlink to the privacy policy page */       
        $privacy_string = __( 'privacy policy','simpleform');

        if ( $page > 0 ) {
    	   $link = '<a href="' . get_page_link($page) . '" target="_blank">' . $privacy_string . '</a>';
    	   $url = get_page_link($page);
	       // If the consent label still contains the original string
	       if (  strpos($privacy_label, $privacy_string) !== false ) { 
              // Check if a link to privacy policy page already exists, and remove it:
              $pattern = '/<a [^>]*>'.$privacy_string.'<\/a>/i';              
              if( preg_match($pattern,$privacy_label) ) {
	          $label = preg_replace($pattern,$link,html_entity_decode($privacy_label));
              } else {
              // If a link to privacy policy page not exists:
	          $label = str_replace($privacy_string,$link,html_entity_decode($privacy_label));	    
              }
              echo json_encode( array( 'error' => false, 'label' => $label, 'url' => $url ) );
	          exit;
           } 
           // If the consent label not contains the original string
           else {
              /* translators: Placeholder %s corresponds to "privacy policy" and it can be used to contain the hyperlink to the privacy policy page */
    	      $label = sprintf( __( 'I have read and consent to the %s', 'simpleform' ), $link );	
              echo json_encode( array( 'error' => false, 'label' => $label, 'url' => $url ) );
	          exit;
           }
        }   
        else {
           echo json_encode( array( 'error' => false ));
	       exit;
        }
        die();
      }

    }
    
	/**
	 * Return an update message
	 *
	 * @since    1.9.2
	 */
	
    public function update_message() { 
		
     // See if there's a release waiting first 
     $updates = (array) get_option( '_site_transient_update_plugins' );
     if ( isset( $updates['response'] ) && array_key_exists( SIMPLEFORM_BASENAME, $updates['response'] ) ) {
            $update_message = '<span class="admin-notices update"><a href="'.self_admin_url('plugins.php').'">'. __('There is a new version of SimpleForm available. Get latest features and improvements!', 'simpleform') .'</a></span>';
	 } 
	 else { $update_message = ''; } // $update_message = '<span class="admin-notices"><a href="https://wpsform.com" target="_blank">'. __('SimpleForm makes contact form easier', 'simpleform') .'</a></span>';
	 
     return $update_message;
     
    } 
    	
    /**
	 * Add support links in the plugin meta row
	 *
	 * @since    1.10
	 */
	
    public function plugin_meta( $plugin_meta, $file ) {

      /* translators: %1$s: native language name, %2$s: URL to translate.wordpress.org */
      $message =__('SimpleForm is not translated into %1$s yet. <a href="%2$s">Help translate it!</a>', 'simpleform' );
      $translation_message =__('Help improve the translation', 'simpleform' );

      if ( strpos( $file, SIMPLEFORM_BASENAME ) !== false ) {
		$plugin_meta[] = '<a href="https://wordpress.org/support/plugin/simpleform/" target="_blank">'.__('Support', 'simpleform').'</a>';
		}
		
	  return $plugin_meta;

	}
	
    /**
	 * Display additional action links in the plugins list table  
	 *
	 * @since    1.10
	 */
	
    public function plugin_links( $plugin_actions, $plugin_file ){ 
    
      $new_actions = array();
	  if ( SIMPLEFORM_BASENAME === $plugin_file ) { 
		
		if ( is_multisite() ) {   
		  $url = network_admin_url('plugin-install.php?tab=search&type=tag&s=simpleform-addon');
		} else {
		  $url = admin_url('plugin-install.php?tab=search&type=tag&s=simpleform-addon');
		} 
		  
      $new_actions['sform_settings'] = '<a href="' . menu_page_url( 'sform-submissions', false ) . '">' . __('Dashboard', 'simpleform') . '</a> | <a href="' . menu_page_url( 'sform-editing', false ) . '">' . __('Editor', 'simpleform') . '</a> | <a href="' . menu_page_url( 'sform-settings', false ) . '">' . __('Settings', 'simpleform') . '</a> | <a href="'.$url.'" target="_blank">' . __('Addons', 'simpleform') . '</a>';
  	  }
     
      return array_merge( $new_actions, $plugin_actions );

    }

	/**
	 * Register and load the widget.
	 *
	 * @since    1.10
	 */

    public static function load_widget() {
      
      register_widget( 'SimpleForm_Widget' );

    }	
    
	/**
	 * Fallback for database table updating if plugin is already active.
	 *
	 * @since    1.10
	 */
    
    public function db_version_check() {
    
        $current_db_version = SIMPLEFORM_DB_VERSION; 
        $installed_version = get_option('sform_db_version');
    
        if ( $installed_version != $current_db_version ) {

 	      $old_settings = get_option( 'sform_settings' );
          if ( $old_settings ) { 
	         $new_settings = array( 'admin_notices' => 'false'); 
             $settings = array_merge($old_settings,$new_settings);
             update_option('sform_settings', $settings);
          }
          
          require_once SIMPLEFORM_PATH . 'includes/class-activator.php';
	      SimpleForm_Activator::create_db();
          
        }           
         
    }
    
}