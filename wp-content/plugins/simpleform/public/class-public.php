<?php
	
/**
 * Defines the public-specific functionality of the plugin.
 *
 * @since      1.0
 */

class SimpleForm_Public {

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
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0
	 */
	 
	public function enqueue_styles() {
		
    wp_register_style( 'sform-default-style', plugins_url('/css/default-template.css',__FILE__)); 	
    wp_register_style( 'sform-basic-style', plugins_url('/css/basic-bootstrap-template.css',__FILE__)); 	
    wp_register_style( 'sform-rounded-style', plugins_url('/css/rounded-bootstrap-template.css',__FILE__)); 
    wp_register_style( 'sform-transparent-style', plugins_url('/css/transparent-template.css',__FILE__)); 	
    wp_register_style( 'sform-highlighted-style', plugins_url('/css/highlighted-template.css',__FILE__)); 	

	$settings = get_option('sform_settings');
	$cssfile = ! empty( $settings['stylesheet_file'] ) ? esc_attr($settings['stylesheet_file']) : 'false';
	
	if( $cssfile == 'true' ) {
      if (is_child_theme() ) { 
	    wp_register_style( 'sform-custom-style', get_stylesheet_directory_uri() . '/simpleform/custom-style.css' , __FILE__ );
      }
      else { 
	    wp_register_style( 'sform-custom-style', get_template_directory_uri() . '/simpleform/custom-style.css' , __FILE__ );
      }
	}   

    global $post; 
    $confirmation_page_ID = ! empty( $settings['confirmation_pageid'] ) ? esc_attr($settings['confirmation_pageid']) : '';	  
    
    if( is_page() && ( strpos($post->post_content,'[simpleform') !== false || $post->ID == $confirmation_page_ID ) ) {    
     
      $form_template = ! empty( $settings['form_template'] ) ? esc_attr($settings['form_template']) : 'default'; 
      $stylesheet = ! empty( $settings['stylesheet'] ) ? esc_attr($settings['stylesheet']) : 'false';
      if ( $stylesheet == 'false' ) { 
      switch ($form_template) {
       case 'basic':
       wp_enqueue_style( 'sform-basic-style' );
       break;
       case 'rounded':
       wp_enqueue_style( 'sform-rounded-style' );
       break;
       case 'transparent':
       wp_enqueue_style( 'sform-transparent-style' );
       break;
       case 'highlighted':
       wp_enqueue_style( 'sform-highlighted-style' );
       break;
       case 'customized':
       wp_enqueue_style( 'sform-default-style' );
       break;
       default:
       wp_enqueue_style( 'sform-default-style' );
      }	   
      }
      else {
	   if( $cssfile == 'true' ) {
         wp_enqueue_style( 'sform-custom-style' );
	   }   
      }	      
    }
 
    }
    
	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0
	 */
	 
	public function enqueue_scripts() {
	
    $settings = get_option('sform_settings');
    $ajax = ! empty( $settings['ajax_submission'] ) ? esc_attr($settings['ajax_submission']) : 'false'; 
    $javascript = ! empty( $settings['javascript'] ) ? esc_attr($settings['javascript']) : 'false';
    $ajax_error = ! empty( $settings['ajax_error'] ) ? stripslashes(esc_attr($settings['ajax_error'])) : esc_attr__( 'Error occurred during AJAX request. Please contact support!', 'simpleform' );
    $outside_error = ! empty( $settings['outside_error'] ) ? esc_attr($settings['outside_error']) : 'bottom';
    $outside = $outside_error == 'top' || $outside_error == 'bottom' ? 'true' : 'false';
    
	wp_register_script( 'sform_form_script', plugin_dir_url( __FILE__ ) . 'js/script.js', array( 'jquery' ), $this->version, false );
	wp_register_script( 'sform_public_script', plugin_dir_url( __FILE__ ) . 'js/public.js', array( 'jquery' ), $this->version, false );
    wp_localize_script('sform_public_script', 'ajax_sform_processing', array('ajaxurl' => admin_url('admin-ajax.php'), 'sform_loading_img' => plugins_url( 'img/processing.svg',__FILE__ ), 'ajax_error' => $ajax_error, 'outside' => $outside ));	

    global $post; 
    if( is_page() && strpos($post->post_content,'[simpleform') !== false ) { 
       wp_enqueue_script( 'sform_form_script');
       if( $ajax == 'true' ) {
       wp_enqueue_script( 'sform_public_script');
       }        
       if ( $javascript == 'true' ) { 
         if (is_child_theme() ) { 
	        wp_enqueue_script( 'sform-custom-script',  get_stylesheet_directory_uri() . '/simpleform/custom-script.js',  array( 'jquery' ), '', true );
         }
         else { 
	        wp_enqueue_script( 'sform-custom-script',  get_template_directory_uri() . '/simpleform/custom-script.js',  array( 'jquery' ), '', true );
         }
	   }
	   
    }   
 
    }

	/**
	 * Apply shortcode and return the contact form for the public-facing side of the site.
	 *
	 * @since    1.0
	 */

    public function sform_shortcode($atts) { 
          
        $atts_array = shortcode_atts( array( 'form' => '0', 'widget_attributes' => '0', 'widget_settings' => '0' ), $atts );	     
	    if ( $atts_array['widget_attributes'] == '0' ) { 
 	        $attributes = get_option('sform_attributes');
 	    } else { 
 	        $attributes = get_option('sform_widget_' . $atts_array['widget_attributes'] . '_attributes');
 	    }
 
 	    if ( $atts_array['widget_settings'] == '0' ) { 
 	        $settings = get_option('sform_settings');
 	    } else { 
 	        $settings = get_option('sform_widget_' . $atts_array['widget_settings'] . '_settings');
 	    }
	        
      include 'partials/form-variables.php'; 
	  
      $template = ! empty( $settings['form_template'] ) ? esc_attr($settings['form_template']) : 'default'; 

      switch ($template) {
      case 'basic':
      $file = 'partials/basic-bootstrap-template.php';
      break;
      case 'rounded':
      $file = 'partials/rounded-bootstrap-template.php';
      break;
      case 'transparent':
      $file = 'partials/transparent-template.php';
      break;
      case 'highlighted':
      $file = 'partials/highlighted-template.php';
      break;
      case 'customized':
      $file = '';
      break;
      default:
      $file = "partials/default-template.php";
      }
      
      if( empty($file) ):
       if (is_child_theme() ) { 
	       
        if ( $atts_array['widget_settings'] == '0' ) { 
 	        include get_stylesheet_directory() . '/simpleform/custom-template.php';
 	    } else { 
 	        include get_stylesheet_directory() . '/simpleform/custom-widget-template.php';
 	    }	       
	   }	    
       else { 

	    if ( $atts_array['widget_settings'] == '0' ) { 
 	        include get_template_directory() . '/simpleform/custom-template.php';
 	    } else { 
 	        include get_template_directory() . '/simpleform/custom-widget-template.php';
 	    }	       
       
	       
       }
      else:
	   include $file;
      endif;

      return $contact_form;
      
    } 

	/**
	 * Validate the form data after submission without Ajax
	 *
	 * @since    1.0
	 */
	 
