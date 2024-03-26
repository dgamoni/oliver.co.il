<?php

/*********For Localization**************/
add_action('after_setup_theme', 'constance_load_textdomain');
function constance_load_textdomain(){
	load_theme_textdomain( "constance", get_template_directory().'/languages' );
	load_theme_textdomain( "constance", get_stylesheet_directory().'/languages' );
}
/*********End For Localization**************/

if( !function_exists('constance_register_font') ){
	function constance_register_font ( $nvr_sectionName ) {		
		$nvr_got_font = constance_get_option($nvr_sectionName);
		
		if ($nvr_got_font!="0" && $nvr_got_font!='') {
			$nvr_font_pieces = explode(":", $nvr_got_font);
			
			$nvr_font_name = $nvr_font_pieces[0];
			$nvr_font_name = str_replace (" ","+", $nvr_font_pieces[0] );
			
			if( isset($nvr_font_pieces[1]) ){
				$nvr_font_variants = $nvr_font_pieces[1];
				$nvr_font_variants = ":" . str_replace ("|",",", $nvr_font_pieces[1] );
			}else{
				$nvr_font_variants = "";
			}
			
			wp_register_style( $nvr_sectionName, '//fonts.googleapis.com/css?family='.$nvr_font_name . $nvr_font_variants );
			return true;
		}else{
			return false;
		}
		
	}
}

// The excerpt based on character
if(!function_exists("constance_string_limit_char")){
	function constance_string_limit_char($nvr_excerpt, $nvr_substr=0, $nvr_strmore = "..."){
		$nvr_string = strip_tags(str_replace('...', '', $nvr_excerpt));
		if ($nvr_substr>0) {
			$nvr_string = substr($nvr_string, 0, $nvr_substr);
		}
		if(strlen($nvr_excerpt)>=$nvr_substr){
			$nvr_string .= $nvr_strmore;
		}
		return $nvr_string;
	}
}
// The excerpt based on words
if(!function_exists("constance_string_limit_words")){
	function constance_string_limit_words($nvr_string, $nvr_word_limit){
	  $nvr_words = explode(' ', $nvr_string, ($nvr_word_limit + 1));
	  if(count($nvr_words) > $nvr_word_limit)
	  array_pop($nvr_words);
	  
	  return implode(' ', $nvr_words);
	}
}

if ( ! isset( $content_width ) )
	$content_width = 610;


/* Remove inline styles printed when the gallery shortcode is used.*/
function constance_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'constance_remove_gallery_css' );

if(!function_exists('constance_readsocialicon')){
	function constance_readsocialicon(){
		$nvr_opt_social_icons_path = get_template_directory() . '/images/social/';
		$nvr_optSocialIcons = array();
		
		if ( is_dir($nvr_opt_social_icons_path) ) {
			if ($nvr_opt_social_icons_dir = opendir($nvr_opt_social_icons_path) ) { 
				$nvr_optSocialIcons[] = "None";
				while ( ($nvr_opt_social_icons_file = readdir($nvr_opt_social_icons_dir)) !== false ) {
					if(stristr($nvr_opt_social_icons_file, ".png") !== false && stristr($nvr_opt_social_icons_file, "@2x.") === false) {
						$nvr_optSocialIcons[$nvr_opt_social_icons_file] = $nvr_opt_social_icons_file;
					}
				}    
			}
		}
		return $nvr_optSocialIcons;
	}
}

if(!function_exists('constance_fontsocialicon')){
	function constance_fontsocialicon(){
		$nvr_optSocialIcons = array(
			'fa-dribbble' => 'Dribbble',
			'fa-facebook' => 'Facebook',
			'fa-flickr' => 'Flickr',
			'fa-foursquare' => 'Foursquare',
			'fa-github' => 'Github',
			'fa-google-plus' => 'Google Plus',
			'fa-instagram' => 'Instagram',
			'fa-linkedin' => 'LinkedIn',
			'fa-pinterest' => 'Pinterest',
			'fa-skype' => 'Skype',
			'fa-tumblr' => 'Tumblr',
			'fa-twitter' => 'Twitter',
			'fa-vimeo-square' => 'Vimeo',
			'fa-youtube' => 'Youtube'
		);
		
		
		return $nvr_optSocialIcons;
	}
}

