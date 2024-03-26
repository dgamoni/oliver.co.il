<?php

/**
  ReduxFramework Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Redux_Framework_constance_config')) {

    class Redux_Framework_constance_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        public function setSections() {
			
			$nvr_optLogotype 	= array(
				'imagelogo' 	=> esc_html__('Image logo', "constance"),
				'textlogo' 		=> esc_html__('Text-based logo', "constance")
				 );
			
			$nvr_optWebLayout	= array(
				'nvrlayout1'	=> esc_html__('Version 1', "constance"),
				'nvrlayout2'	=> esc_html__('Version 2', "constance"),
				'nvrlayout3'	=> esc_html__('Version 3', "constance"),
				'nvrlayout4'	=> esc_html__('Version 4', "constance")
			);
			
			$nvr_opt2ndbarloc 	= array(
				'nvrtopbar' 	=> esc_html__('Above the logo', "constance"),
				'nvrbelowbar' => esc_html__('Below the logo', "constance")
				 );
			
			$nvr_optheadercolor = array(
				'nvrlightmenu' => esc_html__('Light', "constance"),
				'nvrdarkmenu' => esc_html__('Dark', "constance")
			);
			
			$nvr_optHeaderPos 	= array(
				'fixed' 	=> esc_html__('Fixed', "constance"),
				'absolute' 	=> esc_html__('Absolute', "constance")
				 );
			
			$nvr_optLayout 	= array(
				'nvrfullwidth' 	=> esc_html__('Full-Width Layout', "constance"),
				'nvrboxed' 	=> esc_html__('Boxed Layout', "constance")
				 );
			
			$nvr_google_api_output = constance_googlefontjson();
			$nvr_google_font_array = json_decode ($nvr_google_api_output,true) ;
			//print_r( json_decode ($nvr_google_api_output) );
			
			$nvr_google_items = $nvr_google_font_array['items'];
			
			$nvr_optGoogleFonts = array();
			array_push($nvr_optGoogleFonts, "Default Font");
			$nvr_fontID = 0;
			foreach ($nvr_google_items as $nvr_google_item) {
				$nvr_fontID++;
				$nvr_variants='';
				$nvr_variantCount=0;
				foreach ($nvr_google_item['variants'] as $nvr_variant) {
					$nvr_variantCount++;
					if ($nvr_variantCount>1) { $nvr_variants .= '|'; }
					$nvr_variants .= $nvr_variant;
				}
				$nvr_variantText = ' (' . $nvr_variantCount . ' Variants' . ')';
				if ($nvr_variantCount <= 1) $nvr_variantText = '';
				$nvr_optGoogleFonts[ $nvr_google_item['family'] . ':' . $nvr_variants ] = $nvr_google_item['family']. $nvr_variantText;
			}
			
			$nvr_optArrBlog = array(
				'classic' => 'Classic',
				'2col-masonry' => '2 Columns Masonry',
				'3col-masonry' => '3 Columns Masonry'
			);
			
			$nvr_optArrSlider = array(
				'ASC' => 'Ascending',
				'DESC' => 'Descending'
				 );
			
			$nvr_optSliderEffect 	= array(
					'fade'=>'Fade',
					'slide'=>'Slide'
					 );
		
			// Background Defaults
			$nvr_background_defaults = array(
				'color' => '',
				'image' => '',
				'repeat' => 'repeat',
				'position' => 'top center',
				'attachment'=>'scroll'
			);
						 
			$nvr_optBackgroundStyle = array(
				'repeat' => "Repeat",
				'repeat-x' => "Repeat Horizontal",
				'repeat-y' => "Repeat Vertical",
				'no-repeat' => "No Repeat",
				'fixed' => "Fixed"
				);
				
			$nvr_optBackgroundPosition = array(
			'left' => "Left",
			'center' => "Center",
			'right' => "Right",
			'top left' => "Top",
			'top center' => "Top Center",
			'top right' => "Top Right",
			'bottom left' => "Bottom",
			'bottom center' => "Bottom Center",
			'bottom right' => "Bottom Right"
			);
			
			$nvr_selectTextDefault = array(
				'text' => '',
				'select' => ''
			);
			
			$nvr_selectTopBar = array(
				'nvrshowtopbar' => 'On',
				'nvrnotopbar' => 'Off'
			);
			
			$nvr_optSocialIcons = array();
			
			if(function_exists('constance_fontsocialicon')){
				$nvr_optSocialIcons = constance_fontsocialicon();
			}
			
		
			// Pull all the categories into an array
			$nvr_options_categories = array();
			$nvr_options_categories_obj = get_categories();
			foreach ($nvr_options_categories_obj as $nvr_category) {
				$nvr_options_categories[$nvr_category->cat_ID] = $nvr_category->cat_name;
			}
		
			// Pull all the pages into an array
			$nvr_options_pages = array();
			$nvr_options_pages_obj = get_pages('sort_column=post_parent,menu_order');
			$nvr_options_pages[''] = 'Select a page:';
			foreach ($nvr_options_pages_obj as $nvr_page) {
				$nvr_options_pages[$nvr_page->ID] = $nvr_page->post_title;
			}
		
			// If using image radio buttons, define a directory path
			$nvr_imagepath =  get_template_directory_uri() . '/images/backendimage/';
			
			$nvr_optmainlayout = array(
				'one-col' => array('alt' => 'Full Width', 'img' => $nvr_imagepath . '1col.png'),
				'two-col-left' => array('alt' => '2 Column Left', 'img' => $nvr_imagepath . '2cl.png'),
				'two-col-right' => array('alt' => '2 Column Right',  'img' => $nvr_imagepath . '2cr.png')
			);
			
			
			
			$nvr_optfooterlayout = array(
				'0' => array('alt' => 'No Footer Sidebar',  'img' => $nvr_imagepath . 'footer-0.gif'),
				'1' => array('alt' => 'Footer Layout 1',  'img' => $nvr_imagepath . 'footer-1.gif'),
				'2' => array('alt' => 'Footer Layout 2',  'img' => $nvr_imagepath . 'footer-2.gif'),
				'3' => array('alt' => 'Footer Layout 3',  'img' => $nvr_imagepath . 'footer-3.gif'),
				'4' => array('alt' => 'Footer Layout 4',  'img' => $nvr_imagepath . 'footer-4.gif'),
				'5' => array('alt' => 'Footer Layout 5',  'img' => $nvr_imagepath . 'footer-5.gif'),
				'6' => array('alt' => 'Footer Layout 6',  'img' => $nvr_imagepath . 'footer-6.gif'),
				'7' => array('alt' => 'Footer Layout 7',  'img' => $nvr_imagepath . 'footer-7.gif'),
				'8' => array('alt' => 'Footer Layout 8',  'img' => $nvr_imagepath . 'footer-8.gif'),
				'9' => array('alt' => 'Footer Layout 9',  'img' => $nvr_imagepath . 'footer-9.gif'),
			);
			
			
			// ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'title'     => esc_html__('General Settings', "constance"),
                'desc'      => "",
                'icon'      => 'el-icon-home',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(

                    array(
                        'id'        => "constance_sidebar_position",
                        'type'      => 'image_select',
                        'title'     => esc_html__('Column Layout', "constance"),
                        'subtitle'  => esc_html__('Select the default column layout. Default layout is Two Column Left.', "constance"),
						'options'   => $nvr_optmainlayout,
                        'default'   => 'two-col-left'
                    ),
					
					array(
                        'id'        => "constance_footer_sidebar_layout",
                        'type'      => 'image_select',
                        'title'     => esc_html__('Footer Sidebar Layout', "constance"),
                        'subtitle'  => esc_html__('Select footer sidebar layout. Default sidebar is four column.', "constance"),
						'options'   => $nvr_optfooterlayout,
                        'default'   => '9'
                    ),
					
					array(
                        'id'        => "constance_disable_viewport",
                        'type'      => 'checkbox',
                        'title'     => esc_html__('Disable Responsive Feature?', "constance"),
                        'subtitle'  => esc_html__('Select this checkbox to disable the responsive website feature.', "constance"),
                        'default'   => '0',
                    ),
					
					array(
                        'id'        => "constance_logo_type",
                        'type'      => 'select',
                        'title'     => esc_html__('Logo Type', "constance"),
                        'subtitle'  => esc_html__('If text-based logo is activated, enter the logo name and logo tagline in the fields below.', "constance"),
                        
                        //Must provide key => value pairs for select options
                        'options'   => $nvr_optLogotype,
                        'default'   => 'imagelogo'
                    ),
					
					array(
                        'id'        => "constance_site_name",
                        'type'      => 'text',
                        'title'     => esc_html__('Logo Name', "constance"),
                        'subtitle'  => esc_html__('Put your logo name in here.', "constance"),
                        'validate'	=> 'no_html',
						'default'   => ''
                    ),
					
					array(
                        'id'        => "constance_tagline",
                        'type'      => 'text',
                        'title'     => esc_html__('Logo Tagline', "constance"),
                        'subtitle'  => esc_html__('Put your tagline in here.', "constance"),
						'validate'	=> 'no_html',
                        'default'   => ''
                    ),
					
					array(
                        'id'        => "constance_logo_image",
                        'type'      => 'media',
                        'title'     => esc_html__('Dark Logo Image', "constance"),
                        'compiler'  => 'true',
                        'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'subtitle'  => esc_html__('If image logo is activated, upload the logo image.', "constance"),
                    ),
					
					array(
                        'id'        => "constance_logo_image_light",
                        'type'      => 'media',
                        'title'     => esc_html__('Light Logo Image', "constance"),
                        'compiler'  => 'true',
                        'mode'      => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'subtitle'  => esc_html__('If image logo is activated, upload the logo image.', "constance"),
                    ),
					
					array(
                        'id'        => "constance_disable_footer_sidebar",
                        'type'      => 'checkbox',
                        'title'     => esc_html__('Disable Footer Sidebar?', "constance"),
                        'subtitle'  => esc_html__('Select this checkbox to disable footer sidebar feature.', "constance"),
                        'default'   => false,
                    ),
					
					array(
                        'id'        => "constance_footer",
                        'type'      => 'textarea',
                        'title'     => esc_html__('Footer Text', "constance"),
                        'subtitle'  => esc_html__('You can use html tag in here.', "constance"),
                        'validate'  => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
                        'default'   => ''
                    ),
					
					array(
                        'id'        => "constance_footer2",
                        'type'      => 'textarea',
                        'title'     => esc_html__('Footer Text 2', "constance"),
                        'subtitle'  => esc_html__('You can use html tag in here.', "constance"),
                        'validate'  => 'html', //see http://codex.wordpress.org/Function_Reference/wp_kses_post
                        'default'   => ''
                    )
                )
            );
			
			$this->sections[] = array(
                'type' => 'divide',
            );
			
			$this->sections[] = array(
                'title'     => esc_html__('Style Settings', "constance"),
                'desc'      => "",
                'icon'      => 'el-icon-adjust-alt',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(

                    array(
                        'id'            => "constance_container_width",
                        'type'          => 'slider',
                        'title'         => esc_html__('Container\'s Width', "constance"),
                        'subtitle'      => esc_html__('You can change the global container\s width from here', "constance"),
                        'desc'          => esc_html__('Set the length of your container\'s width between 940px - 1200px', "constance"),
                        'default'       => 1170,
                        'min'           => 940,
                        'step'          => 1,
                        'max'           => 1200,
                        'display_value' => 'text'
                    ),
					
					array(
                        'id'        => "constance_web_layout",
                        'type'      => 'select',
                        'title'     => esc_html__('Theme Layout', "constance"),
                        'subtitle'  => esc_html__('Choose the layout style that suits your need', "constance"),
                        
                        //Must provide key => value pairs for select options
                        'options'   => $nvr_optWebLayout,
                        'default'   => 'nvrlayout1'
                    ),
					
					array(
                        'id'        => "constance_headermenu_color",
                        'type'      => 'select',
                        'title'     => esc_html__('Header Menu Color', "constance"),
                        'subtitle'  => esc_html__('Choose the color of your header menu', "constance"),
                        
                        //Must provide key => value pairs for select options
                        'options'   => $nvr_optheadercolor,
                        'default'   => 'nvrdarkmenu'
                    ),
					
					array(
                        'id'        => "constance_container_layout",
                        'type'      => 'select',
                        'title'     => esc_html__('Container Layout', "constance"),
                        'subtitle'  => esc_html__('Choose the container layout of your website. boxed layout cannot be used if you use Theme Layout : version 9, 11, and 12.', "constance"),
                        
                        //Must provide key => value pairs for select options
                        'options'   => $nvr_optLayout,
                        'default'   => 'nvrfullwidth'
                    ),
					
					array(
                        'id'        => "constance_color_theme",
                        'type'      => 'color',
                        'title'     => esc_html__('Theme Color Options', "constance"),
                        'subtitle'  => esc_html__('Choose the color that suit your need', "constance"),
                        'default'   => '',
                        'validate'  => 'color'
                    ),
					
					array(
                        'id'        => "constance_general_font",
                        'type'      => 'typography',
                        'title'     => esc_html__('General Fonts', "constance"),
                        'subtitle'  => esc_html__('Specify the body font properties.', "constance"),
                        'google'    => true,
                        'default'   => array(
                            'color'         => '',
                            'font-size'     => '',
							'google'		=> true,
                            'font-family'   => 'Open Sans',
                            'font-weight'   => 'Normal',
                        ),
                    ),
					
					array(
                        'id'        => "constance_bigtext_font",
                         'type'      => 'typography',
                        'title'     => esc_html__('Bigtext Shortcode Fonts', "constance"),
                        'subtitle'  => esc_html__('Choose the font for [bigtext] shortcode.', "constance"),
						'google'    => true,
                        'default'   => array(
                            'color'         => '',
                            'font-size'     => '',
                            'font-family'   => '',
                            'font-weight'   => '',
                        ),
                    ),
					
					array(
                        'id'        => "constance_heading_font",
                         'type'      => 'typography',
                        'title'     => esc_html__('Heading Fonts', "constance"),
                        'subtitle'  => esc_html__('Choose the font styles for h1, h2, h3, h4, h5, h6.', "constance"),
						'font-size' => false,
						'line-height' => false,
						'text-align' => false,
						'google'    => true,
                        'default'   => array(
                            'color'         => '',
                            'font-size'     => '',
                            'font-family'   => 'Montserrat',
                            'font-weight'   => '',
                        ),
                    ),
					
					array(
                        'id'        => "constance_menunav_font",
                        'type'      => 'typography',
                        'title'     => esc_html__('Menu Navigation Fonts', "constance"),
                        'subtitle'  => esc_html__('Choose the font for main menu.', "constance"),
						'color' => false,
						'font-size' => false,
						'font-weight' => false,
						'font-style' => false,
						'line-height' => false,
						'text-align' => false,
						'google'    => true,
                        'default'   => array(
                            'color'         => '',
                            'font-size'     => '',
                            'font-family'   => 'Montserrat'
                        ),
                    ),
					
					array(
                        'id'        => "constance_secondnav_font",
                        'type'      => 'typography',
                        'title'     => esc_html__('Secondary Menu Navigation Fonts', "constance"),
                        'subtitle'  => esc_html__('Choose the font for secondary menu.', "constance"),
						'color' => false,
						'font-size' => false,
						'font-weight' => false,
						'font-style' => false,
						'line-height' => false,
						'text-align' => false,
						'google'    => true,
                        'default'   => array(
                            'color'         => '',
                            'font-size'     => '',
                            'font-family'   => 'Montserrat',
                            'font-weight'   => '',
                        ),
                    ),
					
					array(
                        'id'        => "constance_secondnav_background",
                        'type'      => 'background',
                        'title'     => esc_html__('Secondary Background Settings', "constance"),
                        'subtitle'  => esc_html__('Change the secondary background CSS.', "constance"),
                        //'default'   => '#FFFFFF',
                    ),
					
					array(
                        'id'        => "constance_secondary_font",
                         'type'      => 'typography',
                        'title'     => esc_html__('Secondary Fonts', "constance"),
                        'subtitle'  => esc_html__('Choose the font for your secondary font. You can use it by using "nvrsecondfont" class in your tag.', "constance"),
						'font-size' => false,
						'font-weight' => false,
						'line-height' => false,
						'text-align' => false,
						'google'    => true,
                        'default'   => array(
                            'color'         => '',
                            'font-size'     => '',
                            'font-family'   => 'Droid Serif',
                            'font-weight'   => '400',
							'font-style'	=> 'italic'
                        ),
                    ),
					
					array(
                        'id'        => "constance_body_background",
                        'type'      => 'background',
                        'title'     => esc_html__('Background Settings', "constance"),
                        'subtitle'  => esc_html__('Change the background CSS.', "constance"),
                        //'default'   => '#FFFFFF',
                    ),
					
					array(
                        'id'        => "constance_disable_page_title",
                        'type'      => 'checkbox',
                        'title'     => esc_html__('Disable Page Title?', "constance"),
                        'subtitle'  => esc_html__('Select this checkbox to disable page title container.', "constance"),
                        'default'   => false,
                    ),
					
					array(
                        'id'        => "constance_header_background",
                        'type'      => 'background',
                        'title'     => esc_html__('Background Header', "constance"),
                        'subtitle'  => esc_html__('Change the background on header.', "constance"),
                        //'default'   => '#FFFFFF',
                    ),
					
					array(
                        'id'        => "constance_footer_background",
                        'type'      => 'background',
                        'title'     => esc_html__('Background Footer', "constance"),
                        'subtitle'  => esc_html__('Change the background on footer.', "constance"),
                        //'default'   => '#FFFFFF',
                    )
                )
            );
			
			$nvr_socialarr = array();
			foreach($nvr_optSocialIcons as $nvr_optSocialIcon => $nvr_optSocialText){
				$nvr_socialarr[] = array(
                        'id'        => "constance_socialicon_".$nvr_optSocialIcon,
                        'type'      => 'text',
                        'title'     => $nvr_optSocialText ." ". esc_html__('Icon', "constance"),
                        'subtitle'  => sprintf( esc_html__('Input your %s URL in here', "constance"), $nvr_optSocialText),
						'validate'	=> 'no_html',
                        'default'   => ''
              	);	
			}
			
			$this->sections[] = array(
                'title'     => esc_html__('Social Network', "constance"),
                'desc'      => "",
                'icon'      => 'el-icon-network',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => $nvr_socialarr
            );
			
			$this->sections[] = array(
                'title'     => esc_html__('Woocommerce Settings', "constance"),
                'desc'      => "",
                'icon'      => 'el-icon-shopping-cart',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(
					
					array(
                        'id'            => "constance_shop_ajax",
                        'type'          => 'checkbox',
                        'title'         => esc_html__('Using Ajax on Shop Page?', "constance"),
                        'desc'      => esc_html__('If you tick this checkbox, the shop page will use ajax for loading the product items.', "constance"),
                        'default'       => '0'
                    ),
					array(
                        'id'            => "constance_shop_masonry",
                        'type'          => 'checkbox',
                        'title'         => esc_html__('Using Masonry Layout?', "constance"),
                        'desc'      => esc_html__('If you tick this checkbox, the shop page will use masonry layout for showing the product items.', "constance"),
                        'default'       => '0'
                    ),
					array(
                        'id'            => "constance_shop_filter",
                        'type'          => 'checkbox',
                        'title'         => esc_html__('Use Product Filter For Masonry Layout?', "constance"),
                        'desc'      => esc_html__('If you tick this checkbox, the Filter Button will appear in the top of the shop page.', "constance"),
                        'default'       => '0'
                    ),
					array(
                        'id'            => "constance_disable_topsearch",
                        'type'          => 'checkbox',
                        'title'         => esc_html__('Disable Shop Search', "constance"),
                        'desc'      	=> esc_html__('Select this checkbox to disable searchbox at the top.', "constance"),
                        'default'       => '0'
                    ),
					array(
                        'id'            => "constance_shop_infscrolls",
                        'type'          => 'checkbox',
                        'title'         => esc_html__('Use Infinite Scrolls?', "constance"),
                        'desc'      => esc_html__('If you tick this checkbox, the shop page will replace the pagination with Infinite Scrolls ("Load More" Button).', "constance"),
                        'default'       => '0'
                    )
                )
            );
			
			$this->sections[] = array(
                'title'     => esc_html__('Blog Settings', "constance"),
                'desc'      => "",
                'icon'      => 'el-icon-book',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(

                    array(
                        'id'            => "constance_blog_layout",
                        'type'          => 'select',
                        'title'         => esc_html__('Blog Layouts', "constance"),
                        'subtitle'      => esc_html__('Select the default layout for your blog page.', "constance"),
                        'default'       => 'classic',
						'options'   	=> $nvr_optArrBlog
                    ),
					
					array(
                        'id'            => "constance_blog_infscrolls",
                        'type'          => 'checkbox',
                        'title'         => esc_html__('Use Infinite Scrolls?', "constance"),
                        'desc'      => esc_html__('If you tick this checkbox, the blog page will replace the pagination with Infinite Scrolls ("Load More" Button).', "constance"),
                        'default'       => '0'
                    )
                )
            );
			
			$this->sections[] = array(
                'title'     => esc_html__('Slider Settings', "constance"),
                'desc'      => "",
                'icon'      => 'el-icon-website',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(

                    array(
                        'id'            => "constance_slider_arrange",
                        'type'          => 'select',
                        'title'         => esc_html__('Arrange Slider Post', "constance"),
                        'subtitle'      => esc_html__('Select the order for your slider. the default is Ascending', "constance"),
                        'default'       => 'ASC',
						'options'   	=> $nvr_optArrSlider
                    ),
					
					array(
                        'id'            => "constance_slider_effect",
                        'type'          => 'select',
                        'title'         => esc_html__('Slider Effect', "constance"),
                        'subtitle'      => esc_html__('Please select transition effect. The default is fade', "constance"),
                        'default'       => 'fade',
						'options'   	=> $nvr_optSliderEffect
                    ),
					
					array(
                        'id'        => "constance_slider_interval",
                        'type'      => 'text',
                        'title'     => esc_html__('Slider Interval', "constance"),
                        'subtitle'  => esc_html__('Please enter number for slider interval. Default is 8000', "constance"),
						'validate'	=> 'numeric',
                        'default'   => '8000'
                    ),
					
					array(
                        'id'            => "constance_slider_disable_text",
                        'type'          => 'checkbox',
                        'title'         => esc_html__('Disable Slider Text', "constance"),
                        'desc'      	=> esc_html__('Select this checkbox to disable the slider text.', "constance"),
                        'default'       => '0'
                    ),
					
					array(
                        'id'            => "constance_slider_disable_nav",
                        'type'          => 'checkbox',
                        'title'         => esc_html__('Disable Slider Navigation', "constance"),
                        'desc'      	=> esc_html__('Select this checkbox to disable navigation.', "constance"),
                        'default'       => '0'
                    ),
					
					array(
                        'id'            => "constance_slider_disable_prevnext",
                        'type'          => 'checkbox',
                        'title'         => esc_html__('Disable Slider Previous/Next Navigation', "constance"),
                        'desc'      	=> esc_html__('Select this checkbox to disable previous/next navigation.', "constance"),
                        'default'       => '0'
                    )
                )
            );
			
			$this->sections[] = array(
                'title'     => esc_html__('Miscellaneous', "constance"),
                'desc'      => "",
                'icon'      => ' el-icon-asterisk',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(
					
					array(
                        'id'            => "constance_disable_minicart",
                        'type'          => 'checkbox',
                        'title'         => esc_html__('Disable Minicart', "constance"),
                        'desc'      	=> esc_html__('Select this checkbox to disable minicart at the top.', "constance"),
                        'default'       => '0'
                    ),
					
					array(
                        'id'            => "constance_disable_felogin",
                        'type'          => 'checkbox',
                        'title'         => esc_html__('Disable Front End Login Form', "constance"),
                        'desc'      	=> esc_html__('Select this checkbox to disable front end login form at the top.', "constance"),
                        'default'       => '0'
                    ),
					
					array(
                        'id'            => "constance_topbar",
                        'type'          => 'select',
                        'title'         => esc_html__('Right Menu Bar', "constance"),
                        'desc'      	=> esc_html__('Choose whether to remove the right menu bar or not.', "constance"),
						'options'		=> $nvr_selectTopBar,
                        'default'       => 'nvrshowtopbar'
                    ),
					
					array(
                        'id'            => "constance_enable_aftercontent",
                        'type'          => 'checkbox',
                        'title'         => esc_html__('Enable After Content Section', "constance"),
                        'desc'      	=> esc_html__('Select this checkbox to enable the After Content Section.', "constance"),
                        'default'       => '0'
                    ),
					
					array(
                        'id'        => "constance_accountlink",
                        'type'      => 'text',
                        'title'     => esc_html__('My Account URL', "constance"),
                        'subtitle'  => esc_html__('Put your my account URL in here.', "constance"),
						'validate'	=> 'url',
                        'default'   => ''
                    ),
					
					array(
                        'id'            => "constance_aftercontent_background",
                        'type'          => 'background',
                        'title'         => esc_html__('Background After Content Section', "constance"),
                        'desc'     		=> esc_html__('Change the background on after content section.', "constance"),
                        'default'       => ''
                    ),
					
					array(
                        'id'            => "constance_aftercontent_text",
                        'type'          => 'textarea',
                        'title'         => esc_html__('After Content Text', "constance"),
                        'desc'      	=> esc_html__('you can use html tag in here.', "constance"),
                        'validate'		=> 'html',
						'default'       => ''
                    ),
					
					array(
                        'id'            => "constance_demo_mode",
                        'type'          => 'checkbox',
                        'title'         => esc_html__('Demo Mode', "constance"),
                        'desc'      	=> esc_html__('For demonstration purpose only.', "constance"),
                        'default'       => '0'
                    )
                )
            );
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => esc_html__('Theme Information 1', "constance"),
                'content'   => ""
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', "constance"),
                'content'   => ""
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = "";
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'nvr_option',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => esc_html__('Theme Options', "constance"),
                'page_title'        => esc_html__('Theme Options', "constance"),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyBYxSvnMu_mABEzbRRUcGRxNTZdAnz1Rgo', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                
                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => true,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                'title' => 'Visit us on GitHub',
                'icon'  => 'el-icon-github'
                //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            );
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://twitter.com/reduxframework',
                'title' => 'Follow us on Twitter',
                'icon'  => 'el-icon-twitter'
            );
            $this->args['share_icons'][] = array(
                'url'   => 'http://www.linkedin.com/company/redux-framework',
                'title' => 'Find us on LinkedIn',
                'icon'  => 'el-icon-linkedin'
            );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                //$this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', "constance"), $v);
            } else {
                $this->args['intro_text'] = "";
            }

            // Add content after the form.
           // $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', "constance");
        }

    }
    
    add_action('after_setup_theme', 'constance_load_redux_config');
	function constance_load_redux_config(){
		global $reduxConfig;
    	$reduxConfig = new Redux_Framework_constance_config();
	}
}