    public function formdata_validation($data) {
		
	    $form_id = isset($_POST['form-id']) ? absint($_POST['form-id']) : '1';
	    $widget_attributes = isset($_POST['widget-attributes']) ? absint($_POST['widget-attributes']) : '0';

        if ( $widget_attributes == '0' ) { 
 	     $attributes = get_option('sform_attributes');
 	    } else { 
 	     $attributes = get_option('sform_widget_' . $widget_attributes . '_attributes');
 	    }
 
 	    $settings = get_option('sform_settings');
		$ajax = ! empty( $settings['ajax_submission'] ) ? esc_attr($settings['ajax_submission']) : 'false'; 
        $name_field = ! empty( $attributes['name_field'] ) ? esc_attr($attributes['name_field']) : 'visible';
        $name_requirement = ! empty( $attributes['name_requirement'] ) ? esc_attr($attributes['name_requirement']) : 'optional';
        $lastname_field = ! empty( $attributes['lastname_field'] ) ? esc_attr($attributes['lastname_field']) : 'hidden';
        $lastname_requirement = ! empty( $attributes['lastname_requirement'] ) ? esc_attr($attributes['lastname_requirement']) : 'optional';
        $email_field = ! empty( $attributes['email_field'] ) ? esc_attr($attributes['email_field']) : 'visible';
        $email_requirement = ! empty( $attributes['email_requirement'] ) ? esc_attr($attributes['email_requirement']) : 'required';
        $phone_field = ! empty( $attributes['phone_field'] ) ? esc_attr($attributes['phone_field']) : 'hidden';
        $phone_requirement = ! empty( $attributes['phone_requirement'] ) ? esc_attr($attributes['phone_requirement']) : 'optional';        
        $subject_field = ! empty( $attributes['subject_field'] ) ? esc_attr($attributes['subject_field']) : 'visible';
        $subject_requirement = ! empty( $attributes['subject_requirement'] ) ? esc_attr($attributes['subject_requirement']) : 'required';
        $consent_field = ! empty( $attributes['consent_field'] ) ? esc_attr($attributes['consent_field']) : 'visible';
        $consent_requirement = ! empty( $attributes['consent_requirement'] ) ? esc_attr($attributes['consent_requirement']) : 'required'; 
        $captcha_field = ! empty( $attributes['captcha_field'] ) ? esc_attr($attributes['captcha_field']) : 'hidden';            
      
        if( $ajax != 'true' && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submission']) && isset( $_POST['sform_nonce'] ) && wp_verify_nonce( $_POST['sform_nonce'], 'sform_nonce_action' ) ) {
	
        $formdata = array(
			'name' => isset($_POST['sform-name']) ? sanitize_text_field($_POST['sform-name']) : '',
			'lastname' => isset($_POST['sform-lastname']) ? sanitize_text_field($_POST['sform-lastname']) : '',
			'email' => isset($_POST['sform-email']) ? sanitize_email($_POST['sform-email']) : '',
			'phone' => isset($_POST['sform-phone']) ? sanitize_text_field($_POST['sform-phone']) : '',			
			'subject' => isset($_POST['sform-subject']) ? sanitize_text_field($_POST['sform-subject']) : '',			
			'message' => isset($_POST['sform-message']) ? sanitize_textarea_field($_POST['sform-message']) : '',
			'consent' => isset($_POST['sform-consent']) ? 'true' : 'false',
		    'captcha' => isset( $_POST['sform-captcha'] ) && is_numeric( $_POST['sform-captcha'] ) ? intval($_POST['sform-captcha']) : '',
            'captcha_one' => isset( $_POST['captcha_one'] ) && is_numeric( $_POST['captcha_one'] ) ? intval($_POST['captcha_one']) : 0,
            'captcha_two' => isset( $_POST['captcha_two'] ) && is_numeric( $_POST['captcha_two'] ) ? intval($_POST['captcha_two']) : 0,
			'url' => isset($_POST['url']) ? sanitize_text_field($_POST['url']) : '',
			'telephone' => isset($_POST['telephone']) ? sanitize_text_field($_POST['telephone']) : '',

		);
		
        $error = '';		

		if ( ! empty($formdata['url']) || ! empty($formdata['telephone']) ) {
		    $error .= 'form_honeypot;';
		}
		
	    $url_data = $formdata['url'];
	    $telephone_data = $formdata['telephone'];

        $name_length = isset( $attributes['name_minlength'] ) ? esc_attr($attributes['name_minlength']) : '2';
        $name_regex = '#[0-9]+#';

        if ( $name_field == 'visible' || $name_field == 'registered' && is_user_logged_in() || $name_field == 'anonymous' && ! is_user_logged_in() )  {

        if ( $name_requirement == 'required' )	{
	      if (  ! empty($formdata['name']) && preg_match($name_regex, $formdata['name'] ) ) { 
		  $error .= 'name_invalid;';
	      }	
          else {
          if ( empty($formdata['name']) || strlen($formdata['name']) < $name_length ) {
		$error .= 'name;';
          }
	      }		
        }

        else {	
		  if (  ! empty($formdata['name']) && preg_match($name_regex, $formdata['name'] ) ) { 
 		  $error .= 'name_invalid;';
         }

	      else {
		  if ( ! empty($formdata['name']) && strlen($formdata['name']) < $name_length ) {
			$error .= 'name;';
	      }         
	      }
        }

        }

        $data_name = $formdata['name'];

        $lastname_length = isset( $attributes['lastname_minlength'] ) ? esc_attr($attributes['lastname_minlength']) : '2';
        $lastname_regex = '#[0-9]+#';

        if ( $lastname_field == 'visible' || $lastname_field == 'registered' && is_user_logged_in() || $lastname_field == 'anonymous' && ! is_user_logged_in() )  {
         if ( $lastname_requirement == 'required' )	{
	      if (  ! empty($formdata['lastname']) && preg_match($lastname_regex, $formdata['lastname'] ) ) { 
		   $error .= 'lastname_invalid;';
	      }
          else {
          if ( empty($formdata['lastname']) || strlen($formdata['lastname']) < $lastname_length ) {
		  $error .= 'lastname;';
          }
	      }	
         }
         else {	
		  if (  ! empty($formdata['lastname']) && preg_match($lastname_regex, $formdata['lastname'] ) ) { 
  		   $error .= 'lastname_invalid;';
	      }	
		  else {
		  if ( ! empty($formdata['lastname']) && strlen($formdata['lastname']) < $lastname_length ) {
		  $error .= 'lastname;';
		  }
          }
         }
        }

        $data_lastname = $formdata['lastname'];

        if ( $email_field == 'visible' || $email_field == 'registered' && is_user_logged_in() || $email_field == 'anonymous' && ! is_user_logged_in() )  {
          if ( $email_requirement == 'required' )	{
	       if ( empty($formdata['email']) || ! is_email($formdata['email']) ) {
           $error .= 'email;';
		   }
          }
          else {		
		   if ( ! empty($formdata['email']) && ! is_email($formdata['email']) ) {
		   $error .= 'email;';
		   }
          }		
        }		

		$data_email = $formdata['email'];

        $phone_regex = '/^[0-9\-\(\)\/\+\s]*$/';  // allowed characters: -()/+ and space

        if ( $phone_field == 'visible' || $phone_field == 'registered' && is_user_logged_in() || $phone_field == 'anonymous' && ! is_user_logged_in() )  {
         if ( $phone_requirement == 'required' )	{
	      if (  ! empty($formdata['phone']) && ! preg_match($phone_regex, $formdata['phone'] ) ) { 
	     $error .= 'phone_invalid;';
	      }	
          else {		
          if ( empty($formdata['phone']) ) {
		   $error .= 'phone;';
          }
	      }		
         }
         else {		
		  if (  ! empty($formdata['phone']) && ! preg_match($phone_regex, $formdata['phone'] ) ) { 
         	     $error .= 'phone_invalid;';
          }
         }		
        }		

		$data_phone = $formdata['phone'];

        $subject_length = isset( $attributes['subject_minlength'] ) ? esc_attr($attributes['subject_minlength']) : '5';
        $subject_regex = '/^[^#$%&=+*{}|<>]+$/';
		
        if ( $subject_field == 'visible' || $subject_field == 'registered' && is_user_logged_in() || $subject_field == 'anonymous' && ! is_user_logged_in() )  {
        if ( $subject_requirement == 'required' )	{
	      if (  ! empty($formdata['subject']) && ! preg_match($subject_regex, $formdata['subject'] ) ) { 
		   $error .= 'subject_invalid;';
    	  }		
          else {		
          if ( empty($formdata['subject']) || strlen($formdata['subject']) < $subject_length ) {
		    $error .= 'subject;';
          }
     	  }		
        }
        else {	
		  if (  ! empty($formdata['subject']) && ! preg_match($subject_regex, $formdata['subject'] ) ) { 
       		   $error .= 'subject_invalid;';
          }
          else {		
		   if ( ! empty($formdata['subject']) && strlen($formdata['subject']) < $subject_length ) {
		       $error .= 'subject;';
		   }
          }		
        }
        }
	
        $data_subject = stripslashes($formdata['subject']);

        $message_length = isset( $attributes['$message_minlength'] ) ? esc_attr($attributes['$message_minlength']) : '10';
        $message_regex = '/^[^#$%&=+*{}|<>]+$/';

	    if (  ! empty($formdata['message']) && ! preg_match($message_regex, $formdata['message'] )  ) { 
		    $error .= 'message_invalid;';
	    } 
	    
	    else {		
	    if ( strlen($formdata['message']) < $message_length ) {
		    $error .= 'message;';
	    }
	    }

        $data_message = $formdata['message'];		
					
        if ( $consent_field == 'visible' || $consent_field == 'registered' && is_user_logged_in() || $consent_field == 'anonymous' && ! is_user_logged_in() )  {
        if ( $consent_requirement == 'required' && $formdata['consent'] !=  "true" )	{
		    $error .= 'consent;'; 
        }
	    $data_consent = $formdata['consent'];
        }
        else {
		    $data_consent = '';
	    }

        if ( $captcha_field == 'visible' || $captcha_field == 'registered' && is_user_logged_in() || $captcha_field == 'anonymous' && ! is_user_logged_in() ) {	
        $captcha_one = $formdata['captcha_one'];
        $captcha_two = $formdata['captcha_two'];
	    $result = $captcha_one + $captcha_two;
        $answer = stripslashes($formdata['captcha']);		

	    if ( empty($captcha_one) || empty($captcha_two) || empty($answer) || $result != $answer ) {
			$data_captcha_one = '';
		    $data_captcha_two = '';
		   	$data_captcha = $answer;
		    $error .= 'captcha;';
	    }
	    else {
		    $data_captcha_one = $formdata['captcha_one'];
		    $data_captcha_two = $formdata['captcha_two'];
		   	$data_captcha = $answer;
	    }

        }
        else {
		    $data_captcha_one = '';
		    $data_captcha_two = '';
		   	$data_captcha = '';
	  }
      
		$error = apply_filters('sform_send_email', $formdata, $error );
		
		$data = array( 'name' => $data_name,'lastname' => $data_lastname,'email' => $data_email,'phone' => $data_phone,'subject' => $data_subject,'message' => $data_message,'consent' => $data_consent,'captcha' => $data_captcha,'captcha_one' => $data_captcha_one,'captcha_two' => $data_captcha_two,'url' => $url_data,'telephone' => $telephone_data,'error' => $error );

	    }
  
        else {	
        $data = array( 'name' => '','lastname' => '','email' => '','phone' =>'','subject' => '','message' => '','consent' => '','captcha' => '','captcha_one' => '','captcha_two' => '','url' => '','telephone' => '' );
        
		}
		
        return $data;

	}

