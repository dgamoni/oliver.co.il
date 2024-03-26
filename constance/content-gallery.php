<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Constance
 * @since Constance 1.0
 */
 
 global $post;
?>

    <?php /* How to display all posts. */ ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class("content-loop"); ?>>
    	<?php
		if(!is_search()){
			$nvr_custom = get_post_custom($post->ID);
			$nvr_post_content = get_the_content();
			preg_match('/\[gallery.*ids=.(.*).\]/', $nvr_post_content, $nvr_ids);
			
			if(is_array($nvr_ids) && count($nvr_ids)>1){
				$nvr_array_id = explode(",", $nvr_ids[1]);
				
				$nvr_content =  str_replace($nvr_ids[0], "", $nvr_post_content);
				$nvr_filtered_content = apply_filters( 'the_content', $nvr_content);
				
				$nvr_sliderli = '';
				foreach($nvr_array_id as $nvr_img_id){
					$nvr_sliderli .= '<li><a href="'. esc_url( get_permalink() ) .'">'. wp_get_attachment_image( $nvr_img_id, 'constance-blog-post-image' ) .'</a></li>';
				}
				
				if($nvr_sliderli!=''){
					echo '<div class="gallerycontainer"><div class="flexslider"><ul class="slides">'.$nvr_sliderli."</ul></div></div>";
				}
			}
		}
		?>
        <div class="loopcontainer">
        	<h6 class="meta-format"><?php esc_html_e('Gallery', 'constance'); ?></h6>
        	<h2 class="posttitle"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', "constance" ), the_title_attribute( 'echo=0' ) ); ?>" data-rel="bookmark"><?php the_title(); ?></a></h2>
            <div class="meta-date nvrsecondfont"><?php the_time('F d, Y') ?></div>
       		<div class="entry-content">
                <?php the_excerpt(); ?>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="entry-utility">
        	<div class="entry-icon fa fa-image"></div>
            <div class="meta-sticky nvrsecondfont"><i class="fa fa-bookmark"></i> <span><?php esc_html_e('Sticky', "constance"); ?></span></div>
            <div class="meta-author nvrsecondfont"><?php esc_html_e("By", "constance"); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>"><?php the_author();?></a></div>
            <div class="meta-cat nvrsecondfont"><?php esc_html_e("In", "constance"); ?> <?php the_category(', '); ?></div>
            
            <div class="meta-comment nvrsecondfont"><?php comments_popup_link( esc_html__('0 Comment', "constance"), esc_html__('1 Comment', "constance"), esc_html__('% Comments', "constance")); ?></div>
            <span class="clearfix"></span>
        </div>
		<div class="clearfix"></div>
        
	</article><!-- end post -->