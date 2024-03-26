<?php

// head action hook
if(!function_exists("constance_head")){
	function constance_head(){
		do_action("constance_head");
	}
	add_action('wp_head', 'constance_head', 20);
}

if(!function_exists("constance_metaviewport")){
	function constance_metaviewport(){
		$nvr_dis_viewport = constance_get_option('constance_disable_viewport');
		if(!$nvr_dis_viewport){
			echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />';
		}
	}
	add_action('constance_head', 'constance_metaviewport', 5);
}

if(!function_exists("constance_print_headmiscellaneous")){
	function constance_print_headmiscellaneous(){
	
		echo "<!--[if lt IE 9]>\n";
		echo "<script src='". esc_url( CONSTANCE_JSURI."html5shiv.js" ) ."' type='text/javascript'></script>\n";
		echo "<![endif]-->\n";
		
		if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {
			$nvr_favicon_url = get_template_directory_uri() . '/images/favicon.ico';
			echo '<link rel="shortcut icon" href="' . esc_url( $nvr_favicon_url ) . '" />';
		}
        
	}
	add_action('constance_head', 'constance_print_headmiscellaneous', 6);
}

if(!function_exists("constance_head_values")){
	function constance_head_values($nvr_custom){
		
		$nvr_showbc = true;
		if(isset($nvr_custom["show_breadcrumb"][0])){
			if($nvr_custom["show_breadcrumb"][0]=="true"){
				$nvr_showbc = true;
			}else{
				$nvr_showbc = false;
			}
		}
		$nvr_cf_enableSlider 	= (isset($nvr_custom["enable_slider"][0]))? $nvr_custom["enable_slider"][0] : "";
		$nvr_cf_disableTitle 	= (isset($nvr_custom["disable_title"][0]))? $nvr_custom["disable_title"][0] : "";
		$nvr_cf_headermenucolor	= (isset($nvr_custom["headermenu_color"][0]))? $nvr_custom["headermenu_color"][0] : "";
		
		if($nvr_cf_enableSlider=="true" && !is_search()){
			$nvr_issliderdisplayed = true;
		}else{
			$nvr_issliderdisplayed = false;
		}
		
		$nvr_istitledisplayed = !constance_get_option('constance_disable_page_title');
		if($nvr_cf_disableTitle=="true"){
			$nvr_istitledisplayed = false;
		}
		
		$nvr_allsitelayout		= array('nvrlayout1','nvrlayout2','nvrlayout3','nvrlayout4');
		$nvr_allcontlayout		= array('nvrboxed','nvrfullwidth');
		$nvr_allcontcontainer	= array('nvrdefaultcontent','nvrfullwidthcontent');
		$nvr_alltopbar			= array('nvrshowtopbar','nvrnotopbar');
		$nvr_allheadermenucolor	= array('nvrlightmenu','nvrdarkmenu');
		
		$nvr_sitelayout			= constance_get_option( 'constance_web_layout');
		$nvr_topbar				= constance_get_option( 'constance_topbar');
		$nvr_contlayout			= constance_get_option( 'constance_container_layout' );
		$nvr_headermenucolor	= constance_get_option( 'constance_headermenu_color' );
		
		if(function_exists('simpleSessionGet') && constance_get_option( 'constance_demo_mode' )=="1"){
			$nvr_sitelayout = simpleSessionGet('site_layout', 'nvrlayout1');
			$nvr_topbar	= simpleSessionGet('topbar', 'nvrshowtopbar');;
			$nvr_contlayout = simpleSessionGet('container_layout', 'nvrfullwidth');
			$nvr_headercolor = simpleSessionGet('headermenu_color', 'nvrdarkmenu');
		}
		
		$nvr_cf_siteLayout	 	= (isset($nvr_custom["site_layout"][0]))? $nvr_custom["site_layout"][0] : $nvr_sitelayout;
		if(!in_array($nvr_cf_siteLayout,$nvr_allsitelayout)){
			$nvr_cf_siteLayout = 'nvrlayout1';
		}
		
		$nvr_cf_contlayout	 	= (isset($nvr_custom["container_layout"][0]))? $nvr_custom["container_layout"][0] : $nvr_contlayout;
		if(!in_array($nvr_cf_contlayout,$nvr_allcontlayout)){
			$nvr_cf_contlayout = 'nvrfullwidth';
		}
		
		$nvr_cf_topbar	 	= (isset($nvr_custom["topbar"][0]))? $nvr_custom["topbar"][0] : $nvr_topbar;
		if(!in_array($nvr_cf_topbar,$nvr_alltopbar)){
			$nvr_cf_topbar = 'nvrshowtopbar';
		}
		
		$nvr_cf_headermenucolor	 = (isset($nvr_custom["headermenu_color"][0]) && $nvr_custom["headermenu_color"][0]!='default')? $nvr_custom["headermenu_color"][0] : $nvr_headermenucolor;
		if(!in_array($nvr_cf_headermenucolor,$nvr_allheadermenucolor)){
			$nvr_cf_headermenucolor = 'nvrdarkmenu';
		}
		
		$nvr_cf_contcontainer = 'nvrdefaultcontent';
		if( constance_is_shop() ){
			$nvr_cf_contcontainer = 'nvrfullwidthcontent';
		}
		
		if(function_exists('simpleSessionSet') && constance_get_option( 'constance_demo_mode' )=="1"){
			simpleSessionSet('site_layout', $nvr_cf_siteLayout);
			simpleSessionSet('container_layout', $nvr_cf_contlayout);
			simpleSessionSet('topbar', $nvr_cf_topbar);
			simpleSessionSet('headermenu_color', $nvr_cf_headermenucolor);
		}
		$nvr_txtContainerWidth = constance_get_bodycontainer();
		
		$nvr_bodyclass = array('novaro');
		$nvr_bodyclass[] = $nvr_cf_siteLayout;
		$nvr_bodyclass[] = $nvr_cf_contlayout;
		$nvr_bodyclass[] = $nvr_cf_contcontainer;
		$nvr_bodyclass[] = $nvr_cf_topbar;
		$nvr_bodyclass[] = $nvr_cf_headermenucolor;
		if($nvr_issliderdisplayed){
			$nvr_bodyclass[] = 'nvrslideron';
		}
		
		if($nvr_txtContainerWidth>1100){
			$nvr_bodyclass[] = 'nvr1100more';
		}
		
		$nvr_return = array(
			'nvr_bodyclass' => $nvr_bodyclass,
			'nvr_showbc' => $nvr_showbc,
			'nvr_cf_siteLayout' => $nvr_cf_siteLayout,
			'nvr_issliderdisplayed' => $nvr_issliderdisplayed,
			'nvr_istitledisplayed' => $nvr_istitledisplayed
		);
		
		return $nvr_return;

	}
}