	/**
	 * Modify the HTTP response header (buffer the output so that nothing gets written until you explicitly tell to do it)
	 *
	 * @since    1.8.1
	 */
    
    public function ob_start_cache($error) {

 	  $widget_attributes = isset($_POST['widget-attributes']) ? absint($_POST['widget-attributes']) : '0';
      $widget_settings = isset($_POST['widget-settings']) ? absint($_POST['widget-settings']) : '0';
	      
 	  if ( $widget_settings == '0' ) { 
 	   $settings = get_option('sform_settings');
 	  } else { 
 	   $settings = get_option('sform_widget_' . $widget_settings . '_settings');
 	  }

      $sform_settings = get_option('sform-settings');
      $ajax = ! empty( $settings['ajax_submission'] ) ? esc_attr($settings['ajax_submission']) : 'true'; 
      if( $ajax != 'true' && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submission']) && isset( $_POST['sform_nonce'] ) && wp_verify_nonce( $_POST['sform_nonce'], 'sform_nonce_action' ) ) {
	      
	  if ($error == '') {
         ob_start();
      }
      
      }
      
    }

	/**
	 * Process the form data after submission with post callback function
	 *
	 * @since    1.0
	 */

    public function formdata_processing($formdata, $error) {    

      $widget_attributes = isset($_POST['widget-attributes']) ? absint($_POST['widget-attributes']) : '0';
      $widget_settings = isset($_POST['widget-settings']) ? absint($_POST['widget-settings']) : '0';
      $form_id = isset( $_POST['form-id'] ) ? absint($_POST['form-id']) : '1';
      
  	  if ( $widget_settings == '0' ) { 
 	   $settings = get_option('sform_settings');
 	  } else { 
 	   $settings = get_option('sform_widget_' . $widget_settings . '_settings');
 	  }
	
      $ajax = ! empty( $settings['ajax_submission'] ) ? esc_attr($settings['ajax_submission']) : 'false'; 
 
      if( $ajax != 'true' && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submission']) && isset( $_POST['sform_nonce'] ) && wp_verify_nonce( $_POST['sform_nonce'], 'sform_nonce_action' ) ) {
  	            
    if ( ! empty($formdata['name']) ) { 
    $requester_name = $formdata['name'];      
    $name_value = $formdata['name'];
    }
    else {
	  if ( is_user_logged_in() ) {
		global $current_user;
		$requester_name = ! empty($current_user->user_name) ? $current_user->user_name : $current_user->display_name;
        $name_value = $requester_name;
      }
      else {
		$requester_name = '';        
		$name_value = '';     
      }
    }
    
    if ( ! empty($formdata['lastname']) ) { 
    $requester_lastname = ' ' . $formdata['lastname'];      
    $lastname_value = ' ' . $formdata['lastname'];
    }
    else {
	  if ( is_user_logged_in() ) {
		global $current_user;
		$requester_lastname = ! empty($current_user->user_lastname) ? ' ' . $current_user->user_lastname : '';
        $lastname_value = ' ' . $requester_lastname;
      }
      else {
		$requester_lastname = '';       
		$lastname_value = '';     
      }
    }

      $requester = $requester_name != '' || $requester_lastname != '' ? trim($requester_name . $requester_lastname) : esc_html__( 'Anonymous', 'simpleform' );
            
    if ( ! empty($formdata['email']) ) { 
    $email_value = $formdata['email'];
    }
    else {
	  if ( is_user_logged_in() ) {
		global $current_user;
		$email_value = $current_user->user_email;
      }
      else {
		$email_value = '';
      }
    }
            
    if ( ! empty($formdata['phone']) ) { 
    $phone_value = $formdata['phone'];
    }
    else {
	$phone_value = '';       
    }

    if ( ! empty($formdata['subject']) ) { 
    $subject_value = $formdata['subject'];
    $request_subject = $formdata['subject'];
    }
    else {
	$subject_value = '';         
	$request_subject = esc_attr__( 'No Subject', 'simpleform' );	         
    }

    if ($error == '') {
			
    $mailing = 'false';
    $submission_timestamp = time();
    $submission_date = date('Y-m-d H:i:s');

	global $wpdb;
	$table_name = "{$wpdb->prefix}sform_submissions"; 
    $requester_type  = is_user_logged_in() ? 'registered' : 'anonymous';
    $user_ID = is_user_logged_in() ? get_current_user_id() : '0';
   
    $sform_default_values = array( "form" => $form_id, "date" => $submission_date, "requester_type" => $requester_type, "requester_id" => $user_ID );
    $extra_fields = array('notes' => '');
  
    $submitter = $requester_name != '' ? $requester_name : esc_html__( 'Anonymous', 'simpleform' );
  
    $sform_extra_values = array_merge($sform_default_values, apply_filters( 'sform_storing_values', $extra_fields, $form_id, $requester_name, $requester_lastname, $email_value, $phone_value, $subject_value, $formdata['message'] ));
    
    $success = $wpdb->insert($table_name, $sform_extra_values);

    if ($success)  {

    $from_data = '<b>'. esc_html__('From', 'simpleform') .':</b>&nbsp;&nbsp;';
    $from_data .= $requester;
    
    if ( ! empty($email_value) ):
    $from_data .= '&nbsp;&nbsp;&lt;&nbsp;' . $email_value . '&nbsp;&gt;';
    else:
    $from_data .= '';
    endif;
    $from_data .= '<br>';
    
    if ( ! empty($phone_value) ) { $phone_data = '<b>'. esc_html__('Phone', 'simpleform') .':</b>&nbsp;&nbsp;' . $phone_value .'<br>'; }
    else { $phone_data = ''; }
    $from_data .= $phone_data;
    
    if ( ! empty($subject_value) ) { $subject_data = '<br><b>'. esc_html__('Subject', 'simpleform') .':</b>&nbsp;&nbsp;' . $subject_value .'<br>'; }
    else { $subject_data = '<br>'; }

    $tzcity = get_option('timezone_string');
    $tzoffset = get_option('gmt_offset');
    if ( ! empty($tzcity))  { 
    $current_time_timezone = date_create('now', timezone_open($tzcity));
    $timezone_offset =  date_offset_get($current_time_timezone);
    $website_timestamp = $submission_timestamp + $timezone_offset; 
    }
    else { 
    $timezone_offset =  $tzoffset * 3600;
    $website_timestamp = $submission_timestamp + $timezone_offset;  
    }
       
    $website_date = date_i18n( get_option( 'date_format' ), $website_timestamp ) . ' ' . esc_html__('at', 'simpleform') . ' ' . date_i18n( get_option('time_format'), $website_timestamp );
	
	$last_message = '<div style="line-height:18px;">' . $from_data . '<b>'. esc_html__('Date', 'simpleform') .':</b>&nbsp;&nbsp;' . $website_date . $subject_data . '<b>'. esc_html__('Message', 'simpleform') .':</b>&nbsp;&nbsp;' .  $formdata['message'] . '</div>';

       set_transient('sform_last_'.$form_id.'_message', $last_message, 0 );
       set_transient( 'sform_last_message', $last_message, 0 );

    $notification = ! empty( $settings['notification'] ) ? esc_attr($settings['notification']) : 'true';

    if ($notification == 'true') { 
	       
    $to = ! empty( $settings['notification_recipient'] ) ? esc_attr($settings['notification_recipient']) : esc_attr( get_option( 'admin_email' ) );
    $submission_number = ! empty( $settings['submission_number'] ) ? esc_attr($settings['submission_number']) : 'visible';
    $subject_type = ! empty( $settings['notification_subject'] ) ? esc_attr($settings['notification_subject']) : 'request';
    $subject_text = ! empty( $settings['custom_subject'] ) ? stripslashes(esc_attr($settings['custom_subject'])) : esc_html__('New Contact Request', 'simpleform');
    $subject = $subject_type == 'request' ? $request_subject : $subject_text;
    
    if ( $submission_number == 'visible' ):
          $reference_number = $wpdb->get_var($wpdb->prepare("SELECT id FROM `$table_name` WHERE date = %s", $submission_date) );
    	  $admin_subject = '#' . $reference_number . ' - ' . $subject;	
     	  else:
     	  $admin_subject = $subject;	
    endif;

    $admin_message_email = '<div style="line-height:18px; padding-top:10px;">' . $from_data . '<b>'. esc_html__('Sent', 'simpleform') .':</b>&nbsp;&nbsp;' . $website_date . $subject_data  . '<br>' .  $formdata['message'] . '</div>'; 
	$headers = "Content-Type: text/html; charset=UTF-8" .  "\r\n";
    $notification_reply = ! empty( $settings['notification_reply'] ) ? esc_attr($settings['notification_reply']) : 'true';
    $bcc = ! empty( $settings['bcc'] ) ? esc_attr($settings['bcc']) : '';
	
    if ( ( ! empty($formdata['email']) || is_user_logged_in() ) && $notification_reply == 'true' ) { $headers .= "Reply-To: ".$requester." <".$email_value.">" . "\r\n"; }
    if ( ! empty($bcc) ) { $headers .= "Bcc: ".$bcc. "\r\n"; } 
  
    do_action('check_smtp');
    add_filter( 'wp_mail_from_name', array ( $this, 'sform_notification_sender_name' ) ); 
    add_filter( 'wp_mail_from', array ( $this, 'sform_notification_sender_email' ) );
    $recipients = explode(',', $to);
	$sent = wp_mail($recipients, $admin_subject, $admin_message_email, $headers); 	
    remove_filter( 'wp_mail_from_name', array ( $this, 'sform_notification_sender_name' ) );
    remove_filter( 'wp_mail_from', array ( $this, 'sform_notification_sender_email' ) );

    if ($sent):
      $mailing = 'true';
    endif;

	}

    $confirmation = ! empty( $settings['autoresponder'] ) ? esc_attr($settings['autoresponder']) : 'false';
			
		if ( $confirmation == 'true' && ! empty($formdata['email']) ) {
			
		  $from = ! empty( $settings['autoresponder_email'] ) ? esc_attr($settings['autoresponder_email']) : esc_attr( get_option( 'admin_email' ) );
          $subject = ! empty( $settings['autoresponder_subject'] ) ? stripslashes(esc_attr($settings['autoresponder_subject'])) : esc_attr__( 'Your request has been received. Thanks!', 'simpleform' );
          $code_name = '[name]';
          $message = ! empty( $settings['autoresponder_message'] ) ? stripslashes(wp_kses_post($settings['autoresponder_message'])) : printf(__( 'Hi %s', 'simpleform' ),$code_name) . ',<p>' . esc_html__( 'We have received your request. It will be reviewed soon and we\'ll get back to you as quickly as possible.', 'simpleform' ) . esc_html__( 'Thanks,', 'simpleform' ) . esc_html__( 'The Support Team', 'simpleform' );          
          $reply_to = ! empty( $settings['autoresponder_reply'] ) ? esc_attr($settings['autoresponder_reply']) : $from;
		  $headers = "Content-Type: text/html; charset=UTF-8" . "\r\n";
		  $headers .= "Reply-To: <".$reply_to.">" . "\r\n";
	      $sql = "SELECT id FROM `$table_name` WHERE date = %s";
          $reference_number = $wpdb->get_var( $wpdb->prepare( $sql, $submission_date ) );
	      $tags = array( '[name]','[lastname]','[email]','[phone]','[subject]','[message]','[submission_id]' );
          $values = array( $formdata['name'],$formdata['lastname'],$formdata['email'],$formdata['phone'],$formdata['subject'],$formdata['message'],$reference_number );
          $content = str_replace($tags,$values,$message);
			
          do_action('check_smtp');
          add_filter( 'wp_mail_from_name', array ( $this, 'sform_confirmation_sender_name' ) ); 
          add_filter( 'wp_mail_from', array ( $this, 'sform_confirmation_sender_email' ) ); 
	      wp_mail($formdata['email'], $subject, $content, $headers);
          remove_filter( 'wp_mail_from_name', array ( $this, 'sform_confirmation_sender_name' ) );
          remove_filter( 'wp_mail_from', array ( $this, 'sform_confirmation_sender_email' ) );

		}
		
    $success_action = ! empty( $settings['success_action'] ) ? esc_attr($settings['success_action']) : 'message';    
    $thanks_url = ! empty( $settings['thanks_url'] ) ? esc_url($settings['thanks_url']) : '';    

    if( $success_action == 'message' ) { $redirect_to = esc_url_raw(add_query_arg( 'sending', 'success', $_SERVER['REQUEST_URI'] )); }
    else { $redirect_to = ! empty($thanks_url) ? esc_url_raw($thanks_url) : esc_url_raw(add_query_arg( 'sending', 'success', $_SERVER['REQUEST_URI'] )); }

    if ( ! has_filter('sform_post_message') ) { 
      if ( $mailing == 'true' ) {
	     header('Location: '. $redirect_to);
	     ob_end_flush();
         exit(); 
      } 	 
	  else  { $error = 'server_error'; }
	}
	
	else { $error = apply_filters( 'sform_post_message', $form_id, $mailing ); 
      if ( $error == '' ) {
	     header('Location: '. $redirect_to);
         ob_end_flush();
         exit(); 
      } 	 
      
	}
		 
    } 

    else  {  $error = 'server_error'; }
			
    }

    return $error;

    }
     
}
    
