<?php
	
 /**
 * Defines the widget of the plugin.
 *
 * @since      1.10
 */

class SimpleForm_Widget extends WP_Widget {

	/**
	 *  Widget constructor
	 */
	 
	public function __construct() {
		
		$widget_options = array ('classname' => __FUNCTION__, 'description' => __( 'Displays a contact form with SimpleForm', 'simpleform' ));
		parent::__construct( 'sform_widget', __( 'SimpleForm Contact Form', 'simpleform' ), $widget_options );
    	add_filter ('pre_update_option_sidebars_widgets',array($this, 'update_sform_shortcodes'), 10, 1);
    	add_action( 'delete_widget', array($this, 'cleanup_sform_shortcodes'), 10, 3 );
		
	}
	
	/**
	 * Output the widget admin form
	 */
	
	public function form( $instance ) {
		
		$title   = ! empty( $instance['sform_widget_title'] ) ? $instance['sform_widget_title'] : '';
        $audience = ! empty( $instance['sform_widget_audience'] ) ? $instance['sform_widget_audience'] : 'all';
        $editor = ! empty( $instance['sform_widget_editor'] ) ? $instance['sform_widget_editor'] : 'false';
        $sform_widget = get_option('widget_sform_widget'); 
        unset($sform_widget['_multiwidget']);
        $noempty_values = wp_list_pluck( $sform_widget, 'sform_widget_audience' );
        $values = array_count_values($noempty_values);        
        
        if ( ! empty($emptyRemoved) ) { 
           if ( ( count($emptyRemoved) > 1 && !empty($values['all']) && $values['all'] > 0 ) || ( !empty($values['out']) && $values['out'] > 1 ) || ( !empty($values['in']) && $values['in'] > 1 ) ) { 
	       $alert = __( 'You may only use one widget per page to make it work properly. Please check the settings before saving!', 'simpleform' );
    	   echo '<script type="text/javascript">var notice = document.getElementsByClassName("widget-alert"); for (var i = 0; i < notice.length; i++) { notice[i].innerHTML = "' .$alert . '"; } </script>';
  	       } else  { 
		   echo '<script type="text/javascript">var notice = document.getElementsByClassName("widget-alert"); for (var i = 0; i < notice.length; i++) { notice[i].innerHTML = ""; } </script>';
           }
        }       
     	?><div class="widget-alert"></div>
						
		<p><label for="<?php echo $this->get_field_id( 'sform_widget_title' ); ?>"><?php _e( 'Title:', 'simpleform' ); ?></label><input class="widefat" id="<?php echo $this->get_field_id( 'sform_widget_title' ); ?>" name="<?php echo $this->get_field_name( 'sform_widget_title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>"></p>
		
        <p><label for="<?php echo $this->get_field_id( 'sform_widget_audience' ); ?>"><?php _e( 'Show for:', 'simpleform' ) ?></label><select class="widefat sform-target" id="<?php echo $this->get_field_id( 'sform_widget_audience' ); ?>" name="<?php echo $this->get_field_name( 'sform_widget_audience' ); ?>"><option value="all" <?php selected( $audience, 'all'); ?>><?php _e( 'Everyone', 'simpleform' ) ?></option><option value="out" <?php echo selected( $audience, 'out' ); ?>><?php _e( 'Logged-out users', 'simpleform' ) ?></option><option value="in" <?php echo selected( $audience, 'in' ); ?>><?php _e( 'Logged-in users', 'simpleform' ) ?></option></select></p>
				
		<div id="sform-widget-boxes" style="margin-top: 12px;"><p style="visibility: ; margin-bottom: 0;"><b><?php _e( 'Change how the contact form is displayed and works:', 'simpleform' ); ?></b></p><p style="margin-top: 0;"><input type="checkbox" id="<?php echo $this->get_field_id( 'sform_widget_editor' ); ?>" name="<?php echo $this->get_field_name( 'sform_widget_editor' ); ?>" class="sform-widgetbox" box="editor-<?php echo $this->number; ?>" value="false" <?php checked( $editor, 'true'); ?>><label for="<?php echo $this->get_field_id( 'sform_widget_editor' ); ?>"><?php _e( 'Override Form Editor', 'simpleform' ); ?></label><a href="<?php echo admin_url('admin.php?page=sform-editing') ?>&type=widget&id=<?php echo $this->number; ?>" target="_blank"><span class="widget-button editor-<?php echo $this->number; if ( $editor =='false' ) {echo ' unseen';}?>"><?php _e( 'Open Editor', 'simpleform' ); ?></span></a></p></div><?php
				 
	}
	