// print the logo html
if(!function_exists("constance_logo")){
	function constance_logo(){ 
		
		$nvr_defaultlogo = array(
			'url' => get_stylesheet_directory_uri() . "/images/logo.png",
			'id' => '',
			'width' => '',
			'height' => '',
			'thumbnail' => ''
		);
		$nvr_logotype = constance_get_option( 'constance_logo_type');
		$nvr_logoimage = constance_get_option( 'constance_logo_image', $nvr_defaultlogo);
		if($nvr_logoimage==""){
			$nvr_logoimage = $nvr_defaultlogo;
		}
		$nvr_logoimagelight = constance_get_option( 'constance_logo_image_light', $nvr_defaultlogo);
		if($nvr_logoimagelight==""){
			$nvr_logoimagelight = $nvr_defaultlogo;
		}
		$nvr_sitename =  constance_get_option( 'constance_site_name');
		$nvr_tagline = constance_get_option( 'constance_tagline');
		
		if($nvr_sitename=="") $nvr_sitename = get_bloginfo('name');
		if($nvr_tagline=="") $nvr_tagline = get_bloginfo('description'); 
		if($nvr_logoimage['url'] == "") $nvr_logoimage['url'] = get_stylesheet_directory_uri() . "/images/logo.png";
		if($nvr_logoimagelight['url'] =="") $nvr_logoimagelight['url'] = $nvr_logoimage['url'];
?>
		<?php if($nvr_logotype == 'textlogo'){ ?>
			
			 <div class="logoimg"><h1><a href="<?php echo esc_url( home_url( '/') ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', "constance" ) ); ?>"><?php echo esc_html( $nvr_sitename ); ?></a></h1><span class="desc"><?php echo esc_html( $nvr_tagline ); ?></span></div>
        
        <?php } else { ?>
        	
            <div class="logoimg">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( $nvr_sitename ); ?>" >
                <img src="<?php echo esc_url( $nvr_logoimage['url'] ); ?>" alt="<?php echo esc_attr( $nvr_sitename ); ?>" class="darklogo" />
                <img src="<?php echo esc_url( $nvr_logoimagelight['url'] ); ?>" alt="<?php echo esc_attr( $nvr_sitename ); ?>" class="lightlogo" />
            </a>
            </div>
            
		<?php } ?>
        
<?php 
	}
}

