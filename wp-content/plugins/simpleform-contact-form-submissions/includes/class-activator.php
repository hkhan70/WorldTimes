<?php

/**
 * The class instantiated during the plugin activation.
 *
 * @since      1.0
 */

class SimpleForm_Submissions_Activator {

	/**
     * Run default functionality during plugin activation.
     *
     * @since    1.0
     */

    public static function activate($network_wide) {
	    
     if ( function_exists('is_multisite') && is_multisite() ) {
	  if($network_wide) {
        global $wpdb;
        $blog_ids = $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs" );
        foreach ( $blog_ids as $blog_id ) {
         switch_to_blog( $blog_id );
         self::check_main_plugin();
         self::sform_submissions_settings();
         self::change_db();
         restore_current_blog();
        }
      } else {
         self::check_main_plugin();
         self::sform_submissions_settings();
         self::change_db();
      }
     } else {
        self::check_main_plugin();
        self::sform_submissions_settings();
        self::change_db();
     }
    
    }
    
    /**
     * Check if the main plugin SimpleForms is installed (active or inactive) on the site.
     *
     * @since    1.0
     */
 
    public static function check_main_plugin() {
	    
	  if ( ! class_exists( 'SimpleForm' ) ) {
        $plugin_file = 'simpleform/simpleform.php';
        if ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin_file ) ) {
	        $admin_url = is_multisite() ? network_admin_url( 'plugin-install.php' ) : admin_url( 'plugin-install.php' );
			deactivate_plugins( basename( __FILE__ ) );
			wp_die( '<div id="admin-notice">' . sprintf( __( 'Before proceeding to activate this plugin, you need to install and activate <a href="%1s" target="_blank">SimpleForm</a> plugin.<p>Search it in the <a href="%2s">WordPress repository</a>', 'simpleform-contact-form-submissions' ), esc_url( 'https://wordpress.org/plugins/simpleform/' ), add_query_arg( array( 's' => 'SimpleForm', 'tab' => 'search', 'type' => 'term' ), $admin_url ) ) . '</div>' );
	    }
        else {
            $admin_url = is_network_admin() ? network_admin_url( 'plugins.php' ) : admin_url( 'plugins.php' );
			deactivate_plugins( basename( __FILE__ ) );
			wp_die( '<div id="admin-notice">' . sprintf( __( 'Before proceeding to activate this plugin, you need to activate <b>SimpleForm</b> plugin.<p>Back to the <a href="%s">Plugins</a> page', 'simpleform-contact-form-submissions' ), esc_url( $admin_url ) ) . '</div>' );
	    }
	  }
	  else { 
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );		  
		if ( is_network_admin() && ! is_plugin_active_for_network( 'simpleform/simpleform.php' )  )  {   
			deactivate_plugins( basename( __FILE__ ) );
			wp_die( '<div id="admin-notice">' . sprintf( __( 'Before proceeding to activate this plugin, you need to activate <b>SimpleForm</b> plugin.<p>Back to the <a href="%s">Plugins</a> page', 'simpleform-contact-form-submissions' ), esc_url( network_admin_url( 'plugins.php' ) ) ) . '</div>' );
	    }
	  }

    }
	

    /**
     *  Specify the initial settings.
     *
     * @since    1.4
     */

    public static function sform_submissions_settings() {
       
 	   $old_settings = get_option( 'sform_settings' );
       
       if ( $old_settings ) {
          $new_settings = array(
	             'data_storing' => 'true',
	             'ip_storing' => 'true',
                 'counter' => 'true',
                 'data_columns' => 'subject,firstname,message,mail,date'
                 ); 
 
          $settings = array_merge($old_settings,$new_settings);
          update_option('sform_settings', $settings); 
       }       
       
    }

    /**
     * Modifies the database table.
     *
     * @since    1.0
     */
 
    public static function change_db() {

        $current_version = SIMPLEFORM_SUBMISSIONS_DB_VERSION;
        $installed_version = get_option('sform_sub_db_version'); // get_site_option
       
        if ( $installed_version != $current_version ) {
        
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $prefix = $wpdb->prefix;
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	        
          $submissions_table = $prefix . 'sform_submissions';
          $sql = "CREATE TABLE " . $submissions_table . " (
            id int(11) NOT NULL AUTO_INCREMENT,
            form int(7) NOT NULL DEFAULT 1,
            requester_type tinytext NOT NULL,
            requester_id int(15) NOT NULL,
            name tinytext NOT NULL,
            lastname tinytext NOT NULL,
            email VARCHAR(200) NOT NULL,
            ip VARCHAR(128) NOT NULL,	
            phone VARCHAR(50) NOT NULL,
            subject tinytext NOT NULL,
            object text NOT NULL,
            date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            status tinytext NOT NULL,
            trash_date datetime NOT NULL,
            notes text NOT NULL,
            PRIMARY KEY  (id)
          ) ". $charset_collate .";";
          dbDelta($sql);
          update_option('sform_sub_db_version', $current_version);
        }
   
    }
    
    /**
     *  Create a table whenever a new blog is created in a WordPress Multisite installation.
     *
     * @since    1.0
     */

    public static function on_create_blog($params) {
       
       if ( is_plugin_active_for_network( 'simpleform-submissions/simpleform-submissions.php' ) ) {
       switch_to_blog( $params->blog_id );
       self::check_main_plugin();
       self::sform_submissions_settings();
       self::change_db();
       restore_current_blog();
       }

    }    
  
}