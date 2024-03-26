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
    	<?php
		if(!is_search()){
			$nvr_custom = get_post_custom($post->ID);
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
		}
		?>
        <div class="loopcontainer">
        	<h6 class="meta-format"><?php esc_html_e('Image', 'constance'); ?></h6>
            <h2 class="posttitle"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', "constance" ), the_title_attribute( 'echo=0' ) ); ?>" data-rel="bookmark"><?php the_title(); ?></a></h2>
            <div class="meta-date nvrsecondfont"><?php the_time('F d, Y') ?></div>
       		<div class="entry-content">
                <?php the_excerpt(); ?>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="entry-utility">
        	<div class="entry-icon fa fa-camera"></div>
            <div class="meta-sticky nvrsecondfont"><i class="fa fa-bookmark"></i> <span><?php esc_html_e('Sticky', "constance"); ?></span></div>
            <div class="meta-author nvrsecondfont"><?php esc_html_e("By", "constance"); ?> <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) );?>"><?php the_author();?></a></div>
            <div class="meta-cat nvrsecondfont"><?php esc_html_e("In", "constance"); ?> <?php the_category(', '); ?></div>
            
            <div class="meta-comment nvrsecondfont"><?php comments_popup_link( esc_html__('0 Comment', "constance"), esc_html__('1 Comment', "constance"), esc_html__('% Comments', "constance")); ?></div>
            <span class="clearfix"></span>
        </div>
		<div class="clearfix"></div>
        
	</article><!-- end post -->