if(!function_exists("constance_searchform")){
	function constance_searchform($nvr_id="", $nvr_class=""){
		if(function_exists('is_woocommerce')){
			$nvr_outputposttype = '<input type="hidden" name="post_type" value="product" />';
			$nvr_searchtext = esc_html__('Search product...', "constance" );
		}else{
			$nvr_outputposttype = '';
			$nvr_searchtext = esc_html__('Search...', "constance" );
		}
		if($nvr_id==''){
			$nvr_id = 'topsearchform';
		}
		$nvr_output = '<div class="'. esc_attr( $nvr_class ).'">';
			$nvr_output .= '<form method="get" id="'.esc_attr( $nvr_id ).'" class="btntoppanel" action="'. esc_url( home_url( '/' ) ) .'">';
				$nvr_output .= '<input type="submit" class="submit" name="submit" value="" />';
				$nvr_output .= '<button type="submit" class="submittext" name="submit"><i class="fa fa-search"></i> '. esc_html__('Search', 'constance') .'</button>';
				$nvr_output .= '<div class="searcharea">';
					$nvr_output .= '<input type="text" name="s" autocomplete="off" class="txtsearch" placeholder="'. esc_attr( $nvr_searchtext ) .'" value="" />';
					$nvr_output .= $nvr_outputposttype;
					$nvr_output .= '<a href="#" class="searchclose"></a>';
				$nvr_output .= '</div>';
			$nvr_output .= '</form>';
		$nvr_output .= '</div>';
		
		return $nvr_output;
	}
}

if(!function_exists('constance_feloginregister')){
	function constance_feloginregister(){
		$return = '
			<div class="loginformbox">
				<div class="febuttoncontainer loginbuttoncontainer">
					<a id="toploginbutton" href="#" class="button color2"><i class="shopicon fa fa-lock"></i> <span class="topbtn_text">'. esc_html__('Login', "constance") .'</span></a>
					<div id="feloginform" class="feform">
						'.constance_login_form().'
					</div>
				</div>
				<div class="orseparator">'. esc_html__('or', "constance") .'</div>
				<div class="febuttoncontainer registerbuttoncontainer">
					<a id="topregisterbutton" href="#" class="button"><i class="shopicon fa fa-book"></i> <span class="topbtn_text">'. esc_html__('Register', "constance") .'</span></a>
					<div id="feregisterform" class="feform">
						'. constance_register_form() .'
					</div>
				</div>
			</div>
		';
		
		return $return;
	}
}

if(!function_exists('constance_breadcrumb')){
	function constance_breadcrumb(){
		if(function_exists('woocommerce_breadcrumb')){
			woocommerce_breadcrumb(array(
				'delimiter' => ' &nbsp;&nbsp;/&nbsp;&nbsp; '
			));
		}elseif(function_exists('yoast_breadcrumb')){
			yoast_breadcrumb('<nav class="nvr-breadcrumb">','</nav><div class="clearfix"></div>');
		}
	}
}

