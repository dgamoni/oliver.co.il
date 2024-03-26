<?php

add_action( 'after_setup_theme', 'constance_setup' );

if ( ! function_exists( 'constance_setup' ) ):

function constance_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	if ( function_exists( 'add_theme_support' ) ) { // Added in 2.9
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'woocommerce' );
		add_image_size( 'constance-blog-post-image', 900, 480, true ); // Blog Image
		add_image_size( 'constance-post-thumb', 100, 100, true ); // Recent Post Widget Image
		add_image_size( 'constance-product-big-image', 700, 700, true ); // Product Big Image
	}

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );
	
	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'gallery', 'video', 'audio' ) );
	
	// This feature allows themes to add document title tag to HTML
	add_theme_support( 'title-tag' );
	
	// Removing the sidebar in woocommerce
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
	/* 270x330 16px 11px 16px 11px*/
	/*remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );*/

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'mainmenu' => esc_html__('Main Menu', "constance" ),
		'secondarymenu' => esc_html__('Secondary Menu', "constance" )
	) );
	
	//function for woocommerce customization
	constance_woocommerce();
}
endif;

function constance_exceptation(){
	add_theme_support( 'custom-header' );
	add_theme_support( 'custom-background' );
}

/***** START - All functions, hooks, and filters for simple share buttons customization *****/
remove_filter( 'the_content', 'show_share_buttons');	
remove_filter( 'the_excerpt', 'show_share_buttons');
/***** END - All functions, hooks, and filters for simple share buttons customization *****/

if(function_exists( 'set_revslider_as_theme' )){
	add_action( 'init', 'constance_disable_autoupdate' );
	function constance_disable_autoupdate() {
		set_revslider_as_theme();
	}
}

if(function_exists('vc_set_as_theme')){
	add_action( 'vc_before_init', 'constance_vcSetAsTheme' );
	function constance_vcSetAsTheme() {
		vc_set_as_theme(true);
	}
}

function constance_current_nav_class($classes, $item) {
    $post_type = get_query_var('post_type');
	
	// Removes current_page_parent class from blog menu item
	 if (is_singular($post_type) == $post_type )
        $classes = array_diff($classes, array( 'current_page_parent' ));
	
	// This adds a current_page_parent class to the parent menu item
    if ($item->xfn != '' && $item->xfn == $post_type) {
        array_push($classes, 'current-menu-item');
    };
	
    return $classes;
}
add_filter('nav_menu_css_class', 'constance_current_nav_class', 10, 2 );

