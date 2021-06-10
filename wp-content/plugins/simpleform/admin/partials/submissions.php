<?php

if ( ! defined( 'WPINC' ) ) die;

$form_id = isset( $_REQUEST['form'] ) ? absint($_REQUEST['form']) : '';
if ( $form_id == '' ) {
$where_form = " WHERE form != '0'";
$last_message = stripslashes(get_transient('sform_last_message'));
} else {
$where_form = " WHERE form = '". $form_id ."'";
$last_message = stripslashes(get_transient('sform_last_'.$form_id.'_message'));
}
$notice = '';
?>

<span id="new-release-message" style=""><?php echo apply_filters( 'sform_update', $notice ) ?></span>
<div class="sform wrap">
	
	


<h1 class="backend"><span class="dashicons dashicons-email-alt"></span><?php esc_html_e( 'Submissions', 'simpleform' ); global $wpdb; $table_name = "{$wpdb->prefix}sform_shortcodes"; $shortcode_data = $wpdb->get_var( "SELECT name FROM $table_name WHERE shortcode = 'simpleform'" ); $contact_form_name = $shortcode_data ? stripslashes(esc_attr($shortcode_data)) : esc_attr__( 'Contact Us Page','simpleform'); $widget = is_active_widget( false, false, 'sform_widget', true ) ? 'true' : 'false'; if ( $widget == 'true' ) { ?><div style="float: right;"><span style="font-size: 13px; padding-right: 10px;"><?php echo esc_html_e( 'Switch Form', 'simpleform' ) . ':' ; ?></span><span class="form-selector" style="float: right; padding: 0; top: 0;"><?php $id = isset( $_REQUEST['form'] ) ? absint($_REQUEST['form']) : ''; $sform_widget = get_option('widget_sform_widget'); $widget_ids = array_keys($sform_widget); $sidebars_widgets = get_option('sidebars_widgets'); global $wp_registered_sidebars;?> <select name="form" class="" id="form" style="line-height: 34px; padding: 0 30px 0 20px; vertical-align: top;"><option value="" <?php selected( $form_id, '' ); ?>><?php echo esc_html_e( 'All Forms', 'simpleform' ); ?></option>


<option value="1" <?php selected( $form_id, '1' ); ?>><?php echo $contact_form_name; ?></option><?php foreach($widget_ids as $k) { if ( $k == is_int($k) ) { $shortcode_name = 'simpleform widget="'.$k.'"'; $shortcode_values = apply_filters( 'sform_form', $shortcode_name ); $default_name = __( 'Contact Form','simpleform'); if ( ! empty($shortcode_values['name']) && $shortcode_values['name'] != $default_name ) { $form_name = stripslashes(esc_attr($shortcode_values['name'])); } else { $form_name = __( 'Contact Form','simpleform') . ' (' . stripslashes(esc_attr($shortcode_values['area'])) .')'; } ?><option value="<?php echo $k; ?>" <?php selected( $form_id, $k ); ?>><?php echo $form_name; ?></option><?php } } ?></select></span></div><?php } ?></h1>









   
<?php

if ( has_action( 'submissions_list' ) ):
  do_action( 'submissions_list', $form_id );
else:
  $sform_widget = get_option('widget_sform_widget'); 
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
    $plugin_file = 'simpleform-contact-form-submissions/simpleform-submissions.php';
    $admin_url = is_network_admin() ? network_admin_url( 'plugins.php' ) : admin_url( 'plugins.php' );
	if ( $last_message /* get_transient( 'sform_last_message' ) */ ) {
	echo '<div id="last-submission"><h3><span class="dashicons '.$icon.'"></span>'.esc_html__('Last Message Received', 'simpleform' ).'</h3>'.$last_message . '</div>';
    if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_file ) ) {		
	echo '<div id="submissions-notice" class="unseen"><h3><span class="dashicons dashicons-editor-help"></span>'.esc_html__('Before you go crazy looking for the received messages', 'simpleform' ).'</h3>'. __( 'Submissions data is not stored in the WordPress database. We have designed SimpleForm to be a minimal, lightweight, fast and privacy-respectful plugin, so that it does not interfere with your site performance and can be easily managed. If you want to keep a copy of your messages, you can add this feature with the <b>SimpleForm Contact Form Submissions</b> addon. You can find it in the WordPress.org plugin repository. By default, only the last message is temporarily stored. Therefore, it is recommended to verify the correct SMTP server configuration in case of use, and always keep the notification email enabled, if you want to be sure to receive messages.', 'simpleform' ) .'</div>'; 	
	}
	else {
    if ( ! class_exists( 'SimpleForm_Submissions' ) ) {	
	echo '<div id="submissions-notice" class="unseen"><h3><span class="dashicons dashicons-editor-help"></span>'.esc_html__('Before you go crazy looking for the received messages', 'simpleform' ).'</h3>'. __('Submissions data is not stored in the WordPress database by default. We have designed SimpleForm to be a minimal, lightweight, fast and privacy-respectful plugin, so that it does not interfere with your site performance and can be easily managed. You can enable this feature by activating the <b>SimpleForm Contact Form Submissions</b> addon. Go to the Plugins page.', 'simpleform' ) .'</div>';	
	}
	}
	}
	else  {
    if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_file ) ) {		
	echo '<div id="empty-submission"><h3><span class="dashicons dashicons-info"></span>'.esc_html__('Empty Inbox', 'simpleform' ).'</h3>'.
esc_html__('So far, no message has been received yet!', 'simpleform' ).'<p>'.sprintf( __('Please note that submissions data is not stored in the WordPress database by default. We have designed SimpleForm to be a minimal, lightweight, fast and privacy-respectful plugin, so that it does not interfere with your site performance and can be easily managed. If you want to keep a copy of your messages, you can add this feature with the <a href="%s" target="_blank">SimpleForm Contact Form Submissions</a> addon. You can find it in the WordPress.org plugin repository.', 'simpleform' ), esc_url( 'https://wordpress.org/plugins/simpleform-contact-form-submissions/' ) ).'</div>';
	}
	else {
    if ( ! class_exists( 'SimpleForm_Submissions' ) ) {	
     echo '<div id="empty-submission"><h3><span class="dashicons dashicons-info"></span>'.esc_html__('Empty Inbox', 'simpleform' ).'</h3>'.
esc_html__('So far, no message has been received yet!', 'simpleform' ).'<p>'.sprintf( __('Submissions data is not stored in the WordPress database by default. We have designed SimpleForm to be a minimal, lightweight, fast and privacy-respectful plugin, so that it does not interfere with your site performance and can be easily managed. You can enable this feature with the <b>SimpleForm Contact Form Submissions</b> addon activation. Go to the <a href="%s">Plugins</a> page.', 'simpleform' ), esc_url( $admin_url ) ) . '</div>';
	}
	}
	}
  }
  else {
  ?>
  <span><?php echo esc_html('There seems to be no form available with ID:', 'simpleform' ) . $form_id; ?></span><p><span class="sf button button-primary"><a href="<?php echo menu_page_url( 'sform-submissions', false ); ?>" style="text-decoration: none; color: #FFF; "><?php esc_html_e('Reload the Submissions page','simpleform') ?></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="sf button button-primary"><a href="<?php echo self_admin_url('widgets.php'); ?>" style="text-decoration: none; color: #FFF; "><?php esc_html_e('Activate SimpleForm Contact Form Widget','simpleform') ?></a></span></p>

  <?php	
  }
endif;
?>
</div>