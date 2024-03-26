<?php
if( ! function_exists("constance_sidebar_admin")){
	function constance_sidebar_admin(){
		$nvr_submenu_slug = 'constance-themesidebar';
		
		$nvr_optionstheme = array();
		
		$nvr_optionstheme['sidebar'] = array (
			
			array ( "name" => esc_html__("Sidebar Manager","constance"), 
					"type" => "open"),
			
			array(	"name" => esc_html__('Sidebar', "constance"),
										"type" => "heading",
										"desc" => ""),
			
			array( 	"name" => esc_html__('Sidebar Generator', "constance"),
										"desc" => esc_html__('Please enter name of new sidebar', "constance"),
										"id" => "constance_sidebar",
										"std" => "fade",
										"type" => "textarray"),
			
			array(	"type" 	=> "close"),
		);
	
		constance_form_admin($nvr_optionstheme['sidebar'], $nvr_submenu_slug);
	}
}

if ( ! function_exists( 'constance_sidebargen_menu' ) ) {
	function constance_sidebargen_menu(){
		
		$nvr_submenu_slug = "constance-themesidebar";
		$nvr_submenu_function = "constance_sidebar_admin";
		add_theme_page( esc_html__('Sidebar Manager',"constance"), esc_html__('Sidebar Manager',"constance"), 'edit_themes', $nvr_submenu_slug, $nvr_submenu_function);
		
	}
	add_action('admin_menu', 'constance_sidebargen_menu');
}