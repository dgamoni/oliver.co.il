<?php
function constance_script() {
	if (!is_admin()) {
		
		$nvr_siteurl = CONSTANCE_SITEURL;
		$nvr_adminurl = CONSTANCE_ADMINURL;
		$nvr_themeurl = CONSTANCE_STYLEURI;
		
		wp_register_script('nvr_easing', CONSTANCE_JSURI .'jquery.easing.js', array('jquery'), '1.2', true);
		wp_enqueue_script('nvr_easing');
		
		wp_register_script('nvr_color', CONSTANCE_JSURI .'jquery.color.js', array('jquery'), '2.0', true);
		wp_enqueue_script('nvr_color');
		
		wp_register_script('nvr_cookie', CONSTANCE_JSURI .'jquery.cookie.js', array('jquery'), '1.0', true);
		if(constance_get_option( 'constance_enable_switcher') ){
			wp_enqueue_script('nvr_cookie');
		}
		
		wp_register_script('nvr_modernizr', CONSTANCE_JSURI .'modernizr.js', array('jquery'), '2.5.3');
		wp_enqueue_script('nvr_modernizr');
		
		wp_register_script('nvr_appear', CONSTANCE_JSURI .'appear.js', array('jquery'), '1.0', true);
		wp_enqueue_script('nvr_appear');
		
		wp_register_script('nvr_parallax', CONSTANCE_JSURI .'jquery.parallax-1.1.3.js', array('jquery'), '1.1.3', true);
		wp_enqueue_script('nvr_parallax');
		
		wp_register_script('nvr_isotope', CONSTANCE_JSURI .'jquery.isotope.min.js', array('jquery'), '1.0', true);
		wp_enqueue_script('nvr_isotope');
		
		wp_register_script('nvr_CountTo', CONSTANCE_JSURI .'jquery.countTo.js', array('jquery'), '1.0', true);
		wp_enqueue_script('nvr_CountTo');
		
		wp_register_script('nvr_infinite-scroll', CONSTANCE_JSURI .'jquery.infinitescroll.js', array('jquery'), '2.0b2', true);
		wp_enqueue_script('nvr_infinite-scroll');
		
		wp_register_script('nvr_prettyPhoto', CONSTANCE_JSURI .'jquery.prettyPhoto.js', array('jquery'), '3.0', true);
		wp_enqueue_script('nvr_prettyPhoto');
		
		wp_register_script('nvr_PerfectScrollbar', CONSTANCE_JSURI .'perfect-scrollbar.with-mousewheel.min.js', array('jquery'), '0.4.9', true);
		wp_enqueue_script('nvr_PerfectScrollbar');
		
		wp_register_script('nvr_ImagesLoaded', CONSTANCE_JSURI .'imagesloaded.pkgd.min.js', array('jquery'), '3.0.4', true);
		wp_enqueue_script('nvr_ImagesLoaded');
		
		wp_register_script('nvr_flexslider', CONSTANCE_JSURI .'jquery.flexslider-min.js', array('jquery'), '1.8', true);
		wp_enqueue_script('nvr_flexslider');
		
		wp_register_script('nvr_selectordie', CONSTANCE_JSURI .'selectordie.min.js', array('jquery'), '1.1.0', true);
		wp_enqueue_script('nvr_selectordie');
		
		wp_register_script('nvr_retina', CONSTANCE_JSURI .'retina.min.js', array('jquery'), '1.1.0', true);
		wp_enqueue_script('nvr_retina');
		
		wp_register_script('nvr_customPortfolio', CONSTANCE_JSURI .'nvrportfolio.js', array('jquery'), '1.0', true);
		wp_enqueue_script('nvr_customPortfolio');
		
		wp_register_script('nvr_customTestimonial', CONSTANCE_JSURI .'nvrtestimonial.js', array('jquery'), '1.0', true);
		wp_enqueue_script('nvr_customTestimonial');
		
		wp_register_script('nvr_customBrand', CONSTANCE_JSURI .'nvrbrand.js', array('jquery'), '1.0', true);
		wp_enqueue_script('nvr_customBrand');
		
		wp_register_script('constance_custom', CONSTANCE_JSURI .'custom.js', array('jquery'), '1.0', true);
		wp_enqueue_script('constance_custom');
		
		$nvr_sliderEffect = constance_get_option( 'constance_slider_effect' ,'fade'); 
		$nvr_sliderInterval = constance_get_option( 'constance_slider_interval' ,600);
		$nvr_sliderDisableNav = constance_get_option( 'constance_slider_disable_nav');
		$nvr_sliderDisablePrevNext = constance_get_option( 'constance_slider_disable_prevnext');
		
		$nvr_domainFormLink = constance_get_option( 'constance_domainform_link','');
		if(!$nvr_domainFormLink){
			$nvr_domainFormLink = $nvr_siteurl;
		}
		
		$nvr_interfeisvar = array( 
			'siteurl' 					=> $nvr_siteurl, 
			'adminurl' 					=> $nvr_adminurl,
			'themeurl'					=> $nvr_themeurl,
			'pfloadmore'				=> esc_html__('Loading More Portfolio', "constance"),
			'postloadmore'				=> esc_html__('Loading More Posts', "constance"),
			'loadfinish'				=> esc_html__('All Items are Loaded', "constance"),
			'totalcarttext'				=> esc_html__('Items', "constance"),
			'sendingtext'				=> esc_html__('Loading...', "constance"),
			'slidereffect' 				=> $nvr_sliderEffect,
			'slider_interval' 			=> $nvr_sliderInterval,
			'slider_disable_nav' 		=> $nvr_sliderDisableNav,
			'slider_disable_prevnext' 	=> $nvr_sliderDisablePrevNext,
			'domainformlink'			=> $nvr_domainFormLink
		);
		wp_localize_script( 'constance_custom', 'interfeis_var', $nvr_interfeisvar );
		
		wp_enqueue_script( 'wc-add-to-cart-variation');
		
	}
}
add_action('wp_enqueue_scripts', 'constance_script');

function constance_admin_script(){
	
	$nvr_siteurl = CONSTANCE_SITEURL;
	$nvr_adminurl = CONSTANCE_ADMINURL;
	$nvr_themeurl = CONSTANCE_STYLEURI;
	
	wp_register_script('constance_options_generator', CONSTANCE_JSURI .'backend/option_generator.js', array('jquery'), '1.0', true);
	wp_enqueue_script('constance_options_generator');

}
add_action('admin_enqueue_scripts', 'constance_admin_script');