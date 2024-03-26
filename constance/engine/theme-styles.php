<?php
function constance_styles() {
	if (!is_admin()) {
		
		wp_register_style('nvr_reset-css', CONSTANCE_CSSURI . 'reset.css', '', '', 'screen, all');
		wp_enqueue_style('nvr_reset-css');
		
		wp_register_style('nvr_normalize-css', CONSTANCE_CSSURI . 'normalize.css', 'nvr_reset-css', '', 'screen, all');
		wp_enqueue_style('nvr_normalize-css');
		
		wp_register_style('nvr_skeleton-css', CONSTANCE_CSSURI . '1140.css', 'nvr_normalize-css', '', 'screen, all');
		wp_enqueue_style('nvr_skeleton-css');
		
		wp_register_style('nvr_font-awesome-css', CONSTANCE_CSSURI . 'font-awesome.min.css', 'nvr_normalize-css', '', 'screen, all');
		wp_enqueue_style('nvr_font-awesome-css');
		
		wp_register_style('nvr_font-line-icon-css', CONSTANCE_CSSURI . 'font-line-icon.css', 'nvr_normalize-css', '', 'screen, all');
		wp_enqueue_style('nvr_font-line-icon-css');
		
		wp_register_style('nvr_PerfectScrollbar-css', CONSTANCE_CSSURI . 'perfect-scrollbar.min.css', 'nvr_skeleton-css', '', 'screen, all');
		wp_enqueue_style('nvr_PerfectScrollbar-css');
		
		wp_register_style('nvr_prettyPhoto-css', CONSTANCE_CSSURI . 'prettyPhoto.css', '', '', 'screen, all');
		wp_enqueue_style('nvr_prettyPhoto-css');
		
		wp_register_style('nvr_flexslider-css', CONSTANCE_CSSURI .'flexslider.css', '', '', 'screen, all');
		wp_enqueue_style('nvr_flexslider-css');
		
		wp_register_style('nvr_custom-portfolio-css', CONSTANCE_CSSURI . 'nvrportfolio.css', '', '', 'screen, all');
		wp_enqueue_style('nvr_custom-portfolio-css');
		
		wp_register_style('nvr_custom-testimonial-css', CONSTANCE_CSSURI . 'nvrtestimonial.css', '', '', 'screen, all');
		wp_enqueue_style('nvr_custom-testimonial-css');
		
		wp_register_style('nvr_custom-brand-css', CONSTANCE_CSSURI . 'nvrbrand.css', '', '', 'screen, all');
		wp_enqueue_style('nvr_custom-brand-css');
		
		wp_register_style('nvr_custom-people-css', CONSTANCE_CSSURI . 'nvrpeople.css', '', '', 'screen, all');
		wp_enqueue_style('nvr_custom-people-css');
		
		wp_register_style('nvr_selectordie-css', CONSTANCE_CSSURI . 'selectordie.css', '', '', 'screen, all');
		wp_enqueue_style('nvr_selectordie-css');
		
		wp_register_style('constance_main-css', CONSTANCE_CSSURI . 'main.css', 'nvr_skeleton-css', '', 'screen, all');
		wp_enqueue_style('constance_main-css');
		
		wp_register_style('constance_layout-css', CONSTANCE_CSSURI . 'layout.css', '', '', 'screen, all');
		wp_enqueue_style('constance_layout-css');
		
		wp_register_style('constance_color-css', CONSTANCE_CSSURI . 'color.css', '', '', 'screen, all');
		wp_enqueue_style('constance_color-css');
		
		wp_register_style('constance_woocommerce-css', CONSTANCE_CSSURI . 'woocommerce.css', '', '', 'screen, all');
		if(function_exists('is_woocommerce')){
			wp_enqueue_style('constance_woocommerce-css');
		}
		
		wp_register_style('constance_stylecustom', CONSTANCE_STYLEURI . 'style-custom.css', '', '', 'screen, all');
		wp_enqueue_style('constance_stylecustom');
		
		$nvr_custom_css = constance_print_stylesheet();
		wp_add_inline_style( 'constance_stylecustom', $nvr_custom_css );
		
		wp_register_style('constance_switcher-css', CONSTANCE_CSSURI . 'style-switcher.css', '', '', 'screen, all');
		if( constance_get_option( 'constance_enable_switcher')){
			wp_enqueue_style('constance_switcher-css');
		}
		
		wp_register_style('constance_noscript-css', CONSTANCE_CSSURI .'noscript.css', '', '', 'screen, all');
		wp_enqueue_style('constance_noscript-css');
		
	}
}
add_action('wp_enqueue_scripts', 'constance_styles');

