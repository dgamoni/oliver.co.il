<?php
/**
 * The Header for our theme.
 *
 *
 * @package WordPress
 * @subpackage Constance
 * @since Constance 1.0
 */
?><!DOCTYPE html>
<!--[if IE 6]>
<html id="ie6" <?php language_attributes(); ?> class="no-js">
<![endif]-->
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?> class="no-js">
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?> class="no-js">
<![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php 
/* We add some JavaScript to pages with the comment form
 * to support sites with threaded comments (when in use).
 */
if ( is_singular() && get_option( 'thread_comments' ) )
	wp_enqueue_script( 'comment-reply' );

/* Always have wp_head() just before the closing </head>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to add elements to <head> such
 * as styles, scripts, and meta tags.
 */

wp_head(); /* the novaro' custom content for wp_head is in includes/header-functions.php */ ?>
</head><?php 
	
	$nvr_pid = constance_get_postid();
	$nvr_custom = constance_get_customdata($nvr_pid);
	$nvr_header_values = constance_head_values($nvr_custom);
	extract($nvr_header_values);
	
?>
<body <?php body_class($nvr_bodyclass); ?>>


<div id="subbody">
	<div id="outercontainer">
    	
        <div id="headertext">
            <div class="container">
                <a href="#" id="closesidemenu"></a>
                <div class="row">
                	<div class="twelve columns">
						<?php 
                        /***** file : engine/header-functions.php
                        - constance_output_socialicon - 5
                        - constance_output_wpmlselector - 20
                        - constance_secondary_menu - 40
                        -
                        *****/
                        do_action('constance_output_toparea');
                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- HEADER -->
        <header id="outertop">
        	<?php
			if($nvr_issliderdisplayed && $nvr_cf_siteLayout=='nvrlayout6'){
            	get_template_part( 'slider');
            }

            $headerpath = 'headers/header-'.$nvr_cf_siteLayout;
            get_template_part( $headerpath ); 
           
            if($nvr_issliderdisplayed && $nvr_cf_siteLayout!='nvrlayout6'){
            	get_template_part( 'slider');
            }
			
			if(!$nvr_issliderdisplayed && $nvr_istitledisplayed) {
            ?>
            <!-- AFTER HEADER -->
            <div id="outerafterheader">
                <div class="container">
                    <div id="afterheader" class="row">
                        <section id="pagetitlecontainer" class=" twelve columns">
                            <?php
                            get_template_part( 'title');
                            
							$nvr_pagedesc = (isset($nvr_custom['_nvr_pagedesc'][0]) && $nvr_custom['_nvr_pagedesc'][0]!="")? $nvr_custom['_nvr_pagedesc'][0] : "";
							if(is_tax()){
								if( term_description()!='' ){
									echo '<div class="pagedesc nvrsecondfont">'.term_description().'</div>';
								}
							}else{
								if($nvr_pagedesc){
									echo '<span class="pagedesc nvrsecondfont">'.esc_html( $nvr_pagedesc ).'</span>';
								}
							}
							
							
                            ?>
                        </section>
                        <?php if($nvr_showbc){ ?>
                        <div id="breadcrumbcontainer" class="twelve columns"><?php constance_breadcrumb(); ?></div>
                        <?php } ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- END AFTER HEADER -->
            <?php 
            }/* end if( !$nvr_issliderdisplayed ) */ 
            ?>
		</header>
        <!-- END HEADER -->
        
        <!-- MIDDLE -->
        <div id="outermiddle">
        <!-- SECTION BUILDER BEFORE CONTENT -->
		<?php 
		$nvr_sectionbuilderb = array();
		if(isset( $nvr_custom['_nvr_sectionbuilder_before'][0] )){
			$nvr_sectionbuilderb = unserialize($nvr_custom['_nvr_sectionbuilder_before'][0]);
		}
		
        constance_section_builder($nvr_sectionbuilderb);
        ?>
        <!-- END SECTION BUILDER BEFORE CONTENT -->
        
        <?php
		
		$nvr_pagelayout = constance_get_sidebar_position($nvr_pid);
		$numcol = 1;
		
		if(constance_is_shop() || constance_is_product()){
			$nvr_pagelayout = 'one-col';
		}
		
		if($nvr_pagelayout!='one-col'){
			if($nvr_pagelayout=="two-col-left"){
				$numcol = 2;
			}elseif($nvr_pagelayout=="two-col-right"){
				$numcol = 2;
			}
			$nvr_mcontentclass = "hassidebar ".$nvr_pagelayout;
		}else{
			$numcol = 1;
			$nvr_mcontentclass = "twelve columns nosidebar";
		}
		?>
        <!-- MAIN CONTENT -->
        <div id="outermain">
        	<div id="main-gradienttop">
        	<div class="container">
            	<div class="row">
                
                <section id="maincontent" class="<?php echo esc_attr( $nvr_mcontentclass ); ?>">
                
                <?php if($nvr_pagelayout!='one-col'){ ?>
                        
                    <section id="content" class="nine columns">
                        <div class="main">
                
                <?php } ?>
                	