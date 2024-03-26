<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Constance
 * @since Constance 1.0
 */
 
 global $post, $more;
 $more = 0;
?>

    <?php /* How to display all posts. */ ?>
	<article id="post-<?php the_ID(); ?>" <?php post_class("content-loop"); ?>>
    	
        <div class="loopcontainer">
    		<div class="entry-content">
                <?php 
				if(is_search()){
					the_excerpt();
				}else{
					the_content(); 
				}
				?>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="entry-utility">
        	<div class="entry-icon fa fa-pencil-square-o"></div>
            <div class="meta-sticky nvrsecondfont"><i class="fa fa-bookmark"></i> <span><?php esc_html_e('Sticky', "constance"); ?></span></div>
            <div class="meta-author nvrsecondfont"><?php esc_html_e("By", "constance"); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>"><?php the_author();?></a></div>
            <div class="meta-cat nvrsecondfont"><?php esc_html_e("In", "constance"); ?> <?php the_category(', '); ?></div>
            
            <div class="meta-comment nvrsecondfont"><?php comments_popup_link( esc_html__('0 Comment', "constance"), esc_html__('1 Comment', "constance"), esc_html__('% Comments', "constance")); ?></div>
            <span class="clearfix"></span>
        </div>
		<div class="clearfix"></div>
        
	</article><!-- end post -->