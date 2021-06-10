<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * @since      1.0
 */

// Prevent direct access. Exit if file is not called by WordPress.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

if ( !is_multisite() )  {
  $settings = get_option('sform_settings');
  if ( isset( $settings['deletion_data'] ) && esc_attr($settings['deletion_data']) == 'true' ) {
  global $wpdb;
  $prefix = $wpdb->prefix;
  $submissions_table = $prefix . 'sform_submissions';
  $wpdb->query("ALTER TABLE $submissions_table DROP COLUMN name, DROP COLUMN lastname, DROP COLUMN email, DROP COLUMN phone, DROP COLUMN subject, DROP COLUMN object, DROP COLUMN ip, DROP COLUMN status, DROP COLUMN trash_date");
  }
  $sform_addon_settings = array( 'data_storing' => $settings['data_storing'], 'ip_storing' => $settings['ip_storing'], 'data_columns' => $settings['data_columns'], 'counter' => $settings['counter'] );
  $sform_core_settings = array_diff_key($settings,$sform_addon_settings);
  update_option('sform_settings', $sform_core_settings);  
  delete_option( 'sform_sub_db_version' );
  delete_option( 'sform_screen_options' );
  delete_transient( 'sform_action_notice' );
} 
else {
    global $wpdb;
    $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
    $original_blog_id = get_current_blog_id();
    foreach ( $blog_ids as $blog_id ) {
        switch_to_blog( $blog_id );
        $settings = get_option('sform_settings'); // Before: get_site_option
        if ( isset( $settings['deletion_data'] ) && esc_attr($settings['deletion_data']) == 'true' ) {
        $prefix = $wpdb->prefix;
        $submissions_table = $prefix . 'sform_submissions';
        $wpdb->query("ALTER TABLE $submissions_table DROP COLUMN name, DROP COLUMN lastname, DROP COLUMN email, DROP COLUMN phone, DROP COLUMN subject, DROP COLUMN object, DROP COLUMN ip, DROP COLUMN status, DROP COLUMN trash_date");   
        }
        $sform_addon_settings = array( 'data_storing' => $settings['data_storing'], 'ip_storing' => $settings['ip_storing'], 'data_columns' => $settings['data_columns'], 'counter' => $settings['counter'] );
        $sform_core_settings = array_diff_key($settings,$sform_addon_settings);
        update_option('sform_settings', $sform_core_settings);
        delete_option( 'sform_sub_db_version' );
        delete_option( 'sform_screen_options' );
        delete_transient( 'sform_action_notice' );
   }
    switch_to_blog( $original_blog_id );
}