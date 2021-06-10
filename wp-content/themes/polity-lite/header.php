<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div class="container">
 *
 * @package Polity Lite
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php
	if ( function_exists( 'wp_body_open' ) ) {
		wp_body_open();
	} else {
		do_action( 'wp_body_open' );
	}
?>
<a class="skip-link screen-reader-text" href="#tabnavigator">
<?php esc_html_e( 'Skip to content', 'polity-lite' ); ?>
</a>
<?php
$polity_lite_show_shortdesc_section    					= esc_attr( get_theme_mod('polity_lite_show_shortdesc_section', false) );
$polity_lite_show_header_footer_social_icons_sections   = esc_attr( get_theme_mod('polity_lite_show_header_footer_social_icons_sections', false) ); 
$polity_lite_show_donatebutton_sections        			= esc_attr( get_theme_mod('polity_lite_show_donatebutton_sections', false) ); 
$polity_lite_show_frontpageslider_section 	      		= esc_attr( get_theme_mod('polity_lite_show_frontpageslider_section', false) );
$polity_lite_show_fourcolumn_sections   				= esc_attr( get_theme_mod('polity_lite_show_fourcolumn_sections', false) );
?>
<div id="templatelayout" <?php if( get_theme_mod( 'polity_lite_boxlayoutoptions' ) ) { echo 'class="boxlayout"'; } ?>>
<?php
if ( is_front_page() && !is_home() ) {
	if( !empty($polity_lite_show_frontpageslider_section)) {
	 	$inner_cls = '';
	}
	else {
		$inner_cls = 'siteinner';
	}
}
else {
$inner_cls = 'siteinner';
}
?>

<div class="site-header <?php echo esc_attr($inner_cls); ?> ">  
	<?php if( $polity_lite_show_shortdesc_section != ''){ ?>        
       <div class="highlighterbar"> 
        <div class="container">
            <div class="center">             
              <?php
            $polity_lite_shortdesc_section = get_theme_mod('polity_lite_shortdesc_section');
            if( !empty($polity_lite_shortdesc_section) ){ ?>
                <?php echo esc_html($polity_lite_shortdesc_section); ?>
            <?php } ?> 
            </div><!-- .center -->   
         </div><!-- .container -->   
      </div><!--end .highlighterbar-->    
    <?php } ?>  
  
 <div class="container"> 
     <div class="logo">
           <?php polity_lite_the_custom_logo(); ?>
            <h1><a style='color:blue' href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
            <?php $description = get_bloginfo( 'description', 'display' );
            if ( $description || is_customize_preview() ) : ?>
                <p><?php echo esc_html($description); ?></p>
            <?php endif; ?>
     </div><!-- logo --> 
     <div class="header_right">       
        <?php if( $polity_lite_show_header_footer_social_icons_sections != ''){ ?>                
                    <div class="topsocial_icons">                                                
					   <?php $polity_lite_facebook_link = get_theme_mod('polity_lite_facebook_link');
                        if( !empty($polity_lite_facebook_link) ){ ?>
                        <a class="fab fa-facebook-f" target="_blank" href="<?php echo esc_url($polity_lite_facebook_link); ?>"></a>
                       <?php } ?>
                    
                       <?php $polity_lite_twitter_link = get_theme_mod('polity_lite_twitter_link');
                        if( !empty($polity_lite_twitter_link) ){ ?>
                        <a class="fab fa-twitter" target="_blank" href="<?php echo esc_url($polity_lite_twitter_link); ?>"></a>
                       <?php } ?>
                
                      <?php $polity_lite_googleplus_link = get_theme_mod('polity_lite_googleplus_link');
                        if( !empty($polity_lite_googleplus_link) ){ ?>
                        <a class="fab fa-google-plus" target="_blank" href="<?php echo esc_url($polity_lite_googleplus_link); ?>"></a>
                      <?php }?>
                
                      <?php $polity_lite_linkedin_link = get_theme_mod('polity_lite_linkedin_link');
                        if( !empty($polity_lite_linkedin_link) ){ ?>
                        <a class="fab fa-linkedin" target="_blank" href="<?php echo esc_url($polity_lite_linkedin_link); ?>"></a>
                      <?php } ?> 
                      
                      <?php $polity_lite_instagram_link = get_theme_mod('polity_lite_instagram_link');
                        if( !empty($polity_lite_instagram_link) ){ ?>
                        <a class="fab fa-instagram" target="_blank" href="<?php echo esc_url($polity_lite_instagram_link); ?>"></a>
                      <?php } ?> 
                 </div><!--end .topsocial_icons--> 
               <?php } ?>  
                      
                      
			   <?php if( $polity_lite_show_donatebutton_sections != ''){ ?>                      
                <?php
                $polity_lite_donatebutton = get_theme_mod('polity_lite_donatebutton');
                if( !empty($polity_lite_donatebutton) ){ ?>        
                 <?php $polity_lite_donatebutton_link = get_theme_mod('polity_lite_donatebutton_link');
                        if( !empty($polity_lite_donatebutton_link) ){ ?>
                          <div class="appointmen_btn">
                           <a class="donatebutton" target="_blank" href="<?php echo esc_url($polity_lite_donatebutton_link); ?>">
                              <?php echo esc_html($polity_lite_donatebutton); ?>            
                           </a> 
                        </div>           
                    <?php } ?> 
                <?php } } ?> 
     
     </div><!-- .header_right -->
     
     <div class="clear"></div>
  
     <div id="mainnavigator" style='text-align:center'>       
		   <button class="menu-toggle" aria-controls="main-navigation" aria-expanded="false" type="button">
			<span aria-hidden="true"><?php esc_html_e( 'Menu', 'polity-lite' ); ?></span>
			<span class="dashicons" aria-hidden="true"></span>
		   </button>

		  <nav id="main-navigation" class="site-navigation primary-navigation" role="navigation">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container' => 'ul',
				'menu_id' => 'primary',
				'menu_class' => 'primary-menu menu',
			) );
			?>
		  </nav><!-- .site-navigation -->
	    </div><!-- #mainnavigator -->
       <div class="clear"></div>       
  </div><!-- .container -->
