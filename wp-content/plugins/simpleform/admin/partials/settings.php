<?php

if ( ! defined( 'WPINC' ) ) die;
$settings = get_option('sform_settings');
$admin_notices = ! empty( $settings['admin_notices'] ) ? esc_attr($settings['admin_notices']) : 'false';
$extra = '';
?>

<div id="new-release-message" class="<?php if ( $admin_notices == 'true' ) {echo 'invisible';} ?>"><?php echo apply_filters( 'sform_update', $extra ); ?></div>
	    
<div class="sform wrap"><h1 class="backend"><span class="dashicons dashicons-admin-settings"></span><?php esc_html_e( 'Settings', 'simpleform' ); ?><span class="form-selector"></span></h1>

<div id="settings-description"><?php esc_html_e( 'Customize messages and whatever settings you want to better match your needs:','simpleform') ?></div>

<h2 class="nav-tab-wrapper"><a class="nav-tab nav-tab-active" id="general"><?php esc_html_e( 'General','simpleform') ?></a><a class="nav-tab" id="messages"><?php esc_html_e( 'Validation Messages','simpleform') ?></a><a class="nav-tab" id="email"><?php esc_html_e( 'Notifications','simpleform') ?></a><?php echo apply_filters( 'sform_itab', $extra ) ?></h2> 
						
<form id="settings" method="post">
<div id="tab-general" class="navtab">

<?php
$html5_validation = ! empty( $settings['html5_validation'] ) ? esc_attr($settings['html5_validation']) : 'false';
$outside_error = ! empty( $settings['outside_error'] ) ? esc_attr($settings['outside_error']) : 'bottom'; 
$focus = ! empty( $settings['focus'] ) ? esc_attr($settings['focus']) : 'field';
$ajax_submission = ! empty( $settings['ajax_submission'] ) ? esc_attr($settings['ajax_submission']) : 'false';
$spinner = ! empty( $sform_settings['spinner'] ) ? esc_attr($sform_settings['spinner']) : 'false';
$spinner = ! empty( $settings['spinner'] ) ? esc_attr($settings['spinner']) : 'false';
$form_template = ! empty( $settings['form_template'] ) ? esc_attr($settings['form_template']) : 'default'; 

switch ($form_template) {
  case 'basic':
  case 'rounded':
  case 'transparent':
  case 'highlighted':
  $template_notes = "&nbsp;";
  break;
  case 'customized':
  $template_notes = esc_attr__('Create a directory inside your active theme\'s directory, name it "simpleform", copy one of the template files, and name it "custom-template.php"', 'simpleform' );
  break;
  default:
  $template_notes = "&nbsp;";
}

switch ($outside_error) {
  case 'none':
  $focus_option = esc_attr__('Do not move focus', 'simpleform' );
  break;
  default:
  $focus_option = esc_attr__('Set focus to error message outside', 'simpleform' );
}

$stylesheet = ! empty( $settings['stylesheet'] ) ? esc_attr($settings['stylesheet']) : 'false';
$cssfile  = ! empty( $settings['stylesheet_file'] ) ? esc_attr($settings['stylesheet_file']) : 'false';
$javascript = ! empty( $settings['javascript'] ) ? esc_attr($settings['javascript']) : 'false';
$uninstall = ! empty( $settings['deletion_data'] ) ? esc_attr($settings['deletion_data']) : 'true'; 
?>		
	
<table class="form-table"><tbody>
	
<tr class="outside"><th class="last option"><span><?php esc_html_e('Admin Notices','simpleforms') ?></span></th><td class="last checkbox notes"><label for="admin-notices"><input  type="checkbox" class="sform" name="admin-notices" id="admin-notices" value="false" <?php checked( $admin_notices, 'true'); ?> ><?php esc_html_e( 'Never display notices on the SimpleForm related admin pages','simpleform') ?></label><p class="description"><?php esc_html_e('Admin notices could include but not limited to reminders, update notifications, call to action, links to documentation','simpleforms') ?></p></td></tr>		
	
<?php
$extra_option = '';
echo apply_filters( 'submissions_settings_filter', $extra_option );
?>

<tr><th class="heading" colspan="2"><span><?php esc_html_e( 'Form Submission Options','simpleform') ?></span></th></tr>	

<tr><th class="first option"><span><?php esc_html_e('AJAX Submission','simpleform') ?></span></th><td class="first checkbox"><label for="ajax-submission"><input type="checkbox" class="sform" name="ajax-submission" id="ajax-submission" value="true" <?php checked( $ajax_submission, 'true'); ?> ><?php esc_html_e('Perform form submission via AJAX instead of a standard HTML request','simpleform') ?></label></td></tr>

<tr class="trajax <?php if ($ajax_submission != 'true') { echo 'unseen'; } ?>"><th class="option"><span><?php esc_html_e('Loading Spinner', 'simpleform' ) ?></span></th><td class="checkbox"><label for="spinner"><input name="spinner" type="checkbox" class="sform" id="spinner" value="false" <?php checked( $spinner, 'true'); ?> ><?php esc_html_e('Use a CSS animation to let users know that their request is being processed','simpleform') ?></label></td></tr>

<tr><th class="option"><span><?php esc_html_e('HTML5 Browser Validation', 'simpleform' ) ?></span></th><td class="checkbox"><label for="html5-validation"><input name="html5-validation" type="checkbox" class="sform" id="html5-validation" value="false" <?php checked( $html5_validation, 'true'); ?> ><?php esc_html_e('Disable the browser default form validation','simpleform') ?></label></td></tr>

<tr><th class="option"><span><?php esc_html_e( 'Focus on Form Errors', 'simpleform' ) ?></span></th><td class="last radio"><fieldset><label for="field"><input id="field" type="radio" name="focus" value="field" <?php checked( $focus, 'field'); ?> ><?php esc_html_e( 'Set focus to first invalid field', 'simpleform' ) ?></label><label id="focusout" for="alert"><input id="alert" type="radio" name="focus" value="alert" <?php checked( $focus, 'alert'); ?> ><?php echo $focus_option; ?></label></fieldset></td></tr>

<tr><th class="heading" colspan="2"><span><?php esc_html_e('Customization Options', 'simpleform' ) ?></span></th></tr>
		
<tr><th class="first option"><span><?php esc_html_e('Form Template','simpleform') ?></span></th><td class="first select notes"><select name="form-template" id="form-template" class="sform"><option value="default" <?php selected( $form_template, 'default'); ?>><?php esc_html_e('Default','simpleform') ?></option><option value="basic" <?php selected( $form_template, 'basic'); ?>><?php esc_html_e('Bootstrap','simpleform') ?></option><option value="rounded" <?php selected( $form_template, 'rounded'); ?>><?php esc_html_e('Rounded Bootstrap','simpleform') ?></option><option value="transparent" <?php selected( $form_template, 'transparent'); ?>><?php esc_html_e('Minimal','simpleform') ?><option value="highlighted" <?php selected( $form_template, 'highlighted'); ?>><?php esc_html_e('Highlighted','simpleform') ?></option><option value="customized" <?php selected( $form_template, 'customized'); ?>><?php esc_html_e('Customized','simpleform') ?></option></select><p id="template-notice" class="description"><?php echo $template_notes ?></p></td></tr>

<tr><th class="option"><span><?php esc_html_e( 'Form CSS Stylesheet', 'simpleform' ) ?></span></th><td class="checkbox"><label for="stylesheet"><input id="stylesheet" name="stylesheet" type="checkbox" class="sform" value="true" <?php checked( $stylesheet, 'true'); ?> ><?php esc_html_e( 'Disable the SimpleForm CSS stylesheet and use your own CSS stylesheet', 'simpleform' ); ?></label></td></tr>