/*Prints HTML with meta information for the current post (category, tags and permalink).*/
if ( ! function_exists( 'constance_posted_in' ) ) :
function constance_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$nvr_tag_list = get_the_tag_list( '', ', ' );
	if ( $nvr_tag_list ) {
		$nvr_posted_in = wp_kses( __( 'Categories: %1$s <br/> Tags: %2$s', "constance" ), array( "br" => array() ) );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$nvr_posted_in = esc_html__( 'Categories: %1$s', "constance" );
	} else {
		$nvr_posted_in = "";
	}
	// Prints the string, replacing the placeholders.
	printf(
		$nvr_posted_in,
		get_the_category_list( ', ' ),
		$nvr_tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;

/*Clearing the automatic paragraphs and breaks on shortcodes that WordPress is adding automatically when filtering content.*/
function constance_content_formatter($nvr_content) { 
	$nvr_content = do_shortcode(shortcode_unautop($nvr_content)); 
	$nvr_content = preg_replace('#^<\/p>|^<br \/>|<p>$#', '', $nvr_content);
	$nvr_content = str_replace('<br />', '', $nvr_content);
	$nvr_content = str_replace('<p><div', '<div', $nvr_content);
	return $nvr_content;
}

/* for top menu */
function nav_page_fallback() {
if(is_front_page()){$nvr_class="current_page_item";}else{$nvr_class="";}
print '<ul class="topnav sf-menu"><li class="'.esc_attr( $nvr_class ).'"><a href=" '.esc_url( home_url( '/') ).' " title=" '.esc_attr__('Click for Home',"constance").' ">'.esc_html__('Home',"constance").'</a></li>';
    wp_list_pages( 'title_li=&sort_column=menu_order&depth=1' );
print '</ul>';
}

function nav_2nd_fallback() {
	print '';
}

/* for shortcode widget  */
add_filter('widget_text', 'do_shortcode');

function constance_change_posttype() {
  if( is_tax('portfoliocat') && !is_admin() ) {
    set_query_var( 'post_type', array( 'post', 'portofolio' ) );
  }
  return;
}
add_action( 'parse_query', 'constance_change_posttype' );

if( !function_exists('constance_check_pagepost')){
	function constance_check_pagepost(){
		global $post;
		
		if( is_404() || is_archive() || is_attachment() || is_search() ){
			$nvr_custom = false;
		}else{
			$nvr_custom = true;
		}
		
		return $nvr_custom;
	}
}

if( !function_exists('constance_get_postid')){
	function constance_get_postid(){
		global $post;
		
		if( is_home() ){
			$nvr_pid = get_option('page_for_posts');
		}elseif( function_exists( 'is_woocommerce' ) && is_shop() ){
			$nvr_pid = (function_exists('wc_get_page_id'))? wc_get_page_id('shop') : woocommerce_get_page_id( 'shop' );
		}elseif( function_exists( 'is_woocommerce' ) && is_product_category() ){
			$nvr_pid = (function_exists('wc_get_page_id'))? wc_get_page_id('shop') : woocommerce_get_page_id( 'shop' );
		}elseif( function_exists( 'is_woocommerce' ) && is_product_tag() ){
			$nvr_pid = (function_exists('wc_get_page_id'))? wc_get_page_id('shop') : woocommerce_get_page_id( 'shop' );
		}elseif(!constance_check_pagepost()){
			$nvr_pid = 0;
		}else{
			$nvr_pid = get_the_ID();
		}
		
		return $nvr_pid;
	}
}

if( !function_exists('constance_get_customdata')){
	function constance_get_customdata($nvr_pid=""){
		global $post;
		
		if($nvr_pid!=""){
			$nvr_custom = get_post_custom($nvr_pid);
			return $nvr_custom;
		}
		
		if($nvr_pid==""){
			$nvr_pid = constance_get_postid();
		}

		if( constance_check_pagepost() ){
			$nvr_custom = get_post_custom($nvr_pid);
		}else{
			$nvr_custom = array();
		}
		
		return $nvr_custom;
	}
}

if( !function_exists('constance_get_bodycontainer')){
	function constance_get_bodycontainer(){
		$nvr_txtContainerWidth = intval( constance_get_option( 'constance_container_width') );
		if($nvr_txtContainerWidth<940){
			$nvr_txtContainerWidth = 940;
		}elseif($nvr_txtContainerWidth >1200){
			$nvr_txtContainerWidth = 1200;
		}
		return $nvr_txtContainerWidth;
	}
}

if( !function_exists('constance_update_option')){
	function constance_update_coption($key,$value){
		
		$nvr_arrval = array(
			$key => $value
		);
		if(get_option( 'constance' )){
			$nvr_options = get_option('constance');
			$nvr_options[$key] = $value;
			update_option('constance', $nvr_options);
		}else{
			add_option('constance', $nvr_arrval);
		}
	}
}

if( !function_exists('constance_use_coption')){
	function constance_get_coption($key){
		
		$nvr_options = get_option( 'constance' );
		if ( isset( $nvr_options[$key] ) ) {
			return $nvr_options[$key];
		}
		return false;
	}
}

if(!function_exists('constance_get_option')){
	function constance_get_option( $nvr_name, $nvr_default = false ) {
		global $nvr_option;
		$nvr_config = $nvr_option;
		if ( !isset($nvr_config[$nvr_name]) ) {
			return $nvr_default;
		}

		if ( isset( $nvr_config[$nvr_name] ) ) {
			return $nvr_config[$nvr_name];
		}
	
		return $nvr_default;
	}
}

if ( !function_exists( 'constance_nav_update' ) ) {
	function constance_nav_update( $menu_id, $menu_item_db_id, $args ) {
		global $constance_mega_menu;
		$options_array = constance_menu_options_array();
		foreach ( $options_array as $value ) {
			if ( isset ( $_REQUEST[ 'menu-item-' . $value['key'] ][ $menu_item_db_id ] ) ) {
				$variable = $_REQUEST[ 'menu-item-' . $value['key'] ][ $menu_item_db_id ];
				/* Clean submenu options if menu-item-parent-id not 0 (if depth > 0) */
				if ( $_REQUEST[ 'menu-item-parent-id' ][ $menu_item_db_id ] != '0' && substr_count( $value['key'], 'submenu' ) ) {
					$variable = '';
				}
				update_post_meta( $menu_item_db_id, $value['key'], $variable );
			} else {
				update_post_meta( $menu_item_db_id, $value['key'], '' );
			}
		}
	}
	add_action( 'wp_update_nav_menu_item', 'constance_nav_update', 2014, 5 );
}

if ( !function_exists( 'constance_mega_menu_backend_walker' ) ) {
	function constance_mega_menu_backend_walker( $walker, $menu_id ) {
		return 'Constance_Mega_Menu_Backend_Walker';
	}
	add_filter( 'wp_edit_nav_menu_walker', 'constance_mega_menu_backend_walker', 2014, 5 );
}

if ( !function_exists( 'constance_menu_options_array' ) ) {
	function constance_menu_options_array(){
		global $constance_mega_menu;

		/* Submenu types */
		$submenu_types = array(
			esc_html__( 'Standard Dropdown', "constance" ) => 'default_dropdown',
			esc_html__( 'Multicolumn Dropdown', "constance" ) => 'multicolumn_dropdown',
		);

		/* options */
		$options = array(
				array(
					'name' => esc_html__( 'Options of Dropdown', "constance" ),
					'descr' => esc_html__( 'Submenu Type', "constance" ),
					'key' => 'submenu_type',
					'type' => 'select',
					'values' => $submenu_types,
/*
					'dependency' => array(
						'element' =>'submenu_post_type',
						'value' => 'post_type_dropdown',
					),
*/
			   ),
			   array(
					'descr' => esc_html__( 'Icon Class (you can use font awesome or line icon class)', "constance" ),
					'key' => 'item_icon',
					'values' => '',
				),
				array(
					'descr' => esc_html__( 'Submenu Columns (Not For Standard Drops)', "constance" ),
					'key' => 'submenu_columns',
					'type' => 'select',
					'values' => range(1, 5),
				),
				array(
					'key' => 'submenu_enable_full_width',
					'type' => 'checkbox',
					'values' => array(
						esc_html__( 'Enable Full Width Dropdown (only for horizontal menu)', "constance" ) => 'true',
					),
				),
				array(
					'name' => esc_html__( 'Dropdown Background Image', "constance" ),
					'descr' => "",
					'key' => 'submenu_bg_image',
					'type' => 'background_image',
					'default' => '',
				),
		);
		return $options;
	}
}

if ( !function_exists( 'constance_options_generator' ) ){ 

	function constance_options_generator( $option, $mm_saved_value = false, $current_class = 'none' ){
		if ( is_string( $current_class ) || $current_class == 'none' ) {
			return false;
		}
		/* Check and set all most variables */
		$option['name'] = isset( $option['name'] ) ? $option['name'] : '';
		$option['descr'] = isset( $option['descr'] ) ? $option['descr'] : '';
		$option['key'] = isset( $option['key'] ) ? $option['key'] : 'key_no_set';
		$option['type'] = isset( $option['type'] ) ? $option['type'] : '';
		$option['values'] = isset( $option['values'] ) ? $option['values'] : '';
		$clear_full_key = $option['key'];
		$out = '';
		/* check field "type" and return actual sting */
		switch ( $option['type'] ) {
			case 'checkbox':
				$col_width = isset( $option['col_width'] ) ? $option['col_width'] : 4;
				$out .= '<input type="hidden" name="' . esc_attr( $option['key'] ) . '[]" value="is_checkbox" />';
				$out .= '<div class="row">';
				if ( is_array( $option['values'] ) ) {
					foreach ( $option['values'] as $key => $value ) {
						$out .= '<div class="mm_checkbox col-xs-' . esc_attr( $col_width ) . '">';
						$out .= '<label><input type="checkbox" class="wpb_vc_param_value" name="' . esc_attr( $option['key'] ) . '[]" value="' . esc_attr( $value ) .'" ' . ( ( isset( $mm_saved_value ) && is_array( $mm_saved_value ) ) 
							? ( in_array( $value, $mm_saved_value ) 
								? 'checked="checked" ' 
								: ''
							)
							: ( (  isset( $option['default'] ) && ( in_array( $value, $option['default'] ) || $value == $option['default'] ) ) 
								? 'checked="checked" ' 
								: ''
							)
						) . '/>' . ( is_string( $key ) ? $key : $value ) .'</label>';
						$out .= '</div>';
					}
				}
				$out .= '</div>';
				break;
			case 'select':
				$out .= '<select class="col-xs-12 form-control input-sm wpb_vc_param_value" name="' . esc_attr( $option['key'] ) . '">';
				if ( is_array( $option['values'] ) ) {
					foreach ( $option['values'] as $key => $value ) {
						$out .= '<option value="' . esc_attr( $value ) .'" ' . ( ( isset( $mm_saved_value ) && $mm_saved_value !== false ) 
							? ( $value == $mm_saved_value 
								? 'selected="selected" ' 
								: ''
							)
							: ( (  isset( $option['default'] ) && ( ( is_array( $option['default'] ) && in_array( $value, $option['default'] ) ) || $value == $option['default'] ) ) 
								? 'selected="selected" ' 
								: ''
							)
						) . '>' . ( is_string( $key ) ? $key : $value ) .'</option>';
					}
				}
				$out .= '</select>';
				break;
			case 'background_image':
				// below calls scripts and styles for media library uploader.
				if ( !isset( $theme_option_file ) ) {
					static $theme_option_file = 1;
					wp_enqueue_script('media-upload');
					wp_enqueue_script('thickbox');
					wp_enqueue_script('jquery');
					wp_enqueue_style('thickbox');
				}

				$out .= '<div class="row background_image_selcetor">';
				$out .= '<div class="input-group input-group-sm col-xs-9">';
				$out .= '<input class="upload form-control col-xs-8" type="text" name="' . esc_attr( $option['key'] ) . '[background_image]" value="' . ( ( isset( $mm_saved_value['background_image'] ) && $mm_saved_value['background_image'] !== false ) 
											? $mm_saved_value['background_image'] 
											: ( isset( $option['default']['background_image'] ) 
												? esc_attr( $option['default']['background_image'] )  
												: ( isset( $option['values']['background_image'] ) 
													? $option['values']['background_image'] 
													: ''
												)
											) 
				) . '" />';
				/*  name="' . $option['key'] . '" */
				$out .= '<span class="input-group-btn">';
				$out .= '<input class="' . esc_attr( $clear_full_key ) . ' select_file_button btn btn-primary" type="button" value="' . esc_attr__( 'Select Image', "constance" ) . '" />';
				$out .= '</span><!-- class="input-group-btn" -->';
				$out .= '</div><!-- class="input-group" -->';
				$out .= '<div class="col-xs-3">';
				$out .= '<img class="img_preview" data-imgprev="' . esc_attr( $clear_full_key ) . '" src="' . ( ( isset( $mm_saved_value['background_image'] ) ) 
											? $mm_saved_value['background_image'] 
											: ( isset( $option['default']['background_image'] ) 
												? esc_attr( $option['default']['background_image'] )  
												: ( isset( $option['values']['background_image'] ) 
													? $option['values']['background_image'] 
													: ''
												)
											) 
				) . '" />';
				$out .= '</div><!-- class="col-xs-3" -->';
				$out .= '<div class="col-xs-12 pull-left">&nbsp;';
				$out .= '</div><!-- class="col-xs-12" -->';
				$out .= '<div class="col-xs-3">';
				$out .= '<select class="col-xs-12 form-control input-sm" name="' . esc_attr( $option['key'] ) . '[background_repeat]">';
				foreach ( array('repeat','no-repeat','repeat-x','repeat-y') as $key => $value ) {
					$out .= '<option value="' . esc_attr( $value ) .'" ' . ( ( isset( $mm_saved_value['background_repeat'] ) && $mm_saved_value['background_repeat'] !== false ) 
						? ( $value == $mm_saved_value['background_repeat'] 
							? 'selected="selected" ' 
							: ''
						)
						: ( ( isset( $option['default']['background_repeat'] ) && $value == $option['default']['background_repeat'] ) 
							? 'selected="selected" ' 
							: ''
						)
					) . '>' . ( is_string( $key ) ? $key : $value ) .'</option>';
				}
				$out .= '</select>';
				$out .= '</div><!-- class="col-xs-3" -->';
				$out .= '<div class="col-xs-3">';
				$out .= '<select class="col-xs-12 form-control input-sm" name="' . esc_attr( $option['key'] ) . '[background_attachment]">';
				foreach ( array('scroll','fixed') as $key => $value ) {
					$out .= '<option value="' . esc_attr( $value ) .'" ' . ( ( isset( $mm_saved_value['background_attachment'] ) && $mm_saved_value['background_attachment'] !== false ) 
						? ( $value == $mm_saved_value['background_attachment'] 
							? 'selected="selected" ' 
							: ''
						)
						: ( ( isset( $option['default']['background_attachment'] ) && $value == $option['default']['background_attachment'] ) 
							? 'selected="selected" ' 
							: ''
						)
					) . '>' . ( is_string( $key ) ? $key : $value ) .'</option>';
				}
				$out .= '</select>';
				$out .= '</div><!-- class="col-xs-3" -->';
				$out .= '<div class="col-xs-3">';
				$out .= '<select class="col-xs-12 form-control input-sm" name="' . esc_attr( $option['key'] ) . '[background_position]">';
				foreach ( array('center','center left','center right','top left','top center','top right','bottom left','bottom center','bottom right') as $key => $value ) {
					$out .= '<option value="' . esc_attr( $value ) .'" ' . ( ( isset( $mm_saved_value['background_position'] ) && $mm_saved_value['background_position'] !== false ) 
						? ( $value == $mm_saved_value['background_position'] 
							? 'selected="selected" ' 
							: ''
						)
						: ( ( isset( $option['default']['background_position'] ) && $value == $option['default']['background_position'] ) 
							? 'selected="selected" ' 
							: ''
						)
					) . '>' . ( is_string( $key ) ? $key : $value ) .'</option>';
				}
				$out .= '</select>';
				$out .= '</div><!-- class="col-xs-3" -->';
				$out .= '<div class="col-xs-3">';
				$out .= '<select class="col-xs-12 form-control input-sm" name="' . esc_attr( $option['key'] ) . '[background_size]">';
				foreach ( array( esc_html__( 'Keep original', "constance" ) => 'auto', esc_html__( 'Stretch to width', "constance" ) => '100% auto', esc_html__( 'Stretch to height', "constance" ) => 'auto 100%','cover','contain') as $key => $value ) {
					$out .= '<option value="' . esc_attr( $value ) .'" ' . ( ( isset( $mm_saved_value['background_size'] ) && $mm_saved_value['background_size'] !== false ) 
						? ( $value == $mm_saved_value['background_size'] 
							? 'selected="selected" ' 
							: ''
						)
						: ( ( isset( $option['default']['background_size'] ) && $value == $option['default']['background_size'] ) 
							? 'selected="selected" ' 
							: ''
						)
					) . '>' . ( is_string( $key ) ? $key : $value ) .'</option>';
				}
				$out .= '</select>';
				$out .= '</div><!-- class="col-xs-3" -->';
				$out .= '</div><!-- class="row" -->';
				break;
			default /* 'textfield' */:
				$out .= '<input class="col-xs-12 form-control input-sm wpb_vc_param_value" type="text" name="' . esc_attr( $option['key'] ) . '" value="' . ( ( isset( $mm_saved_value ) && $mm_saved_value !== false ) 
					? esc_attr( $mm_saved_value ) 
					: ( isset( $option['default'] ) 
						? esc_attr( $option['default'] )  
						: ( isset( $option['values'] ) 
							? esc_attr( $option['values'] ) 
							: ''
						)
					) 
				) . '" />';
				break;
		}

		if ( $option['type'] != 'collapse_start' && $option['type'] != 'collapse_end' && $option['type'] != 'skin_options_generator' && $option['type'] != 'caption' ) {
			$section = '';
			$section .= '<div class="bootstrap">';
			$section .= '<div class="option row ' . esc_attr( $option['key'] ) . ' ' .  esc_attr( $option['type'] ) . '_type"' . ( ( isset( $option['dependency']['element'] ) && isset( $option['dependency']['value'] ) ) ? ' data-dependencyelement="' . $option['dependency']['element'] . '" data-dependencyvalue="' . implode( '|', $option['dependency']['value'] ) . '"' : '' ) . '>';
			$section .= '<div class="col-xs-12">';
			$section .= '<div class="h_separator">';
			$section .= '</div><!-- class="h_separator" -->';
			$section .= '</div><!-- class="col-xs-12" -->';
			$section .= '<div class="option_header col-md-3 col-sm-12">';
			$section .= '<div class="caption">';
			$section .= $option['name'];
			$section .= '</div><!-- class="caption" -->';
			$section .= '<div class="descr">';
			$section .= $option['descr'];
			$section .= '</div><!-- class="descr" -->';
			$section .= '</div><!-- class="option_header col-3" -->';
			$section .= '<div class="option_field col-md-9 col-sm-12">';
			$section .= $out;
			$section .= '</div><!-- class="option_field col-9" -->';
			$section .= '</div><!-- class="option row ' . esc_attr( $option['key'] ) . '" -->';
			$section .= '</div><!-- class="bootstrap" -->';
			$out = $section;
		}
		return $out;
	}
}