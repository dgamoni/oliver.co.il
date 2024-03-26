<?php 

function constance_set_metaboxes(){
	
	global $wpdb;
	
	$nvr_optsidebar = array(
		"constance-sidebar" => "Sidebar", 
	);
	$nvr_optionsidebarval = get_option( 'constance_sidebar');
		if(is_array($nvr_optionsidebarval)){
			
			foreach($nvr_optionsidebarval as $ids => $val){
				$nvr_optsidebar[$ids] = $val;
			}
			
		}
	
	
	/* Option */
	$nvr_optonoff = array(
		'true' => esc_html__('On', "constance"),
		'false' => esc_html__('Off', "constance")
	);
	
	$nvr_optyesno = array(
		'true' => esc_html__('Yes', "constance"),
		'false' => esc_html__('No', "constance")
	);
	
	$nvr_optslidertype = array(
		'flexslider' => 'Flexslider',
		'layerslider' => 'LayerSlider'
	);
	
	$nvr_optslidersize = array(
		'small' => esc_html__('Small', "constance"),
		'big' => esc_html__('Big', "constance")
	);
	
	$nvr_optheadercolor = array(
		'default' => esc_html__('Default', "constance"),
		'nvrlightmenu' => esc_html__('Light', "constance"),
		'nvrdarkmenu' => esc_html__('Dark', "constance")
	);
	
	$nvr_optlayout = array(
		'' => esc_html__('Default', "constance"),
		'left' => esc_html__('Left', "constance"),
		'right' => esc_html__('Right', "constance")
	);
	
	$nvr_optbloglayout = array(
		'' => esc_html__('Default', "constance"),
		'3col-masonry' => esc_html__('Masonry 3 Columns', "constance"),
		'2col-masonry' => esc_html__('Masonry 2 Columns', "constance")
	);
	
	$nvr_opttextalign = array(
		'left' => esc_html__('Left', "constance"),
		'right' => esc_html__('Right', "constance")
	);
	
	$nvr_optslidertextalign = array(
		'top' => esc_html__('Top', "constance"),
		'left' => esc_html__('Left', "constance"),
		'right' => esc_html__('Right', "constance")
	);
	
	$nvr_optpcolumns = array(
		'' => 'Default',
		'classic-2-space' => esc_html__('Classic Two Columns', "constance"),
		'classic-3-space' => esc_html__('Classic Three Columns', "constance"),
		'classic-4-space' => esc_html__('Classic Four Columns', "constance"),
		'masonry-3-space' => esc_html__('Masonry Three Columns with space', "constance"),
		'masonry-4-space' => esc_html__('Masonry Four Columns with space', "constance"),
		'masonry-5-space' => esc_html__('Masonry Five Columns with space', "constance"),
		'masonry-3-nospace' => esc_html__('Masonry Three Columns with no space', "constance"),
		'masonry-4-nospace' => esc_html__('Masonry Four Columns with no space', "constance"),
		'masonry-5-nospace' => esc_html__('Masonry Five Columns with no space', "constance"),
		'grid-3-space'	=> esc_html__('Grid Three Columns with space', "constance"),
		'grid-4-space'	=> esc_html__('Grid Four Columns with space', "constance"),
		'grid-5-space'	=> esc_html__('Grid Five Columns with space', "constance"),
		'grid-3-nospace'	=> esc_html__('Grid Three Columns with no space', "constance"),
		'grid-4-nospace'	=> esc_html__('Grid Four Columns with no space', "constance"),
		'grid-5-nospace'	=> esc_html__('Grid Five Columns with no space', "constance")
	);
	
	$nvr_optpcontainer = array(
		'' => 'Default',
		'nvr-fullwidthwrap' => esc_html__('100% Full-Width', "constance")
	);
	
	$nvr_optccontainer = array(
		'default' => 'Default',
		'nvrfullwidthcontent' => esc_html__('100% Full-Width', "constance")
	);
	
	$nvr_optpitemtype = array(
		'' => esc_html__('Default', "constance"),
		'square' => esc_html__('Square', "constance"),
		'portrait' => esc_html__('Portrait', "constance"),
		'landscape' => esc_html__('Landscape', "constance")
	);
	
	$nvr_optarrange = array(
		'ASC' => esc_html__('Ascending', "constance"),
		'DESC' => esc_html__('Descending', "constance")
	);
	
	$nvr_optbgrepeat = array(
		'' => 'Default',
		'repeat' => 'repeat',
		'no-repeat' => 'no-repeat',
		'repeat-x' => 'repeat-x',
		'repeat-y' => 'repeat-y'
	);
	
	$nvr_optbgattch = array(
		'' => 'Default',
		'scroll' => 'scroll',
		'fixed' => 'fixed'
	);
	
	$nvr_imagepath =  get_template_directory_uri() . '/images/backendimage/';
	$nvr_optlayoutimg = array(
		'default' => $nvr_imagepath.'mb-default.png',
		'one-col' => $nvr_imagepath.'mb-1c.png',
		'two-col-left' => $nvr_imagepath.'mb-2cl.png',
		'two-col-right' => $nvr_imagepath.'mb-2cr.png'
	);
	// Create meta box slider
	global $constance_meta_boxes;
	$constance_meta_boxes = array();
	
	$constance_meta_boxes[] = array(
		'id' => 'post-option-meta-box',
		'title' => esc_html__('Post Options',"constance"),
		'page' => 'post',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Layout',"constance"),
				'desc' => '<em>'.esc_html__('Select the layout you want on this specific post/page. Overrides default site layout.',"constance").'</em>',
				'options' => $nvr_optlayoutimg,
				'id' => '_nvr_layout',
				'type' => 'selectimage',
				'std' => ''
			),
			array(
				'name' => esc_html__('External URL',"constance"),
				'desc' => '<em>'.esc_html__('Input your external link in here. if you use "Link" format.',"constance").'</em>',
				'id' => '_nvr_external_url',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Audio File URL',"constance"),
				'desc' => '<em>'.esc_html__('Input your audio file URL in here. ',"constance").'</em>',
				'id' => '_nvr_audio_url',
				'type' => 'textarea',
				'std' => ''
			),
			array(
				'name' => esc_html__('Video File URL / Video Link',"constance"),
				'desc' => '<em>'.esc_html__('Input your video file URL or video link like youtube or vimeo in here. ',"constance").'</em>',
				'id' => '_nvr_video_url',
				'type' => 'textarea',
				'std' => ''
			)
		)
	);
	
	
	$constance_meta_boxes[] = array(
		'id' => 'page-option-meta-box',
		'title' => esc_html__('Page Options',"constance"),
		'page' => 'page',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Layout',"constance"),
				'desc' => '<em>'.esc_html__('Select the layout you want on this specific post/page. Overrides default site layout.',"constance").'</em>',
				'options' => $nvr_optlayoutimg,
				'id' => '_nvr_layout',
				'type' => 'selectimage',
				'std' => ''
			),
			array(
				'name' => esc_html__('Header Menu Color',"constance"),
				'desc' => '<em>'.esc_html__('Choose the color of your header menu.',"constance").'</em>',
				'id' => 'headermenu_color',
				'type' => 'select',
				'options' => $nvr_optheadercolor,
				'std' => 'default'
			),
			array(
				'name' => esc_html__('Enable Breadcrumb',"constance"),
				'desc' => '<em>'.esc_html__('Choose \'Yes\' if you want to show breadcrumb.',"constance").'</em>',
				'id' => 'show_breadcrumb',
				'type' => 'select',
				'options' => $nvr_optyesno,
				'std' => 'true'
			),
			array(
				'name' => esc_html__('Disable Page Title',"constance"),
				'desc' => '<em>'.esc_html__('Choose \'Yes\' if you want to remove the page title.',"constance").'</em>',
				'id' => 'disable_title',
				'type' => 'select',
				'options' => $nvr_optyesno,
				'std' => 'false'
			),
			array(
				'name' => esc_html__('Main Content Padding Top',"constance"),
				'desc' => '<em>'.esc_html__('Input the padding top value in pixel. example : 12px',"constance").'</em>',
				'id' => 'main_paddingtop',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Main Content Padding Bottom',"constance"),
				'desc' => '<em>'.esc_html__('Input the padding bottom value in pixel. example : 12px',"constance").'</em>',
				'id' => 'main_paddingbottom',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Background Header',"constance"),
				'desc' => '<em>'.esc_html__('Input the image URL in this textbox if you want to change the background image on the header.',"constance").'</em>',
				'id' => 'bg_header',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Background Color Maincontent',"constance"),
				'desc' => '<em>'.esc_html__('Input the hexcolor in this textbox if you want to change the background color of your content.',"constance").'</em>',
				'id' => 'bg_color_maincontent',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Page Description',"constance"),
				'desc' => '<em>'.esc_html__('Input your own page description here.',"constance").'</em>',
				'id' => '_nvr_pagedesc',
				'type' => 'text',
				'std' => ''
			)
		)
	);
	
	$constance_meta_boxes[] = array(
		'id' => 'page-sidebar-meta-box',
		'title' => esc_html__('Sidebar Option',"constance"),
		'page' => 'page',
		'showbox' => 'meta_option_show_box',
		'context' => 'side',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Registered Sidebar',"constance"),
				'desc' => '<em>'.esc_html__('Please choose the sidebar for this page',"constance").'</em>',
				'options' => $nvr_optsidebar,
				'id' => '_nvr_sidebar',
				'type' => 'select',
				'std' => ''
			)
		)
	);
	
	$constance_meta_boxes[] = array(
		'id' => 'page-slider-option-meta-box',
		'title' => esc_html__('Page Slider Options',"constance"),
		'page' => 'page',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Enable Slider',"constance"),
				'desc' => '<em>'.esc_html__('Choose \'On\' if you want to show the slider.',"constance").'</em>',
				'id' => 'enable_slider',
				'type' => 'select',
				'options' => $nvr_optonoff,
				'std' => 'false'
			),
			array(
				'name' => esc_html__('Slider Category',"constance"),
				'desc' => '<em>'.esc_html__('You need to select the slider category to make the slider works.',"constance").'</em>',
				'id' => 'slider_category',
				'type' => 'select-slider-category',
				'std' => ''
			),
			array(
				'name' => esc_html__('External Slider Shortcode',"constance"),
				'desc' => '<em>'.esc_html__('You can put the layerslider or revolution slider shortcode in here. It will overwrite the slider category.',"constance").'</em>',
				'id' => 'slider_layerslider',
				'type' => 'text',
				'std' => ''
			)
		)
	);
	
	$constance_meta_boxes[] = array(
		'id' => 'page-blog-option-meta-box',
		'title' => esc_html__('Page Blog Options',"constance"),
		'page' => 'page',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Blog Categories',"constance"),
				'desc' => '<em>'.esc_html__('You need to tick the blog categories to make the template blog works.',"constance").'</em>',
				'id' => 'blog_category',
				'type' => 'checkbox-blog-categories',
				'std' => ''
			),
			array(
				'name' => esc_html__('Blog Type',"constance"),
				'desc' => '<em>'.esc_html__('Choose the type of the blog that you want to show.',"constance").'</em>',
				'id' => 'blog_layout',
				'type' => 'select',
				'options' => $nvr_optbloglayout,
				'std' => ''
			),
			array(
				'name' => esc_html__('Use Infinite Scrolls?',"constance"),
				'desc' => '<em>'.esc_html__('Choose \'On\' if you want to use infinite scrolls.',"constance").'</em>',
				'id' => 'blog_infscrolls',
				'type' => 'select',
				'options' => $nvr_optonoff,
				'std' => 'false'
			)
		)
	);
	
	$constance_meta_boxes[] = array(
		'id' => 'page-portfolio-option-meta-box',
		'title' => esc_html__('Page Portfolio Options',"constance"),
		'page' => 'page',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Portfolio Type',"constance"),
				'desc' => '<em>'.esc_html__('Select the type of your portfolio.',"constance").'</em>',
				'id' => 'p_type',
				'type' => 'select',
				'options' => $nvr_optpcolumns,
				'std' => '3'
			),
			array(
				'name' => esc_html__('Portfolio Container',"constance"),
				'desc' => '<em>'.esc_html__('Select the type of container for your portfolio.',"constance").'</em>',
				'id' => 'p_container',
				'type' => 'select',
				'options' => $nvr_optpcontainer,
				'std' => ''
			),
			array(
				'name' => esc_html__('Portfolio Categories',"constance"),
				'desc' => '<em>'.esc_html__('Select more than one portfolio category to make the portfolio filter works.',"constance").'</em>',
				'id' => 'p_categories',
				'type' => 'checkbox-portfolio-categories',
				'std' => ''
			),
			array(
				'name' => esc_html__('Use Auto Load More?',"constance"),
				'desc' => '<em>'.esc_html__('Tick this checkbox if you want to use a Load More functionality.',"constance").'</em>',
				'id' => 'p_loadmore',
				'type' => 'checkbox',
				'std' => ''
			),
			array(
				'name' => esc_html__('Portfolio Showposts',"constance"),
				'desc' => '<em>'.esc_html__('Input the number of portfolio items that you want to show per page.',"constance").'</em>',
				'id' => 'p_showpost',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Portfolio Order By',"constance"),
				'desc' => '<em>'.esc_html__('(optional). Sort retrieved portfolio items by parameter. Defaults to \'date\'',"constance").'</em>',
				'id' => 'p_orderby',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Portfolio Order',"constance"),
				'desc' => '<em>'.esc_html__('(optional). Designates the ascending or descending order of the \'Portfolio Order By\' parameter. Defaults to \'DESC\'.',"constance").'</em>',
				'id' => 'p_sort',
				'type' => 'text',
				'std' => ''
			)
		)
	);
	
	$constance_meta_boxes[] = array(
		'id' => 'portfolio-option-meta-box',
		'title' => esc_html__('Portfolio Options',"constance"),
		'page' => 'portofolio',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Layout',"constance"),
				'desc' => '<em>'.esc_html__('Select the layout you want on this specific post/page. Overrides default site layout.',"constance").'</em>',
				'options' => $nvr_optlayoutimg,
				'id' => '_nvr_layout',
				'type' => 'selectimage',
				'std' => ''
			),
			array(
				'name' => esc_html__('Disable Page Title',"constance"),
				'desc' => '<em>'.esc_html__('Choose \'Yes\' if you want to remove the page title.',"constance").'</em>',
				'id' => 'disable_title',
				'type' => 'select',
				'options' => $nvr_optyesno,
				'std' => 'false'
			),
			array(
				'name' => esc_html__('Image Size',"constance"),
				'desc' => '<em>'.esc_html__('Select the image size for your portfolio item.',"constance").'</em>',
				'options' => $nvr_optpitemtype,
				'id' => '_nvr_pimgsize',
				'type' => 'select',
				'std' => ''
			),
			array(
				'name' => esc_html__('Custom Thumbnail',"constance"),
				'desc' => '<em>'.esc_html__('(optional). You can input the custom image URL to override the \'Set Featured Image\'',"constance").'</em>',
				'id' => 'custom_thumb',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('External Link',"constance"),
				'desc' => '<em>'.esc_html__('(optional). You can input the URL if you want to link the portfolio item to another website.',"constance").'</em>',
				'id' => 'external_link',
				'type' => 'text',
				'std' => ''
			)
		)
	);
	
	$constance_meta_boxes[] = array(
		'id' => 'portfolio-gallery-option-meta-box',
		'title' => esc_html__('Portfolio Gallery',"constance"),
		'page' => 'portofolio',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Portfolio Images Gallery',"constance"),
				'desc' => '<em>'.esc_html__('You can select the images for your portfolio from here.',"constance").'</em>',
				'id' => 'nvr_imagesgallery',
				'type' => 'imagegallery',
				'std' => ''
			)
		)
	);
	
	$constance_meta_boxes[] = array(
		'id' => 'people-option-meta-box',
		'title' => esc_html__('People Options',"constance"),
		'page' => 'peoplepost',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('People Information',"constance"),
				'desc' => '<em>'.esc_html__('Input your own people post information here.',"constance").'</em>',
				'id' => '_nvr_people_info',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Pinterest Link',"constance"),
				'desc' => '<em>'.esc_html__('Input your own people post information here.',"constance").'</em>',
				'id' => '_nvr_people_pinterest',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Facebook Link',"constance"),
				'desc' => '<em>'.esc_html__('Input the people facebook link in here.',"constance").'</em>',
				'id' => '_nvr_people_facebook',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Twitter Link',"constance"),
				'desc' => '<em>'.esc_html__('Input the people facebook link in here.',"constance").'</em>',
				'id' => '_nvr_people_twitter',
				'type' => 'text',
				'std' => ''
			)
		)
	);
	
	$constance_meta_boxes[] = array(
		'id' => 'testimonial-option-meta-box',
		'title' => esc_html__('Testimonial Options',"constance"),
		'page' => 'testimonialpost',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Testimonial Information',"constance"),
				'desc' => '<em>'.esc_html__('Input your own testimonial post information here.',"constance").'</em>',
				'id' => '_nvr_testi_info',
				'type' => 'text',
				'std' => ''
			)
		)
	);
	
	$constance_meta_boxes[] = array(
		'id' => 'brand-option-meta-box',
		'title' => esc_html__('Brand Options',"constance"),
		'page' => 'brand',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('External Link',"constance"),
				'desc' => '<em>'.esc_html__('Input the external link for your brand post in here. (optional)',"constance").'</em>',
				'id' => 'external_link',
				'type' => 'text',
				'std' => ''
			)
		)
	);
	
	$constance_meta_boxes[] = array(
		'id' => 'slider-option-meta-box',
		'title' => esc_html__('Slider Options',"constance"),
		'page' => 'slider-view',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('External Link',"constance"),
				'desc' => '<em>'.esc_html__('(optional). You can input the URL if you want to link the slider image to another website.',"constance").'</em>',
				'id' => 'external_link',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Top Text',"constance"),
				'desc' => '<em>'.esc_html__('(optional). You can input the text above the title in here.',"constance").'</em>',
				'id' => 'top_text',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Custom Image URL',"constance"),
				'desc' => '<em>'.esc_html__('(optional). You can input the custom image URL to override the \'Set Featured Image\'',"constance").'</em>',
				'id' => 'image_url',
				'type' => 'text',
				'std' => ''
			),
			array(
				'name' => esc_html__('Button Text',"constance"),
				'desc' => '<em>'.esc_html__('(optional). You can input the custom text for your button.',"constance").'</em>',
				'id' => 'button_text',
				'type' => 'text',
				'std' => ''
			)
		)
	);
	
	$constance_meta_boxes[] = array(
		'id' => 'product-option-meta-box',
		'title' => esc_html__('Product Options',"constance"),
		'page' => 'product',
		'showbox' => 'meta_option_show_box',
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => esc_html__('Layout',"constance"),
				'desc' => '<em>'.esc_html__('Select the layout you want on this specific post/page. Overrides default site layout.',"constance").'</em>',
				'options' => $nvr_optlayoutimg,
				'id' => '_nvr_layout',
				'type' => 'selectimage',
				'std' => ''
			),
			array(
				'name' => esc_html__('Disable Page Title',"constance"),
				'desc' => '<em>'.esc_html__('Choose \'Yes\' if you want to remove the page title.',"constance").'</em>',
				'id' => 'disable_title',
				'type' => 'select',
				'options' => $nvr_optyesno,
				'std' => 'false'
			)
		)
	);

}
add_action('after_setup_theme', 'constance_set_metaboxes');
?>