if(!function_exists("constance_minicart")){
	function constance_minicart($nvr_id="",$nvr_class=""){
		
		global $woocommerce;
		$nvr_cart_subtotal = $woocommerce->cart->get_cart_subtotal();
		$nvr_link = $woocommerce->cart->get_cart_url();
		$nvr_cart_items = $woocommerce->cart->get_cart_item_quantities();
		
		$nvr_totalqty = 0;
		if(is_array($nvr_cart_items)){
			foreach($nvr_cart_items as $nvr_cart_item){
				$nvr_totalqty += (is_numeric($nvr_cart_item))? $nvr_cart_item : 0;
			}
		}
		
		ob_start();
		the_widget('WC_Widget_Cart', '', array('widget_id'=>'cart-dropdown',
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<span class="hidden">',
			'after_title' => '</span>'
		));
		$nvr_widget = ob_get_clean();
	
		$nvr_output = '<div id="'.esc_attr( $nvr_id ).'" class="'.esc_attr( $nvr_class ).'">';
			$nvr_output .= '<a class="topcartbutton btnpanel" href="'.esc_url( $nvr_link ).'"><i class="shopicon fa fa-shopping-cart"></i> <span class="topbtn_text">'.esc_html__( "My Cart", "constance" ).'</span><span class="cart_subqty"><i class="cart_totalqty">'.$nvr_totalqty.'</i><i class="cart_subtotal">'.$nvr_cart_subtotal.'</i></span><div class="clearfix"></div></a>';
			$nvr_output .= '<span class="arrowpanel"></span>';
			$nvr_output .= '<div class="cartlistwrapper">';
				$nvr_output .= $nvr_widget;
			$nvr_output .= '</div>';
		$nvr_output .= '</div>';
		
		return $nvr_output;
	}
}

if(!function_exists("constance_frontlogin")){
	function constance_frontlogin($nvr_id="",$nvr_class=""){
		
		$nvr_link = constance_get_option('constance_loginlink');
		$nvr_output = '<div id="'.esc_attr( $nvr_id ).'" class="'.esc_attr( $nvr_class ).'">';
			$nvr_output .= '<a class="loginbutton btnpanel" href="'.esc_url( $nvr_link ).'"><i class="shopicon fa fa-sign-in"></i> <span class="topbtn_text">'.esc_html__('Login', "constance").'</span></a>';
			$nvr_output .= '<span class="arrowpanel"></span>';
			$nvr_output .= '<div class="loginformwrapper">';
				$nvr_output .= constance_login_form();
			$nvr_output .= '</div>';
		$nvr_output .= '</div>';
		
		return $nvr_output;
	}
}

if(!function_exists('constance_primary_menu')){
	function constance_primary_menu($nvr_class=''){
		echo '<section class="navigation '.esc_attr( $nvr_class ).'">';
			echo '<a class="nav-toggle fa"></a>';
			echo '<nav>';
				wp_nav_menu( array(
				  'container'       => 'ul', 
				  'menu_class'      => 'topnav sf-menu', 
				  'depth'           => 0,
				  'sort_column'    => 'menu_order',
				  'fallback_cb'     => 'nav_page_fallback',
				  'theme_location' => 'mainmenu' 
				)); 
				echo '<div class="clearfix"></div>';
			echo '</nav><!-- nav -->';	
			echo '<div class="clearfix"></div>';
		echo '</section>';
	}
}

if(!function_exists('constance_secondary_menu')){
	function constance_secondary_menu(){
		$nvr_useslidermenu = false;
		if(has_nav_menu('secondarymenu')){
			$locations = get_nav_menu_locations();
			if(isset($locations['secondarymenu'])){
				$slidermenuid = $locations['secondarymenu'];
				$nvr_useslidermenu = true;
			}else{
				$slidermenuid = 0;
			}
		}
		
		if($nvr_useslidermenu){
        	$nav_menu = wp_get_nav_menu_object($slidermenuid);
			echo '<h4 id="sidemenutitle">'.esc_html( $nav_menu->name ).'</h4>';
		}
		wp_nav_menu( array(
		  'container'       => 'ul', 
		  'menu_class'      => 'gn-menu',
		  'menu_id'         => 'secondarynav', 
		  'depth'           => 2,
		  'sort_column'    => 'menu_order',
		  'fallback_cb'     => 'nav_2nd_fallback',
		  'theme_location' => 'secondarymenu' 
		));

	}
	add_action('constance_output_toparea','constance_secondary_menu',40);
}

