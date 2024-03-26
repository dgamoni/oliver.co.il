<?php
$nvr_sliderarrange = constance_get_option( 'constance_slider_arrange');
$nvr_sliderDisableText = constance_get_option( 'constance_slider_disable_text');

$nvr_prefix = 'nvr_';
$nvr_pid = constance_get_postid();
$nvr_custom = constance_get_customdata($nvr_pid);
$nvr_cf_sliderCategory 	= (isset($nvr_custom["slider_category"][0]))? $nvr_custom["slider_category"][0] : "";
$nvr_cf_sliderLayer		= (isset($nvr_custom["slider_layerslider"][0]))? $nvr_custom["slider_layerslider"][0] : "";
$nvr_cf_sliderMenu 		= (isset($nvr_custom["slider_menu"][0]))? $nvr_custom["slider_menu"][0] : "";
?>
<!-- SLIDER -->
<div id="outerslider">
	<?php 
	if($nvr_cf_sliderLayer==''){ 
	?>
    <div id="slidercontainer" class="container">
        <section id="slider" class="row">
            <div id="slideritems" class="flexslider preloader twelve columns">
                <ul class="slides">
                    <?php
                    $nvr_catSlider = get_term_by('slug', $nvr_cf_sliderCategory, "slidercat");
                    if($nvr_cf_sliderCategory!=""){
                        $nvr_catSliderInclude = '&slidercat='. $nvr_catSlider->slug ;
                    }
                    
					$nvr_sliderqry = new WP_Query('post_type=slider-view'.$nvr_catSliderInclude.'&post_status=publish&showposts=-1&order=' . $nvr_sliderarrange);
					
					if( $nvr_sliderqry->have_posts() ){
						while ( $nvr_sliderqry->have_posts() ) : $nvr_sliderqry->the_post();
						
							$nvr_prefix = 'if_';
							$nvr_custom = get_post_custom( get_the_ID() );
							$nvr_thumbid = get_post_thumbnail_id( get_the_ID() );
							$nvr_slidersrc = wp_get_attachment_image_src( $nvr_thumbid, 'full' );
							if($nvr_slidersrc!=false){
								$nvr_cf_thumb = $nvr_slidersrc[0];
							}else{
								$nvr_cf_thumb = '';
							}
							
							$nvr_cf_slideurl = (isset($nvr_custom["external_link"][0]))?$nvr_custom["external_link"][0] : "";
							$nvr_cf_toptext = (isset($nvr_custom["top_text"][0]) && $nvr_custom["top_text"][0]!='')? $nvr_custom["top_text"][0] : "";
							$nvr_cf_thumb = (isset($nvr_custom["image_url"][0]) && $nvr_custom["image_url"][0]!='')? $nvr_custom["image_url"][0] : $nvr_cf_thumb;
							$nvr_cf_buttontext = (isset($nvr_custom["button_text"][0]) && $nvr_custom["button_text"][0]!='')? $nvr_custom["button_text"][0] : esc_html__('Shop Now', 'constance');
							$nvr_cf_talign = (isset($nvr_custom["text_align"][0]))? $nvr_custom["text_align"][0] : "";
							
							$nvr_output = $nvr_style ="";
							
							$nvr_style .= 'background-image:url('.esc_url( $nvr_cf_thumb ).');';
							
							echo '<li style="'.esc_attr( $nvr_style ).'">';
								if($nvr_cf_slideurl!=""){
									echo '<a href="'.esc_url( $nvr_cf_slideurl ).'">';
								}
							   
								echo '<img src="'. esc_url( $nvr_cf_thumb ).'" alt="'.get_the_title().'" />';
									
								if($nvr_cf_slideurl!=""){
									echo '</a>';
								}
								
							   //slider text
							   if($nvr_sliderDisableText!=true){
									if($nvr_cf_talign=="left"){
										$nvr_talign = "left";
									}elseif($nvr_cf_talign=="right"){
										$nvr_talign = "right";
									}else{
										$nvr_talign = "top";
									}
								   echo '<div class="flex-caption">';
									echo '<div class="text-caption '.esc_attr( $nvr_talign ).'">';
										echo '<div class="caption-content">';
									if($nvr_cf_toptext!=""){
										echo '<h3 class="slidertoptext">'.esc_html($nvr_cf_toptext).'</h3>';
									}
								   if($nvr_cf_slideurl!=""){
									   echo '<h2><a href="'.esc_url( $nvr_cf_slideurl ).'">'.get_the_title().'</a></h2>';
								   }else{
									   echo '<h2>'.get_the_title().'</h2>';
								   }
								   
								   if($nvr_cf_slideurl!=""){
									   echo '<div class="nvrsecondfont"><a href="'.esc_url( $nvr_cf_slideurl ).'">'.get_the_excerpt().'</a></div>';
									   if($nvr_cf_buttontext==""){
									   		$nvr_cf_buttontext = esc_html__('Shop Now', 'constance');
									   }
									   echo '<a class="sliderbutton" href="'.esc_url( $nvr_cf_slideurl ).'"><span>'.esc_html( $nvr_cf_buttontext ).'</span></a>';
								   }else{
									   echo '<div class="nvrsecondfont">'.get_the_excerpt().'</div>';
								   }
								   
										echo '</div>';
										echo '<div class="clearfix"></div>';
									echo '</div>';
								   echo '</div>';
							   }
								
							echo '</li>';
						
						endwhile;
					}
                    wp_reset_postdata();
                    ?>
                </ul>
            </div>
            <div class="clearfix"></div>
        </section>
        <div class="clearfix"></div>
    </div>
    <?php 
	}else{ 
		echo do_shortcode($nvr_cf_sliderLayer);
    } 
	?>
</div>
<!-- END SLIDER -->