<tr class="trstylesheet <?php if ($stylesheet !='true') { echo 'unseen'; } ?>"><th class="option"><span><?php esc_html_e( 'CSS Stylesheet File', 'simpleform' ) ?></span></th><td class="checkbox notes"><label for="stylesheet-file"><input id="stylesheet-file" name="stylesheet-file" type="checkbox" class="sform" value="" <?php checked( $cssfile, 'true'); ?> ><?php esc_html_e( 'Include custom CSS code in a separate file', 'simpleform' ); ?></label><p id="stylesheet-description" class="description"><?php if ($cssfile !='true') { esc_html_e('Keep unchecked if you want to use your personal CSS code and include it somewhere in your theme\'s code without using an additional file', 'simpleform' ); } else { esc_html_e('Create a directory inside your active theme\'s directory, name it "simpleform", add your CSS stylesheet file, and name it "custom-style.css"', 'simpleform' ); } ?></p></td></tr>

<tr><th class="option"><span><?php esc_html_e( 'Custom JavaScript Code', 'simpleform' ) ?></span></th><td class="last checkbox notes"><label for="javascript"><input id="javascript" name="javascript" type="checkbox" class="sform" value="" <?php checked( $javascript, 'true'); ?> ><?php esc_html_e( 'Add your custom JavaScript code to your form', 'simpleform' ); ?></label><p id="javascript-description" class="description"><?php if ($javascript !='true') { esc_html_e('Keep unchecked if you want to use your personal JavaScript code and include it somewhere in your theme\'s code without using an additional file', 'simpleform' ); } else { esc_html_e('Create a directory inside your active theme\'s directory, name it "simpleform", add your JavaScript file, and name it "custom-script.js"', 'simpleform' ); } ?></p></td></tr>

<tr><th class="heading" colspan="2"><span><?php esc_html_e( 'Uninstall Options','simpleform') ?></span></th></tr>	

<tr><th class="option first"><span><?php esc_html_e('Uninstall', 'simpleform' ) ?></span></th><td class="wide checkbox"><label for="deletion"><input name="deletion" type="checkbox" class="sform" id="deletion" value="false" <?php checked( $uninstall, 'true'); ?> ><?php esc_html_e( 'Delete all data and settings when the plugin is uninstalled', 'simpleform' ) ?></label></td></tr>

</tbody></table>
</div>

<div id="tab-messages" class="navtab unseen">
	
<?php
$outside_error = ! empty( $settings['outside_error'] ) ? esc_attr($settings['outside_error']) : 'bottom'; 

switch ($outside_error) {
  case 'top':
  $error_notes = esc_attr__('Display an error message on top of the form in case of one or more errors in the fields', 'simpleform' );
  break;
  case 'bottom':
  $error_notes = esc_attr__('Display an error message on bottom of the form in case of one or more errors in the fields', 'simpleform' );
  break;
  default:
  $error_notes = "&nbsp;";
}

