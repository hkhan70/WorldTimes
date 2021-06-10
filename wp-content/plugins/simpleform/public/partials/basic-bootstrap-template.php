<?php

if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Customitation guidelines:
 * After your modifications are done, you can change style using your personal stylesheet file by enabling the option in the settings page. 
 * Following class selectors cannot be removed: d-none, form-control, error-des, control-label, message. 
**/

// Text above Contact Form   
$form = '<div id="sform-introduction" class="'.$class_direction.'"><p>'.$introduction_text.'</p></div>';

// Confirmation message after ajax submission
$form .= '<div id="sform-confirmation"></div>';

// Contact Form starts here:
$form .= '<form id="sform" method="post" '.$form_attribute.' class="'.$form_class.'">';

// Contact Form top error message
$form .= $top_error;

// Name field
$name_input = $name_field == 'visible' || $name_field == 'registered' && is_user_logged_in() || $name_field == 'anonymous' && ! is_user_logged_in() ? '<div class="field-group name '.$name_row_class.'">'.$name_field_label.'<div class="'.$wrap_class.'"><input type="text" id="sform-name" name="sform-name" class="form-control '.$name_class.'" value="'.$name_value.'" placeholder="'.$name_placeholder.'" '.$name_attribute.'><div id="name-error" class="error-des"><span>'.$name_field_error.'</span></div></div></div>' : '';

// Lastname field
$lastname_input = $lastname_field == 'visible' || $lastname_field == 'registered' && is_user_logged_in() || $lastname_field == 'anonymous' && ! is_user_logged_in() ? '<div class="field-group lastname '.$name_row_class.'">'.$lastname_field_label.'<div class="'.$wrap_class.'"><input type="text" id="sform-lastname" name="sform-lastname" class="form-control '.$lastname_class.'" value="'.$lastname_value.'" placeholder="'.$lastname_placeholder.'" '.$lastname_attribute.'><div id="lastname-error" class="error-des"><span>'.$lastname_field_error.'</span></div></div></div>': ''; 

// Email field	     		
$email_input = $email_field == 'visible' || $email_field == 'registered' && is_user_logged_in() || $email_field == 'anonymous' && ! is_user_logged_in() ? '<div class="field-group email '.$email_row_class.'">'.$email_field_label.'<div class="'.$wrap_class.'"><input type="email" name="sform-email" id="sform-email" class="form-control '.$email_class.'" value="'.$email_value.'" placeholder="'.$email_placeholder.'" '.$email_attribute.' ><div id="email-error" class="error-des"><span>'.$email_field_error.'</span></div></div></div>' : '';

// Phone field
$phone_input = $phone_field == 'visible' || $phone_field == 'registered' && is_user_logged_in() || $phone_field == 'anonymous' && ! is_user_logged_in() ? '<div class="field-group phone '.$email_row_class.'">'.$phone_field_label.'<div class="'.$wrap_class.'"><input type="tel" id="sform-phone" name="sform-phone" class="form-control '.$phone_class.'" value="'.$phone_value.'" placeholder="'.$phone_placeholder.'" '.$phone_attribute.'><div id="phone-error" class="error-des"><span>'.$phone_field_error.'</span></div></div></div>' : ''; 

// Subject field
$subject_input = $subject_field == 'visible' || $subject_field == 'registered' && is_user_logged_in() || $subject_field == 'anonymous' && ! is_user_logged_in() ? '<div class="field-group '.$row_label.'">'.$subject_field_label.'<div class="'.$wrap_class.'"><input type="text" name="sform-subject" id="sform-subject" class="form-control '.$subject_class.'" '.$subject_attribute.' value="'.$subject_value.'" placeholder="'.$subject_placeholder.'" ><div id="subject-error" class="error-des"><span>'.$subject_field_error.'</span></div></div></div>' : '';

// Message field
$message_input = '<div class="field-group '.$row_label.'">'.$message_field_label.'<div class="'.$wrap_class.'"><textarea name="sform-message" id="sform-message" rows="10" type="textarea" class="form-control '.$message_class.'" required '.$message_maxlength.' placeholder="'.$message_placeholder.'">'.$message_value.'</textarea><div id="message-error" class="error-des"><span>'.$message_field_error.'</span></div></div></div>';

// Consent field
$consent_input = $consent_field == 'visible' || $consent_field == 'registered' && is_user_logged_in() || $consent_field == 'anonymous' && ! is_user_logged_in() ? '<div id="consent" class="form-group checkbox '.$inline_class.'"><input type="checkbox" name="sform-consent" id="sform-consent" class="'.$consent_class.'" value="'.$checkbox_value.'" '.$consent_attribute.'><label for="sform-consent" class="control-label '.$consent_class.'">'.$consent_label.$required_consent_label.'</label></div>' : '';

// Captcha field
$captcha_input = $captcha_field == 'visible' || $captcha_field == 'registered' && is_user_logged_in() || $captcha_field == 'anonymous' && ! is_user_logged_in() ? '<div class="field-group '.$row_label.'" id="captcha-container"><label for="sform-captcha" '.$label_class.'>'.$captcha_label.'<span>'.$required_captcha_sign.'</span></label><div id="captcha-question-wrap" class="'.$captcha_class.'">'.$captcha_hidden.'<input id="captcha-question" type="text" class="form-control" readonly="readonly" tabindex="-1" value="'.$captcha_question.'" /><input type="number" id="sform-captcha" name="sform-captcha" class="form-control '.$captcha_class.'" '.$captcha_attribute.' value="'.$captcha_value.'" /></div><div id="captcha-error" class="error-des '.$row_label.'"><span class="'.$captcha_error_class.'">'.$captcha_field_error.'</span></div></div>' : '';

// Form fields assembling
$form .= $name_input . $lastname_input . $email_input . $phone_input . $subject_input . $message_input . $consent_input . $captcha_input . $hidden_fields;

// Contact Form bottom error message
$form .= $bottom_error;

// Submit field
$form .= '<div id="sform-submit-wrap" class="'.$submit_class.'"><button name="submission" id="submission" type="submit" class="'.$button_class.' btn btn-primary">'.$submit_label.'</button>'.$animation.'</div></form>'; 

// Text below Contact Form
$form .= '<div id="sform-bottom" class="'.$class_direction.'"><p>'.$bottom_text.'</p></div>';

// Switch from displaying contact form to displaying success message if ajax submission is disabled
$contact_form = isset( $_GET['sending'] ) && $_GET['sending'] == 'success' ? $thank_you_message . $focus_confirmation : $form;