/***** START - All functions for woocommerce customization *****/
function constance_woocommerce(){
	/* Main Page Woocommerce Changes */
	add_filter( 'woocommerce_redirect_single_search_result', '__return_false' );
	add_filter('woocommerce_show_page_title', 'constance_woocommerce_show_page_title');
	add_filter('woocommerce_breadcrumb_defaults', 'constance_woocommerce_breadcrumb_defaults');
	add_filter('loop_shop_columns', 'constance_loop_shop_columns');
	add_filter('yith_wcwl_button_label','constance_wclc_wishlist_text');
	add_filter('yith-wcwl-browse-wishlist-label','constance_wclc_browse_wishlist_text');
	remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb' , 20);
	remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
	remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
    remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	
	add_action( 'woocommerce_archive_description', 'constance_woocommerce_ajax_container_start', 35 );
	add_action( 'woocommerce_archive_description', 'constance_woocommerce_top_filter_start', 39 );
	add_action( 'woocommerce_archive_description', 'constance_woocommerce_shop_category', 40 );
	add_action( 'woocommerce_archive_description', 'constance_woocommerce_searchform',44 );
	add_action( 'woocommerce_archive_description', 'constance_woocommerce_shop_filter', 45 );
	add_action( 'woocommerce_archive_description', 'constance_woocommerce_top_filter_end', 60 );
	
	/* Loop Woocommerce Changes */
	add_action( 'woocommerce_before_shop_loop', 'constance_woocommerce_loop_ulprod_wrapper_start', 70 );
	add_action( 'woocommerce_after_shop_loop', 'constance_woocommerce_loadmore_ajax',6);
	add_action( 'woocommerce_after_shop_loop', 'constance_woocommerce_loop_ulprod_wrapper_end', 9 );
	add_action( 'woocommerce_after_main_content', 'constance_woocommerce_ajax_container_end', 5 );
	
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	add_action( 'woocommerce_before_shop_loop_item', 'constance_woocommerce_loop_list_wrapper_start', 6 );
	add_action( 'woocommerce_before_shop_loop_item', 'constance_woocommerce_loop_img_wrapper_start', 7 );
	add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 10 );
    add_action( 'woocommerce_shop_loop_item_title', 'constance_woocommerce_template_loop_product_title', 10 );
	add_action( 'woocommerce_before_shop_loop_item', 'constance_woocommerce_template_loop_product_thumblink_start', 17 );
	add_action( 'woocommerce_before_shop_loop_item', 'constance_woocommerce_template_loop_product_thumbnail', 18 );
	add_action( 'woocommerce_before_shop_loop_item', 'constance_woocommerce_template_loop_product_thumblink_end', 19 );
	if(function_exists('yith_wishlist_constructor')){
		add_action( 'woocommerce_before_shop_loop_item', 'constance_woocommerce_loop_wishlist', 21 );
	}
	add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_rating', 26 );
	add_action( 'woocommerce_before_shop_loop_item', 'constance_woocommerce_loop_img_wrapper_end', 29 );
	add_action( 'woocommerce_before_shop_loop_item', 'constance_woocommerce_loop_text_wrapper_start', 32 );
	add_action( 'woocommerce_before_shop_loop_item', 'constance_woocommerce_product_categories', 35 );
	
	add_action( 'woocommerce_after_shop_loop_item', 'constance_woocommerce_loop_price_wrapper_start', 6 );
	add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 7 );
	add_action( 'woocommerce_after_shop_loop_item', 'constance_woocommerce_loop_price_wrapper_end', 20 );
	add_action( 'woocommerce_after_shop_loop_item', 'constance_woocommerce_loop_text_wrapper_end', 22 );
	add_action( 'woocommerce_after_shop_loop_item', 'constance_woocommerce_loop_list_wrapper_end', 24 );
	
	/* Single Product Page changes*/
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
	add_action( 'woocommerce_after_single_product_summary', 'constance_woocommerce_product_tab_wrapper_start', 8 );
	add_action( 'woocommerce_after_single_product_summary', 'constance_woocommerce_product_tab_wrapper_end', 12 );
	add_action( 'woocommerce_after_single_product_summary', 'constance_woocommerce_upsell_display', 15 );
	/*
	add_action( 'woocommerce_after_single_product_summary', 'constance_woocommerce_product_related_wrapper_start', 18 );
	add_action( 'woocommerce_after_single_product_summary', 'constance_woocommerce_product_related_wrapper_end', 22 );
	add_action( 'woocommerce_after_single_product_summary', 'constance_woocommerce_product_upsell_wrapper_start', 13 );
	add_action( 'woocommerce_after_single_product_summary', 'constance_woocommerce_product_upsell_wrapper_end', 17 );
	*/
	add_filter( 'woocommerce_output_related_products_args', 'constance_woocommerce_output_related_products_args' );
	
}

function constance_woocommerce_show_page_title(){
	return false;
}

function constance_woocommerce_breadcrumb_defaults(){
	return array(
		'delimiter'   => ' &nbsp;&#47;&nbsp; ',
		'wrap_before' => '<nav class="nvr-breadcrumb" itemprop="breadcrumb">',
		'wrap_after'  => '</nav>',
		'before'      => '',
		'after'       => '',
		'home'        => _x( 'Home', 'breadcrumb', 'woocommerce' ),
	);
}

function constance_loop_shop_columns(){
	
	$nvr_pid = constance_get_postid();
	$nvr_custom = constance_get_customdata($nvr_pid);
	
	$nvr_pagelayout = constance_get_sidebar_position($nvr_pid);
	
	if($nvr_pagelayout!='one-col'){
		$nvr_return = 4;
	}else{
		$nvr_return = 4;
	}
	return $nvr_return;
}

function constance_woocommerce_use_masonry(){
	
	$nvr_shopmasonry = constance_get_option( 'constance_shop_masonry' ,'0');
	if(isset($_GET['masonry']) && $_GET['masonry']=='true'){
		$nvr_shopmasonry = '1';
	}
	$nvr_shopmasonry = ($nvr_shopmasonry=='1')? true : false;
	return $nvr_shopmasonry;
}

