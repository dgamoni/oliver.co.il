<?php
/**
 * Template Name: Portfolio
 *
 * A custom page template for portfolio page.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Constance
 * @since Constance 1.0
 */

get_header(); ?>

	<?php
   	$nvr_pid = constance_get_postid();
	$nvr_custom = constance_get_customdata($nvr_pid);
    $nvr_type = (isset($nvr_custom["p_type"][0]))? $nvr_custom["p_type"][0] : "";
	$nvr_contlayout = (isset($nvr_custom["p_container"][0]))? $nvr_custom["p_container"][0] : "";
    $nvr_cats = (isset($nvr_custom["p_categories"][0]))? $nvr_custom["p_categories"][0] : "";
    $nvr_showpost = (isset($nvr_custom["p_showpost"][0]))? $nvr_custom["p_showpost"][0] : "";
    $nvr_orderby = (isset($nvr_custom["p_orderby"][0]))? $nvr_custom["p_orderby"][0] : "date";
    $nvr_ordersort = (isset($nvr_custom["p_sort"][0]))? $nvr_custom["p_sort"][0] : "DESC";
	$nvr_loadmore = (isset($nvr_custom["p_loadmore"][0]))? $nvr_custom["p_loadmore"][0] : "";
    $nvr_categories = explode(",",$nvr_cats);

	if($nvr_type==""){
		$nvr_type = 'classic-3-space';
	}
	$nvr_arrtype = explode("-",$nvr_type);
	
	$nvr_ptype = $nvr_arrtype[0];
	$nvr_column = intval($nvr_arrtype[1]);
	$nvr_pspace = (isset($nvr_arrtype[2]))? $nvr_arrtype[2] : 'space';
	if($nvr_column==0){
		$nvr_freelayout = true;
	}else{
		$nvr_freelayout = false;
	}
    
    $nvr_approvedcats = array();
    foreach($nvr_categories as $nvr_category){
        $nvr_catname = get_term_by('slug',$nvr_category,"portfoliocat");
        if($nvr_catname!=false){
            $nvr_approvedcats[] = $nvr_catname;
        }
    }
    
    $nvr_catslugs = array();
    if(count($nvr_approvedcats)>1){
        echo '<ul id="filters" class="option-set clearfix " data-option-key="filter">';
            $nvr_filtersli = '';
            $nvr_numli = 1;
            foreach($nvr_approvedcats as $nvr_approvedcat){
                if($nvr_numli==1){
                    $nvr_liclass = 'omega';
                }else{
                    $nvr_liclass = '';
                }
                $nvr_filtersli = '<li class="'.esc_attr( $nvr_liclass ).'"><a href="#filter" data-option-value=".'.esc_attr( $nvr_approvedcat->slug ).'">'.$nvr_approvedcat->name.'</a></li>'.$nvr_filtersli;
                $nvr_catslugs[] = $nvr_approvedcat->slug;
                $nvr_numli++;
            }
            echo '<li class="alpha selected"><a href="#filter" data-option-value="*">'. esc_html__('All Categories', "constance" ).'</a></li>'.$nvr_filtersli;
        echo '</ul>';
		$nvr_hasfilter = true;
    }elseif(count($nvr_approvedcats)==1){
		$nvr_catslugs[] = $nvr_approvedcats[0]->slug;
		$nvr_hasfilter = false;
	}else{
		$nvr_hasfilter = false;
	}

    $nvr_idnum = 0;

    if($nvr_column!= 2 && $nvr_column!= 3 && $nvr_column!= 4 && $nvr_column!= 5 ){
        $nvr_column = 3;
    }
    $nvr_pfcontainercls = "nvr-pf-col-".$nvr_column;
	$nvr_pfcontainercls .= " ".$nvr_ptype;
	$nvr_pfcontainercls .= " ".$nvr_pspace;
	$nvr_pfcontainercls .= " ".$nvr_contlayout;
    $nvr_imgsize = "portfolio-image";
    
    if($nvr_showpost==""){$nvr_showpost="-1";}
    
    $nvr_argquery = array(
        'post_type' => 'portofolio',
        'orderby' => $nvr_orderby,
        'order' => $nvr_ordersort,
        'paged' => $paged
    );
	$nvr_argquery['showposts'] = $nvr_showpost;
    
    if(count($nvr_catslugs)>0){
        $nvr_argquery['tax_query'] = array(
            array(
                'taxonomy' => 'portfoliocat',
                'field' => 'slug',
                'terms' => $nvr_catslugs
            )
        );
    }
	
	$nvr_pfquery = new WP_Query($nvr_argquery);
    ?>
    <div class="nvr-pf-container row">
        <ul id="nvr-pf-filter" class="<?php echo esc_attr( $nvr_pfcontainercls ); ?>">
    
		<?php
		if( $nvr_pfquery->have_posts() ){
			while ( $nvr_pfquery->have_posts() ) : $nvr_pfquery->the_post(); 
					
					$nvr_idnum++;
					if(!$nvr_freelayout){
						if($nvr_column=="2"){
							$nvr_classpf = 'six columns ';
						}elseif($nvr_column=="4"){
							$nvr_classpf = 'three columns ';
						}elseif($nvr_column=="5"){
							$nvr_classpf = 'one_fifth columns ';
						}else{
							$nvr_classpf = 'four columns ';
						}
					}else{
						$nvr_classpf = 'free columns ';
					}
					
					if(($nvr_idnum%$nvr_column) == 1){ $nvr_classpf .= "first ";}
					if(($nvr_idnum%$nvr_column) == 0){$nvr_classpf .= "last ";}
					
					$nvr_custompf = get_post_custom( get_the_ID() );
					
					$nvr_pimgsize = '';
					if($nvr_ptype=='masonry'){
						$nvr_pimgsize = (isset($nvr_custompf["_nvr_pimgsize"][0]))? $nvr_custompf["_nvr_pimgsize"][0] : "";
						
						if($nvr_pimgsize=='square'){
							$nvr_imgsize = 'portfolio-image-square';
						}elseif($nvr_pimgsize=='portrait'){
							$nvr_imgsize = 'portfolio-image-portrait';
						}elseif($nvr_pimgsize=='landscape'){
							$nvr_imgsize = 'portfolio-image-landscape';
						}
						$nvr_classpf .= $nvr_pimgsize.' ';
					}elseif($nvr_ptype=='grid'){
						$nvr_imgsize = 'portfolio-image-square';
						$nvr_pimgsize='square';
					}
					$nvr_classpf .= 'imgsize-'.$nvr_pimgsize.' ';
					
					$nvr_thepfterms = get_the_terms( get_the_ID(), 'portfoliocat');
					
					$nvr_literms = "";
					if ( $nvr_thepfterms && ! is_wp_error( $nvr_thepfterms ) ){
		
						$nvr_approvedterms = array();
						foreach ( $nvr_thepfterms as $nvr_term ) {
							$nvr_approvedterms[] = $nvr_term->slug;
						}			
						$nvr_literms = implode( " ", $nvr_approvedterms );
					}
					
					echo constance_pf_get_box( $nvr_imgsize, get_the_ID(), $nvr_classpf.' element '.$nvr_literms );
						
					$nvr_classpf=""; 
						
			endwhile; // End the loop. Whew.
		}
        ?>
        <li class="pf-clear"></li>
        </ul>
        <div class="clearfix"></div>
    </div><!-- end #nvr-portfolio -->
    
    <?php
	$nvr_infscrolls = ( $nvr_loadmore )? true : false;
	if( $nvr_infscrolls ){
	?>
	<div id="loadmore-paging">
	<div class="loadmorebutton"><?php next_posts_link( '<i class="fa fa-camera"></i>&nbsp; '.esc_html__( 'Load More', "constance" ), $nvr_pfquery->max_num_pages ); ?></div>
	</div>
	<?php
	}
	?>
              
    <?php /* Display navigation to next/previous pages when applicable */ ?>
    <?php if (  $nvr_pfquery->max_num_pages > 1 && !$nvr_infscrolls ) : ?>
     <?php if(function_exists('wp_pagenavi') || true ) { ?>
		<div class="nvr-pagenavi">
			<?php
            echo paginate_links( apply_filters( 'constance_pf_pagination_args', array(
                'base'         => esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) ),
                'format'       => '',
                'add_args'     => '',
                'current'      => max( 1, get_query_var( 'paged' ) ),
                'total'        => $nvr_pfquery->max_num_pages,
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
                <div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span> '.esc_html__( 'Previous', "constance" ), $nvr_pfquery->max_num_pages ); ?></div>
                <div class="nav-next"><?php previous_posts_link( esc_html__( 'Next', "constance" ).' <span class="meta-nav">&rarr;</span>', $nvr_pfquery->max_num_pages ); ?></div>
        </div><!-- #nav-below -->
    <?php }?>
    <?php endif; wp_reset_postdata();?>
            
    <div class="clearfix"></div><!-- clear float -->
                
<?php get_footer(); ?>