</div><!--.site-header --> 
 
<?php 
if ( is_front_page() && !is_home() ) {
if($polity_lite_show_frontpageslider_section != '') {
	for($i=1; $i<=3; $i++) {
	  if( get_theme_mod('polity_lite_homepageslider'.$i,false)) {
		$slider_Arr[] = absint( get_theme_mod('polity_lite_homepageslider'.$i,true));
	  }
	}
?> 
<div class="frontslider-sections">              
<?php if(!empty($slider_Arr)){ ?>
<div id="slider" class="nivoSlider">
<?php 
$i=1;
$slidequery = new WP_Query( array( 'post_type' => 'page', 'post__in' => $slider_Arr, 'orderby' => 'post__in' ) );
while( $slidequery->have_posts() ) : $slidequery->the_post();
$image = wp_get_attachment_url( get_post_thumbnail_id($post->ID)); 
$thumbnail_id = get_post_thumbnail_id( $post->ID );
$alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true); 
?>
<?php if(!empty($image)){ ?>
<img src="<?php echo esc_url( $image ); ?>" title="#slidecaption<?php echo esc_attr( $i ); ?>" alt="<?php echo esc_attr($alt); ?>" />
<?php }else{ ?>
<img src="<?php echo esc_url( get_template_directory_uri() ) ; ?>/images/slides/slider-default.jpg" title="#slidecaption<?php echo esc_attr( $i ); ?>" alt="<?php echo esc_attr($alt); ?>" />
<?php } ?>
<?php $i++; endwhile; ?>
</div>   

<?php 
$j=1;
$slidequery->rewind_posts();
while( $slidequery->have_posts() ) : $slidequery->the_post(); ?>                 
    <div id="slidecaption<?php echo esc_attr( $j ); ?>" class="nivo-html-caption">         
    	<h2><?php the_title(); ?></h2>
    	<?php the_excerpt(); ?>
		<?php
        $polity_lite_homepagesliderbutton = get_theme_mod('polity_lite_homepagesliderbutton');
        if( !empty($polity_lite_homepagesliderbutton) ){ ?>
            <a class="slide_morebtn" href="<?php the_permalink(); ?>"><?php echo esc_html($polity_lite_homepagesliderbutton); ?></a>
        <?php } ?>                  
    </div>   
<?php $j++; 
endwhile;
wp_reset_postdata(); ?>   
<?php } ?>
 </div><!-- .frontslider-sections -->    
<?php } } ?>

   
        
<?php if ( is_front_page() && ! is_home() ) { ?>
   <?php if( $polity_lite_show_fourcolumn_sections != ''){ ?> 
   <section id="home_services_section">
     <div class="container">      
               <?php 
                for($n=1; $n<=4; $n++) {    
                if( get_theme_mod('polity_lite_fourcolumn_pgebx'.$n,false)) {      
                    $queryvar = new WP_Query('page_id='.absint(get_theme_mod('polity_lite_fourcolumn_pgebx'.$n,true)) );		
                    while( $queryvar->have_posts() ) : $queryvar->the_post(); ?>     
                    <div class="top4box <?php if($n % 4 == 0) { echo "last_column"; } ?>">                                                   
                        <?php if(has_post_thumbnail() ) { ?>
                        <div class="iconbox"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a></div>        
                        <?php } ?>
                        <div class="shortinfobx">              	
                          <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> 
                          <?php the_excerpt(); ?> 
                          <a class="readmore" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'polity-lite' ); ?></a>                        
                         </div>                                      
                    </div>
                    <?php endwhile;
                    wp_reset_postdata();                                  
                } } ?>                                 
            <div class="clear"></div>        
      </div><!-- .container -->
    </section><!-- #home_services_section -->
  <?php } ?>
<?php } ?>