<?php
/**
 *
 * @package WordPress
 * @subpackage Constance
 * @since Constance 1.0
 */

get_header(); ?>

		<?php
        
        $nvr_idnum = 0;
        $nvr_column = 3;
        $nvr_typecol = "nvr-pf-col-".$nvr_column;
        $nvr_imgsize = "portfolio-image";
		$nvr_pftype = 'classic';
        
        ?>
        
        <div class="nvr-pf-container row">
            <ul class="<?php echo esc_attr( $nvr_typecol.' '.$nvr_pftype ); ?>">
        
            <?php
            while ( have_posts() ) : the_post(); 
                    $nvr_idnum++;
                    
                    if($nvr_column=="2"){
                        $nvr_classpf = 'six columns ';
                    }elseif($nvr_column=="4"){
                        $nvr_classpf = 'three columns ';
                    }else{
                        $nvr_classpf = 'four columns ';
                    }

                    if(($nvr_idnum%$nvr_column) == 1){ $nvr_classpf .= "first ";}
                    if(($nvr_idnum%$nvr_column) == 0){$nvr_classpf .= "last ";}
                    
                    echo constance_pf_get_box( $nvr_imgsize, get_the_ID(), $nvr_classpf );
                        
                    $nvr_classpf=""; 
                        
            endwhile; // End the loop. Whew.
            ?>
            <li class="pf-clear"></li>
            </ul>
            <div class="clearfix"></div>
        </div><!-- end #nvr-portfolio -->
                  
        <?php /* Display navigation to next/previous pages when applicable */ ?>
        <?php if (  $wp_query->max_num_pages > 1 ) : ?>
		 <?php if(function_exists('wp_pagenavi') || true) { ?>
       		<div class="nvr-pagenavi">
				<?php
                echo paginate_links( apply_filters( 'constance_pf_pagination_args', array(
                    'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
                    'format'       => '',
                    'add_args'     => '',
                    'current'      => max( 1, get_query_var( 'paged' ) ),
                    'total'        => $wp_query->max_num_pages,
                    'prev_text'    => '&larr;',
                    'next_text'    => '&rarr;',
                    'type'         => 'list',
                    'end_size'     => 3,
                    'mid_size'     => 3
                ) ) );
                ?>
                <div class="clearfix"></div>
			</div>
         <?php }else{ ?>
            <div id="nav-below" class="navigation">
                    <div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span> '.esc_html__( 'Previous', "constance" ) ); ?></div>
                    <div class="nav-next"><?php previous_posts_link( esc_html__( 'Next', "constance" ).' <span class="meta-nav">&rarr;</span>' ); ?></div>
            </div><!-- #nav-below -->
        <?php }?>
        <?php endif; wp_reset_postdata();?>
        <div class="clearfix"></div><!-- clear float --> 
                
<?php get_footer(); ?>