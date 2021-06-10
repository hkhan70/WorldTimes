<?php    
/**
 *polity-lite Theme Customizer
 *
 * @package Polity Lite
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function polity_lite_customize_register( $wp_customize ) {	
	
	function polity_lite_sanitize_dropdown_pages( $page_id, $setting ) {
	  // Ensure $input is an absolute integer.
	  $page_id = absint( $page_id );
	
	  // If $page_id is an ID of a published page, return it; otherwise, return the default.
	  return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
	}

	function polity_lite_sanitize_checkbox( $checked ) {
		// Boolean check.
		return ( ( isset( $checked ) && true == $checked ) ? true : false );
	} 
	
	function polity_lite_sanitize_phone_number( $phone ) {
		// sanitize phone
		return preg_replace( '/[^\d+]/', '', $phone );
	} 
		
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	
	 //Panel for section & control
	$wp_customize->add_panel( 'polity_lite_panel_section', array(
		'priority' => null,
		'capability' => 'edit_theme_options',
		'theme_supports' => '',
		'title' => __( 'Theme Options Panel', 'polity-lite' ),		
	) );
	
	//Site Layout Options
	$wp_customize->add_section('polity_lite_layout_sections',array(
		'title' => __('Site Layout Options','polity-lite'),			
		'priority' => 1,
		'panel' => 	'polity_lite_panel_section',          
	));		
	
	$wp_customize->add_setting('polity_lite_boxlayoutoptions',array(
		'sanitize_callback' => 'polity_lite_sanitize_checkbox',
	));	 

	$wp_customize->add_control( 'polity_lite_boxlayoutoptions', array(
    	'section'   => 'polity_lite_layout_sections',    	 
		'label' => __('Check to Show Box Layout','polity-lite'),
		'description' => __('If you want to show box layout please check the Box Layout Option.','polity-lite'),
    	'type'      => 'checkbox'
     )); //Site Layout Options 
	
	$wp_customize->add_setting('polity_lite_template_coloroptions',array(
		'default' => '#d41e44',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'polity_lite_template_coloroptions',array(
			'label' => __('Color Options','polity-lite'),			
			'description' => __('More color options available in PRO Version','polity-lite'),
			'section' => 'colors',
			'settings' => 'polity_lite_template_coloroptions'
		))
	);
	
	$wp_customize->add_setting('polity_lite_template_hover_color',array(
		'default' => '#000000',
		'sanitize_callback' => 'sanitize_hex_color'
	));
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control($wp_customize,'polity_lite_template_hover_color',array(
			'label' => __('Hover Color Options','polity-lite'),			
			'section' => 'colors',
			'settings' => 'polity_lite_template_hover_color'
		))
	);	
	
	//Top Short Heading Text
	$wp_customize->add_section('polity_lite_top_shortheadingtext_sections',array(
		'title' => __('Top Short Heading Text','polity-lite'),
		'description' => __( 'Add short description in header.', 'polity-lite' ),			
		'priority' => null,
		'panel' => 	'polity_lite_panel_section', 
	));	
	
	
	$wp_customize->add_setting('polity_lite_shortdesc_section',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('polity_lite_shortdesc_section',array(	
		'type' => 'text',		
		'section' => 'polity_lite_top_shortheadingtext_sections',
		'setting' => 'polity_lite_shortdesc_section'
	)); 
	
	$wp_customize->add_setting('polity_lite_show_shortdesc_section',array(
		'default' => false,
		'sanitize_callback' => 'polity_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'polity_lite_show_shortdesc_section', array(
	   'settings' => 'polity_lite_show_shortdesc_section',
	   'section'   => 'polity_lite_top_shortheadingtext_sections',
	   'label'     => __('Check To show This Section','polity-lite'),
	   'type'      => 'checkbox'
	 ));//Show Short Top Short Heading Text Sections 
	 
	 //Social icons Section
	$wp_customize->add_section('polity_lite_header_footer_social_icons_sections',array(
		'title' => __('Header & Footer Social Sections','polity-lite'),
		'description' => __( 'Add social icons link here to display icons in header and footer.', 'polity-lite' ),			
		'priority' => null,
		'panel' => 	'polity_lite_panel_section', 
	));
	
	$wp_customize->add_setting('polity_lite_facebook_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'	
	));
	
	$wp_customize->add_control('polity_lite_facebook_link',array(
		'label' => __('Add facebook link here','polity-lite'),
		'section' => 'polity_lite_header_footer_social_icons_sections',
		'setting' => 'polity_lite_facebook_link'
	));	
	
	$wp_customize->add_setting('polity_lite_twitter_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('polity_lite_twitter_link',array(
		'label' => __('Add twitter link here','polity-lite'),
		'section' => 'polity_lite_header_footer_social_icons_sections',
		'setting' => 'polity_lite_twitter_link'
	));
	
	$wp_customize->add_setting('polity_lite_googleplus_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('polity_lite_googleplus_link',array(
		'label' => __('Add google plus link here','polity-lite'),
		'section' => 'polity_lite_header_footer_social_icons_sections',
		'setting' => 'polity_lite_googleplus_link'
	));
	
	$wp_customize->add_setting('polity_lite_linkedin_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('polity_lite_linkedin_link',array(
		'label' => __('Add linkedin link here','polity-lite'),
		'section' => 'polity_lite_header_footer_social_icons_sections',
		'setting' => 'polity_lite_linkedin_link'
	));
	
	$wp_customize->add_setting('polity_lite_instagram_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('polity_lite_instagram_link',array(
		'label' => __('Add instagram link here','polity-lite'),
		'section' => 'polity_lite_header_footer_social_icons_sections',
		'setting' => 'polity_lite_instagram_link'
	));
	
	$wp_customize->add_setting('polity_lite_show_header_footer_social_icons_sections',array(
		'default' => false,
		'sanitize_callback' => 'polity_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'polity_lite_show_header_footer_social_icons_sections', array(
	   'settings' => 'polity_lite_show_header_footer_social_icons_sections',
	   'section'   => 'polity_lite_header_footer_social_icons_sections',
	   'label'     => __('Check To show This Section','polity-lite'),
	   'type'      => 'checkbox'
	 ));//Show Header &footer Social icons Section
	 
	 
	 //Donate Button
	$wp_customize->add_section('polity_lite_donate_button_sections',array(
		'title' => __('Donate Button','polity-lite'),
		'description' => __( 'Add link here to display donate button in header.', 'polity-lite' ),			
		'priority' => null,
		'panel' => 	'polity_lite_panel_section', 
	));	
	
	
	$wp_customize->add_setting('polity_lite_donatebutton',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('polity_lite_donatebutton',array(	
		'type' => 'text',
		'label' => __('enter slider Read more button name here','polity-lite'),
		'section' => 'polity_lite_donate_button_sections',
		'setting' => 'polity_lite_donatebutton'
	)); // donate button text
	
	
	$wp_customize->add_setting('polity_lite_donatebutton_link',array(
		'default' => null,
		'sanitize_callback' => 'esc_url_raw'
	));
	
	$wp_customize->add_control('polity_lite_donatebutton_link',array(
		'label' => __('Add button link here','polity-lite'),
		'section' => 'polity_lite_donate_button_sections',
		'setting' => 'polity_lite_donatebutton_link'
	));
	
	$wp_customize->add_setting('polity_lite_show_donatebutton_sections',array(
		'default' => false,
		'sanitize_callback' => 'polity_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'polity_lite_show_donatebutton_sections', array(
	   'settings' => 'polity_lite_show_donatebutton_sections',
	   'section'   => 'polity_lite_donate_button_sections',
	   'label'     => __('Check To show This Section','polity-lite'),
	   'type'      => 'checkbox'
	 ));//Show Donate Button
	
	
	// Front Slider Section		
	$wp_customize->add_section( 'polity_lite_frontpageslider_section', array(
		'title' => __('Frontpage Slider Sections', 'polity-lite'),
		'priority' => null,
		'description' => __('Default image size for slider is 1400 x 735 pixel.','polity-lite'), 
		'panel' => 	'polity_lite_panel_section',           			
    ));
	
	$wp_customize->add_setting('polity_lite_homepageslider1',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'polity_lite_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('polity_lite_homepageslider1',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slider 1:','polity-lite'),
		'section' => 'polity_lite_frontpageslider_section'
	));	
	
	$wp_customize->add_setting('polity_lite_homepageslider2',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'polity_lite_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('polity_lite_homepageslider2',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slider 2:','polity-lite'),
		'section' => 'polity_lite_frontpageslider_section'
	));	
	
	$wp_customize->add_setting('polity_lite_homepageslider3',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'polity_lite_sanitize_dropdown_pages'
	));
	
	$wp_customize->add_control('polity_lite_homepageslider3',array(
		'type' => 'dropdown-pages',
		'label' => __('Select page for slider 3:','polity-lite'),
		'section' => 'polity_lite_frontpageslider_section'
	));	// Homepage Slider Section
	
	$wp_customize->add_setting('polity_lite_homepagesliderbutton',array(
		'default' => null,
		'sanitize_callback' => 'sanitize_text_field'	
	));
	
	$wp_customize->add_control('polity_lite_homepagesliderbutton',array(	
		'type' => 'text',
		'label' => __('enter slider Read more button name here','polity-lite'),
		'section' => 'polity_lite_frontpageslider_section',
		'setting' => 'polity_lite_homepagesliderbutton'
	)); // Home Slider Read More Button Text
	
	$wp_customize->add_setting('polity_lite_show_frontpageslider_section',array(
		'default' => false,
		'sanitize_callback' => 'polity_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'polity_lite_show_frontpageslider_section', array(
	    'settings' => 'polity_lite_show_frontpageslider_section',
	    'section'   => 'polity_lite_frontpageslider_section',
	     'label'     => __('Check To Show This Section','polity-lite'),
	   'type'      => 'checkbox'
	 ));//Show Frontpage Slider Section	
	 
	 
	 //four column Section
	$wp_customize->add_section('polity_lite_fourcolumn_sections', array(
		'title' => __('Four column Services Section','polity-lite'),
		'description' => __('Select pages from the dropdown for four column sections','polity-lite'),
		'priority' => null,
		'panel' => 	'polity_lite_panel_section',          
	));	
	
	
	$wp_customize->add_setting('polity_lite_fourcolumn_pgebx1',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'polity_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'polity_lite_fourcolumn_pgebx1',array(
		'type' => 'dropdown-pages',			
		'section' => 'polity_lite_fourcolumn_sections',
	));		
	
	$wp_customize->add_setting('polity_lite_fourcolumn_pgebx2',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'polity_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'polity_lite_fourcolumn_pgebx2',array(
		'type' => 'dropdown-pages',			
		'section' => 'polity_lite_fourcolumn_sections',
	));
	
	$wp_customize->add_setting('polity_lite_fourcolumn_pgebx3',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'polity_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'polity_lite_fourcolumn_pgebx3',array(
		'type' => 'dropdown-pages',			
		'section' => 'polity_lite_fourcolumn_sections',
	));	
	
	
	$wp_customize->add_setting('polity_lite_fourcolumn_pgebx4',array(
		'default' => '0',			
		'capability' => 'edit_theme_options',
		'sanitize_callback' => 'polity_lite_sanitize_dropdown_pages'
	));
 
	$wp_customize->add_control(	'polity_lite_fourcolumn_pgebx4',array(
		'type' => 'dropdown-pages',			
		'section' => 'polity_lite_fourcolumn_sections',
	));	
	
	
	$wp_customize->add_setting('polity_lite_show_fourcolumn_sections',array(
		'default' => false,
		'sanitize_callback' => 'polity_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'polity_lite_show_fourcolumn_sections', array(
	   'settings' => 'polity_lite_show_fourcolumn_sections',
	   'section'   => 'polity_lite_fourcolumn_sections',
	   'label'     => __('Check To Show This Section','polity-lite'),
	   'type'      => 'checkbox'
	 ));//Show four column Section
	 
	 //Footer Contact info section
	$wp_customize->add_section('polity_lite_footerinfo_sections',array(
		'title' => __('Footer Contact Section','polity-lite'),				
		'priority' => null,
		'panel' => 	'polity_lite_panel_section',
	));		
	
	
	$wp_customize->add_setting('polity_lite_footerphone',array(
		'default' => null,
		'sanitize_callback' => 'polity_lite_sanitize_phone_number'	
	));
	
	$wp_customize->add_control('polity_lite_footerphone',array(	
		'type' => 'text',
		'label' => __('Enter phone number here','polity-lite'),
		'section' => 'polity_lite_footerinfo_sections',
		'setting' => 'polity_lite_footerphone'
	));	
	
	$wp_customize->add_setting('polity_lite_footeremail',array(
		'sanitize_callback' => 'sanitize_email'
	));
	
	$wp_customize->add_control('polity_lite_footeremail',array(
		'type' => 'email',
		'label' => __('enter email id here.','polity-lite'),
		'section' => 'polity_lite_footerinfo_sections'
	));		
		
	
	$wp_customize->add_setting('polity_lite_show_footerinfo_sections',array(
		'default' => false,
		'sanitize_callback' => 'polity_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'polity_lite_show_footerinfo_sections', array(
	   'settings' => 'polity_lite_show_footerinfo_sections',
	   'section'   => 'polity_lite_footerinfo_sections',
	   'label'     => __('Check To show This Section','polity-lite'),
	   'type'      => 'checkbox'
	 ));//Show Footer Contact section
	 
	 
	//Sidebar Settings
	$wp_customize->add_section('polity_lite_sidebar_options', array(
		'title' => __('Sidebar Options','polity-lite'),		
		'priority' => null,
		'panel' => 	'polity_lite_panel_section',          
	));	
	
	$wp_customize->add_setting('polity_lite_hidesidebar_from_homepage',array(
		'default' => false,
		'sanitize_callback' => 'polity_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'polity_lite_hidesidebar_from_homepage', array(
	   'settings' => 'polity_lite_hidesidebar_from_homepage',
	   'section'   => 'polity_lite_sidebar_options',
	   'label'     => __('Check to hide sidebar from latest post page','polity-lite'),
	   'type'      => 'checkbox'
	 ));// Hide sidebar from latest post page
	 
	 
	 $wp_customize->add_setting('polity_lite_hidesidebar_singlepost',array(
		'default' => false,
		'sanitize_callback' => 'polity_lite_sanitize_checkbox',
		'capability' => 'edit_theme_options',
	));	 
	
	$wp_customize->add_control( 'polity_lite_hidesidebar_singlepost', array(
	   'settings' => 'polity_lite_hidesidebar_singlepost',
	   'section'   => 'polity_lite_sidebar_options',
	   'label'     => __('Check to hide sidebar from single post','polity-lite'),
	   'type'      => 'checkbox'
	 ));// hide sidebar single post	 

		 
}
add_action( 'customize_register', 'polity_lite_customize_register' );

function polity_lite_custom_css(){ 
?>
	<style type="text/css"> 					
        a, .listview_blogstyle h2 a:hover,
        #sidebar ul li a:hover,						
        .listview_blogstyle h3 a:hover,		
        .postmeta a:hover,		
		.site-navigation .menu a:hover,
		.site-navigation .menu a:focus,
		.site-navigation .menu ul a:hover,
		.site-navigation .menu ul a:focus,
		.site-navigation ul li a:hover, 
		.site-navigation ul li.current-menu-item a,
		.site-navigation ul li.current-menu-parent a.parent,
		.site-navigation ul li.current-menu-item ul.sub-menu li a:hover, 			
        .button:hover,
		.topsocial_icons a:hover,
		.nivo-caption h2 span,
		h2.services_title span,
		.top4box:hover h3 a,		
		.blog_postmeta a:hover,		
		.site-footer ul li a:hover, 
		.site-footer ul li.current_page_item a		
            { color:<?php echo esc_html( get_theme_mod('polity_lite_template_coloroptions','#d41e44')); ?>;}					 
            
        .pagination ul li .current, .pagination ul li a:hover, 
        #commentform input#submit:hover,		
        .nivo-controlNav a.active,
		.sd-search input, .sd-top-bar-nav .sd-search input,			
		a.blogreadmore,	
		.highlighterbar,
		#mainnavigator,
		h3.widget-title,
		.site-navigation .menu ul,		
		.nivo-caption .slide_morebtn,
		.learnmore:hover,		
		.copyrigh-wrapper:before,
		.ftr3colbx a.get_an_enquiry:hover,									
        #sidebar .search-form input.search-submit,				
        .wpcf7 input[type='submit'],				
        nav.pagination .page-numbers.current,		
		.blogreadbtn,
		a.donatebutton,		
        .toggle a	
            { background-color:<?php echo esc_html( get_theme_mod('polity_lite_template_coloroptions','#d41e44')); ?>;}
			
		
		.tagcloud a:hover,		
		.topsocial_icons a:hover,		
		h3.widget-title::after
            { border-color:<?php echo esc_html( get_theme_mod('polity_lite_template_coloroptions','#d41e44')); ?>;}
			
			
		 button:focus,
		input[type="button"]:focus,
		input[type="reset"]:focus,
		input[type="submit"]:focus,
		input[type="text"]:focus,
		input[type="email"]:focus,
		input[type="url"]:focus,
		input[type="password"]:focus,
		input[type="search"]:focus,
		input[type="number"]:focus,
		input[type="tel"]:focus,
		input[type="range"]:focus,
		input[type="date"]:focus,
		input[type="month"]:focus,
		input[type="week"]:focus,
		input[type="time"]:focus,
		input[type="datetime"]:focus,
		input[type="datetime-local"]:focus,
		input[type="color"]:focus,
		textarea:focus,
		#templatelayout a:focus
            { outline:thin dotted <?php echo esc_html( get_theme_mod('polity_lite_template_coloroptions','#d41e44')); ?>;}	
			
		
		.site-navigation .menu a:hover,
		.site-navigation .menu a:focus,
		.site-navigation .menu ul a:hover,
		.site-navigation .menu ul a:focus,
		.site-navigation ul li a:hover, 
		.site-navigation ul li.current-menu-item a,
		.site-navigation ul li.current-menu-parent a.parent,
		.site-navigation ul li.current-menu-item ul.sub-menu li a:hover	
       	 { color:<?php echo esc_html( get_theme_mod('polity_lite_template_hover_color','#000000')); ?>;}
		 
		a.donatebutton:hover
       	 { background-color:<?php echo esc_html( get_theme_mod('polity_lite_template_hover_color','#000000')); ?>;} 					
	
    </style> 
<?php                                                                                        
}
         
add_action('wp_head','polity_lite_custom_css');	 

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function polity_lite_customize_preview_js() {
	wp_enqueue_script( 'polity_lite_customizer', get_template_directory_uri() . '/js/customize-preview.js', array( 'customize-preview' ), '19062019', true );
}
add_action( 'customize_preview_init', 'polity_lite_customize_preview_js' );