function constance_wclc_wishlist_text($nvr_return=''){
	
		$nvr_return = '<span class="nvr_wishlist_text">'.$nvr_return.'</span>';
	
	return $nvr_return;
}

function constance_wclc_browse_wishlist_text($nvr_return=''){
	
	$nvr_returnori = $nvr_return;
	$nvr_return = '<i class="fa fa-heart"></i>' ;
	if(is_single()){
		$nvr_return .= ' '.esc_html__('ADDED!', "constance");
	}else{
		$nvr_return .= ' <span class="nvr_wishlist_text">'.$nvr_returnori.'</span>';
	}
	return $nvr_return;
}

function constance_woocommerce_ajax_container_start(){
	
	$nvr_shopajax = constance_get_option( 'constance_shop_ajax' ,'0');
	$nvr_shopajax = ($nvr_shopajax=="1")? true : false;
	
	if($nvr_shopajax){
		echo '<div id="nvrajaxshop" class="nvrshopcontainer">';
	}else{
		echo '<div id="nvrnonajaxshop" class="nvrshopcontainer">';
	}
}

function constance_woocommerce_ajax_container_end(){
	echo '<div class="clearfix"></div></div>';
}

function constance_woocommerce_top_filter_start(){
	echo '<div class="topproductfiltercontainer">';
}