	/**
	 * Update the widget settings
	 *
	 */
	 
	public function update( $new_instance, $old_instance ) {
		
        $instance = array();
        $instance['sform_widget_title'] = isset($new_instance['sform_widget_title']) ? sanitize_text_field($new_instance['sform_widget_title']) : '';
        $instance['sform_widget_audience'] = isset($new_instance['sform_widget_audience']) && in_array($new_instance['sform_widget_audience'], array('all', 'out', 'in')) ? $new_instance['sform_widget_audience'] : 'all';
        $instance['sform_widget_editor'] = isset( $new_instance['sform_widget_editor'] ) ? 'true' : 'false';
 
		return $instance;
		
	}	
	
	/**
	 * Display the widget on the site
	 */
	
	public function widget( $args, $instance ) {
		
        $title = isset( $instance['sform_widget_title'] ) ? $instance['sform_widget_title'] : '';
        $widget_audience = isset( $instance['sform_widget_audience']) ? $instance['sform_widget_audience'] : 'all';
	    $shortcode_pages = get_transient( 'sform_shortcode_pages' );

        if ( $shortcode_pages === false ) {
		global $wpdb;
        $query = "SELECT ID, post_title, guid FROM ".$wpdb->posts." WHERE post_content LIKE '%[simpleform]%' AND post_status = 'publish'";
        $results = $wpdb->get_results ($query);
        $shortcode_pages = wp_list_pluck( $results, 'ID' );
        set_transient('sform_shortcode_pages', $shortcode_pages, 0 );
	    }
     
        global $post;
        if ( ( $widget_audience == 'out' && is_user_logged_in() ) || ( $widget_audience == 'in' && ! is_user_logged_in() ) )
        return;

        if ( in_array($post->ID, $shortcode_pages) )
        return;
        
		echo $args['before_widget'] . '<div class="sforms-widget">';
		
		if ( $title ) { echo $args['before_title'] .  $title . $args['after_title']; }

        $editor = isset( $instance['sform_widget_editor'] ) ? $instance['sform_widget_editor'] : 'false';
        $attributes_option = get_option('sform_widget_'.$this->number .'_attributes');
        $widget_attributes = $editor == 'true' && $attributes_option != false ? $this->number : '0';
	    $shortcode = '[simpleform form="'.$this->number.'" widget_attributes="'.$widget_attributes.'"]';
		echo do_shortcode( $shortcode );
		echo '</div>' . $args['after_widget'];
		
        $settings = get_option('sform_settings');
        $cssfile = ! empty( $settings['stylesheet_file'] ) ? esc_attr($settings['stylesheet_file']) : 'false';
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
        } else {
	          if( $cssfile == 'true' ) {
              wp_enqueue_style( 'sform-custom-style' );
	          }   
            }	 