	/**
	 * Process the form data after submission with Ajax callback function
	 *
	 * @since    1.0
	 */

    public function formdata_ajax_processing() {
	
      if( 'POST' !== $_SERVER['REQUEST_METHOD'] ) { die ( 'Security checked!'); }
      elseif ( ! wp_verify_nonce( $_POST['sform_nonce'], 'sform_nonce_action' ) )  { die ( 'Security checked!'); }

      else {	
	      
      $widget_attributes = isset($_POST['widget-attributes']) ? absint($_POST['widget-attributes']) : '0';
      $widget_settings = isset($_POST['widget-settings']) ? absint($_POST['widget-settings']) : '0';
      $form_id = isset( $_POST['form-id'] ) ? absint($_POST['form-id']) : '1';
      $name = isset($_POST['sform-name']) ? sanitize_text_field($_POST['sform-name']) : '';
      $email = isset($_POST['sform-email']) ? sanitize_email($_POST['sform-email']) : '';
      $email_data = isset($_POST['sform-email']) ? sanitize_text_field($_POST['sform-email']) : '';
      $lastname = isset($_POST['sform-lastname']) ? sanitize_text_field($_POST['sform-lastname']) : '';
	  $phone = isset($_POST['sform-phone']) ? sanitize_text_field($_POST['sform-phone']) : '';			
      $object = isset($_POST['sform-subject']) ? sanitize_text_field(str_replace("\'", "’", $_POST['sform-subject'])) : '';
      $request = isset($_POST['sform-message']) ? sanitize_textarea_field($_POST['sform-message']) : '';
      $consent = isset($_POST['sform-consent']) ? 'true' : 'false';
      $captcha_one = isset($_POST['captcha_one']) && is_numeric( $_POST['captcha_one'] ) ? intval($_POST['captcha_one']) : ''; 
      $captcha_two = isset($_POST['captcha_two']) && is_numeric( $_POST['captcha_two'] ) ? intval($_POST['captcha_two']) : '';
      $captcha_result = isset($_POST['captcha_one']) && isset($_POST['captcha_two']) ? $captcha_one + $captcha_two : ''; 
      $captcha_answer = isset($_POST['sform-captcha']) && is_numeric( $_POST['sform-captcha'] ) ? intval($_POST['sform-captcha']) : '';
      $honeypot_url = isset($_POST['url']) ? sanitize_text_field($_POST['url']) : '';
      $honeypot_telephone = isset($_POST['telephone']) ? sanitize_text_field($_POST['telephone']) : '';

      if ( $widget_attributes == '0' ) { 
 	   $attributes = get_option('sform_attributes');
 	  } else { 
 	   $attributes = get_option('sform_widget_' . $widget_attributes . '_attributes');
 	  }
 
 	  if ( $widget_settings == '0' ) { 
 	   $settings = get_option('sform_settings');
 	  } else { 
 	   $settings = get_option('sform_widget_' . $widget_settings . '_settings');
 	  }
      
      $name_field = ! empty( $attributes['name_field'] ) ? esc_attr($attributes['name_field']) : 'visible';
      $name_requirement = ! empty( $attributes['name_requirement'] ) ? esc_attr($attributes['name_requirement']) : 'required';
      $lastname_field = ! empty( $attributes['lastname_field'] ) ? esc_attr($attributes['lastname_field']) : 'hidden';
      $lastname_requirement = ! empty( $attributes['lastname_requirement'] ) ? esc_attr($attributes['lastname_requirement']) : 'optional';
      $email_field = ! empty( $attributes['email_field'] ) ? esc_attr($attributes['email_field']) : 'visible';
      $email_requirement = ! empty( $attributes['email_requirement'] ) ? esc_attr($attributes['email_requirement']) : 'required';
      $phone_field = ! empty( $attributes['phone_field'] ) ? esc_attr($attributes['phone_field']) : 'hidden';
      $phone_requirement = ! empty( $attributes['phone_requirement'] ) ? esc_attr($attributes['phone_requirement']) : 'optional';  
      $subject_field = ! empty( $attributes['subject_field'] ) ? esc_attr($attributes['subject_field']) : 'visible';
      $subject_requirement = ! empty( $attributes['subject_requirement'] ) ? esc_attr($attributes['subject_requirement']) : 'required';
      $consent_field = ! empty( $attributes['consent_field'] ) ? esc_attr($attributes['consent_field']) : 'visible';
      $consent_requirement = ! empty( $attributes['consent_requirement'] ) ? esc_attr($attributes['consent_requirement']) : 'required'; 
      $captcha_field = ! empty( $attributes['captcha_field'] ) ? esc_attr($attributes['captcha_field']) : 'hidden';     
      
      if ( ! empty($name) ) { $requester_name = $name; }
      else {
	    if ( is_user_logged_in() ) {
		global $current_user;
		$requester_name = ! empty($current_user->user_name) ? $current_user->user_name : $current_user->display_name;
        }
        else { $requester_name = ''; }
      }
            
      if ( ! empty($lastname) ) { $requester_lastname = ' ' . $lastname; }
      else {
	    if ( is_user_logged_in() ) {
		global $current_user;
		$requester_lastname = ! empty($current_user->user_lastname) ? ' ' . $current_user->user_lastname : '';
        }
        else { $requester_lastname = ''; }
      }

      $requester = $requester_name != '' || $requester_lastname != '' ? trim($requester_name . $requester_lastname) : esc_html__( 'Anonymous', 'simpleform' );

      if ( ! empty($email) ) { $requester_email = $email; }
      else {
	    if ( is_user_logged_in() ) {
		global $current_user;
		$requester_email = $current_user->user_email;
        }
        else { $requester_email = ''; }
      }

      if ( ! empty($object) ) { 
        $subject_value = $object;
        $request_subject = $object;
      }
      else {
	    $subject_value = '';         
	    $request_subject = esc_attr__( 'No Subject', 'simpleform' );	         
      }
      
       if (has_action('spam_check_execution')):
          do_action( 'spam_check_execution' );
       endif;	    
      
      if ( ! empty($honeypot_url) || ! empty($honeypot_telephone) ) { 
	  $error = ! empty( $settings['honeypot_error'] ) ? stripslashes(esc_attr($settings['honeypot_error'])) : esc_html__('Error occurred during processing data', 'simpleform');
        echo json_encode(array('error' => true, 'notice' => $error, 'showerror' => true ));
	    exit; 
	  }
	  
        $outside_error = ! empty( $settings['outside_error'] ) ? esc_attr($settings['outside_error']) : 'bottom';
        $showerror = $outside_error == 'top' || $outside_error == 'bottom' ? true : false;
        $errors_query = array();
        $field_error = '';
        $empty_fields = ! empty( $settings['empty_fields'] ) ? stripslashes(esc_attr($settings['empty_fields'])) : esc_attr__( 'There were some errors that need to be fixed', 'simpleform' );
        $characters_length = ! empty( $settings['characters_length'] ) ? esc_attr($settings['characters_length']) : 'true';
     
      if ( $name_field == 'visible' || $name_field == 'registered' && is_user_logged_in() || $name_field == 'anonymous' && ! is_user_logged_in() )  {  
        $name_length = isset( $attributes['name_minlength'] ) ? esc_attr($attributes['name_minlength']) : '2';
        $name_regex = '#[0-9]+#';
        $name_numeric_error = $characters_length == 'true' && ! empty( $settings['incomplete_name'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_name']) == $name_length ? stripslashes(esc_attr($settings['incomplete_name'])) : sprintf( __('Please enter at least %d characters', 'simpleform' ), $name_length );
        $name_generic_error = $characters_length != 'true' && ! empty( $settings['incomplete_name'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_name']) == '' ? stripslashes(esc_attr($settings['incomplete_name'])) : esc_attr__('Please type your full name', 'simpleform' );
        $error_name_label = $characters_length == 'true' ? $name_numeric_error : $name_generic_error;
        $error_invalid_name_label = ! empty( $settings['invalid_name'] ) ? stripslashes(esc_attr($settings['invalid_name'])) : esc_attr__( 'The name contains invalid characters', 'simpleform' );
        $error = ! empty( $settings['name_error'] ) ? stripslashes(esc_attr($settings['name_error'])) : esc_html__('Error occurred validating the name', 'simpleform');
        if ( $name_requirement == 'required' )	{
        if ( empty($name) || strlen($name) < $name_length ) {
	         $field_error = true;
	         $errors_query['name'] = $error_name_label;
             $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields; 
             $errors_query['error'] = TRUE;
             $errors_query['showerror'] = $showerror;
        }
	    if (  ! empty($name) && preg_match($name_regex, $name ) ) { 
            $field_error = true;
            $errors_query['name'] = $error_invalid_name_label;
            $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields; 
 	        $errors_query['error'] = TRUE;
            $errors_query['showerror'] = $showerror;
        }		
        }
        else {	
	    if ( ! empty($name) && strlen($name) < $name_length ) {
            $field_error = true;
            $errors_query['name'] = $error_name_label;
            $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields; 
	        $errors_query['error'] = TRUE;
            $errors_query['showerror'] = $showerror;
	    }
	    if (  ! empty($name) && preg_match($name_regex, $name ) ) { 
            $field_error = true;
            $errors_query['name'] = $error_invalid_name_label;
            $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields; 
 	   	    $errors_query['error'] = TRUE;
            $errors_query['showerror'] = $showerror;
        }
        }
      }

      if ( $lastname_field == 'visible' || $lastname_field == 'registered' && is_user_logged_in() || $lastname_field == 'anonymous' && ! is_user_logged_in() )  {  

        $lastname_length = isset( $attributes['lastname_minlength'] ) ? esc_attr($attributes['lastname_minlength']) : '2';
        $lastname_regex = '#[0-9]+#';
        $error_invalid_lastname_label = ! empty( $settings['invalid_lastname'] ) ? stripslashes(esc_attr($settings['invalid_lastname'])) : esc_attr__( 'The last name contains invalid characters', 'simpleform' );
        $error = ! empty( $settings['lastname_error'] ) ? stripslashes(esc_attr($settings['lastname_error'])) : esc_html__('Error occurred validating the last name', 'simpleform');
$lastname_numeric_error = $characters_length == 'true' && ! empty( $settings['incomplete_lastname'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_lastname']) == $lastname_length ? stripslashes(esc_attr($settings['incomplete_lastname'])) : sprintf( __('Please enter at least %d characters', 'simpleform' ), $lastname_length );
$lastname_generic_error = $characters_length != 'true' && ! empty( $settings['incomplete_lastname'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_lastname']) == '' ? stripslashes(esc_attr($settings['incomplete_lastname'])) : esc_attr__('Please type your full last name', 'simpleform' );
$error_lastname_label = $characters_length == 'true' ? $lastname_numeric_error : $lastname_generic_error;
	
        if ( $lastname_requirement == 'required' )	{
        if ( empty($lastname) || strlen($lastname) < $lastname_length ) {
            $field_error = true;
            $errors_query['lastname'] = $error_lastname_label;
         	$errors_query['error'] = TRUE;
            $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields; 	    
            $errors_query['showerror'] = $showerror;
        }
	    if (  ! empty($lastname) && preg_match($lastname_regex, $lastname ) ) { 
            $field_error = true;
            $errors_query['lastname'] = $error_invalid_lastname_label;
            $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields; 
      		$errors_query['error'] = TRUE;
            $errors_query['showerror'] = $showerror;
        }		
        }

        else {	
	    if ( ! empty($lastname) && strlen($lastname) < $lastname_length ) {
            $field_error = true;
            $errors_query['lastname'] = $error_lastname_label;
            $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields; 		                
            $errors_query['error'] = TRUE;
            $errors_query['showerror'] = $showerror;
        }
	    if (  ! empty($lastname) && preg_match($lastname_regex, $lastname ) ) { 
            $field_error = true;
            $errors_query['lastname'] = $error_invalid_lastname_label;       		               
            $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields; 
            $errors_query['error'] = TRUE;
            $errors_query['showerror'] = $showerror;
        }
        }

      }
      
      if ( $email_field == 'visible' || $email_field == 'registered' && is_user_logged_in() || $email_field == 'anonymous' && ! is_user_logged_in() )  {  

        $error_email_label = ! empty( $settings['invalid_email'] ) ? stripslashes(esc_attr($settings['invalid_email'])) : esc_attr__( 'Please enter a valid email', 'simpleform' );
        $error = ! empty( $settings['email_error'] ) ? stripslashes(esc_attr($settings['email_error'])) : esc_html__('Error occurred validating the email', 'simpleform');
        if ( $email_requirement == 'required' )	{
	    if ( empty($email) || ! is_email($email) ) {
            $field_error = true;
            $errors_query['email'] = $error_email_label;
            $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields;  
	     	$errors_query['error'] = TRUE;
            $errors_query['showerror'] = $showerror;
	    }
        }
        else {		
	    if ( ! empty($email_data) && ! is_email($email) ) {
            $field_error = true;
            $errors_query['email'] = $error_email_label;	    		                
            $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields;  
            $errors_query['error'] = TRUE;
            $errors_query['showerror'] = $showerror;
        }
        }		
		
      }	
      
      $phone_regex = '/^[0-9\-\(\)\/\+\s]*$/';  // allowed characters: -()/+ and space

      if ( $phone_field == 'visible' || $phone_field == 'registered' && is_user_logged_in() || $phone_field == 'anonymous' && ! is_user_logged_in() )  {
        $empty_phone = ! empty( $settings['empty_phone'] ) ? stripslashes(esc_attr($settings['empty_phone'])) : esc_attr__( 'Please provide your phone number', 'simpleform' );
        $error_phone_label = ! empty( $settings['invalid_phone'] ) ? stripslashes(esc_attr($settings['invalid_phone'])) : esc_attr__( 'The phone number contains invalid characters', 'simpleform' );
        $error = ! empty( $settings['phone_error'] ) ? stripslashes(esc_attr($settings['phone_error'])) : esc_attr__( 'Error occurred validating the phone number', 'simpleform' );
        if ( $phone_requirement == 'required' )	{
          if ( empty($phone) ) {
            $field_error = true;
            $errors_query['phone'] = $empty_phone;       		               
            $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields;
	        $errors_query['error'] = TRUE;
            $errors_query['showerror'] = $showerror;
          }
	      if (  ! empty($phone) && ! preg_match($phone_regex, $phone ) ) { 
            $field_error = true;
            $errors_query['phone'] = $error_phone_label;       		               
            $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields;
	        $errors_query['error'] = TRUE;
            $errors_query['showerror'] = $showerror;
	      }		
        }
        else {		
	      if ( ! empty($phone) && ! preg_match($phone_regex, $phone ) ) { 
            $field_error = true;
            $errors_query['phone'] = $error_phone_label;       		               
            $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields;
	        $errors_query['error'] = TRUE;
            $errors_query['showerror'] = $showerror;
	      }		
        }		
		
      }		
      
      if ( $subject_field == 'visible' || $subject_field == 'registered' && is_user_logged_in() || $subject_field == 'anonymous' && ! is_user_logged_in() )  { 
        $subject_length = isset( $attributes['subject_minlength'] ) ? esc_attr($attributes['subject_minlength']) : '5';
        $subject_regex = '/^[^#$%&=+*{}|<>]+$/';
        $error_invalid_subject_label = ! empty( $settings['invalid_subject'] ) ? stripslashes(esc_attr($settings['invalid_subject'])) : esc_attr__( 'Enter only alphanumeric characters and punctuation marks', 'simpleform' );
        $error = ! empty( $settings['subject_error'] ) ? stripslashes(esc_attr($settings['subject_error'])) : esc_html__('Error occurred validating the subject', 'simpleform');
        $subject_numeric_error = $characters_length == 'true' && ! empty( $settings['incomplete_subject'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_subject']) == $subject_length ? stripslashes(esc_attr($settings['incomplete_subject'])) : sprintf( __('Please enter a subject at least %d characters long', 'simpleform' ), $subject_length );
        $subject_generic_error = $characters_length != 'true' && ! empty( $settings['incomplete_subject'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_subject']) == '' ? stripslashes(esc_attr($settings['incomplete_subject'])) : esc_attr__('Please type a short and specific subject', 'simpleform' );
        $error_subject_label = $characters_length == 'true' ? $subject_numeric_error : $subject_generic_error;

        if ( $subject_requirement == 'required' )	{
          if ( empty($object) || strlen($object) < $subject_length ) {
             $field_error = true;
             $errors_query['subject'] = $error_subject_label;       		               
             $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields;
	         $errors_query['error'] = TRUE;
             $errors_query['showerror'] = $showerror;
          }
	      if (  ! empty($object) && ! preg_match($subject_regex, $object ) ) { 
             $field_error = true;
             $errors_query['subject'] = $error_invalid_subject_label;       		               
             $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields;
	         $errors_query['error'] = TRUE;
             $errors_query['showerror'] = $showerror;
	      }		
        }

        else {	
    	if ( ! empty($object) && strlen($object) < $subject_length ) {
             $field_error = true;
             $errors_query['subject'] = $error_subject_label;       		               
             $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields;
	         $errors_query['error'] = TRUE;
             $errors_query['showerror'] = $showerror;
	    }
	    if (  ! empty($object) && ! preg_match($subject_regex, $object ) ) { 
             $field_error = true;
             $errors_query['subject'] = $error_invalid_subject_label;       		               
             $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields;
	         $errors_query['error'] = TRUE;
             $errors_query['showerror'] = $showerror;
        }
        }

      }

      $message_length = isset( $attributes['message_minlength'] ) ? esc_attr($attributes['message_minlength']) : '10';
      $message_regex = '/^[^#$%&=+*{}|<>]+$/';
      $error_invalid_message_label = ! empty( $settings['invalid_message'] ) ? stripslashes(esc_attr($settings['invalid_message'])) : esc_attr__( 'Enter only alphanumeric characters and punctuation marks', 'simpleform' );
      $error = ! empty( $settings['message_error'] ) ? stripslashes(esc_attr($settings['message_error'])) : esc_html__('Error occurred validating the message', 'simpleform');
$message_numeric_error = $characters_length == 'true' && ! empty( $settings['incomplete_message'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_message']) == $message_length ? stripslashes(esc_attr($settings['incomplete_message'])) : sprintf( __('Please enter a message at least %d characters long', 'simpleform' ), $message_length );
$message_generic_error = $characters_length != 'true' && ! empty( $settings['incomplete_message'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_message']) == '' ? stripslashes(esc_attr($settings['incomplete_message'])) : esc_attr__('Please type a clearer message so we can respond appropriately', 'simpleform' );
$error_message_label = $characters_length == 'true' ? $message_numeric_error : $message_generic_error;
     	
      if ( empty($request) || strlen($request) < $message_length ) {
            $field_error = true;
            $errors_query['message'] = $error_message_label;       		               
            $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields;
	        $errors_query['error'] = TRUE;
            $errors_query['showerror'] = $showerror;
      }

      if (  ! empty($request) && ! preg_match($message_regex, $request )  ) { 
            $field_error = true;
            $errors_query['message'] = $error_invalid_message_label;       		               
            $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields;
	        $errors_query['error'] = TRUE;
            $errors_query['showerror'] = $showerror;
      }

      if ( $consent_field == 'visible' || $consent_field == 'registered' && is_user_logged_in() || $consent_field == 'anonymous' && ! is_user_logged_in() )  {  
        $error = ! empty( $settings['consent_error'] ) ? stripslashes(esc_attr($settings['consent_error'])) : esc_attr__( 'Please accept our privacy policy before submitting form', 'simpleform' );
        if ( $consent_requirement == 'required' && $consent == "false" ) { 
             $field_error = true;
             $errors_query['consent'] = $error;       		               
             $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields;
	         $errors_query['error'] = TRUE;
             $errors_query['showerror'] = $showerror;
        }
      }

      if ( ( $captcha_field == 'visible' || $captcha_field == 'registered' && is_user_logged_in() || $captcha_field == 'anonymous' && ! is_user_logged_in() ) && ! empty($captcha_one) && ! empty($captcha_two) && ( empty($captcha_answer) || $captcha_result != $captcha_answer ) ) { 
        $error_captcha_label = ! empty( $settings['invalid_captcha'] ) ? stripslashes(esc_attr($settings['invalid_captcha'])) : esc_attr__( 'Please enter a valid captcha value', 'simpleform' );
	    $error = ! empty( $settings['captcha_error'] ) ? stripslashes(esc_attr($settings['captcha_error'])) : esc_html__('Error occurred validating the captcha', 'simpleform');
        $field_error = true;
        $errors_query['captcha'] = $error_captcha_label;       		               
        $errors_query['notice'] = !isset($errors_query['error']) ? $error : $empty_fields;
	    $errors_query['error'] = TRUE;
        $errors_query['showerror'] = $showerror;
      }

      else {
	  if ( empty($field_error) ) { 
      $mailing = 'false';
      $success_action = ! empty( $settings['success_action'] ) ? esc_attr($settings['success_action']) : 'message';    
      $confirmation_img = plugins_url( 'img/confirmation.png', __FILE__ );
      $thank_string1 = esc_html__( 'We have received your request!', 'simpleform' );
      $thank_string2 = esc_html__( 'Your message will be reviewed soon, and we\'ll get back to you as quickly as possible.', 'simpleform' );
      $thank_you_message = ! empty( $settings['success_message'] ) ? stripslashes(wp_kses_post($settings['success_message'])) : '<div class="form confirmation" tabindex="-1"><h4>' . $thank_string1 . '</h4><br>' . $thank_string2 . '</br><img src="'.$confirmation_img.'" alt="message received"></div>';    
      $thanks_url = ! empty( $settings['thanks_url'] ) ? esc_url($settings['thanks_url']) : '';    
	  if( $success_action == 'message' ):
		   $redirect = false;
		   $redirect_url = '';
		   else:
		   $redirect = true;
		   $redirect_url = $thanks_url;
	  endif;
      $submission_timestamp = time();
      $submission_date = date('Y-m-d H:i:s');
	  global $wpdb;
	  $table_name = "{$wpdb->prefix}sform_submissions"; 
      $requester_type  = is_user_logged_in() ? 'registered' : 'anonymous';
      $user_ID = is_user_logged_in() ? get_current_user_id() : '0';
      
      $sform_default_values = array( "form" => $form_id, "date" => $submission_date, "requester_type" => $requester_type, "requester_id" => $user_ID );  
      $extra_fields = array('notes' => '');
      $submitter = $requester_name != ''  ? $requester_name : esc_html__( 'Anonymous', 'simpleform' );
      $sform_extra_values = array_merge($sform_default_values, apply_filters( 'sform_storing_values', $extra_fields, $form_id, $submitter, $requester_lastname, $requester_email, $phone, $subject_value, $request ));
      $sform_additional_values = array_merge($sform_extra_values, apply_filters( 'sform_testing', $extra_fields ));
      $success = $wpdb->insert($table_name, $sform_additional_values);
      $server_error = ! empty( $settings['server_error'] ) ? stripslashes(esc_attr($settings['server_error'])) : esc_attr__( 'Error occurred during processing data. Please try again!', 'simpleform' );
      
      if ( $success )  {		   
       if (has_action('spam_check_activation')):
          do_action( 'spam_check_activation' );
       endif;	      
       $notification = ! empty( $settings['notification'] ) ? esc_attr($settings['notification']) : 'true';
      
       if ($notification == 'true') { 
       $to = ! empty( $settings['notification_recipient'] ) ? esc_attr($settings['notification_recipient']) : esc_attr( get_option( 'admin_email' ) );
       $submission_number = ! empty( $settings['submission_number'] ) ? esc_attr($settings['submission_number']) : 'visible';
       $subject_type = ! empty( $settings['notification_subject'] ) ? esc_attr($settings['notification_subject']) : 'request';
       $subject_text = ! empty( $settings['custom_subject'] ) ? stripslashes(esc_attr($settings['custom_subject'])) : esc_html__('New Contact Request', 'simpleform');
       $subject = $subject_type == 'request' ? $request_subject : $subject_text;
         if ( $submission_number == 'visible' ):
         $reference_number = $wpdb->get_var($wpdb->prepare("SELECT id FROM `$table_name` WHERE date = %s", $submission_date) );
         $admin_subject = '#' . $reference_number . ' - ' . $subject;	
     	 else:
     	 $admin_subject = $subject;	
         endif;
       $from_data = '<b>'. esc_html__('From', 'simpleform') .':</b>&nbsp;&nbsp;';
       $from_data .= $requester;       
       if ( ! empty($requester_email) ):
       $from_data .= '&nbsp;&nbsp;&lt;&nbsp;' . $requester_email . '&nbsp;&gt;';
       else:
       $from_data .= '';
       endif;
       $from_data .= '<br>';       
       if ( ! empty($phone) ) { $phone_data = '<b>'. esc_html__('Phone', 'simpleform') .':</b>&nbsp;&nbsp;' . $phone .'<br>'; }
       else { $phone_data = ''; }
       $from_data .= $phone_data;
       if ( ! empty($subject_value) ) { $subject_data = '<br><b>'. esc_html__('Subject', 'simpleform') .':</b>&nbsp;&nbsp;' . $subject_value .'<br>'; }
       else { $subject_data = '<br>'; }
       $tzcity = get_option('timezone_string'); 
       $tzoffset = get_option('gmt_offset');
       if ( ! empty($tzcity))  { 
       $current_time_timezone = date_create('now', timezone_open($tzcity));
       $timezone_offset =  date_offset_get($current_time_timezone);
       $website_timestamp = $submission_timestamp + $timezone_offset; 
       }
       else { 
       $timezone_offset =  $tzoffset * 3600;
       $website_timestamp = $submission_timestamp + $timezone_offset;  
       }
       $website_date = date_i18n( get_option( 'date_format' ), $website_timestamp ) . ' ' . esc_html__('at', 'simpleform') . ' ' . date_i18n( get_option('time_format'), $website_timestamp );
       $admin_message_email = '<div style="line-height:18px; padding-top:10px;">' . $from_data . '<b>'. esc_html__('Sent', 'simpleform') .':</b>&nbsp;&nbsp;' . $website_date . $subject_data  . '<br>' .  $request . '</div>';    
       $notification_email = ! empty( $settings['notification_email'] ) ? esc_attr($settings['notification_email']) : esc_attr( get_option( 'admin_email' ) );
	   $from =  $notification_email;
	   $notification_reply = ! empty( $settings['notification_reply'] ) ? esc_attr($settings['notification_reply']) : 'true';
       $bcc = ! empty( $settings['bcc'] ) ? esc_attr($settings['bcc']) : '';
	   $headers = "Content-Type: text/html; charset=UTF-8" .  "\r\n";
       if ( ( ! empty($email) || is_user_logged_in() ) && $notification_reply == 'true' ) { $headers .= "Reply-To: ".$requester." <".$requester_email.">" . "\r\n"; }
       if ( ! empty($bcc) ) { $headers .= "Bcc: ".$bcc. "\r\n"; } 
       
       do_action('check_smtp');
       add_filter( 'wp_mail_from_name', array ( $this, 'sform_notification_sender_name' ) ); 
       add_filter( 'wp_mail_from', array ( $this, 'sform_notification_sender_email' ) );
       $recipients = explode(',', $to);
	   $sent = wp_mail($recipients, $admin_subject, $admin_message_email, $headers); 
       remove_filter( 'wp_mail_from_name', array ( $this, 'sform_notification_sender_name' ) );
       remove_filter( 'wp_mail_from', array ( $this, 'sform_notification_sender_email' ) );
	   $last_message = '<div style="line-height:18px;">' . $from_data . '<b>'. esc_html__('Date', 'simpleform') .':</b>&nbsp;&nbsp;' . $website_date . $subject_data . '<b>'. esc_html__('Message', 'simpleform') .':</b>&nbsp;&nbsp;' .  $request . '</div>';
       set_transient('sform_last_'.$form_id.'_message', $last_message, 0 );
       set_transient( 'sform_last_message', $last_message, 0 ); 
        if ($sent):
         $mailing = 'true';
        endif;
	  } 

      $confirmation = ! empty( $settings['autoresponder'] ) ? esc_attr($settings['autoresponder']) : 'false';
			
	   if ( $confirmation == 'true' && ! empty($email) ) {
		  $from = ! empty( $settings['autoresponder_email'] ) ? esc_attr($settings['autoresponder_email']) : esc_attr( get_option( 'admin_email' ) );
          $subject = ! empty( $settings['autoresponder_subject'] ) ? stripslashes(esc_attr($settings['autoresponder_subject'])) : esc_attr__( 'Your request has been received. Thanks!', 'simpleform' );
          $code_name = '[name]';
          $message = ! empty( $settings['autoresponder_message'] ) ? stripslashes(wp_kses_post($settings['autoresponder_message'])) : printf(__( 'Hi %s', 'simpleform' ),$code_name) . ',<p>' . esc_html__( 'We have received your request. It will be reviewed soon and we\'ll get back to you as quickly as possible.', 'simpleform' ) . esc_html__( 'Thanks,', 'simpleform' ) . esc_html__( 'The Support Team', 'simpleform' );          
          $reply_to = ! empty( $settings['autoresponder_reply'] ) ? esc_attr($settings['autoresponder_reply']) : $from;
		  $headers = "Content-Type: text/html; charset=UTF-8" . "\r\n";
		  $headers .= "Reply-To: <".$reply_to.">" . "\r\n";
	      $sql = "SELECT id FROM `$table_name` WHERE date = %s";
          $reference_number = $wpdb->get_var( $wpdb->prepare( $sql, $submission_date ) );
	      $tags = array( '[name]','[lastname]','[email]','[phone]','[subject]','[message]','[submission_id]' );
          $values = array( $name,$lastname,$email,$phone,$object,$request,$reference_number );
          $content = str_replace($tags,$values,$message);
          do_action('check_smtp');
          add_filter( 'wp_mail_from_name', array ( $this, 'sform_confirmation_sender_name' ) );
          add_filter( 'wp_mail_from', array ( $this, 'sform_confirmation_sender_email' ) ); 
	      wp_mail($email, $subject, $content, $headers);
          remove_filter( 'wp_mail_from_name', array ( $this, 'sform_confirmation_sender_name' ) );
          remove_filter( 'wp_mail_from', array ( $this, 'sform_confirmation_sender_email' ) );
	   }
	   
       if ( ! has_action('sform_ajax_message') ) {
          if ( $mailing == 'true' ) {
	   	   $errors_query['error'] = FALSE;
	       $errors_query['redirect'] = $redirect;  
	       $errors_query['redirect_url'] = $redirect_url;  
           $errors_query['notice'] = $thank_you_message;
	      } 
	      else {
	   	   $errors_query['error'] = TRUE;
           $errors_query['notice'] = $server_error;
           $errors_query['showerror'] = TRUE;
          } 	  
	   }
	   else { do_action( 'sform_ajax_message', $form_id, $mailing, $redirect, $redirect_url, $thank_you_message, $server_error ); }
       } 
      
      else  {
		$errors_query['error'] = TRUE;
        $errors_query['notice'] = $server_error;
        $errors_query['showerror'] = TRUE;
      }

	} 
	  }      
	          
      echo json_encode($errors_query);	 
      wp_die();
      
    } 

    }
 
	/**
	 * Force "From Name" in Notification Email 
	 *
	 * @since    1.0
	 */
   
    public function sform_notification_sender_name() {
	    
     $id = isset( $_POST['form-id'] ) ? absint($_POST['form-id']) : '';
	  
	 if ( $id == '' ) { 
        $settings = get_option('sform_settings');
        $attribute = '';
        $shortcode_values = apply_filters( 'sform_form', $attribute );
        $form_name = ! empty($shortcode_values['name']) ? stripslashes(esc_attr($shortcode_values['name'])) : esc_attr__( 'Contact Us Page','simpleform'); 
	  } else { 
		$settings_option = get_option('sform_widget_'. $id .'_settings');
        $settings = $settings_option != false ? $settings_option : get_option('sform_settings');
        $attribute = 'simpleform widget="'.$id.'"';
        $shortcode_values = apply_filters( 'sform_form', $attribute );
        $default_name = __( 'Contact Form','simpleform'); 
        $form_name = ! empty($shortcode_values['name']) && $shortcode_values['name'] != $default_name ? stripslashes(esc_attr($shortcode_values['name'])) :  __( 'Contact Form','simpleform') . ' ' . stripslashes(esc_attr($shortcode_values['area']));       
	 }
	    
     $sender = ! empty( $settings['notification_name'] ) ? esc_attr($settings['notification_name']) : 'requester';
     $custom_sender = ! empty( $settings['custom_sender'] ) ? esc_attr($settings['custom_sender']) : esc_attr( get_bloginfo( 'name' ) ); 

     if ( $sender == 'requester') { $sender_name = isset($_POST['sform-name']) ? sanitize_text_field($_POST['sform-name']) : esc_attr('Alex');
	     
	     /*
      if ( isset($_POST['sform-name']) ) { $sender_name = sanitize_text_field($_POST['sform-name']); }            
      else { $sender_name = 'Gianluca'; /*
	    if ( is_user_logged_in() ) {	//	 $sender_name = 'Alex';

		 global $current_user;
		 // $sender_name = ! empty($current_user->user_firstname) ? trim($current_user->user_firstname . ' ' . $current_user->user_lastname) : $current_user->display_name;
		 
		 $requester_id = get_current_user_id();
		 $user_info = get_user_by( 'id', $requester_id );
		 $user_firstname = ! empty($user_info->first_name) ? $user_info->first_name : $user_info->display_name;
		 $user_lastname = ! empty($user_info->last_name) ? $user_info->last_name : '';

		 // $sender_name = ! empty($user_firstname) ? trim($user_firstname . ' ' . $user_lastname) : $user_info->display_name;
		 
     	}
        else { $sender_name = esc_html__('Anonymous', 'simpleform');  }
        * /
        }
        
        
        
        
        
	    if ( is_user_logged_in() ) {
		global $current_user;
		$requester_name = ! empty($current_user->user_name) ? $current_user->user_name : $current_user->display_name;
        }
        else { $requester_name = ''; }
      }
            
      if ( ! empty($lastname) ) { $requester_lastname = ' ' . $lastname; }
      else {
	    if ( is_user_logged_in() ) {
		global $current_user;
		$requester_lastname = ! empty($current_user->user_lastname) ? ' ' . $current_user->user_lastname : '';
        }
        else { $requester_lastname = ''; }
      }

      $requester = $requester_name != '' || $requester_lastname != '' ? trim($requester_name . $requester_lastname) : esc_html__( 'Anonymous', 'simpleform' );
      
      
      
      
        */
      }
      
     if ( $sender == 'custom') { $sender_name = $custom_sender; }
    
     if ( $sender == 'form') { $sender_name = $form_name; }
     
     return $sender_name;
     
    }
  
	/**
	 * Force "From Email" in Notification Email 
	 *
	 * @since    1.0
	 */
   
    public function sform_notification_sender_email() {

     $id = isset( $_POST['widget-settings'] ) ? absint($_POST['widget-settings']) : '';
	  if ( $id == '' ) { 
        $settings = get_option('sform_settings');
	  } else { 
		$settings_option = get_option('sform_widget_'. $id .'_settings');
        $settings = $settings_option != false ? $settings_option : get_option('sform_settings');
	  }
      $notification_email = ! empty( $settings['notification_email'] ) ? esc_attr($settings['notification_email']) : esc_attr( get_option( 'admin_email' ) );
      
      return $notification_email;
      
    }

	/**
	 * Force "From Name" in Confirmation Email 
	 *
	 * @since    1.0
	 */
   
    public function sform_confirmation_sender_name() {
	    
	  $widget_id = isset( $_POST['widget-settings'] ) ? absint($_POST['widget-settings']) : '';

	  if ( $widget_id == '' ) { 
        $settings = get_option('sform_settings');
	  } else { 
		$settings_option = get_option('sform_widget_'. $widget_id .'_settings');
        $settings = $settings_option != false ? $settings_option : get_option('sform_settings');
	  }
	    
	  $sender_name = ! empty( $settings['autoresponder_name'] ) ? esc_attr($settings['autoresponder_name']) : esc_attr( get_bloginfo( 'name' ) ); 
	  
	  return $sender_name;
	  
    }

	/**
	 * Force "From Email" in Confirmation Email 
	 *
	 * @since    1.0
	 */
   
    public function sform_confirmation_sender_email() {
	
      $widget_id = isset( $_POST['widget-settings'] ) ? absint($_POST['widget-settings']) : '';
      
	  if ( $widget_id == '' ) { 
        $settings = get_option('sform_settings');
	  } else { 
		$settings_option = get_option('sform_widget_'. $widget_id .'_settings');
        $settings = $settings_option != false ? $settings_option : get_option('sform_settings');
	  }
	    
	  $from = ! empty( $settings['autoresponder_email'] ) ? esc_attr($settings['autoresponder_email']) : esc_attr( get_option( 'admin_email' ) );
	  
      return $from;
      
    }

} 