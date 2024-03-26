<?php
function constance_sidebar_init() {
	register_sidebar( array(
		'name' 					=> esc_html__('Sidebar', "constance" ),
		'id' 						=> 'constance-sidebar',
		'description' 		=> esc_html__('Located at the left/right side of all pages and post.', "constance" ),
		'before_widget' 	=> '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' 		=> '<div class="clearfix"></div></li>',
		'before_title' 		=> '<h2 class="widget-title"><span>',
		'after_title' 			=> '</span></h2>',
	));
	
	register_sidebar(array(
		'name'          => esc_html__('Woocommerce Filter Sidebar', "constance" ),
		'id'         	=> 'woofilter',
		'description'   => esc_html__('Located at the top of the product list at the shop page.', "constance" ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clearfix"></div></li>',
		'before_title' 	=> '<h4 class="widget-title"><span>',
		'after_title' 	=> '</span></h4>',
	));
	
	register_sidebar(array(
		'name'          => esc_html__('Footer1 Sidebar', "constance" ),
		'id'         	=> 'footer1',
		'description'   => esc_html__('Located at the footer column 1.', "constance" ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clearfix"></div></li>',
		'before_title' 	=> '<h4 class="widget-title"><span>',
		'after_title' 	=> '</span></h4>',
	));
	
	register_sidebar(array(
		'name'          => esc_html__('Footer2 Sidebar', "constance" ),
		'id'         	=> 'footer2',
		'description'   => esc_html__('Located at the footer column 2.', "constance" ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clearfix"></div></li>',
		'before_title' 	=> '<h4 class="widget-title"><span>',
		'after_title' 	=> '</span></h4>',
	));
	
	register_sidebar(array(
		'name'          => esc_html__('Footer3 Sidebar', "constance" ),
		'id'         	=> 'footer3',
		'description'   => esc_html__('Located at the footer column 3.', "constance" ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clearfix"></div></li>',
		'before_title' 	=> '<h4 class="widget-title"><span>',
		'after_title' 	=> '</span></h4>',
	));
	
	register_sidebar(array(
		'name'          => esc_html__('Footer4 Sidebar', "constance" ),
		'id'         	=> 'footer4',
		'description'   => esc_html__('Located at the footer column 4.', "constance" ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' 	=> '<div class="clearfix"></div></li>',
		'before_title' 	=> '<h4 class="widget-title"><span>',
		'after_title' 	=> '</span></h4>',
	));
	
	//Register dynamic sidebar
	$nvr_textarrayval = get_option( 'constance_sidebar');
	if(is_array($nvr_textarrayval)){
		
		foreach($nvr_textarrayval as $nvr_ids => $nvr_val){
			if ( function_exists('register_sidebar') )
			register_sidebar(array(
				'name'          		=> $nvr_val,
				'id'					=> $nvr_ids,
				'description'   		=> esc_html__('A Custom sidebar created from Sidebar Manager. It\'s called', "constance" )." ".$nvr_ids,
				'before_widget' 	=> '<li id="%1$s" class="widget-container %2$s">',
				'after_widget' 		=> '</li>',
				'before_title' 		=> '<h2 class="widget-title"><span>',
				'after_title' 			=> '</span></h2>'
			));
		}
		
	}
				
}
/** Register sidebars by running nvr_sidebar_init() on the widgets_init hook. */
add_action( 'widgets_init', 'constance_sidebar_init' );