$empty_fields = ! empty( $settings['empty_fields'] ) ? stripslashes(esc_attr($settings['empty_fields'])) : esc_attr__( 'There were some errors that need to be fixed', 'simpleform' );
$characters_length = ! empty( $settings['characters_length'] ) ? esc_attr($settings['characters_length']) : 'true';
$attributes = get_option('sform_attributes');
$name_field = ! empty( $attributes['name_field'] ) ? esc_attr($attributes['name_field']) : 'visible';
$lastname_field = ! empty( $attributes['lastname_field'] ) ? esc_attr($attributes['lastname_field']) : 'hidden';
$required_name = ! empty( $attributes['name_requirement'] ) ? esc_attr($attributes['name_requirement']) : 'required';
$required_lastname = ! empty( $attributes['lastname_requirement'] ) ? esc_attr($attributes['lastname_requirement']) : 'optional';
$required_email = ! empty( $attributes['email_requirement'] ) ? esc_attr($attributes['email_requirement']) : 'required';
$required_phone = ! empty( $attributes['phone_requirement'] ) ? esc_attr($attributes['phone_requirement']) : 'optional';
$required_subject = ! empty( $attributes['subject_requirement'] ) ? esc_attr($attributes['subject_requirement']) : 'required';
$email_field = ! empty( $attributes['email_field'] ) ? esc_attr($attributes['email_field']) : 'visible';
$phone_field = ! empty( $attributes['phone_field'] ) ? esc_attr($attributes['phone_field']) : 'hidden';
$subject_field = ! empty( $attributes['subject_field'] ) ? esc_attr($attributes['subject_field']) : 'visible';
$consent_field = ! empty( $attributes['consent_field'] ) ? esc_attr($attributes['consent_field']) : 'visible';
$captcha_field = ! empty( $attributes['captcha_field'] ) ? esc_attr($attributes['captcha_field']) : 'hidden';  
$empty_name = isset( $attributes['empty_name'] ) ? esc_attr($attributes['empty_name']) : esc_attr__( 'Please provide your name', 'simpleform' );
$empty_lastname = isset( $attributes['empty_lastname'] ) ? esc_attr($attributes['empty_lastname']) : esc_attr__( 'Please provide your last name', 'simpleform' );
$empty_email = ! empty( $settings['empty_email'] ) ? stripslashes(esc_attr($settings['empty_email'])) : esc_attr__( 'Please provide your email address', 'simpleform' );
$empty_phone = ! empty( $settings['empty_phone'] ) ? stripslashes(esc_attr($settings['empty_phone'])) : esc_attr__( 'Please provide your phone number', 'simpleform' );
$empty_subject = ! empty( $settings['empty_subject'] ) ? stripslashes(esc_attr($settings['empty_subject'])) : esc_attr__( 'Please enter the request subject', 'simpleform' );
$empty_message = ! empty( $settings['empty_message'] ) ? stripslashes(esc_attr($settings['empty_message'])) : esc_attr__( 'Please enter your message', 'simpleform' );
$empty_captcha = ! empty( $settings['empty_captcha'] ) ? stripslashes(esc_attr($settings['empty_captcha'])) : esc_attr__( 'Please enter an answer', 'simpleform' );
$name_length = isset( $attributes['name_minlength'] ) ? esc_attr($attributes['name_minlength']) : '2';
$name_numeric_error = $characters_length == 'true' && ! empty( $settings['incomplete_name'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_name']) == $name_length ? stripslashes(esc_attr($settings['incomplete_name'])) : sprintf( __('Please enter at least %d characters', 'simpleform' ), $name_length );
$name_generic_error = $characters_length != 'true' && ! empty( $settings['incomplete_name'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_name']) == '' ? stripslashes(esc_attr($settings['incomplete_name'])) : esc_attr__('Please type your full name', 'simpleform' );
$incomplete_name = $characters_length == 'true' ? $name_numeric_error : $name_generic_error;
$lastname_length = isset( $attributes['lastname_minlength'] ) ? esc_attr($attributes['lastname_minlength']) : '2';
$subject_length = isset( $attributes['subject_minlength'] ) ? esc_attr($attributes['subject_minlength']) : '5';
$message_length = isset( $attributes['message_minlength'] ) ? esc_attr($attributes['message_minlength']) : '10';
$invalid_name = ! empty( $settings['invalid_name'] ) ? stripslashes(esc_attr($settings['invalid_name'])) : esc_attr__( 'The name contains invalid characters', 'simpleform' );
$name_error = ! empty( $settings['name_error'] ) ? stripslashes(esc_attr($settings['name_error'])) : esc_attr__( 'Error occurred validating the name', 'simpleform' );
$lastname_numeric_error = $characters_length == 'true' && ! empty( $settings['incomplete_lastname'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_lastname']) == $lastname_length ? stripslashes(esc_attr($settings['incomplete_lastname'])) : sprintf( __('Please enter at least %d characters', 'simpleform' ), $lastname_length );
$lastname_generic_error = $characters_length != 'true' && ! empty( $settings['incomplete_lastname'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_lastname']) == '' ? stripslashes(esc_attr($settings['incomplete_lastname'])) : esc_attr__('Please type your full last name', 'simpleform' );
$incomplete_lastname = $characters_length == 'true' ? $lastname_numeric_error : $lastname_generic_error;
$invalid_lastname = ! empty( $settings['invalid_lastname'] ) ? stripslashes(esc_attr($settings['invalid_lastname'])) : esc_attr__( 'The last name contains invalid characters', 'simpleform' );
$lastname_error = ! empty( $settings['lastname_error'] ) ? stripslashes(esc_attr($settings['lastname_error'])) : esc_attr__( 'Error occurred validating the last name', 'simpleform' );
$invalid_email = ! empty( $settings['invalid_email'] ) ? stripslashes(esc_attr($settings['invalid_email'])) : esc_attr__( 'Please enter a valid email', 'simpleform' );
$email_error = ! empty( $settings['email_error'] ) ? stripslashes(esc_attr($settings['email_error'])) : esc_attr__( 'Error occurred validating the email', 'simpleform' );
$invalid_phone = ! empty( $settings['invalid_phone'] ) ? stripslashes(esc_attr($settings['invalid_phone'])) : esc_attr__( 'The phone number contains invalid characters', 'simpleform' );
$phone_error = ! empty( $settings['phone_error'] ) ? stripslashes(esc_attr($settings['phone_error'])) : esc_attr__( 'Error occurred validating the phone number', 'simpleform' );
$subject_numeric_error = $characters_length == 'true' && ! empty( $settings['incomplete_subject'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_subject']) == $subject_length ? stripslashes(esc_attr($settings['incomplete_subject'])) : sprintf( __('Please enter a subject at least %d characters long', 'simpleform' ), $subject_length );
$subject_generic_error = $characters_length != 'true' && ! empty( $settings['incomplete_subject'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_subject']) == '' ? stripslashes(esc_attr($settings['incomplete_subject'])) : esc_attr__('Please type a short and specific subject', 'simpleform' );
$incomplete_subject = $characters_length == 'true' ? $subject_numeric_error : $subject_generic_error;
$invalid_subject = ! empty( $settings['invalid_subject'] ) ? stripslashes(esc_attr($settings['invalid_subject'])) : esc_attr__( 'Enter only alphanumeric characters and punctuation marks', 'simpleform' );
$subject_error = ! empty( $settings['subject_error'] ) ? stripslashes(esc_attr($settings['subject_error'])) : esc_attr__( 'Error occurred validating the subject', 'simpleform' );
$message_numeric_error = $characters_length == 'true' && ! empty( $settings['incomplete_message'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_message']) == $message_length ? stripslashes(esc_attr($settings['incomplete_message'])) : sprintf( __('Please enter a message at least %d characters long', 'simpleform' ), $message_length );
$message_generic_error = $characters_length != 'true' && ! empty( $settings['incomplete_message'] ) && preg_replace('/[^0-9]/', '', $settings['incomplete_message']) == '' ? stripslashes(esc_attr($settings['incomplete_message'])) : esc_attr__('Please type a clearer message so we can respond appropriately', 'simpleform' );
$incomplete_message = $characters_length == 'true' ? $message_numeric_error : $message_generic_error;
$invalid_message = ! empty( $settings['invalid_message'] ) ? stripslashes(esc_attr($settings['invalid_message'])) : esc_attr__( 'Enter only alphanumeric characters and punctuation marks', 'simpleform' );
$message_error = ! empty( $settings['message_error'] ) ? stripslashes(esc_attr($settings['message_error'])) : esc_attr__( 'Error occurred validating the message', 'simpleform' );
$consent_error = ! empty( $settings['consent_error'] ) ? stripslashes(esc_attr($settings['consent_error'])) : esc_attr__( 'Please accept our privacy policy before submitting form', 'simpleform' );
$invalid_captcha = ! empty( $settings['invalid_captcha'] ) ? stripslashes(esc_attr($settings['invalid_captcha'])) : esc_attr__( 'Please enter a valid captcha value', 'simpleform' );
$captcha_error = ! empty( $settings['captcha_error'] ) ? stripslashes(esc_attr($settings['captcha_error'])) : esc_attr__( 'Error occurred validating the captcha', 'simpleform' );
$honeypot_error = ! empty( $settings['honeypot_error'] ) ? stripslashes(esc_attr($settings['honeypot_error'])) : esc_attr__( 'Failed honeypot validation', 'simpleform' );
$server_error = ! empty( $settings['server_error'] ) ? stripslashes(esc_attr($settings['server_error'])) : esc_attr__( 'Error occurred during processing data. Please try again!', 'simpleform' );
$ajax_error = ! empty( $settings['ajax_error'] ) ? stripslashes(esc_attr($settings['ajax_error'])) : esc_attr__( 'Error occurred during AJAX request. Please contact support!', 'simpleform' );
$success_action = ! empty( $settings['success_action'] ) ? esc_attr($settings['success_action']) : 'message';
$confirmation_img = SIMPLEFORM_URL . 'public/img/confirmation.png';
$confirmation_page = ! empty( $settings['confirmation_page'] ) ? esc_attr($settings['confirmation_page']) : '';
$edit_post_link = '<strong><a href="' . get_edit_post_link($confirmation_page) . '" target="_blank" style="text-decoration: none; color: #9ccc79;">' . __( 'Publish now','simpleform') . '</a></strong>';	
/* translators: It is used in place of placeholder %1$s in the string: "%1$s or %2$s the page content" */
$edit = __( 'Edit','simpleform');
/* translators: It is used in place of placeholder %2$s in the string: "%1$s or %2$s the page content" */
$view = __( 'view','simpleform');
$post_url = $confirmation_page != '' ? sprintf( __('%1$s or %2$s the page content', 'simpleform'), '<strong><a href="' . get_edit_post_link($confirmation_page) .'" target="_blank" style="text-decoration: none;">'. $edit .'</a></strong>', '<strong><a href="' . get_page_link($confirmation_page) . '" target="_blank" style="text-decoration: none;">'. $view .'</a></strong>' ) : '&nbsp;'; 
$post_status = $confirmation_page != '' && get_post_status($confirmation_page) == 'draft' ? __( 'Page in draft status not yet published','simpleform').'&nbsp;-&nbsp;'.$edit_post_link : $post_url;
$thank_string1 = esc_html__( 'We have received your request!', 'simpleform' );
$thank_string2 = esc_html__( 'Your message will be reviewed soon, and we\'ll get back to you as quickly as possible.', 'simpleform' );
$thank_you_message = ! empty( $settings['success_message'] ) ? stripslashes(esc_attr($settings['success_message'])) : '<div class="form confirmation" tabindex="-1"><h4>' . $thank_string1 . '</h4><br>' . $thank_string2 . '</br><img src="'.$confirmation_img.'" alt="message received"></div>';
if ( $outside_error == 'top' ) {
/* translators: It is used in place of placeholder %s in the string: "Please enter an error message to be displayed on %s of the form" */
$error_position = esc_attr__('top', 'simpleform');
} else {
/* translators: It is used in place of placeholder %s in the string: "Please enter an error message to be displayed on %s of the form" */
$error_position = esc_attr__('bottom', 'simpleform');
}
?>	

<table class="form-table"><tbody>
	
<tr><th class="heading" colspan="2"><span id="misc"><?php esc_html_e( 'Fields Error Messages', 'simpleform' ) ?></span></th></tr>
	
<tr><th class="first option"><span><?php esc_html_e('Error Message Outside','simpleform') ?></span></th><td class="first select notes"><select name="outside-error" id="outside-error" class="sform"><option value="top" <?php selected( $outside_error, 'top'); ?>><?php esc_html_e('Top of Form','simpleform') ?></option><option value="bottom" <?php selected( $outside_error, 'bottom'); ?>><?php esc_html_e('Bottom of Form','simpleform') ?></option><option value="none" <?php selected( $outside_error, 'none'); ?>><?php esc_html_e('Do not display','simpleform') ?></option></select><p id="outside-notice" class="description"><?php echo $error_notes ?></p></td></tr>

<tr class="troutside <?php if ( $outside_error == 'none' ) {echo 'removed';}?>"><th id="" class="option"><span><?php esc_html_e('Multiple Fields Error','simpleform') ?></span></th><td id="" class="text"><input class="sform out" name="empty-fields" placeholder="<?php echo sprintf( __( 'Please enter an error message to be displayed on %s of the form in case of multiple empty fields', 'simpleform' ), $error_position ) ?>" id="empty-fields" type="text" value="<?php echo $empty_fields; ?>" \></td></tr>

<tr><th class="option"><span><?php esc_html_e('Length Error Type', 'simpleform' ) ?></span></th><td class="checkbox notes"><label for="characters-length"><input name="characters-length" type="checkbox" class="sform" id="characters-length" value="true" <?php checked( $characters_length, 'true'); ?> ><?php esc_html_e('Include the minimum number of required characters in length error message','simpleform') ?></label><p id="characters-description" class="description"><?php if ($characters_length =='true') { esc_html_e('Keep unchecked if you want to use a generic error message without showing the minimum number of required characters', 'simpleform' ); } else { esc_html_e('Keep checked if you want to show the minimum number of required characters and you want to make sure that\'s exactly the number you set for that specific field', 'simpleform' ); } ?></p></td></tr>

<tr class="<?php if ( $name_field =='hidden' || $required_name == 'optional' ) {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Empty Name Field Error','simpleform') ?></span></th><td class="text"><input class="sform" name="empty-name" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field in case of empty name field','simpleform') ?>" id="empty-name" type="text" value="<?php echo $empty_name; ?>" \></td></tr>

<tr class="<?php if ( $name_field =='hidden' || $name_length == 0) {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Name Length Error','simpleform') ?></span></th><td class="text"><input class="sform" name="incomplete-name" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field if the name is not long enough','simpleform') ?>" id="incomplete-name" type="text" value="<?php echo $incomplete_name; ?>" \></td></tr>
        
<tr class="<?php if ( $name_field =='hidden' ) {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Invalid Name Error','simpleform') ?></span></th><td class="text"><input type="text" class="sform" id="invalid-name" name="invalid-name" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field in case of an invalid name','simpleform') ?>" value="<?php echo $invalid_name; ?>" \></td></tr>

<tr class="troutside <?php if ( $name_field =='hidden' ) {echo 'unseen ';} if ( $outside_error == 'none' ) {echo 'removed';} ?>"><th class="option"><span><?php esc_html_e('Name Field Error','simpleform') ?></span></th><td class="text"><input class="sform out" name="name-error" placeholder="<?php echo sprintf( __( 'Please enter an error message to be displayed on %s of the form in case of an error in the name field', 'simpleform' ), $error_position ) ?>" id="name-error" type="text" value="<?php echo $name_error; ?>" \></td></tr>

<tr class="<?php if ( $lastname_field =='hidden' || $required_lastname == 'optional' ) {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Empty Last Name Field Error','simpleform') ?></span></th><td class="text"><input class="sform" name="empty-lastname" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field in case of empty last name field','simpleform') ?>" id="empty-lastname" type="text" value="<?php echo $empty_lastname; ?>" \></td></tr>
		
<tr class="<?php if ( $lastname_field =='hidden' || $lastname_length == 0) {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Last Name Length Error','simpleform') ?></span></th><td class="text"><input class="sform" name="incomplete-lastname" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field if the last name is not long enough','simpleform') ?>" id="incomplete-lastname" type="text" value="<?php echo $incomplete_lastname; ?>" \></td></tr>
        
<tr class="<?php if ( $lastname_field =='hidden' ) {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Invalid Last Name Error','simpleform') ?></span></th><td class="text"><input type="text" class="sform" id="invalid-lastname" name="invalid-lastname" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field in case of an invalid last name','simpleform') ?>" value="<?php echo $invalid_lastname; ?>" \></td></tr>

<tr class="troutside <?php if ( $lastname_field =='hidden' ) {echo 'unseen ';} if ( $outside_error == 'none' ) {echo 'removed';} ?>"><th class="option"><span><?php esc_html_e('Last Name Field Error','simpleform') ?></span></th><td class="text"><input class="sform out" name="lastname-error" placeholder="<?php echo sprintf( __( 'Please enter an error message to be displayed on %s of the form in case of an error in the last name field', 'simpleform' ), $error_position ) ?>" id="lastname-error" type="text" value="<?php echo $lastname_error; ?>" \></td></tr>

<tr class="<?php if ( $email_field =='hidden' || $required_email == 'optional' ) {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Empty Email Field Error','simpleform') ?></span></th><td class="text"><input class="sform" name="empty-email" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field in case of empty email field','simpleform') ?>" id="empty-email" type="text" value="<?php echo $empty_email; ?>" \></td></tr>

<tr class="<?php if ( $email_field =='hidden' ) {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Invalid Email Error','simpleform') ?></span></th><td class="text"><input class="sform" name="invalid-email" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field in case of invalid email','simpleform') ?>" id="invalid-email" type="text" value="<?php echo $invalid_email; ?>" \></td></tr>

<tr class="troutside <?php if ( $email_field =='hidden' ) {echo 'unseen ';} if ( $outside_error == 'none' ) {echo 'removed';} ?>"><th class="option"><span><?php esc_html_e('Email Field Error','simpleform') ?></span></th><td class="text"><input class="sform out" name="email-error" placeholder="<?php echo sprintf( __( 'Please enter an error message to be displayed on %s of the form in case of an error in the email field', 'simpleform' ), $error_position ) ?>" id="email-error" type="text" value="<?php echo $email_error; ?>" \></td></tr>

<tr class="<?php if ( $phone_field =='hidden' || $required_phone == 'optional' ) {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Empty Phone Field Error','simpleform') ?></span></th><td class="text"><input class="sform" name="empty-phone" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field in case of empty phone field','simpleform') ?>" id="empty-phone" type="text" value="<?php echo $empty_phone; ?>" \></td></tr>

<tr class="<?php if ( $phone_field =='hidden' ) {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Invalid Phone Error','simpleform') ?></span></th><td class="text"><input class="sform" name="invalid-phone" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field in case of an invalid phone number','simpleform') ?>" id="invalid-phone" type="text" value="<?php echo $invalid_phone; ?>" \></td></tr>

<tr class="troutside <?php if ( $phone_field =='hidden' ) {echo 'unseen ';} if ( $outside_error == 'none' ) {echo 'removed';} ?>"><th class="option"><span><?php esc_html_e('Phone Field Error','simpleform') ?></span></th><td class="text"><input class="sform out" name="phone-error" placeholder="<?php echo sprintf( __( 'Please enter an error message to be displayed on %s of the form in case of an error in the phone field', 'simpleform' ), $error_position ) ?>" id="phone-error" type="text" value="<?php echo $phone_error; ?>" \></td></tr>

<tr class="<?php if ( $subject_field =='hidden' || $required_subject == 'optional') {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Empty Subject Field Error','simpleform') ?></span></th><td class="text"><input class="sform" name="empty-subject" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field in case of empty subject field','simpleform') ?>" id="empty-subject" type="text" value="<?php echo $empty_subject; ?>" \></td></tr>

<tr class="<?php if ( $subject_field =='hidden' || $subject_length == 0) {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Subject Length Error','simpleform') ?></span></th><td class="text"><input type="text" class="sform" id="incomplete-subject" name="incomplete-subject" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field if the subject is not long enough','simpleform') ?>" value="<?php echo $incomplete_subject; ?>" \></td></tr>

<tr class="<?php if ( $subject_field =='hidden' ) {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Invalid Subject Error','simpleform') ?></span></th><td class="text"><input class="sform" name="invalid-subject" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field in case of an invalid subject','simpleform') ?>" id="invalid-subject" type="text" value="<?php echo $invalid_subject; ?>" \></td></tr>

<tr class="troutside <?php if ( $subject_field =='hidden' ) {echo 'unseen ';} if ( $outside_error == 'none' ) {echo 'removed';} ?>"><th class="option"><span><?php esc_html_e('Subject Field Error','simpleform') ?></span></th><td class="text"><input class="sform out" name="subject-error" placeholder="<?php echo sprintf( __( 'Please enter an error message to be displayed on %s of the form in case of an error in the subject field', 'simpleform' ), $error_position ) ?>" id="subject-error" type="text" value="<?php echo $subject_error; ?>" \></td></tr>

<tr><th class="option"><span><?php esc_html_e('Empty Message Field Error','simpleform') ?></span></th><td class="text"><input class="sform" name="empty-message" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field in case of empty message field','simpleform') ?>" id="empty-message" type="text" value="<?php echo $empty_message; ?>" \></td></tr>

<tr><th class="option"><span><?php esc_html_e('Message Length Error','simpleform') ?></span></th><td class="text"><input type="text" class="sform" name="incomplete-message" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field if the message is not long enough','simpleform') ?>" id="incomplete-message"  value="<?php echo $incomplete_message; ?>" \></td></tr>
		
<tr><th class="messagecell option <?php if ( $outside_error == 'none' && $consent_field == 'hidden' && $captcha_field =='hidden' ) {echo 'last';} ?>"><span><?php esc_html_e('Invalid Message Error','simpleform') ?></span></th><td class="messagecell text <?php if ( $outside_error == 'none' && $consent_field == 'hidden' && $captcha_field =='hidden' ) {echo 'last';} ?>"><input class="sform" name="invalid-message" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field in case of an invalid message','simpleform') ?>" id="invalid-message" type="text" value="<?php echo $invalid_message; ?>" \></td></tr>

<tr class="troutside <?php if ( $outside_error == 'none' ) {echo 'removed';}?>"><th class="option <?php if ( $consent_field == 'hidden' && $captcha_field =='hidden' ) {echo 'last';} ?>"><span><?php esc_html_e('Message Field Error','simpleform') ?></span></th><td class="text <?php if ( $consent_field == 'hidden' && $captcha_field =='hidden' ) {echo 'last';} ?>"><input class="sform out" name="message-error" placeholder="<?php echo sprintf( __( 'Please enter an error message to be displayed on %s of the form in case of an error in the message field', 'simpleform' ), $error_position ) ?>" id="message-error" type="text" value="<?php echo $message_error; ?>" \></td></tr>

<tr class="troutside <?php if ( $consent_field =='hidden' ) {echo 'unseen ';} if ( $outside_error == 'none' ) {echo 'removed';} ?>"><th class="option <?php if ( $captcha_field =='hidden') {echo 'last';}?>"><span><?php esc_html_e('Consent Field Error','simpleform') ?></span></th><td class="text <?php if ( $captcha_field =='hidden') {echo 'last';}?>"><input class="sform out" name="consent-error" placeholder="<?php echo sprintf( __( 'Please enter an error message to be displayed on %s of the form in case consent is not provided', 'simpleform' ), $error_position ) ?>" id="consent-error" type="text" value="<?php echo $consent_error; ?>" \></td></tr>

<tr class="<?php if ( $captcha_field =='hidden') {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Empty Captcha Field Error','simpleform') ?></span></th><td class="text"><input class="sform" name="empty-captcha" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field in case of an empty captcha field','simpleform') ?>" id="empty-captcha" type="text" value="<?php echo $empty_captcha; ?>" \></td></tr>

<tr id="trcaptcha" class="<?php if ( $captcha_field =='hidden' ) {echo 'unseen';}?>"><th class="captchacell option <?php if ( $outside_error == 'none' ) {echo 'last';} ?>"><span><?php esc_html_e('Invalid Captcha Error','simpleform') ?></span></th><td class="captchacell text <?php if ( $outside_error == 'none' ) {echo 'last';} ?>"><input class="sform" name="invalid-captcha" placeholder="<?php esc_html_e('Please enter an inline error message to be displayed below the field in case of invalid captcha value','simpleform') ?>" id="invalid-captcha" type="text" value="<?php echo $invalid_captcha; ?>" \></td></tr>

<tr class="troutside <?php if ( $captcha_field =='hidden' ) {echo 'unseen ';} if ( $outside_error == 'none' ) {echo 'removed';} ?>"><th class="option last"><span><?php esc_html_e('Captcha Field Error','simpleform') ?></span></th><td class="text last"><input class="sform out" name="captcha-error" placeholder="<?php echo sprintf( __( 'Please enter an error message to be displayed on %s of the form in case of error in captcha field', 'simpleform' ), $error_position ) ?>" id="captcha-error" type="text" value="<?php echo $captcha_error; ?>" \></td></tr>

<tr><th class="heading" colspan="2"><span id="misc"><?php esc_html_e( 'Submission Error Messages','simpleform') ?></span></th></tr>

<tr><th class="first option"><span><?php esc_html_e('Honeypot Error','simpleform') ?></span></th><td class="first text"><input class="sform out" name="honeypot-error" placeholder="<?php echo sprintf( __( 'Please enter an error message to be displayed on %s of the form in case a honeypot field is filled in', 'simpleform' ), $error_position ) ?>" id="honeypot-error" type="text" value="<?php echo $honeypot_error; ?>" \></td></tr>

<tr><th id="thserver" class="option <?php if ( $ajax_submission !='true' ) {echo 'last';} ?>"><span><?php esc_html_e( 'Server Error','simpleform') ?></span></th><td id="tdserver" class="text <?php if ( $ajax_submission !='true' ) {echo 'last';} ?>"><input class="sform out" name="server-error" placeholder="<?php echo sprintf( __( 'Please enter an error message to be displayed on %s of the form in case an error occurs during data processing', 'simpleform' ), $error_position ) ?>" id="server-error" type="text" value="<?php echo $server_error; ?>" \></td></tr>

<tr class="trajax <?php if ( $ajax_submission != 'true' ) {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('AJAX Error','simpleform') ?></span></th><td class="text last"><input class="sform out" name="ajax-error" placeholder="<?php echo sprintf( __( 'Please enter an error message to be displayed on %s of the form when the AJAX request fails', 'simpleform' ), $error_position ) ?>" id="ajax-error" type="text" value="<?php echo $ajax_error; ?>" \></td></tr>

<tr><th class="heading" colspan="2"><span id="misc"><?php esc_html_e( 'Success Message','simpleform') ?></span></th></tr>

<tr><th class="first option"><span><?php esc_html_e( 'Action After Submission', 'simpleform' ) ?></span></th><td class="first radio"><fieldset><label for="confirmation-message"><input id="confirmation-message" type="radio" name="success-action" value="message" <?php checked( $success_action, 'message'); ?> ><?php esc_html_e( 'Display confirmation message','simpleform') ?></label><label for="success-redirect"><input id="success-redirect" type="radio" name="success-action" value="redirect" <?php checked( $success_action, 'redirect'); ?> ><?php esc_html_e( 'Redirect to confirmation page','simpleform') ?></label></fieldset></td></tr>
 
<tr class="trsuccessmessage <?php if ($success_action !='message') { echo 'unseen'; }?>"><th class="last option"><span><?php esc_html_e( 'Confirmation Message', 'simpleform' ) ?></span></th><td class="textarea"><textarea class="sform" name="success-message" id="success-message" placeholder="<?php esc_html_e( 'Please enter a thank you message when the form is submitted', 'simpleform' ) ?>" ><?php echo $thank_you_message; ?></textarea><p class="description"><?php esc_html_e( 'The HTML tags for formatting message are allowed', 'simpleform' ) ?></p></td></tr>
				
<tr class="trsuccessredirect <?php if ($success_action !='redirect') { echo 'unseen'; }?>" ><th class="last option"><span><?php esc_html_e( 'Confirmation Page', 'simpleform' ) ?></span></th><td class="last select notes"><?php $pages = get_pages( array( 'sort_column' => 'post_title', 'sort_order' => 'ASC', 'post_type' => 'page', 'post_status' =>  array('publish','draft') ) ); if ( $pages ) { ?><select name="confirmation-page" class="sform" id="confirmation-page"><option value=""><?php esc_html_e( 'Select the page to which the user is redirected when the form is sent', 'simpleform' ) ?></option><?php foreach ($pages as $page) { ?><option value="<?php echo $page->ID; ?>" tag="<?php echo $page->post_status; ?>" slug="<?php echo $page->post_name; ?>"<?php selected( $confirmation_page, $page->ID ); ?>><?php echo $page->post_title; ?></option><?php } ?></select><?php } ?><p id="post-status" class="description"><?php echo $post_status ?></p></td></tr>

</tbody></table>
</div>

<div id="tab-email" class="navtab unseen">

<?php
$server_smtp = ! empty( $settings['server_smtp'] ) ? esc_attr($settings['server_smtp']) : 'false';
$smtp_host = ! empty( $settings['smtp_host'] ) ? esc_attr($settings['smtp_host']) : '';
$smtp_encryption = ! empty( $settings['smtp_encryption'] ) ? esc_attr($settings['smtp_encryption']) : 'ssl';
$smtp_port = ! empty( $settings['smtp_port'] ) ? esc_attr($settings['smtp_port']) : '465';
$smtp_authentication = ! empty( $settings['smtp_authentication'] ) ? esc_attr($settings['smtp_authentication']) : 'true';
$smtp_username = ! empty( $settings['smtp_username'] ) ? stripslashes(esc_attr($settings['smtp_username'])) : '';
$smtp_password = ! empty( $settings['smtp_password'] ) ? stripslashes(esc_attr($settings['smtp_password'])) : '';
$username_placeholder = defined( 'SFORM_SMTP_USERNAME' ) && ! empty(trim(SFORM_SMTP_USERNAME)) ? SFORM_SMTP_USERNAME : esc_html__( 'Enter the username for SMTP authentication', 'simpleform' ); 
$password_placeholder = defined( 'SFORM_SMTP_PASSWORD' ) && ! empty(trim(SFORM_SMTP_PASSWORD)) ? '•••••••••••••••' : esc_html__( 'Enter the password for SMTP authentication', 'simpleform' );
$notification = ! empty( $settings['notification'] ) ? esc_attr($settings['notification']) : 'true';
$notification_recipient = ! empty( $settings['notification_recipient'] ) ? esc_attr($settings['notification_recipient']) : esc_attr( get_option( 'admin_email' ) );
$notification_email = ! empty( $settings['notification_email'] ) ? esc_attr($settings['notification_email']) : esc_attr( get_option( 'admin_email' ) );
$notification_name = ! empty( $settings['notification_name'] ) ? esc_attr($settings['notification_name']) : 'requester';
$custom_sender = ! empty( $settings['custom_sender'] ) ? stripslashes(esc_attr($settings['custom_sender'])) : esc_attr( get_bloginfo( 'name' ) );
$notification_subject = ! empty( $settings['notification_subject'] ) ? esc_attr($settings['notification_subject']) : 'request';
$custom_subject = ! empty( $settings['custom_subject'] ) ? stripslashes(esc_attr($settings['custom_subject'])) : esc_html__('New Contact Request', 'simpleform');
$notification_reply = ! empty( $settings['notification_reply'] ) ? esc_attr($settings['notification_reply']) : 'true';
$bcc = ! empty( $settings['bcc'] ) ? esc_attr($settings['bcc']) : '';
$submission_number = ! empty( $settings['submission_number'] ) ? esc_attr($settings['submission_number']) : 'visible';
$autoresponder = ! empty( $settings['autoresponder'] ) ? esc_attr($settings['autoresponder']) : 'false';	
$autoresponder_email = ! empty( $settings['autoresponder_email'] ) ? esc_attr($settings['autoresponder_email']) : esc_attr( get_option( 'admin_email' ) );
$autoresponder_name = ! empty( $settings['autoresponder_name'] ) ? stripslashes(esc_attr($settings['autoresponder_name'])) : esc_attr( get_bloginfo( 'name' ) );
$autoresponder_subject = ! empty( $settings['autoresponder_subject'] ) ? stripslashes(esc_attr($settings['autoresponder_subject'])) : esc_html__( 'Your request has been received. Thanks!', 'simpleform' );
$code_name = '[name]';
$autoresponder_message = ! empty( $settings['autoresponder_message'] ) ? stripslashes(esc_attr($settings['autoresponder_message'])) : sprintf(__( 'Hi %s', 'simpleform' ),$code_name) . ',<p>' . esc_html__( 'We have received your request. It will be reviewed soon and we\'ll get back to you as quickly as possible.', 'simpleform' ) . '<p>' . esc_html__( 'Thanks,', 'simpleform' ) . '<br>' . esc_html__( 'The Support Team', 'simpleform' );          
$autoresponder_reply = ! empty( $settings['autoresponder_reply'] ) ? esc_attr($settings['autoresponder_reply']) : $autoresponder_email;
?>	  	

<table class="form-table"><tbody>
		
<tr class="smtp heading"><th class="heading" colspan="2"><span id="misc"><?php esc_html_e( 'SMTP Server Configuration', 'simpleform' ) ?></span><span id="smpt-warnings"><?php esc_html_e( 'Show Configuration Warnings', 'simpleform' ) ?></span></th></tr>	

<tr class="smtp smpt-warnings unseen"><td colspan="2"><div class="description"><h4><?php esc_html_e( 'Improve the email deliverability from your website by configuring WordPress to work with an SMTP server', 'simpleform' ) ?></h4><?php esc_html_e( 'By default, WordPress uses the PHP mail() function to send emails; a basic feature in built-in PHP. However, if your own website is hosted on a shared server, it is very likely that the mail() function has been disabled by your own hosting provider, due to the abuse risk it presents. If you are experiencing problems with email reception, that may be exactly the reason why you\'re not receiving emails. The best and recommended solution is to use an SMTP server to send all outgoing emails; a dedicated machine that takes care of the whole email delivery process. One important function of the SMTP server is to prevent spam, by using authentication mechanisms that only allow authorized users to deliver emails. So, using an SMTP server for outgoing email makes it less likely that email sent out from your website is marked as spam, and lowers the risk of email getting lost somewhere. As the sender, you have a choice of multiple SMTP servers to forward your emails: you can choose your internet service provider, your email provider, your hosting service provider, you can use a specialized provider, or you can even use your personal SMTP server. Obviously, the best option would be the specialized provider, but it is not necessary to subscribe to a paid service to have a good service, especially if you do not have any special needs, and you do not need to send marketing or transactional emails. We suggest you use your own hosting service provider\'s SMTP server, or your own email provider, initially. If you have a hosting plan, you just need to create a new email account that uses your domain name, if you haven\'t done so already. Then use the configuration information that your hosting provider gives you to connect to its own SMTP server, by filling all the fields in this section. If you haven\'t got a hosting plan yet, and your website is still running on a local host, you can use your preferred email address to send email; just enter the data provided by your email provider (Gmail, Yahoo, Hotmail, etc...). Don\'t forget to enable less secure apps on your email account. Furthermore, be careful to enter only your email address for that account, or an alias, into the "From Email" and the "Reply To" fields, since public SMTP servers have particularly strong spam filters, and do not allow you to override the email headers. Always remember to change the configuration data as soon as your website is put online, because your hosting provider may block outgoing SMTP connections. If you want to continue using your preferred email address, ask your hosting provider if the port used is open for outbound traffic.', 'simpleform' ) ?><p><?php printf( __('The SMPT login credentials are stored in your website database. We highly recommend that you set up your login credentials in your WordPress configuration file for improved security. To do this, leave the %1$s field and the %2$s field blank and add the lines below to your %3$s file:', 'simpleform'), '<i>SMTP Username</i>', '<i>SMTP Password</i>', '<code>wp-config.php</code>' ) ?></p><pre><?php echo 'define( \'SFORM_SMTP_USERNAME\', \'email\' ); // ' .  esc_html__('Your full email address (e.g. name@domain.com)', 'simpleform' ) ?><br><?php echo 'define( \'SFORM_SMTP_PASSWORD\', \'password\' ); // '. esc_html__('Your account\'s password', 'simpleform' ); ?></pre><?php esc_html_e( 'Anyway, this section is optional. Ignore it and do not enter data if you want to use a dedicated plugin to take care of outgoing email or if you don\'t have to.', 'simpleform' ) ?></p></div></td></tr>

<tr id="trsmtpon" class="smtp smpt-settings"><th id="thsmtp" class="option <?php if ($server_smtp !='true') { echo 'wide'; } else { echo 'first'; } ?>"><span><?php esc_html_e('SMTP Server', 'simpleform' ) ?></span></th><td id="tdsmtp" class="checkbox notes <?php if ($server_smtp !='true') { echo 'wide'; } else { echo 'first'; } ?>"><label for="server-smtp"><input type="checkbox" class="sform" id="server-smtp" name="server-smtp" value="false" <?php checked( $server_smtp, 'true'); ?> ><?php esc_html_e( 'Enable an SMTP server for outgoing email, if you haven\'t done so already', 'simpleform' ); ?></label><p id="smtp-notice" class="description <?php if ($server_smtp =='true') { echo ''; } else { echo 'invisible'; } ?>"><?php  esc_html_e('Uncheck if you want to use a dedicated plugin to take care of outgoing email', 'simpleform' ); ?></p></td></tr>
	
<tr class="smtp smpt-settings trsmtp <?php if ($server_smtp !='true') { echo 'unseen'; }?>"><th class="option"><span><?php esc_html_e( 'SMTP Host Address', 'simpleform' ) ?></span></th><td class="text notes"><input class="sform" name="smtp-host" placeholder="<?php esc_html_e( 'Enter the server address for outgoing email', 'simpleform' ) ?>" id="smtp-host" type="text" value="<?php echo $smtp_host; ?>" \><p class="description"><?php esc_html_e( 'Your outgoing email server address', 'simpleform' ) ?></p></td></tr>	
		
<tr class="smtp smpt-settings trsmtp <?php if ($server_smtp !='true') { echo 'unseen'; }?>" ><th class="option" ><span><?php esc_html_e( 'Type of Encryption', 'simpleform' ) ?></span></th><td class="radio notes"><fieldset><label for="no-encryption"><input id="no-encryption" type="radio" name="smtp-encryption" value="none" <?php checked( $smtp_encryption, 'none'); ?> ><?php esc_html_e( 'None','simpleform') ?></label><label for="ssl-encryption"><input id="ssl-encryption" type="radio" name="smtp-encryption" value="ssl" <?php checked( $smtp_encryption, 'ssl'); ?> ><?php esc_html_e( 'SSL','simpleform') ?></label><label for="tls-encryption" ><input id="tls-encryption" type="radio" name="smtp-encryption" value="tls" <?php checked( $smtp_encryption, 'tls'); ?> ><?php esc_html_e( 'TLS','simpleform') ?></label></fieldset><p class="description"><?php esc_html_e( 'If your SMTP provider supports both SSL and TLS options, we recommend using TLS encryption', 'simpleform' ) ?></p></td></tr>

<tr class="smtp smpt-settings trsmtp <?php if ($server_smtp !='true') { echo 'unseen'; }?>" ><th class="option"><span><?php esc_html_e( 'SMTP Port', 'simpleform' ) ?></span></th><td class="text notes"><input name="smtp-port" id="smtp-port" type="number" class="sform" value="<?php echo $smtp_port;?>" maxlength="4"><p class="description"><?php esc_html_e( 'The port that will be used to relay outgoing email to your email server', 'simpleform' ) ?></p></td></tr>
	
<tr id="form-fields-label" class="smtp smpt-settings trsmtp <?php if ($server_smtp !='true') { echo 'unseen'; }?>"><th id="thauthentication" class="option <?php if ($smtp_authentication !='true') { echo 'last'; }?>"><span><?php esc_html_e( 'SMTP Authentication', 'simpleform' ) ?></span></th><td class="checkbox notes <?php if ($smtp_authentication !='true') { echo 'last'; }?>" id="tdauthentication"><label for="smtp-authentication"><input id="smtp-authentication" name="smtp-authentication" type="checkbox" class="sform" value="true" <?php checked( $smtp_authentication, 'true'); ?> ><?php esc_html_e( 'Enable SMTP Authentication', 'simpleform' ); ?></label><p class="description"><?php esc_html_e( 'This option should always be checked', 'simpleform' ) ?> </p></td></tr>

<tr valign="top" class="smtp smpt-settings trsmtp trauthentication <?php if ($server_smtp !='true' || $smtp_authentication !='true' ) { echo 'unseen'; }?>"><th class="option"><span><?php esc_html_e( 'SMTP Username','simpleform') ?></span></th><td class="text notes"><input class="sform" name="smtp-username" placeholder="<?php echo $username_placeholder ?>" id="smtp-username" type="text" value="<?php echo $smtp_username; ?>" \><p class="description"><?php esc_html_e( 'The username to log in to the SMTP email server (your email). Please read the above warnings for improved security','simpleform') ?></p></td></tr>	
		
<tr class="smtp smpt-settings trsmtp trauthentication <?php if ($server_smtp !='true' || $smtp_authentication !='true' ) { echo 'unseen'; }?>"><th class="last option"><span><?php esc_html_e( 'SMTP Password','simpleform') ?></span></th><td class="last text notes"><input class="sform" name="smtp-password" placeholder="<?php echo $password_placeholder ?>" id="smtp-password" type="text" value="<?php echo $smtp_password; ?>" \><p class="description"><?php esc_html_e( 'The password to log in to the SMTP email server (your password). Please read the above warnings for improved security','simpleform') ?></p></td></tr>	

<tr><th class="heading" colspan="2"><span id="misc"><?php esc_html_e( 'Admin Notification Configuration', 'simpleform' ); ?></span></th></tr>

<tr><th id="thnotification" class="option <?php if ($notification !='true') { echo 'wide'; } else { echo 'first'; } ?>" ><span ><?php esc_html_e( 'Admin Notification', 'simpleform' ); ?></span></th><td id="tdnotification"  class="checkbox <?php if ($notification !='true') { echo 'wide'; } else { echo 'first'; } ?>"><label for="notification"><input name="notification" type="checkbox" class="sform" id="notification" value="true" <?php checked( $notification, 'true'); ?> ><?php esc_html_e( 'Send email to alert the admin, or person responsible for managing contacts, when the form has been successfully submitted', 'simpleform' ); ?></label></td></tr>
   
<tr class="trnotification <?php if ($notification !='true') { echo 'unseen'; }?>"><th class="option"><span><?php esc_html_e( 'Send To', 'simpleform' ) ?></span></th><td class="text notes"><input class="sform" name="notification-recipient" placeholder="<?php esc_html_e( 'Enter the email address to which the admin notification is sent', 'simpleform' ) ?>" id="notification-recipient" type="text" value="<?php echo $notification_recipient; ?>" ><p class="description"><?php esc_html_e( 'Use a comma separated list of email addresses to send to more than one address', 'simpleform' ) ?></p></td></tr>
	       
<tr class="trnotification <?php if ($notification !='true') { echo 'unseen'; }?>"><th class="option"><span><?php esc_html_e( 'BCC', 'simpleform' ) ?></span></th><td class="text notes"><input class="sform" name="bcc" placeholder="<?php esc_html_e( 'Enter the email address to which a copy of the admin notification is sent', 'simpleform' ) ?>" id="bcc" type="text" value="<?php echo $bcc; ?>" ><p class="description"><?php esc_html_e( 'Use a comma separated list of email addresses to send to more than one address', 'simpleform' ) ?></p></td></tr>

<tr class="trnotification trfromemail <?php if ($notification !='true') { echo 'unseen'; }?>"><th class="option"><span><?php esc_html_e( 'From Email', 'simpleform' ) ?></span></th><td class="text"><input class="sform" name="notification-email" placeholder="<?php esc_html_e( 'Enter the email address from which the admin notification is sent', 'simpleform' ) ?>" id="notification-email" type="text" value="<?php echo $notification_email; ?>" \></td></tr>      
       
<tr class="trnotification trfromemail <?php if ($notification !='true') { echo 'unseen'; }?>" ><th class="option"><span><?php esc_html_e( 'From Name', 'simpleform' ) ?></span></th><td class="radio"><fieldset><label for="requester-name"><input id="requester-name" type="radio" name="notification-name" value="requester" <?php checked( $notification_name, 'requester'); ?> ><?php esc_html_e( 'Use submitter name', 'simpleform' ) ?></label><label for="form-name"><input id="form-name" type="radio" name="notification-name" value="form" <?php checked( $notification_name, 'form'); ?> ><?php esc_html_e( 'Use contact form name', 'simpleform' ) ?></label><label for="custom-name"><input id="custom-name" type="radio" name="notification-name" value="custom" <?php checked( $notification_name, 'custom'); ?> ><?php esc_html_e( 'Use default name', 'simpleform' ) ?></label><br></fieldset></td></tr>
	
<tr class="trnotification trcustomname <?php if ( $notification != 'true' || $notification_name != 'custom') { echo 'unseen'; }?>" ><th class="option"><span><?php esc_html_e( 'Default Name', 'simpleform' ) ?></span></th><td class="text"><input class="sform" name="custom-sender" placeholder="<?php esc_html_e( 'Enter the name from which the admin notification is sent', 'simpleform' ) ?>" id="custom-sender" type="text" value="<?php echo $custom_sender; ?>" \></td></tr>

<tr class="trnotification <?php if ($notification !='true') { echo 'unseen'; }?>" ><th class="option"><span><?php esc_html_e( 'Email Subject', 'simpleform' ) ?></span></th><td class="radio"><fieldset><label for="request-subject"><input id="request-subject" type="radio" name="notification-subject" value="request" <?php checked( $notification_subject, 'request'); ?> ><?php esc_html_e( 'Use submission subject', 'simpleform' ) ?></label><label for="default-subject"><input id="default-subject" type="radio" name="notification-subject" value="custom" <?php checked( $notification_subject, 'custom'); ?> ><?php esc_html_e( 'Use default subject', 'simpleform' ) ?></label></fieldset></td></tr>

<tr class="trnotification trcustomsubject <?php if ( $notification != 'true' || $notification_subject != 'custom') { echo 'unseen'; }?>" ><th class="option"><span><?php esc_html_e( 'Default Subject', 'simpleform' ) ?></span></th><td class="text"><input class="sform" name="custom-subject" placeholder="<?php esc_html_e( 'Enter the subject with which the admin notification is sent', 'simpleform' ) ?>" id="custom-subject" type="text" value="<?php echo $custom_subject; ?>" \></td></tr>

<tr class="trnotification <?php if ($notification !='true') { echo 'unseen'; }?>"><th class="option"><span><?php esc_html_e( 'Reply To', 'simpleform' ) ?></span></th><td class="checkbox"><label for="notification-reply"><input name="notification-reply" type="checkbox" class="sform" id="notification-reply" value="true" <?php checked( $notification_reply, 'true'); ?> ><?php esc_html_e( 'Use the email address of the person who filled in the form for reply-to if email is provided', 'simpleform' ); ?></label></td></tr>

<tr class="trnotification <?php if ($notification !='true') { echo 'unseen'; }?>"><th class="option"><span><?php esc_html_e('Submission ID','simpleform') ?></span></th><td class="last checkbox"><label for="submission-number"><input name="submission-number" type="checkbox" class="sform" id="submission-number" value="hidden" <?php checked( $submission_number, 'hidden'); ?> ><?php esc_html_e( 'Hide submission ID inside email subject', 'simpleform' ); ?></label></td></tr>

<tr><th class="heading" colspan="2"><span id="misc"><?php esc_html_e( 'Auto Responder Configuration', 'simpleform' ) ?></span></th></tr>

<tr class="trname"><th id="thconfirmation" class="option <?php if ($autoresponder !='true') { echo 'wide'; } else { echo 'first'; } ?>"><span><?php esc_html_e( 'Auto Responder', 'simpleform' ) ?></span></th><td id="tdconfirmation" class="checkbox <?php if ($autoresponder !='true') { echo 'wide'; } else { echo 'first'; } ?>"><label for="autoresponder"><input name="autoresponder" type="checkbox" class="sform" id="autoresponder" value="false" <?php checked( $autoresponder, 'true'); ?> ><?php esc_html_e( 'Send a confirmation email to users who have successfully submitted the form', 'simpleform' ); ?></label></td></tr>

<tr class="trconfirmation <?php if ($autoresponder !='true') { echo 'unseen'; }?>"><th class="option" ><span><?php esc_html_e( 'From Email', 'simpleform' ) ?></span></th><td class="text"><input class="sform" name="autoresponder-email" placeholder="<?php esc_html_e( 'Enter the email address which auto-reply is sent from', 'simpleform' ) ?>" id="autoresponder-email" type="text" value="<?php echo $autoresponder_email; ?>" \></td></tr>

<tr class="trconfirmation <?php if ($autoresponder !='true') { echo 'unseen'; }?>"><th class="option"><span><?php esc_html_e( 'From Name', 'simpleform' ) ?></span></th><td class="text"><input class="sform" name="autoresponder-name" placeholder="<?php esc_html_e( 'Enter the name which auto-reply is sent from', 'simpleform' ) ?>" id="autoresponder-name" type="text" value="<?php echo $autoresponder_name; ?>" \></td></tr>

<tr class="trconfirmation <?php if ($autoresponder !='true') { echo 'unseen'; }?>"><th class="option"><span><?php esc_html_e( 'Email Subject', 'simpleform' ) ?></span></th><td class="text"><input class="sform" name="autoresponder-subject" placeholder="<?php esc_html_e( 'Enter the subject with which auto-reply is sent', 'simpleform' ) ?>" id="autoresponder-subject" type="text" value="<?php echo $autoresponder_subject; ?>" \></td></tr>

<tr class="trconfirmation trmessage <?php if ($autoresponder !='true') { echo 'unseen'; }?>"><th><span><?php esc_html_e( 'Email Message', 'simpleform' ) ?></span></th><td><textarea name="autoresponder-message" id="autoresponder-message" class="sform" placeholder="<?php esc_html_e( 'Enter the content for your auto-reply message', 'simpleform' ) ?>" ><?php echo $autoresponder_message; ?></textarea><p class="description"><?php esc_html_e( 'You are able to use HTML tags and the following smart tags:', 'simpleform' ) ?> [name], [lastname], [email], [phone], [subject], [message], [submission_id]</p></td></tr>

<tr class="trconfirmation <?php if ($autoresponder !='true') { echo 'unseen'; }?>"><th class="last option"><span><?php esc_html_e( 'Reply To', 'simpleform' ) ?></span></th><td class="last text notes"><input class="sform" name="autoresponder-reply" placeholder="<?php esc_html_e( 'Enter the email address to use for reply-to', 'simpleform' ) ?>" id="autoresponder-reply" type="text" value="<?php echo $autoresponder_reply; ?>" \><p class="description"><?php esc_html_e( 'Leave it blank to use From Email as the Reply-To value', 'simpleform' ) ?></p></td></tr>

</tbody></table>
</div>

<div id="submit-wrap"><div id="alert-wrap">
<noscript><div id="noscript"><?php esc_html_e('You need JavaScript enabled to save settings. Please activate it. Thanks!', 'simpleform' ) ?></div></noscript>
<div id="message-wrap" class="message"></div>
</div>

<input type="submit" class="submit-button" id="save-settings" name="save-settings" value="<?php esc_html_e( 'Save Changes', 'simpleform' ) ?>">

<?php wp_nonce_field( 'ajax-verification-nonce', 'verification_nonce'); ?>
</form></div>