function constance_woocommerce_shop_category(){
	
	$nvr_shopmasonry = constance_woocommerce_use_masonry();
	
	$nvr_shopfilter = constance_get_option( 'constance_shop_filter');
	if(isset($_GET['prodfilter']) && $_GET['prodfilter']=='true'){
		$nvr_shopfilter = '1';
	}
 	$nvr_shopfilter = ( $nvr_shopfilter=="1" && $nvr_shopmasonry)? true : false;
	
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

function constance_woocommerce_shop_filter(){
	
	if(is_active_sidebar( 'woofilter' )){
		echo '<div id="widget-filter-container" class="one_eight columns">';
			echo '<a href="#" id="widget-filter-button"><i class="fa fa-filter"></i><i class="fa fa-close"></i> <span class="filterword">'.esc_html__('Filter', 'constance').'</span><span class="closeword">'.esc_html__('Close', 'constance').'</span></a>';
			echo '<div class="widget-area">';
				echo '<div class="widget-nvr-woofilter">';
					echo '<ul>';
					if(!dynamic_sidebar( 'woofilter' ) ){}
					echo '</ul>';
					echo '<div class="clearfix"></div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}	
}

function constance_woocommerce_searchform(){
    $nvr_shopsearch = constance_get_option( 'constance_disable_topsearch');
    $nvr_shopsearch = ( $nvr_shopsearch=="1")? true : false;
	if(!$nvr_shopsearch){
        echo constance_searchform("","searchbox columns");
    }
}

function constance_woocommerce_top_filter_end(){
	echo '<div class="clearfix"></div></div>';
}

function constance_woocommerce_loop_ulprod_wrapper_start(){
	
	$nvr_shopmasonry = constance_woocommerce_use_masonry();
	if($nvr_shopmasonry){
		$nvr_wrapclass = 'nvr-productmasonry';
	}else{
		$nvr_wrapclass = '';
	}
	echo '<div class="'.$nvr_wrapclass.' prodlist-col nvr-prodcol1">';
}

function constance_woocommerce_loop_ulprod_wrapper_end(){
	echo '</div>';
}

function constance_woocommerce_loop_list_wrapper_start(){
	echo '<div class="nvr-productitem">';
}

function constance_woocommerce_loop_list_wrapper_end(){
	echo '</div>';
}

function constance_woocommerce_loop_img_wrapper_start(){
	echo '<div class="nvr-productloop-img">';
	echo '<span class="nvr-featuredbadge">'.esc_html__('Featured', "constance").'</span>';
}

function constance_woocommerce_loop_wishlist(){
	global $product;
	
	update_option('yith_wcwl_add_to_wishlist_icon', 'fa-heart');
	echo '<div class="btnloop nvr_wishlist">'.do_shortcode('[yith_wcwl_add_to_wishlist]').'</div>';
}

function constance_woocommerce_loop_quickview(){
	global $product;
	$nvr_nonce = wp_create_nonce("constance_quickviewproduct_nonce");
    $nvr_ajaxlink = admin_url('admin-ajax.php?ajax=true&amp;action=constance_quickviewproduct&amp;post_id='.$product->id.'&amp;nonce='.$nvr_nonce);
    echo '<a href="'. esc_url( $nvr_ajaxlink ) .'" data-rel="quickview" class="btnloop nvr_quickview">'.esc_html__('Quickview', 'constance').'</a>';
}

function constance_woocommerce_loop_img_wrapper_end(){
	echo '</div>';
}

function constance_woocommerce_template_loop_product_title() {
	echo '<a href="'.esc_url( get_permalink() ).'"><h3>' . get_the_title() . '</h3></a>';
}

function constance_woocommerce_loop_text_wrapper_start(){
	echo '<div class="nvr-productloop-text"><div class="nvr-pl-texttable"><div class="nvr-pl-textcell">';
}

function constance_woocommerce_loop_price_wrapper_start(){
	echo '<div class="nvr-productloop-price">';
}

function constance_woocommerce_loop_price_wrapper_end(){
	echo '<div class="clearfix"></div></div>';
}

function constance_woocommerce_loop_text_wrapper_end(){
	echo '<div class="clearfix"></div></div></div></div>';
}

function constance_woocommerce_loop_btn_wrapper_start(){
	echo '<div class="btn_container">';
}

function constance_woocommerce_loop_btn_wrapper_end(){
	echo '<div class="clearfix"></div></div>';
}

function constance_woocommerce_template_loop_product_thumblink_start(){
	echo '<a href="'.get_permalink().'">';
}

function constance_woocommerce_template_loop_product_thumbnail(){
	global $product;
	echo woocommerce_get_product_thumbnail();
}

function constance_woocommerce_template_loop_product_thumblink_end(){
	echo '</a>';
}

function constance_woocommerce_loadmore_ajax(){
	
	$nvr_shopmasonry = constance_woocommerce_use_masonry();
	
	$nvr_infscrolls = constance_get_option( 'constance_shop_infscrolls');
	if(isset($_GET['infinitescroll']) && $_GET['infinitescroll']=='true'){
		$nvr_infscrolls = '1';
	}
 	$nvr_infscrolls = ( $nvr_infscrolls=="1" && $nvr_shopmasonry)? true : false;
	if( $nvr_infscrolls ){
		echo '<div id="loadmore-paging">';
			echo '<div class="loadmorebutton">';
				next_posts_link( esc_html__('Load More', "constance" ) );
			echo '</div>';
		echo '</div>';
		remove_action('woocommerce_after_shop_loop','woocommerce_pagination',10);
	}
}

function constance_woocommerce_product_categories(){
	global $product;
	echo '<div class="nvr-productcat">';
		the_terms( $product->id, 'product_cat', '', ', ' );
	echo '</div>';
}

function constance_woocommerce_product_tab_wrapper_start(){
	echo '<div class="stripecontainer fullwidth onproducttab"><div class="stripewrapper"><div class="container">';
}

function constance_woocommerce_product_tab_wrapper_end(){
	echo '<div class="clearfix"></div></div></div></div>';
}

function constance_woocommerce_product_related_wrapper_start(){
	echo '<div class="stripecontainer fullwidth onrelatedproduct"><div class="stripewrapper">';
}

function constance_woocommerce_output_related_products_args() {
  global $product;
	
	$args = array(
		'posts_per_page' => 3,
		'columns' => 3,
		'orderby' => 'rand'
	);
	return $args;
}

function constance_woocommerce_product_related_wrapper_end(){
	echo '<div class="clearfix"></div></div></div>';
}

function constance_woocommerce_product_upsell_wrapper_start(){
	echo '<div class="stripecontainer fullwidth onupsellproduct"><div class="stripewrapper">';
}

function constance_woocommerce_upsell_display(){
	woocommerce_upsell_display( 4, 4);
}

function constance_woocommerce_product_upsell_wrapper_end(){
	echo '<div class="clearfix"></div></div></div>';
}
/***** END - All functions for woocommerce customization *****/

function constance_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $nvr_plugins = array(
		/*
        // This is an example of how to include a plugin pre-packaged with a theme.
        array(
            'name'               => 'Contact Form 7', // The plugin name.
            'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),

        // This is an example of how to include a plugin from a private repo in your theme.
        array(
            'name'               => 'TGM New Media Plugin', // The plugin name.
            'slug'               => 'tgm-new-media-plugin', // The plugin slug (typically the folder name).
            'source'             => 'https://s3.amazonaws.com/tgm/tgm-new-media-plugin.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'external_url'       => 'https://github.com/thomasgriffin/New-Media-Image-Uploader', // If set, overrides default API URL and points to an external URL.
        ),
		*/
        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name'      => 'Redux Framework',
            'slug'      => 'redux-framework',
            'required'  => true,
        ),
		array(
            'name'      => 'Woocommerce',
            'slug'      => 'woocommerce',
            'required'  => true,
        ),
		array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => true,
        ),
		array(
            'name'      => 'Novaro Portfolio',
            'slug'      => 'novaro-portfolio',
            'source'	=> get_stylesheet_directory() . '/engine/plugins/novaro-portfolio.zip',
			'required'  => true,
        ),
		array(
            'name'      => 'Novaro Testimonial',
            'slug'      => 'novaro-testimonial',
            'source'	=> get_stylesheet_directory() . '/engine/plugins/novaro-testimonial.zip',
			'required'  => true,
        ),
		array(
            'name'      => 'Novaro Brand',
            'slug'      => 'novaro-brand',
			'source'	=> get_stylesheet_directory() . '/engine/plugins/novaro-brand.zip',
            'required'  => true,
        ),
		array(
            'name'      => 'Novaro People',
            'slug'      => 'novaro-people',
			'source'	=> get_stylesheet_directory() . '/engine/plugins/novaro-people.zip',
            'required'  => true,
        ),
		array(
            'name'      => 'Novaro Slider',
            'slug'      => 'novaro-slider',
			'source'	=> get_stylesheet_directory() . '/engine/plugins/novaro-slider.zip',
            'required'  => true,
        ),
		array(
            'name'      => 'Novaro Essential Shortcodes',
            'slug'      => 'novaro-shortcodes',
			'source'	=> get_stylesheet_directory() . '/engine/plugins/novaro-shortcodes.zip',
            'required'  => true,
        ),
		array(
            'name'      => 'Wordpress Importer',
            'slug'      => 'wordpress-importer',
            'required'  => true,
        ),
		array(
            'name'      => 'Mail Poet',
            'slug'      => 'wysija-newsletters',
            'required'  => false,
        ),
		array(
            'name'      => 'Enjoy Instagram',
            'slug'      => 'enjoy-instagram-instagram-responsive-images-gallery-and-carousel',
            'required'  => false,
        ),
		array(
            'name'      => 'Really Simple CAPTCHA',
            'slug'      => 'really-simple-captcha',
            'required'  => false,
        ),
		array(
            'name'      => 'WP Retina 2x',
            'slug'      => 'wp-retina-2x',
            'required'  => false,
        ),
		array(
            'name'      => 'Regenerate Thumbnails',
            'slug'      => 'regenerate-thumbnails',
            'required'  => false,
        ),
		array(
            'name'      => 'Flickr Photos',
            'slug'      => 'simple-flickr-plugin',
            'required'  => false,
        ),
		array(
            'name'      => 'YITH WooCommerce Wishlist',
            'slug'      => 'yith-woocommerce-wishlist',
            'required'  => true,
        ),
		

    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $nvr_config = array(
        'id'           => 'novaro',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => esc_html__('Install Required Plugins', "constance" ),
            'menu_title'                      => esc_html__('Install Plugins', "constance" ),
            'installing'                      => esc_html__('Installing Plugin: %s', "constance" ), // %s = plugin name.
            'oops'                            => esc_html__('Something went wrong with the plugin API.', "constance" ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', "constance" ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', "constance" ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', "constance" ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', "constance" ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', "constance" ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', "constance" ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', "constance" ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', "constance" ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', "constance" ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', "constance" ),
            'return'                          => esc_html__('Return to Required Plugins Installer', "constance" ),
            'plugin_activated'                => esc_html__('Plugin activated successfully.', "constance" ),
            'complete'                        => esc_html__('All plugins installed and activated successfully. %s', "constance" ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $nvr_plugins, $nvr_config );

}
add_action( 'tgmpa_register', 'constance_register_required_plugins' );