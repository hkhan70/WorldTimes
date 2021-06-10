<?php

if ( ! defined( 'WPINC' ) ) die;

$widget_page = is_active_widget( false, false, 'sform_widget', true ) ? 'true' : 'false';
$sform_widget = get_option('widget_sform_widget');
$highlighted_id = array_key_first($sform_widget);	
$id = isset( $_REQUEST['id'] ) ? absint($_REQUEST['id']) : $highlighted_id;

if ( $widget_page == 'true' && in_array($id, array_keys($sform_widget)) ) {
$sidebars_widgets = get_option('sidebars_widgets');
$widget_id = 'sform_widget-'.$id;
global $wp_registered_sidebars;
$widget_for = ! empty($sform_widget[$id]['sform_widget_audience']) ? $sform_widget[$id]['sform_widget_audience'] : 'all';
$settings = get_option('sform_settings');
$attributes_option = get_option('sform_widget_'.$id.'_attributes');
$attributes = $attributes_option != false ? $attributes_option : get_option('sform_attributes');

if ( $widget_for == 'out' ) {
  $widget_name_field = 'anonymous';
  $widget_email_field = 'anonymous';
  $widget_subject_field = 'anonymous';
  $widget_consent_field = 'anonymous';
  /* translators: It is used in place of placeholder %s in the string: "You set the widget as visible only for %s" */
  $target = __( 'logged-out users','simpleform');
  $audience = __( 'Logged-out users','simpleform');
}
elseif ( $widget_for == 'in' ) {
  $widget_name_field = 'registered' ;
  $widget_email_field = 'registered';
  $widget_subject_field = 'registered';
  $widget_consent_field = 'registered';
  /* translators: It is used in place of placeholder %s in the string: "You set the widget as visible only for %s" */
  $target = __( 'logged-in users','simpleform');
  $audience = __( 'Logged-in users','simpleform');
}
else {
  $widget_name_field = 'visible'; 
  $widget_email_field = 'visible';
  $widget_subject_field = 'visible';
  $widget_consent_field = 'visible';
  $target = '';
  $audience = __( 'Everyone','simpleform');
}

$widget_editor = ! empty($sform_widget[$id]['sform_widget_editor']) ? $sform_widget[$id]['sform_widget_editor'] : 'false';
switch ($widget_editor) {
  case 'true':
  $description = esc_html__( 'Change easily the way your contact form is displayed. Choose which fields to use and who should see them:','simpleform');
  $description_class = 'editorpage';
  break;
  default: 
  /* translators: It is used in place of placeholder %s in the string: "You need to enable the "Override Editor" option in the %s for the changes to take effect." */
  $widgets_url = '<a href="'.self_admin_url('widgets.php').'" target="_blank">' .  __('SimpleForm Contact Form Widget', 'simpleform') . '</a>';
  $description = '<div class="deactivation">' . sprintf( __('You need to enable the "Override Editor" option in the %s for the changes to take effect.', 'simpleform' ), $widgets_url ) . ' '. __('When it\'s done, please reload the page!', 'simpleform' ) . '</div>';
  $description_class = '';
}

$shortcode_name = 'simpleform widget="'.$id.'"';
global $wpdb;
$table_name = "{$wpdb->prefix}sform_shortcodes";
$shortcode_values = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE shortcode = '%s'", $shortcode_name ), ARRAY_A );
$form_name = ! empty($shortcode_values['name']) ? stripslashes(esc_attr($shortcode_values['name'])) : __( 'Contact Form','simpleform');
?>	
	
<div id="widget-page">
	
<div class="page-description <?php echo $description_class ?>"><?php echo $description ?></div>

<h2 class="nav-tab-wrapper"><a class="nav-tab nav-tab-active" id="builder"><?php esc_html_e( 'Form Builder','simpleform') ?></a><a class="nav-tab" id="appearance"><?php esc_html_e( 'Form Appearance','simpleform') ?></a></h2>

<form id="attributes" method="post">
	
<div id="tab-builder" class="navtab"><table class="form-table"><tbody>	

<tr class="outside"><th class="option"><span><?php esc_html_e('Widget Name','simpleform') ?></span></th><td class="text" style="line-height: 42px;"><span><?php esc_html_e( 'SimpleForm Contact Form','simpleform') ?></span><a href="<?php echo self_admin_url('widgets.php'); ?>" target="_blank"><span id="edit-widget" type="submit" name="submit" id="" class="sf button button-primary" ><?php esc_html_e('Edit Widget','simpleform') ?></span></a></td></tr>

<tr><th class="option"><span><?php esc_html_e('Widget Area','simpleform') ?></span></th><td class="text"><?php foreach($sidebars_widgets as $key=>$value) { if ( is_array($value) && in_array($widget_id, $value)) { echo $wp_registered_sidebars[$key]['name']; } else { echo ''; } } ?></td></tr>


<tr><th class="option"><span><?php esc_html_e('Form Name','simpleform') ?></span></th><td class="text"><input class="sform" name="form-name" placeholder="<?php esc_html_e('Enter a name for this Form','simpleform') ?>" id="form-name" type="text" value="<?php echo $form_name; ?>"></td></tr>
	

<tr><th class="last option"><span><?php esc_html_e('Displayed for','simpleform') ?></span></th><td class="last text"><?php echo $audience; ?></td></tr>

<input type="hidden" id="widget-id" name="widget-id" value="<?php echo $id ?>">
<input type="hidden" id="widget-for" name="widget-for" value="<?php echo $widget_for ?>">
<input type="hidden" id="widget-editor" name="widget-editor" value="<?php echo $widget_editor ?>">

<?php
$introduction_text = isset ( $attributes['introduction_text'] ) ? esc_attr($attributes['introduction_text']) : esc_attr__( 'Please fill out the form below and we will get back to you as soon as possible. Mandatory fields are marked with (*).', 'simpleform' );
$bottom_text = ! empty( $attributes['bottom_text'] ) ? esc_attr($attributes['bottom_text']) : '';
$name_field = ! empty( $attributes['name_field'] ) ? esc_attr($attributes['name_field']) : $widget_name_field;
$name_visibility = ! empty( $attributes['name_visibility'] ) ? esc_attr($attributes['name_visibility']) : 'visible';
$name_label = ! empty( $attributes['name_label'] ) ? stripslashes(esc_attr($attributes['name_label'])) : esc_attr__( 'Name', 'simpleform' );
$name_placeholder = ! empty( $attributes['name_placeholder'] ) ? stripslashes(esc_attr($attributes['name_placeholder'])) : '';
$name_minlength = isset( $attributes['name_minlength'] ) ? esc_attr($attributes['name_minlength']) : '2';
$name_maxlength = isset( $attributes['name_maxlength'] ) ? esc_attr($attributes['name_maxlength']) : '0';
$name_requirement = ! empty( $attributes['name_requirement'] ) ? esc_attr($attributes['name_requirement']) : 'required';
$lastname_field = ! empty( $attributes['lastname_field'] ) ? esc_attr($attributes['lastname_field']) : 'hidden';
$lastname_visibility = ! empty( $attributes['lastname_visibility'] ) ? esc_attr($attributes['lastname_visibility']) : 'visible';
$lastname_label = ! empty( $attributes['lastname_label'] ) ? stripslashes(esc_attr($attributes['lastname_label'])) : esc_attr__( 'Last Name', 'simpleform' );
$lastname_placeholder = ! empty( $attributes['lastname_placeholder'] ) ? stripslashes(esc_attr($attributes['lastname_placeholder'])) : '';
$lastname_minlength = isset( $attributes['lastname_minlength'] ) ? esc_attr($attributes['lastname_minlength']) : '2';
$lastname_maxlength = isset( $attributes['lastname_maxlength'] ) ? esc_attr($attributes['lastname_maxlength']) : '0';
$lastname_requirement = ! empty( $attributes['lastname_requirement'] ) ? esc_attr($attributes['lastname_requirement']) : 'optional';
$email_field = ! empty( $attributes['email_field'] ) ? esc_attr($attributes['email_field']) : $widget_email_field;
$email_visibility = ! empty( $attributes['email_visibility'] ) ? esc_attr($attributes['email_visibility']) : 'visible';
$email_label = ! empty( $attributes['email_label'] ) ? stripslashes(esc_attr($attributes['email_label'])) : esc_attr__( 'Email', 'simpleform' );
$email_placeholder = ! empty( $attributes['email_placeholder'] ) ? stripslashes(esc_attr($attributes['email_placeholder'])) : '';
$email_requirement = ! empty( $attributes['email_requirement'] ) ? esc_attr($attributes['email_requirement']) : 'required';
$phone_field = ! empty( $attributes['phone_field'] ) ? esc_attr($attributes['phone_field']) : 'hidden';
$phone_visibility = ! empty( $attributes['phone_visibility'] ) ? esc_attr($attributes['phone_visibility']) : 'visible';
$phone_label = ! empty( $attributes['phone_label'] ) ? stripslashes(esc_attr($attributes['phone_label'])) : esc_attr__( 'Phone', 'simpleform' );
$phone_placeholder = ! empty( $attributes['phone_placeholder'] ) ? stripslashes(esc_attr($attributes['phone_placeholder'])) : '';
$phone_requirement = ! empty( $attributes['phone_requirement'] ) ? esc_attr($attributes['phone_requirement']) : 'optional';
$subject_field = ! empty( $attributes['subject_field'] ) ? esc_attr($attributes['subject_field']) : $widget_subject_field;
$subject_visibility = ! empty( $attributes['subject_visibility'] ) ? esc_attr($attributes['subject_visibility']) : 'visible';
$subject_label = ! empty( $attributes['subject_label'] ) ? stripslashes(esc_attr($attributes['subject_label'])) : esc_attr__( 'Subject', 'simpleform' );
$subject_placeholder = ! empty( $attributes['subject_placeholder'] ) ? stripslashes(esc_attr($attributes['subject_placeholder'])) : '';
$subject_minlength = isset( $attributes['subject_minlength'] ) ? esc_attr($attributes['subject_minlength']) : '5';
$subject_maxlength = isset( $attributes['subject_maxlength'] ) ? esc_attr($attributes['subject_maxlength']) : '0';
$subject_requirement = ! empty( $attributes['subject_requirement'] ) ? esc_attr($attributes['subject_requirement']) : 'required';
$message_visibility = ! empty( $attributes['message_visibility'] ) ? esc_attr($attributes['message_visibility']) : 'visible';
$message_label = ! empty( $attributes['message_label'] ) ? stripslashes(esc_attr($attributes['message_label'])) : esc_attr__( 'Message', 'simpleform' );
$message_placeholder = ! empty( $attributes['message_placeholder'] ) ? stripslashes(esc_attr($attributes['message_placeholder'])) : '';
$message_minlength = isset( $attributes['message_minlength'] ) ? esc_attr($attributes['message_minlength']) : '10';
$message_maxlength = isset( $attributes['message_maxlength'] ) ? esc_attr($attributes['message_maxlength']) : '0';
$consent_field = ! empty( $attributes['consent_field'] ) ? esc_attr($attributes['consent_field']) : $widget_consent_field;
$consent_label = ! empty( $attributes['consent_label'] ) ? stripslashes(esc_attr($attributes['consent_label'])) : esc_attr__( 'I have read and consent to the privacy policy', 'simpleform' ); 
$privacy_link = ! empty( $attributes['privacy_link'] ) ? esc_attr($attributes['privacy_link']) : 'false';
$privacy_page = ! empty( $attributes['privacy_page'] ) ? esc_attr($attributes['privacy_page']) : '0';
$edit_page = '<a href="' . get_edit_post_link($privacy_page) . '" target="_blank" style="text-decoration: none; color: #9ccc79;">' . __( 'Publish now','simpleform') . '</a>';	
$privacy_url = $privacy_page != '0' ? get_page_link($privacy_page) : '';
/* translators: It is used in place of placeholder %1$s in the string: "%1$s or %2$s the page content" */
$edit = __( 'Edit','simpleform');
/* translators: It is used in place of placeholder %2$s in the string: "%1$s or %2$s the page content" */
$view = __( 'view','simpleform');
$post_url = $privacy_page != '0' ? sprintf( __('%1$s or %2$s the page content', 'simpleform'), '<strong><a href="' . get_edit_post_link($privacy_page) .'" target="_blank" style="text-decoration: none;">'. $edit .'</a></strong>', '<strong><a href="' . get_page_link($privacy_page) . '" target="_blank" style="text-decoration: none;">'. $view .'</a></strong>' ) : '&nbsp;'; 
$privacy_status = $privacy_page != '0' && get_post_status($privacy_page) == 'draft' ? __( 'Page in draft status not yet published','simpleform').'&nbsp;-&nbsp;'.$edit_page : $post_url;
$consent_requirement = ! empty( $attributes['consent_requirement'] ) ? esc_attr($attributes['consent_requirement']) : 'required'; 
$captcha_field = ! empty( $attributes['captcha_field'] ) ? esc_attr($attributes['captcha_field']) : 'hidden';            
$math_captcha_label = ! empty( $attributes['captcha_label'] ) ? stripslashes(esc_attr($attributes['captcha_label'])) : esc_attr__( 'I\'m not a robot', 'simpleform' ); 
$submit_label = ! empty( $attributes['submit_label'] ) ? stripslashes(esc_attr($attributes['submit_label'])) : esc_attr__( 'Submit', 'simpleform' );
$label_position = ! empty( $attributes['label_position'] ) ? esc_attr($attributes['label_position']) : 'top';
$required_sign = ! empty( $attributes['required_sign'] ) ? esc_attr($attributes['required_sign']) : 'true';
$required_word = ! empty( $attributes['required_word'] ) ? esc_attr($attributes['required_word']) : esc_attr__( '(required)', 'simpleform' );
$word_position = ! empty( $attributes['word_position'] ) ? esc_attr($attributes['word_position']) : 'required';
$lastname_alignment = ! empty( $attributes['lastname_alignment'] ) ? esc_attr($attributes['lastname_alignment']) : 'name';
$phone_alignment = ! empty( $attributes['phone_alignment'] ) ? esc_attr($attributes['phone_alignment']) : 'email';
$submit_position = ! empty( $attributes['submit_position'] ) ? esc_attr($attributes['submit_position']) : 'centred';
$form_direction = ! empty( $attributes['form_direction'] ) ? esc_attr($attributes['form_direction']) : 'ltr'
?>

<tr><th class="heading" colspan="2"><span id="misc"><?php esc_html_e( 'Form Description','simpleform') ?></span></th></tr>
 
<tr><th class="first option"><span><?php esc_html_e( 'Text above Form', 'simpleform' ) ?></span></th><td class="first textarea"><textarea class="sform description" name="introduction-text" id="introduction-text" placeholder="<?php esc_html_e( 'Enter the text that must be displayed above the form. It can be used to provide a description or instructions for filling in the form.', 'simpleform' ) ?>" ><?php echo $introduction_text ?></textarea><p class="description"><?php esc_html_e( 'The HTML tags for formatting message are allowed', 'simpleform' ) ?></p></td></tr>

<tr><th class="last textarea option"><span><?php esc_html_e( 'Text below Form', 'simpleform' ) ?></span></th><td class="last textarea"><textarea class="sform description" name="bottom-text" id="bottom-text" placeholder="<?php esc_html_e( 'Enter the text that must be displayed below the form. It can be used to provide additional information.', 'simpleform' ) ?>" ><?php echo $bottom_text ?></textarea><p class="description"><?php esc_html_e( 'The HTML tags for formatting message are allowed', 'simpleform' ) ?></p></td></tr>

<tr><th class="heading" colspan="2"><span><?php esc_html_e('Form Fields','simpleform') ?></span></th></tr>

<?php if ( $widget_for == 'all' ) { ?>
<tr><th class="first option"><span><?php esc_html_e('Name Field','simpleform') ?></span></th><td class="first select"><select name="name-field" id="name-field" class="sform"><option value="visible" <?php selected( $name_field, 'visible'); ?>><?php esc_html_e('Display to all users','simpleform') ?></option><option value="registered" <?php selected( $name_field, 'registered'); ?>><?php esc_html_e('Display only to registered users','simpleform') ?></option><option value="anonymous" <?php selected( $name_field, 'anonymous'); ?>><?php esc_html_e('Display only to anonymous users','simpleform') ?></option><option value="hidden" <?php selected( $name_field, 'hidden'); ?>><?php esc_html_e('Do not display','simpleform') ?></option></select></td></tr>
<?php } else { ?>
<tr><th class="first option"><span><?php esc_html_e('Name Field','simpleform') ?></span></th><td class="first checkbox notes"><label for="name-field"><input type="checkbox" class="sform widgetfield" name="name-field" id="name-field" field="name" value="<?php echo $name_field ?>" <?php checked( $name_field, 'hidden'); ?>><?php esc_html_e('Do not display','simpleform') ?></label><p class="description"><?php printf( __('You have set the widget as visible only for %s', 'simpleform' ), $target ) ?></p></td></tr>
<?php } ?>

<tr class="trname <?php if ( $name_field =='hidden') {echo 'unseen';} ?>" ><th class="option"><span><?php esc_html_e('Name Field Label Visibility','simpleform') ?></span></th><td class="checkbox"><label for="namelabel"><input name="name-visibility" type="checkbox" class="sform field-label" id="namelabel" value="<?php echo $name_visibility ?>" <?php checked( $name_visibility, 'hidden'); ?>><?php esc_html_e('Hide label for name field','simpleform') ?></label></td></tr>

<tr class="trname namelabel <?php if ( $name_field =='hidden' || $name_visibility =='hidden' ) {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e('Name Field Label','simpleform') ?></span></th><td class="text"><input class="sform" name="name-label" placeholder="<?php esc_html_e('Enter a label for the name field','simpleform') ?>" id="name-label" type="text" value='<?php echo $name_label; ?>'</td></tr>		
		
<tr class="trname <?php if ( $name_field =='hidden' ) {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e('Name Field Placeholder','simpleform') ?></span></th><td class="text"><input class="sform" name="name-placeholder" placeholder="<?php esc_html_e('Enter a placeholder for the name field. If blank, it will not be used!','simpleform') ?>" id="name-placeholder" type="text" value='<?php echo $name_placeholder; ?>'</td></tr>
	
<tr class="trname <?php if ( $name_field =='hidden' ) {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e( 'Name\'s Minimum Length', 'simpleform' ) ?></span></th><td class="text"><input name="name-minlength" id="name-minlength" type="number" class="sform" min="0" max="80" value="<?php echo $name_minlength;?>"><span class="description left"><?php esc_html_e('Notice that 0 means no minimum limit','simpleform') ?></span></td></tr>

<tr class="trname <?php if ( $name_field =='hidden' ) {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e( 'Name\'s Maximum Length', 'simpleform' ) ?></span></th><td class="text"><input name="name-maxlength" id="name-maxlength" type="number" class="sform" min="0" max="80" value="<?php echo $name_maxlength;?>"><span class="description left"><?php esc_html_e('Notice that 0 means no maximum limit','simpleform') ?></span></td></tr>

<tr class="trname <?php if ( $name_field =='hidden') {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e('Name Field Requirement','simpleform') ?></span></th><td class="checkbox"><label for="name-requirement"><input name="name-requirement" type="checkbox" class="sform" id="name-requirement" value="required" <?php checked( $name_requirement, 'required'); ?>><?php esc_html_e('Make this a required field','simpleform') ?></label></td></tr>

<?php if ( $widget_for == 'all' ) { ?>
<tr><th class="option"><span><?php esc_html_e('Last Name Field','simpleform') ?></span></th><td class="select"><select name="lastname-field" id="lastname-field" class="sform"><option value="visible" <?php selected( $lastname_field, 'visible'); ?>><?php esc_html_e('Display to all users','simpleform') ?></option><option value="registered" <?php selected( $lastname_field, 'registered'); ?>><?php esc_html_e('Display only to registered users','simpleform') ?></option><option value="anonymous" <?php selected( $lastname_field, 'anonymous'); ?>><?php esc_html_e('Display only to anonymous users','simpleform') ?></option><option value="hidden" <?php selected( $lastname_field, 'hidden'); ?>><?php esc_html_e('Do not display','simpleform') ?></option></select></td></tr>
<?php } else { ?>
<tr><th class="option"><span><?php esc_html_e('Last Name Field','simpleform') ?></span></th><td class="checkbox notes"><label for="lastname-field"><input type="checkbox" class="sform widgetfield" name="lastname-field" id="lastname-field" field="lastname" value="hidden" <?php checked( $lastname_field, 'hidden'); ?> ><?php esc_html_e('Do not display','simpleform') ?></label><p class="description"><?php printf( __('You have set the widget as visible only for %s', 'simpleform' ), $target ) ?></p></td></tr>
<?php } ?>

<tr class="trlastname <?php if ( $lastname_field =='hidden') {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e('Last Name Field Label Visibility','simpleform') ?></span></th><td class="checkbox"><label for="lastnamelabel"><input name="lastname-visibility" type="checkbox" class="sform field-label" id="lastnamelabel" value="visible" <?php checked( $lastname_visibility, 'hidden'); ?>><?php esc_html_e('Hide label for last name field','simpleform') ?></label></td></tr>

<tr class="trlastname lastnamelabel <?php if ( $lastname_field =='hidden' || $lastname_visibility =='hidden' ) {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e('Last Name Field Label','simpleform') ?></span></th><td class="text"><input class="sform" name="lastname-label" placeholder="<?php esc_html_e('Enter a label for the last name field','simpleform') ?>" id="lastname-label" type="text" value='<?php echo $lastname_label; ?>'</td></tr>		

<tr class="trlastname <?php if ( $lastname_field =='hidden' ) {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e('Last Name Field Placeholder','simpleform') ?></span></th><td class="text"><input class="sform" name="lastname-placeholder" placeholder="<?php esc_html_e('Enter a placeholder for the last name field. If blank, it will not be used!','simpleform') ?>" id="lastname-placeholder" type="text" value='<?php echo $lastname_placeholder; ?>'</td></tr>		
<tr class="trlastname <?php if ( $lastname_field =='hidden' ) {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e( 'Last Name\'s Minimum Length', 'simpleform' ) ?></span></th><td class="text"><input name="lastname-minlength" id="lastname-minlength" type="number" class="sform" min="0" max="80" value="<?php echo $lastname_minlength;?>"><span class="description left"><?php esc_html_e('Notice that 0 means no minimum limit','simpleform') ?></span></td></tr>

<tr class="trlastname <?php if ( $lastname_field =='hidden' ) {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e( 'Last Name\'s Maximum Length', 'simpleform' ) ?></span></th><td class="text"><input name="lastname-maxlength" id="lastname-maxlength" type="number" class="sform" min="0" max="80" value="<?php echo $lastname_maxlength;?>"><span class="description left"><?php esc_html_e('Notice that 0 means no maximum limit','simpleform') ?></span></td></tr>

<tr class="trlastname <?php if ( $lastname_field =='hidden') {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e('Last Name Field Requirement','simpleform') ?></span></th><td class="checkbox"><label for="lastname-requirement"><input name="lastname-requirement" type="checkbox" class="sform" id="lastname-requirement" value="required" <?php checked( $lastname_requirement, 'required'); ?>><?php esc_html_e('Make this a required field','simpleform') ?></label></td></tr>

<?php if ( $widget_for == 'all' ) { ?>
<tr><th class="option"><span><?php esc_html_e('Email Field','simpleform') ?></span></th><td class="select"><select name="email-field" id="email-field" class="sform"><option value="visible" <?php selected( $email_field, 'visible'); ?>><?php esc_html_e('Display to all users','simpleform') ?></option><option value="registered" <?php selected( $email_field, 'registered'); ?>><?php esc_html_e('Display only to registered users','simpleform') ?></option><option value="anonymous" <?php selected( $email_field, 'anonymous'); ?>><?php esc_html_e('Display only to anonymous users','simpleform') ?></option><option value="hidden" <?php selected( $email_field, 'hidden'); ?>><?php esc_html_e('Do not display','simpleform') ?></option></select></td></tr>
<?php } else { ?>
<tr><th class="option"><span><?php esc_html_e('Email Field','simpleform') ?></span></th><td class="checkbox notes"><label for="email-field"><input type="checkbox" class="sform widgetfield" name="email-field" id="email-field" field="email" value="hidden" <?php checked( $email_field, 'hidden'); ?> ><?php esc_html_e('Do not display','simpleform') ?></label><p class="description"><?php printf( __('You have set the widget as visible only for %s', 'simpleform' ), $target ) ?></p></td></tr>
<?php } ?>
		
<tr class="tremail <?php if ( $email_field =='hidden') {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e('Email Field Label Visibility','simpleform') ?></span></th><td class="checkbox"><label for="emaillabel"><input name="email-visibility" type="checkbox" class="sform field-label" id="emaillabel" value="visible" <?php checked( $email_visibility, 'hidden'); ?>><?php esc_html_e('Hide label for email field','simpleform') ?></label></td></tr>

<tr class="tremail emaillabel <?php if ( $email_field =='hidden' || $email_visibility =='hidden' ) { echo 'unseen';}?>" ><th class="option"><span ><?php esc_html_e('Email Field Label','simpleform') ?></span></th><td class="text"><input class="sform" name="email-label" placeholder="<?php esc_html_e('Enter a label for the email field','simpleform') ?>" id="email-label" type="text" value="<?php echo $email_label; ?>"</td></tr>

<tr class="tremail <?php if ( $email_field =='hidden' ) {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e('Email Field Placeholder','simpleform') ?></span></th><td class="text"><input class="sform" name="email-placeholder" placeholder="<?php esc_html_e('Enter a placeholder for the email field. If blank, it will not be used!','simpleform') ?>" id="email-placeholder" type="text" value='<?php echo $email_placeholder; ?>'</td></tr>		
		
<tr class="tremail <?php if ( $email_field =='hidden') { echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Email Field Requirement','simpleform') ?></span></th><td class="checkbox"><label for="email-requirement"><input name="email-requirement" type="checkbox" class="sform" id="email-requirement" value="required" <?php checked( $email_requirement, 'required'); ?>><?php esc_html_e('Make this a required field','simpleform') ?></label></td></tr>

<?php if ( $widget_for == 'all' ) { ?>
<tr><th class="option"><span><?php esc_html_e('Phone Field','simpleform') ?></span></th><td class="select"><select name="phone-field" id="phone-field" class="sform"><option value="visible" <?php selected( $phone_field, 'visible'); ?>><?php esc_html_e('Display to all users','simpleform') ?></option><option value="registered" <?php selected( $phone_field, 'registered'); ?>><?php esc_html_e('Display only to registered users','simpleform') ?></option><option value="anonymous" <?php selected( $phone_field, 'anonymous'); ?>><?php esc_html_e('Display only to anonymous users','simpleform') ?></option><option value="hidden" <?php selected( $phone_field, 'hidden'); ?>><?php esc_html_e('Do not display','simpleform') ?></option></select></td></tr>
<?php } else { ?>
<tr><th class="option"><span><?php esc_html_e('Phone Field','simpleform') ?></span></th><td class="checkbox notes"><label for="phone-field"><input type="checkbox" class="sform widgetfield" name="phone-field" id="phone-field" field="phone" value="hidden" <?php checked( $phone_field, 'hidden'); ?> ><?php esc_html_e('Do not display','simpleform') ?></label><p class="description"><?php printf( __('You have set the widget as visible only for %s', 'simpleform' ), $target ) ?></p></td></tr>
<?php } ?>

<tr class="trphone <?php if ( $phone_field =='hidden') {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e('Phone Field Label Visibility','simpleform') ?></span></th><td class="checkbox"><label for="phonelabel"><input name="phone-visibility" type="checkbox" class="sform field-label" id="phonelabel" value="visible" <?php checked( $phone_visibility, 'hidden'); ?>><?php esc_html_e('Hide label for phone field','simpleform') ?></label></td></tr>

<tr class="trphone phonelabel <?php if ( $phone_field =='hidden' || $phone_visibility =='hidden' ) {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e('Phone Field Label','simpleform') ?></span></th><td class="text"><input class="sform" name="phone-label" placeholder="<?php esc_html_e('Enter a label for the phone field','simpleform') ?>" id="phone-label" type="text" value='<?php echo $phone_label; ?>'</td></tr>		

<tr class="trphone <?php if ( $phone_field =='hidden' ) {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e('Phone Field Placeholder','simpleform') ?></span></th><td class="text"><input class="sform" name="phone-placeholder" placeholder="<?php esc_html_e('Enter a placeholder for the phone field. If blank, it will not be used!','simpleform') ?>" id="phone-placeholder" type="text" value='<?php echo $phone_placeholder; ?>'</td></tr>		

<tr class="trphone <?php if ( $phone_field =='hidden') {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e('Phone Field Requirement','simpleform') ?></span></th><td class="checkbox"><label for="phone-requirement"><input name="phone-requirement" type="checkbox" class="sform" id="phone-requirement" value="required" <?php checked( $phone_requirement, 'required'); ?>><?php esc_html_e('Make this a required field','simpleform') ?></label></td></tr>

<?php if ( $widget_for == 'all' ) { ?>
<tr><th class="option"><span><?php esc_html_e('Subject Field','simpleform') ?></span></th><td class="select"><select name="subject-field" id="subject-field" class="sform"><option value="visible" <?php selected( $subject_field, 'visible'); ?>><?php esc_html_e('Display to all users','simpleform') ?></option><option value="registered" <?php selected( $subject_field, 'registered'); ?>><?php esc_html_e('Display only to registered users','simpleform') ?></option><option value="anonymous" <?php selected( $subject_field, 'anonymous'); ?>><?php esc_html_e('Display only to anonymous users','simpleform') ?></option><option value="hidden" <?php selected( $subject_field, 'hidden'); ?>><?php esc_html_e('Do not display','simpleform') ?></option></select></td></tr>
<?php } else { ?>
<tr><th class="option"><span><?php esc_html_e('Subject Field','simpleform') ?></span></th><td class="checkbox notes"><label for="subject-field"><input type="checkbox" class="sform widgetfield" name="subject-field" id="subject-field" field="subject" value="hidden" <?php checked( $subject_field, 'hidden'); ?> ><?php esc_html_e('Do not display','simpleform') ?></label><p class="description"><?php printf( __('You have set the widget as visible only for %s', 'simpleform' ), $target ) ?></p></td></tr>
<?php } ?>

<tr class="trsubject <?php if ( $subject_field =='hidden') {echo 'unseen';} else {echo 'visible';} ?>" ><th class="option"><span><?php esc_html_e('Subject Field Label Visibility','simpleform') ?></span></th><td class="checkbox"><label for="subjectlabel"><input name="subject-visibility" type="checkbox" class="sform field-label" id="subjectlabel" value="visible" <?php checked( $subject_visibility, 'hidden'); ?>><?php esc_html_e('Hide label for subject field','simpleform') ?></label></td></tr>

<tr class="trsubject subjectlabel <?php if ($subject_field =='hidden' || $subject_visibility =='hidden' ) {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e('Subject Field Label','simpleform') ?></span></th><td class="text"><input class="sform" name="subject-label" placeholder="<?php esc_html_e('Enter a label for the subject field','simpleform') ?>" id="subject-label" type="text" value="<?php echo $subject_label; ?>"></td></tr>

<tr class="trsubject <?php if ( $subject_field =='hidden' ) {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e('Subject Field Placeholder','simpleform') ?></span></th><td class="text"><input class="sform" name="subject-placeholder" placeholder="<?php esc_html_e('Enter a placeholder for the subject field. If blank, it will not be used!','simpleform') ?>" id="subject-placeholder" type="text" value='<?php echo $subject_placeholder; ?>'</td></tr>		

<tr class="trsubject <?php if ( $subject_field =='hidden' ) {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e( 'Subject\'s Minimum Length', 'simpleform' ) ?></span></th><td class="text"><input name="subject-minlength" id="subject-minlength" type="number" class="sform" min="0" max="80" value="<?php echo $subject_minlength;?>"><span class="description left"><?php esc_html_e('Notice that 0 means no minimum limit','simpleform') ?></span></td></tr>

<tr class="trsubject <?php if ( $subject_field =='hidden' ) {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e( 'Subject\'s Maximum Length', 'simpleform' ) ?></span></th><td class="text"><input name="subject-maxlength" id="subject-maxlength" type="number" class="sform" min="0" max="80" value="<?php echo $subject_maxlength;?>"><span class="description left"><?php esc_html_e('Notice that 0 means no maximum limit','simpleform') ?></span></td></tr>

<tr class="trsubject <?php if ($subject_field =='hidden') {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Subject Field Requirement','simpleform') ?></span></th><td class="checkbox"><label for="subject-requirement"><input name="subject-requirement" type="checkbox" class="sform" id="subject-requirement" value="required" <?php checked( $subject_requirement, 'required'); ?>><?php esc_html_e('Make this a required field','simpleform') ?></label></td></tr>

<tr><th class="option"><span><?php esc_html_e('Message Field Label Visibility','simpleform') ?></span></th><td class="checkbox"><label for="messagelabel"><input name="message-visibility" type="checkbox" class="sform field-label" id="messagelabel" value="visible" <?php checked( $message_visibility, 'hidden'); ?>><?php esc_html_e('Hide label for message field','simpleform') ?></label></td></tr>

<tr class="messagelabel <?php if ( $message_visibility =='hidden' ) {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Message Field Label','simpleform') ?></span></th><td class="text"><input class="sform" name="message-label" placeholder="<?php esc_html_e('Enter a label for the message field','simpleform') ?>" id="message-label" type="text" value="<?php echo $message_label; ?>"</td></tr>

<tr><th class="option"><span><?php esc_html_e('Message Field Placeholder','simpleform') ?></span></th><td class="text"><input class="sform" name="message-placeholder" placeholder="<?php esc_html_e('Enter a placeholder for the message field. If blank, it will not be used!','simpleform') ?>" id="message-placeholder" type="text" value='<?php echo $message_placeholder; ?>'</td></tr>

<tr><th class="option"><span><?php esc_html_e( 'Message\'s Minimum Length', 'simpleform' ) ?></span></th><td class="text"><input name="message-minlength" id="message-minlength" type="number" class="sform" min="5" max="80" value="<?php echo $message_minlength;?>"></td></tr>

<tr><th class="option"><span><?php esc_html_e( 'Message\'s Maximum Length', 'simpleform' ) ?></span></th><td class="text"><input name="message-maxlength" id="message-maxlength" type="number" class="sform" min="0" max="80" value="<?php echo $message_maxlength;?>"><span class="description left"><?php esc_html_e('Notice that 0 means no maximum limit','simpleform') ?></span></td></tr>

<?php if ( $widget_for == 'all' ) { ?>
<tr><th class="option"><span><?php esc_html_e('Consent Field','simpleform') ?></span></th><td class="select"><select name="consent-field" id="consent-field" class="sform"><option value="visible" <?php selected( $consent_field, 'visible'); ?>><?php esc_html_e('Display to all users','simpleform') ?></option><option value="registered" <?php selected( $consent_field, 'registered'); ?>><?php esc_html_e('Display only to registered users','simpleform') ?></option><option value="anonymous" <?php selected( $consent_field, 'anonymous'); ?>><?php esc_html_e('Display only to anonymous users','simpleform') ?></option><option value="hidden" <?php selected( $consent_field, 'hidden'); ?>><?php esc_html_e('Do not display','simpleform') ?></option></select></td></tr>
<?php } else { ?>
<tr><th class="option"><span><?php esc_html_e('Consent Field','simpleform') ?></span></th><td class="checkbox notes"><label for="consent-field"><input type="checkbox" class="sform widgetfield" name="consent-field" id="consent-field" field="consent" value="hidden" <?php checked( $consent_field, 'hidden'); ?> ><?php esc_html_e('Do not display','simpleform') ?></label><p class="description"><?php printf( __('You have set the widget as visible only for %s', 'simpleform' ), $target ) ?></p></td></tr>
<?php } ?>

<tr class="trconsent <?php if ($consent_field =='hidden') {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Consent Field Label','simpleform') ?></span></th><td class="textarea"><textarea class="sform labels" name="consent-label" id="consent-label" placeholder="<?php esc_html_e( 'Enter a label for the consent field', 'simpleform' ) ?>" ><?php echo $consent_label ?></textarea><p class="description"><?php esc_html_e( 'The HTML tags for formatting consent field label are allowed', 'simpleform' ) ?></p></td></tr>

<?php $pages = get_pages( array( 'sort_column' => 'post_title', 'sort_order' => 'ASC', 'post_type' => 'page', 'post_status' =>  array('publish','draft') ) ); if ( $pages ) { ?>
<tr class="trconsent <?php if ($consent_field =='hidden') {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Link to Privacy Policy','simpleform') ?></span></th><td class="checkbox"><label for="privacy-link"><input name="privacy-link" type="checkbox" class="sform" id="privacy-link" value="false" <?php checked( $privacy_link, 'true'); ?>><?php esc_html_e('Insert a link to the Privacy Policy page in the consent field label','simpleform') ?></label></td></tr>

<tr class="trconsent trpage <?php if ($consent_field =='hidden' || $privacy_link == 'false') {echo 'unseen';}?>" ><th class="option"><span><?php esc_html_e( 'Privacy Policy Page', 'simpleform' ) ?></span></th><td class="select notes"><select name="privacy-page" class="sform" id="privacy-page"><option value=""><?php esc_html_e( 'Select the page', 'simpleform' ) ?></option><?php foreach ($pages as $page) { ?><option value="<?php echo $page->ID; ?>" tag="<?php echo $page->post_status; ?>" <?php selected( $privacy_page, $page->ID ); ?>><?php echo $page->post_title; ?></option><?php } ?></select><input type="hidden" id="page-id" name="page-id" value=""><input type="submit" name="submit" id="set-page" class="sf button button-primary unseen" value="Use This Page" page="<?php echo $privacy_page ?>"><span id="label-error"></span><p id="post-status" class="description"><?php echo $privacy_status ?></p></td></tr>
<?php }	?>	

<tr class="trconsent <?php if ($consent_field =='hidden') {echo 'unseen';}?>"><th class="option"><span><?php esc_html_e('Consent Field Requirement','simpleform') ?></span></th><td class="checkbox notes"><label for="consent-requirement"><input name="consent-requirement" type="checkbox" class="sform" id="consent-requirement" value="required" <?php checked( $consent_requirement, 'required'); ?>><?php esc_html_e('Make this a required field','simpleform') ?></label><p class="description"><?php esc_html_e('If you\'re collecting personal data, this field is required for requesting the user\'s explicit consent','simpleform') ?></p></td></tr>

<?php if ( $widget_for == 'all' ) { ?>
<tr><th class="option"><span><?php esc_html_e('Captcha Field','simpleform') ?></span></th><td class="select"><select name="captcha-field" id="captcha-field" class="sform"><option value="visible" <?php selected( $captcha_field, 'visible'); ?>><?php esc_html_e('Display to all users','simpleform') ?></option><option value="registered" <?php selected( $captcha_field, 'registered'); ?>><?php esc_html_e('Display only to registered users','simpleform') ?></option><option value="anonymous" <?php selected( $captcha_field, 'anonymous'); ?>><?php esc_html_e('Display only to anonymous users','simpleform') ?></option><option value="hidden" <?php selected( $captcha_field, 'hidden'); ?>><?php esc_html_e('Do not display','simpleform') ?></option></select></td></tr>
<?php } else { ?>
<tr><th class="option"><span><?php esc_html_e('Captcha Field','simpleform') ?></span></th><td class="checkbox notes"><label for="captcha-field"><input type="checkbox" class="sform widgetfield" name="captcha-field" id="captcha-field" field="captcha" value="hidden" <?php checked( $captcha_field, 'hidden'); ?> ><?php esc_html_e('Do not display','simpleform') ?></label><p class="description"><?php printf( __('You have set the widget as visible only for %s', 'simpleform' ), $target ) ?></p></td></tr>
<?php } ?>

<tr class="trcaptcha trcaptchalabel <?php if ( $captcha_field =='hidden' ) {echo 'unseen';} ?>"><th class="option"><span><?php esc_html_e('Captcha Field Label','simpleform') ?></span></th><td class="text"><input type="text" class="sform" id="captcha-label" name="captcha-label" placeholder="<?php esc_html_e('Enter a label for the captcha field','simpleform') ?>" value="<?php echo $math_captcha_label ?>"></td></tr>

<tr><th class="last option"><span><?php esc_html_e('Submit Button Label','simpleform') ?></span></th><td class="last text"><input type="text" id="submit-label" class="sform" name="submit-label" placeholder="<?php esc_html_e('Enter a label for the submit field','simpleform') ?>" value="<?php echo $submit_label ?>"</td></tr>

</tbody></table>
</div>

<div id="tab-appearance" class="navtab unseen">
<table class="form-table"><tbody>	

<tr class="outside"><th class="option"><span style="cursor: default"><?php esc_html_e( 'Label Position', 'simpleform' ) ?></span></th><td class="radio"><fieldset><label for="top-position"><input id="top-position" type="radio" name="label-position" value="top" <?php checked( $label_position, 'top'); ?> ><?php esc_html_e( 'Top', 'simpleform' ) ?></label><label for="inline-position"><input id="inline-position" type="radio" name="label-position" value="inline" <?php checked( $label_position, 'inline'); ?> ><?php esc_html_e( 'Inline', 'simpleform' ) ?></label></fieldset></td></tr>

<tr><th id="thsign" class="option"><span><?php esc_html_e('Required Field Symbol', 'simpleform' ) ?></span></th><td id="tdsign" class="checkbox"><label for="required-sign"><input type="checkbox" class="sform" id="required-sign" name="required-sign" value="true" <?php checked( $required_sign, 'true'); ?> ><?php esc_html_e( 'Use an asterisk at the end of the label to mark a required field', 'simpleform' ); ?></label></td></tr>

<tr class="trsign <?php if ($required_sign =='true') { echo 'unseen'; } ?>"><th class="option"><span><?php esc_html_e( 'Replacement Word', 'simpleform' ) ?></span></th><td class="text notes"><input class="sform" name="required-word" placeholder="<?php esc_html_e( 'Enter a word to mark a required field or an optional field', 'simpleform' ) ?>" id="required-word" type="text" value="<?php echo $required_word; ?>" \><p class="description"><?php esc_html_e( 'The replacement word will be placed at the end of the field label, except for the consent and captcha fields. If you hide the label, remember to place it into the placeholder!', 'simpleform' ) ?></p></td></tr>

<tr class="trsign <?php if ($required_sign =='true') { echo 'unseen'; } ?>" ><th class="option" ><span><?php esc_html_e( 'Required/Optional Field Labelling', 'simpleform' ) ?></span></th><td class="radio"><fieldset><label for="required-labelling"><input id="required-labelling" type="radio" name="word-position" value="required" <?php checked( $word_position, 'required'); ?> ><?php esc_html_e( 'Use the replacement word to mark a required field','simpleform') ?></label><label for="optional-labelling"><input id="optional-labelling" type="radio" name="word-position" value="optional" <?php checked( $word_position, 'optional'); ?> ><?php esc_html_e( 'Use the replacement word to mark an optional field','simpleform') ?></label></fieldset></td></tr>

<tr class="trname trlastname <?php if ( $name_field =='hidden' || $lastname_field =='hidden') {echo 'unseen';}?>" ><th class="option" ><span><?php esc_html_e( 'Last Name Field Layout', 'simpleform' ) ?></span></th><td class="radio"><fieldset><label for="single-line-lastname"><input id="single-line-lastname" type="radio" name="lastname-alignment" value="alone" <?php checked( $lastname_alignment, 'alone'); ?> ><?php esc_html_e( 'Place on a single line','simpleform') ?></label><label for="name-line" ><input id="name-line" type="radio" name="lastname-alignment" value="name" <?php checked( $lastname_alignment, 'name'); ?> ><?php esc_html_e( 'Place next to name field on the same line','simpleform') ?></label></fieldset></td></tr>

<tr class="tremail trphone <?php if ( $email_field =='hidden' || $phone_field =='hidden') {echo 'unseen';}?>" ><th class="option" ><span><?php esc_html_e( 'Phone Field Layout', 'simpleform' ) ?></span></th><td class="radio"><fieldset><label for="single-line-phone"><input id="single-line-phone" type="radio" name="phone-alignment" value="alone" <?php checked( $phone_alignment, 'alone'); ?> ><?php esc_html_e( 'Place on a single line','simpleform') ?></label><label for="email-line" ><input id="email-line" type="radio" name="phone-alignment" value="email" <?php checked( $phone_alignment, 'email'); ?> ><?php esc_html_e( 'Place next to email field on the same line','simpleform') ?></label></fieldset></td></tr>

<tr><th class="option"><span><?php esc_html_e('Submit Button Position','simpleform') ?></span></th><td class="select"><select name="submit-position" id="submit-position" class="sform"><option value="left" <?php selected( $submit_position, 'left'); ?>><?php esc_html_e('Left','simpleform') ?></option><option value="right" <?php selected( $submit_position, 'right'); ?>><?php esc_html_e('Right','simpleform') ?></option><option value="centred" <?php selected( $submit_position, 'centred'); ?>><?php esc_html_e('Centred','simpleform') ?></option><option value="full" <?php selected( $submit_position, 'full'); ?>><?php esc_html_e('Full Width','simpleform') ?></option></select></td></tr>

<tr><th class="option"><span style="cursor: default"><?php esc_html_e( 'Form Direction', 'simpleform' ) ?></span></th><td class="radio last"><fieldset><label for="ltr-direction"><input id="ltr-direction" type="radio" name="form-direction" value="ltr" <?php checked( $form_direction, 'ltr'); ?> ><?php esc_html_e( 'Left to Right', 'simpleform' ) ?></label><label for="rtl-direction"><input id="rtl-direction" type="radio" name="form-direction" value="rtl" <?php checked( $form_direction, 'rtl'); ?> ><?php esc_html_e( 'Right to Left', 'simpleform' ) ?></label></fieldset></td></tr>

</tbody></table>
</div>	

<div id="submit-wrap"><div id="alert-wrap">
<noscript><div id="noscript"><?php esc_html_e('You need JavaScript enabled to edit form. Please activate it. Thanks!', 'simpleform' ) ?></div></noscript>
<div id="message-wrap" class="message"></div>
</div>

<input type="submit" class="submit-button" id="save-attributes" name="save-attributes"  value="<?php esc_html_e( 'Save Changes', 'simpleform' ) ?>">	
<?php  wp_nonce_field( 'ajax-verification-nonce', 'verification_nonce'); ?>
</form>

</div>
</div>

<?php
} else { ?>
<span><?php esc_html_e('There seems to be no widget available!', 'simpleform' ) ?></span><p><span class="sf button button-primary"><a href="<?php echo menu_page_url( 'sform-editing', false ); ?>" style="text-decoration: none; color: #FFF; "><?php esc_html_e('Reload the Form Editor page','simpleform') ?></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="sf button button-primary"><a href="<?php echo self_admin_url('widgets.php'); ?>" style="text-decoration: none; color: #FFF; "><?php esc_html_e('Activate SimpleForm Contact Form Widget','simpleform') ?></a></span></p>
<?php }