        $ajax = ! empty( $settings['ajax_submission'] ) ? esc_attr($settings['ajax_submission']) : 'false'; 
        $javascript = ! empty( $settings['javascript'] ) ? esc_attr($settings['javascript']) : 'false';
        $ajax_error = ! empty( $settings['ajax_error'] ) ? stripslashes(esc_attr($settings['ajax_error'])) : esc_attr__( 'Error occurred during AJAX request. Please contact support!', 'simpleform' );
        $outside_error = ! empty( $settings['outside_error'] ) ? esc_attr($settings['outside_error']) : 'bottom';
        $outside = $outside_error == 'top' || $outside_error == 'bottom' ? 'true' : 'false';
        wp_localize_script('sform_public_script', 'ajax_sform_processing', array('ajaxurl' => admin_url('admin-ajax.php'), 'sform_loading_img' => plugins_url( 'img/processing.svg',__FILE__ ), 'ajax_error' => $ajax_error, 'outside' => $outside ));	
        wp_enqueue_script( 'sform_form_script');
        if( $ajax == 'true' ) {
         wp_enqueue_script( 'sform_public_script');
        }        
        if ( $javascript == 'true' ) { 
         if (is_child_theme() ) { 
	        wp_enqueue_script( 'sform-custom-script',  get_stylesheet_directory_uri() . '/simpleform/custom-script.js',  array( 'jquery' ), '', true );
         } else { 
	        wp_enqueue_script( 'sform-custom-script',  get_template_directory_uri() . '/simpleform/custom-script.js',  array( 'jquery' ), '', true );
         }
	    }
		
	}

	/**
	 * Add/Edit the shortcodes related to simpleform widgets
	 */
	
	public function update_sform_shortcodes($sidebars_widgets) {
		
      foreach ( $sidebars_widgets as $sidebar => $widgets ) {
	      
			if ( 'wp_inactive_widgets' === $sidebar ) {
                  $sidebars_widgets['wp_inactive_widgets'] = array();
			      continue;
			}
			if ( is_array( $widgets ) ) {
			  foreach ( $widgets as $key => $widget_id ) {
				if ( strpos($widget_id, 'sform_widget-' ) !== false ) {
                  $id =  explode("sform_widget-", $widget_id)[1];
                  $shortcode_name = 'simpleform widget="'.$id.'"';
                  $shortcode_values = apply_filters( 'sform_form', $shortcode_name );
                  global $wp_registered_sidebars;
	              $widget_area = $wp_registered_sidebars[$sidebar]['name']; 
	              $form_name = __( 'Contact Form','simpleform'); 
	              global $wpdb;
                  $table_name = "{$wpdb->prefix}sform_shortcodes";
                  if ( empty($shortcode_values['name']) ) { 
                    $wpdb->insert($table_name, array('shortcode' => $shortcode_name, 'area' => $widget_area, 'name' => $form_name));
                  }
                  if ( isset($shortcode_values['area']) && $shortcode_values['area'] != $widget_area ) { 
                    $wpdb->update($table_name, array('area' => $widget_area), array('shortcode' => $shortcode_name ));
                  }
                  
                }
	          }
	        }
	  }
	      
      return $sidebars_widgets;

	}
	
	/**
	 * Delete the shortcode after a widget has been marked for deletion and cleanup the widget option
	 */
	
	public function cleanup_sform_shortcodes( $widget_id, $sidebar_id, $id_base ) { 
    
      if ($id_base == 'sform_widget') { 
         $id =  explode("sform_widget-", $widget_id)[1];
         $shortcode_name = 'simpleform widget="'.$id.'"';
	     global $wpdb;
         $table_name = "{$wpdb->prefix}sform_shortcodes";
         $wpdb->delete($table_name, array('shortcode' => $shortcode_name ));
         $table_submissions = "{$wpdb->prefix}sform_submissions";
         $wpdb->update($table_submissions, array('form' => '1'), array( 'form' => $id));        
         $option = 'sform_widget_'.$id.'_attributes';
         $attributes_option = get_option($option);
         if ( $attributes_option != false ) { $wpdb->query( $wpdb->prepare("DELETE FROM {$wpdb->options} WHERE option_name = '%s'", $option) ); }
         $sform_widget = get_option('widget_sform_widget');
         unset($sform_widget[$id]);
         update_option('widget_sform_widget', $sform_widget);
      }
      
    }
    	    
}