if (!function_exists('nvr_socialicon')){
	function nvr_socialicon(){

		$nvr_optSocialIcons = constance_fontsocialicon();
		
		$nvr_outputli = "";
		foreach($nvr_optSocialIcons as $nvr_optSocialIcon => $nvr_optSocialText){
			$nvr_sociallink = constance_get_option( 'constance_socialicon_'.$nvr_optSocialIcon, "" );
			if(isset($nvr_sociallink) && $nvr_sociallink!=''){
				$nvr_outputli .= '<li><a href="'.esc_url( $nvr_sociallink ).'" class="fa '.esc_attr( $nvr_optSocialIcon ).'"></a></li>'."\n";
			}
		}
		$nvr_output = "";
		if($nvr_outputli!=""){
			$nvr_output .= '<ul class="sn">';
			$nvr_output .= $nvr_outputli;
			$nvr_output .= '</ul>';
		}
		return $nvr_output;
	}
}//end if(!function_exists('constance_get_socialicon'))

if(!function_exists('constance_output_socialicon')){
	function constance_output_socialicon(){
		/*=====SOCIALICON======*/
		$nvr_socialiconoutput = nvr_socialicon();
		if($nvr_socialiconoutput!=''){				
			// get the social network icon
			echo '<div class="topicon">'. $nvr_socialiconoutput .'</div>';
		}
	}
	add_action('constance_output_toparea','constance_output_socialicon',8);
	
}

if(!function_exists('constance_output_headertext')){
	function constance_output_headertext(){

		/*=====HEADERTEXT======*/
		$nvr_headertext = stripslashes(constance_get_option( 'constance_headertext',''));
		if($nvr_headertext){
			echo '<div class="toptext"><span>'. do_shortcode($nvr_headertext) .'</span></div>';
		}
	}
}

if(!function_exists('constance_output_wpmlselector')){
	function constance_output_wpmlselector(){
		do_action('icl_language_selector');
	}
	add_action('constance_output_toparea','constance_output_wpmlselector',20);
}

if(!function_exists('constance_output_searchform')){
	function constance_output_searchform(){
		
		$nvr_disable_topsearch = constance_get_option('constance_disable_topsearch');
		if($nvr_disable_topsearch!=true){
			echo constance_searchform("","searchbox"); 
		}
	}
}

if(!function_exists('constance_output_feloginregister')){
	function constance_output_feloginregister(){
		
		$nvr_disable_felogin = constance_get_option('constance_disable_felogin');
		$nvr_accountlink = constance_get_option( 'constance_accountlink', '');
		if($nvr_disable_felogin!=true){
			if(is_user_logged_in()){
				echo '<ul class="gn-menu frontendmenu">';
					echo '<li class="afterlogin logoutitem"><a href="'. esc_url( wp_logout_url( home_url() ) ) .'"><i class="shopicon fa fa-sign-out"></i> <span class="topbtn_text">'.esc_html__('Logout', "constance").'</span></a></li>';
					if($nvr_accountlink!=''){
						echo '<li class="afterlogin myaccountitem"><a href="'. esc_url( $nvr_accountlink ).'"><i class="shopicon fa fa-user"></i> <span class="topbtn_text">'.esc_html__('My Account', "constance").'</span></a></li>';
					}
				echo '</ul>';
			}else{
				echo constance_feloginregister();
			}
		}
	}
}

if(!function_exists('constance_output_minicart')){
	function constance_output_minicart(){
		
		$nvr_disable_minicart = constance_get_option('constance_disable_minicart');
		if($nvr_disable_minicart!=true && function_exists('is_woocommerce')){
			echo constance_minicart("topminicart","commercepanel");
		}
	}
}