// get style
if(!function_exists("constance_print_stylesheet")){
	function constance_print_stylesheet(){
		
		/* Get Theme Color Options */
		$nvr_opt_colorTheme		= constance_get_option('constance_color_theme');    
		
		$nvr_textcolorcss  = '';
		if($nvr_opt_colorTheme!=''){
		
			$nvr_textcolorcss .= 'a:hover, a.colortext:hover, .colortext a:hover, .colortext{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.button, .button:visited, #maincontent input[type="submit"], #maincontent input[type="reset"], button{ background: '.$nvr_opt_colorTheme.'; border-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '#footersidebar input[type="submit"], #footersidebar input[type="reset"]{ background: '.$nvr_opt_colorTheme.'; border-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.button:hover, #maincontent input[type="submit"]:hover, #maincontent input[type="reset"]:hover, button:hover{ background: '.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.sn a:hover{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '#headertext #lang_sel .lang_sel_sel{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.topnav li li a:hover, .topnav li .current_page_item > a, .topnav li .current_page_item > a:hover, .topnav li .current_page_parent > a, .topnav li .current_page_parent > a:hover, .topnav li .current-menu-parent > a, .topnav li .current-menu-parent > a:hover, .topnav li .current-menu-item > a, .topnav li .current-menu-item > a:hover{color:'.$nvr_opt_colorTheme.' !important;}';
			$nvr_textcolorcss .= '.topnav > li > a:hover, .topnav > li.current_page_item > a, .topnav > li.current_page_parent > a, .topnav > li.current_page_ancestor > a, .topnav > li.current-menu-item > a, .topnav > li.current-menu-parent > a, .topnav > li.current-menu-ancestor > a{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.gn-menu li a:hover{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '#topminicart .topcartbutton:hover{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.loginformbox .febuttoncontainer:hover a.button{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '#togglesidemenu:hover{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= 'ul#slidermenunav li a:hover{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '#slider a.sliderbutton{ background-color:'.$nvr_opt_colorTheme.'; border-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '#outerbeforecontent{background-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.highlight2{background:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.icn-container{border-color:'.$nvr_opt_colorTheme.';color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.icn-container.type2{border-color:'.$nvr_opt_colorTheme.'; background-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.icn-container.type3{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= 'ul.tabs li:hover{border-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= 'ul.tabs	 li.active{border-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= 'html ul.tabs li.active, html ul.tabs li.active a:hover, ul.tabs li a:hover{background: '.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.archives_list li a:hover{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= 'div.meter div{background-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= 'div.bordersep .bordershow{background-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.nvr-heading.white .hborder{background-color:'.$nvr_opt_colorTheme.' !important;}';
			$nvr_textcolorcss .= '.posttitle a:hover{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= 'article .meta-format{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.entry-utility2 a:hover{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= 'article.format-quote .entry-content{background-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.nav-previous a:hover, .nav-next a:hover{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.commentlist .comment-body .reply a{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.wp-pagenavi a:hover{background-color:'.$nvr_opt_colorTheme.'; border-color:'.$nvr_opt_colorTheme.' !important;}';
			$nvr_textcolorcss .= '.wp-pagenavi span.current{background:'.$nvr_opt_colorTheme.';border-color:'.$nvr_opt_colorTheme.' !important;}';
			$nvr_textcolorcss .= '.nvr-pagenavi li .page-numbers:hover, .nvr-pagenavi li .page-numbers.current{ border-color:'.$nvr_opt_colorTheme.'; background-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.nvr-recentposts .nvr-rp-morelink{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.nvr-pf-box:hover .nvr-pf-text .nvr-pf-title a{color:'.$nvr_opt_colorTheme.' !important;}';
			$nvr_textcolorcss .= 'body.novaro .nvr-pf-container .classic .nvr-pf-text .nvr-pf-cat a:hover{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '#subbody .newslettercontainer input.wysija-submit:hover{background-color:'.$nvr_opt_colorTheme.';border-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= 'body.novaro ul.products li.product h3:hover{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= 'body.novaro ul.products li.product .nvr-productcat a:hover{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= 'body.novaro a.button:hover, body.novaro button.button:hover, body.novaro input.button:hover, body.novaro #respond input#submit:hover, body.novaro #content input.button:hover{ background:'.$nvr_opt_colorTheme.'; border-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= 'body.novaro .woocommerce-message a.wc-forward{background:'.$nvr_opt_colorTheme.'; border:1px solid '.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= 'body.novaro nav.woocommerce-pagination ul li span.current, body.novaro nav.woocommerce-pagination ul li a:hover, body.novaro #content nav.woocommerce-pagination ul li span.current, body.novaro #content nav.woocommerce-pagination ul li a:hover, body.novaro nav.woocommerce-pagination ul li a:focus, body.novaro #content nav.woocommerce-pagination ul li a:focus{border-width:1px solid '.$nvr_opt_colorTheme.' !important; background-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= 'body.novaro .woocommerce-message{border-top:3px solid '.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= 'body.novaro .woocommerce-message:before{color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.cart-subtotals th{background-color:'.$nvr_opt_colorTheme.'; border-bottom:1px solid '.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.widget_shopping_cart_content p.buttons a{border-color:'.$nvr_opt_colorTheme.'; background-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.widget_price_filter .price_slider_amount button.button{ background:'.$nvr_opt_colorTheme.'; border:1px solid '.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '.nvr_gridinfo .cellcontent > table .tabletd .gridbutton{background-color:'.$nvr_opt_colorTheme.';}';
			$nvr_textcolorcss .= '@media only screen and (max-width:767px){
				.js .topnav a:hover, .js .topnav a.current-menu-item{background-color:'.$nvr_opt_colorTheme.' !important;}
			}';

		}
		
		/* Get Header Background Option */
		$nvr_opt_bgHeader 		= constance_get_option('constance_header_background');    
		$nvr_cf_bgHeader 		= '';
		$nvr_cf_bgRepeat 		= "no-repeat";
		$nvr_cf_bgPos	 		= "center";
		$nvr_cf_bgAttch	 		= "";
		$nvr_cf_bgSize			= "";
		$nvr_cf_bgColor	 		= "transparent";
		
		if( $nvr_opt_bgHeader){
			if($nvr_opt_bgHeader["background-image"]!=""){
				$nvr_cf_bgHeader 	= $nvr_opt_bgHeader["background-image"];
				$nvr_cf_bgRepeat 		= $nvr_opt_bgHeader["background-repeat"];
				$nvr_cf_bgPos	 		= $nvr_opt_bgHeader["background-position"];
				$nvr_cf_bgAttch	 		= $nvr_opt_bgHeader["background-attachment"];
				$nvr_cf_bgSize	 		= $nvr_opt_bgHeader["background-size"];
			}
			$nvr_cf_bgColor	 		= ($nvr_opt_bgHeader["background-color"]!="")? $nvr_opt_bgHeader["background-color"] : "";
		}
		
		/* Get Body Background Option */
		$nvr_optBodyBGColor = '';
		$nvr_optBodyBGImage = '';
		$nvr_optBodyBGPosition = 'center';
		$nvr_optBodyBGStyle = 'repeat';
		$nvr_optBodyBGattachment = '';
		$nvr_optBodyBGSize = '';
		
		$nvr_optBodyBG = constance_get_option( 'constance_body_background');
		if($nvr_optBodyBG){
			$nvr_optBodyBGColor = $nvr_optBodyBG['background-color'];
			$nvr_optBodyBGImage = $nvr_optBodyBG['background-image'];
			$nvr_optBodyBGPosition = $nvr_optBodyBG['background-position'];
			$nvr_optBodyBGStyle = $nvr_optBodyBG['background-repeat'];
			$nvr_optBodyBGattachment = $nvr_optBodyBG['background-attachment'];
			$nvr_optBodyBGSize = $nvr_optBodyBG['background-size'];
		}
		
		$nvr_opt2ndnavBG = constance_get_option( 'constance_secondnav_background');
		$nvr_str2ndnavBG = '';
		if($nvr_opt2ndnavBG){
			foreach($nvr_opt2ndnavBG as $nvr_2ndnavbgidx => $nvr_2ndnavbgval ){
				if($nvr_2ndnavbgidx=="media" || $nvr_2ndnavbgval==""){continue;}
				if($nvr_2ndnavbgidx=="background-image"){
					$nvr_str2ndnavBG .= $nvr_2ndnavbgidx.':url('.esc_url( $nvr_2ndnavbgval ).');';
				}else{
					$nvr_str2ndnavBG .= $nvr_2ndnavbgidx.':'.$nvr_2ndnavbgval.';';
				}
			}
		}
		
		/* Get After Content Background Option */
		$nvr_opt_bgAfterC = constance_get_option( 'constance_aftercontent_background');
		$nvr_cf_bgAfterC 		= "";
		$nvr_cf_bgRepeatAfterC	= "repeat";
		$nvr_cf_bgPosAfterC		= "center";
		$nvr_cf_bgSizeAfterC	= "";
		$nvr_cf_bgColorAfterC	= "transparent";

		if( $nvr_opt_bgAfterC ){
			if($nvr_opt_bgAfterC["background-image"]!=""){
				$nvr_cf_bgAfterC 	= $nvr_opt_bgAfterC["background-image"];
			}
			$nvr_cf_bgRepeatAfterC	= $nvr_opt_bgAfterC["background-repeat"];
			$nvr_cf_bgPosAfterC		= $nvr_opt_bgAfterC["background-position"];
			$nvr_cf_bgAttchAfterC	= $nvr_opt_bgAfterC["background-attachment"];
			$nvr_cf_bgSizeAfterC	= $nvr_opt_bgAfterC["background-size"];
			$nvr_cf_bgColorAfterC	= ($nvr_opt_bgAfterC["background-color"]!="")? $nvr_opt_bgAfterC["background-color"] : "#333333";
		}
		
		/* Get Footer Background Option */
		$nvr_opt_bgFooter 		= constance_get_option('constance_footer_background');
		$nvr_cf_bgFooter 		= "";
		$nvr_cf_bgRepeatFooter	= "repeat";
		$nvr_cf_bgPosFooter		= "center";
		$nvr_cf_bgSizeFooter	= "";
		$nvr_cf_bgColorFooter	= "#000000";
		
		if( $nvr_opt_bgFooter ){
			if($nvr_opt_bgFooter["background-image"]!=""){
				$nvr_cf_bgFooter 	= $nvr_opt_bgFooter["background-image"];
			}
			$nvr_cf_bgRepeatFooter	= $nvr_opt_bgFooter["background-repeat"];
			$nvr_cf_bgPosFooter		= $nvr_opt_bgFooter["background-position"];
			$nvr_cf_bgAttchFooter	= $nvr_opt_bgFooter["background-attachment"];
			$nvr_cf_bgSizeFooter	= $nvr_opt_bgFooter["background-size"];
			$nvr_cf_bgColorFooter	= ($nvr_opt_bgFooter["background-color"]!="")? $nvr_opt_bgFooter["background-color"] : $nvr_cf_bgColorFooter;
		}
		
		/* Get Google Font Option */
		$nvr_optGeneralTextFont = constance_get_option( 'constance_general_font');
		
		$nvr_optBigTextFont = constance_get_option( 'constance_bigtext_font');

		$nvr_optHeadingFont = constance_get_option( 'constance_heading_font');
		
		$nvr_optMenuFont = constance_get_option( 'constance_menunav_font');
		
		$nvr_opt2ndMenuFont = constance_get_option( 'constance_secondnav_font');
		
		$nvr_opt2ndFont = constance_get_option( 'constance_secondary_font');
		
		$nvr_txtContainerWidth = intval( constance_get_option( 'constance_container_width') );
		
		//get background from metabox
		$nvr_pid = constance_get_postid();
		$nvr_custom = constance_get_customdata($nvr_pid);
		$nvr_cf_paddingtop		= (isset($nvr_custom["main_paddingtop"][0]))? $nvr_custom["main_paddingtop"][0] : "";
		$nvr_cf_paddingbottom	= (isset($nvr_custom["main_paddingbottom"][0]))? $nvr_custom["main_paddingbottom"][0] : "";
		$nvr_cf_bgHeader 		= (isset($nvr_custom["bg_header"][0]))? $nvr_custom["bg_header"][0] : $nvr_cf_bgHeader;
		$nvr_cf_bgRepeat 		= (isset($nvr_custom["bg_repeat"][0]) && trim($nvr_custom["bg_repeat"][0])!="")? $nvr_custom["bg_repeat"][0] : $nvr_cf_bgRepeat;
		$nvr_cf_bgPos	 		= (isset($nvr_custom["bg_pos"][0]) && trim($nvr_custom["bg_pos"][0])!="")? $nvr_custom["bg_pos"][0] : $nvr_cf_bgPos;
		$nvr_cf_bgAttch	 		= (isset($nvr_custom["bg_attch"][0]) && trim($nvr_custom["bg_attch"][0])!="")? $nvr_custom["bg_attch"][0] : $nvr_cf_bgAttch;
		$nvr_cf_bgColor	 		= (isset($nvr_custom["bg_color"][0]) && trim($nvr_custom["bg_color"][0])!="")? $nvr_custom["bg_color"][0] : $nvr_cf_bgColor;
		
		$nvr_cf_pagebgimg = (isset($nvr_custom["page-bgimg"][0]))? $nvr_custom["page-bgimg"][0] : "";
		$nvr_cf_pagebgposition = (isset($nvr_custom["page-bgposition"][0]))? $nvr_custom["page-bgposition"][0] : "";
		$nvr_cf_pagebgstyle = (isset($nvr_custom["page-bgstyle"][0]))? $nvr_custom["page-bgstyle"][0] : "";
		$nvr_cf_pagebgattch = (isset($nvr_custom["page-bgattch"][0]))? $nvr_custom["page-bgattch"][0] : "";
		$nvr_cf_pagebgcolor = (isset($nvr_custom["page-bgcolor"][0]))? $nvr_custom["page-bgcolor"][0] : "";
		
		$nvr_cf_bgMainC  		= (isset($nvr_custom["bg_maincontent"][0]))? $nvr_custom["bg_maincontent"][0] : '';
		$nvr_cf_bgRepeatMainC 	= (isset($nvr_custom["bg_repeat_maincontent"][0]) && trim($nvr_custom["bg_repeat_maincontent"][0])!="")? $nvr_custom["bg_repeat_maincontent"][0] : 'repeat';
		$nvr_cf_bgPosMainC 	= (isset($nvr_custom["bg_pos_maincontent"][0]) && trim($nvr_custom["bg_pos_maincontent"][0])!="")? $nvr_custom["bg_pos_maincontent"][0] : 'center';
		$nvr_cf_bgColorMainC 	= (isset($nvr_custom["bg_color_maincontent"][0]) && trim($nvr_custom["bg_color_maincontent"][0])!="")? $nvr_custom["bg_color_maincontent"][0] : 'transparent';
		
		$nvr_cf_bgAfterC  		= (isset($nvr_custom["bg_aftercontent"][0]))? $nvr_custom["bg_aftercontent"][0] : $nvr_cf_bgAfterC;
		$nvr_cf_bgRepeatAfterC 	= (isset($nvr_custom["bg_repeat_aftercontent"][0]) && trim($nvr_custom["bg_repeat_aftercontent"][0])!="")? $nvr_custom["bg_repeat_aftercontent"][0] : $nvr_cf_bgRepeatAfterC;
		$nvr_cf_bgPosAfterC 	= (isset($nvr_custom["bg_pos_aftercontent"][0]) && trim($nvr_custom["bg_pos_aftercontent"][0])!="")? $nvr_custom["bg_pos_aftercontent"][0] : $nvr_cf_bgPosAfterC;
		$nvr_cf_bgColorAfterC 	= (isset($nvr_custom["bg_color_aftercontent"][0]) && trim($nvr_custom["bg_color_aftercontent"][0])!="")? $nvr_custom["bg_color_aftercontent"][0] : $nvr_cf_bgColorAfterC;
		
		$nvr_cf_bgFooter 		= (isset($nvr_custom["bg_footer"][0]))? $nvr_custom["bg_footer"][0] : $nvr_cf_bgFooter;
		$nvr_cf_bgRepeatFooter	= (isset($nvr_custom["bg_repeat_footer"][0]) && trim($nvr_custom["bg_repeat_footer"][0])!="")? $nvr_custom["bg_repeat_footer"][0] : $nvr_cf_bgRepeatFooter;
		$nvr_cf_bgPosFooter		= (isset($nvr_custom["bg_pos_footer"][0]) && trim($nvr_custom["bg_pos_footer"][0])!="")? $nvr_custom["bg_pos_footer"][0] : $nvr_cf_bgPosFooter	;
		$nvr_cf_bgColorFooter	= (isset($nvr_custom["bg_color_footer"][0]) && trim($nvr_custom["bg_color_footer"][0])!="")? $nvr_custom["bg_color_footer"][0] : $nvr_cf_bgColorFooter;
		
		$nvr_print_custom_css = '';
		
		$nvr_print_custom_css .= $nvr_textcolorcss;
		
		$nvr_bodycss = '';
		$nvr_generalTextOutput = '';
		if($nvr_optGeneralTextFont){
			foreach($nvr_optGeneralTextFont as $nvr_generalTextFont => $nvr_generalTextFontVal){
				if($nvr_generalTextFont!='google' && $nvr_generalTextFont!='subsets' && $nvr_generalTextFont!='font-options' && $nvr_generalTextFontVal!=''){
					if($nvr_generalTextFont=='font-family'){
						if(strpos($nvr_generalTextFontVal,",")>0){
							$nvr_generalTextOutput = $nvr_generalTextFontVal;
						}else{
							$nvr_generalTextFontVal = $nvr_generalTextOutput = "'".$nvr_generalTextFontVal."'";
						}
					}
					$nvr_bodycss .= $nvr_generalTextFont. ": ".$nvr_generalTextFontVal.";";
				}
			}
		}
		
		if($nvr_cf_pagebgimg!="" || $nvr_cf_pagebgcolor!=''){
			$nvr_bodycss .= 'background-image:url('. $nvr_cf_pagebgimg .');';
			$nvr_bodycss .= 'background-repeat:'. $nvr_cf_pagebgstyle  .';';
			$nvr_bodycss .= 'background-attachment:'. $nvr_cf_pagebgattch  .';';
			$nvr_bodycss .= 'background-position:'. $nvr_cf_pagebgposition .';';
			$nvr_bodycss .= 'background-color:'. $nvr_cf_pagebgcolor .';';
		
		}else{
			if($nvr_optBodyBGImage!="" || $nvr_optBodyBGColor!=""){
				$nvr_bodycss .= 'background-color:'. $nvr_optBodyBGColor .';';
				$nvr_bodycss .= 'background-image:url('. $nvr_optBodyBGImage .');';
				$nvr_bodycss .= 'background-repeat:'. $nvr_optBodyBGStyle .';';
				$nvr_bodycss .= 'background-position:'. $nvr_optBodyBGPosition .';';
				$nvr_bodycss .= 'background-attachment:'. $nvr_optBodyBGattachment .';';
			}
		}
		$nvr_print_custom_css .='body{'.$nvr_bodycss.'}';
		
		$nvr_outertopcss = '';
		if($nvr_cf_bgHeader){
			$nvr_outertopcss .='background-image:url('. $nvr_cf_bgHeader .');';
		}
		$nvr_outertopcss .='background-repeat:'. $nvr_cf_bgRepeat .'; background-position:'. $nvr_cf_bgPos .'; background-color:'. $nvr_cf_bgColor .';';
		if($nvr_cf_bgSize){
			$nvr_outertopcss .='background-size:'. $nvr_cf_bgSize .';';
		}
		$nvr_print_custom_css .='#outerafterheader, .nvrlayout5 #outertop{'.$nvr_outertopcss.'}';
		
		$nvr_logo_height = constance_get_option( 'constance_logo_image_height');
		if($nvr_logo_height!='' && is_numeric($nvr_logo_height) && $nvr_logo_height>0){
			$nvr_header_height = 28 + 28 + $nvr_logo_height;
			
			$nvr_print_custom_css .='div.logoimg img{height:'. $nvr_logo_height .'px;}';
		}
		
		$nvr_MenuOutput = '';
		if($nvr_optMenuFont){
			foreach($nvr_optMenuFont as $nvr_MenuFont => $nvr_MenuFontVal){
				if($nvr_MenuFont!='google' && $nvr_MenuFont!='subsets' && $nvr_MenuFont!='font-options' && $nvr_MenuFontVal!=''){
					if($nvr_MenuFont=='font-family'){$nvr_MenuFontVal = "'".$nvr_MenuFontVal."', sans-serif !important";}
					$nvr_MenuOutput .= $nvr_MenuFont. ": ".$nvr_MenuFontVal.";";
				}
			}
		}
		
		if(strlen($nvr_MenuOutput)>0){
			$nvr_print_custom_css .='.topnav li a span.link_content, body.novaro #topminicart .topcartbutton, .searchbox .submittext, #togglesidemenu, .gn-menu li a, .gn-menu li a:visited, body.novaro .loginformbox .febuttoncontainer a.button, #widget-filter-button, .topproductfiltercontainer, .topproductfiltercontainer .isotope-filter li a, .tagcloud a{'.$nvr_MenuOutput.'}';
		}elseif($nvr_generalTextOutput!=''){
			$nvr_print_custom_css .='.topnav li a span.link_content, #togglesidemenu, .gn-menu li a, .gn-menu li a:visited, body.novaro .loginformbox .febuttoncontainer a.button, #widget-filter-button, .topproductfiltercontainer, .topproductfiltercontainer .isotope-filter li a, .tagcloud a{font-family:'. $nvr_generalTextOutput .', sans-serif !important;}';
		}
		
		$nvr_2ndMenuOutput = '';
		if($nvr_opt2ndMenuFont){
			foreach($nvr_opt2ndMenuFont as $nvr_2ndMenuFont => $nvr_2ndMenuFontVal){
				if($nvr_2ndMenuFont!='google' && $nvr_2ndMenuFont!='subsets' && $nvr_2ndMenuFont!='font-options' && $nvr_2ndMenuFontVal!=''){
					if($nvr_2ndMenuFont=='font-family'){$nvr_2ndMenuFontVal = "'".$nvr_2ndMenuFontVal."', sans-serif !important";}
					$nvr_2ndMenuOutput .= $nvr_2ndMenuFont. ": ".$nvr_2ndMenuFontVal.";";
				}
			}
		}
		
		if(strlen($nvr_2ndMenuOutput)>0){
			$nvr_print_custom_css .='#secondarynav li a, #secondarynav li a:visited{'.$nvr_2ndMenuOutput.'}';
		}elseif($nvr_generalTextOutput!=''){
			$nvr_print_custom_css .='#secondarynav li a, #secondarynav li a:visited{font-family:'. $nvr_generalTextOutput .', sans-serif !important;}';
		}
		
		if($nvr_str2ndnavBG!=''){
			$nvr_print_custom_css .='#headertext{'.$nvr_str2ndnavBG.'}';
		}
		
		$nvr_2ndfontcss = '';
		if($nvr_opt2ndFont){
			foreach($nvr_opt2ndFont as $nvr_2ndFont => $nvr_2ndFontVal){
				if($nvr_2ndFont!='google' && $nvr_2ndFont!='subsets' && $nvr_2ndFont!='font-options' && $nvr_2ndFontVal!=''){
					if($nvr_2ndFont=='font-family'){$nvr_2ndFontVal = "'".$nvr_2ndFontVal."'";}
					$nvr_2ndfontcss .= $nvr_2ndFont. ": ".$nvr_2ndFontVal.";";
				}
			}
		}
		$nvr_print_custom_css .='.nvrsecondfont, body.novaro div.product .summary .price{'. $nvr_2ndfontcss .'}';
		$nvr_print_custom_css .='.nvr-trotating blockquote{'. $nvr_2ndfontcss .'}';
		
		$nvr_bigtextcss = '';
		if($nvr_optBigTextFont){
			foreach($nvr_optBigTextFont as $nvr_bigTextFont => $nvr_bigTextFontVal){
				if($nvr_bigTextFont!='google' && $nvr_bigTextFont!='subsets' && $nvr_bigTextFont!='font-options' && $nvr_bigTextFontVal!=''){
					if($nvr_bigTextFont=='font-family'){$nvr_bigTextFontVal = "'".$nvr_bigTextFontVal."'";}
					$nvr_bigtextcss .= $nvr_bigTextFont. ": ".$nvr_bigTextFontVal.";";
				}
			}
		}
		$nvr_print_custom_css .='.bigtext{'. $nvr_bigtextcss .'}';
		
		$nvr_headingfontcss = '';
		if($nvr_optHeadingFont){
			foreach($nvr_optHeadingFont as $nvr_HeadingFont => $nvr_HeadingFontVal){
				if($nvr_HeadingFont!='google' && $nvr_HeadingFont!='subsets' && $nvr_HeadingFont!='font-options' && $nvr_HeadingFontVal!=''){
					if($nvr_HeadingFont=='font-family'){$nvr_HeadingFontVal = "'".$nvr_HeadingFontVal."'";}
					$nvr_headingfontcss .= $nvr_HeadingFont. ": ".$nvr_HeadingFontVal.";";
				}
			}
		}
		$nvr_print_custom_css .='h1, h2, h3, h4, h5, h6, a.sliderbutton, body.novaro ul.products li.product .nvr-productcat, .nvr_selector, body.novaro div.product form.cart table.variations td.label, body.novaro div.product .woocommerce-tabs ul.tabs li a, .filterlist li, #filterlist li, #filters li, .nvr_gridimg .gridsubtitle, .nvr_gridimg .cellcontent > table .tabletd .gridlinktext{'. $nvr_headingfontcss .'}';
		
		if($nvr_cf_paddingbottom){
			$nvr_print_custom_css .='#subbody #outermain{padding-bottom:'.$nvr_cf_paddingbottom.';}';
		}
		
		if($nvr_cf_paddingtop){
			$nvr_print_custom_css .='#subbody #outermain{padding-top:'.$nvr_cf_paddingtop.';}';
		}
		
		if($nvr_txtContainerWidth){
			$nvr_print_custom_css .='#subbody .container{max-width:'. $nvr_txtContainerWidth.'px;}';
		}
		if( $nvr_txtContainerWidth>1100){
			$nvr_headertitlewidth =  $nvr_txtContainerWidth - 30;
		}else{
			$nvr_headertitlewidth =  $nvr_txtContainerWidth - 20;
		}
		$nvr_print_custom_css .='.nvrlayout1.nvrboxed #subbody, .nvrlayout2.nvrboxed #subbody{max-width:'. $nvr_txtContainerWidth.'px;}';
		
		$nvr_outermain = '';
		if($nvr_cf_bgMainC){
			$nvr_outermain .='background-image:url('. $nvr_cf_bgMainC .');';
		}
		$nvr_outermain .='background-repeat:'. $nvr_cf_bgRepeatMainC .'; background-position:'. $nvr_cf_bgPosMainC .'; background-color:'. $nvr_cf_bgColorMainC .';';
		
		$nvr_print_custom_css .= '#outermain{'.$nvr_outermain.'}';
		
		
		$nvr_outeraftercontent = '';
		if($nvr_cf_bgAfterC){
			$nvr_outeraftercontent .= 'background-image:url('. $nvr_cf_bgAfterC .');';
		}
		$nvr_outeraftercontent .= 'background-repeat:'. $nvr_cf_bgRepeatAfterC .'; background-position:'. $nvr_cf_bgPosAfterC .'; background-color:'. $nvr_cf_bgColorAfterC .';';
		if($nvr_cf_bgSizeAfterC){
			$nvr_outertopcss .='background-size:'. $nvr_cf_bgSizeAfterC .';';
		}
		$nvr_print_custom_css .= '#outeraftercontent{'. $nvr_outeraftercontent .'}';
		
		$nvr_footerwrapper = '';
		if($nvr_cf_bgFooter){
			$nvr_footerwrapper .= 'background-image:url('. $nvr_cf_bgFooter .');';
		}
		if($nvr_cf_bgRepeatFooter){
			$nvr_outertopcss .='background-size:'. $nvr_cf_bgSizeFooter .';';
		}
		$nvr_footerwrapper .= 'background-repeat:'. $nvr_cf_bgRepeatFooter .'; background-position:'. $nvr_cf_bgPosFooter .'; background-color:'. $nvr_cf_bgColorFooter .';';
		$nvr_print_custom_css .= '#footerwrapper{'. $nvr_footerwrapper .'}';
		
		return $nvr_print_custom_css;
		
	}// end function nvr_print_stylesheet
}

function constance_admin_styles(){
	wp_register_style('nvr_common-css', CONSTANCE_CSSURI .'backend/common.css', '', '', 'screen, all');
	wp_enqueue_style('nvr_common-css');
}

add_action('admin_enqueue_scripts', 'constance_admin_styles');