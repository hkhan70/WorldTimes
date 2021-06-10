<?php

/**
 * The class instantiated during the plugin's deactivation.
 *
 * @since      1.0
 */

class SimpleForm_Submissions_Deactivator {

	/**
	 * Run during plugin deactivation.
	 *
	 * @since    1.4
	 */
	 
	public static function deactivate() {

	  // Resume the admin notification
	  $settings = get_option('sform_settings');
	  $settings['notification'] = 'true';
      update_option('sform_settings', $settings); 
      
      // Check if SimpleForm widget has been activated
      if ( is_active_widget( false, false, 'sform_widget', true ) ) {
        $sform_widget = get_option('widget_sform_widget');
        // Filters elements of an array using the 'is_int' function
        $sform_widget_array = array_filter(array_keys($sform_widget), 'is_int');
        if ( ! empty($sform_widget_array) ) {
	      foreach ($sform_widget_array as $key=>$id) { 
		     if ( $sform_widget[$id]['sform_widget_settings'] == 'true' ) { 
	              $widget_settings = get_option('sform_widget_'. $id .'_settings');
			      $widget_settings['notification'] = 'true';
                  update_option('sform_widget_'. $id .'_settings', $widget_settings); 
             } 
          } 
        }
      }      
      
	}

}