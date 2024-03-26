<?php
add_action( 'after_setup_theme', 'wc_deregister_polls_scripts_and_styles' );

function wc_deregister_polls_scripts_and_styles() {
  remove_action('wp_enqueue_scripts', 'constance_styles');
  remove_action('wp_enqueue_scripts', 'constance_script');
}

function constance_new_styles() {
 if (!is_admin()) {
		wp_register_style('oliver-default', CONSTANCE_STYLEURI . 'style.css', '', '', 'screen, all');
		wp_enqueue_style('oliver-default');
		wp_register_style('nvr_font-awesome-css', CONSTANCE_CSSURI . 'font-awesome.min.css', 'nvr_normalize-css', '', 'screen, all');
		wp_enqueue_style('nvr_font-awesome-css');
		wp_register_style('nvr_font-line-icon-css', CONSTANCE_CSSURI . 'font-line-icon.css', 'nvr_normalize-css', '', 'screen, all');
		wp_enqueue_style('nvr_font-line-icon-css');
		wp_register_style('constance_stylecustom', CONSTANCE_STYLEURI . 'style-custom.css', '', '', 'screen, all');
		wp_enqueue_style('constance_stylecustom');
	    wp_enqueue_script('addthis', '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-576bdc69e36ab6a2');
	}
}
add_action('wp_enqueue_scripts', 'constance_new_styles');

function constance_js_script() {
	if (!is_admin()) {
		
		$nvr_siteurl = CONSTANCE_SITEURL;
		$nvr_adminurl = CONSTANCE_ADMINURL;
		$nvr_themeurl = CONSTANCE_STYLEURI;
		
		wp_register_script('nvr_easing', CONSTANCE_JSURI .'jquery.easing.js', array('jquery'), '1.2', true);
		wp_enqueue_script('nvr_easing');
		
		wp_register_script('nvr_color', CONSTANCE_JSURI .'jquery.color.js', array('jquery'), '2.0', true);
		wp_enqueue_script('nvr_color');
		
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
		
		//wp_register_script('nvr_PerfectScrollbar', CONSTANCE_JSURI .'perfect-scrollbar.with-mousewheel.min.js', array('jquery'), '0.4.9', true);
		//wp_enqueue_script('nvr_PerfectScrollbar');
		
		wp_register_script('nvr_ImagesLoaded', CONSTANCE_JSURI .'imagesloaded.pkgd.min.js', array('jquery'), '3.0.4', true);
		wp_enqueue_script('nvr_ImagesLoaded');
		
		wp_register_script('nvr_flexslider', CONSTANCE_JSURI .'jquery.flexslider-min.js', array('jquery'), '1.8', true);
		wp_enqueue_script('nvr_flexslider');
		
		wp_register_script('nvr_selectordie', CONSTANCE_JSURI .'selectordie.min.js', array('jquery'), '1.1.0', true);
		wp_enqueue_script('nvr_selectordie');
		
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
add_action('wp_enqueue_scripts', 'constance_js_script');

//Disable Reviews
add_filter( 'woocommerce_product_tabs', 'wcs_woo_remove_reviews_tab', 98 );
function wcs_woo_remove_reviews_tab($tabs) {
 unset($tabs['reviews']);
 return $tabs;
}

//Disable WO Emoji
function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}

add_action( 'init', 'disable_wp_emojicons' );

function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}


remove_action('wp_head', 'rsd_link'); // remove really simple discovery link
remove_action('wp_head', 'wp_generator'); // remove wordpress version
remove_action('wp_head', 'feed_links', 2); // remove rss feed links (make sure you add them in yourself if youre using feedblitz or an rss service)
remove_action('wp_head', 'feed_links_extra', 3); // removes all extra rss feed links
remove_action('wp_head', 'index_rel_link'); // remove link to index paged
remove_action('wp_head', 'wlwmanifest_link'); // remove wlwmanifest.xml (needed to support windows live writer)
remove_action('wp_head', 'start_post_rel_link', 10, 0); // remove random post link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // remove parent post link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // remove the next and previous post links
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );
remove_action('wp_head', 'rest_output_link_wp_head', 10 );
//remove_action('wp_head', 'wp_oembed_add_discovery_links', 10 );
remove_action('wp_head', 'rel_canonical');

//Disable edit link
function wpse_remove_edit_post_link( $link ) {
return '';
}
add_filter('edit_post_link', 'wpse_remove_edit_post_link');

function vc_remove_frontend_links() {
    vc_disable_frontend(); // this will disable frontend editor
}
add_action( 'vc_after_init', 'vc_remove_frontend_links' );

// dgamoni

/**
 * On checkout we have free shipping in Latvia if order is over 50 EUR. 
 *
 * FIRST:
 * We should hide in this case this 2 options:
 * Latvijas pasts (izņemšana pasta nodaļā):€3.63 (iesk. PVN)
 * Ekspresspasts (piegāde ar kurjeru): €6.05(iesk. PVN)
 *
 * @param array $rates Array of rates found for the package.
 * @return array
 */
function my_hide_shipping_when_free_is_available( $rates ) {
	$free = array();
	$free_shipping = false;
	foreach ( $rates as $rate_id => $rate ) {
		if ( 'free_shipping' === $rate->method_id ) {
			$free[ $rate_id ] = $rate;
			$free_shipping = true;
			//break;
		} else if ('flat_rate' != $rate->method_id){
			$free[ $rate_id ] = $rate;
		}

	}
	//return ! empty( $free ) ? $free : $rates;
	if ($free_shipping) {
		return  $free;
	} else {
		return  $rates;
	}
}
add_filter( 'woocommerce_package_rates', 'my_hide_shipping_when_free_is_available', 100 );


//unset free_shipping:8 - Latvijas pasts (izņemšana pasta nodaļā)
function wc_cart_totals_shipping_html_plus_filter($id) {
  $packages = WC()->shipping->get_packages();

  foreach ( $packages as $i => $package ) {
    $chosen_method = isset( WC()->session->chosen_shipping_methods[ $i ] ) ? WC()->session->chosen_shipping_methods[ $i ] : '';
    $product_names = array();

    if ( sizeof( $packages ) > 1 ) {
      foreach ( $package['contents'] as $item_id => $values ) {
        $product_names[] = $values['data']->get_title() . ' &times;' . $values['quantity'];
      }
    }

    //var_dump($package['rates']);
    //var_dump($package['rates']["free_shipping:8"]);
    //unset($package['rates']["free_shipping:8"]);
    unset($package['rates'][$id]);
    //var_dump($package['rates']);

    wc_get_template( 'cart/cart-shipping.php', array(
      'package'              => $package,
      'available_methods'    => $package['rates'],
      'show_package_details' => sizeof( $packages ) > 1,
      'package_details'      => implode( ', ', $product_names ),
      'package_name'         => apply_filters( 'woocommerce_shipping_package_name', sprintf( _n( 'Shipping', 'Shipping %d', ( $i + 1 ), 'woocommerce' ), ( $i + 1 ) ), $i, $package ),
      'index'                => $i,
      'chosen_method'        => $chosen_method
    ) );
  }
}