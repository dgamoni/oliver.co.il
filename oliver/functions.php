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

//unset free_shipping:8 and flat_rate:5
function wc_cart_totals_shipping_html_plus_filter_array($id) {
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
    foreach ($id as $key => $idd) {
    	unset($package['rates'][$idd]);
    }
    //unset($package['rates'][$id]);
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

// dgamoni update 22-07-16
function child_remove_parent_function() {
    remove_action( 'woocommerce_archive_description', 'constance_woocommerce_shop_category', 40 );
}
add_action( 'wp_loaded', 'child_remove_parent_function' );

// masonory
add_action( 'woocommerce_archive_description', 'constance_woocommerce_shop_category_child', 40 );
function constance_woocommerce_shop_category_child(){
	
	$nvr_shopmasonry = constance_woocommerce_use_masonry();
	
	$nvr_shopfilter = constance_get_option( 'constance_shop_filter');
	if(isset($_GET['prodfilter']) && $_GET['prodfilter']=='true'){
		$nvr_shopfilter = '1';
	}
	//$nvr_shopfilter = ( $nvr_shopfilter=="1" && $nvr_shopmasonry)? true : false;
 	$nvr_shopfilter = ( $nvr_shopfilter=="1" && !$nvr_shopmasonry)? true : false;
	
	if($nvr_shopfilter){
		$nvr_shopid = constance_get_postid();
		$nvr_shoppermalink = get_permalink($nvr_shopid);
		$nvr_producttax = 'product_cat';
		$nvr_productcats = get_terms( $nvr_producttax, array( 'hide_empty' => true ) );
		
		echo '<div class="isotope-filter-container nine columns">';
			echo '<ul class="isotope-filter">';
				echo '<li class="firstfilter"><a href="'.esc_url( $nvr_shoppermalink ).'" data-product-slug="" data-option-value="*">'.esc_html__('All', "constance").'</a></li>';
				foreach($nvr_productcats as $nvr_productcat){
					$nvr_termlink = get_term_link($nvr_productcat->slug, $nvr_producttax);
					if ( is_wp_error( $nvr_termlink ) ) {
						continue;
					}
					echo '<li class=""><a href="'.esc_url($nvr_termlink).'" data-product-slug="'.esc_attr($nvr_productcat->slug).'" data-option-value=".product-cat-'. esc_attr( $nvr_productcat->slug ).'">'.$nvr_productcat->name.'</a></li>';
				}
			echo '</ul>';
			echo '<div class="clearfix"></div>';
		echo '</div>';
	}
	
}

// custom header
function constance_styles_child() {
	if (!is_admin()) {

		$nvr_custom_css = constance_print_stylesheet_child();
		wp_add_inline_style( 'constance_stylecustom', $nvr_custom_css );
	}
}
add_action('wp_enqueue_scripts', 'constance_styles_child');

function constance_print_stylesheet_child(){
	global $post;

	if (is_single() || is_page()) {
		$header_url = get_field('oliver_custom_background_header', $post->ID);
		$nvr_cf_bgHeader = $header_url;

	} else if ( is_tax()) {

		$queried_object = get_queried_object();
		$term_id = $queried_object->term_id;
		$taxonomy = $queried_object->taxonomy;
		$header_url = get_field('oliver_custom_background_header', $taxonomy.'_'.$term_id);
		$nvr_cf_bgHeader = $header_url;

	} else {

		$nvr_cf_bgHeader 		= '';
	}
	

	if($nvr_cf_bgHeader){
		$nvr_outertopcss .='background-image:url('. $nvr_cf_bgHeader .');';
	}

	$nvr_print_custom_css .='#outerafterheader, .nvrlayout5 #outertop{'.$nvr_outertopcss.'}';

	return $nvr_print_custom_css;
}// end function nvr_print_stylesheet_child


// youtube embed + get_the_excerpt
global $wp_embed;
add_filter( 'get_the_excerpt', array( $wp_embed, 'run_shortcode' ), 9 );
add_shortcode( 'embed', '__return_false', 9 );
add_filter( 'get_the_excerpt', array( $wp_embed, 'autoembed' ), 9 );
$content_width = 490;

// Set notice for Free shipping start from 49.99
add_action( 'woocommerce_check_cart_items', 'spyr_set_min_total' );
function spyr_set_min_total() {
	// Only run in the Cart or Checkout pages
	if( is_cart() || is_checkout() ) {
		global $woocommerce;

		$minimum_cart_total = 49.99;

		$total = WC()->cart->subtotal;

		if( $total <= $minimum_cart_total  ) {
			$gap = $minimum_cart_total - $total;
			wc_add_notice( sprintf( 
				'<strong>You need to buy an additional %s %s to get free shipping</strong>',
				//'<strong>Free shipping start from %s %s </strong>'
				//.'<br />Current cart\'s total: %s %s',
				$gap,
				//$minimum_cart_total,
				get_option( 'woocommerce_currency'),
				$total,
				get_option( 'woocommerce_currency') ),
			'success' );
		}
	}
}

// custom js
function oliver_custom_js_child () { 
	?>
	<script type="text/javascript">

	jQuery(document).ready(function($){

		// replace header_effect function
		jQuery(window).load(function(){
			header_effect();
		});

		function header_effect(){
			"use strict";
			/*=================================== TOPSEARCH ==============================*/
			var headertext = jQuery('#headertext');
			var outerheader = jQuery('#outerheader');
			var outerheaderw = jQuery('#outerheaderwrapper');
			var outerslider = jQuery('#outerslider');
			var wpadminbar = jQuery('#wpadminbar');
			
			var headertextheight = headertext.height();
			var headertextinnerh = headertext.innerHeight();
			var adminbarinnerh = wpadminbar.innerHeight();
			var outerheaderinnerh = outerheader.innerHeight();
			var outerheadertop = outerheader.css("top");
			var windowheight = jQuery(window).height();
			var headertextoffset = headertext.offset().top;
			// var outerheaderoffset = outerheader.offset().top;
// dgamoni fix 
var outerheaderoffset = 0;

			if(jQuery('body').hasClass('nvrlayout9')!=true){
				outerheaderw.css('height',outerheaderinnerh);
			}
			
			jQuery(window).scroll(function(evt){
				var scrolltop = jQuery(document).scrollTop();
				//console.log(scrolltop);
				//console.log(outerheaderoffset);
				
				if(jQuery('body').hasClass('nvrlayout4')){
					if(scrolltop>headertextinnerh){
						headertext.addClass("sticky");
						outerheader.addClass("sticky");
						outerslider.addClass("sticky");
					}else{
						headertext.removeClass("sticky");
						outerheader.removeClass("sticky");
						outerslider.removeClass("sticky");
					}
				}else{
					
					if(scrolltop>(outerheaderoffset)){
						outerheader.addClass("sticky");
						var postopoffset = 0;
					}else{
						outerheader.removeClass("sticky");
						var postopoffset = outerheaderoffset;
					}
					if(jQuery('nav.gn-menu-wrapper').hasClass('gn-open-part') || jQuery('nav.gn-menu-wrapper').hasClass('gn-open-all')){
						var postop = postopoffset + outerheaderinnerh;
						jQuery('nav.gn-menu-wrapper').css('top', postop);
					}
				}
			});
		}

		/* Thanks to CSS Tricks for pointing out this bit of jQuery
		http://css-tricks.com/equal-height-blocks-in-rows/
		It's been modified into a function called at page load and then each time the page is resized. One large modification was to remove the set height before each new calculation. */

		equalheight = function(container){

		var currentTallest = 0,
		     currentRowStart = 0,
		     rowDivs = new Array(),
		     $el,
		     topPosition = 0;
		 $(container).each(function() {

		   $el = $(this);
		   $($el).height('auto')
		   topPostion = $el.position().top;

		   if (currentRowStart != topPostion) {
		     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
		       rowDivs[currentDiv].height(currentTallest);
		     }
		     rowDivs.length = 0; // empty the array
		     currentRowStart = topPostion;
		     currentTallest = $el.height();
		     rowDivs.push($el);
		   } else {
		     rowDivs.push($el);
		     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
		  }
		   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
		     rowDivs[currentDiv].height(currentTallest);
		   }
		 });
		}

		$(window).load(function() {
		  equalheight('body.novaro ul.products li.product');
		});


		$(window).resize(function(){
		  equalheight('body.novaro ul.products li.product');
		});

	 });// end ready

	</script>
