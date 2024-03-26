<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Constance
 * @since Constance 1.0
 */

get_header(); 
?>

        <div id="singlepost">
        
             <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
             <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
             	<?php
                 
				$nvr_custom = get_post_custom($post->ID);
				$nvr_post_format = get_post_format();
				switch ($nvr_post_format) {
					case "video":
						
						$nvr_cf_vidurl = (isset($nvr_custom["_nvr_video_url"][0]))? $nvr_custom["_nvr_video_url"][0] : "";
						if($nvr_cf_vidurl!=''){
							echo '<div class="mediacontainer">'.apply_filters('the_content', $nvr_cf_vidurl)."</div>";
						}
						$nvr_posticon = 'fa-film';
						$nvr_postformattext = esc_html__('Video', 'constance');
						
					break;
					case "audio":
					
						$nvr_cf_audurl = (isset($nvr_custom["_nvr_audio_url"][0]))? $nvr_custom["_nvr_audio_url"][0] : "";
						if($nvr_cf_audurl!=''){
							echo '<div class="mediacontainer">'.apply_filters('the_content', $nvr_cf_audurl)."</div>";
						}
						$nvr_posticon = 'fa-volume-up';
						$nvr_postformattext = esc_html__('Audio', 'constance');
					
					break;
					case "gallery":
						
						$nvr_post_content = get_the_content();
						preg_match('/\[gallery.*ids=.(.*).\]/', $nvr_post_content, $ids);
						$nvr_array_id = explode(",", $ids[1]);
						
						$nvr_content =  str_replace($ids[0], "", $nvr_post_content);
						$nvr_filtered_content = apply_filters( 'the_content', $nvr_content);
						
						$nvr_sliderli = '';
						foreach($nvr_array_id as $nvr_img_id){
							$nvr_sliderli .= '<li><a href="'. esc_url( get_permalink() ) .'">'. wp_get_attachment_image( $nvr_img_id, 'constance-blog-post-image' ) .'</a></li>';
						}
						
						if($nvr_sliderli!=''){
							echo '<div class="gallerycontainer"><div class="flexslider"><ul class="slides">'.$nvr_sliderli."</ul></div></div>";
						}
						$nvr_posticon = 'fa-image';
						$nvr_postformattext = esc_html__('Gallery', 'constance');
						
					break;
					case "image":
						
						$nvr_cf_imgurl = (isset($nvr_custom["image_url"][0]))? $nvr_custom["image_url"][0] : "";
						$nvr_imgurl = "";
						/* temporary not used */
						if($nvr_cf_imgurl!=""){
							$nvr_imgurl = '<img src='. esc_url( $nvr_cf_imgurl ) .' alt="'. esc_attr( get_the_title( $post->ID ) ).'" class="scale-with-grid"/>';
						}elseif(has_post_thumbnail($post->ID) ){
							$nvr_imgurl = get_the_post_thumbnail($post->ID, 'constance-blog-post-image', array('class' => 'scale-with-grid'));
						}else{
							$nvr_imgurl ="";
						}
						
						if($nvr_imgurl!=''){
							echo '<div class="imgcontainer">'.$nvr_imgurl."</div>";
						}
						$nvr_posticon = 'fa-camera';
						$nvr_postformattext = esc_html__('Image', 'constance');
						
					break;
					case "quote":
						$nvr_posticon = 'fa-quote-left';
						$nvr_postformattext = esc_html__('Quote', 'constance');
						
					break;
					case "link":
						$nvr_posticon = 'fa-link';
						$nvr_postformattext = esc_html__('Link', 'constance');
						
					break;
					case "aside":
						$nvr_posticon = 'fa-bookmark';
						$nvr_postformattext = esc_html__('Aside', 'constance');
						
					break;
					
					default :
						$nvr_posticon = 'fa-file-text';
						$nvr_postformattext = "";
					break;
				}
				?>
                <?php if($nvr_postformattext!=""){ ?>
                <h6 class="meta-format"><?php echo esc_html($nvr_postformattext); ?></h6>
                <?php } ?>
                <h1 class="posttitle"><?php the_title(); ?></h1> 
                <div class="meta-date nvrsecondfont"><?php the_time('M d, Y') ?></div>
                
                 <div class="entry-content">
                    <?php 
					if(isset($nvr_filtered_content)){
						echo do_shortcode($nvr_filtered_content);
					}else{
						the_content();
					}
					?>
                    <?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . esc_html__( 'Pages:', "constance" ) . '</span>', 'after' => '</div>' ) ); ?>
                    <div class="clearfix"></div>
                </div>
                
                <div class="entry-utility">
                    <div class="entry-icon fa <?php esc_attr($nvr_posticon); ?>"></div>
                    <div class="meta-sticky"><i class="fa fa-bookmark"></i> <span class="grey"><?php esc_html_e('Sticky', "constance"); ?></span></div>
                    <div class="meta-author nvrsecondfont"><?php esc_html_e("By", "constance"); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>"><?php the_author();?></a></div>
                    <div class="meta-cat nvrsecondfont"><?php esc_html_e("In", "constance"); ?> <?php the_category(', '); ?></div>
                    <div class="meta-tags nvrsecondfont"><?php esc_html_e("Tags in", "constance"); ?> <?php the_tags('',', '); ?></div>
                    
                    <div class="meta-comment nvrsecondfont"><?php comments_popup_link( esc_html__('No Comment', "constance"), esc_html__('1 Comment', "constance"), esc_html__('% Comments', "constance")); ?></div>
                    <span class="clearfix"></span>
                </div>
                
             </article>
             <div id="prevnext-post-link">
            	<?php
				$nvr_nextpost = get_next_post(true);
				$nvr_prevpost = get_previous_post(true);
				$nvr_hasprevpost = false;
                if(!empty($nvr_prevpost)){
					$nvr_hasprevpost =true;
					echo '<div class="nav-previous"><a href="'.esc_url( get_permalink($nvr_prevpost->ID) ).'"><span class="navarrow fa fa-angle-left"></span><span class="navtext">'. esc_html__( 'Previous Article', "constance" ) .'</span><br /><span class="prevnexttitle">'.get_the_title($nvr_prevpost->ID).'</span></a></div>';
                }
				if(!empty($nvr_nextpost)){
					$nvr_navclass = ($nvr_hasprevpost)? "positionleft" : '';
					echo '<div class="nav-next '.esc_attr($nvr_navclass).'"><a href="'.esc_url( get_permalink($nvr_nextpost->ID) ).'"><span class="navarrow fa fa-angle-right"></span><span class="navtext">'. esc_html__( 'Next Article', "constance" ) .'</span><br /><span class="prevnexttitle">'.get_the_title($nvr_nextpost->ID).'</span></a></div>';
                }
                ?>
                <div class="clearfix"></div>
            </div>
            <?php
            
            // If a user has filled out their description, show a bio on their entries.
            if ( get_the_author_meta( 'description' ) ) : ?>
            <div id="entry-author-info">
            	<h2 class="entry-author-title"><?php esc_html_e('About Author', "constance"); ?></h2>
                <div id="author-avatar">
                    <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'constance_author_bio_avatar_size',98 ) ); ?>
                </div><!-- author-avatar -->
                <div id="author-description">
                    <h2><span class="author"><?php the_author(); ?></span></h2>
                    <?php the_author_meta( 'description' ); ?>
                </div><!-- author-description	-->
            </div><!-- entry-author-info -->
            <?php endif; ?>
            <?php comments_template( '', true ); ?>
            
            <?php endwhile; ?>
        
        </div><!-- singlepost --> 
                   
<?php get_footer(); ?>