<?php
} 
add_action( 'wp_footer', 'oliver_custom_js_child', 50 );

 // rules for delivery for size
function wc_cart_totals_shipping_html_plus_rules() {
			
	 // is longer then 70cm in cart, this method not available 
	// LV state
	$customer_state = WC()->customer->shipping_country;
	//var_dump($customer_state);
	$rules_for_delivery = false;
	$rules_for_delivery2 = false;
	$rules_for_delivery3 = false;
	$size = 71; //Latvijas pasts Latvija
	$size2 = 61; //Latvijas pasts arzemes
	$size3 = 91; //arzemes ekspress


	foreach ( WC()->cart->get_cart() as $key=>$product_cart ) {
  		$product_cart_id[$key]	=	$product_cart['product_id'];
  		$product_var_id[$key]	=	$product_cart['variation_id'];
  		$res = get_post_meta($product_cart_id[$key]);
         
  		//var_dump($product_var_id[$key]);
        //var_dump($product_cart_id[$key]);
  		//var_dump($res);

		$_product = wc_get_product($product_cart_id[$key] );
		if( $_product->is_type( 'simple' ) ) {
		 	//var_dump(' simple ');
		 	$_width  = $res['_width'][0];
			$_length = $res['_length'][0];
			$_height = $res['_height'][0];
		} elseif ( $_product->is_type( 'variable' ) ) {
			//var_dump('variable');
			$this_variation = new WC_Product( $product_var_id[$key] );
			$_width  = $this_variation->width;
			$_length = $this_variation->length;
			$_height = $this_variation->height;
		    // var_dump($this_variation->width);
		    // var_dump($this_variation->length);
		    // var_dump($this_variation->height);
		}
		 // var_dump( $res['_width'][0] );
		 // var_dump( $res['_length'][0] );
		 // var_dump( $res['_height'][0] );


		if ( ( intval($_width)>=$size ) || ( intval($_length)>=$size ) || ( intval($_height)>=$size ) ) {
			//echo ' size1 ';
			$rules_for_delivery = true;
		} else {
			//echo ' nosize1 ';

		}
		if ( ( intval($_width)>=$size2 ) || ( intval($_length)>=$size2 ) || ( intval($_height)>=$size2 ) ) {
			//echo ' size2 ';
			$rules_for_delivery2 = true;
		} else {
			//echo ' nosize2 ';

		}
		if ( ( intval($_width)>=$size3 ) || ( intval($_length)>=$size3 ) || ( intval($_height)>=$size3 ) ) {
			//echo ' size3 ';
			$rules_for_delivery3 = true;
		} else {
			//echo ' nosize3 ';
		}

	} //end foreach

	 if ( $rules_for_delivery && $customer_state == 'LV' ) {
	 		//echo ' filter -free_shipping:8","flat_rate:5 ';
	 		wc_cart_totals_shipping_html_plus_filter_array(array("free_shipping:8","flat_rate:5")); //should be added flat_rate:5
	 } else if ( $rules_for_delivery3 && $customer_state != 'LV' ) {
	 		//echo 'filter3 - flat_rate:11","flat_rate:10';
	 		//wc_cart_totals_shipping_html_plus_filter("flat_rate:11"); //overlaps filter 2
	 		wc_cart_totals_shipping_html_plus_filter_array(array("flat_rate:11","flat_rate:10"));
	 } else if ( $rules_for_delivery2 && $customer_state != 'LV' ) {
	 		//echo ' filter2 - flat_rate:10';
	 		wc_cart_totals_shipping_html_plus_filter("flat_rate:10");
	 		//wc_cart_totals_shipping_html();
	 } else {
	 		//echo 'default ';
	 		wc_cart_totals_shipping_html();
	 }
} // end rules for delivery
